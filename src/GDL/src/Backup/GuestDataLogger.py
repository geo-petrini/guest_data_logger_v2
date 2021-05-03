import cv2 as cv
import math
import argparse
import os 
import time
import datetime
from datetime import timedelta
import tkinter as tk
from tkinter import *
from PIL import Image, ImageTk
import json
import requests
import threading as thread
import multiprocessing
from queue import Queue
import sys
import keyboard
import logging

""" 
 Inizializzazione del file di log.
"""
logging.basicConfig(filename='info.log', level=logging.DEBUG)

""" 
 Lettura del file di configurazione.
"""
with open('Config.json', 'r') as conf:
    data=conf.read()

config = json.loads(data)

""" 
 Verifica e salvataggio del proxy se presente.
"""
proxies = {}
if 'http' in config and config['http'] and len(config['http'])>0:
    proxies['http']=config['http']

if 'https' in config and config['https'] and len(config['https'])>0:
    proxies['https']=config['https']


""" 
Questa classe è utile a inviare i dati raccolti dalla webcam 
al server prendendoli dalla coda.
"""
class SenderData (thread.Thread):

    """ 
     Inizializza le variabili della classe.
    """
    def __init__(self, q, api_key, ex):
        thread.Thread.__init__(self)
        self._stopevent = thread.Event()
        self.q = q
        self.api_key = api_key
        self.ex = ex
    
    """
     Viene eseguito allo start della thread e manda i dati al server ogni 10 secondi.
    """
    def run(self):
        timeN = datetime.datetime.now()
        timeF = datetime.datetime.now()
        timeF += timedelta(seconds=10)
        while self.checkEx():
            if timeN < timeF:
                self.send_data()
                timeF = datetime.datetime.now()
                timeF += timedelta(seconds=10)
        timeF = datetime.datetime.now()
        return

    """
     Verifica la coda dedicata all'uscita dell'applicativo.
    """
    def checkEx(self):
        try:
            if(self.ex.get(False)['exit']):
                logging.info("exit now")
                return False
            else:
                self.ex.put({'exit': False})
                return True
        except Exception as e:
            pass

    
    """
     Inserisce i dati catturati dalla webcam all'interno di un Json 
     che verrà spedito al server in seguito.
    """
    def dataToJSON(self):
        v = self.q.get(True, 11)
        myJson = {
            "data":v["time"],
            "num_persone": v["count"],
            "api_key":self.api_key
            }
        return myJson

    """
     Spedisce al sito il Json contenente i dati raccolti dalla webcam.
    """
    def send_data(self):
        url = str(config['site_sender'])
        req = requests.post(url, json= self.dataToJSON(), proxies=proxies)
        s = req.text
        logging.info(f'request text; {s}')


"""
 Questa classe gestisce il frame di login e le varie interazioni con esso.
"""
class StartWindow():
    
    """
     Inizializza le variabili e i componenti della classe.
    """
    def __init__(self, q):
        self.q = q
        self.webcamport = 0
        self._build_frame()
        self.main_frame.protocol("WM_DELETE_WINDOW", self.on_closing)
        self._build_logo()
        self._build_help()
        self._build_key_input()
        self._build_option_menu()
        self._build_button()
        self.main_frame.mainloop() 

    """
     Istanzia il frame che verrà visualizzato a schermo.
    """
    def _build_frame(self):
        self.main_frame = Tk()
        self.main_frame.geometry("280x380")
        self.main_frame.configure(background='white')
        self.main_frame.wm_title("Face recognition")
        self.main_frame.resizable(width=False, height=False)

    """
     Istanzia il bottone di invio.
    """
    def _build_button(self):
        btn = Button(self.main_frame, text ="Start", width=20,command=self.buttonPressed)
        btn.place(x=60,y=320)
    
    
    """
     Istanzia il menu di selezione per le webcam.
    """
    def _build_option_menu(self):
        variable = tk.StringVar(self.main_frame)
        optionList = self.returnCameraIndexes()
        variable.set("Seleziona la webcam")
        opt = tk.OptionMenu(self.main_frame, variable, *optionList)
        opt.config(width=23, font=('Helvetica', 10))
        opt.pack()
        opt.place(x=30,y=180)
        def callback(*args):
            if variable.get() != "None":
                self.webcamport = int(variable.get())
        variable.trace("w", callback)

    """
     Istanzia e carica il logo.
    """
    def _build_logo(self):
        load = Image.open("n.png")
        render = ImageTk.PhotoImage(load)
        img = Label(self.main_frame, image=render)
        img.image = render
        img.place(x=0,y=0)

    """
     Istanzia il label che suggerisce di inserire la chiave.
    """
    def _build_help(self):
        L0 = Label(self.main_frame,text="Insert your API Key:")
        L0.config(font=("Courier",8))
        L0.place(x=30,y=90)

    """
     Utile a gestire la chiusura dell'applicativo.
    """
    def on_closing(self):
        sys.exit()

    
    """
     Istanzia il text box nel quale va inserita la chiave.
    """
    def _build_key_input(self):
        l1 = Label(self.main_frame, text="Key")
        l1.place(x=30,y=120)
        self.e1 = Entry(self.main_frame, bd=5)
        self.e1.place(x=100,y=120)
        if "api_key" in config:
            key = str(config["api_key"])        
            self.e1.insert(0,key)


    """
     Testa la connesione con il server, il server risponde con l'http code numero 200
     se l'api key inviata è corretta.
    """
    def testConnection(self, api_key):
        response = None
        url = str(config['key_checker'])
        myJson = {
                "api_key":api_key
                }
        try:
            if 'http' in proxies or 'https' in proxies:
                response = requests.post(url, json=myJson, proxies=proxies, timeout=5)
            else:
                response = requests.post(url, json=myJson, timeout=5)
            
            logging.info(response.status_code)

        except requests.Timeout:
            logging.exception("Connection error!")
            return False, "Connection error"

        if response and response.status_code and response.status_code == 200: 
            return True
        else:
            return False
        

    """
     Gestisce il click sul bottone start. 
     Quando viene eseguito fa un test della connessione e se va a buon fine 
     "distrugge" la schermata di login e avvia l'applicativo principale.
    """
    def buttonPressed(self):
        api_key = self.e1.get()
        webcam_port = None
        cameraIndex = self.returnCameraIndexes()
        L4 = Label()
        if L4.winfo_exists():
            L4.destroy()
        if len(api_key) == 0:
            L4 = Label(self.main_frame, text="Not valid, try again.")
            L4.config(fg="red")
            L4.place(x=30,y=350)        
        else:
            if  cameraIndex != ["None"]:
                connect = self.testConnection(api_key)
                if self.testConnection(api_key) is True:
                    toSave ={
                        "site_sender": str(config['site_sender']),
                        "key_checker": str(config["key_checker"]),
                        "http": str(config['http']),
                        "https": str(config['https']),
                        "api_key": api_key
                    }
                    json_object = json.dumps(toSave, indent = 5)
                    with open("Config.json", "w") as outfile:
                        outfile.write(json_object)
                    logging.info("entered")
                    self.q.put( {'api_key':api_key, 'webcam_port':self.webcamport} )
                    self.main_frame.destroy()
                else:
                    if connect[1] == "Connection error":
                        L4 = Label(self.main_frame, text="Connection error")
                    else:
                        L4 = Label(self.main_frame, text="API Key invalid, try again.")
                    L4.config(fg="red")
                    L4.place(x=30,y=350)
            elif cameraIndex == ["None"]:
                L4 = Label(self.main_frame, text="Nessuna webcam rilevata!")
                L4.config(fg="red")
                L4.place(x=30,y=350)

    """
     Rileva le webcam disponibili e inserisce il loro indice all'interno di un array.
    """
    def returnCameraIndexes(self):
        index = 0
        freeIndexes = []
        while index < 255:
            video = cv.VideoCapture(index, cv.CAP_DSHOW)
            if video.isOpened():
                freeIndexes.append(index)
                index += 1
            else:
                index += 1
            video.release()
        if len(freeIndexes) < 1:
            return ["None"]
        return freeIndexes


"""
 Questa classe gestisce il conteggio delle facce e l'aggiornamento dei dati
 raccolti dalla webcam, ovviamente si occupa anche di aggiornare il frame e 
 mostrare l'interfaccia a schermo tramite Tkinter.
"""
class Capture(thread.Thread):

    """
     Inizializza le variabili e i componenti di classe.
    """
    def __init__(self, q, frames_queue, camera_port):
        thread.Thread.__init__(self)
        self.camera_port = camera_port
        self.q = q
        self.frames_queue = frames_queue
        self.faceProto = "opencv_face_detector.pbtxt"
        self.faceModel = "opencv_face_detector_uint8.pb"        
        self.runstate = True
        # Load network
        self.faceNet = cv.dnn.readNet(self.faceModel, self.faceProto)
    
    """
     Rileva le facce e aggiorna il contatore. Ritorna i dati raccolti dalla cam.
    """
    def detectFaces(self, cap):
        frameFace = None
        count = 0
        error = None
        #prende il frame attuale della camera.
        hasFrame, frame = cap.read()
        if not hasFrame:    #se non individua frame, esce
            cv.waitKey()
        else:

            #ridimensione del frame del 200% con il metodo apposito.
            

            #prende il numero di box/cornici create. Se non viene trovata nessuna, continua.
            frameFace, bboxes = self.getFaceBox(self.faceNet, frame) 

            #conteggio dei volti presenti nel frame.
            count = len(bboxes)
            '''for face in bboxes:
                count+=1'''
            
        return {'frame':frameFace, 'count':count, 'error':error}
        

    """
     Questo metodo riconosce le facce all'interno di un frame e 
     le incornicia con un contorno blu.
    """
    def getFaceBox(self, net, frame, conf_threshold=0.7):
        frameOpencvDnn = frame.copy()
        frameHeight = frameOpencvDnn.shape[0]
        frameWidth = frameOpencvDnn.shape[1]
        blob = cv.dnn.blobFromImage(frameOpencvDnn, 1.0, (300, 300), [104, 117, 123], True, False)
        net.setInput(blob)
        detections = net.forward()
        bboxes = []
        for i in range(detections.shape[2]):
            confidence = detections[0, 0, i, 2]
            if confidence > conf_threshold:
                x1 = int(detections[0, 0, i, 3] * frameWidth)
                y1 = int(detections[0, 0, i, 4] * frameHeight)
                x2 = int(detections[0, 0, i, 5] * frameWidth)
                y2 = int(detections[0, 0, i, 6] * frameHeight)
                bboxes.append([x1, y1, x2, y2])
                cv.rectangle(frameOpencvDnn, (x1, y1), (x2, y2), (255, 0, 0), int(round(frameHeight/150)), 8)
        return frameOpencvDnn, bboxes

    

    """
     Permette di sopprimere la thread.
    """
    def halt(self):
        logging.debug('stop thread')
        self.runstate = False

    """
     Viene eseguito allo start della thread e si occupa di mostrare il frame a schermo,
     catturare i dati dalla cam e ogni 10 secondi spedirli e aggiornarli.
    """
    def run(self):
        logging.info("camera start")
        #cattura dello schermo
        cap = cv.VideoCapture(self.camera_port, cv.CAP_DSHOW)
        padding = 20
        last_face_number = None
        count = 0

        timeN = datetime.datetime.now() #current time
        timeF = datetime.datetime.now() + timedelta(seconds=10) #time to send data
        while cv.waitKey(1) < 0 and self.runstate:

            face_number = 0 
            detected = self.detectFaces(cap)

            if detected:
                #conteggio totale delle persone.

                if last_face_number:
                    if last_face_number < detected['count']:
                        last_face_number = detected['count']
                        count += 1
                else:
                    last_face_number = detected['count']
                    count = detected['count']            
           
            if not detected['error']:
                self.frames_queue.put( detected )             
            timeN = datetime.datetime.now()

            if timeN >= timeF:
                self.q.put( {'time':timeN.strftime('%Y-%m-%d %H:%M:%S'), 'count':count} )
                #azzeremento del last_face_number
                last_face_number = None
                # #azzeramento count
                count = 0
                timeF = datetime.datetime.now() + timedelta(seconds=10)
        
        cv.destroyAllWindows()
        logging.info('end while - exiting webcam procedure')


"""
 Questa classe si occupa della gestione dell'interfaccia dell'applicazione.
"""
class CameraWindow():

    """
     Istanzia le variabili e i componenti della classe.
    """
    def __init__(self, ex=None, frames_queue=None):
        self.frames_queue = frames_queue
        self.ex = ex
        self.faceProto = "opencv_face_detector.pbtxt"
        self.faceModel = "opencv_face_detector_uint8.pb"
        self._build_frame()
        self._build_label()
        self.stop_event = thread.Event()
        self.rth = None
           

    """
     Istanzia e definisce il frame.
    """    
    def _build_frame(self):
        #Definisce nuovo frame.
        self.top = Tk()
        #setta le dimensioni del frame.
        self.top.geometry("1290x700")
        #setta il background bianco.
        self.top.configure(background='white')
        #aggiunge il titolo al frame.
        self.top.wm_title("GuestDataLoggerv2")
        #setta a non ridimensionabile il frame.
        self.top.protocol("WM_DELETE_WINDOW", self.on_close )

    """
     Istanzia e definisce il label del conteggio che apparirà a schermo.
    """
    def _build_label(self):
        self.label = tk.Label(self.top)
        self.label.pack()
        self.labelInfo = tk.Label(self.top, text="Conteggio: 0", font=('Helvetica', 12), fg='blue')
        self.labelInfo.pack()
        self.label.place(x=0,y=25)
        self.labelInfo.place(x=0,y=0)
    
    """
     Esegue un resizing del frame in base alla percentuale passata.
    """
    def rescale_frame(self, frame):
        self.top.update()
        frameWidth = self.top.winfo_width()
        frameHeight = self.top.winfo_height()
        width = int(frame.size[0])
        height = int(frame.size[1])
        multiplierWidth = frameWidth / width
        multiplierHeight = frameHeight / height
        #larghezza minore di altezza
        if multiplierWidth < multiplierHeight:
            dim = (int(width*multiplierWidth), int(height*multiplierWidth))
            self.label.place()
        #altezza minore di larghezza
        else:
            dim = (int(width*multiplierHeight), int(height*multiplierHeight))
        self.label.place(relx = 0.5,
                        rely = 0.5,
                        anchor = 'center')
        return frame.resize(dim)

    """
     Aggiorna il frame con le immagini catturate dalla webcam.
    """
    def update_picture(self, frame, resize=True):
        image = Image.fromarray(frame)
        if resize:
            try:
                image = self.rescale_frame(image)
                
            except:
                logging.exception('error scaling frame')
                error = True
            #finalFrame = resize  
        finalFrame =  ImageTk.PhotoImage(image) 
        self.label.configure(image = finalFrame)   
        self.label.image = finalFrame

    """
     Aggiorna il contatore delle facce.
    """
    def update_counter(self, count):
        if(count > 1 or count == 0):
            self.labelInfo.configure(text = "Conteggio: " + str(count) + " persone")
        else:
            self.labelInfo.configure(text = "Conteggio: " + str(count) + " persona")

    """
     Gestisce la chiusura del frame, quindi l'uscita dall'applicativo.
    """
    def on_close(self):
        self.ex.put({'exit':True})

        time.sleep(1)
        self.top.destroy()

    """
     Si occupa di aggiornare il frame e il contatore.
    """
    def _refresh(self, data_queue, stop_event):
        logging.info('frame refresh started')
        exit_event = False
        while not exit_event:
            data = None
            #prende la grandezza della queue
            s = data_queue.qsize()
            if s > 0:
                #cicla per ogni frame prendendo sempre l'ultimo frame
                for i in range(s):
                    try:
                        data = data_queue.get(False)    #get non blocking
                    except Exception as e:
                        data = None   #capture exception in case of Empty get from queue
            if data:
                try:
                    self.update_picture(cv.cvtColor(data['frame'], cv.COLOR_BGR2RGB))
                except Exception as e:
                    logging.exception('error updating frame')
                try:
                    self.update_counter(data['count'])
                except Exception as e:
                    logging.exception('error updating count')
            exit_event=stop_event.is_set()
        logging.debug('frame refresh ended')

    """
     Viene eseguito allo start della thread e si occupa di aggiornare la coda, 
     il frame e il conteggio.
    """
    def run(self):
        logging.debug("starting frames refresh thread")
        self.rth = thread.Thread(target=self._refresh, args=[self.frames_queue, self.stop_event])
        self.rth.daemon = True
        self.rth.start()
        logging.debug("starting tk mainloop")
        self.top.mainloop()

"""
 Metodo main per l'esecuzione del programma.
"""
if __name__ == '__main__':
    
    ex = Queue()
    ex.put({'exit':False})
    sender_queue =  Queue()
    sw = StartWindow(sender_queue) #si chiude da sola
    
    sw_return_val = sender_queue.get()
    logging.debug(sw_return_val)
    api_key = sw_return_val["api_key"]
    webcam_port = sw_return_val["webcam_port"]
    
    sd = SenderData(sender_queue, api_key, ex)
    sd.daemon = True
    sd.start()

    frames_queue = Queue()
    cap = Capture(sender_queue, frames_queue, webcam_port)
    cap.start()

    cw = CameraWindow(frames_queue=frames_queue, ex=ex)
    cw.run()    #code stops here as tk mainloop is started

    cap.runstate = False
    cw = None
    
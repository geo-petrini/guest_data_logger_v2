
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

proxies = {
 'http': 'http://10.20.4.118:8888',
 'https': 'http://10.20.4.118:8888'
}

class SenderData (thread.Thread):
    def __init__(self, q, api_key, ex):
        thread.Thread.__init__(self)
        self._stopevent = thread.Event()
        self.q = q
        self.api_key = api_key
        self.ex = ex
    
    def run(self):
        timeN = datetime.datetime.now()
        timeF = datetime.datetime.now()
        timeF += timedelta(seconds=10)
        condizione = self.checkEx()
        while condizione:
            if timeN < timeF:
                self.send_data()
                timeF = datetime.datetime.now()
                timeF += timedelta(seconds=10)
            condizione = self.checkEx()
        timeF = datetime.datetime.now()
        print("Fuori dal run")
        return
    
    def join (self, timeout = None):
        self._stopevent.set()

    def checkEx(self):
        try:
            if(self.ex.get(False)['exit']):
                print("exit now")
                return False
            else:
                print("FALSE exit")
                self.ex.put({'exit': False})
                return True
        except Exception as e:
            pass

    
    #Permette l'aggiunta di dati al database
    #@param date Data corrente nel formato mm-dd-YY
    #@param hours Ora attuale.
    #@param minutes Minuti attuali.
    #@param secs Secondi attuali.
    def dataToJSON(self):
        v = self.q.get(True, 11)
        print(v)
        myJson = {
            "data":v["time"],
            "num_persone": v["count"],
            "api_key":self.api_key
            }
        print(myJson)
        return myJson

    #-----------------------------------------------------------------------------   

    #-----------------------------------------------------------------------------  

    #bisogna fare il controllo se la chiave inserita sia veritiera

    #verifica se i dati utente inseriti sono validi, per farlo utilizza un try & catch
    # che verifica se l'host o l'utente inserito esistano.
    #@param host Host da testare.
    #@param user User da testare.
    #@param password Password dell'utente da testare.

    def send_data(self):
        url = 'http://samtinfo.ch/gdl/scripts/insertStat.php'
        req = requests.post(url, json= self.dataToJSON(), proxies=proxies)
        s = req.text
        print(f'request text; {s}')

#----------------------------------------------------------------------------------------

class StartWindow():
    
    # Inizializza il frame di login, istanziando tutti gli oggetti utili.
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
    #-------------------------------- Menu Frame in Tkinter ---------------------------------------

    #/////////////////// Istanzia il frame /////////////////
    def _build_frame(self):
        #Quando viene partito.
        #Definisce nuovo frame.
        self.main_frame = Tk()
        #setta le dimensioni del frame.
        self.main_frame.geometry("280x380")
        #setta il background bianco.
        self.main_frame.configure(background='white')
        #aggiunge il titolo al frame.
        self.main_frame.wm_title("Face recognition")
        #setta a non ridimensionabile il frame.
        self.main_frame.resizable(width=False, height=False)

    #/////////////////// Istanzia il bottone di invio /////////////////
    def _build_button(self):
        btn = Button(self.main_frame, text ="Start", width=20,command=self.buttonPressed)
        btn.place(x=60,y=320)
    
    #//////////////// Istanzia l'option menu /////////////////////
    def _build_option_menu(self):
        variable = tk.StringVar(self.main_frame)
        optionList = self.returnCameraIndexes()
        variable.set("Seleziona la webcam")
        opt = tk.OptionMenu(self.main_frame, variable, *optionList)
        opt.config(width=23, font=('Helvetica', 10))
        opt.pack()
        opt.place(x=30,y=180)

        #Estrapola il valore selezionato
        labelTest = tk.Label(text="", font=('Helvetica', 12), fg='blue')
        labelTest.pack()
        labelTest.place(x=30,y=220)
        def callback(*args):
            labelTest.configure(text="The selected item is {}".format(variable.get()))
            self.webcamport = int(variable.get())
        variable.trace("w", callback)
        

    #//////////////// Istanzia e carica il logo /////////////////////
    def _build_logo(self):
        load = Image.open("n.png")
        render = ImageTk.PhotoImage(load)
        img = Label(self.main_frame, image=render)
        img.image = render
        img.place(x=0,y=0)

    #///////////// Istanzia l'help label //////////////////
    def _build_help(self):
        L0 = Label(self.main_frame,text="Insert your API Key:")
        L0.config(font=("Courier",8))
        L0.place(x=30,y=90)

    #////////////////////////////////////////////////////
    def on_closing(self):
        sys.exit()

    #////////// Istanzia la key entry ///////////
    def _build_key_input(self):
        l1 = Label(self.main_frame, text="Key")
        l1.place(x=30,y=120)
        self.e1 = Entry(self.main_frame, bd=5)
        self.e1.place(x=100,y=120)

    

    #/////////////////// Testa la connessione con il server ////////////////////////
    def testConnection(self, api_key):
        
        url = 'http://samtinfo.ch/gdl/scripts/checkKey.php'
        myJson = {
                "api_key":api_key
                }
        response = requests.post(url, json=myJson, proxies=proxies)
        print(response.status_code)
        if response.status_code == 386: 
            return True
        else:
            return False

    #In caso venga premuto il tasto start, verifica
    #che i campi non siano vuoti e che i dati inseriti
    #siano validi tramite apposito metodo, se queste
    #condizioni non sono soddisfatte, stampa un label rosso con l'errore.
    def buttonPressed(self):
        api_key = self.e1.get()
        webcam_port = None
        L4 = Label()

        if L4.winfo_exists():
            L4.destroy()

        if len(api_key) == 0:
            L4 = Label(self.main_frame, text="Not valid, try again.")
            L4.config(fg="red")
            L4.place(x=30,y=350)  
            
        else:
            if self.returnCameraIndexes() != ["None"]:
                if self.testConnection(api_key) is True:
                    print("entered")
                    self.q.put( {'api_key':api_key, 'webcam_port':self.webcamport} )
                    self.main_frame.destroy()
                else:
                    L4 = Label(self.main_frame, text="API Key invalid, try again.")
                    L4.config(fg="red")
                    L4.place(x=30,y=350)
            else:
                L4 = Label(self.main_frame, text="Nessuna webcam rilevata!")
                L4.config(fg="red")
                L4.place(x=30,y=350)

    # Metodo per rilevare l'indice delle webcam disponibili
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

class Capture(thread.Thread):

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
            try:
                frame = self.rescale_frame(frame,percent=200)
            except:
                logging.exception('error scaling frame')
                error = True

            #prende il numero di box/cornici create. Se non viene trovata nessuna, continua.
            frameFace, bboxes = self.getFaceBox(self.faceNet, frame) 

            #conteggio dei volti presenti nel frame.
            for face in bboxes:
                count+=1
            
        print(f'count current detected faces: {count}')
        return {'frame':frameFace, 'count':count, 'error':error}
        

#------------------------------ Scansione volti ------------------------------    

    #Genera  i box/cornici attorno ad ogni volto trovato per frame.
    #@Param frame Frame attuale.
    #@Param net Network.
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

    #------------------------------Resize del frame-------------------------------

    #esegue un resizing del frame in base alla percentuale passata.
    #@param frame Frame da ridimensionare.
    #@param percent Percentuale di ridimensionamento.
    def rescale_frame(self, frame, percent=75):
        width = int(frame.shape[1] * percent/ 100)
        height = int(frame.shape[0] * percent/ 100)
        dim = (width, height)
        return cv.resize(frame, dim, interpolation =cv.INTER_AREA)   

    def halt(self):
        logging.debug('stop thread')
        self.runstate = False

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
                logging.debug("adding data to frames queue")
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
        print('end while - exiting webcam procedure')



class CameraWindowN():
    def __init__(self, ex=None, frames_queue=None):
        self.frames_queue = frames_queue
        self.ex = ex
        self.faceProto = "opencv_face_detector.pbtxt"
        self.faceModel = "opencv_face_detector_uint8.pb"
        self._build_frame()
        self._build_label()
        self.stop_event = thread.Event()
        self.rth = None
           

    # Istanzia il frame che conterrà l'immagine della webcam
    def _build_frame(self):
        #Definisce nuovo frame.
        self.top = Tk()
        #setta le dimensioni del frame.
        self.top.geometry("1290x700")
        #setta il background bianco.
        self.top.configure(background='white')
        #aggiunge il titolo al frame.
        self.top.wm_title("Guest Data Logger v2")
        #setta a non ridimensionabile il frame.        
        self.top.resizable(width=False, height=False)
        self.top.protocol("WM_DELETE_WINDOW", self.on_close )
        self.top.bind('<Escape>', self.on_close )

    def _build_label(self):
        self.label = tk.Label(self.top, height=675, width=1290)
        self.label.pack()
        self.labelInfo = tk.Label(self.top, text="Conteggio: 0", font=('Helvetica', 12), fg='blue')
        self.labelInfo.pack()
        self.label.place(x=0,y=25)
        self.labelInfo.place(x=0,y=0)

    def update_picture(self, frame):
        image = Image.fromarray(frame)
        finalFrame =  ImageTk.PhotoImage(image)           
        self.label.configure(image = finalFrame)   
        self.label.image = finalFrame

    def update_counter(self, count):
        if(count > 1 or count == 0):
            self.labelInfo.configure(text = "Conteggio: " + str(count) + " persone")
        else:
            self.labelInfo.configure(text = "Conteggio: " + str(count) + " persona")

    def on_close(self):
        self.ex.put({'exit':True})

        self.stop_event.set()
        print(f'stop event: {self.stop_event.is_set()}')
        time.sleep(1)
        self.top.destroy()

    def _refresh(self, data_queue, stop_event):
        logging.debug('frame refresh started')
        exit_event = False
        while not exit_event:
            try:
                data = data_queue.get(False)    #get non blocking
            except Exception as e:
                data = None   #capture exception in case of Empty get from queue
            #logging.debug(f'data_queue value: {data}')
            if data:
                #logging.debug('refreshing data')
                try:
                    self.update_picture(data['frame'])
                except Exception as e:
                    logging.exception('error updating frame')

                try:
                    self.update_counter(data['count'])
                except Exception as e:
                    logging.exception('error updating count')    

            exit_event=stop_event.is_set()

        logging.debug('frame refresh ended')
        print('frame refresh ended')

    def run(self):
        logging.debug("starting frames refresh thread")
        self.rth = thread.Thread(target=self._refresh, args=[self.frames_queue, self.stop_event])
        self.rth.daemon = True
        self.rth.start()
        logging.debug("starting tk mainloop")
        self.top.mainloop() 

class CameraWindow(thread.Thread):
    
    def __init__(self, q, webcam_port=0, ex=None):
        thread.Thread.__init__(self)
        self.q = q
        self.ex = ex
        self.runstate = True
        self.capture = webcam_port
        self.faceProto = "opencv_face_detector.pbtxt"
        self.faceModel = "opencv_face_detector_uint8.pb"
        self._build_frame()
        self._build_label()
        self.top.mainloop()
    
    # Istanzia il frame che conterrà la webcam
    def _build_frame(self):
        #Definisce nuovo frame.
        self.top = Tk()
        #setta le dimensioni del frame.
        self.top.geometry("1290x700")
        #setta il background bianco.
        self.top.configure(background='white')
        #aggiunge il titolo al frame.
        self.top.wm_title("Guest Data Logger v2")
        #setta a non ridimensionabile il frame.        
        self.top.resizable(width=False, height=False)
        self.top.protocol("WM_DELETE_WINDOW", self.on_closing)

    def on_closing(self):
        self.ex.put({'exit':True})
        self.runstate = False
        print(f'setting runstate = {self.runstate}')

    def _build_label(self):
        self.label = tk.Label(self.top, height=675, width=1290)
        self.label.pack()
        self.labelInfo = tk.Label(self.top, text="Conteggio: 0", font=('Helvetica', 12), fg='blue')
        self.labelInfo.pack()
        self.label.place(x=0,y=25)
        self.labelInfo.place(x=0,y=0)

    def update_picture(self, frame):
        image = Image.fromarray(frame)
        finalFrame =  ImageTk.PhotoImage(image)           
        self.label.configure(image = finalFrame)   
        self.label.image = finalFrame

    def update_counter(self, count):
        if(count > 1 or count == 0):
            self.labelInfo.configure(text = "Conteggio: " + str(count) + " persone")
        else:
            self.labelInfo.configure(text = "Conteggio: " + str(count) + " persona")

    def run(self):
        print("funzia")
        # Load network
        faceNet = cv.dnn.readNet(self.faceModel, self.faceProto)

        #cattura dello schermo
        cap = cv.VideoCapture(self.capture, cv.CAP_DSHOW)
        padding = 20
        last_face_number = None
        count = 0

        timeN = datetime.datetime.now()
        timeF = datetime.datetime.now()
        timeF += timedelta(seconds=10)
        while cv.waitKey(1) < 0 and self.runstate:
            face_number = 0 

            if timeN < timeF:

                timeN = datetime.datetime.now()

                #prende il frame attuale della camera.
                hasFrame, frame = cap.read()
                if not hasFrame:    #se non individua frame, chiude.
                    cv.waitKey()
                    break

                #ridimensione del frame del 200% con il metodo apposito.
                try:
                    frame = self.rescale_frame(frame,percent=200)
                except:
                    print("2ppo")
                
                #prende il numero di box/cornici create. Se non viene trovata nessuna, continua.
                frameFace, bboxes = self.getFaceBox(faceNet, frame) 


                #conteggio dei volti presenti nel frame.
                for face in bboxes:
                    face_number+=1

                #conteggio totale delle persone.
                
                if last_face_number:
                    if last_face_number < face_number:
                        last_face_number = face_number
                        count += 1
                else:
                    last_face_number = face_number
                    count = face_number
                    

                print(f'count: {count}')

                self.update_picture( cv.cvtColor(frameFace, cv.COLOR_BGR2RGB) )
                self.update_counter(count)

                now = datetime.datetime.now()
            else:
                timeN = datetime.datetime.now()
                self.q.put( {'time':timeN.strftime('%Y-%m-%d %H:%M:%S'), 'count':count} )
                #azzeremento del last_face_number
                last_face_number = None
                # #azzeramento count
                count = 0
                timeF = datetime.datetime.now()
                timeF += timedelta(seconds=10)
                print(str(count))

        print('end while - exiting webcam procedure')
        cv.destroyAllWindows()
        self.top.destroy()
        

    #------------------------------ Scansione volti ------------------------------    

    #Genera  i box/cornici attorno ad ogni volto trovato per frame.
    #@Param frame Frame attuale.
    #@Param net Network.
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

    #------------------------------Resize del frame-------------------------------

    #esegue un resizing del frame in base alla percentuale passata.
    #@param frame Frame da ridimensionare.
    #@param percent Percentuale di ridimensionamento.
    def rescale_frame(self, frame, percent=75):
        width = int(frame.shape[1] * percent/ 100)
        height = int(frame.shape[0] * percent/ 100)
        dim = (width, height)
        return cv.resize(frame, dim, interpolation =cv.INTER_AREA)    

    #-----------------------------------------------------------------------------
    #metodo per aggiungere il json : guestdatalogger
    

if __name__ == '__main__':
    ex = Queue()
    ex.put({'exit':False})
    sender_queue =  Queue()
    sw = StartWindow(sender_queue) #si chiude da sola
    
    sw_return_val = sender_queue.get()
    print(sw_return_val)
    api_key = sw_return_val["api_key"]
    webcam_port = sw_return_val["webcam_port"]
    
    sd = SenderData(sender_queue, api_key, ex)
    sd.daemon = True
    sd.start()

    frames_queue = Queue()
    cap = Capture(sender_queue, frames_queue, webcam_port)
    cap.start()

    cw = CameraWindowN(frames_queue=frames_queue, ex=ex)
    cw.run()    #code stops here as tk mainloop is started

    cap.runstate = False
    cw = None
    
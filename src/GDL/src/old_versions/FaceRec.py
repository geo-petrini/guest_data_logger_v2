# Import required modules
import cv2 as cv
import math
import argparse
import os 
import time
import datetime
#agiunto il deltatime : guestdatalogger
from datetime import timedelta
import tkinter as tk
from tkinter import *
from PIL import Image, ImageTk
#aggiunto l'importazione del json : guestdatalogger
import json
#aggiunto l'importazione del request : guestdatalogger
import requests
import threading as thread

#modifica dei parametri in entrata (api key) : guestdatalogger
#Permette di iniziare la detection dei volti.
#@param host Host del database.
#@param user user con cui connettersi.
#@param passwd password dell'utente.
def startFaceRecognition(api_key, capture=0):
    #------------------------------Resize del frame-------------------------------
    
    #esegue un resizing del frame in base alla percentuale passata.
	#@param frame Frame da ridimensionare.
	#@param percent Percentuale di ridimensionamento.
    def rescale_frame(frame, percent=75):
        width = int(frame.shape[1] * percent/ 100)
        height = int(frame.shape[0] * percent/ 100)
        dim = (width, height)
        return cv.resize(frame, dim, interpolation =cv.INTER_AREA)    

    #-----------------------------------------------------------------------------
    #metodo per aggiungere il json : guestdatalogger

    #Permette l'aggiunta di dati al database
	#@param date Data corrente nel formato mm-dd-YY
	#@param hours Ora attuale.
	#@param minutes Minuti attuali.
	#@param secs Secondi attuali.
    def dataToJSON(date,number_face):

        #Inserimento dati nel Database
        #url = 'http://localhost:8080/localDataSite/Scripts/insertStat.php'
        url = 'http://127.0.0.1'
        myJson = {
            "data":date,
            "num_persone": number_face,
            "api_key":api_key
            }
        req = requests.post(url, json= myJson)
        print(req.text)


    #-----------------------------------------------------------------------------   
        
    #------------------------------ Scansione volti ------------------------------    

    #Genera  i box/cornici attorno ad ogni volto trovato per frame.
	#@Param frame Frame attuale.
	#@Param net Network.
    def getFaceBox(net, frame, conf_threshold=0.7):
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

    #Definisce nuovo frame.
    top = Tk()
    #setta le dimensioni del frame.
    top.geometry("1000x660")
    #setta il background bianco.
    top.configure(background='white')
    #aggiunge il titolo al frame.
    top.wm_title("Guest Data Logger v2")
    #setta a non ridimensionabile il frame.
    top.resizable(width=False, height=False)
    
    faceProto = "opencv_face_detector.pbtxt"
    faceModel = "opencv_face_detector_uint8.pb"

    
    def on_closing():
        sys.exit()

    def webcam():
        label = tk.Label(top)
        label.pack()

        # Load network
        faceNet = cv.dnn.readNet(faceModel, faceProto)

        #cattura dello schermo
        cap = cv.VideoCapture(capture)
        padding = 20
        last_face_number = None
        count = 0

        timeN = datetime.datetime.now()
        timeF = datetime.datetime.now()
        timeF += timedelta(seconds=10)
        while cv.waitKey(1) < 0:
            
            face_number = 0 

            # if cv.waitKey(delay=0):
            #     cv.DestroyWindow("Live Video")

            if timeN<timeF:

                timeN = datetime.datetime.now()

                #prende il frame attuale della camera.
                hasFrame, frame = cap.read()
                
                #ridimensione del frame del 200% con il metodo apposito.
                try:
                    frame = rescale_frame(frame,percent=200)
                except:
                    print("2ppo")
                
                #prende il numero di box/cornici create. Se non viene trovata nessuna, continua.
                frameFace, bboxes = getFaceBox(faceNet, frame)  

                #conteggio dei volti presenti nel frame.
                for face in bboxes:
                    face_number+=1   

                tkFrame1 = cv.cvtColor(frame, cv.COLOR_BGR2RGB)
                tkFrame2 = cv.cvtColor(frameFace, cv.COLOR_BGR2RGB)
                image1 = Image.fromarray(tkFrame1)
                image2 = Image.fromarray(tkFrame2)
                finalFrame1 =  ImageTk.PhotoImage(image1)
                finalFrame2 =  ImageTk.PhotoImage(image2)
                label.image = finalFrame1
                label.configure(image = finalFrame1)
                label.pack()
                label.image = finalFrame2
                label.configure(image = finalFrame2)
                label.pack()
                #se non individua frame, chiude.
                if not hasFrame:
                    cv.waitKey()
                    break

                #print delle cornici su schermo. 
                #cv.imshow("Face detect", frameFace)
                    
                #conteggio totale delle persone.
                
                if last_face_number is not None:
                    if last_face_number < face_number:
                        count+=1
                        last_face_number = face_number
                        now = datetime.datetime.now()
                else:
                    last_face_number = face_number
                    count+=face_number
                    now = datetime.datetime.now()
                print(str(count))
            else:
                timeN = datetime.datetime.now()
                dataToJSON(timeN.strftime('%Y-%m-%d %H:%M:%S'), count)
                #azzeremento del last_face_number
                last_face_number = None
                # #azzeramento count
                count = 0
                
                timeF = datetime.datetime.now()
                timeF += timedelta(seconds=10)
                print(str(count))
    
    threadWeb = thread.Thread(target = webcam).start()
    top.protocol("WM_DELETE_WINDOW", on_closing)
    top.mainloop()



    #-----------------------------------------------------------------------------  

#bisogna fare il controllo se la chiave inserita sia veritiera

#verifica se i dati utente inseriti sono validi, per farlo utilizza un try & catch
# che verifica se l'host o l'utente inserito esistano.
#@param host Host da testare.
#@param user User da testare.
#@param password Password dell'utente da testare.
def testConnection(api_key):
    
    #url = 'http://localhost:8080/localDataSite/Scripts/checkKey.php'
    url = 'http://127.0.0.1'
    #custom_header = {"api_key":api_key}
    myJson = {
            "api_key":api_key
            }
    response = requests.post(url, json=myJson)
    print(response.status_code)
    if response.status_code == 404: #386:
        return True
    else:
        return False

#-------------------------------- Menu Frame in Tkinter ---------------------------------------

    #/////////////////// Frame /////////////////
#Quando viene partito bisogna ribattare.

#Definisce nuovo frame.
top = Tk()
#setta le dimensioni del frame.
top.geometry("280x380")
#setta il background bianco.
top.configure(background='white')
#aggiunge il titolo al frame.
top.wm_title("Face recognition")
#setta a non ridimensionabile il frame.
top.resizable(width=False, height=False)

#///////////////////////////////////////////


#//////////////// Logo /////////////////////
load = Image.open("n.png")
render = ImageTk.PhotoImage(load)
img = Label(top, image=render)
img.image = render
img.place(x=0,y=0)

#///////////////////////////////////////////


#///////////// Help label //////////////////

L0 = Label(top,text="Insert your API Key:")
L0.config(font=("Courier",8))
L0.place(x=30,y=90)

#///////////////////////////////////////////
#///// Host,user,password label+entry //////

L1 = Label(top, text="Key")
L1.place(x=30,y=120)
E1 = Entry(top, bd=5)
E1.place(x=100,y=120)

#///////////////////////////////////////////

#In caso venga premuto il tasto start, verifica
#che i campi non siano vuoti e che i dati inseriti
#siano validi tramite apposito metodo, se queste
#condizioni non sono soddisfatte, stampa un label rosso con l'errore.
def buttonPressed():
    v = E1.get()

    L4 = Label()
    if L4.winfo_exists():
        L4.destroy()

    if len(v) == 0:
        L4 = Label(top, text="Not valid, try again.")
        L4.config(fg="red")
        L4.place(x=30,y=350)  
        
    else:
        if testConnection(v) is True:
            top.destroy()
            startFaceRecognition(v)
                
        else:
            L4 = Label(top, text="API Key invalid, try again.")
            L4.config(fg="red")
            L4.place(x=30,y=350)   

btn = Button(top, text ="Start", width=20,command=buttonPressed)
btn.place(x=60,y=320)
top.mainloop()

#----------------------------------------------------------------------------------------
# Import required modules
import cv2 as cv
import math
import argparse
import os 
import time
import datetime
#agiunto il deltatime : guestdatalogger
from datetime import timedelta
from tkinter import *
from PIL import Image, ImageTk
#aggiunto l'importazione del json : guestdatalogger
import json
#aggiunto l'importazione del request : guestdatalogger
import requests

#modifica dei parametri in entrata (api key) : guestdatalogger
#Permette di iniziare la detection dei volti.
#@param host Host del database.
#@param user user con cui connettersi.
#@param passwd password dell'utente.
def startFaceRecognition(capture=0):
  
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
    def dataToJSON(date,number_face, api_key="fubn734fbn73hjd834nj8"):

        #Inserimento dati nel Database
        url = 'http://127.0.0.1'
        myJson = {
            "data":date,
            "num_persone": number_face,
            "api_key":api_key
            }
        req = requests.post(url, json= myJson)
        print(req.status_code)


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

    faceProto = "opencv_face_detector.pbtxt"
    faceModel = "opencv_face_detector_uint8.pb"

    # Load network
    faceNet = cv.dnn.readNet(faceModel, faceProto)

    #cattura dello schermo
    cap = cv.VideoCapture(capture)
    padding = 20
    last_face_number = None
    count = 0
    #aggiunto guestdataloggerv2
    timeN = datetime.datetime.now()
    timeF = datetime.datetime.now()
    timeF += timedelta(seconds=10)
    
    while cv.waitKey(1) < 0:
        
        face_number = 0 

        if timeN<timeF:

            timeN = datetime.datetime.now()
                

            #prende il frame attuale della camera.
            hasFrame, frame = cap.read()
                
            #ridimensione del frame del 200% con il metodo apposito.
            frame = rescale_frame(frame,percent=200)

            #se non individua frame, chiude.
            if not hasFrame:
                cv.waitKey()
                break

            #prende il numero di box/cornici create. Se non viene trovata nessuna, continua.
            frameFace, bboxes = getFaceBox(faceNet, frame)  

            #conteggio dei volti presenti nel frame.
            for face in bboxes:
                face_number+=1   

            #print delle cornici su schermo. 
            cv.imshow("Face detect", frameFace)
                
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
            dataToJSON(timeN.strftime("%d/%m/%Y, %H:%M:%S"), count)
            #azzeremento del last_face_number
            last_face_number = None
            # #azzeramento count
            count = 0
            timeF = datetime.datetime.now()
            timeF += timedelta(seconds=10)

        #bisogna aggiungere la parte del json dove vado a immettere i dati : guestdatalogger

    #-----------------------------------------------------------------------------  
startFaceRecognition()
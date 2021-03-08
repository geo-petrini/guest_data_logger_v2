import tkinter as tk
from tkinter import *
from PIL import Image, ImageTk
import requests
import threading as thread
import cv2 as cv
import time
import datetime
from datetime import timedelta
        
class CameraWindow():

    def __init__(self, q):
        self.q = q
        self.faceProto = "opencv_face_detector.pbtxt"
        self.faceModel = "opencv_face_detector_uint8.pb"
        self._build_frame()
        self._build_label()
        self.startFaceRecognition()
        self.top.protocol("WM_DELETE_WINDOW", self.on_closing)
        self.top.mainloop()
        self.SetDoubleBuffered(True)
    
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

    def on_closing(self):
            sys.exit()

    def _build_label(self):
        self.label = tk.Label(self.top)
        self.label.pack()

    #modifica dei parametri in entrata (api key) : guestdatalogger
    #Permette di iniziare la detection dei volti.
    #@param host Host del database.
    #@param user user con cui connettersi.
    #@param passwd password dell'utente.
    def startFaceRecognition(self, capture=0):
       
        threadWeb = thread.Thread(target = lambda : self.webcam(capture)).start()

    def webcam(self, capture):
        
        # Load network
        faceNet = cv.dnn.readNet(self.faceModel, self.faceProto)

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
                    frame = self.rescale_frame(frame,percent=300)
                except:
                    print("2ppo")
                
                #prende il numero di box/cornici create. Se non viene trovata nessuna, continua.
                frameFace, bboxes = self.getFaceBox(faceNet, frame) 


                #conteggio dei volti presenti nel frame.
                for face in bboxes:
                    face_number+=1   

                tkFrame1 = cv.cvtColor(frame, cv.COLOR_BGR2RGB)
                tkFrame2 = cv.cvtColor(frameFace, cv.COLOR_BGR2RGB)
                image1 = Image.fromarray(tkFrame1)
                image2 = Image.fromarray(tkFrame2)
                finalFrame1 =  ImageTk.PhotoImage(image1)
                finalFrame2 =  ImageTk.PhotoImage(image2)
                #self.label.image = finalFrame1
                #self.label.configure(image = finalFrame1)
                #self.label.pack()
                self.label.image = finalFrame2
                self.label.configure(image = finalFrame2)
                self.label.pack()
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
                #dataToJSON(timeN.strftime('%Y-%m-%d %H:%M:%S'), count, api_key)
                self.q.put( {'time':timeN.strftime('%Y-%m-%d %H:%M:%S'), 'count':count} )
                #azzeremento del last_face_number
                last_face_number = None
                # #azzeramento count
                count = 0
                timeF = datetime.datetime.now()
                timeF += timedelta(seconds=10)
                print(str(count))

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


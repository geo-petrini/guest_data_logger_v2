import tkinter as tk
from tkinter import *
from PIL import Image, ImageTk
import requests
import threading as thread
import cv2 as cv
import time
import datetime
from datetime import timedelta
import sys

class CameraWindow():

    def __init__(self, q, ex):
        self.q = q
        self.ex = ex
        self.runstate = True
        self.faceProto = "opencv_face_detector.pbtxt"
        self.faceModel = "opencv_face_detector_uint8.pb"
        self._build_frame()
        self._build_label()
        self.startFaceRecognition()
        self.top.protocol("WM_DELETE_WINDOW", self.on_closing)
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

    def on_closing(self):
        self.ex.put({'exit':True})
        self.runstate = False
        print(f'setting runstate = {self.runstate}')
        #self.top.destroy()

    def _build_label(self):
        self.label = tk.Label(self.top, height=675, width=1290)
        self.label.pack()
        self.labelInfo = tk.Label(self.top, text="Conteggio: 0", font=('Helvetica', 12), fg='blue')
        self.labelInfo.pack()
        self.label.place(x=0,y=25)
        self.labelInfo.place(x=0,y=0)

    #modifica dei parametri in entrata (api key) : guestdatalogger
    #Permette di iniziare la detection dei volti.
    #@param host Host del database.
    #@param user user con cui connettersi.
    #@param passwd password dell'utente.
    def startFaceRecognition(self, capture=0):
       
        self.threadWeb = thread.Thread(target = lambda : self.webcam(capture))
        print(self.threadWeb)
        self.threadWeb.start()
        #if self.threadWeb.is_alive():
        #    print('self.threadWeb is alive')

    def webcam(self, capture):
        
        # Load network
        faceNet = cv.dnn.readNet(self.faceModel, self.faceProto)

        #cattura dello schermo
        cap = cv.VideoCapture(capture, cv.CAP_DSHOW)
        padding = 20
        last_face_number = None
        count = 0

        timeN = datetime.datetime.now()
        timeF = datetime.datetime.now()
        timeF += timedelta(seconds=10)
        #cv.waitKey(1) < 0 and
        while cv.waitKey(1) < 0 and self.runstate:
            #print(self.runstate)
            face_number = 0 

            # if cv.waitKey(delay=0):
            #     cv.DestroyWindow("Live Video")

            if timeN<timeF:

                timeN = datetime.datetime.now()

                #prende il frame attuale della camera.
                hasFrame, frame = cap.read()
                
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

                tkFrame = cv.cvtColor(frameFace, cv.COLOR_BGR2RGB)
                image = Image.fromarray(tkFrame)
                finalFrame =  ImageTk.PhotoImage(image)
                if self.runstate == False:
                    print("exiting while loop")
                    break
                    
                self.label.configure(image = finalFrame)
                self.label.image = finalFrame
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
                if(count > 1 or count == 0):
                    self.labelInfo.configure(text = "Conteggio: " + str(count) + " persone")
                else:
                    self.labelInfo.configure(text = "Conteggio: " + str(count) + " persona")
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

        print('end while - exiting webcam procedure')
        #TODO clean close cv
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


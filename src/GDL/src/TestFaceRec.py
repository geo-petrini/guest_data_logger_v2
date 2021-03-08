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
from multiprocessing import Queue
import StartWindow
import CameraWindow

#Permette l'aggiunta di dati al database
#@param date Data corrente nel formato mm-dd-YY
#@param hours Ora attuale.
#@param minutes Minuti attuali.
#@param secs Secondi attuali.
def dataToJSON(self):
    v = self.q.get()
    myJson = {
        "data":v["time"],
        "num_persone": v["count"],
        "api_key":self.api_key
        }
    return myJson

#-----------------------------------------------------------------------------   

#-----------------------------------------------------------------------------  

#bisogna fare il controllo se la chiave inserita sia veritiera

#verifica se i dati utente inseriti sono validi, per farlo utilizza un try & catch
# che verifica se l'host o l'utente inserito esistano.
#@param host Host da testare.
#@param user User da testare.
#@param password Password dell'utente da testare.

def send_data(q, ):
    pass
    #url = 'http://localhost:8080/localDataSite/Scripts/insertStat.php'
    url = 'http://127.0.0.1'
    req = requests.post(url, json= dataToJSON())
    print(req.text)


if __name__ == '__main__':
    q =  Queue()
    api_key = q.get()["api_key"]
    #sender = thread.Thread(target = lambda : self.webcam(capture)).start()
    #mw = StartWindow.StartWindow(q)
    cw = CameraWindow.CameraWindow(q)
    sd = SenderData.SenderData(q, api_key)
#----------------------------------------------------------------------------------------

class SenderData (threading.Thread):
    def __init__(self, q, api_key):
        threading.Thread.__init__(self)
        self.q = q
        self.api_key = api_key
    def run(self):
        while True:
        	if!(self.q.isEmpty()):
        		
            




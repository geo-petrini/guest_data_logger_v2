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
from multiprocessing import *
import StartWindow
import CameraWindow
import sys

#il metodo get() della classe Queue, di default ha un parametro block settato a true che blocca il flusso del programma fino a quando la coda si riempie.

class SenderData (thread.Thread):
    def __init__(self, q, api_key, ex):
        thread.Thread.__init__(self)
        self._stopevent = thread.Event()
        self.q = q
        self.api_key = api_key
        self.ex = ex
    
    def run(self):
        condizione = self.checkEx()
        while condizione:
            self.send_data()
            condizione = self.checkEx()
        print("Fuori dal run")
        #sys.exit()
        return
    
    def join (self, timeout = None):
        self._stopevent.set()

    def checkEx(self):
        if(self.ex.get(False)['exit']):
            print("exit now")
            return False
        else:
            print("FALSE exit")
            self.ex.put({'exit': False})
            return True
    
    #Permette l'aggiunta di dati al database
    #@param date Data corrente nel formato mm-dd-YY
    #@param hours Ora attuale.
    #@param minutes Minuti attuali.
    #@param secs Secondi attuali.
    def dataToJSON(self):
        try:
            v = self.q.get(True, 3)
            myJson = {
                "data":v["time"],
                "num_persone": v["count"],
                "api_key":self.api_key
                }
            return myJson
        except:
            print("dataToJSON: exception")

    #-----------------------------------------------------------------------------   

    #-----------------------------------------------------------------------------  

    #bisogna fare il controllo se la chiave inserita sia veritiera

    #verifica se i dati utente inseriti sono validi, per farlo utilizza un try & catch
    # che verifica se l'host o l'utente inserito esistano.
    #@param host Host da testare.
    #@param user User da testare.
    #@param password Password dell'utente da testare.

    def send_data(self):
        url = 'http://localhost:8080/GuestDataLogger/scripts/insertStat.php'
        #url = 'http://127.0.0.1'
        req = requests.post(url, json= self.dataToJSON())
        print(req.text)

#----------------------------------------------------------------------------------------

if __name__ == '__main__':
    ex = Queue()
    ex.put({'exit':False})
    q =  Queue()
    mw = StartWindow.StartWindow(q)
    api_key = q.get()["api_key"]
    sd = SenderData(q, api_key, ex)
    sd.start()
    cw = CameraWindow.CameraWindow(q, ex)
    while sd.is_alive():
        time.sleep(0.5)
    print("Thread morta")
    # NOTA: IDLE cattura tutte le eccezioni, compresa la SystemExit.
    # Provare senza IDLE.
    sys.exit("sys.exit()")
    #exit()
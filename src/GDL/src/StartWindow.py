import tkinter as tk
from tkinter import *
from PIL import Image, ImageTk
import requests
import cv2 as cv

class StartWindow():

    # Inizializza il frame di login, istanziando tutti gli oggetti utili.
    def __init__(self, q):
        self.q = q
        self._build_frame()
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


    #////////// Istanzia la key entry ///////////
    def _build_key_input(self):
        l1 = Label(self.main_frame, text="Key")
        l1.place(x=30,y=120)
        self.e1 = Entry(self.main_frame, bd=5)
        self.e1.place(x=100,y=120)

    #/////////////////// Testa la connessione con il server ////////////////////////
    def testConnection(self, api_key):
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

    #In caso venga premuto il tasto start, verifica
    #che i campi non siano vuoti e che i dati inseriti
    #siano validi tramite apposito metodo, se queste
    #condizioni non sono soddisfatte, stampa un label rosso con l'errore.
    def buttonPressed(self):
        api_key = self.e1.get()

        L4 = Label()
        if L4.winfo_exists():
            L4.destroy()

        if len(api_key) == 0:
            L4 = Label(self.main_frame, text="Not valid, try again.")
            L4.config(fg="red")
            L4.place(x=30,y=350)  
            
        else:
            if self.testConnection(api_key) is True:
                self.q.put( {'api_key':api_key} )
                self.main_frame.destroy()
                
                    
            else:
                L4 = Label(self.main_frame, text="API Key invalid, try again.")
                L4.config(fg="red")
                L4.place(x=30,y=350)

    # Metodo per rilevare l'indice delle webcam disponibili
    def returnCameraIndexes(self):
        index = 0
        freeIndexes = []
        while True:
            video = cv.VideoCapture(index, cv.CAP_DSHOW)
            if not video.isOpened():
                break
            else:
                freeIndexes.append(index)
            video.release()
            index += 1
        if len(freeIndexes) < 1:
            return ["None"]
        return freeIndexes

# GuestDataLoggerV2 | Diario di lavoro
##### Mattia Bralla, Stefano Gnesa, Samuel Agustoni, Nikola Nikolic
### Centro Professionale Trevano, 11.03.2021

## Lavori svolti


|Orario        |Lavoro svolto                            |
|--------------|-----------------------------------------|
|08:20 - 09:05 | Briefing di gruppo |
|09:05 - 09:50 | Bralla: rework degli script php per il sito<br>Gnesa: rework della struttura del sito per implementarlo tramite MVC<br>Nikolic & Agustoni: thread per inviare i dati al server |
|10:05 - 10:50 | Bralla: rework degli script php per il sito<br>Gnesa: rework della struttura del sito per implementarlo tramite MVC<br>Nikolic & Agustoni: thread per inviare i dati al server|
|10:50 - 11:35 | Bralla: rework degli script php per il sito<br>Gnesa: rework della struttura del sito per implementarlo tramite MVC<br>Nikolic & Agustoni: double buffer|
|12:30 - 13:15 | Bralla: rework degli script php per il sito<br>Gnesa: rework della struttura del sito per implementarlo tramite MVC<br>Nikolic & Agustoni: gestione della chiusura del client|
|13:15 - 14:00 | Bralla: rework degli script php per il sito<br>Gnesa: gestione della chiusura del client<br>Nikolic & Agustoni: gestione della chiusura del client|
|14:15 - 15:00 | Bralla: rework degli script php per il sito<br>Gnesa: rework della struttura del sito per implementarlo tramite MVC<br>Nikolic & Agustoni: gestione della chiusura del client|
|15:00 - 15:45 | Bralla: rework degli script php per il sito<br>Gnesa: rework della struttura del sito per implementarlo tramite MVC<br>Nikolic & Agustoni: gestione della chiusura del client|
##  Problemi riscontrati e soluzioni adottate
Nikolic & Agustoni: problemi nel gestire il double buffer con tkinter, problemi con la gestione della chiusura del client (non si chiude in modo pulito)<br>
Bralla: problemi con servizio mysql, soluzione -> scaricare xampp su SSD. Problema di coerenza delle date sulla modifica della tabella, soluzione -> utilizzo di una libreria esterna per la validazione.

##  Punto della situazione rispetto alla pianificazione
In anticipo.

## Programma di massima per la prossima giornata di lavoro
Server: abbellire il sito e MVC.<br>
Client: gestire l'onClosing e se resta tempo gestire più webcam.


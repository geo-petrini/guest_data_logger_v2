<div id="templatemo_banner_wrapper">
	<div id="templatemo_banner">
    	<div id="templatemo_banner_image">
        	<div id="templatemo_banner_image_wrapper">
            	<img src="application/images/logo.png" alt="image" />
            </div>
        </div>
        <div id="templatemo_banner_content">
            <div class="header_01">Guest Data Logger</div>
            <br>
            <div class="header_02">Benvenuto
            <?php
                if((isset($_SESSION['firstname']) && !is_null($_SESSION['firstname']) && strlen($_SESSION['firstname']) != 0) || (isset($_SESSION['lastname'])  && !is_null($_SESSION['lastname']) && strlen($_SESSION['lastname']) != 0)){
                    if(isset($_SESSION['firstname'])){
                        echo " " .$_SESSION['firstname'];
                    }
                    if(isset($_SESSION['lastname'])){
                        echo " " . $_SESSION['lastname'];
                    }
                }else if(isset($_SESSION['username'])){
                    echo " " .$_SESSION['username'];
                }
            ?>
            </div>
        </div>
    	<div class="cleaner"></div>
    </div>
</div>

<div id="templatemo_content_wrapper">
	<div id="templatemo_content">
    	<div id="column">
            <div class="header_01" style="color: black;">Guest Data Logger</div>

            <div class="header_02" style="color: black;">Il software</div>
            <p>Il Guest Data Logger (GDL) è un applicazione utile a raccogliere dati statistici relativi al numero di visitatori di uno stand ad una certa data e ora.</p>
            <p>Tutti i dati vengono salvati automaticamente e saranno poi disponibili <a href="<?php echo URL?>graph">qui</a> sottoforma di grafici personalizzabili.</p>
            <p>Scarica il software <a href="http://samtinfo.ch/gdl/download/GDL_Software.zip">qui</a>. Per informazioni riguardo al funzionamento dell'applicazione, riferirsi al manuale d'utilizzo incluso nel download.</p>
    
            <div class="header_02" style="color: black;">Gestisci i tuoi dati GDL da qui</div>
            <p class="em_text">User</p>
            <p>Come utente potrai analizzare i grafici pubblici dei visitatori di uno stand, con la possibilità di cambiare l'unità di tempo e il tipo di grafico.</p>               
            <div class="cleaner"></div>        
            <p class="em_text">Proprietario stand</p>
            <p>Come proprietario di stand hai la possibilità di gestire i tuoi stand, ricevere le chiavi per inviare i flussi di dati tramite il software GDL e rendere pubblici i grafici.</p>
            <div class="cleaner"></div>

            <div class="header_02" style="color: black;">Storia</div>
            <p>Il GDL nasce come progetto scolastico sotto il nome ScanSpect, a cui hanno lavorato Alessandro Aloise, André da Silva e Nathan Lué della Scuola Arti e Mestieri Trevano nel 2020.</p>
            <p>Il progetto non concluso è stato poi proseguito con il nome Guest Data Logger dagli studenti Mattia Bralla, Stefano Gnesa, Samuel Agustoni, Nikola Nikolić.</p>

            <div class="header_02" style="color: black;">Altro</div>
            <p class="em_text">Repository GitHub</p>
            <div style="padding-bottom: 5%">
                <div class="news_image_wrapper">
                    <img src="application/images/githubLogo.png" alt="image" />
                </div>
                <p>Visualizza la <a href="https://github.com/geo-petrini/guest_data_logger_v2">repository</a> del nostro progetto.</p>
            </div>
            <div class="cleaner"></div>
            <p class="em_text">OpenCV</p>
            <div style="padding-bottom: 5%">
                <div class="news_image_wrapper">
                    <img src="application/images/opencvLogo.png" alt="image" />
                </div>
                <p>La libreria <a href="https://opencv.org/">OpenCV</a> ha premesso il riconoscimento facciale del nostro software.</p>
            </div>
            <div class="cleaner"></div>
            <p class="em_text">Python</p>
            <div style="padding-bottom: 5%">
                <div class="news_image_wrapper">
                    <img src="application/images/pythonLogo.png" alt="image" />
                </div>
                <p><a href="https://www.python.org/">Python</a> è il linguaggio su cui è basato il nostro software.</p>
            </div>
        </div>
    	<div class="cleaner"></div>
    </div>
</div>
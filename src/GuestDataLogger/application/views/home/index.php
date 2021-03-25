<div id="templatemo_banner_wrapper">
	<div id="templatemo_banner">
    	<div id="templatemo_banner_image">
        	<div id="templatemo_banner_image_wrapper">
            	<img src="application/images/logo.png" alt="image" />
            </div>
        </div>
        <div id="templatemo_banner_content">
        	<div class="header_01">ScanSpect Data Manager</div>
            <div class="button_01"><a href="http://samtinfo.ch/i17aloale/site/">Sito Informativo</a></div>
            <br>
            <br>
            <?php
                if(isset($_SESSION['username'])){
                    echo '<div class="header_02">Benvenuto ' . $_SESSION['username'] . '</div>';
                }
               
                
            ?>
        </div>	
    
    	<div class="cleaner"></div>
    </div>
</div>

<div id="templatemo_content_wrapper">
	<div id="templatemo_content">
    
    	<div id="column_w530">
        	
            <div class="header_02" style="color: black;">Gestisci i tuoi dati ScanSpect da qui </div>
            
            <p class="em_text">User</p>
            
            <p>Come user, potrai analizzare grafici pubblici dei visitatori di uno stand, con la possibilità di cambiare l'unità di tempo tramite l'opzione "Graph" del menu in alto.</p>
                               
            <div class="cleaner"></div>        
            <p class="em_text">Stand owner</p>
            
            <p>Come Stand owner hai la possibilità di gestire i tuoi stand, ricevendo una chiave per inviare i flussi di dati tramite il nostro applicativo e di rendere pubblici i grafici.</p>                               
            
            <div class="cleaner"></div>
            <p class="em_text">Admin</p>

            <p>Come admin avrai la possibilità di visualizzare tutti gli utenti, tutti i loro stand e tutti i dati caricati.</p>
            
            <div class="cleaner"></div>
        </div>
        
        <div id="column_w300">
        
        	<div class="header_03" style="color: black;">Pagine utili</div>
            
            <div class="column_w300_section_01">
            	<div class="news_image_wrapper">
                	<img src="application/images/githubLogo.png" alt="image" />
                </div>
                
                <div class="news_content">
                    <div class="header_04"><a class="alist" href="https://github.com/LuMug/ScanSpect">Repository github</a></div>
                    <p>Visualizza la repository del nostro progetto.</p>
				</div>
                                
                <div class="cleaner"></div>
            </div>
            
            <div class="column_w300_section_01 even_color">
            	<div class="news_image_wrapper">
                	<img src="application/images/opencvLogo.png" alt="image" />
                </div>
                
                <div class="news_content">
                    <div class="header_04"><a class="alist" href="https://opencv.org/">OpenCV</a></div>
                    <p>La libreria OpenCV ha permesso il riconoscimento facciale del nostro software.</p>
				</div>
                                
                <div class="cleaner"></div>
            </div>
            
            <div class="column_w300_section_01">
            	<div class="news_image_wrapper">
                	<img src="application/images/pythonLogo.png" alt="image" />
                </div>
                
                <div class="news_content">
                    <div class="header_04"><a class="alist" href="https://www.python.org/">Python</a></div>
                    <p>Python è necessario al fine di utilizzare il software per il riconoscimento facciale, 
                    scarica l'ultima versione da questo link.</p>
				</div>
                                
                <div class="cleaner"></div>
            </div>
             <div class="column_w300_section_01 even_color">
            	<div class="news_image_wrapper">
                	<img src="application/images/xamppLogo.jpg" alt="image" />
                </div>
                
                <div class="news_content">
                    <div class="header_04"><a class="alist" href="https://www.apachefriends.org/it/index.html">XAMPP</a></div>
                    <p>XAMPP è una buona piattaforma per avere un DBMS e PHP in un unico pacchetto, senza dover installarli in modo stand-alone.</p>
				</div>
                                
                <div class="cleaner"></div>
                 
            </div>
            <div class="cleaner"></div>
        </div>
    
    	<div class="cleaner"></div>
    </div>
</div>
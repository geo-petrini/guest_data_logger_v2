<!DOCTYPE html>
<?php 
	session_start(); 
	$route = include('./Configuration/config.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo $route?>/Style/templatemo_style.css" rel="stylesheet" type="text/css" />
    <script language="javascript" type="text/javascript">
    function clearText(field){

        if (field.defaultValue == field.value) field.value = '';
        else if (field.value == '') field.value = field.defaultValue;
    }
    </script>
	<title>ScanSpect</title>
	<style>
         #ulist {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        .list {
            float: left;
        }

        .list .alink {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .list .alink:hover {
            background-color: #4CAF50;
        }
        #login {
            float: right;
        }
	</style>
</head>
<body>

<ul id="ulist">
        <li class="list"><a class="alink" href="<?php echo $route?>">Home</a></li>
        
        <?php
            if(isset($_SESSION['loggedin'])){
        ?>
        <li class="list"><a class="alink" href="<?php echo $route?>/Graphs/">Graphs</a></li>
        <?php
            }
        ?> 
        <?php
            if(isset($_SESSION['admin'])){
        ?>
        
        <li class="list"><a class="alink" href="<?php echo $route?>/Administrator/">Data</a></li>
        <li class="list"><a class="alink" href="<?php echo $route?>/Modify/">Modify</a></li>
        <?php
            }
        ?>
        <li class="list"><a class="alink" href="<?php echo $route?>/About/">About</a></li>
        <?php 
            if(!isset($_SESSION['loggedin'])){
        ?>
        <li id="login" class="list"><a class="alink" href="<?php echo $route?>/Login/">Login</a></li>
        <li id="login" class="list"><a class="alink" href="<?php echo $route?>/Register/">Register</a></li>
        <?php
            }else{
        ?>
        <li id="login" class="list"><a class="alink" href="<?php echo $route?>/User/"><?php if(isset($_SESSION['admin'])){echo "Admin ";} echo $_SESSION['username'];?></a>
        <?php 
            }
        ?>
    </ul>

 <div id="templatemo_banner_wrapper">
	<div id="templatemo_banner">
    
    	<div id="templatemo_banner_image">
        	<div id="templatemo_banner_image_wrapper">
            	<img src="<?php echo $route?>/About/images/logo.png" alt="image" />
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
    </div> <!-- end of banner -->
</div> <!-- end of banner wrapper -->

<div id="templatemo_content_wrapper">
	<div id="templatemo_content">
    
    	<div id="column_w530">
        	
            <div class="header_02" style="color: black;">Gestisci i tuoi dati ScanSpect da qui </div>
            
            <p class="em_text">Utente</p>
            
            <p>Come utente, potrai analizzare grafici di dati di tutte le persone passate davanti ad uno stand, con la possibilità di cambiare l'unità di tempo tramite l'opzione "Graph" del menu in alto.</p>
                               
            <div class="cleaner"></div>        
            <p class="em_text">Amministratore</p>
            
            <p>Oltre a poter analizzare i grafici, è presente la possibilità di vedere la tabella con tutti i dati tramite l'opzione "Data" in alto.</p>                               
            <div class="cleaner"></div>            
            <br>
            <img src="images/warning.png"  style="float: left; height:15px; width:15px;"><p>Ricordati di modificare il file config.php dentro l'apposita cartella affinché il sito punti direttamente alla cartella scelta per l'utilizzo del data manager di ScanSpect!</p>
            <img src="images/warning.png"  style="float: left; height:15px; width:15px;"><p>Se è la prima volta che accedi a questa pagina, esegui il file InitialScript.sql!</p>
            <img src="images/warning.png"  style="float: left; height:15px; width:15px;"><p>Per poter accedere al client, ricordati di usare un account di un utente presente come user e con permessi di scrittura in MySQL!</p>
            <img src="images/warning.png"  style="float: left; height:15px; width:15px;"><p>Se vuoi creare degli utenti amministratori, accedi come adminUser (la password è presente dentro al file adminUser.php)</p>
            
            
            <div class="cleaner"></div>
        </div>
        
        <div id="column_w300">
        
        	<div class="header_03" style="color: black;">Pagine utili</div>
            
            <div class="column_w300_section_01">
            	<div class="news_image_wrapper">
                	<img src="<?php echo $route?>/images/githubLogo.png" alt="image" />
                </div>
                
                <div class="news_content">
                    <div class="header_04"><a class="alist" href="https://github.com/LuMug/ScanSpect">Repository github</a></div>
                    <p>Visualizza la repository del nostro progetto.</p>
				</div>
                                
                <div class="cleaner"></div>
            </div>
            
            <div class="column_w300_section_01 even_color">
            	<div class="news_image_wrapper">
                	<img src="<?php echo $route?>/images/opencvLogo.png" alt="image" />
                </div>
                
                <div class="news_content">
                    <div class="header_04"><a class="alist" href="https://opencv.org/">OpenCV</a></div>
                    <p>La libreria OpenCV ha permesso il riconoscimento facciale del nostro software.</p>
				</div>
                                
                <div class="cleaner"></div>
            </div>
            
            <div class="column_w300_section_01">
            	<div class="news_image_wrapper">
                	<img src="<?php echo $route?>/images/pythonLogo.png" alt="image" />
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
                	<img src="<?php echo $route?>/images/xamppLogo.jpg" alt="image" />
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
    </div> <!-- end of content wrapper -->
</div> <!-- end of content wrapper -->

<footer>
        <center>Copyright © 2020 ScanSpect</center><!-- Credit: www.templatemo.com -->
</footer>    
<!-- templatemo 121 simple gray -->
<!-- 
Simple Gray Template 
http://www.templatemo.com/preview/templatemo_121_simple_gray 
-->   
</body>
</html>
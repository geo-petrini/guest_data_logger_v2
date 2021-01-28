<?php 
	session_start(); 
	$route = include('./../Configuration/config.php');
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo $route?>/About/styles/about-us.css">
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
    <div class="wrapper row2">
    <div id="container" class="clear">
        <div id="about-us" class="clear">
        <div id="about-intro" class="clear">
            <div class="one_half first">
            <h1><b>Chi siamo?</b></h1>
            <p>Siamo dei giovani informatici, o quasi (speriamo di diventarlo), che frequentano la Scuola di Arti e Mestieri di Trevano. Il nostro è un progetto nato da un lavoro scolastico consegnatoci dal professor Luca Muggiasca.</p>
            <p>Questo progetto è stato realizzato tramite molteplici tecniche di programmazione e di sviluppo e design web, tant'è vero che sono stati utilizzati ben 5 linguaggi diversi, di programmazione e non, quali Python, Php, JavaScript, Html e Css.</p>
            </div>
            <div class="one_half"><img src="<?php echo $route?>images/logo.png" alt="Template Demo Image" /></div>
        </div>
        <div id="statements" class="clear">
            <div class="one_third first">
            <h1><b>Filosofia di lavoro</b></h1>
            <h2><i>Se funziona lascialo così!</i></h2>
            <p>Non tutti sono d'accordo con la nostra filosofia. Alcuni pensano che raggiungere la perfezione sia il massimo, ma la verità è che la perfezione non esiste. Quindi cercare di raggiungerla causa solo un loop temporale infinito. Noi non abbiamo questo problema!</p>
            </div>
            <div class="one_third">
            <h1><b>Le nostre abilità</b></h1>
            <ul class="skillset">
                <li class="clear"><img class="fl_left" src="<?php echo $route?>/About/images/programmazione.jpg" alt="Template Demo Image" />
                <div class="fl_right">
                    <p>Programmazione e design Web impeccabile</p>
                    <p>Grazie alle nostre competenze puoi fidarti ciecamente del nostro team.</p>
                </div>
                </li>
                <li class="clear"><img class="fl_left" src="<?php echo $route?>/About/images/update.png" alt="Template Demo Image" />
                <div class="fl_right">
                    <p>Aggiornamenti e miglioramenti sempre dietro l'angolo</p>
                    <p>Il nostro team è sempre al lavoro per garantirti il massimo delle prestazioni dal nostro applicativo.</p>
                </div>
                </li>
                <li class="clear"><img class="fl_left" src="<?php echo $route?>/About/images/24h.png" alt="Template Demo Image" />
                <div class="fl_right">
                    <p>Assistenza 24 ore su 24</p>
                    <p>Non importa che fuori ci sia il sole o piova, non importa che sia il 24 dicembre o il 2 agosto. Il nostro team ti aiuterà sempre, ogni momento in cui vuoi.</p>
                </div>
                </li>
            </ul>
            </div>
            <div class="one_third">
            <h1><b>Utilizzo di ScanSpect</b></h1>
            <p>Utilizza il software per monitorare l'affluenza di persone</p>
            <ul>
                <li>Alle fiere</li>
                <li>Al mercatino di natale</li>
                <li>Alla consegna dei diplomi</li>
                <li>Al saggio di tua figlia</li>
                <li>Al tuo primo concerto</li>
            </ul>
            <p>In poche parole ovunque tu voglia</p>
            </div>
        </div>
        <div id="team">
            <ul class="clear">
            <li class="one_third first">
                <div class="figure"><img src="<?php echo $route?>/images/lue_nathan.jpg" alt="Template Demo Image" />
                <div class="figcaption">
                    <div class="fl_left">
                    <p class="team_name">Nathan Luè</p>
                    <p class="team_title">Studente di informatica</p>
                    </div>
                    <ul>
                        <li><a href="mailto: nathan.lue@samtrevano.ch"><img src="<?php echo $route ?>/About/images/gmail.ico" alt="Email icon" /></a></li>
                        <li><a href="https://github.com/NathanLue"><img src="<?php echo $route ?>/About/images/github.ico" alt="GitHub icon" /></a></li>
                        <li><a href=""></a></li>
                    </ul>
                    <p class="team_description"><i>"Un pastorello con le mucche al pascolo<br>Sta suonando la sua fisarmonica…<br>Allegramente mi saluta con un CIAO!<br>Poi riprende subito a cantar"</i></p>
                </div>
                </div>
            </li>
            <li class="one_third">
                <div class="figure"><img src="<?php echo $route?>images/da_silva_andre_thomas.jpg" alt="Template Demo Image" />
                <div class="figcaption">
                    <div class="fl_left">
                    <p class="team_name">André Da Silva</p>
                    <p class="team_title">Studente di informatica</p>
                    </div>
                    <ul>
                        <li><a href="mailto: andre.dasilva@samtrevano.ch"><img src="<?php echo $route ?>/About/images/gmail.ico" alt="Email icon" /></a></li>
                        <li><a href="https://github.com/andredasilva451"><img src="<?php echo $route ?>/About/images/github.ico" alt="GitHub icon" /></a></li>
                        <li><a href=""><img src="<?php echo $route ?>/About/images/mcdonalds.ico" alt="Template Demo Image" /></a></li>
                    </ul>
                    <p class="team_description"><i>"Pazza inter amala"</i></p>
                </div>
                </div>
            </li>
            <li class="one_third">
                <div class="figure"><img src="<?php echo $route?>/images/aloise_alessandro.jpg" alt="Template Demo Image" />
                <div class="figcaption">
                    <div class="fl_left">
                    <p class="team_name">Alessandro Aloise</p>
                    <p class="team_title">Studente di informatica</p>
                    </div>
                    <ul>
                        <li><a href="mailto: alessandro.aloise@samtrevano.ch"><img src="<?php echo $route ?>/About/images/gmail.ico" alt="Email icon" /></a></li>
                        <li><a href=""><img src="<?php echo $route ?>/About/images/github.ico" alt="GitHub icon" /></a></li>
                        <li><a href="https://www.os-templates.com/page-templates"><img src="<?php echo $route ?>/About/images/tiktok.ico" alt="Template Demo Image" /></a></li>
                    </ul>
                    <p class="team_description"><i>"Dream big do Bigger"</i></p>
                </div>
                </div>
            </li>
            </ul>
        </div>
        </div>
    </div>
    </div>
    <!-- footer -->
    <div class="wrapper row3">
    <div id="footer" class="clear">
        <p class="fl_left">Copyright &copy; 2009 - 2020 - All Rights Reserved - <a href="https://www.os-templates.com/">Domain Name</a></p>
        <p class="fl_right">Template by <a href="https://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p>
    </div>
    </div>
    <div id="osfooter">
    <div>
        <div id="bsap_1244497" class="bsarocks bsap_2cdb89802e2deca5991138bb3e47b146"></div>
    </div>
    </div>
</body>
</html>
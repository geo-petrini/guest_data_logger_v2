<ul id="ulist">
    <li class="list"><a class="alink" href="<?php echo URL?>">Home</a></li>
    <li class="list"><a class="alink" href="<?php echo URL?>graph">Grafici</a></li>
    <?php 
        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == FALSE){
    ?>
    <li id="login" class="list"><a class="alink" href="<?php echo URL?>login">Accesso</a></li>
    <li id="login" class="list"><a class="alink" href="<?php echo URL?>register">Registrazione</a></li>
    <?php
        }else if ($_SESSION['loggedin'] == TRUE){
            if(isset($_SESSION['owner']) && $_SESSION['owner'] == TRUE){
        ?>
                <li class="list"><a class="alink" href="<?php echo URL?>stand">I miei stand</a></li>
                <li class="list"><a class="alink" href="<?php echo URL?>key">Le mie chiavi</a></li>
        <?php
            }
        ?>
        <li class="list"><a class="alink" href="<?php echo URL?>stand/addStand">Aggiungi stand</a></li>
        <?php
            if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){
        ?>
                <li class="list"><a class="alink" href="<?php echo URL?>administrator">Admin</a></li>  
        <?php
            }
        ?>
    <li id="login" class="list"><a class="alink" href="<?php echo URL?>user">
    <?php 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){
            echo "Admin - ";
        }else if(isset($_SESSION['owner']) && $_SESSION['owner'] == TRUE){
            echo "Proprietario stand - ";
        }else{
            echo "Utente - ";
        }
        echo $_SESSION['username'];
    ?></a>
    <?php
        }
    ?>
    <li class="list"><a class="alink" href="http://samtinfo.ch/gdl/download/GDL_Software.zip">Download</a></li>
</ul>
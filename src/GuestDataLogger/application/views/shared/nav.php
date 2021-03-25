<ul id="ulist">
    <li class="list"><a class="alink" href="<?php echo URL?>">Home</a></li>
    <li class="list"><a class="alink" href="<?php echo URL?>graph">Graphs</a></li>
    <?php 
        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == FALSE){
    ?>
    <li id="login" class="list"><a class="alink" href="<?php echo URL?>login">Login</a></li>
    <li id="login" class="list"><a class="alink" href="<?php echo URL?>register">Register</a></li>
    <?php
        }else if ($_SESSION['loggedin'] == TRUE){
            if(isset($_SESSION['owner']) && $_SESSION['owner'] == TRUE){
        ?>
                <li class="list"><a class="alink" href="<?php echo URL?>stand">My stands</a></li>
                <li class="list"><a class="alink" href="<?php echo URL?>key">My keys</a></li>
        <?php
            }
        ?>
        <li class="list"><a class="alink" href="<?php echo URL?>stand/addStand">Add stand</a></li>
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
            echo "Stand owner - ";
        }else{
            echo "User - ";
        }
        echo $_SESSION['username'];
    ?></a>
    <?php
        }
    ?>
</ul>
<?php 
    session_start();
    $route = include('./../Configuration/config.php');
	$normalUsercredential = include('./../Configuration/normalUser.php');
	$adminUserCredential = include('./../Configuration/adminUser.php');
    if($_SESSION['loggedin'] && $_SESSION['admin']){
?>
<!DOCTYPE html>
<html>
<head>
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
    <?php
        #Connessione al Database.
        $mysqli = new mysqli($_SESSION['host'], $adminUserCredential[0], $adminUserCredential[1], $_SESSION['database']);
        #Query effettuata al Database.
        $table = "user";
        $query = "SELECT * FROM $table";
        if ($result = $mysqli->query($query)) {
    ?>
    <center>
        <table>
            <tr>
                <th>Username</th>
                <th>Type</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                $usernameDb = $row["username"];
                $adminDb = $row["admin"];
                if(isset($_POST["type$usernameDb"])){
                    $unit =$_POST["type$usernameDb"];
                    $col = $unit;
                    if($row["admin"] == 1){
                        $sql2 = "UPDATE user SET admin = FALSE WHERE username = '$usernameDb'"; 
                        $adminDb = false;
                    }else{

                        $sql2 = "UPDATE user SET admin = TRUE WHERE username = '$usernameDb'";
                        $adminDb = true;
                    }
                    if ($ris = $mysqli->query($sql2)) {
                        //OK
                    }else{
                        echo "Error changing admin permissions";
                    }
                }
            ?>
            <td><?php echo $usernameDb ?></td>
            <td>

                <form method="post">
                <select id="rangeGraph" name="type<?php echo $usernameDb?>" onChange="this.form.submit()">
                    <option value="admin" <?php  if($adminDb){echo "selected";} ?>>Admin</option>
                    <option value="normal" <?php  if(!$adminDb){echo "selected";} ?>>Normal</option>
                </select>

                </form>
            </td>
            </tr>
            <?php 
            }
            ?>
        </table>
    </center>
    <?php 
        }else{
            echo "Unable to do the query";
        }
    ?>
</body>
<?php
    }else{
        //ACCESSO NON EFFETTUATO
        echo "You must login"
    }
?>
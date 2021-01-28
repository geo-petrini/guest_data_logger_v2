<?php 
	session_start(); 
	$route = include('./../Configuration/config.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>User info</title>
    <style>
        button {
            background-color: #FF3232;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }

        .imgcontainer {
            text-align: center;
            margin: 24px 0 12px 0;
        }

        img.avatar {
            width: 15%;
            border-radius: 50%;
        }

        .container {
            padding: 16px;
            text-align: center;
        }

		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			overflow: hidden;
			background-color: #333;
		}

		li {
			float: left;
		}

		li a {
			display: block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		li a:hover {
			background-color: #4CAF50;
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
            if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){
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
        <li id="login" class="list"><a class="alink" href="<?php echo $route?>/User/"><?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){echo "Admin ";} echo $_SESSION['username'];?></a>
        <?php 
            }
        ?>
    </ul>
    <div class="imgcontainer">
        <img src="<?php echo $route ?>Login/img/adminLogin.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">
        <label for="username"><b>Username</b></label><br>
        <p name="username"><?php echo $_SESSION['username']?></p><br>

        <label for="type"><b>User type</b></label><br>
        <p name="type"><?php if($_SESSION['admin']){echo "Administrator";}else{echo "Normal";}?></p><br>

        <label for="host"><b>Host connected</b></label><br>
        <p name="host"><?php echo $_SESSION['host']?></p><br>

        <label for="database"><b>Database access</b></label><br>
        <p name="database"><?php echo $_SESSION['database']?></p><br>

        <label for="table"><b>Table access</b></label><br>
        <p name="table"><?php echo $_SESSION['table']?></p><br>

        <?php
        if(array_key_exists('buttonLogout', $_POST)) { 
            session_destroy();
            header("location: ".$route);
        }
        ?> 

        <form method="post"> 
            <button type="submit" name="buttonLogout">Logout</button>
        </form>
        
    </div>
</body>
</html>
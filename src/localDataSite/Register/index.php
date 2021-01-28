<?php 
    $route = include('./../Configuration/config.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <style>
        body {font-family: Arial, Helvetica, sans-serif;}

        input[type=text], input[type=password] {
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
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
<center><h2>Register</h2></center>

<form action="<?php echo $route?>/Register/registerUser.php" method="post">
  <div class="imgcontainer">
    <img src="<?php echo $route?>/Login/img/adminLogin.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="username"><b>Username</b></label><br>
    <input type="text" placeholder="Enter Username" name="username" required><br>

    <label for="password"><b>Password</b></label><br>
    <input type="password" placeholder="Enter Password" name="password" required><br>
        
    <button type="submit">Register</button>
  </div>
</form>

</body>
</html>

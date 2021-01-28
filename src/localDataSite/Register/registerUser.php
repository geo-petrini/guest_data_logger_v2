<?php 
	session_start(); 
    $route = include('./../Configuration/config.php');
    $username = $password = "";

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	#Informazioni per la connessione.
	$username = test_input($_POST["username"]);
	$password = test_input($_POST["password"]);
	$database = "guestdatalogger";
	$table = "guestdatalogger.user";
    $host = "localhost:3307";
    #Connessione al Database.
    $mysqli = new mysqli($host, 'LoginUser', 'LoginAndRegister', $database);
    $_SESSION['loggedin'] = false;
	if(!$mysqli->connect_errno){
        $sql = "INSERT INTO user(username, pass) VALUES('$username', '$password')";
        if ($mysqli->query($sql)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['database'] = $database;
            $_SESSION['table'] = $table;
            $_SESSION['host'] = $host;
            $_SESSION['admin'] = false;
            header("location: ".$route);
        }else{
            echo "Error";
        }
    }else{
?>
<!DOCTYPE html>
	<head>
		<style>
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

			.container {
				padding: 16px;
				text-align: center;
        	}
		</style>
	</head>
	<body>
	<form action="<?php echo $route?>/Register/" method="post">
		<div class="container">
			<p><b>Register failed!</b><br><br>Check your user in Configuration/user.php</p>
			<button type="submit">Back</button>
		</div>
	</form>
	</body>
<?php
	}
?>
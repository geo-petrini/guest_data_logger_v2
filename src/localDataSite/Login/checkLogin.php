<?php 
	session_start(); 
	$route = include('./../Configuration/config.php');
	$normalUserCredential = include('./../Configuration/normalUser.php');
	$adminUserCredential = include('./../Configuration/adminUser.php');
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

	#Connessione al Database
	$mysqli = new mysqli($host, 'LoginUser', 'LoginAndRegister', $database);
	if(!$mysqli->connect_errno){
		$sql = "SELECT * from `user` WHERE `username` = '$username' AND `pass` = '$password'";
		$result = $mysqli->query($sql);
		if (is_array($result->fetch_assoc())) {
			$_SESSION['loggedin'] = true;
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			$_SESSION['database'] = $database;
			$_SESSION['table'] = $table;
			$_SESSION['host'] = $host;
			$_SESSION['admin'] = false;
			if($row["admin"]){
				$_SESSION['admin'] = true;
			}
			header("location: ".$route);
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
			<form action="<?php echo $route?>/Login/" method="post">
				<div class="container">
					<p><b>Login failed!</b><br><br>Check your username or password</p>
					<button type="submit">Back</button>
				</div>
			</form>
			</body>
		<?php
		}
	}else{
		//LOGIN NORMAL ERRATO
		echo "Login normalUser errato";
	}
?>
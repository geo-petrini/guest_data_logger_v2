<?php
	class LoginModel{

		function checkLogin($username, $password) {
			$mysqli = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
			if(!$mysqli->connect_errno){
				$query = "SELECT * from user WHERE username = '$username' AND pass = '$password'";
				$result = $mysqli->query($query);
				$result = $result->fetch_assoc();
				if (is_array($result)) {
					$_SESSION['loggedin'] = true;
					$_SESSION['username'] = $username;

					if($result['isOwner'] == 1){
						$_SESSION['owner'] = true;
					}else{
						$_SESSION['owner'] = false;
					}

					if($result['isAdmin'] == 1){
						$_SESSION['admin'] = true;
					}else{
						$_SESSION['admin'] = false;
					}
					return TRUE;
				}
				return FALSE;
			}
			return "MYSQL";
		}

		function registerUser($username, $password){
			$mysqli = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
			if(!$mysqli->connect_errno){
				if(strlen($username) < 25){
					if(strlen($password) < 32){
						$query = "INSERT INTO user(username, pass) VALUES('$username', '$password')";
						if ($mysqli->query($query)) {
							$_SESSION['loggedin'] = true;
							$_SESSION['username'] = $username;
							$_SESSION['owner'] = false;
							$_SESSION['admin'] = false;
							return TRUE;
						}
					}else{
						return "PASS";
					}
				}else{
					return "USER";
				}
			}
			return "MYSQL";
		}
		
		function cleanInput($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	}
?>
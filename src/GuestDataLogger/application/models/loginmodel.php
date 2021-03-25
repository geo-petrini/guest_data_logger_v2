<?php
	include_once "databasemodel.php";
	class LoginModel{

		function checkLogin($username, $password) {
			$query = "SELECT * from user WHERE username = '$username' AND pass = '$password'";
			$result = DatabaseModel::executeSelectQuery($query);
			if ($result != "MYSQL" && count($result) > 0) {
				$result = $result[0];

				$_SESSION['loggedin'] = TRUE;
				$_SESSION['username'] = $username;

				if($result['isOwner'] == 1){
					$_SESSION['owner'] = TRUE;
				}else{
					$_SESSION['owner'] = false;
				}

				if($result['isAdmin'] == 1){
					$_SESSION['admin'] = TRUE;
				}else{
					$_SESSION['admin'] = FALSE;
				}
				$result = TRUE;
			}else{
				$result = FALSE;
			}
			return $result;
		}

		function registerUser($username, $password){
			if(strlen($username) < 25){
				if(strlen($password) < 32){
					$query = "INSERT INTO user(username, pass) VALUES('$username', '$password')";
					$result = DatabaseModel::executeQuery($query);
					if ($result == TRUE) {
						$_SESSION['loggedin'] = TRUE;
						$_SESSION['username'] = $username;
						$_SESSION['owner'] = FALSE;
						$_SESSION['admin'] = FALSE;
					}
				}else{
					$result = "PASS";
				}
			}else{
				$result = "USER";
			}
			return $result;
		}
		
		function cleanInput($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	}
?>
<?php
	include_once "databasemodel.php";
	class LoginModel{

		/**
		 * 
		 * Controlla i dati per il login.
		 * 
		 * @param string $username Il nome utente.
		 * @param string $password La password.
		 * @return boolean True se il login va a buon fine, altrimenti false.
		 * 
		 */
		function checkLogin($username, $password) {
			$query = "SELECT * from utente WHERE username = '$username'";
			$result = DatabaseModel::executeSelectQuery($query);
			if ($result != "MYSQL" && password_verify($password, $result[0]['pass'])) {
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

		/**
		 * 
		 * Registra un nuovo utente.
		 * 
		 * @param string $username Il nome utente.
		 * @param string $password La password.
		 * @return mixed boolean|string True se la registrazione va a buon fine, "PASS"
		 * se la password è troppo lunga, o "USER" se il nome utente è troppo lungo.
		 * 
		 */
		function registerUser($username, $password){
			if(strlen($username) < 25){
				if(strlen($password) < 32){
					$hashed = password_hash($password,PASSWORD_BCRYPT);
					$query = "INSERT INTO utente(username, pass) VALUES('$username', '$hashed')";
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
		
		/**
		 * 
		 * Trasforma la stringa passata in una stringa priva di elementi che potrebbero dare problemi.
		 * 
		 * @param string $data La stringa da pulire.
		 * @return string La nuova stringa.
		 * 
		 */
		function cleanInput($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	}
?>
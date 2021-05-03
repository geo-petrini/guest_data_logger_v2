<?php
	include_once "databasemodel.php";
	class UserModel{

        /**
		 * 
		 * Ritorna le informazioni di un utente.
		 * 
		 * @param string $username L'utente.
		 * @return array Le informazioni dell'utente.
		 * 
		 */
        function fetchInfo($username){
            $query = "SELECT username, nome, cognome FROM utente WHERE username = '$username'";
            $info = DatabaseModel::executeSelectQuery($query);
            return $info;
        }

	}
?>
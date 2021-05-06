<?php
	class DatabaseModel{

		/**
		 * 
		 * Esegue una query al database.
		 * 
		 * @param string $query La query da eseguire.
		 * @return mixed Il risultato della query come array o "MYSQL" se c'è un errore di connessione.
		 * 
		 */
		static function executeSelectQuery($query){
			$mysqli = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
			if(!$mysqli->connect_errno){
				$result = array();
				if ($select = $mysqli->query($query)) {
					while ($row = $select->fetch_assoc()) {
						$result[] = $row;
					}
					$select->free();
					return $result;
				}
			}
			return "MYSQL";
		}

		/**
		 * 
		 * Esegue una query al database.
		 * 
		 * @param string $query La query da eseguire.
		 * @return mixed Vero o falso se la query è andata a buon fine o no,
		 * "MYSQL" se c'è un errore di connessione.
		 * 
		 */
		static function executeQuery($query){
			$mysqli = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
			if(!$mysqli->connect_errno){
				if ($mysqli->query($query)) {
					return TRUE;
				}else{
					return FALSE;
				}
			}
			return "MYSQL";
		}
	}
?>
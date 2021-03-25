<?php
	class DatabaseModel{
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
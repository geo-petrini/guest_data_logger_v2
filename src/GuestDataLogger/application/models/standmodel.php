<?php
	include_once "databasemodel.php";
	
	class StandModel{
        function fetchStands($proprietario){
			$query = "SELECT id, nome, luogo, data_inizio, data_fine, isPublic FROM stand WHERE proprietario = '$proprietario'";
			$stands = DatabaseModel::executeSelectQuery($query);
			return $stands;
        }

		function addStand($stand) {
            $nome = $stand['nome'];
			$luogo = $stand['luogo'];
			$data_inizio = $stand['data_inizio'];
            $data_fine = $stand['data_fine'];
            $proprietario = $stand['proprietario'];
			$query = "INSERT INTO stand(nome, luogo, data_inizio, data_fine, proprietario) VALUES('$nome', '$luogo', '$data_inizio', '$data_fine', '$proprietario')";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
		}

		function deleteStand($stand){
			$query = "DELETE FROM stand WHERE id = $stand";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
		}

        function setPublic($stand, $val) {
			$query = "UPDATE stand SET isPublic = $val WHERE id = $stand";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
		}
	}
?>
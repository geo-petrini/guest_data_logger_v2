<?php
	include_once "databasemodel.php";
	class KeyModel{

        function insertKey($key, $stand_id){
            $query = "SELECT num_webcam FROM chiave WHERE stand_id = $stand_id";
            $num_webcam = DatabaseModel::executeSelectQuery($query);
            if(is_array($num_webcam)){
                $num_webcam = count($num_webcam) + 1;
                $query = "INSERT INTO chiave VALUES('$key', $stand_id, $num_webcam)";
                $flag = DatabaseModel::executeQuery($query);
                return $flag;
            }else{
                return $num_webcam;
            }
        }

        function fetchKeysByOwner($proprietario){
            $query = "SELECT chiave.chiave, chiave.stand_id, chiave.num_webcam, stand.nome, stand.luogo FROM chiave LEFT JOIN stand ON chiave.stand_id = stand.id WHERE stand.proprietario = '$proprietario' ORDER BY stand.nome,chiave.num_webcam";
            $keys = DatabaseModel::executeSelectQuery($query);
            return $keys;
        }
        
        function deleteKey($chiave){
			$query = "DELETE FROM chiave WHERE chiave = '$chiave'";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
        }
	}
?>
<?php
	include_once "databasemodel.php";
	class KeyModel{

        /**
		 * 
		 * Inserisce una nuova chiave nel database.
		 * 
		 * @param string $key La chiave da inserire.
		 * @param int $stand_id L'id dello stand associato alla chiave.
		 * @return string Un flag.
		 * 
		 */
        function insertKey($key, $stand_id){
            $query = "SELECT num_webcam FROM chiave WHERE stand_id = $stand_id";
            $num_webcam = DatabaseModel::executeSelectQuery($query);
            if(is_array($num_webcam)){
                $webcam = max($num_webcam);
                $webcam = $webcam['num_webcam'];
                $query = "INSERT INTO chiave VALUES('$key', $stand_id, $webcam + 1)";
                $flag = DatabaseModel::executeQuery($query);
                return $flag;
            }else{
                return $num_webcam;
            }
        }

        /**
		 * 
		 * Ritorna le chiavi possedute dal proprietario passato.
		 * 
		 * @param string $proprietario Il proprietario.
		 * @return array Le chiavi.
		 * 
		 */
        function fetchKeysByOwner($proprietario){
            $query = "SELECT chiave.chiave, chiave.stand_id, chiave.num_webcam, stand.nome, stand.luogo FROM chiave LEFT JOIN stand ON chiave.stand_id = stand.id WHERE stand.proprietario = '$proprietario' ORDER BY stand.nome,chiave.num_webcam";
            $keys = DatabaseModel::executeSelectQuery($query);
            return $keys;
        }
        
        /**
		 * 
		 * Rimuove una chiave.
		 * 
		 * @param string $chiave La chiave da rimuovere.
		 * @return string Un flag.
		 * 
		 */
        function deleteKey($chiave){
			$query = "DELETE FROM chiave WHERE chiave = '$chiave'";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
        }
	}
?>
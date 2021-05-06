<?php
	include_once "databasemodel.php";
	
	class StandModel{

		/**
		 * 
		 * Ritorna gli stand di un proprietario.
		 * 
		 * @param string $proprietario Il proprietario.
		 * @return array Gli stand.
		 * 
		 */
        function fetchStands($proprietario){
			$query = "SELECT id, nome, luogo, data_inizio, data_fine, isPublic FROM stand WHERE proprietario = '$proprietario'";
			$stands = DatabaseModel::executeSelectQuery($query);
			return $stands;
        }

		/**
		 * 
		 * Aggiunge uno stand.
		 * 
		 * @param array $stand Lo stand da aggiungere.
		 * @return string "DATE" se le date non sono valide, altrimenti un flag.
		 * 
		 */
		function addStand($stand) {
            $nome = $stand['nome'];
			$luogo = $stand['luogo'];
			$data_inizio = $stand['data_inizio'];
            $data_fine = $stand['data_fine'];
			$proprietario = $stand['proprietario'];
			if($data_inizio > $data_fine){
				return "DATE";
			}
			$query = "INSERT INTO stand(nome, luogo, data_inizio, data_fine, proprietario) VALUES('$nome', '$luogo', '$data_inizio', '$data_fine', '$proprietario')";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
		}

		/**
		 * 
		 * Rimuove uno stand.
		 * 
		 * @param $stand_id L'id dello stand da rimuovere.
		 * @return string Un flag.
		 * 
		 */
		function deleteStand($stand_id){
			$query = "DELETE FROM stand WHERE id = $stand_id";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
		}

		/**
		 * 
		 * Controlla che un utente possieda almeno uno stand.
		 * 
		 * @param string $username Il nome utente.
		 * @return boolean TRUE se possiede uno o più stand, altrimenti FALSE.
		 * 
		 */
		function checkStands($username){
			$query = "SELECT COUNT(*) AS count FROM stand WHERE proprietario = '$username'";
			$result = DatabaseModel::executeSelectQuery($query);
			$result = $result[0];
			if ($result != "MYSQL" && $result['count'] != 0) {
				$result = TRUE;
			}else{
				$result = FALSE;
			}
			return $result;
		}

		/**
		 * 
		 * Rende pubblico o privato il grafico di uno stand.
		 * 
		 * @param int $stand_id L'id dello stand.
		 * @param int $val Il valore da impostare.
		 * @return string Un flag.
		 * 
		 */
        function setPublic($stand_id, $val) {
			$query = "UPDATE stand SET isPublic = $val WHERE id = $stand_id";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
		}

		/**
		 * 
		 * Permette di modificare lo stato di proprietà di un utente.
		 * 
		 * @param string $proprietario Il proprietario.
		 * @param boolean $val Il nuovo valore.
		 * @return string Un flag.
		 * 
		 */
        function setOwner($proprietario, $val) {
			if($val){
				$query = "UPDATE utente SET isOwner = 1 WHERE username = '$proprietario'";
			}else{
				$query = "UPDATE utente SET isOwner = 0 WHERE username = '$proprietario'";
			}
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
		}
	}
?>
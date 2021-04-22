<?php
include_once "application/models/databasemodel.php";
	class ScriptModel{

		/**
		 * 
		 * Aggiorna i dati di uno stand.
		 * 
		 * @param string $update_field I campi da aggiornare.
		 * @param int $stand_id L'id dello stand.
		 * @return string Un flag.
		 * 
		 */
		function updateStand($update_field, $stand_id){
			$query = "UPDATE stand SET $update_field WHERE id=$stand_id";
			$flag = DatabaseModel::executeSelectQuery($query);
			return $flag;
		}
	}
?>
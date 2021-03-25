<?php
include_once "application/models/databasemodel.php";
	class ScriptModel{
		function updateStand($update_field, $stand_id){
            file_put_contents("log.txt", "ScriptModel");
			$query = "UPDATE stand SET $update_field WHERE id=$stand_id";
			$flag = DatabaseModel::executeSelectQuery($query);
			return $flag;
		}
	}
?>
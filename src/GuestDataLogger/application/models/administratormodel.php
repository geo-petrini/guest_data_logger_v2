<?php
	include_once "databasemodel.php";
	class AdministratorModel{
		function fetchUsers(){
			$query = "SELECT username, nome, cognome, isOwner, isAdmin FROM user";
			$users = DatabaseModel::executeSelectQuery($query);
			return $users;
		}

		function fetchUser($username){
			$query = "SELECT username, nome, cognome, isOwner, isAdmin FROM user WHERE username = '$username'";
			$user = DatabaseModel::executeSelectQuery($query);
			return $user;
		}
		
		function updateUser($user){
			$username = $user['username'];
			$newUsername = $user['newUsername'];
			$nome = $user['newNome'];
			$cognome = $user['newCognome'];
			$isAdmin = $user['newIsAdmin'];
			$query = "UPDATE user SET username = '$newUsername', nome = '$nome', cognome = '$cognome', isAdmin = $isAdmin WHERE username = '$username'";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
		}

		function deleteUser($username){
			$query = "DELETE FROM user WHERE username = '$username'";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
		}

        function fetchStands(){
			$query = "SELECT * FROM stand";
			$stands = DatabaseModel::executeSelectQuery($query);
			return $stands;
		}
		
		function fetchStand($id){
			$query = "SELECT * FROM stand WHERE id = $id";
			$user = DatabaseModel::executeSelectQuery($query);
			return $user;
		}

		function updateStand($stand){
			$id = $stand['id'];
			$nome = $stand['newNome'];
			$luogo = $stand['newLuogo'];
			$query = "UPDATE stand SET nome = '$nome', luogo = '$luogo' WHERE id = '$id'";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
		}

		function deleteStand($id){
			$query = "DELETE FROM stand WHERE id = $id";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
		}
	}
?>
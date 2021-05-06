<?php
	include_once "databasemodel.php";
	class AdministratorModel{
		/**
		 * 
		 * Ritorna le informazioni di tutti gli utenti.
		 * 
		 * @return array Le informazioni degli utenti.
		 * 
		 */
		function fetchUsers(){
			$query = "SELECT username, nome, cognome, isOwner, isAdmin FROM utente";
			$users = DatabaseModel::executeSelectQuery($query);
			return $users;
		}

		/**
		 * 
		 * Ritorna le informazioni di un utente con lo username passato, se esiste.
		 * 
		 * @param string $username Il nome utente. 
		 * @return array Le informazioni dell'utente.
		 * 
		 */
		function fetchUser($username){
			$query = "SELECT username, nome, cognome, isOwner, isAdmin FROM utente WHERE username = '$username'";
			$user = DatabaseModel::executeSelectQuery($query);
			return $user;
		}
		
		/**
		 * 
		 * Modifica i valori di un utente.
		 * 
		 * @param string $username Il nome utente.
		 * @return string Un flag.
		 * 
		 */
		function updateUser($user){
			$username = $user['username'];
			$newUsername = $user['newUsername'];
			$nome = $user['newNome'];
			$cognome = $user['newCognome'];
			$isAdmin = $user['newIsAdmin'];
			$query = "UPDATE utente SET username = '$newUsername', nome = '$nome', cognome = '$cognome', isAdmin = $isAdmin WHERE username = '$username'";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
		}

		/**
		 * 
		 * Elimina l'utente con lo username passato, se esiste.
		 * 
		 * @param string $username Il nome utente.
		 * @return string Un flag.
		 * 
		 */
		function deleteUser($username){
			$query = "DELETE FROM utente WHERE username = '$username'";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
		}

		/**
		 * 
		 * Ritorna tutti gli stand.
		 * 
		 * @return array Gli stand.
		 * 
		 */
        function fetchStands(){
			$query = "SELECT * FROM stand";
			$stands = DatabaseModel::executeSelectQuery($query);
			return $stands;
		}
		
		/**
		 * 
		 * Ritorna lo stand con l'ID passato.
		 * 
		 * @param int $id L'id dello stand.
		 * @return array Lo stand.
		 * 
		 */
		function fetchStand($id){
			$query = "SELECT * FROM stand WHERE id = $id";
			$stand = DatabaseModel::executeSelectQuery($query);
			return $stand;
		}

		/**
		 * 
		 * Modifica i valori di uno stand.
		 * 
		 * @param array $stand Lo stand da modificare.
		 * @return string Un flag.
		 * 
		 */
		function updateStand($stand){
			$id = $stand['id'];
			$nome = $stand['newNome'];
			$luogo = $stand['newLuogo'];
			$query = "UPDATE stand SET nome = '$nome', luogo = '$luogo' WHERE id = '$id'";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
		}

		/**
		 * 
		 * Elimina lo stand con l'ID passato, se esiste.
		 * 
		 * @param int $id L'id dello stand.
		 * @return string Un flag.
		 * 
		 */
		function deleteStand($id){
			$query = "DELETE FROM stand WHERE id = $id";
			$flag = DatabaseModel::executeQuery($query);
			return $flag;
		}
	}
?>
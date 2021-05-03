<?php
	include_once "databasemodel.php";
	class GraphModel{
		private $camp = "data";

		function setCamp($filter){
			$camp = "data";
			if($filter != "default"){
				if($filter == "YEAR" || $filter == "DATE"){
					$camp = "$filter($camp)";
				}else{
					$camp = "DATE_FORMAT(data,'%Y-%m";
					if($filter == "HOUR" || $filter == "MINUTE"){
						$camp = $camp . "-%d %H";
					}
					if($filter == "MINUTE"){
						$camp = $camp . ":%i";
					}
					$camp = $camp . "')";
				}
			}
			$this->camp = $camp;
		}

        function fetchStands($proprietario){
			if($proprietario == ""){
				$query = "SELECT * FROM stand WHERE isPublic = 1";
			}else{
				$query = "SELECT * FROM stand WHERE proprietario = '$proprietario' OR isPublic = 1";
			}
			$stands = DatabaseModel::executeSelectQuery($query);
			if(is_array($stands)){
				$stand_ids = $this::fetchStandsWithStats($proprietario);
				if(is_array($stand_ids)){
					$standsWStats = array();
					foreach($stands as $stand){
						if(in_array($stand['id'], $stand_ids)){
							$standWStats[] = $stand;
						}
					}
					
					if(count($standWStats) != 0){
						return $standWStats;
					}else{
						return "EMPTY";
					}
				}
				return $stand_ids;
			}
			return $stands;
		}

		function fetchStandsWithStats($proprietario){
			if($proprietario == ""){
				$query = "SELECT DISTINCT(stand_id) FROM stat LEFT JOIN stand on stat.stand_id = stand.id WHERE isPublic = 1";
			}else{
				$query = "SELECT DISTINCT(stand_id) FROM stat LEFT JOIN stand on stat.stand_id = stand.id WHERE stand.proprietario = '$proprietario' OR isPublic = 1";
			}
			$stand_ids = DatabaseModel::executeSelectQuery($query);
            if(is_array($stand_ids)){
                $ids = array();
                foreach ($stand_ids as $stand_id) {
                    $ids[] = $stand_id['stand_id'];
                }
                return $ids;
            }
			return $stand_ids;
		}

		function fetchWebcams($stand_id){
			$query = "SELECT DISTINCT(num_webcam) FROM stat WHERE stand_id = $stand_id ORDER BY num_webcam;";
			$webcams = DatabaseModel::executeSelectQuery($query);
			return $webcams;
		}

		function fetchLabels($stand_id, $num_webcam){
			$camp = $this->camp;
			if($num_webcam != 0){
				$query = "SELECT $camp FROM stat WHERE stand_id = $stand_id AND num_webcam = $num_webcam GROUP BY $camp ORDER BY $camp";
			}else{
				$query = "SELECT $camp FROM stat WHERE stand_id = $stand_id GROUP BY $camp ORDER BY $camp";
			}
			$labels = DatabaseModel::executeSelectQuery($query);
			$result = "";
			foreach ($labels as $label) {
				$result = $result . "'" . $label["$camp"] . "'" . ", ";
			}
			return $result;
		}

		function fetchDataset($stand_id, $num_webcam){
			$camp = $this->camp;
			$query = "SELECT numero_persone FROM stat WHERE stand_id = $stand_id AND num_webcam = $num_webcam GROUP BY $camp ORDER BY $camp";
			$dataset = DatabaseModel::executeSelectQuery($query);
			$result = "";
			foreach ($dataset as $data) {
				$result = $result . $data['numero_persone'] . ", ";
			}
			return $result;
		}

		function fetchDatasetPie($stand_id){
			$query = "SELECT SUM(numero_persone) FROM stat WHERE stand_id = $stand_id GROUP BY num_webcam ORDER BY num_webcam";
			$dataset = DatabaseModel::executeSelectQuery($query);
			$result = "";
			foreach($dataset as $data) {
				$result = $result . $data['SUM(numero_persone)'] . ", ";
			}
			return $result;
		}
	}
?>
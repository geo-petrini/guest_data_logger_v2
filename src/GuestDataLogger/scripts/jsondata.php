<?php
    session_start();
    
    $database = require "database.php";

    $stand_id = $_GET['stand_id'];
    $filter = $_GET['data'];
    
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
            echo $camp;
        }
    }

    $query;
    if(isset($_GET['num_webcam'])){
        $num_webcam = $_GET['num_webcam'];
        $query1 = "SELECT  stand_id, num_webcam, $camp AS data, SUM(numero_persone) AS numero_persone FROM stat WHERE stand_id = $stand_id AND num_webcam = $num_webcam GROUP BY $camp ORDER BY $camp";
        $query2 = "SELECT  stat.stand_id, stat.num_webcam, $camp AS data, SUM(numero_persone) AS numero_persone FROM stat LEFT JOIN stand ON stat.stand_id = stand_id WHERE stat.stand_id = $stand_id AND stat.num_webcam = $num_webcam AND stand.isPublic = 1 GROUP BY $camp ORDER BY $camp";
    }else{
        $query1 = "SELECT  stand_id, num_webcam, $camp AS data, SUM(numero_persone) AS numero_persone FROM stat WHERE stand_id = $stand_id GROUP BY $camp, num_webcam ORDER BY num_webcam, $camp";
        $query2 = "SELECT  stat.stand_id, stat.num_webcam, $camp AS data, SUM(numero_persone) AS numero_persone FROM stat LEFT JOIN stand ON stat.stand_id = stand_id WHERE stat.stand_id = $stand_id AND stand.isPublic = 1 GROUP BY $camp ORDER BY $camp";
    }
    $mysqli = new mysqli($database[0], $database[1], $database[2], $database[3]);
    $query;
    if(isset($_SESSION['button'])){
        $query = $query1;
    }else{
        $query = $query2;
    }
    if(!$mysqli->connect_errno){
        $jsondata = array();
        if($select = $mysqli->query($query)){
            while ($row = $select->fetch_assoc()) {
                $jsondata[] = $row;
            }
            $json = json_encode($jsondata, JSON_FORCE_OBJECT);
            echo $json;
        }
    }
?>
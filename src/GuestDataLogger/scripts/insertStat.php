<?php
    $database = require "database.php";

    $json = file_get_contents('php://input');
    $values = json_decode($json, true);
    $chiave = $values['api_key'];
    $query = "SELECT stand_id, num_webcam FROM chiave WHERE chiave = '$chiave'";

    $mysqli = new mysqli($database[0], $database[1], $database[2], $database[3]);
    if(!$mysqli->connect_errno){
        if($select = $mysqli->query($query)){
            $result = $select->fetch_assoc();

            $stand_id = $result['stand_id'];
            $num_webcam = $result['num_webcam'];
            $data = $values['data'];
            $numero_persone = $values['num_persone'];
        
            $query = "INSERT INTO stat(data, numero_persone, stand_id, num_webcam) VALUES('$data', $numero_persone, $stand_id, $num_webcam)";
            $mysqli->query($query);
        }
    }
?>
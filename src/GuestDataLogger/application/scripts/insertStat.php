<?php
    $database = require "database.php";

    $json = file_get_contents('php://input');
    $values = json_decode($json, true);

    $query = "SELECT * FROM chiave WHERE chiave = '$chiave'";
    $result = DatabaseModel::executeSelectQuery($query)[0];

    $stand_id = $result['stand_id'];
    $num_webcam = $result['num_webcam'];
    $data = $values['data'];
    $numero_persone = $values['num_persone'];
    $chiave = $values['api_key'];

    $query = "INSERT INTO stat(data, numero_persone, stand_id, num_webcam) VALUES('$data', $numero_persone, $stand_id, $num_webcam)";
    $mysqli = new mysqli($database[0], $database[1], $database[2], $database[3]);
    if(!$mysqli->connect_errno){
        $mysqli->query($query);
    }

?>
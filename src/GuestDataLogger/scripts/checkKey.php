<?php
    $database = require "database.php";
    $json = file_get_contents('php://input');
    $values = json_decode($json, true);
    $chiave = $values['api_key'];
    $query = "SELECT chiave from chiave WHERE chiave = '$chiave'";
    $mysqli = new mysqli($database[0], $database[1], $database[2], $database[3]);
    if(!$mysqli->connect_errno){
        $result = array();
        if($select = $mysqli->query($query)){
            while ($row = $select->fetch_assoc()) {
                $result[] = $row;
            }
            $select->free();
            if(count($result) > 0){
                http_response_code(200);
                return;
            }else{
                http_response_code(400);
                return;
            }
        }
        http_response_code(503);
        return;
    }else{
        http_response_code(503);
        return;
    }
?>
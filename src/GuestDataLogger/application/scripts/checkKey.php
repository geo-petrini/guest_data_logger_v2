<?php
    $database = require "database.php";

    $json = file_get_contents('php://input');
    $values = json_decode($json, true);
    $chiave = $values['api_key'];
    $query = "SELECT * from chiave WHERE chiave = '$chiave'";
    $mysqli = new mysqli($database[0], $database[1], $database[2], $database[3]);
    if(!$mysqli->connect_errno){
        http_response_code(503);
    }else{
        if($mysqli->query($query) == 1){
            header("HTTP/1.1 386 OK");
        }else{
            http_response_code(400);
        }
    }
?>
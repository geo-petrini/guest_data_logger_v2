<?php
session_start();
$database = require "database.php";

$input = filter_input_array(INPUT_POST);
if ($input['action'] == 'edit') {
    $update_field='';
    if(isset($input['nome'])) {
        $index = "firstname";
        $value = $input['nome'];
        $update_field.= "nome='".$input['nome']."'";
    } else if(isset($input['cognome'])) {
        $index = "lastname";
        $value = $input['cognome'];
        $update_field.= "cognome='".$input['cognome']."'";
    }
    if($update_field && isset($input['username'])) {
        $username =strval($input['username']);
        $query = "UPDATE utente SET $update_field WHERE username='$username'";
        $mysqli = new mysqli($database[0], $database[1], $database[2], $database[3]);
        if(!$mysqli->connect_errno){
            $mysqli->query($query);
            $_SESSION[$index] = $value;
        }
    }
}
?>
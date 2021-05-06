<?php
$database = require "database.php";
function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

$input = filter_input_array(INPUT_POST);
if ($input['action'] == 'edit') {
    $update_field='';
    if(isset($input['nome'])) {
        $update_field.= "nome='".$input['nome']."'";
    } else if(isset($input['luogo'])) {
        $update_field.= "luogo='".$input['luogo']."'";
    } else if(isset($input['data_inizio'])) {
        if(validateDate($input['data_inizio'])){
            $update_field.= "data_inizio='".$input['data_inizio']."'";
        }else{
            $update_field.= "data_inizio='".$input['data_inizio']."'";
        }
    } else if(isset($input['data_fine'])) {
        if(validateDate($input['data_fine'])){
            $update_field.= "data_fine='".$input['data_fine']."'";
        }else{
            $update_field.= "data_fine='".$input['data_fine']."'";
        }
    }
    if($update_field && $input['id']) {
        $stand_id = $input['id'];
        $query = "UPDATE stand SET $update_field WHERE id=$stand_id";
        $mysqli = new mysqli($database[0], $database[1], $database[2], $database[3]);
        if(!$mysqli->connect_errno){
            $mysqli->query($query);
        }
    }
}
?>
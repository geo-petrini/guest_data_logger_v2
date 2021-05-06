<?php

class Graph
{
  public function index()
  {
    session_start();
    if(isset($_SESSION['username'])){
        $proprietario = $_SESSION['username'];
    }else{
        $proprietario = "";
    }
    require 'application/models/graphmodel.php';
    $model = new GraphModel();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $filter = $_POST['filter'];
    }else{
        $filter = "id";
    }

    $stands = $model->fetchStands($proprietario, $filter);
    if(is_array($stands)){
        require 'application/views/shared/header.php';
        require 'application/views/shared/nav.php';
        require 'application/views/graph/index.php';
        require 'application/views/shared/footer.php';
    }else if($stands == "MYSQL"){
        header('Location:'.URL.'errors/databaseError');
    }else if($stands == "EMPTY"){
        header('Location:'.URL.'errors/noGraphs');
    }else{
        header('Location:'.URL.'errors/unexpectedError');
    }
  }

  public function showGraph(){
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $requestMethod = TRUE;
        $_SESSION['post'] = $_POST;
        $refresh = $_POST['refresh'];
        $sessionPost = FALSE;
    }else{
        $requestMethod = FALSE;
        if(isset($_SESSION['post'])){
            $sessionPost = TRUE;
            if($requestMethod == FALSE){
                $_POST = $_SESSION['post'];
                $sessionRgba = $_SESSION['rgba'];
                $sessionBgrgba = $_SESSION['bgrgba'];
                $webcams = $_SESSION['webcams'];
                $sessionLabels = $_SESSION['labels'];
                $refresh = $_POST['refresh'];
            }
        }else{
            $sessionPost = FALSE;
        }
    }

    if($requestMethod == FALSE && $sessionPost == FALSE){
        header('Location:'.URL.'home');
    }

    if(!isset($_POST['refresh'])){
        $refresh = 'yes';
    }else{
        $refresh = $_POST['refresh'];
    }

    if($refresh == "yes"){
        header('refresh: 15; url='.URL.'graph/ShowGraph');
    }

    require 'application/views/shared/header.php';
    require 'application/views/shared/nav.php';
    require 'application/models/graphmodel.php';
    $model = new GraphModel();

    $stand_id = $_POST['id'];
    if(!isset($_POST['type'])){
        $type = 'line';
    }else{
        $type = $_POST['type'];
    }

    if(!isset($_POST['datetime'])){
        $datetime = 'default';
    }else{
        $datetime = $_POST['datetime'];
    }

    require 'application/views/graph/graphForm.php';

    $model->setCamp($datetime);

    if(!isset($webcams)){
        $webcams = $model->fetchWebcams($stand_id);
        $_SESSION['webcams'] = $webcams;
    }
    $datasets = array();

    if($type == 'pie' || $type == "doughnut" || $type == "polarArea"){
        $num_webcam = " ";
        if($requestMethod == TRUE){
            $labels = " ";
            $rgba = "[ ";
            foreach($webcams as $webcam){
                $labels = "$labels'Webcam " . $webcam['num_webcam'] . "', ";
                $red = rand(0, 255);
                $green = rand(0, 255);
                $blue = rand(0, 255);
                $rgba = "$rgba'rgb($red, $green, $blue)', ";
            }
            $rgba = "$rgba]";
            $bgrgba = $rgba;
            
            $_SESSION['labels'] = $labels;
            $_SESSION['rgba'] = $rgba;
            $_SESSION['bgrgba'] = $bgrgba;
        }else{
            $rgba = $sessionRgba;
            $bgrgba = $sessionBgrgba;
            $labels = $sessionLabels;
        }

        $datasets[0] = $model->fetchDatasetPie($stand_id);
        require 'application/views/graph/graph.php';
    }else if($type == "tabledata"){
        $stats = $model->fetchDatasetTable($stand_id);
        require 'application/views/graph/tabledata.php';
    }else{
        if($requestMethod == TRUE){
            $sessionRgba = array();
            $sessionBgrgba = array();
            foreach ($webcams as $webcam) {
                $red = rand(0, 255);
                $green = rand(0, 255);
                $blue = rand(0, 255);
                $rgba = "'rgba($red, $green, $blue, 255)'";
                $sessionRgba[] = $rgba;
                $bgrgba = $rgba;
                $sessionBgrgba[] = $bgrgba;
                $num_webcam = $webcam['num_webcam'];
                $labels = $model->fetchLabels($stand_id, $num_webcam);
                $datasets[0] = $model->fetchDataset($stand_id, $num_webcam);
                require 'application/views/graph/graph.php';
            }
            $_SESSION['rgba'] = $sessionRgba;
            $_SESSION['bgrgba'] = $sessionBgrgba;
            $_SESSION['webcams'] = $webcams;
            $_SESSION['labels'] = "";
            $_SESSION['post'] = $_POST;
        }else{
            for ($i=0; $i < count($webcams); $i++) { 
                $rgba = $sessionRgba[$i];
                $bgrgba = $sessionBgrgba[$i];
                $webcam = $webcams[$i];
                $num_webcam = $webcam['num_webcam'];
                $labels = $model->fetchLabels($stand_id, $num_webcam);
                $datasets[0] = $model->fetchDataset($stand_id, $num_webcam);
                require 'application/views/graph/graph.php';
            }
        }
    }
    require 'application/views/shared/footer.php';
  }
}
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
    $stands = $model->fetchStands($proprietario);
    if(is_array($stands)){
        require 'application/views/shared/header.php';
        require 'application/views/shared/nav.php';
        require 'application/views/graph/index.php';
        require 'application/views/shared/footer.php';
    }else if($stands == "MYSQL"){
        header('Location:'.URL.'errors/databaseError');
    }else{
        header('Location:'.URL.'home');
    }
  }

  public function showGraph(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        session_start();
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
       

        require 'application/views/shared/header.php';
        require 'application/views/shared/nav.php';
        require 'application/views/graph/graphForm.php';

        require 'application/models/graphmodel.php';
        $model = new GraphModel();
        $model->setCamp($datetime);
        $webcams = $model->fetchWebcams($stand_id);
        $datasets = array();
        if($type == 'radar'){
            $labels = $model->fetchLabels($stand_id, 0);
            $datasets = array();
            $num_webcam = array();
            foreach ($webcams as $webcam) {
                $datasets[] = $model->fetchDataset($stand_id, $num_webcam);
                $num_webcam[] = $webcam['num_webcam'];
            }
            require 'application/views/graph/graph.php';
        }else{
            foreach ($webcams as $webcam) {
                $num_webcam = $webcam['num_webcam'];
                $labels = $model->fetchLabels($stand_id, $num_webcam);
                $datasets[0] = $model->fetchDataset($stand_id, $num_webcam);
                require 'application/views/graph/graph.php';
            }
        }
        require 'application/views/shared/footer.php';
    }else{
        header('Location:'.URL.'home');
    }
  }
}
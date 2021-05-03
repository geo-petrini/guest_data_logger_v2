<?php

class Stand
{
  public function index()
  {
    session_start();
    if(isset($_SESSION['owner']) && $_SESSION['owner'] == TRUE){
        require 'application/models/standmodel.php';

        $model = new StandModel();
        $stands = $model->fetchStands($_SESSION['username']);

        if(is_array($stands)){
            require 'application/models/graphmodel.php';

            $model = new GraphModel();
            $stand_ids = $model->fetchStandsWithStats($_SESSION['username']);
            if(is_array($stand_ids)){
                require 'application/views/shared/header.php';
                require 'application/views/shared/nav.php';
                require 'application/views/stand/index.php';
                require 'application/views/shared/footer.php';
            }else{
                header('Location:'.URL.'errors/databaseError');
            }
        }else if($stands == "MYSQL"){
            header('Location:'.URL.'errors/databaseError');
        }
    }else{
        header('Location:'.URL.'home');
    }
  }

  public function addStand()
  {
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require 'application/models/standmodel.php';
        $model = new StandModel();
        $result = $model->addStand($_POST);
        echo $result;
        if($result == TRUE && !is_string($result)){
            if($_SESSION['owner'] == FALSE){
                $result = $model->setOwner($_SESSION['username'], true);
                $_SESSION['owner'] = TRUE;
            }
            header('Location:'.URL.'home');
        }else if($result == "MYSQL"){
            header('Location:'.URL.'errors/databaseError');
        }else if($result == "DATE"){
            header('Location:'.URL.'errors/dateError');
        }else{
            header('Location:'.URL.'errors/databaseError');
        }
    }else{
        require 'application/views/shared/header.php';
        require 'application/views/shared/nav.php';
        require 'application/views/stand/addStand.php';
        require 'application/views/shared/footer.php';
    }
  }

  public function deleteStand()
  {
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require 'application/models/standmodel.php';
        $model = new StandModel();
        $flag = $model->deleteStand($_POST['id']);
        if($model->checkStands($_SESSION['username'])){
            $model->setOwner($_SESSION['username'], FALSE);
            $_SESSION['owner'] = FALSE;
        }
        if($flag == TRUE && !is_string($flag)){
            header('Location:'.URL.'stand');
        }else if($flag == "MYSQL"){
            header('Location:'.URL.'errors/databaseError');
        }
    }else{
        header('Location:'.URL.'home');
    }
  }

  public function togglePublic()
  {
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require 'application/models/standmodel.php';
        $model = new StandModel();
        $flag = $model->setPublic($_POST['id'], $_POST['val']);
        if($flag == TRUE && !is_string($flag)){
            header('Location:'.URL.'stand');
        }else if($flag == "MYSQL"){
            header('Location:'.URL.'errors/databaseError');
        }
    }else{
        header('Location:'.URL.'home');
    }
  }
}
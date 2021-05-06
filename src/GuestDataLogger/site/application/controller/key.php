<?php

class Key
{
  public function index()
  {
    session_start();
    if(isset($_SESSION['username'])){
        require "application/models/keymodel.php";
        $model = new KeyModel();
        $keys = $model->fetchKeysByOwner($_SESSION['username']);
        if(is_array($keys)){
            require 'application/views/shared/header.php';
            require 'application/views/shared/nav.php';
            require 'application/views/key/index.php';
            require 'application/views/shared/footer.php';
        }else if($keys == "MYSQL"){
            header('Location:'.URL.'errors/databaseError');
        }
    }else{
        header('Location:'.URL.'home');
    }
  }

  public function createKey()
  {
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])){
        require "application/functions/api.php";
        require "application/models/keymodel.php";

        $key = getKey();
        $model = new KeyModel();
        $flag = $model->insertKey($key, $_POST['id']);
        echo $flag;
        if($flag == TRUE && !is_string($flag)){
            header('Location:'.URL.'key');
        }else if($flag == "MYSQL"){
            header('Location:'.URL.'errors/databaseError');
        }else{
            header('Location:'.URL.'stand');
        }
    }else{
        header('Location:'.URL.'home');
    }
  }

  public function deleteKey()
  {
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require 'application/models/keymodel.php';
        $model = new KeyModel();
        $flag = $model->deleteKey($_POST['chiave']);
        if($flag == TRUE && !is_string($flag)){
            header('Location:'.URL.'key');
        }else if($flag == "MYSQL"){
            header('Location:'.URL.'errors/databaseError');
        }
    }else{
        header('Location:'.URL.'home');
    }
  }
}
<?php

class Login
{
  public function index()
  {
    session_start();
    require 'application/views/shared/header.php';
    require 'application/views/shared/nav.php';
    require 'application/views/login/index.php';
    require 'application/views/shared/footer.php';
  }

  public function checkLogin()
  {
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        session_start();
        require 'application/models/loginmodel.php';
        $model = new LoginModel();
        $username = $model->cleanInput($_POST['username']);
        $password = $_POST['password'];
        $result = $model->checkLogin($username, $password);
        if($result == TRUE){
            header('Location:'.URL.'home');
        }else if($result == FALSE){
            require 'application/views/shared/errorHeader.php';
            require 'application/views/login/loginError.php';
        }else if($result == "MYSQL"){
            require 'application/views/shared/errorHeader.php';
            require 'application/views/shared/databaseError.php';
        }
    }else{
        header('Location:'.URL.'home');
    }
  }
}
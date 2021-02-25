<?php

class Register
{
  public function index()
  {
    session_start();
    require 'application/views/shared/header.php';
    require 'application/views/shared/nav.php';
    require 'application/views/register/index.php';
    require 'application/views/shared/footer.php';
  }

  public function registerUser()
  {
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        session_start();
        require 'application/models/loginmodel.php';
        $model = new LoginModel();
        $username = $model->cleanInput($_POST['username']);
        $password = $_POST['password'];
        $result = $model->registerUser($username, $password);
        if($result == TRUE){
            header('Location:'.URL.'home');
        }else if($result == "USER"){
            require 'application/views/shared/errorHeader.php';
            require 'application/views/register/usernameError.php';
        }else if($result == "PASS"){
            require 'application/views/shared/errorHeader.php';
            require 'application/views/register/passwordError.php';
        }else if($result == "MYSQL"){
            require 'application/views/shared/errorHeader.php';
            require 'application/views/shared/databaseError.php';
        }
    }else{
        header('Location:'.URL.'home');
    }
  }
}
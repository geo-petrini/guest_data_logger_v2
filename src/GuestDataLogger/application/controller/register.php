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
        if($result == TRUE && !is_string($result)){
            header('Location:'.URL.'home');
        }else if($result == "USER"){
            header('Location:'.URL.'errors/registerError/usernameError');
        }else if($result == "PASS"){
            header('Location:'.URL.'errors/registerError/passwordError');
        }else if($result == "MYSQL"){
            header('Location:'.URL.'errors/databaseError');
        }else{
            header('Location:'.URL.'errors/registerError/usernameTakenError');
        }
    }else{
        header('Location:'.URL.'home');
    }
  }
}
<?php

class Administrator
{
  public function index()
  {
    session_start();
    if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){
        require 'application/views/shared/header.php';
        require 'application/views/shared/nav.php';
        require 'application/views/administrator/index.php';
        require 'application/views/shared/footer.php';
    }else{
        require 'application/views/shared/errorHeader.php';
        require 'application/views/administrator/administratorError.php';
    }
  }
  
  public function users()
  {
    if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){
        require 'application/models/administratormodel.php';
        $model = new AdministratorModel();
        $users = $model->fetchUsers();
        if(is_array($users)){
            require 'application/views/shared/header.php';
            require 'application/views/shared/nav.php';
            require 'application/views/administrator/users.php';
            require 'application/views/shared/footer.php';
        }else if($users == "MYSQL"){
            require 'application/views/shared/errorHeader.php';
            require 'application/views/shared/databaseError.php';
        }
    }else{
        require 'application/views/shared/errorHeader.php';
        require 'application/views/administrator/administratorError.php';
    }
  }

  public function stands()
  {
    if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){
        require 'application/models/administratormodel.php';
        $model = new AdministratorModel();
        $stands = $model->fetchStands();
        if(is_array($stands)){
            require 'application/views/shared/header.php';
            require 'application/views/shared/nav.php';
            require 'application/views/administrator/stands.php';
            require 'application/views/shared/footer.php';
        }else if($stands == "MYSQL"){
            require 'application/views/shared/errorHeader.php';
            require 'application/views/shared/databaseError.php';
        }
    }else{
        require 'application/views/shared/errorHeader.php';
        require 'application/views/administrator/administratorError.php';
    }
  }
}
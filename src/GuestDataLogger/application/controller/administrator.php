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
        header('Location:'.URL.'errors/administratorError');
    }
  }
  
  public function users()
  {
    session_start();
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
            header('Location:'.URL.'errors/databaseError');
        }
    }else{
        header('Location:'.URL.'errors/administratorError');
    }
  }

  public function modifyUser()
  {
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE && isset($_POST['username'])){
            require 'application/models/administratormodel.php';
            $model = new AdministratorModel();
            $user = $model->fetchUser($_POST['username'])[0];
            if(is_array($user)){
                require 'application/views/shared/header.php';
                require 'application/views/shared/nav.php';
                require 'application/views/administrator/user.php';
                require 'application/views/shared/footer.php';
            }else if($user == "MYSQL"){
                header('Location:'.URL.'errors/databaseError');
            }
        }else{
            header('Location:'.URL.'errors/administratorError');
        }
    }else{
        header('Location:'.URL.'home');
    }
  }

  public function updateUser()
  {
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){
            require 'application/models/administratormodel.php';
            $model = new AdministratorModel();
            $flag = $model->updateUser($_POST);
            if($flag == TRUE){
                header('Location:'.URL.'administrator/users');
            }else if($flag == "MYSQL"){
                header('Location:'.URL.'errors/databaseError');
            }
        }else{
            header('Location:'.URL.'errors/administratorError');
        }
    }else{
        header('Location:'.URL.'home');
    }
  }

  public function deleteUser()
  {
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){
            require 'application/models/administratormodel.php';
            $model = new AdministratorModel();
            $flag = $model->deleteUser($_POST['username']);
            if($flag == TRUE){
                header('Location:'.URL.'administrator/users');
            }else if($flag == "MYSQL"){
                header('Location:'.URL.'errors/databaseError');
            }
        }else{
            header('Location:'.URL.'errors/administratorError');
        }
    }else{
        header('Location:'.URL.'home');
    }
  }

  public function stands()
  {
    session_start();
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
            header('Location:'.URL.'errors/databaseError');
        }
    }else{
        header('Location:'.URL.'errors/administratorError');
    }
  }

  public function modifyStand()
  {
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE && isset($_POST['id'])){
            require 'application/models/administratormodel.php';
            $model = new AdministratorModel();
            $stand = $model->fetchStand($_POST['id'])[0];
            if(is_array($stand)){
                require 'application/views/shared/header.php';
                require 'application/views/shared/nav.php';
                require 'application/views/administrator/stand.php';
                require 'application/views/shared/footer.php';
            }else if($stand == "MYSQL"){
                header('Location:'.URL.'errors/databaseError');
            }
        }else{
            header('Location:'.URL.'errors/administratorError');
        }
    }else{
        header('Location:'.URL.'home');
    }
  }

  public function updateStand()
  {
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){
            require 'application/models/administratormodel.php';
            $model = new AdministratorModel();
            $flag = $model->updateStand($_POST);
            if($flag == TRUE){
                header('Location:'.URL.'administrator/stands');
            }else if($flag == "MYSQL"){
                header('Location:'.URL.'errors/databaseError');
            }
        }else{
            header('Location:'.URL.'errors/administratorError');
        }
    }else{
        header('Location:'.URL.'home');
    }
  }

  public function deleteStand()
  {
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){
            require 'application/models/administratormodel.php';
            $model = new AdministratorModel();
            $flag = $model->deleteStand($_POST['id']);
            if($flag == TRUE){
                header('Location:'.URL.'administrator/stands');
            }else if($flag == "MYSQL"){
                header('Location:'.URL.'errors/databaseError');
            }
        }else{
            header('Location:'.URL.'errors/administratorError');
        }
    }else{
        header('Location:'.URL.'home');
    }
  }
}
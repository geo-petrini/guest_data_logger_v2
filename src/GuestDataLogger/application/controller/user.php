<?php

class User
{
  public function index()
  {
    session_start();
    if(isset($_SESSION['username'])){
      require 'application/views/shared/header.php';
      require 'application/views/shared/nav.php';
      require 'application/models/usermodel.php';
      $model = new UserModel();
      $info = $model->fetchInfo($_SESSION['username']);
      if($info == "MYSQL"){
          header('Location:'.URL.'errors/databaseError');
      }
      require 'application/views/user/index.php';
      require 'application/views/shared/footer.php';
    }else{
      header('Location:'.URL.'errors/sessionError');
    }
  }
}
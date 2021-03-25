<?php

class Errors
{
  public function index()
  {
    header('Location:'.URL.'home');
  }

  public function databaseError(){
    require 'application/views/error/errorHeader.php';
    require 'application/views/error/databaseError.php';
  }

  public function loginError(){
    require 'application/views/error/errorHeader.php';
    require 'application/views/error/loginError.php';
  }

  public function registerError($type){
    require 'application/views/error/errorHeader.php';
    require 'application/views/error/'.$type.'.php';
  }

  public function administratorError(){
    require 'application/views/error/errorHeader.php';
    require 'application/views/error/administratorError.php';
  }
}
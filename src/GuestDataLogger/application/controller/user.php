<?php

class User
{
  public function index()
  {
    session_start();
    require 'application/views/shared/header.php';
    require 'application/views/shared/nav.php';
    require 'application/views/user/index.php';
    require 'application/views/shared/footer.php';
  }
}
<?php


if (session_status() == PHP_SESSION_NONE) {

  session_save_path("SESSION");

  session_start();
}

$link = mysqli_connect("localhost", "root", "", "shopping2324")
  or die("Unable to reach MySQL Server");
  
?> 
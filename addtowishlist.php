<?php
require_once("config.php");

if(!isset($_GET['id']))
 header("location:home.php");

if(!isset($_SESSION['id']))
  header("location:login.php");

$query="SELECT * FROM favorites WHERE client_id={$_SESSION['id']} and item_id= {$_GET['id']}";

$result = mysqli_query($link,$query);
if(mysqli_num_rows($result) == 0){

$query = "INSERT INTO favorites (client_id, item_id) VALUES({$_SESSION['id']}, {$_GET['id']})";

mysqli_query($link,$query);
}
else
echo "<script>alert('Already added')</script>";
header("location:wishlist.php");
?>
<?php
require_once("config.php");

if(!isset($_GET['id']))
 header("location:home.php");

if(!isset($_SESSION['id']))
  header("location:login.php");

$status = $_GET['status'];

$query="SELECT * FROM favorites WHERE (client_id={$_SESSION['id']} AND sale_item_id={$_GET['id']} AND status='$status') OR (client_id={$_SESSION['id']} AND rent_item_id={$_GET['id']} AND status='$status')";
$result = mysqli_query($link,$query);
if(mysqli_num_rows($result) == 0){

  if($status == 'sale') {
    $query = "INSERT INTO favorites (client_id, status, sale_item_id, rent_item_id) VALUES({$_SESSION['id']}, '$status', {$_GET['id']}, null)";
    mysqli_query($link,$query);
  } elseif($status == 'rent') {
    $query = "INSERT INTO favorites (client_id, status, sale_item_id, rent_item_id) VALUES({$_SESSION['id']}, '$status', null, {$_GET['id']})";
    mysqli_query($link,$query);
  }
  header("location:wishlist.php");
}
else{
  echo "<script>alert('Already added')</script>";
  echo "<script>
    setTimeout(function() {
      window.location.href = 'wishlist.php?';
    }, 500);
  </script>";
}
?>
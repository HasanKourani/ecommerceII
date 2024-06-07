<?php
require_once("config.php");
require_once("adminNav.php");

if(!isset($_GET['id']))
header("location:adminProducts.php");

$delete = "DELETE FROM cars WHERE id = {$_GET['id']}";
$result = mysqli_query($link, $delete);

if($result){
    header("location:adminProducts.php");
}
?>
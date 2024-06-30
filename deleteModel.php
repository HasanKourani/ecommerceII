<?php
require_once("config.php");
require_once("adminNav.php");

if(!isset($_GET['id']))
header("location:models.php");

$delete = "DELETE FROM car_models WHERE id = {$_GET['id']}";
$result = mysqli_query($link, $delete);

if($result){
    header("location:models.php");
}
?>
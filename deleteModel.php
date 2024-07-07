<?php
require_once("config.php");

if(!isset($_GET['id']))
header("location:models.php");

$delete = "DELETE FROM car_models WHERE id = {$_GET['id']}";
$delete1 = "DELETE FROM carsforsale WHERE model_id={$_GET['id']}";
$delete2 = "DELETE FROM carsforrent WHERE model_id={$_GET['id']}";
$result2 = mysqli_query($link, $delete2);
$result1 = mysqli_query($link, $delete1);
$result = mysqli_query($link, $delete);

if($result){
    header("location:models.php");
}
?>
<?php
require_once("config.php");

if(!isset($_GET['id']))
header("location:adminProducts.php");

if($_GET['status']=='sale'){

    $delete = "DELETE FROM carsforsale WHERE id = {$_GET['id']}";
    $delete1 = "DELETE FROM reviews WHERE sale_item_id = {$_GET['id']}";
    $delete2 = "DELETE FROM favorites WHERE sale_item_id = {$_GET['id']}";
    $delete3 = "DELETE FROM order_items WHERE item_id = {$_GET['id']}";
    $result3 = mysqli_query($link, $delete3);
    $result2 = mysqli_query($link, $delete2);
    $result1 = mysqli_query($link, $delete1);
    $result = mysqli_query($link, $delete);

} elseif($_GET['status']=='rent') {
    $delete = "DELETE FROM carsforrent WHERE id = {$_GET['id']}";
    $delete1 = "DELETE FROM reviews WHERE rent_item_id = {$_GET['id']}";
    $delete2 = "DELETE FROM favorites WHERE rent_item_id = {$_GET['id']}";
    $delete3 = "DELETE FROM rent_items WHERE item_id = {$_GET['id']}";
    $result3 = mysqli_query($link, $delete3);
    $result2 = mysqli_query($link, $delete2);
    $result1 = mysqli_query($link, $delete1);
    $result = mysqli_query($link, $delete);
}

if($result){
    header("location:adminProducts.php");
}
?>
<?php
require_once"config.php";

if(!isset($_GET['id']))
header("location:models.php");

$model_id = $_GET['id'];

$deleteOrderItems = "DELETE FROM order_items WHERE item_id IN (SELECT id FROM carsforsale WHERE model_id = {$model_id})";
mysqli_query($link, $deleteOrderItems);

$deleteRentItems = "DELETE FROM rent_items WHERE item_id IN (SELECT id FROM carsforrent WHERE model_id = {$model_id})";
mysqli_query($link, $deleteOrderItems);

$deleteFavoritesSale = "DELETE FROM favorites WHERE sale_item_id IN (SELECT id FROM carsforsale WHERE model_id = {$model_id})";
mysqli_query($link, $deleteFavoritesSale);

$deleteFavoritesRent = "DELETE FROM favorites WHERE rent_item_id IN (SELECT id FROM carsforrent WHERE model_id = {$model_id})";
mysqli_query($link, $deleteFavoritesRent);

$deleteReviewsSale = "DELETE FROM reviews WHERE sale_item_id IN (SELECT id FROM carsforsale WHERE model_id = {$model_id})";
mysqli_query($link, $deleteReviewsSale);

$deleteReviewsRent = "DELETE FROM reviews WHERE rent_item_id IN (SELECT id FROM carsforrent WHERE model_id = {$model_id})";
mysqli_query($link, $deleteReviewsRent);

$deleteFromCarsForSale = "DELETE FROM carsforsale WHERE model_id = {$model_id}";
mysqli_query($link, $deleteFromCarsForSale);

$deleteFromCarsForRent = "DELETE FROM carsforrent WHERE model_id = {$model_id}";
mysqli_query($link, $deleteFromCarsForRent);

$deleteModel = "DELETE FROM car_models WHERE id = {$model_id}";
$result = mysqli_query($link, $deleteModel);

if($result){
    header("location:models.php");
}
?>
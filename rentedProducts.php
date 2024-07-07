<?php

require_once("config.php");
require_once("adminNav.php");

$sql = "SELECT ri.*, c.* FROM rent_items ri JOIN cars c ON ri.item_id = c.id WHERE rented=1";
$result = mysqli_query($link, $sql);
echo "<div class='w-100 m-5'>";
echo "<h1 class='text-center text-dark mb-5'> Rented Cars </h1>";
echo "<div class='container d-flex flex-wrap justify-content-around align-items-center'>";
while($row = mysqli_fetch_array($result)) {
    echo "
    <div class='card m-2 p-2 bg-dark' style='width:300px;'>
      <img class='card-img-top' src='image/{$row['photo']}' alt='Card image' style='width:100%'>
      <div class='card-body'>
        <h4 class='card-title text-white'>{$row['carName']}</h4>
        <h5 class='card-title text-white'>Rent Duration: {$row['duration']} Days</h5>
        <h5 class='card-title text-white'>Rented Until: {$row['finalDate']}</h5>
      </div>
    </div>";
}
echo "</div>";
echo "</div>";
?>
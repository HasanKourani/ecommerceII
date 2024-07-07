<?php

require_once("config.php");
require_once("adminNav.php");


$sql = "SELECT * FROM car_models";
$result = mysqli_query($link, $sql);
echo "<div class='w-100 m-5'>";
echo "<p class='text-center mb-5'><a href='addModel.php' class='btn btn-primary fs-4'>ADD A NEW MODEL</a></p>";
echo "<h1 class='text-center text-dark'> AVAILABLE MODELS </h1>";
echo "<div class='container d-flex flex-wrap justify-content-around align-items-center'>";
while($row = mysqli_fetch_array($result)){
    echo "
      <div class='card m-2 p-2 bg-dark' style='width:300px;'>
        <img class='card-img-top' src='image/{$row['modelPhoto']}' alt='Card image' style='width:100%'>
        <div class='card-body'>
          <h4 class='card-title text-white'>{$row['modelName']}</h4>
          <div class='d-flex flex-column'>
            <a href= 'editModel.php?id={$row['id']}' class='btn btn-primary'>EDIT</a>
            <a href='deleteModel.php?id={$row['id']}' class='btn btn-primary mt-2'>DELETE</a>
          </div>
        </div>
      </div>";
}
echo "</div>";
echo "</div>";
?>
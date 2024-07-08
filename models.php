<?php

require_once("config.php");
require_once("adminNav.php");


$sql = "SELECT * FROM car_models";
$result = mysqli_query($link, $sql);
echo "<div class='w-100 m-5'>";
if(mysqli_num_rows($result)>0) {
  echo "<div class='d-flex justify-content-between align-items-center mb-5'>";
  echo "<h1 class='text-center text-dark'> AVAILABLE MODELS </h1>";
  echo "<a href='addModel.php' class='btn btn-primary fs-4'>ADD A NEW MODEL</a>
  </div>";
echo "<div class='d-flex flex-wrap justify-content-start align-items-center'>";
while($row = mysqli_fetch_array($result)){
    echo "
      <div class='card m-1 p-2 bg-dark' style='width:300px;'>
        <img class='card-img-top' src='image/{$row['modelPhoto']}' alt='Card image' style='height:200px; object-fit:cover;'>
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
} else {
  echo"
  <div class='d-flex justify-content-center align-items-center'>
    <h2 class='text-danger'>Models Unavailable</h2>
  </div>";
}
echo "</div>";
?>
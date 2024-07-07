<?php

require_once("config.php");
require_once("adminNav.php");

if(isset($_POST['submit'])){
  $update = "UPDATE rent_items SET returned=1 WHERE item_id={$_POST['id']}";
  mysqli_query($link, $update);
  $update1 = "UPDATE carsforrent SET rented=0 WHERE id={$_POST['id']}";
  mysqli_query($link, $update1);
}



$sql = "SELECT ri.*, c.* FROM rent_items ri JOIN carsforrent c ON ri.item_id = c.id WHERE rented=1 AND returned=0";
$result = mysqli_query($link, $sql);
echo "<div class='w-100 m-5'>";
if(mysqli_num_rows($result) > 0){
  echo "<h1 class='text-center text-dark mb-5'> Rented Cars </h1>";
  echo "<div class='container d-flex flex-wrap justify-content-start align-items-center'>";
  while($row = mysqli_fetch_array($result)) {
      echo "
      <div class='card m-2 p-2 bg-dark' style='width:300px;'>
        <img class='card-img-top' src='image/{$row['photo']}' alt='Card image' style='height:300px; object-fit:cover;'>
        <div class='card-body'>
          <h4 class='card-title text-white'>{$row['carName']}</h4>
          <h5 class='card-title text-white'>Rent Duration: {$row['duration']} Days</h5>
          <h5 class='card-title text-white'>Rented Until: {$row['finalDate']}</h5>";
          if($row['finalDate'] < date("Y-m-d")){
            echo"
          <form action='' method='post'>
            <input type='hidden' name='id' value='{$row['id']}'>
            <button type='submit' name='submit' class='btn btn-success mt-2'>Confirm Car Return</button>
          </form>";
          }
      echo
      "</div>
      </div>";
  }
  echo "</div>";
} else {
  echo"
  <div class='d-flex justify-content-center align-items-center'>
    <h1 class='text-danger'>No Cars Rented</h1>
  </div>";
}
echo "</div>";
?>
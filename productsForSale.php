<?php

require_once("config.php");
require_once("nav.php");

$sql = "SELECT * FROM carsforsale";
if(isset($_GET['id']))
  $sql .= " WHERE model_id = {$_GET['id']}";

if(isset($_GET['txtSearch'])) {
  if(strlen($_GET['txtSearch']) >= 3){
    if(isset($_GET['id'])){
      $sql .= " and ";
    } else {
      $sql .=" WHERE ";
    }
      $sql .="(carName like '%{$_GET['txtSearch']}%')";
  } else {
    echo 
    "<div class='alert alert-info alert-dismissible'>
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Info!</strong> Please enter at least 3 characters for the search.
    </div>";
    exit;
  }
}
$result = mysqli_query($link,$sql);
 if( mysqli_num_rows($result)==0){
  echo "<div class='alert alert-danger alert-dismissible'>
  <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
  <strong>Error!</strong> NO ITEMS FOUND
  </div>
  <button type='button' class='btn btn-primary btn-lg'><a href='productsForSale.php' class='text-white text-decoration-none'>CHECK OTHER CARS</a></button>
  ";
} else {
  echo "<h1 class='mb-5'>Cars For Sale</h1>";
  echo "<div class='featured-cars d-flex justify-content-start align-items-center flex-wrap'>";
  while ($row= mysqli_fetch_array($result)){

    if($row['stock'] > 0) {
      echo "
      <div class='card text-bg-dark' style='width:300px; float:left; margin:5px;'>
        <img class='card-img-top'src='image/{$row['photo']}' alt='Card image' style='height:300px; object-fit:cover;'>
        <div class='card-body'>
          <h4 class='card-title'>{$row['carName']}</h4>
          <p class='card-text '>$ {$row['carPrice']}</p>
          <p class='card-text'>" . 
            (strlen($row['description']) > 50 ? substr($row['description'], 0, 50) . '...' : $row['description']) . 
          "</p>
          <div class='d-flex align-items-center justify-content-start'>
            <a href= 'itemsForSale.php?id={$row['id']}' class='btn btn-primary me-3'>View Car</a>
            <a href='addtowishlist.php?id={$row['id']}&status=sale' class='btn btn-primary'>Add to wishlist <i class='fa-solid fa-heart'></i></a>
          </div>
        </div>
      </div>";
    } else {
      echo "
      <div class='d-flex flex-column align-items-center'>
        <h3 class='text-danger'> OUT OF STOCK </h3>
        <div class='card text-bg-dark opacity-50' style='width:300px; float:left; margin:5px;'>
          <img class='card-img-top'src='image/{$row['photo']}' alt='Card image' style='height:300px; object-fit:cover;'>
          <div class='card-body'>
            <h4 class='card-title'>{$row['carName']}</h4>
            <p class='card-text '>$ {$row['carPrice']}</p>
            <p class='card-text'>" . 
              (strlen($row['description']) > 50 ? substr($row['description'], 0, 50) . '...' : $row['description']) . 
            "</p>
            <div class='d-flex align-items-center justify-content-start'>
              <a href= 'itemsForSale.php?id={$row['id']}' class='btn btn-primary me-3 disabled'>View Car</a>
              <a href='addtowishlist.php?id={$row['id']}&status=sale' 
              class='btn btn-primary disabled'>Add to wishlist <i class='fa-solid fa-heart'></i></a>
            </div>
          </div>
        </div>
      </div>";
    }
  }

  echo "</div>";

}
?>
</div>

<?php
require_once("footer.php")
?>
</body>
</html>
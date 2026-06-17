<?php

require_once"config.php";
require_once"adminNav.php";

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

$result = mysqli_query($link, $sql);
echo "<div class='w-100 m-5'>";
echo "<div class='d-flex justify-content-between align-items-center mb-5'>";
echo "<a href='addProduct.php?status=sale' class='btn btn-primary fs-4'>ADD A NEW PRODUCT</a>";
  if(mysqli_num_rows($result)>0) {
    echo "<h1 class='text-dark'> For Sale Cars In Stock </h1>
</div>";
  echo "<div class='d-flex flex-wrap justify-content-start align-items-center'>";
  while($row = mysqli_fetch_array($result)){
      echo "
        <div class='card m-1 p-2 bg-dark' style='width:300px;'>
          <img class='card-img-top' src='image/{$row['photo']}' alt='Card image' style='height:300px; object-fit:cover;'>
          <div class='card-body'>
            <h4 class='card-title text-white'>{$row['carName']}</h4>
            <div class='d-flex flex-column'>
              <a href= 'editProduct.php?id={$row['id']}&status=sale' class='btn btn-primary'>EDIT</a>
              <a href='deleteProduct.php?id={$row['id']}&status=sale' class='btn btn-primary mt-2'>DELETE</a>
            </div>
          </div>
        </div>";
  }
  echo "</div>";
} else {
  echo"
  <div class='d-flex justify-content-center align-items-center'>
    <h2 class='text-danger'>No Cars Available In Stock</h2>
  </div>";
}
echo "</div>";
?>
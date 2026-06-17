<?php 

require_once"config.php";
require_once"nav.php";


$sql = "SELECT * FROM carsforrent";
$sql1 = "SELECT * FROM carsforsale";

if (isset($_GET['id'])) {
    $sql .= " WHERE model_id = {$_GET['id']}";
    $sql1 .= " WHERE model_id = {$_GET['id']}";
}

if(isset($_GET['txtSearch'])) {
  if(strlen($_GET['txtSearch']) >= 3){
    if(isset($_GET['id'])){
      $sql .= " and ";
      $sql1 .= " and ";
    } else {
      $sql .=" WHERE ";
      $sql1 .=" WHERE ";
    }
      $sql .="(carName like '%{$_GET['txtSearch']}%')";
      $sql1 .="(carName like '%{$_GET['txtSearch']}%')";
  } else {
    echo 
    "<div class='alert alert-info alert-dismissible'>
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Info!</strong> Please enter at least 3 characters for the search.
    </div>";
    exit;
  }
}


if(isset($_GET['filteredSearch'])) {

    if (!empty($_GET['model']) && $_GET['model'] !== 'Models') {
        $sql .= " WHERE model_id LIKE '%{$_GET['model']}%'";
        $sql1 .= " WHERE model_id LIKE '%{$_GET['model']}%'";
    }

    if (!empty($_GET['condition']) && $_GET['condition'] !== 'Condition') {
        $sql1 .= " AND carStatus LIKE '%{$_GET['condition']}%'";
    }

    if (!empty($_GET['gear']) && $_GET['gear'] !== 'Gear') {
        $sql .= " AND gearType LIKE '%{$_GET['gear']}%'";
        $sql1 .= " AND gearType LIKE '%{$_GET['gear']}%'";
    }

    if (!empty($_GET['yearFrom']) && !empty($_GET['yearTo'])) {
        $sql .= " AND carYear BETWEEN {$_GET['yearFrom']} AND {$_GET['yearTo']}";
        $sql1 .= " AND carYear BETWEEN {$_GET['yearFrom']} AND {$_GET['yearTo']}";
    }

    if (!empty($_GET['from']) && !empty($_GET['to'])) {
        $sql1 .= " AND carPrice BETWEEN {$_GET['from']} AND {$_GET['to']}";
    }
}

$result = mysqli_query($link,$sql);
$result1 = mysqli_query($link,$sql1);

 if( mysqli_num_rows($result)==0 && mysqli_num_rows($result1)==0){
  echo "<div class='alert alert-danger alert-dismissible'>
  <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
  <strong>Error!</strong> NO ITEMS FOUND
  </div>
  <button type='button' class='btn btn-primary btn-lg'><a href='productsForRent.php' class='text-white text-decoration-none'>CHECK OTHER CARS</a></button>
  ";
} else {
  echo "<h1 class='mb-5'>FOR RENT</h1>";
  echo "<div class='featured-cars d-flex justify-content-start align-items-center flex-wrap'>";
  while ($row= mysqli_fetch_array($result)){

    if($row['rented']==0){
  
      echo "
      <div class='card text-bg-dark' style='width:300px; float:left; margin:5px;'>
        <img class='card-img-top'src='image/{$row['photo']}' alt='Card image' style='height:300px; object-fit:cover;'>
        <div class='card-body'>
          <h4 class='card-title'>{$row['carName']}</h4>
          <p class='card-text '>Fee/Day: {$row['rentFee']}$</p>
          <p class='card-text'>" . 
            (strlen($row['description']) > 50 ? substr($row['description'], 0, 50) . '...' : $row['description']) . 
          "</p>
          <div class='d-flex align-items-center justify-content-start'>
            <a href= 'itemsForRent.php?id={$row['id']}' class='btn btn-primary me-3'>View Car</a>
            <a href='addtowishlist.php?id={$row['id']}&status=rent' class='btn btn-primary'>Add to wishlist <i class='fa-solid fa-heart'></i></a>
          </div>
        </div>
      </div>";

    } else {
      echo "
      <div class='d-flex flex-column align-items-center'>
        <h3 class='text-danger'> CURRENTLY RENTED </h3>
        <div class='card text-bg-dark opacity-50' style='width:300px; float:left; margin:5px;'>
          <img class='card-img-top'src='image/{$row['photo']}' alt='Card image' style='height:300px; object-fit:cover;'>
          <div class='card-body'>
            <h4 class='card-title'>{$row['carName']}</h4>
            <p class='card-text '>Fee/Day: {$row['rentFee']}$</p>
            <p class='card-text'>" . 
              (strlen($row['description']) > 50 ? substr($row['description'], 0, 50) . '...' : $row['description']) . 
            "</p>
            <div class='d-flex align-items-center justify-content-start'>
              <a href= 'itemsForRent.php?id={$row['id']}' class='btn btn-primary me-3 disabled'>View Car</a>
              <a href='addtowishlist.php?id={$row['id']}&status=rent' 
              class='btn btn-primary disabled'>Add to wishlist <i class='fa-solid fa-heart'></i></a>
            </div>
          </div>
        </div>
      </div>";
    }
  }
  echo "</div>";

  echo "<h1 class='mb-5'>FOR SALE</h1>";
  echo "<div class='featured-cars d-flex justify-content-start align-items-center flex-wrap'>";
    while ($row1= mysqli_fetch_array($result1)){

        if($row1['sold'] == 0 && $row1['booked']==0) {
        echo "
        <div class='card text-bg-dark' style='width:300px; float:left; margin:5px;'>
            <img class='card-img-top'src='image/{$row1['photo']}' alt='Card image' style='height:300px; object-fit:cover;'>
            <div class='card-body'>
            <h4 class='card-title'>{$row1['carName']}</h4>
            <p class='card-text '>$ {$row1['carPrice']}</p>
            <p class='card-text'>" . 
                (strlen($row1['description']) > 50 ? substr($row1['description'], 0, 50) . '...' : $row1['description']) . 
            "</p>
            <div class='d-flex align-items-center justify-content-start'>
                <a href= 'itemsForSale.php?id={$row1['id']}' class='btn btn-primary me-3'>View Car</a>
                <a href='addtowishlist.php?id={$row1['id']}&status=sale' class='btn btn-primary'>Add to wishlist <i class='fa-solid fa-heart'></i></a>
            </div>
            </div>
        </div>";
        } elseif($row1['sold'] == 1) {
        echo "
        <div class='d-flex flex-column align-items-center'>
            <h3 class='text-danger'> SOLD </h3>
            <div class='card text-bg-dark opacity-50' style='width:300px; float:left; margin:5px;'>
            <img class='card-img-top'src='image/{$row1['photo']}' alt='Card image' style='height:300px; object-fit:cover;'>
            <div class='card-body'>
                <h4 class='card-title'>{$row1['carName']}</h4>
                <p class='card-text '>$ {$row1['carPrice']}</p>
                <p class='card-text'>" . 
                (strlen($row1['description']) > 50 ? substr($row1['description'], 0, 50) . '...' : $row1['description']) . 
                "</p>
                <div class='d-flex align-items-center justify-content-start'>
                <a href= 'itemsForSale.php?id={$row1['id']}' class='btn btn-primary me-3 disabled'>View Car</a>
                <a href='addtowishlist.php?id={$row1['id']}&status=sale' 
                class='btn btn-primary disabled'>Add to wishlist <i class='fa-solid fa-heart'></i></a>
                </div>
            </div>
            </div>
        </div>";
        } elseif($row1['booked']==1) {
          echo "
          <div class='d-flex flex-column align-items-center'>
              <h3 class='text-danger'> BOOKED </h3>
              <div class='card text-bg-dark opacity-50' style='width:300px; float:left; margin:5px;'>
              <img class='card-img-top'src='image/{$row1['photo']}' alt='Card image' style='height:300px; object-fit:cover;'>
              <div class='card-body'>
                  <h4 class='card-title'>{$row1['carName']}</h4>
                  <p class='card-text '>$ {$row1['carPrice']}</p>
                  <p class='card-text'>" . 
                  (strlen($row1['description']) > 50 ? substr($row1['description'], 0, 50) . '...' : $row1['description']) . 
                  "</p>
                  <div class='d-flex align-items-center justify-content-start'>
                  <a href= 'itemsForSale.php?id={$row1['id']}' class='btn btn-primary me-3 disabled'>View Car</a>
                  <a href='addtowishlist.php?id={$row1['id']}&status=sale' 
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
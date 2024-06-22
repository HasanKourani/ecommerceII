<?php 
require_once("nav.php");
require_once("config.php");

$sql = "SELECT * FROM cars WHERE stock>0";
if(isset($_GET['id']))
$sql .= " and model_id = {$_GET['id']}";

if(isset($_GET['txtSearch'])) {
  if(strlen($_GET['txtSearch']) >= 3){
    if(isset($_GET['id'])){
    $sql .= " and ";
    } else {
    $sql .=" where ";
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
  <button type='button' class='btn btn-primary btn-lg'><a href='products.php' class='text-white text-decoration-none'>CHECK OTHER CARS</a></button>
  ";
} else {
  echo "<h2>Available Cars</h2>";
  echo "<div class='featured-cars d-flex justify-content-around align-items-center flex-wrap'>";
  while ($row= mysqli_fetch_array($result)){
  
      echo "
      <div class='card text-bg-dark' style='width:300px; float:left; margin:5px;'>
        <img class='card-img-top'src='image/{$row['photo']}' alt='Card image' style='width:100%'>
        <div class='card-body'>
          <h4 class='card-title'>{$row['carName']}</h4>
          <p class='card-text '>$ {$row['carPrice']}</p>
          <p class='card-text'>" . 
            (strlen($row['description']) > 50 ? substr($row['description'], 0, 50) . '...' : $row['description']) . 
          "</p>
          <div class='d-flex align-items-center justify-content-evenly'>
            <a href= 'item.php?id={$row['id']}' class='btn btn-primary'>View Car</a>
            <a href='addtowishlist.php?id={$row['id']}' class='btn btn-primary'>Add to wishlist <i class='fa-solid fa-heart'></i></a>
          </div>
        </div>
      </div>";
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
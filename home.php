<?php
    require_once("config.php");
    require_once("nav.php");

    echo "
      <div class='d-flex flex-column justify-content-around align-items-center text-white mb-5'
        style='background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url(image/carousel1.jpg);
        width: 100%; height: 100vh; background-repeat: no-repeat; background-size: cover;'>
        <h1>Buy Your Dream Car Today!</h1>
      </div>
      ";

    $sql = "SELECT * FROM carsforsale WHERE stock>0 LIMIT 4";
    $result = mysqli_query($link, $sql);
    echo"<h1 class='mb-5 mt-2'>Featured Cars For Sale</h1>";
    if(mysqli_num_rows($result)>1) {
      echo "<div class='featured-cars d-flex justify-content-start align-items-center'>";
      while ($row= mysqli_fetch_array($result)){
    
        echo "
            <div class='card text-bg-dark' style='width:300px; float:left; margin:5px;'>
              <img class='card-img-top'src='image/{$row['photo']}' alt='Card image' style='height:300px; object-fit:cover;'>
              <div class='card-body'>
                <h4 class='card-title'>{$row['carName']}</h4>
                <p class='card-text '>$ {$row['carPrice']}</p>
                <p class='card-text'>" . 
                  (strlen($row['description']) > 50 ? substr($row['description'], 0, 50) . '...' : $row['description']) . 
                "</p>
                <a href= 'itemsForSale.php?id={$row['id']}' class='btn btn-primary'>View Car</a>
                <a href='addtowishlist.php?id={$row['id']}&status=sale' class='btn btn-primary m-2'>Add to wishlist <i class='fa-solid fa-heart'></i></a>
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
    $sql2 = "SELECT * FROM carsforrent WHERE rented=0 LIMIT 4";
    $result2 = mysqli_query($link, $sql2);
    echo"<h1 class='mt-5 mb-5'>Featured Cars For Rent</h1>";
    if(mysqli_num_rows($result2)>1){
      echo "<div class='featured-cars d-flex justify-content-start align-items-center'>";
      while ($row2= mysqli_fetch_array($result2)){
    
        echo "
            <div class='card text-bg-dark' style='width:300px; float:left; margin:5px;'>
              <img class='card-img-top'src='image/{$row2['photo']}' alt='Card image' style='height:300px; object-fit:cover;'>
              <div class='card-body'>
                <h4 class='card-title'>{$row2['carName']}</h4>
                <p class='card-text '>Fee/Day: {$row2['rentFee']}$</p>
                <p class='card-text'>" . 
                  (strlen($row2['description']) > 50 ? substr($row2['description'], 0, 50) . '...' : $row2['description']) . 
                "</p>
                <a href= 'itemsForRent.php?id={$row2['id']}' class='btn btn-primary'>View Car</a>
                <a href='addtowishlist.php?id={$row2['id']}&status=rent' class='btn btn-primary m-2'>Add to wishlist <i class='fa-solid fa-heart'></i></a>
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
    $sql1 = "SELECT * FROM car_models LIMIT 4";
    $result1 = mysqli_query($link, $sql1);
    echo "<h1 class='mt-5'>Featured Models</h1>";
    if(mysqli_num_rows($result1)>1){
      echo "<div class='featured-models d-flex justify-content-start align-items-center'>";
      
      while ($row1= mysqli_fetch_array($result1)){
        echo "
            <div class='card text-bg-dark' style='width:300px; float:left; margin:5px;'>
              <img class='card-img-top'src='image/{$row1['modelPhoto']}' alt='Card image' style='height:200px; object-fit:cover;'>
              <div class='card-body'>
                <h4 class='card-title'>{$row1['modelName']}</h4>
                <a href= 'productsForSale.php?id={$row1['id']}' class='btn btn-primary'>View Models</a>
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
?>
</div>

<?php
require_once("footer.php")
?>
</body>
</html>
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

    $sql = "SELECT * FROM cars LIMIT 4";
    $result = mysqli_query($link, $sql);
    echo"<h1>Featured Cars</h1>";
    echo "<div class='featured-cars d-flex justify-content-around align-items-center'>";
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
               <a href= 'item.php?id={$row['id']}' class='btn btn-primary'>View Car</a>
               <a href='addtowishlist.php?id={$row['id']}' class='btn btn-primary m-2'>Add to wishlist <i class='fa-solid fa-heart'></i></a>
             </div>
           </div>";
           
    }
    echo "</div>";
    $sql1 = "SELECT * FROM car_models LIMIT 3";
    $result1 = mysqli_query($link, $sql1);
    echo "<h1 class='mt-5'>Featured Models</h1>";
    echo "<div class='featured-models d-flex justify-content-around align-items-center'>";
    
    while ($row1= mysqli_fetch_array($result1)){
      echo "
           <div class='card text-bg-dark' style='width:300px; float:left; margin:5px;'>
             <img class='card-img-top'src='image/{$row1['modelPhoto']}' alt='Card image' style='width:100%'>
             <div class='card-body'>
               <h4 class='card-title'>{$row1['modelName']}</h4>
               <a href= 'products.php?id={$row1['id']}' class='btn btn-primary'>View Models</a>
             </div>
           </div>";
    }
    echo "</div>";
?>
</div>

<?php
require_once("footer.php")
?>
</body>
</html>
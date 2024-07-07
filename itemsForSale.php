<?php
    
    require_once("config.php");
    require_once("nav.php");

    if(!isset($_GET['id']))
    header("location:home.php");

    
    $query="SELECT * FROM carsforsale WHERE id ={$_GET['id']} and stock>0";
    $result=mysqli_query($link,$query);
    if(mysqli_num_rows($result)==1){
      $row= mysqli_fetch_array($result);
        echo  
          "<div class='card d-flex flex-row text-bg-dark'>
            <img class='card-img-top'src='image/{$row['photo']}' alt='Card image' style='height:600px; width:600px; object-fit:cover;'>
              <div class='card-body d-flex flex-column justify-content-around'>
              <h1 class='card-title'>{$row['carName']}</h1>
              <h4 class='card-text'>BUYING PRICE: {$row['carPrice']}$</h4>
              <p class='card-title'><strong>Year:</strong> {$row['carYear']}</p>
              <p class='card-title'><strong>Status:</strong> {$row['carStatus']}</p>
              <p class='card-title'><strong>GearBox Type:</strong> {$row['gearType']}</p>
              <p class='card-title'><strong>Stock:</strong> {$row['stock']}</p>";
              
              if($row['carStatus']=="Used"){
                echo "<p class='card-title'><strong>Distance Travelled:</strong> {$row['distance']}KM</p>";
                echo "<p class='card-title'><strong>Previous Owners:</strong> {$row['owners']}</p>";
              }

            echo"
              <p class='card-text'>{$row['description']}</p>
              <div class='d-flex flex-row'>
                <a href='checkout.php?id={$row['id']}' class='btn btn-primary w-25 m-2'>BUY NOW</a>
              </div>
            </div>
          </div>";

    $sql = "SELECT r.*, c.* FROM reviews r JOIN clients c ON r.user_id = c.id WHERE sale_item_id = {$_GET['id']} and status='sale'";
    $result = mysqli_query($link, $sql);
    
    echo "<div class='d-flex flex-wrap justify-content-between align-items-center mt-5'>
            <h2>Reviews</h2>
            <a href='addReview.php?id={$_GET['id']}&status=sale' class='btn btn-primary fs-5'>Add a New Review</a>
          </div>";
    while($row1 = mysqli_fetch_array($result)) {
      echo "
          <div class='card mb-5 mt-5 p-4'>
            <div class='card-header'>
              <span class='d-flex align-items-center'>
                <i class='fa fa-user fa-2x me-2'></i>
                <div class='fw-bold fs-4'>{$row1['first_name']} {$row1['last_name']}</div>
              </span>
            </div>
            <div class='card-body'>
              <blockquote class='blockquote mb-0'>
                <p>{$row1['review']}</p>";
                $num_stars = $row1['stars'];
                $star = "&#11088;";
                $starsReview = str_repeat($star, $num_stars);
                echo "
                <footer class='footer'>{$starsReview}</footer>
              </blockquote>
            </div>
          </div>
      ";
    }
      
    } else {
      echo" <div class='alert alert-warning alert-dismissible'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Warning!</strong> Item not found</a>.
      </div>";
    }

?>
</div>

<?php
require_once("footer.php")
?>
</body>
</html>
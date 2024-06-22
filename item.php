<?php
    if(!isset($_GET['id']))
    header("location:home.php");

    require_once("nav.php");
   require_once("config.php");
   $query="SELECT * FROM cars WHERE id ={$_GET['id']}";
   $result=mysqli_query($link,$query);
   if(mysqli_num_rows($result)==1){
    $row= mysqli_fetch_array($result);
      echo  
        "<div class='card d-flex flex-row text-bg-dark'>
           <img class='card-img-top'src='image/{$row['photo']}' alt='Card image' style='width: 600px'>
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
              <a href='rent.php?id={$row['id']}'class='btn btn-primary w-25 m-2'>RENT NOW</a>
            </div>
          </div>
        </div>";
   }
   else
   echo" <div class='alert alert-warning alert-dismissible'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
   <strong>Warning!</strong>Item not found</a>.
 </div>";

?>
</div>

<?php
require_once("footer.php")
?>
</body>
</html>
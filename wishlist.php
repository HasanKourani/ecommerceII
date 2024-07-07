<?php
  require_once("config.php");
  require_once("nav.php");
  
  echo"<h1 class='text-bg-primary bg-gradient fw-bold text-center p-3'>YOUR WISHLIST</h1>";

  if(!isset($_SESSION['id']))
   header(("location:login.php"));

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach($_POST as $key => $value) {
          $a = explode('_', $key);
          if($a[0]=="btnDelete"){
                $query="DELETE FROM favorites WHERE id=$a[1]";
                mysqli_query($link,$query);
          }
    }
  }
  
  $sql="SELECT favorites.id,carName,photo,carPrice FROM carsforsale 
  INNER JOIN favorites
  ON carsforsale.id = sale_item_id
  WHERE client_id ={$_SESSION['id']}";
  
  $result= mysqli_query($link, $sql);

  $sql1="SELECT favorites.id,carName,photo,rentFee FROM carsforrent 
  INNER JOIN favorites
  ON carsforrent.id = rent_item_id
  WHERE client_id ={$_SESSION['id']}";

  $result1= mysqli_query($link, $sql1);

  if (mysqli_num_rows($result) == 0 && mysqli_num_rows($result1) == 0)
    echo "<div class='alert alert-danger alert-dismissible'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    <strong>You have no favourites!</strong>
  </div>";
  
  else{
    echo "<div class='d-flex flex-row align-items-center flex-wrap'>";
    while($row= mysqli_fetch_array($result)){ 
    
      echo "<form method='post' class='m-4'>
              <div class='card text-bg-dark' style='width:200px' float:left; margin:5px; height:200px'>
              <img class='card-img-top' src= 'image/{$row['photo']}' alt='Card image' style='height:200px; object-fit:cover;'>
              <div class='card-body'>
                <h4 class='card-title'>{$row['carName']}</h4>
                <p class='card-text'> $ {$row['carPrice']}</p>
                <input class='btn btn-danger' type='submit'
                name='btnDelete_{$row['id']}'  value='Delete'></td>
              </div>
              </div>
            </form>";
            
    }

    while($row1= mysqli_fetch_array($result1)){ 
    
      echo "<form method='post' class='m-4'>
              <div class='card text-bg-dark' style='width:200px' float:left; margin:5px; height:200px'>
              <img class='card-img-top' src= 'image/{$row1['photo']}' alt='Card image' style='height:200px; object-fit:cover;'>
              <div class='card-body'>
                <h4 class='card-title'>{$row1['carName']}</h4>
              <p class='card-text '>Fee/Day: {$row1['rentFee']}$</p>
                <input class='btn btn-danger' type='submit'
                name='btnDelete_{$row1['id']}'  value='Delete'></td>
              </div>
              </div>
            </form>";
            
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

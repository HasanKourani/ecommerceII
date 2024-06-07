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
  
  $sql="SELECT favorites.id,carName,photo,carPrice FROM cars 
  INNER JOIN favorites
  ON cars.id = item_id
  WHERE client_id ={$_SESSION['id']}";
  
  $result= mysqli_query ($link, $sql);

  if (mysqli_num_rows($result) == 0)
    echo "<div class='alert alert-danger alert-dismissible'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    <strong>You have no favourites!</strong>
  </div>";
  
  else{
    echo "<div class='d-flex flex-row align-items-center flex-wrap'>";
    while($row= mysqli_fetch_array($result)){ 
    
      echo "<form method='post' class='m-4'>
              <div class='card text-bg-dark' style='width:200px' float:left; margin:5px; height:200px'>
              <img class='card-img-top' src= 'image/{$row['photo']}' alt='Card image' style='width:100%'>
              <div class='card-body'>
                <h4 class='card-title'>{$row['carName']}</h4>
                <p class='card-text'> $ {$row['carPrice']}</p>
                <input class='btn btn-danger' type='submit'
                name='btnDelete_{$row['id']}'  value='Delete'></td>
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

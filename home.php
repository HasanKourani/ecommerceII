<?php
    require_once"config.php";
    require_once"nav.php";

    $models = "SELECT * FROM car_models";
    $resultModels = mysqli_query($link, $models);

    echo "
    <div onmouseover='displaySearch()' onmouseout='hideSearch()'>
      <form method='get' action='allProducts.php'>
        <div class='d-flex m-5 justify-content-center align-items-center'>
          <input class='border border-0 p-3 fs-5 w-75' type='text' placeholder='Search for your car...'
          name='txtSearch' style='outline:none;'>
          <button class='border border-0 p-3 fs-5 w-25 text-bg-primary' type='submit'>SEARCH</button>
        </div>
      </form>
        <div id='hidden' class='d-none'>
          <form method='get' action='allProducts.php'>
            <h3 class='text-center'>OR</h3>
            <div class='d-flex m-5 justify-content-center align-items-center'>
              <select name='model' class='border border-0 p-3 fs-5 w-25' style='outline:none; cursor:pointer;'>
                <option selected>Models</option>";
                while($model = mysqli_fetch_array($resultModels)) {
              echo "
                <option value='$model[id]'>$model[modelName]</option>";
              }
              echo"
              </select>
              <select name='condition' class='border border-0 p-3 fs-5 w-25' style='outline:none; cursor:pointer;'>
                <option selected>Condition</option>
                <option value='New'>New</option>
                <option value='Used'>Used</option>
              </select>
              <select name='gear' class='border border-0 p-3 fs-5 w-25' style='outline:none; cursor:pointer;'>
                <option selected>Gear</option>
                <option value='Automatic'>Automatic</option>
                <option value='Sequential'>Sequential</option>
              </select>
              <button class='border border-0 p-3 fs-5 w-25 text-bg-primary' type='submit' name='filteredSearch' value='car'>SEARCH</button>
            </div>
            <div class='d-flex flex-column m-5'>
              <h4>Price</h4>
              <div class='d-flex mb-3'>
                <input type='number' name='from' id='from' placeholder='From' class='border border-0 p-3 me-4' style='outline:none; cursor:pointer;' required>
                <input type='number' name='to' id='to' placeholder='To' class='border border-0 p-3' style='outline:none; cursor:pointer;'>
              </div>
              <h4>Year</h4>
              <div class='d-flex mb-3'>
                <input type='number' name='yearFrom' id='yearFrom' placeholder='From' class='border border-0 p-3 me-4' style='outline:none; cursor:pointer;' required>
                <input type='number' name='yearTo' id='yearTo' placeholder='To' class='border border-0 p-3' style='outline:none; cursor:pointer;'>
              </div>
            </div>
            <div class='d-flex justify-content-end align-items-center mb-3'>
              <button class='border border-0 p-3 fs-5 text-bg-primary w-25' type='submit' name='filteredSearch'>SEARCH</button>
              <button class='border border-0 p-3 fs-5 text-bg-primary w-25 ms-5' type='reset'>RESET</button>
            </div>
          </form>
        </div>
    </div>
      <div class='d-flex flex-column justify-content-around align-items-center text-white mb-5'
        style='background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url(image/carousel1.jpg);
        width: 100%; height: 100vh; background-repeat: no-repeat; background-size: cover;'>
        <h1>Buy Your Dream Car Today!</h1>
      </div>
      ";

    $sql = "SELECT * FROM carsforsale WHERE sold=0 and booked=0 LIMIT 4";
    $result = mysqli_query($link, $sql);
    echo"<h1 class='mb-5 mt-2'>Featured Cars For Sale</h1>";
    if(mysqli_num_rows($result)>0) {
      echo "<div class='featured-cars d-flex justify-content-start align-items-center flex-wrap'>";
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
    if(mysqli_num_rows($result2)>0){
      echo "<div class='featured-cars d-flex justify-content-start align-items-center flex-wrap'>";
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
    if(mysqli_num_rows($result1)>0){
      echo "<div class='featured-models d-flex justify-content-start align-items-center flex-wrap'>";
      
      while ($row1= mysqli_fetch_array($result1)){
        echo "
            <div class='card text-bg-dark' style='width:300px; float:left; margin:5px;'>
              <img class='card-img-top'src='image/{$row1['modelPhoto']}' alt='Card image' style='height:200px; object-fit:cover;'>
              <div class='card-body'>
                <h4 class='card-title'>{$row1['modelName']}</h4>
                <a href= 'allProducts.php?id={$row1['id']}' class='btn btn-primary'>View Models</a>
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

<script type='text/javascript'>
  function displaySearch() {
    document.getElementById('hidden').classList.remove('d-none');
  }
  function hideSearch() {
    document.getElementById('hidden').classList.add('d-none');
  }
</script>
</body>
</html>
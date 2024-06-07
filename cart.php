
<?php

require_once("config.php");

require_once("nav.php");

if(!isset($_SESSION['id']))
header(("location:login.php"));

$sid=session_id();
$user_id = $_SESSION['id'];
echo"<h1 class='text-bg-primary bg-gradient fw-bold text-center p-3'>YOUR CART</h1>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      foreach($_POST as $key => $value) {
            $a = explode('_', $key);
            if($a[0]=="btnDelete"){
                  $query="DELETE FROM carts WHERE id=$a[1] AND user_id = '$user_id'";
                  mysqli_query($link,$query);
            }
      }
}

echo "<form method='post'>";

echo "<table class='table table-striped'>";

$query = "SELECT cars.id, photo, carName, carPrice, quantity, carPrice * quantity AS total FROM cars

INNER JOIN carts ON cars.id = item_id

WHERE session_id='$sid' AND user_id = '$user_id'";

$result = mysqli_query($link, $query);

$total = 0;
$cartItems = array();
$rowColor = 0;

if(mysqli_num_rows($result)==0){
      echo "<div class='alert alert-danger alert-dismissible'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    <strong>Your Cart Is Empty!</strong>
  </div>";
} else {
      echo "<tr class='table-primary'><th>Image</th><th>Product</th> <th>Unit Price</th><th>Quantity</th> <th>Total</th><th></th></tr>";
      while($row = mysqli_fetch_array($result)){

            $rowClass = $rowColor % 2 == 0 ? 'table-warning' : 'table-info';

            echo "<tr class='{$rowClass}'><td><img src='image/{$row['photo']}' style='width:120px'></td>

            <td>{$row['carName']}</td>

            <td>{$row['carPrice']}$</td>

            <td>{$row['quantity']}</td>

            <td>{$row['total']}$</td>";

            $sql = "SELECT carts.id FROM carts WHERE session_id='$sid'";
            $result1 = mysqli_query($link, $sql);
            $row1 = mysqli_fetch_array($result1);
            echo "<td><input class='btn btn-danger' type='submit'
                  name='btnDelete_{$row1['id']}' value='Delete'></td>
                  </tr>";

            $total += $row['total'];
            $cartItems[] = $row;
            $rowColor++;
      }
      echo"<tr class='table-primary'><th colspan='3'></th><th>Total</th><th>$total$</th></tr>";
      echo "</table>";

      $_SESSION['cartItems'] = $cartItems;
      echo "</form>";

      echo "<form action='checkout.php' method='post'>
            <input class='btn btn-primary' type='submit' name='btnCheckOut' value='Proceed To Checkout'>
            </form>";

}

?>
</div>

<?php
require_once("footer.php")
?>
</body>
</html>
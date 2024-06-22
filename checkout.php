<?php
    require_once("config.php");
    require_once("nav.php");
    $sid=session_id();
    if(!isset($_SESSION['id']))
    header(("location:login.php"));

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $fn = $_POST["fn"] ?? '';
        $ln = $_POST["ln"] ?? '';
        $client_id = $_SESSION['id'] ?? '';
        $email = $_POST["email"] ?? '';
        $shippingAdd = $_POST["shippingAdd"] ?? '';
        $city = $_POST["city"] ?? '';
        $zip = $_POST["zip"] ?? '';
        $country = $_POST["country"] ?? '';
        $phone = $_POST["phone"] ?? '';
        
        $sql = "INSERT INTO orders (firstName, lastName, email, shippingAddress, city, zip, country, phone)
                VALUES ('$fn', '$ln', '$email', '$shippingAdd', '$city', '$zip', '$country', '$phone')";
        mysqli_query($link, $sql);

        $orderId = mysqli_insert_id($link);
        $_SESSION['orderId'] = $orderId;

        $query = "SELECT * FROM cars WHERE id = {$_GET['id']}";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);

            $itemId = $row['id'];
            $price = $row['carPrice'];
            $sql = "INSERT INTO order_items (order_id, item_id, price)
                    VALUES ('$orderId', '$itemId', '$price')";
            mysqli_query($link, $sql);

        $sold = "UPDATE cars SET sold='1', stock=stock-1, unitsSold=unitsSold+1 
        WHERE id={$_GET['id']} and stock>0";
        mysqli_query($link, $sold);

        header("location:bill.php");      
    }
?>
<form action='' method='post'>
    <div class='mb-3 mt-3'>
        <label for='fn' class='form-label'>First Name: *</label>
        <input type='text' name='fn' id='fn' class='form-control' placeholder="First Name" required>
    </div>
    <div class='mb-3 mt-3'>
        <label for='ln' class='form-label'>Last Name: *</label>
        <input type='text' name='ln' id='ln' class='form-control' placeholder="Last Name" required>
    </div>
    <div class='mb-3 mt-3'>
        <label for='email' class='form-label'>Email: *</label>
        <input type='email' name='email' id='email' class='form-control' placeholder="example@gmail.com" required>
    </div>
    <div class='mb-3 mt-3'>
        <label for='shippingAdd' class='form-label'>Shipping Address: *</label>
        <input type='text' name='shippingAdd' id='shippingAdd' class='form-control' placeholder="Neighborhood - Building - Floor" required>
    </div>
    <div class='mb-3 mt-3'>
        <label for='city' class='form-label'>City: *</label>
        <input type='text' name='city' id='city' class='form-control' placeholder="City" required>
    </div>
    <div class='mb-3 mt-3'>
        <label for='zip' class='form-label'>Zip: </label>
        <input type='text' name='zip' id='zip' class='form-control' placeholder="Example: 0000">
    </div>
    <div class='mb-3 mt-3'>
        <label for='country' class='form-label'>Country: *</label>
        <input type='text' name='country' id='country' class='form-control' placeholder="Country" required>
    </div>
    <div class='mb-3 mt-3'>
        <label for='phone' class='form-label'>Phone: *</label>
        <input type='number' name='phone' id='phone' class='form-control' placeholder="03 - 123 456" required>
    </div>
    <input class='btn btn-primary mb-5' type='submit' name='submit' value='Place Order'>
</form>
</div>

<?php
require_once("footer.php")
?>
</body>
</html>
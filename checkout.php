<?php
    require_once"config.php";
    require_once"nav.php";
    
    $sid=session_id();
    if(!isset($_SESSION['id']))
    header(("location:login.php"));

    $sql = "SELECT * FROM carsforsale WHERE id={$_GET['id']}";
    $result=mysqli_query($link,$sql);
    $row1= mysqli_fetch_array($result);

    $user = "SELECT * FROM clients WHERE id = {$_SESSION['id']}";
    $userResult = mysqli_query($link, $user);
    $row = mysqli_fetch_array($userResult);

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(isset($_POST['termsCheckbox'])){

            $fn = $row['first_name'];
            $ln = $row['last_name'];
            $client_id = $_SESSION['id'] ?? '';
            $email = $row['email'];
            $city = $row['city'];
            $country = $row['country'];
            $phone = $row['phone'];
            $orderType = "Buy";
            
            $sql = "INSERT INTO orders (userId, firstName, lastName, email, city, country, phone, orderType)
                    VALUES ('$client_id', '$fn', '$ln', '$email', '$city', '$country', '$phone', '$orderType')";
            mysqli_query($link, $sql);

            $orderId = mysqli_insert_id($link);
            $_SESSION['orderId'] = $orderId;

            $query = "SELECT * FROM carsforsale WHERE id = {$_GET['id']}";
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_array($result);

                $itemId = $row['id'];
                $price = $row['carPrice'];
                $sql = "INSERT INTO order_items (order_id, item_id, price)
                        VALUES ('$orderId', '$itemId', '$price')";
                mysqli_query($link, $sql);

            $sold = "UPDATE carsforsale SET sold='1' 
            WHERE id={$_GET['id']}";
            mysqli_query($link, $sold);

            header("location:bill.php");      
        } else {
            echo "<div class='w-100 m-2'>
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              <strong>ATTENTION!</strong> Please Agree to Terms and Policies!
            </div>";
        }
    }
?>
<form action='' method='post'>
    <div class="d-flex flex-column justify-content-center align-items-center mb-5">
        <img src="image/<?php echo htmlspecialchars($row1['photo']); ?>" alt="Car photo" class="w-50 h-50 rounded">
    </div>
    <div class="d-flex flex-column justify-content-between" style="min-height:20vh;">
        <h1><?php echo htmlspecialchars($row1['carName']); ?></h1>
        <h4>Car Year: <?php echo htmlspecialchars($row1['carYear']); ?></h4>
        <div class="d-flex">
            <h4>Car Price: $</h4>
            <h4 id="dayFee"><?php echo htmlspecialchars($row1['carPrice']); ?></h4>
        </div>
    </div>
    <h1 class="mt-5 mb-3">Payment Method:</h1>
    <div class="form-check d-flex align-items-center mb-5">
    <input class="form-check-input" type="radio" name="pay" id="pay" checked>
    <label class="form-check-label fs-4 ms-2" for="pay">
        PAY ON PICK UP
    </label>
    </div>

    <h1>Terms And Policies</h1>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="termsCheckbox" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">
            Do You Agree To Our <a href="tP.php" class="text-decoration-none" target="_blank">Terms And Policies?</a>
        </label>
    </div>
    <input class='btn btn-primary mb-5' type='submit' name='submit' value='Place Order'>
</form>
</div>

<?php
require_once("footer.php")
?>
</body>
</html>
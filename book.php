<?php

    require_once"config.php";
    require_once"nav.php";

    $sql1 = "SELECT * FROM carsforsale WHERE id={$_GET['id']}";
    $result1=mysqli_query($link,$sql1);
    $row2= mysqli_fetch_array($result1);

    $user = "SELECT * FROM clients WHERE id = {$_SESSION['id']}";
    $userResult = mysqli_query($link, $user);
    $row1 = mysqli_fetch_array($userResult);

    $today = date("Y-m-d");

    if(isset($_POST['book'])) {

        if(isset($_POST['termsCheckbox'])){

            $bookingDate = $_POST['bookingDate'];

            if(!$_POST['bookingDate']) {
                echo
                "<div class='alert alert-danger alert-dismissible'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    <strong>Error!</strong> Please select BOOKING DATE!
                </div>";
            } else {
                $fn = $row1['first_name'];
                $ln = $row1['last_name'];
                $client_id = $_SESSION['id'];
                $email = $row1['email'];
                $city = $row1['city'];
                $country = $row1['country'];
                $phone = $row1['phone'];
                $orderType = "Book";

                $insertOrder = "INSERT INTO orders (userId, firstName, lastName, email, city, country, phone, orderType)
                        VALUES ('$client_id', '$fn', '$ln', '$email', '$city', '$country', '$phone', '$orderType')";
                mysqli_query($link, $insertOrder);

                $orderId = mysqli_insert_id($link);
                $_SESSION['orderId'] = $orderId;

                $insertSale = "INSERT INTO bookings (order_id, item_id, deposit, bookingDate)
                VALUES ('$orderId', '{$_GET['id']}', {$_POST['deposit']}, '$bookingDate')";
                mysqli_query($link, $insertSale);

                $booked = "UPDATE carsforsale SET booked=1 WHERE id={$_GET['id']}";
                mysqli_query($link, $booked);

                header("location:bookBill.php");
            }
        } else {
            echo "<div class='w-100 m-2'>
            <div class='alert alert-danger alert-dismissible'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>ATTENTION!</strong> Please Agree to Terms and Policies!
            </div>";
        }
    }
?>

<form action="" method="post" class="d-flex flex-column">

    <div class="d-flex flex-column justify-content-center align-items-center mb-5">
        <img src="image/<?php echo htmlspecialchars($row2['photo']); ?>" alt="Car photo" class="w-50 h-50 rounded">
    </div>
    <div class="d-flex flex-row justify-content-between align-items-center">
        <div class="d-flex flex-column justify-content-between" style="min-height:20vh;">
            <h1><?php echo htmlspecialchars($row2['carName']); ?></h1>
            <h4>Car Year: <?php echo htmlspecialchars($row2['carYear']); ?></h4>
            <div class="d-flex">
                <h4>Car Price: $</h4>
                <h4 id="carPrice"><?php echo htmlspecialchars($row2['carPrice']); ?></h4>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-between" style="min-height:20vh;">
            <input type="date" name="currentDate" id="currentDate" hidden>
            <h3>Book For:</h3>
            <input type="date" name="bookingDate" id="bookingDate" min="<?php echo htmlspecialchars($today) ?>"
            class="border border-0 text-bg-primary p-2 text-uppercase btn fs-5">
            <h3>Deposit Amount: (in $)</h3>
            <input type="number" name="deposit" id="deposit" placeholder="Deposit Amount"
            class="border border-0 rounded p-2 fs-5" style="outline:none;" required max="<?php echo htmlspecialchars($row2['carPrice']); ?>">
        </div>
    </div>
    <hr>
    <h1 class="mb-3 mt-3">Payment Method:</h1>
    <div class="form-check d-flex align-items-center">
        <input class="form-check-input" type="radio" name="pay" id="pay" checked>
        <label class="form-check-label fs-4 ms-2" for="pay">
            PAY ON DELIVERY
        </label>
    </div>
    <h1>Terms And Policies</h1>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="termsCheckbox" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">
            Do You Agree To Our <a href="tP.php" class="text-decoration-none" target="_blank">Terms And Policies?</a>
        </label>
    </div>
    <button type="submit" class="justify-self-center align-self-center btn btn-primary fw-bold fs-4 m-5" name="book">Book Car</button>
</form>
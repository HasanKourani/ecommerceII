<?php

    require_once"config.php";
    require_once"nav.php";

    if(!isset($_SESSION['id']))
    header(("location:login.php"));

    $sql = "SELECT * FROM carsforrent WHERE id={$_GET['id']}";
    $result=mysqli_query($link,$sql);
    $row= mysqli_fetch_array($result);

    $user = "SELECT * FROM clients WHERE id = {$_SESSION['id']}";
    $userResult = mysqli_query($link, $user);
    $row1 = mysqli_fetch_array($userResult);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['termsCheckbox'])){

            $finalDate = $_POST['finalDate'];
            $startingDate = $_POST['startingDate'];
            $currentDate = date("Y-m-d");

            if($finalDate==$currentDate || !$finalDate){
                echo
                "<div class='alert alert-danger alert-dismissible'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    <strong>Error!</strong> Rent at least 1 day!
                </div>";
            } elseif($startingDate >= $finalDate){
                echo
                "<div class='alert alert-danger alert-dismissible'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    <strong>Error!</strong> Starting date can't be after Final Date
                </div>";
            } else {

                $fn = $row1['first_name'];
                $ln = $row1['last_name'];
                $client_id = $_SESSION['id'] ?? '';
                $email = $row1['email'];
                $city = $row1['city'];
                $country = $row1['country'];
                $phone = $row1['phone'];
                $orderType = "Rent";
                $duration = $_POST['duration'];
                $totalFee = $_POST['totalFee'];

                $sql = "INSERT INTO orders (userId, firstName, lastName, email, city, country, phone, orderType)
                        VALUES ('$client_id', '$fn', '$ln', '$email', '$city', '$country', '$phone', '$orderType')";
                mysqli_query($link, $sql);

                $orderId = mysqli_insert_id($link);
                $_SESSION['orderId'] = $orderId;

                $sql = "SELECT * FROM carsforrent WHERE id={$_GET['id']}";
                $result=mysqli_query($link,$sql);
                $row= mysqli_fetch_array($result);
                $itemId = $row['id'];
                    
                    $sql = "INSERT INTO rent_items (order_id, item_id, duration, totalFee, startingDate, finalDate)
                            VALUES ('$orderId', '$itemId', '$duration', '$totalFee', '$startingDate', '$finalDate')";
                    mysqli_query($link, $sql);

                $rented = "UPDATE carsforrent SET rented=1
                WHERE id={$_GET['id']}";
                mysqli_query($link, $rented);

                    header("location:rentBill.php");
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
        <img src="image/<?php echo htmlspecialchars($row['photo']); ?>" alt="Car photo" class="w-50 h-50 rounded">
    </div>
    <div class="d-flex flex-row justify-content-between align-items-center">
        <div class="d-flex flex-column justify-content-between" style="min-height:20vh;">
            <h1><?php echo htmlspecialchars($row['carName']); ?></h1>
            <h4>Car Year: <?php echo htmlspecialchars($row['carYear']); ?></h4>
            <div class="d-flex">
                <h4>Rent Fee (Per Day): $</h4>
                <h4 id="dayFee"><?php echo htmlspecialchars($row['rentFee']); ?></h4>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-between" style="min-height:20vh;">
            <input type="date" name="currentDate" id="currentDate" hidden>
            <h3>Rent From:</h3>
            <input type="date" name="startingDate" id="startingDate" class="border border-0 text-bg-primary p-2 text-uppercase btn fs-5">
            <h3>Rent Until:</h3>
            <input type="date" name="finalDate" id="finalDate" class="border border-0 text-bg-primary p-2 text-uppercase btn fs-5">
            <input type="hidden" name="duration" id="durationInput">
            <input type="hidden" name="totalFee" id="totalFeeInput">
            <h3 id="duration"></h3>
            <h3 id="totalFee"></h3>
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
    <button type="submit" class="justify-self-center align-self-center btn btn-primary fw-bold fs-4 m-5">Proceed To Checkout</button>
</form>

<script type='text/javascript'>
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();

    if (dd < 10) {
    dd = '0' + dd;
    }

    if (mm < 10) {
    mm = '0' + mm;
    } 
        
    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("currentDate").setAttribute("value", today);
    document.getElementById("finalDate").setAttribute("min", today);
    document.getElementById("startingDate").setAttribute("min", today);

    document.getElementById("finalDate").addEventListener("change", function () {

        const startDate = new Date(document.getElementById("startingDate").value);
        const endDate = new Date(document.getElementById("finalDate").value);
        let duration = Math.ceil((endDate - startDate)/(1000*60*60*24));

        document.getElementById("duration").innerHTML="Duration: " + duration + " Days";
        document.getElementById("durationInput").value = duration;

        let dayFee = parseFloat(document.getElementById("dayFee").innerHTML);
        let totalFee = dayFee * duration;
        document.getElementById("totalFee").innerHTML = "Total Rent Fee: $" + totalFee;
        document.getElementById("totalFeeInput").value = totalFee;
    });
</script>

<?php
require_once("footer.php");
?>
</body>
</html>


<?php

    require_once("config.php");

    require_once("nav.php");

    if(!isset($_SESSION['id']))
    header(("location:login.php"));

    $sql = "SELECT * FROM cars WHERE id={$_GET['id']}";
    $result=mysqli_query($link,$sql);
    $row= mysqli_fetch_array($result);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $finalDate = $_POST['finalDate'];
        $currentDate = date("Y-m-d");

        $fn = $_POST["fn"] ?? '';
        $ln = $_POST["ln"] ?? '';
        $client_id = $_SESSION['id'] ?? '';
        $email = $_POST["email"] ?? '';
        $shippingAdd = $_POST["shippingAdd"] ?? '';
        $city = $_POST["city"] ?? '';
        $zip = $_POST["zip"] ?? '';
        $country = $_POST["country"] ?? '';
        $phone = $_POST["phone"] ?? '';
        $orderType = "Rent";
        $duration = $_POST['duration'];
        $totalFee = $_POST['totalFee'];

        $sql = "INSERT INTO orders (firstName, lastName, email, shippingAddress, city, zip, country, phone, orderType)
                VALUES ('$fn', '$ln', '$email', '$shippingAdd', '$city', '$zip', '$country', '$phone', '$orderType')";
        mysqli_query($link, $sql);

        $orderId = mysqli_insert_id($link);
        $_SESSION['orderId'] = $orderId;

        $query = "SELECT * FROM cars WHERE id = {$_GET['id']}";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);

            $itemId = $row['id'];
            $sql = "INSERT INTO rent_items (order_id, item_id, duration, totalFee, finalDate)
                    VALUES ('$orderId', '$itemId', '$duration', '$totalFee', '$finalDate')";
            mysqli_query($link, $sql);

        $rented = "UPDATE cars SET rented=1, stock=stock-1, unitsRented=unitsRented+1 
        WHERE id={$_GET['id']} and stock>0";
        mysqli_query($link, $rented);

        if($finalDate==$currentDate || !$finalDate){
            echo
            "<div class='alert alert-danger alert-dismissible'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Error!</strong> Rent at least 1 day!
            </div>";
        } else {
            header("location:rentBill.php");
        }
    }

?>

<form action="" method="post" class="d-flex flex-column">

    <div class="d-flex flex-column justify-content-center align-items-center mb-5">
        <img src="image/<?php echo htmlspecialchars($row['photo']); ?>" alt="Car photo" class="w-50 h-50">
    </div>
    <div class="d-flex flex-row justify-content-between align-items-center">
        <div class="d-flex flex-column justify-content-between" style="min-height:20vh;">
            <h1><?php echo htmlspecialchars($row['carName']); ?></h1>
            <h4>Units Available For Renting: <?php echo htmlspecialchars($row['stock']); ?></h4>
            <div class="d-flex">
                <h4>Rent Fee (Per Day): $</h4>
                <h4 id="dayFee"><?php echo htmlspecialchars($row['rentFee']); ?></h4>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-between" style="min-height:20vh;">
            <input type="date" name="currentDate" id="currentDate" hidden>
            <h3>Rent Until:</h3>
            <input type="date" name="finalDate" id="finalDate" class="border border-0 text-bg-primary p-2 text-uppercase btn fs-5">
            <input type="hidden" name="duration" id="durationInput">
            <input type="hidden" name="totalFee" id="totalFeeInput">
            <h3 id="duration"></h3>
            <h3 id="totalFee"></h3>
        </div>
    </div>
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

    document.getElementById("finalDate").addEventListener("change", function () {

        const startDate = new Date(document.getElementById("currentDate").value);
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


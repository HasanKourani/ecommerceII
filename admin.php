<?php 
require_once("config.php");
require_once("adminNav.php");
?>
<div class="w-100 m-5">

    <?php 
        $sales = "SELECT price FROM order_items";
        $salesResult = mysqli_query($link, $sales);

        $totalSales = 0;


        while($row = mysqli_fetch_array($salesResult)) {
            $totalSales += $row['price'];
        }
    ?>
    <div class="d-flex flex-wrap justify-content-around">
        <div class="card p-5 fs-3 d-flex flex-column text-center text-bg-info">
            <h2 class="card-title">Total Sales</h2>
            <p class="fw-bold"><?php echo $totalSales ?>$</p>
        </div>

        <?php
            $stock = "SELECT SUM(stock) FROM carsforsale";
            $stockResult = mysqli_query($link, $stock);
            $row = mysqli_fetch_assoc($stockResult);
            $totalStock = $row['SUM(stock)'];
        ?>

        <div class="card p-5 fs-3 d-flex flex-column text-center text-bg-danger">
            <h2 class="card-title">Available Cars For Sale</h2>
            <p class="fw-bold"><?php echo $totalStock ?></p>
        </div>

        <?php
            $unitsSold = "SELECT SUM(unitsSold) FROM carsforsale";
            $unitsSoldResult = mysqli_query($link, $unitsSold);
            $row1 = mysqli_fetch_assoc(($unitsSoldResult));
            $totalUnitsSold = $row1['SUM(unitsSold)'];
        ?>

        <div class="card p-5 fs-3 d-flex flex-column text-center text-bg-warning">
            <h2 class="card-title">Sold Cars</h2>
            <p class="fw-bold"><?php echo $totalUnitsSold ?></p>
        </div>

        <?php
            $unitsRented = "SELECT SUM(rented) FROM carsforrent";
            $unitsRentedResult = mysqli_query($link, $unitsRented);
            $row2 = mysqli_fetch_assoc(($unitsRentedResult));
            $totalUnitsRented = $row2['SUM(rented)'];
        ?>

        <div class="card p-5 fs-3 d-flex flex-column text-center bg-warning-subtle">
            <h2 class="card-title">Rented Cars</h2>
            <p class="fw-bold"><?php echo $totalUnitsRented ?></p>
        </div>
    </div>

    <?php 
        $clients = "SELECT * FROM clients WHERE roleAs=0";
        $clientsResult = mysqli_query($link, $clients);
        $totalClients = mysqli_num_rows($clientsResult);
    ?>

    <div class="card p-5 fs-3 m-5 d-flex flex-row justify-content-between align-items-center bg-primary-subtle">
            <h2 class="card-title">Total Registered Customers</h2>
            <p class="fw-bold"><?php echo $totalClients ?></p>
    </div>

    <h2 class="m-5 text-dark">LATEST ORDERS</h2>
    <div class="card m-5 text-bg-primary">
        <div class="card-body">
            <?php 
                $latestOrders = "SELECT * FROM orders ORDER BY id DESC LIMIT 3";
                $lateststockResult = mysqli_query($link, $latestOrders);

                while($row = mysqli_fetch_array($lateststockResult)){
            ?>
                    
                    <h4 class="card-title">Order Number: <?php echo htmlspecialchars($row['id']); ?></h4>
                    <p class="card-text"><strong>First Name:</strong> <?php echo htmlspecialchars($row['firstName']); ?></p>
                    <p class="card-text"><strong>Last Name:</strong> <?php echo htmlspecialchars($row['lastName']); ?></p>
                    <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                    <hr>
            <?php
                }
            ?>
        </div>
    </div>

</div>
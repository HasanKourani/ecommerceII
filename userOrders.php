<?php
    require_once"config.php";
    require_once"nav.php";

    $saleOrders = "SELECT * FROM orders WHERE userId = {$_SESSION['id']} ORDER BY id DESC";
    $result = mysqli_query($link, $saleOrders);
?>
    <h1 class='text-start mb-5 text-dark'>All Orders</h1>

    <div class='d-flex flex-wrap justify-content-start align-items-center'>
    <?php
        while($row = mysqli_fetch_array($result)) {
    ?>  
        <a href="oneUserOrder.php?id=<?php echo htmlspecialchars($row['id']);?>" class="text-decoration-none m-1">
            <div class="card p-5 ordersCard">
                <h2 class>Order Number: <?php echo htmlspecialchars($row['id']); ?></h2>
                <h5 class="card-text"><strong>First Name:</strong> <?php echo htmlspecialchars($row['firstName']); ?></h5>
                <h5 class="card-text"><strong>Last Name:</strong> <?php echo htmlspecialchars($row['lastName']); ?></h5>
                <h5 class="card-text"><strong>Order Type:</strong> <?php echo htmlspecialchars($row['orderType']); ?></h5>
                <h5 class="card-text"><strong>Order Date:</strong> <?php echo htmlspecialchars($row['orderDate']); ?></h5>
            </div>
        </a>
    <?php } ?>
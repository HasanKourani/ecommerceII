<?php 
    require_once("config.php");
    require_once("nav.php");

    if(!isset($_SESSION['id'])){
        header('location:login.php');
    }

    if(!isset($_SESSION['orderId'])){
        header('location:checkout.php');
    }

    $orderId = $_SESSION['orderId'];

    $query = "SELECT * FROM orders WHERE id = '$orderId'";
    $result = mysqli_query($link, $query);

    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
    }

    $sql = "SELECT oi.*, c.carName FROM order_items oi JOIN cars c ON oi.item_id = c.id WHERE oi.order_id = $orderId";
    $result1 = mysqli_query($link, $sql);
?>

<div class="container">
        <div class='alert alert-success alert-dismissible'>
            <strong>Your Order has Been Sent!</strong>
        </div>
    <h1 class="text-center my-4">Order Bill</h1>

    <div class="card text-bg-dark">
        <div class="card-body">
            <h2 class="card-title mb-4">Order Number: <?php echo htmlspecialchars($row['id']); ?></h2>
            <p class="card-text"><strong>First Name:</strong> <?php echo htmlspecialchars($row['firstName']); ?></p>
            <p class="card-text"><strong>Last Name:</strong> <?php echo htmlspecialchars($row['lastName']); ?></p>
            <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
            <p class="card-text"><strong>Shipping Address:</strong> <?php echo htmlspecialchars($row['shippingAddress']); ?></p>
            <p class="card-text"><strong>City:</strong> <?php echo htmlspecialchars($row['city']); ?></p>
            <p class="card-text"><strong>Zip:</strong> <?php echo htmlspecialchars($row['zip']); ?></p>
            <p class="card-text"><strong>Country:</strong> <?php echo htmlspecialchars($row['country']); ?></p>
            <p class="card-text"><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
            <p class="card-text"><strong>Order Date:</strong> <?php echo htmlspecialchars($row['orderDate']); ?></p>

            <h5 class="card-title mt-4">Items Ordered</h5>
            <table class="table table-striped">
                <thead>
                    <tr class="table-primary">
                        <th>Car Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $rowColor = 0;
                    $grandTotal = 0;
                    while ($row1 = mysqli_fetch_assoc($result1)){
                        $rowClass = $rowColor % 2 == 0 ? 'table-success' : 'table-primary';
                        $grandTotal += $row1['total'];
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row1['carName']); ?></td>
                            <td><?php echo htmlspecialchars($row1['quantity']); ?></td>
                            <td>$<?php echo htmlspecialchars($row1['price']); ?></td>
                            <td>$<?php echo htmlspecialchars($row1['total']); ?></td>
                        </tr>
                    <?php 
                $rowColor++; }; ?>
                </tbody>
            </table>
            <h5 class="text-end">Grand Total: $<?php echo number_format($grandTotal, 2); ?></h5>
        </div>
    </div>
</div>

<?php
require_once("footer.php");
?>
</body>
</html>
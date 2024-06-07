<?php 
require_once("config.php");
require_once("adminNav.php");

$query = "SELECT * FROM orders";
$result = mysqli_query($link, $query);
echo "<div class='w-100 m-5'>";
echo "<h1 class='text-center mb-5 text-dark'>All Orders</h1>";
echo "<div class='container'>";
while($row = mysqli_fetch_array($result)) {
    $orderId = $row['id'];
?>

    <div class="card mb-3 text-bg-primary">
        <div class="card-body">
            <h2 class="card-title mb-4">Order Number: <?php echo htmlspecialchars($row['id']); ?></h2>
            <h5 class="card-title">Customer Details:</h5>
            <p class="card-text"><strong>First Name:</strong> <?php echo htmlspecialchars($row['firstName']); ?></p>
            <p class="card-text"><strong>Last Name:</strong> <?php echo htmlspecialchars($row['lastName']); ?></p>
            <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
            <p class="card-text"><strong>Shipping Address:</strong> <?php echo htmlspecialchars($row['shippingAddress']); ?></p>
            <p class="card-text"><strong>City:</strong> <?php echo htmlspecialchars($row['city']); ?></p>
            <p class="card-text"><strong>Zip:</strong> <?php echo htmlspecialchars($row['zip']); ?></p>
            <p class="card-text"><strong>Country:</strong> <?php echo htmlspecialchars($row['country']); ?></p>
            <p class="card-text"><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
            <p class="card-text"><strong>Order Date:</strong> <?php echo htmlspecialchars($row['orderDate']); ?></p>
        </div>
    </div>
        <h2 class="card-title text-dark mb-3">Ordered Items:</h2>
        <div class="card bg-primary-subtle">
            <table class="table table-striped">
                <thead>
                    <tr class='table-primary'>
                        <th>Car Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT oi.*, c.carName FROM order_items oi JOIN cars c ON oi.item_id = c.id WHERE oi.order_id = $orderId";
                    $result1 = mysqli_query($link, $sql);
                    $grandTotal = 0;
                    $rowColor = 0;
                    while($row1 = mysqli_fetch_assoc($result1)){
                        $rowClass = $rowColor % 2 == 0 ? 'table-danger' : 'table-success';
                        $grandTotal += $row1['total'];
                        ?>
                        <tr class=<?php echo $rowClass ?>>
                            <td><?php echo htmlspecialchars($row1['carName']); ?></td>
                            <td><?php echo htmlspecialchars($row1['quantity']); ?></td>
                            <td>$<?php echo htmlspecialchars($row1['price']); ?></td>
                            <td>$<?php echo htmlspecialchars($row1['total']); ?></td>
                        </tr>
                    
                        <?php
                        $rowColor++;
                    }
                    ?>
                </tbody>
            </table>
            <h5 class="text-end">Grand Total: $<?php echo number_format($grandTotal, 2); ?></h5>
        </div>
            <br>
            <hr>

<?php } ?>

</div>
</div>


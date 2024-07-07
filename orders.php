<?php 
require_once("config.php");
require_once("adminNav.php");

$query = "SELECT * FROM orders ORDER BY id DESC";
$result = mysqli_query($link, $query);
echo "<div class='w-100 m-5'>";
echo "<h1 class='text-center mb-5 text-dark'>All Orders</h1>";
echo "<div class='d-flex flex-wrap justify-content-around align-items-center'>";
while($row = mysqli_fetch_array($result)) {
?>  
    <a href="oneOrder.php?id=<?php echo htmlspecialchars($row['id']);?>" class="text-decoration-none m-2">
        <div class="card p-5 ordersCard">
            <h2 class>Order Number: <?php echo htmlspecialchars($row['id']); ?></h2>
            <h5 class="card-text"><strong>First Name:</strong> <?php echo htmlspecialchars($row['firstName']); ?></h5>
            <h5 class="card-text"><strong>Last Name:</strong> <?php echo htmlspecialchars($row['lastName']); ?></h5>
            <h5 class="card-text"><strong>Order Type:</strong> <?php echo htmlspecialchars($row['orderType']); ?></h5>
        </div>
    </a>
<?php } ?>

</div>
</div>


<?php 
require_once"config.php";
require_once"adminNav.php";

$query = "SELECT * FROM orders";

if(isset($_GET['filteredSearch'])) {

    if (!empty($_GET['orderType']) && $_GET['orderType'] !== 'Type') {
        $query .= " WHERE orderType LIKE '%{$_GET['orderType']}%'";
    }

    if (!empty($_GET['first_name'])) {
        $query .= " AND firstName LIKE '%{$_GET['first_name']}%'";
    }

    if (!empty($_GET['last_name'])) {
        $query .= " AND lastName LIKE '%{$_GET['last_name']}%'";
    }

    if(!empty($_GET['orderDate'])) {
        $query .= " AND orderDate LIKE '%{$_GET['orderDate']}%'";
    }
}

$query .= " ORDER BY id DESC ";


$result = mysqli_query($link, $query);
$today = date("Y-m-d");
echo "<div class='w-100 m-5'>";
echo "<h1 class='text-start mb-5 text-dark'>Search Orders</h1>
<form method='get' action='orders.php'>
    <div class='d-flex m-5 justify-content-start align-items-center'>
        <select name='orderType' class='border border-0 p-3 fs-5 w-25' style='outline:none; cursor:pointer;'>
        <option selected>Type</option>
        <option value='Buy'>Buy</option>
        <option value='Rent'>Rent</option>
        <option value='Book'>Book</option>
        </select>
    </div>
    <div class='d-flex flex-column m-5'>
        <h4>Customer</h4>
        <div class='d-flex mb-3'>
            <input type='text' name='first_name' id='first_name' placeholder='First Name' class='border border-0 p-3 me-4'
            style='outline:none; cursor:pointer;' required>
            <input type='text' name='last_name' id='last_name' placeholder='Last Name' class='border border-0 p-3' style='outline:none; cursor:pointer;'
            required>
        </div>
        <h4>Date</h4>
        <input type='date' name='orderDate' id='orderDate' max='$today'
        class='border border-0 text-bg-light p-2 align-self-start text-uppercase btn fs-5'>
    </div>
    <div class='d-flex justify-content-start align-items-center m-5'>
        <button class='border border-0 p-3 fs-5 text-bg-primary' type='submit' name='filteredSearch'>SEARCH</button>
        <button class='border border-0 p-3 fs-5 text-bg-primary ms-5' type='reset'>RESET</button>
    </div>
</form>

<h1 class='text-start mb-5 text-dark'>All Orders</h1>";

echo "<div class='d-flex flex-wrap justify-content-start align-items-center'>";
while($row = mysqli_fetch_array($result)) {
?>  
    <a href="oneOrder.php?id=<?php echo htmlspecialchars($row['id']);?>" class="text-decoration-none m-1">
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


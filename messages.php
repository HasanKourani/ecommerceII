<?php

require_once("config.php");
require_once("adminNav.php");


$sql = "SELECT m.*, c.* FROM messages m JOIN clients c ON m.senderId = c.id WHERE receiverId='$_SESSION[id]' ORDER BY dateSent DESC";
$result = mysqli_query($link, $sql);

echo "<div class='w-100 m-5'>";
echo "<h1 class='text-center mb-5 text-dark'>All Messages</h1>";
echo "<div class='d-flex flex-wrap justify-content-around align-items-center'>";

while($row = mysqli_fetch_assoc($result)) {
?>

<a href="oneMessage.php?id=<?php echo htmlspecialchars($row['msgId']);?>" class="text-decoration-none m-2">
        <div class="card p-5 ordersCard">
            <h2 class>Message From:</h2>
            <h3 class="card-text"><strong> <?php echo htmlspecialchars($row['first_name']), " ", htmlspecialchars($row['last_name']); ?></strong></h3>
            <h4 class="card-text">Sent at: <strong><?php echo htmlspecialchars($row['dateSent']); ?></strong></h4>
            <h5 class="card-text"><strong>Client Number:</strong> <?php echo htmlspecialchars($row['senderId']); ?></h5>
        </div>
    </a>

<?php } ?>

</div>
</div>
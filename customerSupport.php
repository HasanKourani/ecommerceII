<?php
require_once("nav.php");
require_once("config.php");

if(!isset($_SESSION['id'])){
    header('location:login.php');
}

$sql = "SELECT m.*, c.* FROM messages m JOIN clients c ON m.senderId = c.id WHERE receiverId='$_SESSION[id]' ORDER BY dateSent DESC";
$result = mysqli_query($link, $sql);

echo "<div class='w-100 m-5'>";
echo "<div class='d-flex flex-wrap justify-content-between align-items-center mb-5'>
    <h2>Messages</h2>
    <a href='userSendMessage.php' class='btn btn-primary fs-5'>Send a New Message</a>
    </div>";
echo "<div class='d-flex flex-wrap justify-content-around align-items-center mb-5'> ";

while($row = mysqli_fetch_assoc($result)) {
?>

    <a href="userMessages.php?id=<?php echo htmlspecialchars($row['msgId']);?>" class="text-decoration-none m-2"> 
        <div class="card p-5 ordersCard">
            <h2 class>Reply From:</h2>
            <h3 class="card-text"><strong></strong>Admin</h3>
            <h4 class="card-text">Sent at: <strong><?php echo htmlspecialchars($row['dateSent']); ?></strong></h4>
        </div>
    </a>

<?php } ?>

</div>

<?php
require_once("footer.php")
?>
</body>
</html>
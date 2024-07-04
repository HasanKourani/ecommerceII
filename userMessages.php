<?php
require_once("nav.php");
require_once("config.php");

if(!isset($_SESSION['id'])){
    header('location:login.php');
}


$query = "SELECT m.*, c.* FROM messages m JOIN clients c ON m.senderId = c.id WHERE msgId={$_GET['id']}";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_array($result);
echo "<div class='w-100 m-5'>";
?>
<div class='container'>
    
    <h1>Message From: Admin</h1>

    <div class="d-flex flex-column justify-content-between">
        <h4 class="mt-5 mb-5">Message Content:</h4>
        <textarea name="message" id="message"
        rows="8" cols="100" maxlength="2500"
        style="resize: none; outline: none;"
        class=" fs-2 bg-info text-white border border-0 rounded p-3"
        required readonly><?php echo htmlspecialchars($row['msg']) ?></textarea>
    </div>

</div>
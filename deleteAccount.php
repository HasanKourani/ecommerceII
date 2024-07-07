<?php
require_once('config.php');
require_once('nav.php');

if(!isset($_GET['id']))
header("location:home.php");

if(isset($_POST['submit'])){
    $client_id = $_GET['id'];
    $query = "DELETE FROM clients WHERE id=$client_id";
    $query1 = "DELETE FROM reviews WHERE user_id=$client_id";
    $query2 = "DELETE FROM messages WHERE (senderId=$client_id OR receiverId=$client_id)";
    $result2 = mysqli_query($link, $query2);
    $result1 = mysqli_query($link, $query1);
    $result = mysqli_query($link, $query);

    if($result){
        header("location:logout.php");
    }
}
?>

<div class="d-flex flex-column justify-content-evenly align-items-center" style="min-height:90vh;">
    <h1 class="text-danger">Are You Sure You Want To Delete Your Account?</h1>
    <form action="" method="post">
        <button type="submit" name="submit" class="btn btn-danger fs-2">DELETE ACCOUNT</button>
    </form>
</div>
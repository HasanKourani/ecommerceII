<?php

    if(!isset($_GET['id']))
    header("location:home.php");

    require_once("config.php");

    $sid=session_id();
    $user_id = $_SESSION['id'];

    $query="SELECT * FROM carts WHERE session_id='$sid' AND item_id={$_GET['id']} AND user_id='$user_id'";
    $result=mysqli_query($link,$query);

    if(mysqli_num_rows($result)>0){

        $query="UPDATE carts SET quantity = quantity+1
        WHERE session_id='$sid' AND item_id={$_GET['id']} AND user_id='$user_id'";

    } else {

        $query="INSERT INTO carts(user_id, session_id, item_id, quantity)
        VALUES('$user_id', '$sid',{$_GET['id']},1)";

    }
    
    mysqli_query($link,$query);
    header("location:cart.php");
?>
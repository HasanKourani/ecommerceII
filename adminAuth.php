<?php 
if(isset($_SESSION['loggedin'])){
    if($_SESSION['roleAs'] != 1){
        header('Location: home.php');
    }
} else {
    header('Location: login.php');
}
?>
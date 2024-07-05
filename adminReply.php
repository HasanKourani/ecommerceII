<?php 
require_once("config.php");
require_once("adminNav.php");

$query = "SELECT m.*, c.* FROM messages m JOIN clients c ON m.senderId = c.id WHERE msgId={$_GET['id']}";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_array($result);

if(isset($_POST['submit'])){
    $client_id = $row['senderId'];
    $admin_id = $row['receiverId'];
    $message = $_POST['message'];

    $sql = "INSERT INTO messages (senderId, receiverId, msg) VALUES('$admin_id', '$client_id', '$message')";
    mysqli_query($link, $sql);

    if(mysqli_affected_rows($link)>0){
        echo "<div class='w-100 m-2'>
        <div class='alert alert-success alert-dismissible'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Success!</strong> Message Sent.
      </div>";
      echo "<script>
        setTimeout(function() {
          window.location.href = 'messages.php';
        }, 3000);
      </script>";
      } else {
        echo "<div class='w-100 m-2'>
        <div class='alert alert-primary alert-dismissible'>
          <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          <strong>Error!</strong> No Message sent!
        </div>";
    }
}


?>
<div class='container'>
    <div class="d-flex flex-column justify-content-evenly m-5" style="min-height: 600px;">
        <h2>Reply to <?php echo htmlspecialchars($row['first_name']), ' ', htmlspecialchars($row['last_name']) ?></h2>

        <form action="" method="post" class="d-flex flex-column justify-content-between" style="min-height: 320px;">
            <div class="d-flex flex-column justify-content-between">
                <h4 class="mt-5">Message:</h4>
                <textarea name="message" id="message"
                rows="8" cols="100" maxlength="2500"
                style="resize: none; outline: none;"
                class="border border-0 rounded p-3 fs-4" required></textarea>
            </div>
            <button type="submit" class="align-self-start btn btn-primary fs-5 mt-5" name="submit">Reply</button>
        </form>
    </div>
</div>
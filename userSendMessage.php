<?php
require_once("nav.php");
require_once("config.php");

if(!isset($_SESSION['id'])){
    header('location:login.php');
}

$query = "SELECT id, first_name FROM clients WHERE roleAs='1'";
$result = mysqli_query($link, $query);
$admins = [];
while($row = mysqli_fetch_assoc($result)){
    $admins[] = $row;
}

if(isset($_POST['submit'])){
    $client_id = $_SESSION['id'];
    $admin_id = $_POST['admin'];
    $message = $_POST['message'];

    $sql = "INSERT INTO messages (senderId, receiverId, msg) VALUES('$client_id', '$admin_id', '$message')";
    mysqli_query($link, $sql);

    if(mysqli_affected_rows($link)>0){
        echo "<div class='w-100 m-2'>
        <div class='alert alert-success alert-dismissible'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Success!</strong> Message Sent.
      </div>";
      echo "<script>
        setTimeout(function() {
          window.location.href = 'customerSupport.php';
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

<h1 class="text-center mt-5">Customer Support</h1>

<div class="d-flex flex-column justify-content-evenly" style="min-height: 600px;">
    <h2>Write us a message</h2>

    <form action="" method="post" class="d-flex flex-column justify-content-between" style="min-height: 320px;">
        <label for="admin" class="form-label fw-bold fs-5">Choose Admin:</label>
        <select id="admin" name="admin" class="form-select btn btn-primary">
            <?php 
                foreach ($admins as $admin) { 
                    if ($row["id"] == $admin['id']) {
                        $selected = "selected";
                    } else {
                        $selected = "";
                    }
                    echo "<option value=\"{$admin['id']}\" $selected>{$admin['first_name']}</option>";
                } 
            ?>
        </select>
        <div class="d-flex flex-column justify-content-between">
            <h4 class="mt-5">Message:</h4>
            <textarea name="message" id="message"
            rows="8" cols="100" maxlength="2500"
            style="resize: none; outline: none;"
            required></textarea>
        </div>
        <button type="submit" class="align-self-start btn btn-primary fs-5 mt-5" name="submit">Send Message</button>
    </form>
</div>

</div>

<?php
require_once("footer.php")
?>
</body>
</html>
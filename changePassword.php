<?php
require_once("config.php");
require_once("nav.php");

if(!isset($_SESSION['id']))
header(("location:login.php"));

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oldPass = $_POST['oldPass'];
    $newPass = $_POST['newPass'];
    $cnfmNewPass = $_POST['cnfmNewPass'];

    if($newPass !== $cnfmNewPass) {
    echo 
        "<div class='alert alert-danger alert-dismissible'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Error!</strong> New passwords do not match.
        </div>";
    } else {
        $query = "SELECT password FROM clients WHERE id = {$_SESSION['id']}";
        $result = mysqli_query($link, $query);

        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $storedHash = $row['password'];

            if(md5($oldPass) === $storedHash) {
                $newHashed = md5($newPass);
                $update = "UPDATE clients SET password = '$newHashed' WHERE id = {$_SESSION['id']}";
                mysqli_query($link, $update);

                if (mysqli_affected_rows($link) > 0) {
                    echo "<div class='alert alert-success alert-dismissible'>
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            <strong>Success!</strong> Password Changed.
                          </div>";
                    echo "<script>
                            setTimeout(function() {
                                window.location.href = 'home.php';
                            }, 3000);
                          </script>";
                } else {
                    echo "<div class='alert alert-danger alert-dismissible'>
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            <strong>Error!</strong> Password update failed. Please try again.
                          </div>";
                }
            } else {
                echo "<div class='alert alert-danger alert-dismissible'>
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        <strong>Error!</strong> Old password is incorrect.
                      </div>";
            }
        } else {
            echo "<div class='alert alert-danger alert-dismissible'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    <strong>Error!</strong> User not found.
                  </div>";
        }
    }
}

$query = "SELECT email FROM clients WHERE id = {$_SESSION['id']}";
$result = mysqli_query($link, $query);
if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
}
?>

<form action='changePassword.php' method='post'>
    <div class="mb-3 mt-3">
        <label for="email" class="form-label">Email: *</label>
        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email"  required
        value="<?php echo $row['email'];?>" disabled>
    </div>
    <div class="mb-3 mt-3">
        <label for="oldPass" class="form-label">Old Password: *</label>
        <input type="password" class="form-control" id="oldPass" placeholder="Old Password"
         name="oldPass" required>
    </div>
    <div class="mb-3 mt-3">
        <label for="newPass" class="form-label">New Password: *</label>
        <input type="password" class="form-control" id="newPass" placeholder="New Password"
         name="newPass" required>
    </div>
    <div class="mb-3 mt-3">
        <label for="cnfmNewPass" class="form-label">Confirm New Password: *</label>
        <input type="password" class="form-control" id="cnfmNewPass" placeholder="Confrim New Password"
         name="cnfmNewPass" required>
    </div>
    <button type="submit" class="btn btn-primary">UPDATE</button>
</form>

<?php
require_once("footer.php")
?>
</body>
</html>
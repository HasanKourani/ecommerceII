<?php
require_once("nav.php");
require_once("config.php");
?>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_SESSION['email'];   
  $fn = $_POST['fn'];
  $ln = $_POST['ln'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $country = $_POST['country']; 
  $phone = $_POST['phone'];

  $query="UPDATE clients SET first_name='$fn',last_name='$ln',address='$address',city='$city',
  country='$country',phone='$phone'
  WHERE id={$_SESSION['id']}";
    mysqli_query($link,$query);
    if(mysqli_affected_rows($link)>0){
      echo "<div class='alert alert-success alert-dismissible'>
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Success!</strong> Profile is updated.
    </div>";
    $_SESSION['fn'] = $fn;
    $_SESSION['ln'] = $ln;
    echo "<script>
      setTimeout(function() {
        window.location.href = 'profile.php';
      }, 3000);
    </script>";
    } else {
      echo "<div class='alert alert-danger alert-dismissible'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Error!</strong> Profile is not updated.
      </div>";
    }
}

else{
  $email =  $pwd =  $cpwd =  $fn = $ln = $address = $city = $country =  $phone = " ";
}
$query="SELECT * FROM clients WHERE id = {$_SESSION['id']}";
$result=mysqli_query($link,$query);
if(mysqli_num_rows($result) == 1){
  $row=mysqli_fetch_array($result);
}
else{
  header("logout.php");
} 
?>

<form action="profile.php" method="post">
  <div class="mb-3 mt-3">
    <label for="email" class="form-label">Email: *</label>
    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email"  required
    value="<?php echo $row['email'];?>" disabled>
  </div>
  <div class="mb-3">
    <label for="fn" class="form-label">First Name:</label>
    <input type="text" class="form-control" id="fn" placeholder="Enter First Name" name="fn" required
    value="<?php echo $row['first_name'];?>">
  </div>
  <div class="mb-3">
    <label for="ln" class="form-label">Last Name:</label>
    <input type="text" class="form-control" id="ln" placeholder="Enter Last Name" name="ln" required
    value="<?php echo $row['last_name'];?>">
  </div>
  <div class="mb-3">
    <label for="address" class="form-label">Address:</label>
    <input type="text" class="form-control" id="address" placeholder="Enter Address" name="address"
    value="<?php echo $row['address'];?>">
  </div>
  <div class="mb-3">
    <label for="city" class="form-label">City:</label>
    <input type="text" class="form-control" id="city" placeholder="Enter City" name="city"
    value="<?php echo $row['city'];?>">
  </div>
  <div class="mb-3">
    <label for="country" class="form-label">Country:</label>
    <input type="text" class="form-control" id="country" placeholder="Enter Country" name="country"
    value="<?php echo $row['country'];?>">
  </div>
  <div class="mb-3">
    <label for="phone" class="form-label">Phone:</label>
    <input type="text" class="form-control" id="phone" placeholder="Enter Phone" name="phone"
    value="<?php echo $row['phone'];?>">
  </div>
  <button type="submit" class="btn btn-primary">UPDATE</button>
</form>
</div>

<?php
require_once("footer.php")
?>
</body>
</html>

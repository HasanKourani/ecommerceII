<?php
require_once("nav.php");
require_once("config.php");
if(!isset($_POST['submit'])) {
  $create = "CREATE TABLE IF NOT EXISTS clients (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      email VARCHAR(255) UNIQUE,
      password VARCHAR(255),
      first_name VARCHAR(255),
      last_name VARCHAR(255),
      address VARCHAR(255),
      city VARCHAR(255),
      country VARCHAR(255),
      phone VARCHAR(255)
  )";
  if (mysqli_query($link, $create)) {
      true;
  } else {
      echo "Error creating table: " . mysqli_error($link);
  } ?>
  <?php
} else {
  $email = $_POST['email'];  
  $pwd = $_POST['pswd'];  
  $cpwd = $_POST['cpswd']; 
  $fn = $_POST['fn'];
  $ln = $_POST['ln'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $country = $_POST['country']; 
  $phone = $_POST['phone'];

  if($pwd != $cpwd ){
    echo "<div class='alert alert-danger alert-dismissible'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    <strong>Error!</strong> Confirm Password must match Password.
  </div>";
  } else {
  $sql = "SELECT * FROM clients WHERE email='$email'";
  $result = mysqli_query($link, $sql);

  if(mysqli_num_rows($result) > 0) {
    echo "<div class='alert alert-danger alert-dismissible'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    <strong>Error!</strong> Email already used.
    </div>";
  } else {
    $hashedpwd=md5($pwd);
    $query = "INSERT IGNORE INTO clients (email, password, first_name, last_name, address, city, country, phone)
    VALUES ('$email', '$hashedpwd', '$fn', '$ln', '$address', '$city', '$country','$phone')";
    $qresult = mysqli_query($link, $query);
    if($qresult){
      $_SESSION['id'] = mysqli_insert_id($link);
      $_SESSION['email'] = $email;
      $_SESSION['fn'] = $fn;
      $_SESSION['ln'] = $ln;
      header("location:home.php");
      exit();
    } else {
      die("something went wrong". mysqli_error($link));
    }
  }
}
}
?>
<form action="register.php" method="post">
    <div class="mb-3 mt-3">
      <label for="email" class="form-label">Email: *</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email"  required>
    </div>
    <div class="mb-3">
      <label for="pwd" class="form-label">Password: *</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required >
    </div>
    <div class="mb-3">
      <label for="pwd" class="form-label">Confirm Password: *</label>
      <input type="password" class="form-control" id="cpwd" placeholder="Enter password" name="cpswd" required>
    </div>
    <div class="mb-3">
      <label for="fn" class="form-label">First Name: *</label>
      <input type="text" class="form-control" id="fn" placeholder="Enter First Name" name="fn" required>
    </div>
    <div class="mb-3">
        <label for="ln" class="form-label">Last Name: *</label>
        <input type="text" class="form-control" id="ln" placeholder="Enter Last Name" name="ln" required>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address:</label>
        <input type="text" class="form-control" id="address" placeholder="Enter Address" name="address">
    </div>
    <div class="mb-3">
        <label for="city" class="form-label">City:</label>
        <input type="text" class="form-control" id="city" placeholder="Enter City" name="city">
    </div>
    <div class="mb-3">
        <label for="country" class="form-label">Country:</label>
        <input type="text" class="form-control" id="country" placeholder="Enter Country " name="country">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone:</label>
        <input type="text" class="form-control" id="phone" placeholder="Enter Phone" name="phone">
    </div>
      <button type="submit" class="btn btn-primary" name="submit">Create an account</button>
      <a href="login.php" class="btn btn-danger">Already have an account? Log In</a>
  </form>
</div>

<?php
require_once("footer.php")
?>
</body>
</html>

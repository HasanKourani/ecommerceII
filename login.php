<?php
require_once("config.php");
require_once("nav.php");

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email=$_POST['email'];
  $pwd=$_POST['pswd'];

  if(isset($_POST['remember'])){
    setcookie("client_email",$email,time()+30*24*60*60);
    setcookie("client_pwd",$pwd);
  }

  $c_pwd=md5($pwd);
  $query="SELECT * FROM clients WHERE email='$email' and password='$c_pwd'";
  $result=mysqli_query($link,$query);

  if(mysqli_num_rows($result)==1){
    $row = mysqli_fetch_array($result);
    $_SESSION['id'] =$row['id'] ;
    $_SESSION['email'] =  $row['email'];
    $_SESSION['fn'] = $row['first_name'];
    $_SESSION['ln'] = $row['last_name'];
    $_SESSION['roleAs'] = $row['roleAs'];
    $_SESSION['loggedin'] = true;

    $roleAs = $_SESSION['roleAs'];

    if($roleAs == 0){
      header("location:home.php");
    } else {
      header("location:admin.php");
    }
  }

  else{
    echo "<div class='alert alert-danger alert-dismissible'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    <strong>Error!</strong> Incorrect Email or Password.
    </div>";
  }

} elseif(isset($_COOKIE['client_email'],$_COOKIE['client_pwd'])){
    $email=$_COOKIE['client_email'];
    $pwd=$_COOKIE['client_pwd'];
  }
  else{ $email=$pwd =" "; }

?>
<form action="login.php" method="post">
  <div class="mb-3 mt-3">
  <label for="email" class="form-label">Email:</label>
  <input type="email" class="form-control" id="email" placeholder="Enter email" name="email"
  value="<?php echo $email;?>">
  </div>
  <div class="mb-3">
  <label for="pwd" class="form-label">Password:</label>
  <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
  </div>
  <div class="form-check mb-3">
  <label class="form-check-label">
  <input class="form-check-input" type="checkbox" name="remember"> Remember me
  </label>
  </div>
  <button type="submit" class="btn btn-primary">Log In</button>
  <a href="register.php" class="btn btn-danger">Don't have an Account? Sign Up</a>
</form>

</div>

<?php
require_once("footer.php")
?>
</body>
</html>




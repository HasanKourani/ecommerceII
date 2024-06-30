<?php 
require_once("config.php");
require_once("adminNav.php");

if(!isset($_GET['id']))
header("location:adminProducts.php");

$query="SELECT * FROM car_models WHERE id = {$_GET['id']}";
$result = mysqli_query($link,$query);

if(mysqli_num_rows($result) == 1) {
    $row=mysqli_fetch_array($result);
} else {
    header("models.php");
} 

if(isset($_POST['btnEdit'])) { 
    $modelName = $_POST['modelName'];

    $update = "UPDATE car_models SET modelName='$modelName' WHERE id = {$_GET['id']}";
    mysqli_query($link, $update);

    if(isset($_FILES['my_image']) && $_FILES['my_image']['size'] > 0) {
        $id = mysqli_insert_id($link);
        $a = explode('.', $_FILES['my_image']['name']);
        $ext = $a[count($a)-1];
        $name = "$id.$ext";
        $query = "UPDATE cars SET photo='$name'
                    WHERE id = {$_GET['id']}";
        mysqli_query($link, $query);
        copy($_FILES['my_image']["tmp_name"], "image/$name");
    }
    if(mysqli_affected_rows($link)>0){
        echo "<div class='w-100 m-2'>
        <div class='alert alert-success alert-dismissible'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Success!</strong> Car Details Updated.
      </div>";
      echo "<script>
        setTimeout(function() {
          window.location.href = 'models.php';
        }, 2000);
      </script>";
      } else {
        echo "<div class='w-100 m-2'>
        <div class='alert alert-primary alert-dismissible'>
          <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          <strong>Error!</strong> Model is NOT Updated!
        </div>";
    }
}
?>
<div class='w-100 m-5'>

    <form action="" enctype="multipart/form-data" method="post">

        <p class="fw-bold fs-5"><label for="image">Image</label></p>
        <img src="image/<?php echo $row['modelPhoto']?>" name="image" alt="Car Photo" style="width: 400px;" class="mb-3">

        <div class="mb-3">
            <p class="fw-bold fs-5"><label>Change Image:</label></p>
            <input type="file" name="my_image" class="btn btn-primary">
        </div>

        <div class="mb-3 mt-3">
            <label for="modelName" class="form-label fw-bold fs-5">Model Name:</label>
            <input type="text" class="form-control" id="modelName" placeholder="Car Name" name="modelName"
            value="<?php echo $row['modelName'];?>">
        </div>

        <button type="submit" class="btn btn-primary" name="btnEdit">EDIT</button>

    </form>

</div>
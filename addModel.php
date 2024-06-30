<?php 
require_once("adminNav.php");
require_once("config.php");


if(isset($_POST['btnAdd'])) { 
    $modelName = $_POST['modelName'];

    $insert = "INSERT INTO car_models (modelName, modelPhoto)
    VALUES ('$modelName', null)";
    mysqli_query($link, $insert);

    if(isset($_FILES['my_image']) && $_FILES['my_image']['size'] > 0) {
        $id = mysqli_insert_id($link);
        $a = explode('.', $_FILES['my_image']['name']);
        $ext = $a[count($a)-1];
        $name = "$id.$ext";
        $query = "UPDATE car_models SET modelPhoto='$name'
                    WHERE id = $id";
        mysqli_query($link, $query);
        copy($_FILES['my_image']["tmp_name"], "image/$name");
    }
    if(mysqli_affected_rows($link) > 0){
        echo "<div class='w-100 m-2'>
        <div class='alert alert-success alert-dismissible'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Success!</strong> New Model Added.
      </div>";
      echo "<script>
        setTimeout(function() {
          window.location.href = 'models.php';
        }, 2000);
      </script>";
    }
}
?>
<div class='w-100 m-5'>

    <form action="" method="post" enctype="multipart/form-data">

        <div class="mb-3">
            <p class="fw-bold fs-5"><label>Insert Image:</label></p>
            <input type="file" name="my_image" class="btn btn-primary" required>
        </div>

        <div class="mb-3 mt-3">
            <label for="modelName" class="form-label fw-bold fs-5">Car Model:</label>
            <input type="text" class="form-control" id="modelName" placeholder="Enter Car Name" name="modelName" required>
        </div>

        <button type="submit" class="btn btn-primary" name="btnAdd">ADD</button>

    </form>
</div>
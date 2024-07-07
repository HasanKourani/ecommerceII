<?php 
require_once("config.php");

if(!isset($_GET['id']))
header("location:adminProducts.php");

$query="SELECT * FROM carsforsale WHERE id = {$_GET['id']}";
$result = mysqli_query($link,$query);

$query2="SELECT * FROM carsforrent WHERE id = {$_GET['id']}";
$result2 = mysqli_query($link,$query2);

$query1 = "SELECT id, modelName FROM car_models";
$result1 = mysqli_query($link, $query1);
$car_models = [];
while($row1 = mysqli_fetch_assoc($result1)){
    $car_models[] = $row1;
}

if(mysqli_num_rows($result) == 1) {
    $row=mysqli_fetch_array($result);
} else {
    header("adminProducts.php");
}

if(mysqli_num_rows($result2) == 1) {
    $row=mysqli_fetch_array($result2);
} else {
    header("adminProductsRental.php");
} 

if(isset($_POST['btnEdit'])) {

    if($_GET['status'] == 'sale') {
        $carName = $_POST['carName'];
        $carPrice = $_POST['carPrice'];
        $carYear = $_POST['carYear'];
        $carStatus = $_POST['carStatus'];
        $owners = $_POST['owners'];
        $distance = $_POST['distance']; 
        $gearType = $_POST['gearType'];
        $stock = $_POST['stock'];
        $model_id = $_POST['model_id'];
        $description = $_POST['description'];

        $update = "UPDATE carsforsale SET carName='$carName', carYear='$carYear', 
        carPrice='$carPrice', carStatus='$carStatus', owners='$owners',
        distance='$distance', gearType='$gearType', stock='$stock', photo='{$row['photo']}',
        model_id='$model_id', description='$description' WHERE id = {$_GET['id']}";
        mysqli_query($link, $update);

        if(isset($_FILES['my_image']) && $_FILES['my_image']['size'] > 0) {
            $id = mysqli_insert_id($link);
            $a = explode('.', $_FILES['my_image']['name']);
            $ext = $a[count($a)-1];
            $name = "$id.$ext";
            $query = "UPDATE carsforsale SET photo='$name'
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
            window.location.href = 'adminProducts.php';
            }, 200);
        </script>";
        } else {
            echo "<div class='w-100 m-2'>
            <div class='alert alert-primary alert-dismissible'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Error!</strong> Car is NOT Updated!
            </div>";
        }
    } elseif($_GET['status'] == 'rent') {
        $carName = $_POST['carName'];
        $rentFee = $_POST['rentFee'];
        $carYear = $_POST['carYear'];
        $carStatus = $_POST['carStatus'];
        $distance = $_POST['distance']; 
        $gearType = $_POST['gearType'];
        $model_id = $_POST['model_id'];
        $description = $_POST['description'];

        $update = "UPDATE carsforrent SET carName='$carName', rentFee='$rentFee',
        carYear='$carYear', carStatus='$carStatus', distance='$distance',
        gearType='$gearType', photo='{$row['photo']}', model_id='$model_id',
        description='$description' WHERE id = {$_GET['id']}";
        mysqli_query($link, $update);

        if(isset($_FILES['my_image']) && $_FILES['my_image']['size'] > 0) {
            $id = mysqli_insert_id($link);
            $a = explode('.', $_FILES['my_image']['name']);
            $ext = $a[count($a)-1];
            $name = "$id.$ext";
            $query = "UPDATE carsforrent SET photo='$name'
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
            window.location.href = 'adminProductsRental.php';
            }, 200);
        </script>";
        } else {
            echo "<div class='w-100 m-2'>
            <div class='alert alert-primary alert-dismissible'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Error!</strong> Car is NOT Updated!
            </div>";
        }
    }
}

require_once("adminNav.php");
?>
<div class='w-100 m-5'>

    <form action="" enctype="multipart/form-data" method="post">

        <p class="fw-bold fs-5"><label for="image">Image</label></p>
        <img src="image/<?php echo $row['photo']?>" name="image" alt="Car Photo" style="width: 400px;" class="mb-3">

        <div class="mb-3">
            <p class="fw-bold fs-5"><label>Change Image:</label></p>
            <input type="file" name="my_image" class="btn btn-primary">
        </div>

        <div class="mb-3 mt-3">
            <label for="carName" class="form-label fw-bold fs-5">Car Name:</label>
            <input type="text" class="form-control" id="carName" placeholder="Car Name" name="carName"
            value="<?php echo $row['carName'];?>">
        </div>

        <?php if($_GET['status']=='sale') { ?>
            <div class="mb-3">
                <label for="carPrice" class="form-label fw-bold fs-5">Car Price:</label>
                <input type="number" class="form-control" id="carPrice" placeholder="Car Price: in $" name="carPrice"
                value="<?php echo $row['carPrice'];?>">
            </div>
        <?php } else { ?>
            <div class="mb-3">
                <label for="rentFee" class="form-label fw-bold fs-5">Rent Fee:</label>
                <input type="number" class="form-control" id="rentFee" placeholder="Rent Fee: in $" name="rentFee"
                value="<?php echo $row['rentFee']; ?>">
            </div>
        <?php } ?>

        <div class="mb-3">
            <label for="carYear" class="form-label fw-bold fs-5">Car Year:</label>
            <input type="number" class="form-control" id="carYear" placeholder="Car Year" name="carYear"
            value="<?php echo $row['carYear'];?>">
        </div>

        <div class="mb-3">
            <label for="carStatus" class="form-label fw-bold fs-5">Car Status:</label>
            <select id="carStatus" name="carStatus" class="btn btn-primary">
                <?php 
                    $status = array("New", "Used");
                    foreach ($status as $value) {
                        if($row["carStatus"] == $value)
                            $s = "selected";
                        else
                            $s="";
                        echo "<option value='$value' $s>$value</option>";
                    }
                ?>
            </select>
        </div>

        <?php if($_GET['status']=='sale') { ?>
            <div class="mb-3">
                <label for="owners" class="form-label fw-bold fs-5">Number of Previous Owners:</label>
                <input type="number" class="form-control" id="owners" placeholder="Number of Previous Owners" name="owners"
                value="<?php echo $row['owners'];?>">
            </div>
        <?php } ?>

        <div class="mb-3">
            <label for="distance" class="form-label fw-bold fs-5">Distance Travelled:</label>
            <input type="number" class="form-control" id="distance" placeholder="Distance Travelled: in KM" name="distance"
            value="<?php echo $row['distance'];?>">
        </div>

        <div class="mb-3">
            <label for="gearType" class="form-label fw-bold fs-5">Gear Type:</label>
            <select id="gearType" name="gearType" class="btn btn-primary">
                <?php 
                    $status = array("Automatic", "Sequential");
                    foreach ($status as $value) {
                        if($row["gearType"] == $value)
                            $s = "selected";
                        else
                            $s="";
                        echo "<option value='$value' $s>$value</option>";
                    }
                ?>
            </select>
        </div>

        <?php if($_GET['status']=='sale') { ?>
            <div class="mb-3">
                <label for="stock" class="form-label fw-bold fs-5">Available in Stock:</label>
                <input type="number" class="form-control" id="stock" placeholder="Available in Stock" name="stock"
                value="<?php echo $row['stock'];?>">
            </div>
        <?php } ?>

        <div class="mb-3">
            <label for="model_id" class="form-label fw-bold fs-5">Car Model:</label>
            <select id="model_id" name="model_id" class="form-select btn btn-primary">
                <?php 
                    foreach ($car_models as $model) { 
                        if ($row["model_id"] == $model['id']) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                        echo "<option value=\"{$model['id']}\" $selected>{$model['modelName']}</option>";
                    } 
                ?>
            </select>
        </div>

        <div class="mb-3">
            <p><label for="description" class="form-label fw-bold fs-5">Description:</label></p>
            <textarea name="description" id="description" rows="4" cols="100" maxlength="255" style="resize: none;"><?php echo $row['description'];?></textarea>
        </div>

        <button type="submit" class="btn btn-primary" name="btnEdit">EDIT</button>

    </form>

</div>
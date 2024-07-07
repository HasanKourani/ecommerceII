<?php
require_once("config.php");
require_once("adminNav.php");


$query = "SELECT id, modelName FROM car_models";
$result = mysqli_query($link, $query);
$carModels = [];
while ($row = mysqli_fetch_assoc($result)) {
    $carModels[] = $row;
}

if(isset($_POST['btnAdd'])) {

    if($_GET['status'] == 'sale'){
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

        $insert = "INSERT INTO carsforsale (carName, carPrice, carYear, carStatus, owners, distance, gearType, stock, photo, model_id, description)
        VALUES ('$carName', '$carPrice', '$carYear', '$carStatus', '$owners', '$distance', '$gearType', '$stock', null, '$model_id', '$description')";
        mysqli_query($link, $insert);

        if(isset($_FILES['my_image']) && $_FILES['my_image']['size'] > 0) {
            $id = mysqli_insert_id($link);
            $a = explode('.', $_FILES['my_image']['name']);
            $ext = $a[count($a)-1];
            $name = "$id.$ext";
            $query = "UPDATE carsforsale SET photo='$name'
                        WHERE id  = $id";
            mysqli_query($link, $query);
            copy($_FILES['my_image']["tmp_name"], "image/$name");
        }
        if(mysqli_affected_rows($link) > 0){
            echo "<div class='w-100 m-2'>
            <div class='alert alert-success alert-dismissible'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Success!</strong> New Car Added.
        </div>";
        echo "<script>
            setTimeout(function() {
            window.location.href = 'adminProducts.php';
            }, 2000);
        </script>";
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

        $insert = "INSERT INTO carsforrent (carName, carYear, carStatus, rentFee, distance, gearType, photo, model_id, description)
        VALUES ('$carName', '$carYear', '$carStatus', '$rentFee', '$distance', '$gearType', null, '$model_id', '$description')";
        mysqli_query($link, $insert);

        if(isset($_FILES['my_image']) && $_FILES['my_image']['size'] > 0) {
            $id = mysqli_insert_id($link);
            $a = explode('.', $_FILES['my_image']['name']);
            $ext = $a[count($a)-1];
            $name = "$id.$ext";
            $query = "UPDATE carsforrent SET photo='$name'
                        WHERE id  = $id";
            mysqli_query($link, $query);
            copy($_FILES['my_image']["tmp_name"], "image/$name");
        }
        if(mysqli_affected_rows($link) > 0){
            echo "<div class='w-100 m-2'>
            <div class='alert alert-success alert-dismissible'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Success!</strong> New Car Added.
        </div>";
        echo "<script>
            setTimeout(function() {
            window.location.href = 'adminProductsRental.php';
            }, 2000);
        </script>";
        }
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
            <label for="carName" class="form-label fw-bold fs-5">Car Name:</label>
            <input type="text" class="form-control" id="carName" placeholder="Enter Car Name" name="carName" required>
        </div>
        <?php if($_GET['status']=='sale') { ?>
            <div class="mb-3">
                <label for="carPrice" class="form-label fw-bold fs-5">Car Price:</label>
                <input type="number" class="form-control" id="carPrice" placeholder="Car Price: in $" name="carPrice" required>
            </div>
        <?php } else { ?>
            <div class="mb-3">
                <label for="rentFee" class="form-label fw-bold fs-5">Rent Fee:</label>
                <input type="number" class="form-control" id="rentFee" placeholder="Rent Fee: in $" name="rentFee" required>
            </div>
        <?php } ?>

        <div class="mb-3">
            <label for="carYear" class="form-label fw-bold fs-5">Car Year:</label>
            <input type="number" class="form-control" id="carYear" placeholder="Car Year" name="carYear" required>
        </div>

        <div class="mb-3">
            <label for="carStatus" class="form-label fw-bold fs-5">Car Status:</label>
            <select id="carStatus" name="carStatus" class="btn btn-primary">
                <option value="New">New</option>
                <option value="Used">Used</option>
            </select>
        </div>

        <?php if($_GET['status']=='sale') { ?>
            <div class="mb-3">
                <label for="owners" class="form-label fw-bold fs-5">Number of Previous Owners:</label>
                <input type="number" class="form-control" id="owners" placeholder="Number of Previous Owners" name="owners">
            </div>
        <?php } ?>

        <div class="mb-3">
            <label for="distance" class="form-label fw-bold fs-5">Distance Travelled:</label>
            <input type="number" class="form-control" id="distance" placeholder="Distance Travelled: in KM" name="distance">
        </div>

        <div class="mb-3">
            <label for="gearType" class="form-label fw-bold fs-5">Gear Type:</label>
            <select id="gearType" name="gearType" class="btn btn-primary">
                <option value="Sequential">Sequential</option>
                <option value="Automatic">Automatic</option>
            </select>
        </div>
        
        <?php if($_GET['status']=='sale') { ?>
            <div class="mb-3">
                <label for="stock" class="form-label fw-bold fs-5">Available in Stock:</label>
                <input type="number" class="form-control" id="stock" placeholder="Available in Stock" name="stock" required>
            </div>
        <?php } ?>

        <div class="mb-3">
            <label for="model_id" class="form-label fw-bold fs-5">Car Model:</label>
            <select id="model_id" name="model_id" class="form-select btn btn-primary" required>
                <?php foreach ($carModels as $model): ?>
                    <option value="<?= $model['id'] ?>"><?= $model['modelName'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <p><label for="description" class="form-label fw-bold fs-5">Description:</label></p>
            <textarea name="description" id="description" rows="4" cols="100" maxlength="255" style="resize: none;"></textarea>
        </div>

        <button type="submit" class="btn btn-primary" name="btnAdd">ADD</button>

    </form>
</div>
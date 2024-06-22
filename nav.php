<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Dealership</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/17fed53362.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-dark-subtle">
    <nav class="navbar navbar-expand-sm text-bg-dark navbar-dark fw-bold">
        <div class="container-fluid d-flex align-items-center">
            <a class="navbar-brand" href="home.php">Car Dealership</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav me-auto d-flex align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Car Models</a>
                        <ul class="dropdown-menu">
                            <a href="products.php" class='dropdown-item'>ALL CARS</a>
                            <?php
                            require_once("config.php");
                            $sql = "SELECT * FROM car_models ORDER BY modelName";
                            $result = mysqli_query($link, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<li><a class='dropdown-item' href='products.php?id={$row['id']}'>{$row['modelName']}</a></li>";
                            }
                            ?>
                        </ul>
                    </li>
                    <li>
                    <?php
                    if (isset($_SESSION['fn']) && isset($_SESSION['ln'])) {
                        echo "
                        <li class='nav-item dropdown'>
                            <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown'>Welcome, {$_SESSION['fn']}</a>
                            <ul class='dropdown-menu'>
                                <li><a class='dropdown-item' href='profile.php'>Profile</a></li>
                                <li><a class='dropdown-item' href='changePassword.php'>Change Password</a></li>
                            </ul>
                        </li>
                        <li><a class='nav-link' href='logout.php'>Logout</a></li>";
                    } else {
                        echo "<li class='nav-item'>
                            <a class='nav-link' href='register.php'>Register</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='login.php'>Login</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='adminLogin.php'>Admin</a>
                        </li>";
                    }
                    ?>
                    </li>
                </ul>
                <form class="d-flex align-items-center" method="get" action="products.php">
                    <a href="wishlist.php" class="me-4"><i class="fa-solid fa-heart"></i></a>
                    <input class="form-control me-2" type="text" placeholder="Search" name="txtSearch">
                    <?php
                    if (isset($_GET['id'])) {
                        echo "<input type='hidden' name='id' value='{$_GET['id']}'>";
                    }
                    ?>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                </form>
                <ul class='navbar-nav'>
                </ul>
            </div>
        </div>
    </nav>
<div class="container mt-3">
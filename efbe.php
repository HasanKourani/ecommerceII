<?php 
require_once("config.php");
require_once("adminAuth.php");
?>

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
<body>
    <div class="d-flex">
        <nav class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark vh-100" style="width: 280px;">
            <a href="admin.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">Admin Panel</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="admin.php" class="nav-link text-white">
                        <i class="fa fa-dashboard m-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="adminProducts.php" class="nav-link text-white">
                        <i class="fa-solid fa-list m-2"></i>
                        Products For Sale
                    </a>
                </li>
                <li>
                    <a href="adminProductsRental.php" class="nav-link text-white">
                        <i class="fa-solid fa-list m-2"></i>
                        Products For Rental
                    </a>
                </li>
                <li>
                    <a href="models.php" class="nav-link text-white">
                    <i class="fa-solid fa-car m-2"></i>
                        Models
                    </a>
                </li>
                <li>
                    <a href="orders.php" class="nav-link text-white">
                        <i class="fa fa-calendar m-2"></i>
                        Orders
                    </a>
                </li>
                <li>
                    <a href="soldProducts.php" class="nav-link text-white">
                        <i class="fa-solid fa-dollar m-2"></i>
                        Sold Cars
                    </a>
                </li>
                <li>
                    <a href="rentedProducts.php" class="nav-link text-white">
                        <i class="fa-solid fa-r m-2"></i>
                        Rented Cars
                    </a>
                </li>
                <li>
                    <a href="clients.php" class="nav-link text-white">
                        <i class="fa fa-user m-2"></i>
                        Customers
                    </a>
                </li>
                <li>
                    <a href="messages.php" class="nav-link text-white">
                        <i class="fas fa-comment-dots m-2"></i>
                        Messages
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <strong>Hello, Admin</strong>
                </a>
                <ul class="dropdown-menu text-bg-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item text-primary" href="changePassword.php">Change Password</a></li>
                    <li><a class="dropdown-item text-primary" href="profile.php">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-primary" href="logout.php">Log Out</a></li>
                </ul>
            </div>
        </nav>
        <main class="flex-grow-1 p-3">
            <!-- Content of admin.php goes here -->
        </main>
    </div>
</body>
</html>

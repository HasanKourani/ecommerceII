<?php


if (session_status() == PHP_SESSION_NONE) {

  session_save_path("SESSION");

  session_start();
}


$link = mysqli_connect("localhost", "root", "", "shopping2324")
  or die("Unable to reach MySQL Server");
  
  $create = "CREATE TABLE IF NOT EXISTS car_models (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    modelName VARCHAR(255)
  )";
  $create1 = "CREATE TABLE IF NOT EXISTS cars (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    carName VARCHAR(255),
    carPrice VARCHAR(255),
    carYear VARCHAR(255),
    carStatus VARCHAR(255),
    owners VARCHAR(255),
    distance VARCHAR(255),
    gearType VARCHAR(255),
    stock VARCHAR(255),
    photo VARCHAR(255),
    model_id INT(6) UNSIGNED,
    description VARCHAR(255),
    FOREIGN KEY (model_id) REFERENCES car_models(id)
  )";
  $create2 = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50),
    lastName VARCHAR(50),
    email VARCHAR(100),
    shippingAddress VARCHAR(255),
    city VARCHAR(50),
    zip VARCHAR(20),
    country VARCHAR(50),
    phone VARCHAR(20),
    orderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );";
  $create3= "CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    item_id INT,
    quantity INT,
    price DECIMAL(10, 2),
    total DECIMAL(10, 2)
  )";
  if (mysqli_query($link, $create) && mysqli_query($link, $create1) && mysqli_query($link, $create2) && mysqli_query($link, $create3)) {
    true;
  }
?> 
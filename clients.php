<?php

require_once("config.php");
require_once("adminNav.php");

$query = "SELECT * FROM clients WHERE roleAs=0";
$result = mysqli_query($link, $query);
echo "<div class='w-100 m-5'>";
echo "<h1 class='text-start mb-5'> Current Customers </h1>";
echo "<table class='table table-striped' style='height:10vh;'>";
echo "<tr class='table-primary'><th>First Name</th><th>Last Name</th><th>Phone</th> </tr>";

while($row = mysqli_fetch_array($result)){

    echo "<tr>

        <td>{$row['first_name']}</td>

        <td>{$row['last_name']}</td>

        <td>{$row['phone']}</td>";
}

echo "</table>";
echo "</div>";
?>

</div>
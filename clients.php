<?php
require_once("adminNav.php");
require_once("config.php");

$query = "SELECT * FROM clients WHERE roleAs=0";
$result = mysqli_query($link, $query);
echo "<div class='w-100 m-5'>";
echo "<h1 class='text-center mb-5'> Current Customers </h1>";
echo "<table class='table table-striped' style='height:50vh;'>";
echo "<tr class='table-primary text-center'><th>First Name</th><th>Last Name</th><th>Phone</th> </tr>";

$rowColor = 0;

while($row = mysqli_fetch_array($result)){

    $rowClass = $rowColor % 2 == 0 ? 'table-danger' : 'table-success';

    echo "<tr class='{$rowClass} text-center'>

        <td>{$row['first_name']}</td>

        <td>{$row['last_name']}</td>

        <td>{$row['phone']}</td>";

    $rowColor++;
}

echo "</table>";
echo "</div>";
?>

</div>
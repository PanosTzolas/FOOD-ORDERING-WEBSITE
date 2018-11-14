<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php

$q = intval($_GET['q']);
 $conn = new mysqli("localhost","root","","complete_food_store_db"   );
                                 if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

mysqli_select_db($conn,"ajax_demo");
$sql="SELECT distance,delivers FROM daily WHERE daily_id = '".$q."'";
$result = mysqli_query($conn,$sql);
echo "<table bgcolor=\"#FFFFFF\">
<tr>
<th>distance</th>
<th>delivers</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['distance'] . "</td>";
    echo "<td>" . $row['delivers'] . "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($conn);
?>
</body>
</html>
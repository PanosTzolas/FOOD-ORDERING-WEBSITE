<?php
session_start();
if(isset($_COOKIE["lat"])){
$location_lat = $_COOKIE["lat"];
}
else{
$location_lat=null;
}
if(isset($_COOKIE["lng"])){
$location_lng = $_COOKIE["lng"];
}
else {
$location_lng=null;
}
if ($location_lng!=null && $location_lat!=null) {

$conn = new mysqli("localhost","root","","complete_food_store_db"   );
								 if ($conn->connect_error) {
									die("Connection failed: " . $conn->connect_error);
								}
	$username=$_SESSION['username'];
	$sql = "UPDATE deliveras SET location_lat=$location_lat,location_long=$location_lng WHERE username='$username'";

	if (mysqli_query($conn, $sql)) {
	}


		$sql = "UPDATE deliveras SET active='1' WHERE username='$username'";
									if (mysqli_query($conn, $sql)) {
									} else {
									echo "Error updating record: " . mysqli_error($conn);
									}


								date_default_timezone_set('Europe/Athens');
								$current_date = date('Y-m-d H:i:s');

								$auto_incr = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'complete_food_store_db' AND TABLE_NAME = 'daily'";
								$result=mysqli_query($conn, $auto_incr);


								$result = $conn->query($auto_incr);


								if ($result->num_rows > 0) {
								// output data of each row

									while($row = $result->fetch_assoc()) {
								$last_auto=$row['AUTO_INCREMENT'];


									}
								}

				$_SESSION['daily_id'] = $last_auto;

								$sql = "INSERT INTO daily (daily_id, delivers, distance, start, end, deliveras_username)
VALUES ('$last_auto', '0', '0', '$current_date', NULL,'$username')";
									if (mysqli_query($conn, $sql)) {
								} else {
									echo "Error updating record: " . mysqli_error($conn);
								}





echo "<script>
  window.location.href='delivery_order.php';
  </script>";

}else {
	echo "<script>
	  window.location.href='delivery_location.php';
	  </script>";
}
?>

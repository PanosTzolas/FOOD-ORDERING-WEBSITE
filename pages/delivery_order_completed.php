<?php

			$cookie_name = 'order_id';
			setcookie($cookie_name, "", time() - 3600, "/"); // 86400 = 1 day
			session_start();
			$username=$_SESSION['username'];
	
	 $conn = new mysqli("localhost","root","","complete_food_store_db"   );
 mysqli_set_charset($conn, "utf8");
								 if ($conn->connect_error) {
									die("Connection failed: " . $conn->connect_error);
								}
	
	$sql = "UPDATE deliveras SET location_lat={$_COOKIE['dest_lat']},location_long={$_COOKIE['dest_long']} WHERE username='$username'";
	if (mysqli_query($conn, $sql)) {
	}
echo "<script>
  window.location.href='delivery_order.php';
  </script>";
?>

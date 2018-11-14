<?php
session_start();

if(isset($_SESSION['daily_id'])){
$username=$_SESSION['username'];
$conn = new mysqli("localhost","root","","complete_food_store_db"   );
$sql = "UPDATE deliveras SET active='0' WHERE username='$username'";
if (mysqli_query($conn, $sql)) {
								
								}
 mysqli_set_charset($conn, "utf8");
date_default_timezone_set('Europe/Athens'); 
								$current_date = date('Y-m-d H:i:s');
								
								
								$sql = "UPDATE daily SET end='$current_date' WHERE daily_id={$_SESSION['daily_id']}";
									if (mysqli_query($conn, $sql)) {
									} else {
									echo "Error: " . mysqli_error($conn);
									}
								
								
								 
								
								if (isset($_COOKIE['order_id'])){
								$sql_update_order_deliveras = "UPDATE order_deliveras SET delivered='0' WHERE order_id={$_COOKIE['order_id']}";
								if (mysqli_query($conn, $sql_update_order_deliveras)) {
								} else {
								echo "Error: " . $sql_update_order_deliveras . "<br>" . mysqli_error($conn);
								}
								$sql_update_order_deliveras = "UPDATE order_deliveras SET deliveras_username=NULL WHERE order_id={$_COOKIE['order_id']}";
								if (mysqli_query($conn, $sql_update_order_deliveras)) {
								} else {
								echo "Error: " . $sql_update_order_deliveras . "<br>" . mysqli_error($conn);
								}

										$cookie_name = 'order_id';
									setcookie($cookie_name, "", time() - 3600, "/"); // 86400 = 1 day

								}
								unset($_SESSION['daily_id']);
								}
$_SESSION = array();
unset($_SESSION['username']);  
unset($_SESSION['password']);
header("Location: index.php");
?>

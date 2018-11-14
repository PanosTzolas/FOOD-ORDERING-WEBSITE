<?php
session_start();

if(isset($_COOKIE["user_lat"])){
   $location_lat = $_COOKIE["user_lat"];
}
else{
	$location_lat=null;
}
if(isset($_COOKIE["user_lng"])){
   $location_lng = $_COOKIE["user_lng"];
}
else {
	$location_lng=null;
}

if (isset($_POST['summary']))
{
    $summary = $_POST['summary'];
}
else
{
    $summary = null;
}
$_SESSION['summary'] = $summary;

if (isset($_POST['door_name']))
{
    $door_name = $_POST['door_name'];
}
else
{
    $door_name = null;
}

if (isset($_POST['floor']))
{
    $floor_ap = $_POST['floor'];
}
else
{
    $floor_ap = 0;
}

	if($location_lat != null && $location_lng!=null && $floor_ap != 0 && $door_name != null) {

	$nearby_store_id = -1;
	$min_miles = -1;

	$conn = new mysqli("localhost","root","","complete_food_store_db"   );
	mysqli_set_charset($conn, "utf8");
	$query = "SELECT  food_store_id,location_lat,location_long FROM food_stores";
	$result = mysqli_query($conn, $query);
	if ($result->num_rows > 0) {

		 while($row = mysqli_fetch_array($result)){
			$id = $row["food_store_id"];
			$store_lat = $row["location_lat"];
			$store_lon = $row["location_long"];
			 $theta = $location_lng - $store_lon;
			 
			$dist = sin(deg2rad($location_lat)) * sin(deg2rad($store_lat)) +  cos(deg2rad($location_lat)) * cos(deg2rad($store_lat)) * cos(deg2rad($theta));
			$dist = acos($dist);
			$dist = rad2deg($dist);
			$miles = $dist * 60 * 1.1515;
			if ($miles < $min_miles || $min_miles==-1)   {
				
					
					$has_items = 1;
					if(!empty($_SESSION["shopping_cart"]))
					{
				
					foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
						$i_quantity=$values["item_quantity"];
						$i_id=$values["item_id"];
						$query2 = "SELECT  Product_product_id,prod_quantity FROM product_supply WHERE food_stores_food_store_id=$id";
						$result2 = mysqli_query($conn, $query2);
						if ($result2->num_rows > 0) {

								
									while($row2 = mysqli_fetch_array($result2)){
										if ($i_id==$row2["Product_product_id"] && $i_quantity>$row2["prod_quantity"] && $i_id > 4){ // && $i_id > 5 giati oi kafedes einai apeiroi
										$has_items = 0;
										}
								
							
									}
								
							}
						}
					}
						

				if($has_items==1){
				$min_miles = $miles;
				$nearby_store_id = $id;
				$min_store_lat = $row["location_lat"];
				$min_store_lon = $row["location_long"];
				}
			}
			}
		}
	
		

if($nearby_store_id==-1){
	echo "<script>
  alert('Order failed out of stock!');
  </script>";
}
else {
	
	
	if(!empty($_SESSION["shopping_cart"]))
					{
				
					foreach($_SESSION["shopping_cart"] as $keys => $values)
						{

						$i_quantity=$values["item_quantity"];
						$i_id=$values["item_id"];
						$query3 = "SELECT  Product_product_id,prod_quantity FROM product_supply WHERE food_stores_food_store_id=$nearby_store_id";
						$result3 = mysqli_query($conn, $query3);
						if ($result3->num_rows > 0) {
								
									while($row3 = mysqli_fetch_array($result3)){
										if ($i_id==$row3["Product_product_id"] && $i_quantity<$row3["prod_quantity"] && $i_id >4){
											$new_quantity = $row3["prod_quantity"]-$i_quantity;
										

											$sql_update_quantity = "UPDATE product_supply SET prod_quantity=$new_quantity WHERE (Product_product_id='$i_id') AND (food_stores_food_store_id=$nearby_store_id)";
											
											if (mysqli_query($conn, $sql_update_quantity)) {
												echo "UPDATE DONE ";
								} else {
									echo "Error updating record: " . mysqli_error($conn);
								}
										}
								
							
									}
								
							}
						}
					}
	$chosen_food_store=$nearby_store_id;
	

	
	$min_miles = -1;
	

	$query = "SELECT  username,active,location_lat,location_long FROM deliveras WHERE active='1'";
	$result = mysqli_query($conn, $query);
	if ($result->num_rows > 0) {

		 while($row = mysqli_fetch_array($result)){
			$delivery_username = $row["username"];
			$delivery_active = $row["active"];
			$delivery_lat = $row["location_lat"];
			$delivery_lon = $row["location_long"];
			 $theta = $min_store_lon - $delivery_lon;
			 
			$dist = sin(deg2rad($min_store_lat)) * sin(deg2rad($delivery_lat)) +  cos(deg2rad($min_store_lat)) * cos(deg2rad($delivery_lat)) * cos(deg2rad($theta));
			$dist = acos($dist);
			$dist = rad2deg($dist);
			$miles = $dist * 60 * 1.1515;
			if ($miles < $min_miles || $min_miles==-1)   {
		
				$min_miles = $miles;
				$nearby_delivery_username = $delivery_username;
			}
			}
		}

 $now = new \DateTime('now');
   $month = $now->format('m');
   $year = $now->format('Y');
$sql_insert_food_order = "INSERT INTO food_order (order_id, Customer_email, food_stores_idfood_stores, summary, floor_ap, doorbell_name,order_lat,order_long,Month,Year)
VALUES (NULL, '{$_SESSION['username']}', '$chosen_food_store', '$summary', '$floor_ap', '$door_name','$location_lat','$location_lng','$month','$year')";
if (mysqli_query($conn, $sql_insert_food_order)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql_insert_food_order . "<br>" . mysqli_error($conn);
}



$auto_incr = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'complete_food_store_db' AND TABLE_NAME = 'food_order'";
$result=mysqli_query($conn, $auto_incr);


$result = $conn->query($auto_incr);


if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $last_auto=$row['AUTO_INCREMENT'];


    }
}
$last_auto=$last_auto-1;


if(!empty($_SESSION["shopping_cart"]))
{
     $total = 0;

     foreach($_SESSION["shopping_cart"] as $keys => $values)
     {
     $i_name=$values["item_name"];
     $i_quantity=$values["item_quantity"];
     $i_price=$values["item_price"];
     number_format($values["item_quantity"] * $values["item_price"], 2);
     $i_id=$values["item_id"];

    $total = $total + ($values["item_quantity"] * $values["item_price"]);
    $sql_insert_order_details = "INSERT INTO order_details (order_id, quantity, product_id)
    VALUES ('$last_auto', '$i_quantity', '$i_id')";
    if (mysqli_query($conn, $sql_insert_order_details)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql_insert_order_details . "<br>" . mysqli_error($conn);
    }
     }

number_format($total, 2);
}
	
if($min_miles!=-1){ 
$chosen_delivery=$nearby_delivery_username;	
$sql = "UPDATE deliveras SET active='2' WHERE username='$chosen_delivery'";
	
	if (mysqli_query($conn, $sql)) {
	}
	
	
	$sql_insert_order_deliveras = "INSERT INTO order_deliveras (order_id, deliveras_username,delivered)
VALUES ('$last_auto','$chosen_delivery','0')";
if (mysqli_query($conn, $sql_insert_order_deliveras)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql_insert_order_deliveras . "<br>" . mysqli_error($conn);
}
}
else{
	$sql_insert_order_deliveras = "INSERT INTO order_deliveras (order_id, deliveras_username,delivered)
VALUES ('$last_auto',NULL,'0')";
if (mysqli_query($conn, $sql_insert_order_deliveras)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql_insert_order_deliveras . "<br>" . mysqli_error($conn);
}
}
	
	
	
}		


unset($_SESSION['shopping_cart']);
mysqli_close($conn);

echo "<script>
  window.location.href='final.php';
  </script>";
  
  
	}
	
	else {
			echo "<script>
  window.location.href='location.php';
  </script>";
	
}
		
?>

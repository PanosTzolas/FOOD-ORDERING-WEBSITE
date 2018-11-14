<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "complete_food_store_db");
mysqli_set_charset($connect, "utf8");

echo "<div class=\"table-responsive\">
     <table class=\"table table-bordered\">";

echo "<tr>
    <th width=\"5%\" style=\"padding: 5px;\">Item ID</th>
     <th width=\"5%\" style=\"padding: 5px;\">Item Name</th>
     <th width=\"5%\" style=\"padding: 5px;\">Quantity</th>

</tr>";
if(isset($_SESSION['username']) && ($_SESSION['username']!=null)){
  $username=$_SESSION['username'];
}
$query1 = "SELECT product.product_id, product.product_type, product.name, product_supply.prod_quantity FROM product LEFT JOIN product_supply ON product_supply.Product_product_id = product.product_id LEFT JOIN food_stores ON product_supply.food_stores_food_store_id = food_stores.food_store_id LEFT JOIN manager ON food_stores.Manager_username = manager.username WHERE manager.username='".$username."' AND product.product_type='Food' ORDER BY product_id ASC";
$result1 = mysqli_query($connect, $query1);

if(mysqli_num_rows($result1) > 0)
{
     while($row = mysqli_fetch_array($result1))
     {
       $product_id=$row["product_id"];
       $product_name=$row["name"];
       $product_quant=$row["prod_quantity"];
       echo "<tr>";
           echo "<td>".$product_id."</td>";
            echo "<td>".$product_name."</td>";
            echo "<td>".$product_quant."</td>";
       echo "</tr>";
     }
}

echo "</table>
</div>";

 ?>

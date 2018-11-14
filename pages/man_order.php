<?php
session_start();

if( ($_SESSION['type']=='Manager')){
$conn = new mysqli("localhost","root","","complete_food_store_db"   );
mysqli_set_charset($conn, "utf8");


echo "<div class=\"table-responsive\">
     <table class=\"table table-bordered\">";

echo "<tr>
    <th width=\"5%\" style=\"padding: 5px;\">Order ID</th>
    <th width=\"5%\" style=\"padding: 5px;\">Customer</th>
     <th width=\"5%\" style=\"padding: 5px;\">Condition</th>
     <th width=\"5%\" style=\"padding: 5px;\">Total</th>

</tr>";
if(isset($_SESSION['username']) && ($_SESSION['username']!=null)){
  $username=$_SESSION['username'];
}
$query1 = "SELECT customer.email, delivered, food_order.order_id, summary FROM order_deliveras LEFT JOIN food_order ON order_deliveras.order_id = food_order.order_id LEFT JOIN customer ON food_order.Customer_email = customer.email LEFT JOIN food_stores ON food_order.food_stores_idfood_stores = food_stores.food_store_id LEFT JOIN manager ON food_stores.Manager_username = manager.username WHERE manager.username='".$username."'";
$result1 = mysqli_query($conn, $query1);

if(mysqli_num_rows($result1) > 0)
{
     while($row = mysqli_fetch_array($result1))
     {
       $customer_email=$row["email"];
       $order_delivered=$row["delivered"];
       $order_id=$row["order_id"];
       $summary=$row["summary"];
      $total=  number_format($summary, 2);
       if ($order_delivered!=2) {
         echo "<tr>";
              echo "<td>".$order_id."</td>";
             echo "<td>".$customer_email."</td>";
             if ( $order_delivered==0) {
               echo "<td>Waiting Delivery</td>";
             }elseif ($order_delivered==1) {
               echo "<td>On The Way</td>";
             }
              echo "<td>".$total."€</td>";
         echo "</tr>";
       }

     }
}

echo "</table>
</div>";


}
 ?>

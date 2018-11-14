<<?php
session_start();


$conn = new mysqli("localhost","root","","complete_food_store_db"   );
mysqli_set_charset($conn, "utf8");




if(isset($_SESSION['username']) && ($_SESSION['username']!=null)){
  $username=$_SESSION['username'];
}

$chosen_food_store_id=0;

 if(!empty($_SESSION["shopping_quantity"]))
 {
      $total = 0;

      foreach($_SESSION["shopping_quantity"] as $keys => $values)
      {
        $ite_id=$values["ite_id"];
      $it_id=$values["it_id"];
      $it_name=$values["it_name"];
      $it_quantity=$values["it_quantity"];

      $query = "SELECT product_id, product_type, product.name, prod_quantity, food_stores_food_store_id FROM product LEFT JOIN product_supply ON product_supply.Product_product_id = product.product_id LEFT JOIN food_stores ON product_supply.food_stores_food_store_id = food_stores.food_store_id LEFT JOIN manager ON food_stores.Manager_username = manager.username WHERE manager.username='".$username."' AND product.product_type='Food' AND product_supply.Product_product_id=$it_id ORDER BY product_id ASC";

      $result = mysqli_query($conn, $query);
      if ($result->num_rows > 0) {

         while($row = mysqli_fetch_array($result)){
           $product_id_n = $row["product_id"];
           $product_quant = $row["prod_quantity"];
           $chosen_food_store_id=$row["food_stores_food_store_id"];


           if ($it_id==$row["product_id"] )   {
             $product_quant=$product_quant+$it_quantity;
             $sql_update="UPDATE product_supply SET prod_quantity='$product_quant' WHERE Product_product_id=$it_id AND food_stores_food_store_id=$chosen_food_store_id";
             if (mysqli_query($conn, $sql_update)) {
               echo "Record updated successfully";
             } else {
               echo "Error updating record: " . mysqli_error($conn);
             }



           }

         }


       }


      }

 }



unset($_SESSION['shopping_quantity']);
mysqli_close($conn);
   header('Location: manager_starting_page.php');

 ?>

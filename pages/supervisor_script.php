<?php

$ok = 1;

if(isset($_POST['month']) && $_POST['month']>0 && $_POST['month']<13){
$month= $_POST['month'];
}
else{
	$ok = 0;
	echo "<script>
  alert('INVALID MONTH');
  window.location.href='supervisor.php';
  </script>";
}
if(isset($_POST['year']) && $_POST['year']>2000 ){
	$year= $_POST['year'];
}
else{
	$ok = 0;
	echo "<script>
  alert('INVALID YEAR!');
  window.location.href='supervisor.php';
  </script>";
}

if($ok > 0)
{
$mysqli = new mysqli("localhost", "root", "", "complete_food_store_db");
mysqli_set_charset($mysqli, "utf8");

/* check connection */
if ($mysqli->connect_errno) {

   echo "Connect failed ".$mysqli->connect_error;

   exit();
}

$query = "SELECT firstname, lastname, AMKA, AFM, IBAN ,username FROM manager";

$employeesArray = array();

if ($result = $mysqli->query($query)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {

       array_push($employeesArray, $row);
    }

    /* free result set */
    $result->free();
}


$query4 = "SELECT firstname, lastname, AMKA, AFM, IBAN,username FROM deliveras";

$deliveryArray = array();

if ($result4 = $mysqli->query($query4)) {

    /* fetch associative array */
    while ($row4 = $result4->fetch_assoc()) {

       array_push($deliveryArray, $row4);
    }
    /* free result set */
    $result4->free();
}

$mysqli->close();


         createXMLfile($employeesArray,$deliveryArray);


}


function createXMLfile($employeesArray,$deliveryArray){
$month= $_POST['month'];
$year= $_POST['year'];
   $filePath = 'payments.xml';

   $dom     = new DOMDocument('1.0', 'utf-8');
   $xml      = $dom->createElement('xml');
   $header      = $dom->createElement('header');
   $transaction      = $dom->createElement('transaction');
        $period      = $dom->createElement('period');
        

        $period->setAttribute('month', $month);
        $period->setAttribute('year', $year);
        $transaction->appendChild($period);
   $header->appendChild($transaction);

   $xml->appendChild($header);

   $root      = $dom->createElement('employees');

   for($i=0; $i<count($employeesArray); $i++){



     $fistname      =  $employeesArray[$i]['firstname'];

     $lastname    =  $employeesArray[$i]['lastname'];

     $AMKA     =  $employeesArray[$i]['AMKA'];

     $AFM      =  $employeesArray[$i]['AFM'];

     $IBAN  =  $employeesArray[$i]['IBAN'];

     $employee = $dom->createElement('employee');


     $name     = $dom->createElement('firstname', $fistname);

     $employee->appendChild($name);

     $last_val   = $dom->createElement('lastname', $lastname);

     $employee->appendChild($last_val);

     $amka_val    = $dom->createElement('AMKA', $AMKA);

     $employee->appendChild($amka_val);

     $afm_val     = $dom->createElement('AFM', $AFM);

     $employee->appendChild($afm_val);

     $iban_val = $dom->createElement('IBAN', $IBAN);

     $employee->appendChild($iban_val);

	 $temp_username = $employeesArray[$i]['username'];
	 
	 $connect = new mysqli("localhost", "root", "", "complete_food_store_db");
	mysqli_set_charset($connect	, "utf8");

	 $query2 = "SELECT food_store_id FROM food_stores where Manager_username='$temp_username'";

	$result2 = mysqli_query($connect, $query2);
	
	if(mysqli_num_rows($result2) > 0)
	{
		 while($row2 = mysqli_fetch_array($result2))
		 {
			 $store_id = $row2["food_store_id"];
			 
			 $query3 = "SELECT  SUM(summary) AS whole_sum FROM food_order where (Month='$month' and Year='$year' and food_stores_idfood_stores='$store_id')";
			 
			 $result3 = mysqli_query($connect, $query3);
			if($result3!=null){
			  while($row3 = mysqli_fetch_array($result3))
			  {
				 $payment = $row3["whole_sum"];
				  $payment = ($payment * 0.02) +800 ;
				  
			  }
			}
		 }
	
 
	 $connect->close();

	 $amount     = $dom->createElement('amount',number_format($payment, 2) );

     $employee->appendChild($amount);
	 }
     $root->appendChild($employee);

   }

   for($i=0; $i<count($deliveryArray); $i++){



     $fistname      =  $deliveryArray[$i]['firstname'];

     $lastname    =  $deliveryArray[$i]['lastname'];

     $AMKA     =  $deliveryArray[$i]['AMKA'];

     $AFM      =  $deliveryArray[$i]['AFM'];

     $IBAN  =  $deliveryArray[$i]['IBAN'];

     $delivery = $dom->createElement('delivery');


     $name     = $dom->createElement('firstname', $fistname);

     $delivery->appendChild($name);

     $last_val   = $dom->createElement('lastname', $lastname);

     $delivery->appendChild($last_val);

     $amka_val    = $dom->createElement('AMKA', $AMKA);

     $delivery->appendChild($amka_val);

     $afm_val     = $dom->createElement('AFM', $AFM);

     $delivery->appendChild($afm_val);

     $iban_val = $dom->createElement('IBAN', $IBAN);

     $delivery->appendChild($iban_val);

	 $temp_username = $deliveryArray[$i]['username'];
	 
	 $connect = new mysqli("localhost", "root", "", "complete_food_store_db");
	mysqli_set_charset($connect	, "utf8");

	
								$payment=0;
	   $sql = "SELECT start,end,distance FROM daily WHERE deliveras_username='$temp_username' AND end IS NOT NULL";
									$result = mysqli_query($connect, $sql);
										if ($result->num_rows > 0) {
												while($row = mysqli_fetch_array($result)){
													$start = $row["start"];
													$start_month = date("m",strtotime($start));
													
													if($start_month == $month){
													
													$end = $row["end"];
													$distance = $row["distance"];
													
													$ts1 = strtotime($end);
													$ts2 = strtotime($start);
													$diff = abs($ts1 - $ts2)/3600;
													$time_apoz=5;
													$km_apoz=0.10;
													
													$payment = $payment + $diff*$time_apoz + $distance*$km_apoz;
													}
												}
													 $connect->close();

	 $amount     = $dom->createElement('amount',number_format($payment, 2) );

     $delivery->appendChild($amount);
										}
 
	 
     $root->appendChild($delivery);

   }
		
   $xml->appendChild($root);
   $dom->appendChild($xml);


   $dom->save($filePath);

 }

echo "<script>
  alert('payments.xml completed!');
  window.location.href='supervisor.php';
  </script>";

 ?>

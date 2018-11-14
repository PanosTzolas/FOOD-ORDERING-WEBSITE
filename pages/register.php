<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Register</title>
  </head>
  <body>
    <?php

		if ((strlen($_POST['userid']) < 6 || strlen($_POST['userid'])>30))
	{
		echo "<script>
		alert('Username must be between 6-30 characters!');
		window.location.href='index.php';
		</script>";
	}
	else if(strlen($_POST['pswrd']) < 6){
		echo "<script>
		alert('Password must be longer than 6 characters!');
		window.location.href='index.php';
		</script>";
	}
	else if(strlen($_POST['phone'])!=10){
			 echo "<script>
		alert('Invalid Phone!');
		window.location.href='index.php';
		</script>";
			}

	else{
		 $username=$_POST['userid'];
			$found=0;

        $conn = new mysqli("localhost","root","","complete_food_store_db");
        if (mysqli_connect_error())
{
    echo " CONNECTION FAILED";
die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}


		$sql = "select * FROM Customer";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row

             while($row = $result->fetch_assoc()) {

                if ($username == $row["email"]){
                    $found = 1;
                }

        }
    }


		if($found != 1){

        $password=$_POST['pswrd'];
        $phone=$_POST['phone'];



				$query="INSERT INTO `customer` (`email`, `password`, `phone`) VALUES ('$username', '$password', '$phone')";
        $result=mysqli_query($conn,$query);
		if($result){
        echo "<script>
		alert('Thank you for registering!');
		window.location.href='index.php';
		</script>";
		}


		}

		else {
			 echo "<script>
		alert('Username taken!');
		window.location.href='index.php';
		</script>";

		}
        $conn->close();
       }
     ?>


<div class="header"></div>
		<br>
		<form name="login" method="POST" action="login.php">
		<div class="login">
				<input type="text" value=echo .$username. name="userid"><br>
				<input type="password" value=$_POST['pswrd'] name="pswrd"><br>
				<input type="submit" value="Login"/>
		</div>
  </body>
</html>

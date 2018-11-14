<?php
session_start();

?>

<?php

if (isset($_POST['userid']))
{
    $username = $_POST['userid'];
}
else
{
    $username = null;
}

if (isset($_POST['pswrd']))
{
    $password = $_POST['pswrd'];
}
else
{
  $password = null;
}


$conn = new mysqli("localhost","root","","complete_food_store_db"   );

if (mysqli_connect_error())
{
    echo " CONNECTION FAILED";
die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

$found = 0;

    $sql = "select * FROM supervisor";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row

             while($row = $result->fetch_assoc()) {

                if ($username == $row["username"] && $row["password"] == $password ){

                    $found = 1;

					$_SESSION['username'] = $username;
					$_SESSION['password'] = $password;
					$_SESSION['type'] = 'Supervisor';
                }

        }
    }



$conn->close();
if ($found != 1 ){
echo "<script>
  alert('Wrong username password!');
  window.location.href='supervisor.php';
  </script>";
}
else {
echo "<script>
  window.location.href='supervisor.php';
  </script>";
}


?>

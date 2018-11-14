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

if (isset($_POST['Type']))
{
    $type = $_POST['Type'];
}
else
{
  $type = null;
}

$conn = new mysqli("localhost","root","","complete_food_store_db"   );


if (mysqli_connect_error())
{
    echo " CONNECTION FAILED";
die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

$found = 0;
 if ($type == 'User'){
    $sql = "select * FROM Customer";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

             while($row = $result->fetch_assoc()) {

                if ($username == $row["email"] && $row["password"] == $password ){

                    $found = 1;

					$_SESSION['username'] = $username;
					$_SESSION['password'] = $password;
					$_SESSION['type'] = 'User';
					
                    header('Location: menu.php');
                }

        }
    }
}
else if($type == 'Manager'){
    $sql = "select * FROM manager";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        $found = 0;
             while($row = $result->fetch_assoc()) {
                if ($username == $row["username"] && $row["password"] == $password ){
                    $found = 1;
                    $_SESSION['username'] = $username;
          					$_SESSION['password'] = $password;
							$_SESSION['type'] = 'Manager';
                    header('Location: manager_starting_page.php');
                }

        }
    }
}
else {
    $sql = "select * FROM deliveras";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        // output data of each row
        $found = 0;
             while($row = $result->fetch_assoc()) {

                if ($username == $row["username"] && $row["password"] == $password ){
                    $found = 1;
					$_SESSION['username'] = $username;
					$_SESSION['password'] = $password;
					$_SESSION['type'] = 'Delivery';
                    header('Location: delivery.php');
                }

        }
    }
}
$conn->close();
if ($found != 1 ){
echo "<script>
  alert('Wrong username password!');
  window.location.href='index.php';
  </script>";
}
else {
echo "<script>
  window.location.href='index.php';
  </script>";
}


?>

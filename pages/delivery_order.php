<?php
session_start();

				if( ($_SESSION['type']=='Delivery')){

$username=$_SESSION['username'];
 $conn = new mysqli("localhost","root","","complete_food_store_db"   );
 mysqli_set_charset($conn, "utf8");

$sql = "SELECT active FROM deliveras WHERE username='$username'";
									$result = mysqli_query($conn, $sql);
										if ($result->num_rows > 0) {
												while($row = mysqli_fetch_array($result)){
												$active = $row["active"];
									}
										}

if($active!=0){
if (!isset($_COOKIE['order_id'])){
								 if ($conn->connect_error) {
									die("Connection failed: " . $conn->connect_error);
								}



		  $order_id=-1;

		 $query = "SELECT order_id FROM order_deliveras WHERE deliveras_username='$username' AND delivered!='2' ORDER BY order_id ASC LIMIT 1";
	$result = mysqli_query($conn, $query);

		 while($row = mysqli_fetch_array($result)){
			$order_id = $row["order_id"];
			$cookie_name = "order_id";
			$cookie_value = $row["order_id"];
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
			}


		if($order_id==-1){

	 $query = "SELECT order_id FROM order_deliveras WHERE deliveras_username IS NULL ORDER BY order_id ASC LIMIT 1";
	$result = mysqli_query($conn, $query);

		 while($row = mysqli_fetch_array($result)){
			$order_id = $row["order_id"];
			$cookie_name = "order_id";
			$cookie_value = $row["order_id"];
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
			}
		}

	if($order_id!=-1){


		 $query = "SELECT food_stores_idfood_stores,summary,floor_ap,doorbell_name,order_lat,order_long FROM food_order WHERE order_id={$order_id}";
	$result = mysqli_query($conn, $query);


		if ($result->num_rows > 0) {

		 while($row = mysqli_fetch_array($result)){





			$cookie_name = "store_id";
			$food_store_id = $row["food_stores_idfood_stores"];
			$cookie_value = $food_store_id;

			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

			$cookie_name = "summary";
			$cookie_value = $row["summary"];
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

			$cookie_name = "floor_ap";
			$cookie_value = $row["floor_ap"];
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

			$cookie_name = "doorbell_name";
			$cookie_value = $row["doorbell_name"];
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

			$cookie_name = "dest_lat";
			$cookie_value =  $row["order_lat"];
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

			$cookie_name = "dest_long";
			$cookie_value = $row["order_long"];
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

			}
		}
			 $query = "SELECT  location_lat,location_long FROM food_stores WHERE food_store_id={$food_store_id}";
	$result = mysqli_query($conn, $query);
	if ($result->num_rows > 0) {

		 while($row = mysqli_fetch_array($result)){

			$cookie_name = "store_lat";
			$cookie_value =  $row["location_lat"];
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

			$cookie_name = "store_long";
			$cookie_value =  $row["location_long"];
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

			}
	}

		$sql_update_food_order = "UPDATE order_deliveras SET delivered='1',deliveras_username='$username' WHERE order_id='$order_id'";
if (mysqli_query($conn, $sql_update_food_order)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql_update_food_order . "<br>" . mysqli_error($conn);
}

		$sql = "UPDATE deliveras SET active='2' WHERE username='$username'";

	if (mysqli_query($conn, $sql)) {
	}

	$sql_update_order_deliveras = "UPDATE order_deliveras SET deliveras_username='$username' WHERE order_id='$order_id'";
if (mysqli_query($conn, $sql_update_order_deliveras)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql_update_order_deliveras . "<br>" . mysqli_error($conn);
}


	echo "<script>
  window.location.href='delivery_order.php';
  </script>";

	}

}
}
?>
	<!DOCTYPE html>
	<html lang="zxx" class="no-js">
	 <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
    </style>
	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="img/fav.png">
		<!-- Author Meta -->
		<meta name="author" content="colorlib">
		<!-- Meta Description -->
		<meta name="description" content="">
		<!-- Meta Keyword -->
		<meta name="keywords" content="">
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Site Title -->
		<title>Kappa Stores</title>

		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
			<!--
			CSS
			============================================= -->
			<link rel="stylesheet" href="css/linearicons.css">
			<link rel="stylesheet" href="css/font-awesome.min.css">
			<link rel="stylesheet" href="css/bootstrap.css">
			<link rel="stylesheet" href="css/magnific-popup.css">
			<link rel="stylesheet" href="css/jquery-ui.css">
			<link rel="stylesheet" href="css/nice-select.css">
			<link rel="stylesheet" href="css/animate.min.css">
			<link rel="stylesheet" href="css/owl.carousel.css">
			<link rel="stylesheet" href="css/main.css">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		</head>
		<body>
			<header id="header">
				<div class="header-top">
				<?php

						echo '<div style="color: white;">';
						echo $_SESSION['username'];
							echo '</div>';

					 ?>

					<div class="container">
				  		<div class="row justify-content-center">
						      <div id="logo">
						        <a href="delivery.php"><img src="img/logo.png" alt="" title="" /></a>
						      </div>
				  		</div>
					</div>
				</div>
				<div class="container main-menu">
					<div class="row align-items-center justify-content-center d-flex">
				      <nav id="nav-menu-container">
				         <ul class="nav-menu">
						 <li><a href='logout.php'>Logout</a></li>
				          <li><a href="delivery.php">Home</a></li>
				          <li><a href="delivery_order.php">Orders</a></li>
						   <li><a href="delivery_stats.php">Stats</a></li>
				        </ul>
				      </nav><!-- #nav-menu-container -->
					</div>
				</div>
			</header><!-- #header -->

			<!-- start banner Area -->
			<section class="relative about-banner">
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								Orders
							</h1>
						</div>
					</div>
				</div>
			</section>
			<!-- End banner Area -->

<!-- Display the countdown timer in an element -->



    </div>
    <div id="map"></div>


		<script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      src="https://maps.googleapis.com/maps/api/js?key=APIKEY&libraries=places"

	 var geocoder;
			var start_lat = 38.246639;
			var start_lng = 21.734573;



      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: start_lat, lng: start_lng},
          zoom: 17
        });
        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        // Set the data fields to return when the user selects a place.
        autocomplete.setFields(
            ['address_components', 'geometry', 'icon', 'name']);









		 var dest_lat = 0.0;
			var dest_long = 0.0;
			var store_lat = 0.0;
			var store_long = 0.0;
			//if(getCookie("dest_lat") && getCookie("dest_long") && getCookie("store_lat") && getCookie("store_long")){
			 dest_lat = parseFloat(getCookieValue("dest_lat"));
			 dest_long = parseFloat(getCookieValue("dest_long"));
			 store_lat = parseFloat(getCookieValue("store_lat"));
			 store_long = parseFloat(getCookieValue("store_long"));

			var image = "img/logo_marker.png";

		var store_marker = new google.maps.Marker({
          position: {lat: store_lat, lng: store_long},
          map: map,
		  icon: image
        });

			var dest_image = "img/house_marker.png";

	var dest_marker = new google.maps.Marker({
          position: {lat: dest_lat, lng: dest_long},
          map: map,
		   icon: dest_image
        });
		//	}


}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return true;
        }
    }
    return false;
}


function getCookieValue(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
    </script>

	 <p id="loop"></p>
			<script>
			setInterval(myMethod, 10000);
var x=0;
function myMethod( )
{
	 if (!getCookie("order_id"))
	 location.reload();
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return true;
        }
    }
    return false;
}

</script>


<?php

if (isset($_COOKIE['order_id'])){
	 echo " {$_COOKIE['order_id']} <br>";
	 echo "TOTAL : {$_COOKIE['summary']} <br>";
	 echo "FLOOR : {$_COOKIE['floor_ap']} <br>";
echo "DOOR NAME : {$_COOKIE['doorbell_name']} <br>";
?>



<form class="form-wrap text-center" method="POST" >

<input type="submit" name="submit" value="Delivered" class="genric-btn primary">

              <?php

                                 $conn = new mysqli("localhost","root","","complete_food_store_db"   );
                                 if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $username=$_SESSION['username'];

                                if(isset($_POST['submit']) ) {
                                    $sql = "UPDATE deliveras SET active='1' WHERE username='$username'";
                                    if (mysqli_query($conn, $sql)) {
                                } else {
                                    echo "Error updating record: " . mysqli_error($conn);
                                }
								$sql_update_order_deliveras2 = "UPDATE order_deliveras SET delivered='2' WHERE order_id={$_COOKIE['order_id']}";




								if (mysqli_query($conn, $sql_update_order_deliveras2)) {
								} else {
								echo "Error: " . $sql_update_order_deliveras2 . "<br>" . mysqli_error($conn);
								}

								$query = "SELECT location_lat,location_long FROM deliveras WHERE username='$username'" ;

								$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_array($result)){
								$lon1=$row["location_long"];
								$lat1=$row["location_lat"];

								}
								$lon2=(float)$_COOKIE["store_long"];
								$lat2=(float)$_COOKIE["store_lat"];

								function calcCrow($lat1, $lon1, $lat2, $lon2){
									$R = 6371; // km
									$dLat = toRad($lat2-$lat1);
									$dLon = toRad($lon2-$lon1);
									$lat1 = toRad($lat1);
									$lat2 = toRad($lat2);

									$a = sin($dLat/2) * sin($dLat/2) +sin($dLon/2) * sin($dLon/2) * cos($lat1) * cos($lat2);
									$c = 2 * atan2(sqrt($a), sqrt(1-$a));
									$d = $R * $c;
									return $d;
							}
							function toRad($Value)
{
    return $Value * pi() / 180;
}
							$dest=calcCrow($lat1, $lon1, $lat2, $lon2);
							echo "<br>";
							echo $dest*1000;


								$lon1=$_COOKIE["dest_long"];
								$lat1=$_COOKIE["dest_lat"];

								$dest=$dest + calcCrow($lat1, $lon1, $lat2, $lon2);

								echo "<br>";
								echo $dest*1000;
								$daily_id=$_SESSION['daily_id'];
								$query="SELECT distance,delivers FROM daily WHERE daily_id ='$daily_id'";

								$result = mysqli_query($conn, $query);

								while($row = mysqli_fetch_array($result)){
								$temp_distance=$row["distance"];
								$temp_delivers=$row["delivers"];
								}

								$temp_delivers=$temp_delivers+1;
								$temp_distance=$temp_distance+$dest;

								  $sql = "UPDATE daily SET distance=$temp_distance,delivers=$temp_delivers   WHERE daily_id ='$daily_id'";
                                    if (mysqli_query($conn, $sql)) {
                                } else {
                                    echo "Error updating record: " . mysqli_error($conn);
                                }

								$cookie_name = 'order_id';
								setcookie($cookie_name, "", time() - 3600, "/"); // 86400 = 1 day

								echo "<script>
  window.location.href='delivery_order_completed.php';
  </script>";
	                  }




                                $conn->close();
								}

                                ?>

</form>
			<!-- Start contact-page Area -->
			<section class="contact-page-area section-gap">
				<div class="container">
					<div class="row">

						<div class="col-lg-5 reservation-right">

						</div>


					</div>
				</div>
			</section>
			<!-- End contact-page Area -->

			<!-- start footer Area -->
			<footer class="footer-area">
				<div class="footer-widget-wrap">
					<div class="container">
						<div class="row section-gap">
							<div class="col-lg-4  col-md-6 col-sm-6">
								<div class="single-footer-widget">
									<h4>Opening Hours</h4>
									<ul class="hr-list">
										<li class="d-flex justify-content-between">
											<span>Monday - Friday</span> <span>08.00 am - 10.00 pm</span>
										</li>
										<li class="d-flex justify-content-between">
											<span>Saturday</span> <span>08.00 am - 10.00 pm</span>
										</li>
										<li class="d-flex justify-content-between">
											<span>Sunday</span> <span>08.00 am - 10.00 pm</span>
										</li>
									</ul>
								</div>
							</div>
							<div class="col-lg-4  col-md-6 col-sm-6">
								<div class="single-footer-widget">
									<h4>Contact Us</h4>
									<p>
										56/8, los angeles, rochy beach, Santa monica, United states of america - 1205
									</p>
									<p class="number">
										012-6532-568-9746 <br>
										012-6532-569-9748
									</p>
								</div>
							</div>
							<div class="col-lg-4  col-md-6 col-sm-6">
								<div class="single-footer-widget">
									<h4>Newsletter</h4>
									<p>You can trust us. we only send promo offers, not a single spam.</p>
									<div class="d-flex flex-row" id="mc_embed_signup">


										  <form class="navbar-form" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get">
										    <div class="input-group add-on align-items-center d-flex">
										      	<input class="form-control" name="EMAIL" placeholder="Your Email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Email address'" required="" type="email">
												<div style="position: absolute; left: -5000px;">
													<input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
												</div>
										      <div class="input-group-btn">
										        <button class="genric-btn"><span class="lnr lnr-arrow-right"></span></button>
										      </div>
										    </div>
										      <div class="info mt-20"></div>
										  </form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="footer-bottom-wrap">
					<div class="container">
						<div class="row footer-bottom d-flex justify-content-between align-items-center">
							<p class="col-lg-8 col-mdcol-sm-6 -6 footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
							<ul class="col-lg-4 col-mdcol-sm-6 -6 social-icons text-right">
	                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
	                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
	                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
	                            <li><a href="#"><i class="fa fa-behance"></i></a></li>
	                        </ul>
						</div>
					</div>
				</div>
			</footer>
			<!-- End footer Area -->

			<script src="js/vendor/jquery-2.2.4.min.js"></script>
			<script src="js/popper.min.js"></script>
			<script src="js/vendor/bootstrap.min.js"></script>
 			<script src="js/jquery-ui.js"></script>
  			<script src="js/easing.min.js"></script>
			<script src="js/hoverIntent.js"></script>
			<script src="js/superfish.min.js"></script>
			<script src="js/jquery.ajaxchimp.min.js"></script>
			<script src="js/jquery.magnific-popup.min.js"></script>
			<script src="js/jquery.nice-select.min.js"></script>
			<script src="js/owl.carousel.min.js"></script>
            <script src="js/isotope.pkgd.min.js"></script>
			<script src="js/mail-script.js"></script>
			<script src="js/main.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=APIKEY&libraries=places&callback=initMap"async defer></script>
		</body>
	</html>

	<?php
	}else {echo "<br /><a href='index.php'><img src='img/meme.png' /></a>";}

	?>

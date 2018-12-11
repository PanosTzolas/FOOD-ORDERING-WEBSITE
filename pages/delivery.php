<?php

session_start();
if(isset($_SESSION['username'])&& $_SESSION['type']=='Delivery'){
?>

	<!DOCTYPE html>
	<html lang="zxx" class="no-js">
	<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
		<title>Delivery</title>

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
			<section class="banner-area">
				<div class="container">
					<div class="row fullscreen align-items-center justify-content-between">
						<div class="col-lg-12 banner-content">
							<h6 class="text-white">Wide Options of Choice</h6>
							<script>
								$(document).ready(function(){
    							$('input:checkbox').click(function() {
        						$('input:checkbox').not(this).prop('checked', false);

    							});
								});
							</script>

							<form method="post" >
									<label for="active">ACTIVE <input type="checkbox" name="active" id="active" value="1" /></label><br />
									<label for="inactive">INACTIVE <input type="checkbox" name="inactive" id="inactive" value="1" /></label><br />
									<input  name="submit" type="submit" value="submit" />
							</form>

								<?php
								if( ($_SESSION['type']=='Delivery')){
								 $conn = new mysqli("localhost","root","","complete_food_store_db"   );
								 if ($conn->connect_error) {
									die("Connection failed: " . $conn->connect_error);
								}

								$username=$_SESSION['username'];
								$sql0 = "SELECT active FROM deliveras WHERE username='$username'";
									$result0 = mysqli_query($conn, $sql0);
										if ($result0->num_rows > 0) {
												while($row = mysqli_fetch_array($result0)){
														$restore_active = $row["active"];
												}

									}


									if($restore_active==1){
									$sql = "SELECT daily_id FROM daily WHERE end IS NULL AND deliveras_username='$username'";
									$result = mysqli_query($conn, $sql);
										if ($result->num_rows > 0) {
												while($row = mysqli_fetch_array($result)){
													$_SESSION['daily_id'] = $row["daily_id"];
												}
												echo "<script>
												window.location.href='delivery_order.php';
												</script>";

										}
									}

								if(isset($_POST['active']) ) {



									$sql = "SELECT active FROM deliveras WHERE username='$username'";
									$result = mysqli_query($conn, $sql);
										if ($result->num_rows > 0) {
												while($row = mysqli_fetch_array($result)){
												$active = $row["active"];
									}
										}




									if($active==0){

									header('Location: delivery_location.php');
									}

								} else if  (isset($_POST['inactive'])) {

									$sql = "UPDATE deliveras SET active='0' WHERE username='$username'";
									if (mysqli_query($conn, $sql)) {

								}

								date_default_timezone_set('Europe/Athens');
								$current_date = date('Y-m-d H:i:s');

								if(isset($_SESSION['daily_id'])){
								$sql = "UPDATE daily SET end='$current_date' WHERE daily_id={$_SESSION['daily_id']}";
									if (mysqli_query($conn, $sql)) {
										echo "END SET";
									} else {
									echo "Error " . mysqli_error($conn);
									}




								if (isset($_COOKIE['order_id'])){
								$sql_update_order_deliveras = "UPDATE order_deliveras SET delivered='0' WHERE order_id={$_COOKIE['order_id']}";
								if (mysqli_query($conn, $sql_update_order_deliveras)) {
								} else {
								echo "Update Error: " . $sql_update_order_deliveras . "<br>" . mysqli_error($conn);
								}
								$sql_update_order_deliveras = "UPDATE order_deliveras SET deliveras_username=NULL WHERE order_id={$_COOKIE['order_id']}";
								if (mysqli_query($conn, $sql_update_order_deliveras)) {
								} else {
								}

										$cookie_name = 'order_id';
									setcookie($cookie_name, "", time() - 3600, "/"); // 86400 = 1 day

								}
								unset($_SESSION['daily_id']);
								}

								}

								$conn->close();
								}
								?>
						</div>
					</div>
				</div>
			</section>

			<!-- Start reservation Area -->
			<section class="reservation-area section-gap relative">
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row justify-content-between align-items-center">
						<div class="col-lg-6 reservation-left">
							<h1 class="text-white">Reserve Your Seats
							to Confirm if You Come
							with Your Family</h1>
							<p class="text-white pt-20">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea.
							</p>
						</div>
						<div class="col-lg-5 reservation-right">
							<form class="form-wrap text-center" action="#">
								<input type="text" class="form-control" name="name" placeholder="Your Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Name'" >
								<input type="email" class="form-control" name="email" placeholder="Your Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Email Address'" >
								<input type="text" class="form-control" name="phone" placeholder="Phone Number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone Number'" >
								<input type="text" class="form-control date-picker" name="date" placeholder="Select Date & time" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Select Date & time'" >
								<div class="form-select" id="service-select">
									<select>
										<option data-display="">Select Event</option>
										<option value="1">Event One</option>
										<option value="2">Event Two</option>
										<option value="3">Event Three</option>
										<option value="4">Event Four</option>
									</select>
								</div>
								<button class="primary-btn text-uppercase mt-20">Make Reservation</button>
							</form>
						</div>
					</div>
				</div>
			</section>
			<!-- End reservation Area -->


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
			<script src="https://maps.googleapis.com/maps/api/js?key=APIKEY"></script>
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
		</body>
	</html>

		<?php
	}else {echo "<br /><a href='index.php'><img src='img/meme.png' /></a>";}
	?>

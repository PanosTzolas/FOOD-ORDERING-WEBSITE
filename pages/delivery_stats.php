<?php

session_start();
				if( ($_SESSION['type']=='Delivery')){

?>	
	
	<!DOCTYPE html>
	<html lang="zxx" class="no-js">
	<head>
	<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
	text-align: center;
    width: 50%;
}

td, th {
    border: 6px solid #000000;
    text-align: center;
    padding: 5px;
}


</style>
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
						echo " : ";
								
								$username=$_SESSION['username'];						

					
					
					 $conn = new mysqli("localhost","root","","complete_food_store_db"   );
								 if ($conn->connect_error) {
									die("Connection failed: " . $conn->connect_error);
								}
					
					
							$salary=0;
	   $sql = "SELECT start,end,distance FROM daily WHERE deliveras_username='$username' AND end IS NOT NULL";
									$result = mysqli_query($conn, $sql);
										if ($result->num_rows > 0) {
												while($row = mysqli_fetch_array($result)){
													$start = $row["start"];
													$end = $row["end"];
													$distance = $row["distance"];
													
													$ts1 = strtotime($end);
													$ts2 = strtotime($start);
													$diff = abs($ts1 - $ts2)/3600;
													$time_apoz=5;
													$km_apoz=0.10;
													
													$salary = $salary + $diff*$time_apoz + $distance*$km_apoz;
													
												}
												
										}
										 echo (round($salary,2));
													echo "€<br>";
														echo '</div>';	
						$conn->close();
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
							<script>
								$(document).ready(function(){
    							$('input:checkbox').click(function() {
        						$('input:checkbox').not(this).prop('checked', false);
    							});
								});
							</script>
							
					
							  
								
								<form>
									<div class="wrapper">
									
									<script>
   function updateText(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
		
        xmlhttp.open("GET","getstats.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
									
								 <select name="users" onchange="updateText(this.value)" class="select">
       <?php
	   $conn = new mysqli("localhost","root","","complete_food_store_db"   );
								 if ($conn->connect_error) {
									die("Connection failed: " . $conn->connect_error);
								}
	   $sql = "SELECT start,daily_id FROM daily WHERE deliveras_username='$username'";
									$result = mysqli_query($conn, $sql);
										if ($result->num_rows > 0) {
												while($row = mysqli_fetch_array($result)){
													$date = $row["start"];
													$daily_id = $row["daily_id"];
													?>
													<option value=<?php echo $daily_id;?>><?php echo $date; ?></option>
													 <?php
										}
										}
										$conn->close();
		?>
		
   


  </select>
</form>
<br>

	<div id="txtHint"><b></b></div>

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
	}else{
											echo "<br /><a href='index.php'><img src='img/meme.png' /></a>";
	}
				
	?>

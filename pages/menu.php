<?php
 session_start();
 $connect = mysqli_connect("localhost", "root", "", "complete_food_store_db");
mysqli_set_charset($connect, "utf8");
 if(isset($_POST["add_to_cart"]))
 {
	 if($_POST["quantity"]>0){
      if(isset($_SESSION["shopping_cart"]))
      {
           $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
           if(!in_array($_GET["id"], $item_array_id))
           {

                $count = count($_SESSION["shopping_cart"]);
                $item_array = array(
                     'item_id'               =>     $_GET["id"],
                     'item_name'               =>     $_POST["hidden_name"],
                     'item_price'          =>     $_POST["hidden_price"],
                     'item_quantity'          =>     $_POST["quantity"]
                );
                $_SESSION["shopping_cart"][$count] = $item_array;
           }
           else
          {
                echo '<script>alert("Item Already Added")</script>';
              echo '<script>window.location="menu.php"</script>';
        }
      }
      else
      {
           $item_array = array(
                'item_id'               =>     $_GET["id"],
                'item_name'               =>     $_POST["hidden_name"],
                'item_price'          =>     $_POST["hidden_price"],
                'item_quantity'          =>     $_POST["quantity"]
           );
           $_SESSION["shopping_cart"][0] = $item_array;
      }
	 }
	 else{
		 echo '<script>alert("Number must be greater than zero!")</script>';
              echo '<script>window.location="menu.php"</script>';
	 }
 }
 if(isset($_GET["action"]))
 {
      if($_GET["action"] == "delete")
      {
           foreach($_SESSION["shopping_cart"] as $keys => $values)
           {
                if($values["item_id"] == $_GET["id"])
                {
                     unset($_SESSION["shopping_cart"][$keys]);
                     echo '<script>alert("Item Removed")</script>';
                     echo '<script>window.location="menu.php"</script>';
                }
           }
      }
 }
 ?>

	<!DOCTYPE html>
	<html lang="zxx" class="no-js">
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
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">

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
					<div class="container">
					<?php


							if(isset($_SESSION['username']) && ($_SESSION['username']!=null))
								{

						//$k  = $_SESSION['username'];
						echo '<div style="color: white;">';
						echo $_SESSION['username'];
							echo '</div>';


					 ?>

					<a href='logout.php'>Click here to log out</a>
					<?php
							}
							?>
				  		<div class="row justify-content-center">
						      <div id="logo">
						        <a href="menu.php"><img src="img/logo.png" alt="" title="" /></a>
						      </div>
				  		</div>
					</div>
				</div>
				<div class="container main-menu">
					<div class="row align-items-center justify-content-center d-flex">
				      <nav id="nav-menu-container">
				        <ul class="nav-menu">
				          <?php
						 if(!isset($_SESSION['username']))
								{
								?>
								 <li><a href="index.php">Home</a></li>
									 <?php
								}
									?>
				          <li><a href="about.php">About</a></li>
				          <li><a href="menu.php">Menu</a></li>
				          <li><a href="gallery.php">Gallery</a></li>
				          <li><a href="contact.php">Contact</a></li>
				        </ul>
				      </nav><!-- #nav-menu-container -->
					</div>
				</div>
			</header><!-- #header -->

			<!-- start banner Area -->
			<section class="about-banner relative">
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								Menus
							</h1>
							<p class="text-white link-nav"><a href="menu.php">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="menu.php"> Menus</a></p>
						</div>
					</div>
				</div>
			</section>
			<!-- End banner Area -->

			<!-- Start menu-area Area -->
            <section class="menu-area section-gap" id="menu">

							<div class="col-lg-5 reservation-right" style="float: right; position: sticky; width: 390px; height: 805px; padding: 5px;" >
							  <form class="form-wrap text-center" action="location.php"> <!--contact.php -->
							<div style="clear:both"></div>
							<br />
							<h3>Order Details</h3>
							<div class="table-responsive">
									 <table class="table table-bordered" style="font-size: 12px; margin: 10px;">
												<tr>
														 <th width="5%" style="padding: 5px;">Item Name</th>
														 <th width="5%" style="padding: 5px;">Quantity</th>
														 <th width="5%" style="padding: 5px;">Price</th>
														 <th width="5%" style="padding: 5px;">Total</th>
														 <th width="5%" style="padding: 5px;">Action</th>
												</tr>
												<?php




												$total=0;
												if(!empty($_SESSION["shopping_cart"]))
												{
														 $total = 0;
														 foreach($_SESSION["shopping_cart"] as $keys => $values)
														 {
												?>
												<tr>
														 <td><?php echo $values["item_name"]; ?></td>
														 <td><?php echo $values["item_quantity"]; ?></td>
														 <td>€ <?php echo $values["item_price"]; ?></td>
														 <td>€ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
														 <td><a href="menu.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
												</tr>
												<?php
																	$total = $total + ($values["item_quantity"] * $values["item_price"]);
														 }
												?>
												<tr>
														 <td colspan="3" align="right">Total</td>
														 <td align="right">€ <?php echo number_format($total, 2); ?></td>
														 <td></td>
												</tr>
												<?php
												}
												?>
									 </table>
                   <?php  if ($total!=0 && isset($_SESSION['username']) && ($_SESSION['username']!=null)) {?>
									 <input type="submit" name="submit" value="Order" class="genric-btn primary">
                 <?php  }?>
							</div>
							</form>
							</div>

                <div class="container">
					<div class="row d-flex justify-content-center">
						<div class="menu-content pb-70 col-lg-8">
							<div class="title text-center">
								<h1 class="mb-10">What kind of Foods we serve for you</h1>
								<p>Who are in extremely love with eco friendly system.</p>
							</div>
						</div>
					</div>

                    <ul class="filter-wrap filters col-lg-12 no-padding">
                        <li class="active" data-filter="*">All Menu</li>
                        <li data-filter=".Coffee">Coffee</li>
                        <li data-filter=".Food">Food</li>

                    </ul>

                    <div class="filters-content">
<div class="row grid">


	<div class="container" style="width:700px;">
<?php
$query = "SELECT * FROM product ORDER BY product_id ASC";
$result = mysqli_query($connect, $query);
if(mysqli_num_rows($result) > 0)
{
		 while($row = mysqli_fetch_array($result))
		 {

?>

<div class="col-md-6 all <?php echo $row["product_type"]; ?>">
<div class="single-menu">
<div class="title-wrap d-flex justify-content-between">
	<dt data-event="Menu Item" id="IT_000000000298" class="menu-item" >
		<div class="menu-item-heading">
		 <form method="post" action="menu.php?action=add&id=<?php echo $row["product_id"]; ?>">


							 <h4 class="text-info"><?php echo $row["name"]; ?></h4>
							 <h4 class="text-danger">€ <?php echo $row["price"]; ?></h4>
							 <input type="number" min="0" step="1" name="quantity" class="form-control"  />

							 <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />
							 <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />
							 <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />

		 </form>
	 </div>

				 </dt>
		 </div>
		 </div>
</div>
<?php
		 }
}
$connect->close();
?>
</div>

												</div>



                    </div>

<div class="col-lg-5 reservation-right">
  <form class="form-wrap text-center" action="#">
<div style="clear:both"></div>
<br />
<h3>Order Details</h3>
<div class="table-responsive">
		 <table class="table table-bordered">
					<tr>
							 <th width="40%">Item Name</th>
							 <th width="10%">Quantity</th>
							 <th width="20%">Price</th>
							 <th width="15%">Total</th>
							 <th width="5%">Action</th>
					</tr>
					<?php
					if(!empty($_SESSION["shopping_cart"]))
					{
							 $total = 0;
							 foreach($_SESSION["shopping_cart"] as $keys => $values)
							 {
					?>
					<tr>
							 <td><?php echo $values["item_name"]; ?></td>
							 <td><?php echo $values["item_quantity"]; ?></td>
							 <td>€ <?php echo $values["item_price"]; ?></td>
							 <td>€ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
							 <td><a href="menu.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
					</tr>
					<?php
										$total = $total + ($values["item_quantity"] * $values["item_price"]);
							 }
					?>
					<tr>
							 <td colspan="3" align="right">Total</td>
							 <td align="right">€ <?php echo number_format($total, 2); ?></td>
							 <td></td>
					</tr>
					<?php
					}
					?>
		 </table>
</div>
</form>
</div>



										</div>


            </section>
            <!-- End menu-area Area -->

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

					</div>
				</div>
			</section>
			<!-- End reservation Area -->

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

<?php
	Include 'links/dataConnector.php';
	session_start();
	$data = new dataConnector();
	$table = $data->select("products", "1");
	if (isset($_SESSION['username'])) {
		if ($_SESSION['username'] == 'admin') {
			header("LOCATION: adminControls.php");
		}
	}
	if (isset($_SESSION['cart'])) {

	}
	else{
		$_SESSION['cart'] = array();
	}
	$total = 0;
	$total_quan = 0;
	foreach ($_SESSION['cart'] as $thing) {
		$total_quan += $thing['quantity'];
	}
	$SQL = "SELECT DISTINCT prodCat FROM products;";
	$categories = $data->connection->query($SQL);
?>

<!doctype html>
<html class="no-js" lang="en">

    <head>
        <!-- meta data -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <!--font-family-->
		<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

        <!-- title of site -->
        <title>APLIFY</title>

        <!-- For favicon png -->
		<link rel="shortcut icon" type="image/icon" href="assets/logo/aplifylogo2.ico"/>

        <!--font-awesome.min.css-->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

        <!--linear icon css-->
		<link rel="stylesheet" href="assets/css/linearicons.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/solid.min.css" integrity="sha512-6mc0R607di/biCutMUtU9K7NtNewiGQzrvWX4bWTeqmljZdJrwYvKJtnhgR+Ryvj+NRJ8+NnnCM/biGqMe/iRA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

		<!--animate.css-->
        <link rel="stylesheet" href="assets/css/animate.css">

		<!-- Bootstrap -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  
        <!--style.css-->
        <link rel="stylesheet" href="assets/css/style.css">

        <!--responsive.css-->
        <link rel="stylesheet" href="assets/css/responsive.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

        <!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

	<body>
		<!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

		<!-- Header Start -->
		<nav class="navbar navbar-expand-lg bg-light sticky-top shadow">
			<div class="container-fluid justify-content-around align-items-center px-5 bg-light">
				<a class="navbar-brand" href="#">
					<img src="assets\logo\aplify.png" style="height: 7vh;">
				</a>
				<?php if(isset($_SESSION['username'])): ?>
					<div class="nav-item px-3">
						<h6>Welcome <?= $_SESSION['username']; ?> </h6>
					</div>
				<?php endif; ?>
				<button class="navbar-toggler float-end me-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav me-5 py-2 mb-lg-0">
						<li class="nav-item px-1">
							<a class="nav-link active" aria-current="page" href="index.php">Home</a>
						</li>
						<li class="nav-item dropdown px-1">
							<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								Categories
							</a>
							<ul class="dropdown-menu">
								<?php foreach($categories as $category): ?>
									<form action="catTemplate.php" method="post">
										<input type="hidden" name="selectedCat" value="<?= $category['prodCat']; ?>">
										<li>
											<button type="submit" class="dropdown-item" href="checkoutPage.php">
												<?= $category['prodCat']; ?>
											</button>
										</li>
									</form>
								<?php endforeach; ?>
							</ul>
						</li>
						<li class="nav-item dropdown px-1">
							<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								Account
							</a>
							<ul class="dropdown-menu">
								<?php if(isset($_SESSION['username'])): ?>
									<li><a class="dropdown-item" href="checkoutPage.php">Account</a></li>
									<li><a class="dropdown-item" href="messages.php">Messages</a></li>
									<li><a class="dropdown-item" href="links/logout.php">Log Out</a></li>
								<?php else: ?>
									<li><a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#loginModal" href="#">Login</a></li>
									<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#registerModal" href="#">Register</a></li>
								<?php endif; ?>
							</ul>
						</li>
					</ul>
				</div>
				<?php if(count($_SESSION['cart'])): ?>
					<div class="nav-item">
						<div class="btn-group dropstart">
							<button class="dropdown-toggle bg-transparent" id="cartDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
									aria-expanded="false">
									<span class="lnr lnr-cart"></span>
							</button>
							<div class="dropdown-menu dropdown-menu-start" aria-labelledby="cartDropdown">
								<?php foreach($_SESSION['cart'] as $item): ?>
									<div class="dropdown-item container">
										<div class="row justify-content-center align-items-center">
											<div class="col"><?= $thing['prodName']; ?></div>
											<div class="col"><?= $thing['quantity'] . ' x '; ?> </div>
											<div class="col"><?= $thing['price']; ?></div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</nav>
		<!-- Header End -->

		<!--welcome-hero start -->
		<header id="home">

		    <div id="homePageCarousel" class="carousel slide bg-dark" data-bs-ride="carousel">
				<ol class="carousel-indicators">
					<li data-bs-target="#homePageCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="First slide"></li>
					<li data-bs-target="#homePageCarousel" data-bs-slide-to="1" aria-label="Second slide"></li>
					<li data-bs-target="#homePageCarousel" data-bs-slide-to="2" aria-label="Third slide"></li>
				</ol>
				<div class="carousel-inner" role="listbox">
					<div class="carousel-item active">
						<div class="container py-5">
							<div class="row justify-content-center align-items-center">
								<div class="col">
									<img src="assets\images\products\Television\50UHD202\50UHD202_1.png" class="h-25 w-75" alt="First slide" style="object-fit:contain; aspect-ratio: 3/2;">
								</div>
								<div class="col">
									<div class="carousel-caption text-end">
										<h3>50UHD202 SMART 4K TV</h3>
										<p>
											Ultra HD 3840×2160<br>
											Vidaa U Operating System<br>
											VEWD App Store, Youtube, Netflix<br>
											HDR Compatible<br>
											Bluetooth Function<br>

											Size		50″<br>
											Backlight	Direct LED<br>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="carousel-item">
						<div class="container py-5">
							<div class="row justify-content-center align-items-center">
								<div class="col">
									<img src="assets\images\products\Television\2T-C50BG1X.png" class="h-25 w-75" alt="Second slide" style="object-fit:contain; aspect-ratio: 3/2;">
								</div>
								<div class="col">
									<div class="carousel-caption text-end">
										<h3>2K Android TV 2T-C50BG1X</h3>
										<p style="font-size: 0.7em;">
											Thousands of applications to download and install such as VODs, Games, News, etc. <br>
											Interact with your Android TV thru its built-in Voice Assistant using the remote control<br>
											Built-in Dual-band Wi-Fi Receiver to receive either of 2.4GHz and 5GHz wifi frequency<br>
											Built-in 5G Wi-Fi Receiver for faster and stable connection for video streaming, online gaming, and downloading<br>
											AQUOS original processor that enhance and ensure the viewing quality of experience<br><br>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="carousel-item">
						<div class="container py-5">
							<div class="row justify-content-center align-items-center">
								<div class="col">
									<img src="assets\images\products\Refridgerator\6WSP21NIHPG\6WSP21NIHPG.jpg" class="h-25 w-75" alt="Third slide" style="object-fit:contain; aspect-ratio: 3/2;">
								</div>
								<div class="col">
									<div class="carousel-caption text-end">
										<h3>Whirlpool 6WSP21NIHPG</h3>
										<p>
											Zen Inverter Technology<br>
											6th Sense Technology<br>
											Smart Mode<br>
											Quick Cooling Mode<br>
											Quick Freezing Mode<br>
											Photosynthesis LED Light<br>
											Smart Defrosting<br>
											Child Lock - Control Panel<br>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<button class="carousel-control-prev text-black" type="button" data-bs-target="#homePageCarousel" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next text-black" type="button" data-bs-target="#homePageCarousel" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</button>
			</div>

		</header>
		<!--welcome-hero end -->

		<!--new-arrivals start -->
		<section id="new-arrivals" class="new-arrivals">
			<div class="container">
				<div class="section-header">
					<h2>New Arrivals</h2>
				</div><!--/.section-header-->
				<div class="new-arrivals-content">
					<div class="row">
						<div class="col-md-3 col-sm-4">
							<div class="single-new-arrival">
								<div class="single-new-arrival-bg" >
									<img src="assets/images/products/Air Conditioner/HMSTINV10ZEN.jpg" alt="new-arrivals images">
									<div class="single-new-arrival-bg-overlay"></div>
									<div class="new-arrival-cart">
										<p>
											<span class="lnr lnr-cart"></span>
											<a onclick="choose(this)">View Details</a>
										</p>
									</div>
								</div>
								<h4><a onclick="chooseSelf(this)">Hanabishi Inverter Split Type Air Conditioner</a></h4>
								<p class="arrival-product-price">₱ 29,470.00</p>
							</div>
						</div>
						<div class="col-md-3 col-sm-4">
							<div class="single-new-arrival">
								<div class="single-new-arrival-bg">
									<img src="assets/images/products/Air Conditioner/SAH09CIW/SAH09CIW.jpg" alt="new-arrivals images">
									<div class="single-new-arrival-bg-overlay"></div>
									<div class="new-arrival-cart">
										<p>
											<span class="lnr lnr-cart"></span>
											<a onclick="choose(this)">View Details</a>
										</p>
									</div>
								</div>
								<h4><a onclick="chooseSelf(this)">Whirlpool SAH09CIW</a></h4>
								<p class="arrival-product-price">₱38,998.00</p>
							</div>
						</div>
						<div class="col-md-3 col-sm-4">
							<div class="single-new-arrival">
								<div class="single-new-arrival-bg">
									<img src="assets/images/products/Refridgerator/HADDREF98SSINV/HADDREF98SSINV.jpg" alt="new-arrivals images">
									<div class="single-new-arrival-bg-overlay"></div>
									<div class="new-arrival-cart">
										<p>
											<span class="lnr lnr-cart"></span>
											<a onclick="choose(this)">View Details</a>
										</p>
									</div>
								</div>
								<h4><a onclick="chooseSelf(this)">Hanabishi Double Door No Frost Inverter Refrigerator 9.8 CUFT</a></h4>
								<p class="arrival-product-price">₱23,155.00</p>
							</div>
						</div>
						<div class="col-md-3 col-sm-4">
							<div class="single-new-arrival">
								<div class="single-new-arrival-bg">
									<img src="assets/images/products/Refridgerator/HASBSREF18SSINV/HASBSREF18SSINV.jpg" alt="new-arrivals images">
									<div class="single-new-arrival-bg-overlay"></div>
									<div class="new-arrival-cart">
										<p>
											<span class="lnr lnr-cart"></span>
											<a onclick="choose(this)">View Details</a>
										</p>
									</div>
								</div>
								<h4><a onclick="chooseSelf(this)">Hanabishi Eco-Inverter Side by Side Refrigerator</a></h4>
								<p class="arrival-product-price">₱44,210.00</p>
							</div>
						</div>
						<div class="col-md-3 col-sm-4">
							<div class="single-new-arrival">
								<div class="single-new-arrival-bg">
									<img src="assets/images/products/Refridgerator/HASREF60S/HASREF60S.jpg" alt="new-arrivals images">
									<div class="single-new-arrival-bg-overlay"></div>
									<div class="new-arrival-cart">
										<p>
											<span class="lnr lnr-cart"></span>
											<a onclick="choose(this)">View Details</a>
										</p>
									</div>
								</div>
								<h4><a onclick="chooseSelf(this)">Hanabishi Single Door Refrigerator </a></h4>
								<p class="arrival-product-price">₱14,735.00</p>
							</div>
						</div>
						<div class="col-md-3 col-sm-4">
							<div class="single-new-arrival">
								<div class="single-new-arrival-bg">
									<img src="assets/images/products/Television/43LN5600PTA/43LN5600PTA.png" alt="new-arrivals images">
									<div class="single-new-arrival-bg-overlay"></div>
									<div class="new-arrival-cart">
										<p>
											<span class="lnr lnr-cart"></span>
											<a onclick="choose(this)">View Details</a>
										</p>
									</div>
								</div>
								<h4><a onclick="chooseSelf(this)">43" LN56 Series Smart FHD TV</a></h4>
								<p class="arrival-product-price">₱14,100.00</p>
							</div>
						</div>
						<div class="col-md-3 col-sm-4">
							<div class="single-new-arrival">
								<div class="single-new-arrival-bg">
									<img src="assets/images/products/Television/QA75QN800AGXXP/QA75QN800AGXXP.png" alt="new-arrivals images">
									<div class="single-new-arrival-bg-overlay"></div>
									<div class="new-arrival-cart">
										<p>
											<span class="lnr lnr-cart"></span>
											<a onclick="choose(this)">View Details</a>
										</p>
									</div>
								</div>
								<h4><a onclick="chooseSelf(this)">SAMSUNG 75" Neo QLED 8K QN800A (2021)</a></h4>
								<p class="arrival-product-price">₱314,999.00</p>
							</div>
						</div>
						<div class="col-md-3 col-sm-4">
							<div class="single-new-arrival">
								<div class="single-new-arrival-bg">
									<img src="assets/images/products/Television/LC-40LE360D3/LC-40LE360D3.jpg" alt="new-arrivals images">
									<div class="single-new-arrival-bg-overlay"></div>
									<div class="new-arrival-cart">
										<p>
											<span class="lnr lnr-cart"></span>
											<a onclick="choose(this)">View Details</a>
										</p>
									</div>
								</div>
								<h4><a onclick="chooseSelf(this)">Sharp Full HD/EASY SMART TV LC-50SA5500X</a></h4>
								<p class="arrival-product-price">₱27,697.00</p>
							</div>
						</div>
					</div>
				</div>
			</div><!--/.container-->

		</section>
		<!--new-arrivals end -->


		<!--best seller start -->

		<section id="best-seller" class="new-arrivals">
			<div class="container">
				<div class="section-header">
					<h2>Best Seller</h2>
				</div><!--/.section-header-->
				<div class="new-arrivals-content">
					<div class="row">
						<div class="col-md-4">
							<div class="single-new-arrival">
								<div class="single-new-arrival-bg" style="min-height: 415px;">
									<img src="assets/images/products/Air Conditioner/HMSTINV10ZEN.jpg" alt="new-arrivals images">
									<div class="single-new-arrival-bg-overlay"></div>
									<div class="new-arrival-cart">
										<p>
											<span class="lnr lnr-cart"></span>
											<a onclick="choose(this)">View Details</a>
										</p>
									</div>
								</div>
								<h4><a onclick="chooseSelf(this)">Hanabishi Inverter Split Type Air Conditioner</a></h4>
								<p class="arrival-product-price">₱ 29,470.00</p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="single-new-arrival">
								<div class="single-new-arrival-bg" style="min-height: 415px;">
									<img src="assets/images/products/Air Conditioner/SAH09CIW/SAH09CIW.jpg" alt="new-arrivals images">
									<div class="single-new-arrival-bg-overlay"></div>
									<div class="new-arrival-cart">
										<p>
											<span class="lnr lnr-cart"></span>
											<a onclick="choose(this)">View Details</a>
										</p>
									</div>
								</div>
								<h4><a onclick="chooseSelf(this)">Whirlpool SAH09CIW</a></h4>
								<p class="arrival-product-price">₱38,998.00</p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="single-new-arrival">
								<div class="single-new-arrival-bg"style="min-height: 415px;">
									<img src="assets/images/products/Refridgerator/HADDREF98SSINV/HADDREF98SSINV.jpg" alt="new-arrivals images">
									<div class="single-new-arrival-bg-overlay"></div>
									<div class="new-arrival-cart">
										<p>
											<span class="lnr lnr-cart"></span>
											<a onclick="choose(this)">View Details</a>
										</p>
									</div>
								</div>
								<h4><a onclick="chooseSelf(this)">Hanabishi Double Door No Frost Inverter Refrigerator 9.8 CUFT</a></h4>
								<p class="arrival-product-price">₱23,155.00</p>
							</div>
						</div>

						<div class="col-md-4">
							<div class="single-new-arrival">
								<div class="single-new-arrival-bg" style="min-height: 415px;">
									<img src="assets/images/products/Refridgerator/HASREF60S/HASREF60S.jpg" alt="new-arrivals images">
									<div class="single-new-arrival-bg-overlay"></div>
									<div class="new-arrival-cart">
										<p>
											<span class="lnr lnr-cart"></span>
											<a onclick="choose(this)">View Details</a>
										</p>
									</div>
								</div>
								<h4><a onclick="chooseSelf(this)">Hanabishi Single Door Refrigerator </a></h4>
								<p class="arrival-product-price">₱14,735.00</p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="single-new-arrival">
								<div class="single-new-arrival-bg" style="min-height: 415px;">
									<img src="assets/images/products/Television/43LN5600PTA/43LN5600PTA.png" alt="new-arrivals images">
									<div class="single-new-arrival-bg-overlay"></div>
									<div class="new-arrival-cart">
										<p>
											<span class="lnr lnr-cart"></span>
											<a onclick="choose(this)">View Details</a>
										</p>
									</div>
								</div>
								<h4><a onclick="chooseSelf(this)">43" LN56 Series Smart FHD TV</a></h4>
								<p class="arrival-product-price">₱14,100.00</p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="single-new-arrival">
								<div class="single-new-arrival-bg" style="min-height: 415px;">
									<img src="assets/images/products/Television/43LN5600PTA/43LN5600PTA.png" alt="new-arrivals images">
									<div class="single-new-arrival-bg-overlay"></div>
									<div class="new-arrival-cart">
										<p>
											<span class="lnr lnr-cart"></span>
											<a onclick="choose(this)">View Details</a>
										</p>
									</div>
								</div>
								<h4><a onclick="chooseSelf(this)">43" LN56 Series Smart FHD TV</a></h4>
								<p class="arrival-product-price">₱14,100.00</p>
							</div>
						</div>


					</div>
				</div>
			</div><!--/.container-->

		</section>
		<!--best seller end -->

		<!--feature start -->
		<section id="feature" class="feature">
			<div class="container">
				<div class="section-header">
					<h2>featured products</h2>
				</div><!--/.section-header-->
				<div class="feature-content">
					<div class="row">
						<div class="col-sm-3">
							<div class="single-feature">
								<img src="assets/images/products/Television/QA85QN900AGXXP/QA85QN900AGXXP.png" alt="feature image">
								<div class="single-feature-txt text-center">
									<p>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<span class="spacial-feature-icon"><i class="fa fa-star"></i></span>
										<span class="feature-review">(45 review)</span>
									</p>
									<h3><a onclick="chooseSelf(this)">85" Neo QLED 8K QN900A (2021)</a></h3>
									<h5>₱643,122.00</h5>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="single-feature">
								<img src="assets/images/products/Refridgerator/RF85A920CSG/RF85A920CSG.png" alt="feature image">
								<div class="single-feature-txt text-center">
									<p>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<span class="spacial-feature-icon"><i class="fa fa-star"></i></span>
										<span class="feature-review">(45 review)</span>
									</p>
									<h3>
										<a onclick="chooseSelf(this)">SAMSUNG 30.8 cu.ft. French Door No Frost Inverter Ref w/ Food Showcase</a>
									</h3>
									<h5>₱159,858.00</h5>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="single-feature">
								<img src="assets/images/products/Air Conditioner/FP-53CFV036308-1.png" alt="feature image">
								<div class="single-feature-txt text-center">
									<p>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<span class="spacial-feature-icon"><i class="fa fa-star"></i></span>
										<span class="feature-review">(45 review)</span>
									</p>
									<h3><a onclick="chooseSelf(this)">Carrier Slimpac Inverter</a></h3>
									<h5>₱151,000.00</h5>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="single-feature">
								<img src="assets/images/products/Television/QA75QN800AGXXP/QA75QN800AGXXP.png" alt="feature image">
								<div class="single-feature-txt text-center">
									<p>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<span class="spacial-feature-icon"><i class="fa fa-star"></i></span>
										<span class="feature-review">(45 review)</span>
									</p>
									<h3>
										<a onclick="chooseSelf(this)">Samsung 75" Neo QLED 8K QN800A (2021)</a></h3>
									<h5>₱314,999.00 </h5>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!--/.container-->

		</section>
		<!--feature end -->


		<!--newsletter start -->

		<section id="newsletter"  class="newsletter">
			<div class="container">
				<div class="hm-footer-details container-fluid">
					<div class="row px-5 mx-5">
						<div class="col container-fluid justify-content-end">
							<div class="row justify-content-end align-items-center">
								<div class="col">
									<img style="height: 5em;object-fit: contain;" src="assets/logo/aplifylogo2.png" alt=""/>
								</div>
							</div>
							<div class="row justify-content-end align-items-center">
								<div class="col">
									<p class="text-secondary">"Living Made Easy"</p>
								</div>
							</div>
						</div>
						<div class=" col" style="text-align:right;">
							<div class="hm-footer-widget">
								<div class="hm-foot-menu ">
									<ul class="list-group list-group-flush">
										<li class="list-group-item">
											<h6>Account Details</h6>
										</li>
										<li class="list-group-item">
											<a href="orderHistory.php">
												order history
											</a>
										</li>
									</ul><!--/ul-->
								</div><!--/.hm-foot-menu-->
							</div><!--/.hm-footer-widget-->
						</div><!--/.col-->
					</div><!--/.row-->
				</div><!--/.hm-footer-details-->

			</div><!--/.container-->

		</section><!--/newsletter-->
		<!--newsletter end -->

		<!--footer start-->
		<footer id="footer"  class="footer">
			<div class="container">
				<div class="hm-footer-copyright text-center">
					<p>
						&copy; 2022 Aplify Inc. All rights reserved
					</p><!--/p-->
				</div><!--/.text-center-->
			</div><!--/.container-->

			<div id="scroll-Top">
				<div class="return-to-top">
					<i class="fa fa-angle-up " id="scroll-top" data-toggle="tooltip" data-placement="top" title="" data-original-title="Back to Top" aria-hidden="true"></i>
				</div>

			</div><!--/.scroll-Top-->

        </footer><!--/.footer-->
		<!--footer end-->

		<!-- Include all js compiled plugins (below), or include individual files as needed -->

		<script src="assets/js/jquery.js"></script>

        <!--modernizr.min.js-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    </body>

</html>
<form action="Product_name.php" id="itemToAddForm" method="post">
	<input type="hidden" id="itemToAdd" name="itemToView" />
</form>

<form id="logoutForm" action="links/logout.php" method="post"></form>

<form id="catForm" action="catTemplate.php" method="post">
	<input id="selectedCat" type="hidden" name="selectedCat">
</form>

<form action="links/login.php" method="POST">
	<!-- Modal Body -->
	<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
	<div class="modal fade text-black" id="loginModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<h5 class="modal-title" id="modalTitleId">Login</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row justify-content-center align-items-center text-center">
							<div class="col">
								<img src="assets\logo\aplifylogo2.png" style="object-fit: contain; height: 5em;"  alt="">
							</div>
						</div>
						<div class="row justify-content-center align-items-center">
							<div class="col">
								<div class="mb-3">
								  <label for="" class="form-label">Username / Email</label>
								  <input type="text" class="form-control" name="loginCredential" id="loginCredential" aria-describedby="helpId" placeholder="" required>
								</div>
							</div>
						</div>
						<div class="row justify-content-center align-items-center">
							<div class="col">
								<div class="mb-3">
								  <label for="" class="form-label">Password</label>
								  <input type="password" class="form-control" name="loginCredentialPass" id="loginCredentialPass" aria-describedby="helpId" placeholder="" required>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer text-center">
					<div class="container-fluid">
						<div class="row justify-content-center align-items-center">
							<div class="col">
								<button data-bs-toggle="modal" data-bs-target="#registerModal" type="button" style="background: #e99c2e; border:0;"  class="btn btn-secondary" data-bs-dismiss="modal">Register</button>	
							</div>
							<div class="col">
								<button type="submit" class="btn btn-primary">Login</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
		
<form action="links/registration.php" method="POST">
	<!-- Modal Body -->
	<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
	<div class="modal fade text-black" id="registerModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitleId">Registration</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row justify-content-center align-items-center">
							<div class="mb-3 col">
								<label for="" class="form-label">First Name</label>
								<input type="text" class="form-control" name="firstname" id="firstname" required>
							</div>
							<div class="mb-3 col">
								<label for="" class="form-label">Middle Name</label>
								<input type="text" class="form-control" name="middlename" id="middlename" required>
							</div>
							<div class="mb-3 col">
								<label for="" class="form-label">Last Name</label>
								<input type="text" class="form-control" name="lastname" id="lastname" required>
							</div>
						</div>
						<div class="row justify-content-center align-items-center">
							<div class="col mb-3">
								<label for="" class="form-label">Street Address</label>
								<input type="text" class="form-control" name="street" id="street" aria-describedby="helpId" placeholder="Blk 25 Lot 21 Kingstown 2">
								<small id="helpId" class="form-text text-muted">Street / House / Floor / Unit No.</small>
							</div>
						</div>
						<div class="row justify-content-center align-items-center">
							<div class="col mb-3">
								<label for="" class="form-label">Zip Code</label>
								<input type="number" class="form-control" name="zipcode" id="zipcode" aria-describedby="helpId" placeholder="1421">
								<small id="helpId" class="form-text text-muted">4 Digit Code</small>
							</div>
						</div>
						<div class="row justify-content-center align-items-center">
							<div class="col mb-3">
								<label for="" class="form-label">City</label>
								<input type="text" class="form-control" name="city" id="city" aria-describedby="helpId" placeholder="Caloocan City">
							</div>
						</div>
						<div class="row justify-content-center align-items-center">
							<label for="" class="form-label">Phone Number</label>
							<div class="col input-group mb-3">
								<span class="input-group-text" id="basic-addon1">+63</span>
								<input type="text" class="form-control" name="phonenumber" id="phonenumber" aria-describedby="helpId" placeholder="">
							</div>
						</div>
						<div class="row justify-content-center align-items-center">
							<div class="col">
								<div class="mb-3">
								  <label for="" class="form-label">Email</label>
								  <input type="email" class="form-control" name="emailReg" id="emailReg" aria-describedby="helpId" placeholder="">
								</div>
							</div>
						</div>
						<div class="row justify-content-center align-items-center">
							<div class="col">
								<div class="mb-3">
								  <label for="" class="form-label">Username</label>
								  <input type="text" class="form-control" name="userReg" id="userReg" aria-describedby="helpId" placeholder="">
								</div>
							</div>
						</div>
						<div class="row justify-content-center align-items-center">
							<div class="col">
								<div class="mb-3">
								  <label for="" class="form-label">Password</label>
								  <input type="password" class="form-control" name="passReg" id="passReg" aria-describedby="helpId" placeholder="">
								</div>
							</div>
						</div>
						<div class="row justify-content-center align-items-center">
							<div class="col">
								<div class="mb-3">
								  <label for="" class="form-label">Confirm Password</label>
								  <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" aria-describedby="helpId" placeholder="">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="container-fluid">
						<div class="row justify-content-center align-items-center text-center">
							<div class="col">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							</div>
							<div class="col">
								<button type="submit" style="background: #e99c2e; border:0;" class="btn btn-primary">Register</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>


<script>
	function choose(self){
		var text = self.parentNode.parentNode.parentNode.nextSibling.nextSibling.childNodes[0].innerHTML;
		document.getElementById("itemToAdd").value = text;
		document.getElementById("itemToAddForm").submit();
	}

	function chooseSelf(self){
		var text = self.innerHTML;
		document.getElementById("itemToAdd").value = text;
		document.getElementById("itemToAddForm").submit();
	}
	function selectCat(self){
		document.getElementById('selectedCat').value = self.innerHTML;
		document.getElementById('catForm').submit();
	}
	
	$(document).ready(()=>{
		$("#confirmPassword").on('input', ()=>{
			if($('#confirmPassword').val() != $('#passReg').val()){
				$("#confirmPassword").addClass("is-invalid");
			}
			else{
				$("#confirmPassword").removeClass("is-invalid");
				$("#confirmPassword").addClass("is-valid");

			}
		});
	});
</script>
<?php require 'toastr.php'; ?>

<script src="assets/js/validation.js"></script>
<?php
	Include 'links/dataConnector.php';
	session_start();
	$data = new dataConnector();
	$table = $data->select("products", "1");
	if (!isset($_SESSION['username'])) {
		header("LOCATION: index.php");
		die();
	}
	if ($_SESSION['username'] == 'admin') {
		header("LOCATION: adminControls.php");
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
	$rawMsg = $data->select("messages", "link like '%". $_SESSION['username'] ."%'");
	$msgs = array();
	while ($row = $rawMsg->fetch_assoc()) {
		$sender = explode("-", $row['link'])[0] == $_SESSION['username'] ? True : False;
		array_push($msgs, array($sender, $row['message']));
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
		
		
		<section id="new-arrivals" class="new-arrivals">
			<div class="container">
				<div class="section-header" style="margin-top:100px; margin-bottom: 50px;">
					<h2>Admin Messages</h2>
				</div><!--/.section-header-->
				<hr>
				<div class="new-arrivals-content">
					<div class="row container">
						<?php

							foreach ($msgs as $thing) {
								if ($thing[0]) {
									echo "<div style='background-color: #3486eb; border-radius:5em; padding: 1em 5em; color: white; margin-top:1em; box-shadow: 5px 8px #888888;'>
										".$thing[1]."
									</div>";
								}
								else{
									echo "<div style='box-shadow: 5px 8px #888888; background-color: white; border: 2px solid black; border-radius:5em; padding: 1em 5em; color: black; margin-top:1em; text-align:right;'>
										".$thing[1]."
									</div>";
								}
							}

						?>
						<form action="links/userMessage.php" method="post" style="justify-content: center; margin-top:4em;">
							<textarea style="width: 100%;" name="message" rows="3" cols="80"></textarea>
							<br>
							<input class="btn btn-primary"  type="submit" name="" value="Send">
						</form>
					</div>
				</div>
			</div><!--/.container-->

		</section><!--/.new-arrivals-->
		<!--new-arrivals end -->


		<!--best seller start -->



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
  

		<!-- bootsnav js -->
		<script src="assets/js/bootsnav.js"></script>

		<!--owl.carousel.js-->
        <script src="assets/js/owl.carousel.min.js"></script>


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

<script>
	function logout(){
		document.getElementById('logoutForm').submit();
	}

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


	function selectCat(self){
		document.getElementById('selectedCat').value = self.innerHTML;
		document.getElementById('catForm').submit();
	}
	function goToMessages(){
		document.location.replace("messages.php");
	}

</script>

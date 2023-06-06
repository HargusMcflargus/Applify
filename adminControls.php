<?php
	Include 'links/dataConnector.php';
	session_start();
    if (isset($_SESSION['username'])){
        $data = new dataConnector();
    	$table = $data->select("products", "1");
    	if (isset($_SESSION['cart'])) {

    	}
    	else{
    		$_SESSION['cart'] = array();
    	}
		$Total = 0;
		$total_quan = 0;
		foreach ($_SESSION['cart'] as $thing) {
			$total_quan += $thing['quantity'];
		}
		$results = $data->select("history", "1");
    }
    else{
        header("Location: index.php");
        die();
    }
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
        <title>Furniture</title>

        <!-- For icon png -->
		<link rel="shortcut icon" type="image/icon" href="assets/logo/aplifylogo2.ico"/>

        <!--font-awesome.min.css-->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

        <!--linear icon css-->
		<link rel="stylesheet" href="assets/css/linearicons.css">

		<!--animate.css-->
        <link rel="stylesheet" href="assets/css/animate.css">

        <!--owl.carousel.css-->
        <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
		<link rel="stylesheet" href="assets/css/owl.theme.default.min.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  

		<!-- bootsnav -->
		<link rel="stylesheet" href="assets/css/bootsnav.css" >

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
							<a class="nav-link active" aria-current="page" href="adminControls.php">Home</a>
						</li>
						<li class="nav-item dropdown px-1">
							<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								Account
							</a>
							<ul class="dropdown-menu">
								<?php if(isset($_SESSION['username'])): ?>
									<li><a class="dropdown-item" href="adminMessage.php">Messages</a></li>
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

		<div class="container" style="padding-top: 200px; ">
				<div class="row justify-content-center">
				<h1>Order History</h1><br>
				<table class="table border-1">
					<thead>
						<tr>
							<th>Preview</th>
							<th>Product</th>
							<th>Date</th>
							<th>User</th>
							<th>Quantity</th>
							<th>Total</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = $results->fetch_assoc()): ?>
							<tr>
								<td>
									<img width='120em'  src='<?= $row['imageLink']; ?>'></img>
								</td>
								<td>
									<?= $row['product']; ?>
								</td>

								<td>
									<?= $row['dateOfPurchase']; ?>
								</td>

								<td>
									<?= $row['customerName']; ?>
								</td>

								<td>
									<?= $row['quantity']; ?>
								</td>

								<td>
									<?= $row['total']; ?>
								</td>
								<td>
									<select name="statusUpdate" class="form-select statusUpdate" <?= $row['status'] == "Arrived" ? "disabled" : ""; ?>>
										<option value="<?= $row['ID']; ?>" class="d-none"></option>
										<option value="Processing" <?= $row['status'] == "Processing" ? "selected" : ""; ?>>Processing</option>
										<option value="Delivering" <?= $row['status'] == "Delivering" ? "selected" : ""; ?>>Delivering</option>
										<option value="Arrived" <?= $row['status'] == "Arrived" ? "selected" : ""; ?>>Arrived</option>
									</select>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>

		</div>

		<!--  div for the whole desc and reviews-->
		<br><br><br><br><br><br><br><br><br><br>

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

        </footer>
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


        <!--Custom JS-->
        <script src="assets/js/custom.js"></script>

<form id="addToCartForm" action="links/addToCart.php" method="post">
	<input type="hidden" name="itemToAdd" id="itemToAddInput">
	<input type="hidden" name="itemToAddQuantity" id="itemToAddQuantityInput" />
</form>
<form id="logoutForm" action="links/logout.php" method="post"></form>
<form id="catForm" action="catTemplate.php" method="post">
	<input id="selectedCat" type="hidden" name="selectedCat">
</form>

<?php include "toastr.php"; ?>

<script>


	function logout(){
		document.getElementById('logoutForm').submit();
	}

	function addToCart(){
		document.getElementById('itemToAddInput').value = document.getElementById('currentProdName').innerHTML;
		document.getElementById('itemToAddQuantityInput').value = document.getElementById('itemToAddField').value;
		document.getElementById('addToCartForm').submit();
	}

		

	function selectCat(self){
		document.getElementById('selectedCat').value = self.innerHTML;
		document.getElementById('catForm').submit();
	}
	function goToMessages(){
		document.location.replace("messages.php");
	}

	$(".statusUpdate").on("change", (event)=>{
		$.ajax({
			url: "links/updateStatus.php",
			method: "POST",
			data: {
				ID: $(event.currentTarget).children(".d-none").val(),
				Status: $(event.currentTarget).val()
			},
			success: (data)=>{
				toastr.options = {
					"onclick": ()=>{
						location.reload();
					}
				};
				toastr.success("Updated Status Successfully");
			}
		});
	});
	</script>

    </body>

</html>

<?php
	Include 'links/dataConnector.php';
	session_start();
	if (isset($_SESSION['username'])) {
		if ($_SESSION['username'] == 'admin') {
			header("LOCATION: adminControls.php");
		}
	}
    if (isset($_POST['itemToView'])){
        $data = new dataConnector();
    	$table = $data->select("products", "1");
    	if (isset($_SESSION['cart'])) {

    	}
    	else{
    		$_SESSION['cart'] = array();
    	}
        $item = $data->select("products", "prodName='" . $_POST['itemToView'] . "'");
        $item = $item->fetch_assoc();
		$comments = $data->select("comments", "productName='". $_POST['itemToView'] . "'");
		$Total = 0;
		$total_quan = 0;
		foreach ($_SESSION['cart'] as $thing) {
			$total_quan += $thing['quantity'];
		}
		$SQL = "SELECT DISTINCT prodCat FROM products;";
		$categories = $data->connection->query($SQL);
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

		<div class="container" style="padding-top: 200px; ">
				<div class="row justify-content-center">

                    <div class="col-sm-5">
                        <img src="<?php echo $item['imageLink'] ?>" style=" width: 900px; height: 400px;" alt="image" />
                    </div>

    				<div class="col-sm-7">
                        <h1 style="font-size: 30px;" id="currentProdName"><?php echo $item['prodName']; ?></h1>

    					<hr>
                        <h3 style="font-size: 28px;" ><?php echo $item['price']; ?></h3>
        				<hr>
        				<input id="itemToAddField" value="1" placeholder="1" type="number" size="50" style=" width:100px; height:40px; font-size:20pt;" required/>
        				<a class="btn btn-primary btn-lg" style="background-color: #e99c2e  !important; border: 1px solid #e99c2e; margin-left: 10px; margin-top: -10px; padding: 10px 16px; font-size:16px;" onclick="addToCart()">Add to cart</a>

    				</div>


				</div>


		</div>
			<br>

<div class="other" style="margin-top: 35em;"><!-- div for the whole desc and reviews  padding: 0 28px; border-color: red; -->
	<div class="container" style="width: 800px; height: 400px; position: absolute;  left: 50%; transform: translate(-50%, -50%); " >
		<div class="descrev-indicator">
			<span class="btn-indicator clicked" >DESCRIPTION</span>
			<span class="btn-indicator ">REVIEWS <?php echo "(" .  mysqli_num_rows($comments) . ")"; ?></span>
		</div>
		<div class="descrev" style="height: 200%; width: 100%; overflow:hidden; transform:  translateY(-25%); ">
			<div class="slide-row" id="slide-row" style="display: flex; width:1600px; transition: 0.5s; ">
				<div class="slide-col" style="width: 800px; height: 400px; position: relative;  ">
					<div class="DESCRIPTION" style="color: black; position: absolute; ">
	                    <?php
	                        echo $item['proDesc'];
	                    ?>
	    				<br>
					</div>
				</div>

				<div class="slide-col" style="width: 800px; height: 400px; position: relative;">
					<div class="REVIEWS" style="color: black; position: absolute;">
						<?php
							while ($row =  $comments->fetch_assoc()) {
								echo "<p style='font-weight: bold; color: black;'>" . $row['usernaame'] . "</p><br>";
								echo "<blockquote>  <p>". $row['comment'] ."</p></blockquote><hr>";
							}
						?>
					</div>
				</div>


			</div>
		</div>
	</div>
</div>
		<!--  div for the whole desc and reviews-->
		<br><br><br><br><br><br><br><br><br><br>

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

		<!--bootstrap.min.js-->
        <script src="assets/js/bootstrap.min.js"></script>

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

<script>


	function logout(){
		document.getElementById('logoutForm').submit();
	}

		function addToCart(){
			document.getElementById('itemToAddInput').value = document.getElementById('currentProdName').innerHTML;
			document.getElementById('itemToAddQuantityInput').value = document.getElementById('itemToAddField').value;
			document.getElementById('addToCartForm').submit();
		}

			var btn = document.getElementsByClassName("btn-indicator");
			var slide = document.getElementById("slide-row");

			btn[0].onclick = function(){
				slide.style.transform = "translateX(0px)";
				for(i=0;i<2;i++){
					btn[i].classList.remove("clicked");
				}
				this.classList.add("clicked");
			}
			btn[1].onclick = function(){
				slide.style.transform = "translateX(-800px)";
				for(i=0;i<2;i++){
					btn[i].classList.remove("clicked");
				}
				this.classList.add("clicked");
			}
			function disableScroll() {


					window.scrollTo(0, 70);
			        window.onscroll = function() {
			            window.scrollTo(0, 70);
			        };
			}

			function enableScroll() {
			    window.onscroll = function() {};
			}

			document.getElementById('login-nav').addEventListener("click",function() {
				document.querySelector('.bg-modal').style.display = "flex";
			});

	            document.querySelector('.login-close').addEventListener("click", function() {
	                document.querySelector('.bg-modal').style.display = "none";
	            });

	            document.getElementById('show-signup').addEventListener("click",function() {
	                document.querySelector('.bg-modal').style.display = "none";
	                document.querySelector('.bg-modal-signup').style.display = "flex";

	            });

	            document.querySelector('.signup-close').addEventListener("click", function() {
	                document.querySelector('.bg-modal-signup').style.display = "none";
	            });

				var catItem = document.getElementById('category_button');
				var catDropDown = document.getElementById('category_list');
				catItem.onclick = function(){
					catDropDown.style.display = catDropDown.style.display == "block" ? "none": "block";
				}

				function selectCat(self){
					document.getElementById('selectedCat').value = self.innerHTML;
					document.getElementById('catForm').submit();
				}
				function goToMessages(){
					document.location.replace("messages.php");
				}
		</script>

    </body>

</html>

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
								  <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" aria-describedby="helpId" readonly required>
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

<script src="assets/js/validation.js"></script>
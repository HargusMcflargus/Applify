<?php
    session_start();
    session_destroy();
	$_SESSION['cart'] = array();
    header("LOCATION: ../index.php");
    die();
?>

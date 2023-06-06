<?php
    session_start();
    var_dump($_SESSION['cart'][$_POST['itemToRemove']]);
    unset($_SESSION['cart'][$_POST['itemToRemove']]);
    $_SESSION['toaster_Success'] = $_POST['itemToRemove']. " Successfully Removed";
    header("LOCATION: ../checkoutPage.php");
    die();
?>

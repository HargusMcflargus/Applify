<?php
    include_once 'dataConnector.php';
    session_start();
    if (isset($_POST['itemToAdd'])){
        if (isset($_SESSION['cart'][$_POST['itemToAdd']])) {
            $_SESSION['cart'][$_POST['itemToAdd']]['quantity'] += $_POST['itemToAddQuantity'];
        }
        else{
            $connector = new dataConnector();
            $results = array();
            $result = $connector->select("products", "prodName='" . $_POST['itemToAdd'] . "'");
            while($row = $result->fetch_assoc()){
                $results = $row;
            }
            $results['quantity'] = (int)$_POST['itemToAddQuantity'];
            $_SESSION['cart'][$_POST['itemToAdd']] = $results;
            $_SESSION['toaster_Success'] = "Successfully Added" . $_POST['itemToAdd'] . "To Cart";
        }
    }
    header("Location: ../index.php");
    die();
?>

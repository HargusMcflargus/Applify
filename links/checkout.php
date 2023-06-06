<?php
    session_start();
    include_once 'dataConnector.php';
    $data = new dataConnector();
    $total = 0;
    foreach ($_SESSION['cart'] as $key => $value) {
        $now = date_create();
        $now = date_format($now, "d-m-Y");
        $total = getPrice($value['price']) * $value['quantity'];
        $status = "Processing";
        $sql = "INSERT INTO history (product, imageLink, dateOfPurchase, quantity, customerName, total, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $statement = $data->connection->prepare($sql);
        $statement->bind_param("sssssss", $key, $value['imageLink'], $now, $value['quantity'], $_SESSION['username'], $total, $status);
        $statement->execute();

        $sql = "INSERT INTO comments VALUES (NULL, ?, ?, ?)";
        $statement = $data->connection->prepare($sql);
        $statement->bind_param("sss", $key, $_POST['comment'], $_SESSION['username']);
        $statement->execute();
    }
    $_SESSION['cart'] = array();
    $_SESSION['toaster_Success'] = "Thank you for purchasing with us, Please Come again";
    header('LOCATION: ../index.php');
    die();
?>

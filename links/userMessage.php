<?php
    session_start();
    include_once 'dataConnector.php';
    $data = new dataConnector();
    $sql = "INSERT INTO messages (link, message) VALUES (?, ?)";
    $statement = $data->connection->prepare($sql);
    $temp =   $_SESSION['username']. "-admin";
    $statement->bind_param("ss", $temp , $_POST['message']);
    $statement->execute();
    header("Location: ../messages.php");
    die();
?>

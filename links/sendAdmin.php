<?php
    Include_once 'dataConnector.php';
    session_start();
    if (isset($_POST['message'])) {
        $data = new dataConnector();
        $SQL = "INSERT INTO  messages (link, message) VALUES (?, ?)";
        $statement = $data->connection->prepare($SQL);
        $link = "admin-" . $_POST['receiver'];
        $statement->bind_param("ss", $link, $_POST['message']);
        $statement->execute();
    }
    header("LOCATION: ../adminMessage.php");
    die();
?>

<?php
    session_start();
    require "dataConnector.php";

    $connection = new dataConnector();

    $SQL = "UPDATE history SET status='". $_POST['Status'] ."' WHERE ID='". $_POST['ID'] ."'";

    $connection->connection->query($SQL);

?>
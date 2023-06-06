<?php
    include_once 'dataConnector.php';
    session_start();
    if (isset($_POST['loginCredential'])) {
        $connector =  new dataConnector();
        $result = $connector->select("user", "1");
        if ($_POST['loginCredential'] == 'admin' && $_POST['loginCredentialPass'] == "admin") {
            $_SESSION['username'] = $_POST['loginCredential'];
            header("LOCATION: ../adminControls.php");
            die();
        }
        while ($row = $result->fetch_assoc()) {
            if ($row['username'] == $_POST['loginCredential'] || $row['email'] == $_POST['loginCredential']) {
                if ($row['password'] == $_POST['loginCredentialPass']) {
                    $_SESSION['username'] = $_POST['loginCredential'];
                    break;
                }
            }
        }
    }
    if(!isset($_SESSION['username'])){
        $_SESSION['toaster_Error'] = "User Not Found";
    }
    header("LOCATION: ../index.php");
    die();
?>

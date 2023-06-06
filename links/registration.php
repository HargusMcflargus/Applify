<?php
    Include_once 'dataConnector.php';
    session_start();
    if ($_POST['confirmPassword'] == $_POST['passReg']) {
        $data = new dataConnector();
        $sql = "INSERT INTO user (email, username, password, firstname, middlename, lastname, street, zipcode, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $statement = $data->connection->prepare($sql);
        $statement->bind_param("sssssssss", $_POST['emailReg'], $_POST['userReg'], $_POST['passReg'], $_POST['firstname'], $_POST['middlename'], $_POST['lastname'], $_POST['street'], $_POST['zipcode'], $_POST['city']);
        $statement->execute();
        $_SESSION['toaster_Success'] = "User Successfully Registered";
    }else{
        $_SESSION['toaster_Error'] = "Password Do not Match";
    }
    header("LOCATION: ../index.php");
    die();
?>

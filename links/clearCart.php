<?php
    session_start();
    foreach ($_SESSION as $thing){
        unset($thing);
    }
    header("Location: ../index.php");
    die();
?>
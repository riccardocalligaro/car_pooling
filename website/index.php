<!DOCTYPE html>
<html lang="it">


<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION["type"] === 1) {
        header("location: dashboard_driver.php");
    } elseif ($_SESSION["type"] === 0) {
        header("location: dashboard_client.php");
    }
    exit;
} else {
    header("location: login.php");

}



?>

</html>
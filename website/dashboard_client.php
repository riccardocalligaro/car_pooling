<!DOCTYPE html>
<html lang="it">
<?php
include_once('base.php');

cp_head('Accedi', '');

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["type"] === 0)) {
    header("location: login.php");
    exit;
}



?>


<a href="logout.php" class="btn btn-primary w-100">Logout</a>


Dashboard driver

</html>
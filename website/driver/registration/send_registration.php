<!DOCTYPE html>
<html lang="it">

<?php
include_once('../../base.php');

cp_head('Registrazione', '../../');
?>


<?php

include_once('../../config.php');

if (isset($_POST['register'])) {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $numero_patente = $_POST['numero_patente'];
    $codice_fiscale = $_POST['codice_fiscale'];

    $insertdate = date("Y-m-d", strtotime($_POST['scadenza_patente']));
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $fotografia_url;
    if (isset($_POST['fotografia_url'])) {
        $fotografia_url = $_POST['fotografia_url'];
    }


    $password=password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO autista (nome, cognome, numero_patente, scadenza_patente, telefono, email, fotografia_url, password, codice_fiscale) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssss", $nome, $cognome, $numero_patente, $insertdate, $telefono, $email, $fotografia_url, $password, $codice_fiscale);

    $rc = $stmt->execute();
    
    if ($rc) {
        cp_success();
        header("Refresh: 1; url=../../index.php");
    } else {        
        die('execute() failed: ' . htmlspecialchars($stmt->error));
        cp_failure();
    }

    $stmt->close();


}
?>

</html>
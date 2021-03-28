<!DOCTYPE html>
<html lang="it">

<?php
include_once('../../base.php');

cp_head('Registrazione', '../');
?>


<?php

include_once('../../config.php');

if (isset($_POST['register'])) {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $documento_identita = $_POST['documento_identita'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $password=password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO passeggero (nome, cognome, documento_identita, telefono, email, password) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssss", $nome, $cognome, $documento_identita, $telefono, $email, $password);

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
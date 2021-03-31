<!DOCTYPE html>
<html lang="it">

<?php
include_once('../../base.php');

cp_head('Crea una corsa', '../');
?>

<?php

include_once('../../config.php');

session_start();

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$driver_id = $_SESSION['id'];
$targa = $_POST['automobile'];
$posti = $_POST['posti'];
$prenotazioni_aperte = 1;

$viaggio = $_POST['viaggio'];

$permissions = 0;
$money = 0;
$stato = 0;

$stmt = $conn->prepare("INSERT INTO viaggi_autisti (data_partenza, data_arrivo, autista_id, automobile_targa, prenotazioni_aperte, viaggio_id, posti_disponibili, data_creazione, stato)
VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)");

$stmt->bind_param("ssisiiii", $start_date, $end_date, $driver_id, $targa, $prenotazioni_aperte, $viaggio, $posti, $stato);
$rc = $stmt->execute();


if ($rc) {
    echo '<div class="text-center pt-5 pb-5">
    <i class="fas fa-car fa-3x"></i>
    <h1>Successo</h1>

    </div>';
    header("Refresh: 1; url=../../index.php");
} else {
    die('execute() failed: ' . htmlspecialchars($stmt->error));
    cp_failure();
}

$stmt->close();

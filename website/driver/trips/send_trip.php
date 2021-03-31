<!DOCTYPE html>
<html lang="it">

<?php
include_once('../../base.php');

cp_head('Crea un viaggio', '../');
?>

<?php

include_once('../../config.php');

session_start();

$start_city = $_POST['citta_partenza'];
$end_city = $_POST['citta_arrivo'];

$driver_id = $_SESSION['id'];
$permessi = $_POST['permessi'];
$contributo_economico = $_POST['contributo_economico'];
$tempo_stimato = $_POST['tempo_stimato'];

$stmt = $conn->prepare("INSERT INTO viaggio (citta_partenza, citta_destinazione, tipo_permessi, contributo_economico, tempo_stimato, autista_id)
VALUES (?, ?, ?, ?, ?, ?)");

$stmt->bind_param("iiiiii", $start_city, $end_city, $permessi, $contributo_economico, $tempo_stimato, $driver_id);
$rc = $stmt->execute();


if ($rc) {
    echo '<div class="text-center pt-5 pb-5">
    <i class="fas fa-car fa-3x"></i>
    <h1>Successo</h1>

    </div>';
    header("Refresh: 1; url=trips_page.php");
} else {
    die('execute() failed: ' . htmlspecialchars($stmt->error));
    cp_failure();
}

$stmt->close();


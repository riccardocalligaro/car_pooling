<!DOCTYPE html>
<html lang="it">

<!DOCTYPE html>
<html lang="it">

<?php
include_once('../../base.php');

cp_head('Annulla corsa', '../');
?>


<?php

session_start();

include_once('../../config.php');

$stmt = $conn->prepare("UPDATE viaggi_autisti SET stato = 1 WHERE id = ? AND autista_id = ?");
$stmt->bind_param("ii", $_GET['ride'], $_SESSION['id']);
$stmt->execute();

echo '<div class="text-center pt-5 pb-5">
<i class="fas fa-check fa-3x"></i>
<h1>Successo</h1>
</div>';
header("Refresh: 1; url=../../index.php");

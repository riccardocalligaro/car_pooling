<!DOCTYPE html>
<html lang="it">

<?php

session_start();

include_once('../../base.php');
include_once('../../config.php');

cp_head('Aggiugni auto', '../');
?>


<?php



$nome = $_POST['name'];
$plate = $_POST['plate'];
$autista_id = $_SESSION['id'];
$posti = $_POST['posti'];

$stmt = $conn->prepare("INSERT INTO automobile (targa, posti, autista_id, nome) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siis", $plate, $posti, $autista_id, $nome);
$rc = $stmt->execute();

if ($rc) {
    echo '<div class="text-center pt-5 pb-5">
    <i class="fas fa-car fa-3x"></i>
    <h1>Successo</h1>
    </div>';
    header("Refresh: 1; url=add_car.php");
} else {
    die('execute() failed: ' . htmlspecialchars($stmt->error));
    cp_failure();
}
$stmt->close();



?>

</html>
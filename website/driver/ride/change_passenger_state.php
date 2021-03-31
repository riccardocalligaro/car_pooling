
<!DOCTYPE html>
<html lang="it">

<!DOCTYPE html>
<html lang="it">

<?php
include_once('../../base.php');

cp_head('Cambia stato passeggero', '../');
?>


<?php

session_start();

include_once('../../config.php');

$new_state = $_GET['state'];

$stmt = $conn->prepare("UPDATE viaggi_passeggeri SET stato = ? WHERE id = ?");
$stmt->bind_param("ii", $new_state, $_GET['id']);
$stmt->execute();

if ($stmt) {
    echo '<div class="text-center pt-5 pb-5">
    <i class="fas fa-check fa-3x"></i>
    <h1>Successo</h1>
    </div>';
    header("Refresh: 1; url=passengers.php?ride={$_GET['ride']}");
}

<!DOCTYPE html>
<html lang="it">

<?php
include_once('../../base.php');

cp_head('Prenota un viaggio', '../');

session_start();

include_once('../../config.php');

$valutazione = $_POST['star'];
$name = $_POST['name'];
$comment = $_POST['comment'];
$driver_id = $_SESSION['id'];

$client_id = $_POST['client_id'];


$stmt = $conn->prepare("INSERT INTO feedback_passeggero (valutazione, recensione, passeggero_id, autista_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isii", $valutazione, $comment, $client_id, $driver_id);
$rc = $stmt->execute();


if ($rc) {
    echo '<div class="text-center pt-5 pb-5">
        <i class="fas fa-star fa-3x"></i>
        <h1>Successo</h1>
        </div>';

    header("Refresh: 2; url=../../dashboard_driver.php");
} else {
    die('execute() failed: ' . htmlspecialchars($stmt->error));
    cp_failure();
}

$stmt->close();

?>

</html>
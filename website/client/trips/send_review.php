<!DOCTYPE html>
<html lang="it">

<?php
include_once('../../base.php');

cp_head('Prenota un viaggio', '../');
?>


<?php

include_once('../../config.php');

$valutazione = $_POST['star'];
$name = $_POST['name'];
$comment = $_POST['comment'];
$driver_id = $_POST['autista_id'];

$trip_id = $_POST['trip_id'];


$stmt = $conn->prepare("INSERT INTO feedback_autista (valutazione, recensione, nome, autista_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("issi", $valutazione, $comment, $name, $driver_id);
$rc = $stmt->execute();
$stmt->close();

$stmt = $conn->prepare("UPDATE viaggi_passeggeri SET stato = 2 WHERE id = ?");
$stmt->bind_param("i", $trip_id);
$rc = $stmt->execute();


if ($rc) {
    echo '<div class="text-center pt-5 pb-5">
        <i class="fas fa-star fa-3x"></i>
        <h1>Successo</h1>
        </div>';

    header("Refresh: 2; url=trips_page.php");
} else {
    die('execute() failed: ' . htmlspecialchars($stmt->error));
    cp_failure();
}
$stmt->close();

?>

</html>
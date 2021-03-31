<!DOCTYPE html>
<html lang="it">

<?php
include_once('../../base.php');

cp_head('Prenota un viaggio', '../');
?>


<?php

include_once('../../config.php');

if (isset($_POST['buy_ride'])) {
    $trip_id = $_POST['trip_id'];
    $client_id = $_POST['client_id'];
    $indirizzo = $_POST['indirizzo'];
    $citta = $_POST['citta'];
    $numero = $_POST['numero'];
    $provincia = $_POST['provincia'];
    $cap = $_POST['cap'];
    $stato = 0;


    $stmt = $conn->prepare("INSERT INTO viaggi_passeggeri (viaggio_autista_id, passeggero_id, indirizzo, citta, numero, provincia, cap, stato, data_creazione) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    $stmt->bind_param("iisssssi", $trip_id, $client_id, $indirizzo, $citta, $numero, $provincia, $cap, $stato);

    $rc = $stmt->execute();
    
    if ($rc) {
        echo '<div class="text-center pt-5 pb-5">
            <i class="fas fa-car fa-3x"></i>
            <h1>Successo</h1>
            <p>Ti invieremo una conferma appena il driver accetterà la tua prenotazione</p>
            </div>';
        
        header("Refresh: 3; url=../../dashboard_client.php");
    } else {
        die('execute() failed: ' . htmlspecialchars($stmt->error));
        cp_failure();
    }

    $stmt->close();
}
?>

</html>
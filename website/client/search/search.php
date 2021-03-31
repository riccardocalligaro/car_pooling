<?php

include_once('../../config.php');

$start_city = $_POST['start_city'];
$destination_city = $_POST['destination_city'];
$date = $_POST['date'];



$query = "SELECT viaggi_autisti.posti_disponibili, viaggio.contributo_economico, autista.id as 'driver_id', partenza.id as 'id_partenza', destinazione.id as 'id_destinazione', viaggi_autisti.id, viaggi_autisti.data_partenza, viaggi_autisti.data_arrivo, autista.nome, autista.cognome, automobile.posti, partenza.citta_partenza, destinazione.citta_destinazione, viaggio.tempo_stimato FROM 
    (
        SELECT citta.istat as 'id', citta.comune as 'citta_partenza'
        FROM citta
        WHERE citta.comune LIKE(?)
    ) as partenza,
    (
        SELECT citta.istat as 'id', citta.comune as 'citta_destinazione'
        FROM citta
        WHERE citta.comune LIKE(?)
    ) as destinazione,
    viaggi_autisti
    INNER JOIN viaggio ON viaggi_autisti.viaggio_id = viaggio.id
    INNER JOIN autista ON viaggi_autisti.autista_id = autista.id
    INNER JOIN automobile ON viaggi_autisti.automobile_targa = automobile.targa
    WHERE viaggio.citta_partenza = partenza.id AND viaggio.citta_destinazione = destinazione.id AND viaggi_autisti.prenotazioni_aperte = true
    AND viaggi_autisti.stato = 0
    ORDER BY viaggi_autisti.data_creazione DESC
    ";

if ($date != '') {
    $query .= 'AND CAST(viaggi_autisti.data_partenza as DATE) = ?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $start_city, $destination_city, $date);

    $stmt->execute();
} else {
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $start_city, $destination_city);
    $stmt->execute();
}

if ($res = $stmt->get_result()) {
    $rows = $res->num_rows;

    if ($rows > 0) {
        while ($row = $res->fetch_assoc()) {
            echo ' <div class="card text-start mt-3 card-size">
                <div class="card-header">
                ' . $row['nome'] . ' ' . $row['cognome'] . ' 
      </div>
                <div class="card-body">
                    <h5 class="card-title">' . $row['citta_partenza'] . ' - ' . $row['citta_destinazione'] . '</h5>
                    <p class="card-text">' . $row['posti_disponibili'] . ' posti disponibili</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Data partenza: ' . date('d-m-Y H:i', strtotime($row['data_partenza'])) . '</li>
                    <li class="list-group-item">Data destinazione: ' . date('d-m-Y H:i', strtotime($row['data_arrivo'])) . '</li>
                    <li class="list-group-item">Contributo economico: ' . $row['contributo_economico'] . '€</li>
                </ul>
                <div class="card-body">
                    ';

            echo "<a href='client/trips/trip_page.php?id={$row['id']}&start={$row['id_partenza']}&end={$row['id_destinazione']}&driver={$row['driver_id']}' class='btn btn-primary'>Prenota ora</a>
                </div>
            </div>";
        }
    } else {
        echo '
            <div class="text-center">
            <h2 class="mb-2">Nessun risultato</h2>
            <img class="mt-5 responsive w-75 mx-auto" src="./assets/illustrations/To_do.svg" alt="" srcset="">
            </div>
            ';
    }
}

$stmt->close();

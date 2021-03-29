<?php

    include_once('../../config.php');

    $start_city = $_POST['start_city'];
    $destination_city = $_POST['destination_city'];
    $date = $_POST['date'];

    $query = "SELECT viaggi_autisti.data_partenza, viaggi_autisti.data_arrivo, autista.nome, autista.cognome, automobile.posti, partenza.citta_partenza, destinazione.citta_destinazione, viaggio.tempo_stimato FROM 
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
    AND CAST(viaggi_autisti.data_partenza as DATE) = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $start_city, $destination_city, $date);

    $stmt->execute();
    
   

    if ($res = $stmt->get_result()) {
        $rows = $res->num_rows;

        if ($rows > 0) {
            echo '<table class="table w-75 mx-auto">
            <thead>
                <tr>
                    <th scope="col">Città partenza</th>
                    <th scope="col">Città destinazione</th>
                    <th scope="col">Data partenza</th>
                    <th scope="col">Data arrivo</th>
                    <th scope="col">Tempo stimato</th>
                    <th scope="col">Autista</th>
                    <th scope="col">Posti automobile</th>
                    <th scope="col">Azione</th>
                </tr>
            </thead>
            <tbody>';
    
            
            while ($row = $res->fetch_assoc()) {
                echo "<tr>
                <td>{$row['citta_partenza']}</td>
                <td>{$row['citta_destinazione']}</td>
                <td>{$row['data_partenza']}</td>
                <td>{$row['data_arrivo']}</td>
                <td>{$row['tempo_stimato']}</td>
                <td>{$row['nome']} {$row['cognome']}</td>
                <td>{$row['posti']}</td>
                <td><button class='btn btn-primary w-100' id='search_btn'>Prenota</button></td>
            </tr>";
            }
    
            echo '    </tbody>
        </table>';
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

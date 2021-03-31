<!DOCTYPE html>
<html lang="it">


<?php
session_start();
include_once('../../base.php');

cp_head('I miei viaggi', '../../');
?>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">CarPooling</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../../dashboard_client.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../trips/trips_page.php">I miei viaggi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../settings/settings_page.php">Impostazioni</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php
                    include_once('../../config.php');

                    function stateText($state)
                    {
                        switch ($state) {
                            case 0:
                                return "da confermare";
                                break;
                            case 1:
                                return "confermato";
                                break;
                            case 2:
                                return "recensito";
                                break;
                            case 3:
                                return "rifiutato";
                                break;
                        }
                    }
                    $stmt = $conn->prepare("SELECT t1.comune as 'citta_partenza', t2.comune as 'citta_destinazione',
                    -- autista
                    CONCAT(autista.nome, ' ', autista.cognome) as 'autista_nominativo',
                    -- viaggio
                    viaggio.contributo_economico, viaggi_autisti.posti_disponibili, viaggi_autisti.data_partenza, viaggi_autisti.data_arrivo,
                    viaggi_passeggeri.stato, viaggi_passeggeri.id, viaggi_autisti.stato as 'stato_viaggio',
                    autista.id as 'id_autista'
                    FROM viaggi_passeggeri
                    INNER JOIN viaggi_autisti ON viaggi_autisti.id = viaggi_passeggeri.viaggio_autista_id
                    INNER JOIN autista ON viaggi_autisti.autista_id = autista.id
                    INNER JOIN viaggio ON viaggi_autisti.viaggio_id = viaggio.id
                    INNER JOIN citta t1 ON t1.istat = viaggio.citta_partenza
                    INNER JOIN citta t2 ON t2.istat = viaggio.citta_destinazione
                    WHERE viaggi_passeggeri.passeggero_id = ?
                    ORDER BY viaggi_passeggeri.data_creazione DESC
                    ");
                    $stmt->bind_param("i", $_SESSION['id']);
                    $stmt->execute();

                    if ($res = $stmt->get_result()) {
                        while ($row = $res->fetch_assoc()) {
                            echo ' <div class="card text-start mt-3 card-size">
                <div class="card-header">
                '.$row['autista_nominativo'].'
      </div>
                <div class="card-body">
                    <h5 class="card-title">'.$row['citta_partenza'].' - '.$row['citta_destinazione'].'</h5>
                    <p class="card-text">Ancora '.$row['posti_disponibili'].' posti disponibili</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Stato: '.stateText($row['stato']).'</li>
                    <li class="list-group-item">Data partenza: '.date('d-m-Y H:i', strtotime($row['data_partenza'])).'</li>
                    <li class="list-group-item">Data destinazione: '.date('d-m-Y H:i', strtotime($row['data_arrivo'])).'</li>
                    <li class="list-group-item">Contributo economico: '.$row['contributo_economico'].'€</li>
                </ul>
                    ';

                            if ($row['stato_viaggio'] === 1 && $row['stato'] === 1) {
                                echo '  <div class="card-body">
                                <a href="leave_review.php?ride='.$row['stato_viaggio'].'&driver='.$row['id_autista'].'" class="btn btn-primary">Lascia una recensione</a>
                                </div>';
                            }
                            echo '</div>';
                        }
                    }

                    ?>
    </div>
</body>

</html>
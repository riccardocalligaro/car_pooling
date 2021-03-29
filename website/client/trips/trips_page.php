<!DOCTYPE html>
<html lang="it">


<?php
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
                                return "rifiutato";
                                break;
                        }
                    }

                    $stmt = $conn->prepare("SELECT * FROM viaggi_passeggeri
                    INNER JOIN viaggi_autisti ON viaggi_autisti.viaggio_id = viaggi_passeggeri.viaggio_autista_id 
                    INNER JOIN viaggio on viaggi_autisti.viaggio_id = viaggio.id
                    INNER JOIN autista on viaggi_autisti.autista_id = autista.id
                    ");

                    $stmt->execute();

                    if ($res = $stmt->get_result()) {
                        while ($row = $res->fetch_assoc()) {
                            echo ' <div class="card text-start mt-3">
                <div class="card-header">
                '.$row['nome'].' '.$row['cognome'].' 
      </div>
                <div class="card-body">
                    <h5 class="card-title">'.$row['citta_partenza'].' - '.$row['citta_destinazione'].'</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        cards content.</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Stato: '.stateText($row['stato']).'</li>
                    <li class="list-group-item">Data partenza: '.$row['data_partenza'].'</li>
                    <li class="list-group-item">Data destinazione: '.$row['data_arrivo'].'</li>
                    <li class="list-group-item">Contributo economico: '.$row['contributo_economico'].'€</li>
                </ul>
                    ';
                        }
                    }

                    ?>
</div>
</body>

</html>
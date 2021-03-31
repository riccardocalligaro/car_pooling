<!DOCTYPE html>
<html lang="it">
<?php
include_once('base.php');

cp_head('Dashboard | Driver', '');

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["type"] === 1)) {
    header("location: login.php");
    exit;
}

include_once('config.php');
?>


<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">CarPooling</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="driver/trips/trips_page.php">I miei viaggi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="driver/settings/settings_page.php">Impostazioni</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="row mt-5 pe-2 ps-2 w-100 mx-auto">

        <!-- start left side -->
        <div class="col-lg-6 col-md-12 col-sm-12">

            <!--  start header -->
            <div class="text-center">
                <img class="mb-5 responsive" height="250px" src="./assets/illustrations/undraw_order_a_car_3tww.svg" alt="" srcset="">
                <h3 class="title mx-auto">Aggiungi una corsa</h3>
                <h5>Immetti i dati per creare una corsa e offrirla ai passeggeri</h5>
            </div>
            <!--  end header -->

            <div class="cl2 mt-5">
                <!-- start ride form -->
                <form action="driver/ride/send_ride.php" method="post" class="mx-auto">
                    <!-- start dates -->
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="inputStartDate" class="form-label">Data partenza</label>
                                <input type="datetime-local" class="form-control" id="inputStartDate" name="start_date">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="inputDestinationDate" class="form-label">Data arrivo</label>
                                <input type="datetime-local" class="form-control" id="inputDestinationDate" name="end_date">
                            </div>
                        </div>
                    </div>
                    <!-- end dates -->


                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="automobile" class="form-label">Automobile</label>
                                <select class="form-control" id="automobile" required="" name="automobile">

                                    <?php


                                    # usiamo i prepared statement (sempre mysqli) per evitare injection
                                    $stmt = $conn->prepare("SELECT * FROM automobile WHERE autista_id = ?");
                                    $stmt->bind_param("i", $_SESSION['id']);

                                    $stmt->execute();

                                    if ($res = $stmt->get_result()) {
                                        while ($row = $res->fetch_assoc()) {
                                            echo "<option>{$row['targa']}</option>";
                                        }
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="inputPostiDisponibili" class="form-label">Posti disponibili</label>
                                <input name="posti" type="number" step="1" min="1" class="form-control" id="inputPostiDisponibili" name="end_date">
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="viaggio" class="form-label">Viaggio</label>
                        <select class="form-control" id="viaggio" required="" name="viaggio">

                            <?php
                            $stmt = $conn->prepare("SELECT t1.comune as 'comune_partenza', t2.comune as 'comune_destinazione', viaggio.id FROM viaggio
                                INNER JOIN citta t1 ON t1.istat = viaggio.citta_partenza
                                INNER JOIN citta t2 ON t2.istat = viaggio.citta_destinazione
                                WHERE viaggio.autista_id = ?
                                ");
                            $stmt->bind_param("i", $_SESSION['id']);
                            # usiamo i prepared statement (sempre mysqli) per evitare injection

                            $stmt->execute();

                            if ($res = $stmt->get_result()) {
                                while ($row = $res->fetch_assoc()) {
                                    echo "<option value='{$row['id']}'>{$row['comune_partenza']} - {$row['comune_destinazione']}</option>";
                                }
                            }

                            ?>
                        </select>
                    </div>
                    <button class="btn btn-primary w-100" id="search_btn">Crea corsa</button>
                </form>
                <!-- end ride form -->
            </div>
        </div>
        <!-- end left side -->



        <div class="col-lg-6 col-md-12 col-sm-12 mb-5 card-size">
            <?php
            include_once('config.php');


            function stateText($state)
            {
                switch ($state) {
                    case 0:
                        return "in corso";
                        break;
                    case 1:
                        return "annullato";
                        break;
                    case 2:
                        return "concluso";
                        break;
                }
            }

            $stmt = $conn->prepare("SELECT t1.comune as 'comune_partenza', t2.comune as 'comune_destinazione', viaggio.*, viaggi_autisti.id as 'id_viaggio', viaggi_autisti.stato,
                    viaggi_autisti.data_partenza, viaggi_autisti.data_arrivo, viaggi_autisti.posti_disponibili  FROM viaggi_autisti
                    INNER JOIN viaggio ON viaggio.id = viaggi_autisti.viaggio_id
                    INNER JOIN citta t1 ON t1.istat = viaggio.citta_partenza
                    INNER JOIN citta t2 ON t2.istat = viaggio.citta_destinazione
                    WHERE viaggi_autisti.autista_id = ?
                    ORDER BY viaggi_autisti.data_creazione DESC
                    ");
            $stmt->bind_param("i", $_SESSION['id']);


            $stmt->execute();

            if ($res = $stmt->get_result()) {
                if ($res->num_rows == 0) {
                    echo '<img class="mt-5 responsive" src="./assets/illustrations/To_do.svg" alt="" srcset="">';
                    echo '<h2 class="text-center pt-5" style="font-size: 23px;">Non hai nessuna corsa</h2>';
                }

                while ($row = $res->fetch_assoc()) {
                    echo ' <div class="card text-start mt-3 mx-auto">
                <div class="card-body">
                    <h5 class="card-title">' . $row['comune_partenza'] . ' - ' . $row['comune_destinazione'] . '</h5>
                    <p class="card-text">' . $row['posti_disponibili'] . ' posti disponibili</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Stato: ' . stateText($row['stato']) . '</li>
                    <li class="list-group-item">Data partenza: ' . date('d-m-Y H:i', strtotime($row['data_partenza'])) . '</li>
                    <li class="list-group-item">Data destinazione: ' . date('d-m-Y H:i', strtotime($row['data_arrivo'])) . '</li>
                    <li class="list-group-item">Contributo economico: ' . $row['contributo_economico'] . '€</li>
                </ul>
                <div class="card-body">
                <a href="driver/ride/passengers.php?ride=' . $row['id_viaggio'] . '" class="btn btn-primary mb-1">Visualizza passeggeri</a>
                <a href="driver/ride/end_ride.php?ride=' . $row['id_viaggio'] . '" class="btn btn-primary mb-1">Segna come concluso</a>
                <a href="driver/ride/cancel_ride.php?ride=' . $row['id_viaggio'] . '" class="btn btn-primary mb-1">Annulla</a>
                </div>
                </div>
                    ';
                }
            }

            ?>

        </div>
    </div>

    </div>

</body>

</html>
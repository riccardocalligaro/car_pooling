<!DOCTYPE html>
<html lang="it">
<?php
include_once('../../base.php');

cp_head('Dashboard | Driver', '../../');

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["type"] === 1)) {
    header("location: login.php");
    exit;
}

include_once('../../config.php');
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
                        <a class="nav-link" aria-current="page" href="../../dashboard_driver.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="driver/trips/trips_page.php">I miei viaggi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="driver/settings/settings_page.php">Impostazioni</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <!--  start header -->
        <div class="text-center">
            <img class="mb-5" height="250px" src="../../assets/illustrations/undraw_best_place_r685.svg" alt=""
                srcset="">
            <h3 class="title mx-auto">Aggiungi una viaggio</h3>
            <h5>Crea un viaggio generico per le tue corse</h5>
        </div>
        <!--  end header -->

        <div class=" mt-5">
            <!-- start ride form -->
            <form action="driver/ride/send_ride.php" method="post" class="mx-auto">
                <!-- start dates -->
                <div class="row">
                    <div class="mb-3 col-lg-2 col-sm-12">
                        <label for="inputStart" class="form-label">Provincia</label>
                        <select class="form-control provincia-select" id="select_partenza" required="" name="provincia">
                            <?php
                            include_once('config.php');
                            # usiamo i prepared statement (sempre mysqli) per evitare injection
                            $stmt = $conn->prepare("SELECT nome_province, sigla_province FROM province");
                            $stmt->execute();
                            
                            if ($res = $stmt->get_result()) {
                                while ($row = $res->fetch_assoc()) {
                                    $data_array[] = $row;
                                }
                            }
                            echo "<option value='' disabled selected='selected'>Seleziona</option>";

                            foreach ($data_array as $data) {
                                echo "<option value='{$data['sigla_province']}'>{$data['nome_province']}</option>";
                            }

                            echo ' </select>                  
                            </div>
                            <div class="mb-3 col-lg-4 col-sm-12">
                                <label for="inputStart" class="form-label">Città di partenza</label>
                                <select class="form-control" id="citta_partenza" required="" name="citta_partenza"></select>
                            </div>

                            <div class="mb-3 col-lg-2 col-sm-12">
                            <label for="inputStart" class="form-label">Provincia</label>
                            <select class="form-control" id="select_arrivo" required="" name="provincia_arrivo">
                            ';
                            echo "<option value='' disabled selected='selected'>Seleziona</option>";

                            foreach ($data_array as $data) {
                                echo "<option value='{$data['sigla_province']}'>{$data['nome_province']}</option>";
                            }
                            echo ' </select>                  
                            </div>';
                            ?>

                            <div class="mb-3 col-lg-4">
                                <label for="citta_arrivo" class="form-label">Città di arrivo</label>
                                <select class="form-control provincia-select" id="citta_arrivo" required=""
                                    name="citta_arrivo"></select>
                            </div>
                    </div>
                </div>
                <button class="btn btn-primary w-100" id="search_btn">Crea viaggio</button>
            </form>
            <!-- end ride form -->
        </div>
        <!-- end left side -->

        <?php

                    $stmt = $conn->prepare("SELECT t1.comune as 'comune_partenza', t2.comune as 'comune_destinazione', viaggio.*, viaggi_autisti.* FROM viaggi_autisti
                    INNER JOIN viaggio ON viaggio.id = viaggi_autisti.viaggio_id
                    INNER JOIN citta t1 ON t1.istat = viaggio.citta_partenza
                    INNER JOIN citta t2 ON t2.istat = viaggio.citta_destinazione
                    WHERE viaggi_autisti.autista_id = ?
                    ORDER BY viaggi_autisti.data_creazione
                    ");
                    $stmt->bind_param("i", $_SESSION['id']);


                    $stmt->execute();

                    if ($res = $stmt->get_result()) {
                        if ($res->num_rows == 0) {
                            echo '<img class="mt-5 responsive" src="./assets/illustrations/To_do.svg" alt="" srcset="">';
                            echo '<h2 class="text-center pt-5" style="font-size: 23px;">Non hai nessuna corsa</h2>';
                        }

                        while ($row = $res->fetch_assoc()) {
                            echo ' <div class="card text-start mt-3">
                <div class="card-body">
                    <h5 class="card-title">'.$row['comune_partenza'].' - '.$row['comune_destinazione'].'</h5>
                    <p class="card-text">'.$row['posti_disponibili'].' posti disponibili</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Data partenza: '.date('d-m-Y H:i', strtotime($row['data_partenza'])).'</li>
                    <li class="list-group-item">Data destinazione: '.date('d-m-Y H:i', strtotime($row['data_arrivo'])).'</li>
                    <li class="list-group-item">Contributo economico: '.$row['contributo_economico'].'€</li>
                </ul>
                <div class="card-body">
                <a href="" class="btn btn-primary">Visualizza passeggeri</a>
                    <a href="" class="btn btn-primary">Modifica</a>
</div>
                </div>
                    ';
                        }
                    }

                    ?>

    </div>
    </div>

</body>

</html>
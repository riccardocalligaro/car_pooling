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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
            <img class="mb-5 mt-5 responsive" height="250px" src="../../assets/illustrations/undraw_best_place_r685.svg" alt="" srcset="">
            <h3 class="title mx-auto">Aggiungi una viaggio</h3>
            <h5>Crea un viaggio generico per le tue corse</h5>
        </div>
        <!--  end header -->

        <div class=" mt-5">
            <!-- start ride form -->
            <form action="send_trip.php" method="post" class="mx-auto">
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
                                <select class="form-control provincia-select" id="citta_arrivo" required="" name="citta_arrivo"></select>
                            </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="permessi" class="form-label">Permessi</label>
                            <select class="form-control custom-select provincia-select" id="permessi" required="" name="permessi">
                                <option value='0'>Permesso 1</option>";
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="contributo_economico" class="form-label">Contributo economico (euro)</label>
                            <input type="number" min="0" class="form-control" id="contributo_economico" name="contributo_economico">
                        </div>
                        <div class="col-4">
                            <label for="permessi" class="form-label">Tempo stimato (minuti)</label>
                            <input type="number" min="0" step="1" class="form-control" id="contributo_economico" name="tempo_stimato">
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary w-100" id="search_btn">Crea viaggio</button>
            </form>
            <!-- end ride form -->
        </div>
        <!-- end left side -->

        <div class="container">
            <?php

            $stmt = $conn->prepare("SELECT t1.comune as 'comune_partenza', t2.comune as 'comune_destinazione', viaggio.* FROM viaggio
INNER JOIN citta t1 ON t1.istat = viaggio.citta_partenza
INNER JOIN citta t2 ON t2.istat = viaggio.citta_destinazione
WHERE viaggio.autista_id = ?
");
            $stmt->bind_param("i", $_SESSION['id']);


            $stmt->execute();

            if ($res = $stmt->get_result()) {
                if ($res->num_rows == 0) {
                    echo '<img class="mt-5 responsive" src="./assets/illustrations/To_do.svg" alt="" srcset="">';
                    echo '<h2 class="text-center pt-5" style="font-size: 23px;">Non hai nessuna corsa</h2>';
                }

                while ($row = $res->fetch_assoc()) {
                    echo ' <div class="card text-start mt-3 card-size">
<div class="card-body">
<h5 class="card-title">' . $row['comune_partenza'] . ' - ' . $row['comune_destinazione'] . '</h5>
<p class="card-text">Tempo stimato di ' . $row['tempo_stimato'] . ' minuti</p>
</div>
<ul class="list-group list-group-flush">
<li class="list-group-item">Contributo economico: ' . $row['contributo_economico'] . '€</li>

</ul>
<div class="card-body">
<a href="" class="btn btn-primary">Elimina</a>
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
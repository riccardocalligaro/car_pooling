<!DOCTYPE html>
<html lang="it">


<?php

session_start();
include_once('../../base.php');

cp_head('Impostazioni', '../../');
?>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.php">CarPooling</a>
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
                        <a class="nav-link" href="../trips/trips_page.php">I miei viaggi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="driver/settings/settings_page.php">Impostazioni</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        <?php
                    include_once('../../config.php');

                    # usiamo i prepared statement (sempre mysqli) per evitare injection
                    $stmt = $conn->prepare("SELECT * FROM automobile WHERE autista_id=?");



                    $stmt->bind_param("i", $_SESSION["id"]);
                    $stmt->execute();

                    if ($res = $stmt->get_result()) {
                        while ($row = $res->fetch_assoc()) {
                            echo '<div class="card">
                            <ul class="list-group list-group-flush">
                              <li class="list-group-item">'.$row['targa'].' - '.$row['nome'].'</li>
                            </ul>
                          </div>';
                        }
                    }

                ?>

        <form class="mt-5" method="post" action="add_car_action.php">
            <div class="form-group">
                <label for="carName">Nome</label>
                <input type="text" class="form-control" id="carName" name="name" placeholder="">
            </div>
            <div class="form-group mt-2">
                <label for="carLicensePlate">Targa</label>
                <input type="text" class="form-control" id="carLicensePlate" placeholder="" name="plate">
            </div>
            <div class="form-group mt-2">
                <label for="carSeats">Posti</label>
                <input type="number" step="1" min="1" value="1" class="form-control" id="carSeats" placeholder="" name="posti">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Aggiungi auto</button>
        </form>

    </div>

</body>

</html>
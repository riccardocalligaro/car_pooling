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
            <a class="navbar-brand" href="../settings/settings_page.php">CarPooling</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../../dashboard_client.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../trips/trips_page.php">I miei viaggi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="client/settings/settings_page.php">Impostazioni</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card mt-3">
            <div class="card-header">
                Generale
            </div>
            <div class="card-body">

                <?php
                include_once('../../config.php');

                # usiamo i prepared statement (sempre mysqli) per evitare injection
                $stmt = $conn->prepare("SELECT * FROM passeggero WHERE id=?");



                $stmt->bind_param("i", $_SESSION["id"]);
                $stmt->execute();

                if ($res = $stmt->get_result()) {
                    while ($row = $res->fetch_assoc()) {
                        echo ' <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">Nome</label>
                                <input name="name" type="text" class="form-control" id="firstName" placeholder="" value=' . $row['nome'] . '  disabled>
                                <div class="invalid-feedback"> Valid first name is required. </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName">Cognome</label>
                                <input name="surname" type="text" class="form-control" id="lastName" placeholder="" value=' . $row['cognome'] . ' disabled>
                                <div class="invalid-feedback"> Valid last name is required. </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefono">Telefono</label>
                                <input name="name" type="text" class="form-control" id="telefono" placeholder="" value=' . $row['telefono'] . '  disabled>
                                <div class="invalid-feedback"> Valid first name is required. </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input name="surname" type="text" class="form-control" id="email" placeholder="" value=' . $row['email'] . ' disabled>
                                <div class="invalid-feedback"> Valid last name is required. </div>
                            </div>
                        </div>';
                    }
                }

                ?>

                <a href="../../logout.php" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
</body>

</html>
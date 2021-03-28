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
                        <a class="nav-link" href="../trips/trips_page.php">I miei viaggi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="client/settings/settings_page.php">Impostazioni</a>
                    </li>
                </ul>
            </div>
        </div>
</nav>
</body>
</html>
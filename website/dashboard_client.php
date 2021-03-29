<!DOCTYPE html>
<html lang="it">
<?php
include_once('base.php');

cp_head('Dashboard | Passeggero', '');

session_start();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["type"] === 0)) {
    header("location: login.php");
    exit;
}

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
                        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="client/trips/trips_page.php">I miei viaggi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="client/settings/settings_page.php">Impostazioni</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="row p-5">
        <div id="search" class="text-center">
        
        <img class="mb-5" height="250px" src="./assets/illustrations/undraw_Location_search_re_ttoj.svg" alt="" srcset="">
            <h3 class="title mx-auto">Ricerca un viaggio</h3>
            <h5>Immetti i dati di un viaggio per trovare l'orario che più ti soddisfa</h5>
            <div class="cl2 mt-5">
                <form action="#" class="mx-auto">
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-sm-12">
                            <label for="inputStart" class="form-label">Città di partenza</label>
                            <input type="text" class="form-control" id="inputStart">
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label for="inputDestination" class="form-label">Città di arrivo</label>
                            <input type="text" class="form-control" id="inputDestination">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputDate" class="form-label">Data</label>
                        <input type="date" class="form-control" id="inputDate">
                    </div>
                    <a class="btn btn-lg btn-primary w-100" id="search_btn">Ricerca</a>
                </form>
            </div>
        </div>
        <div id="results" class="d-none text-center col-lg-5 col-md-12 col-sm-12">
            <!-- <img class="mt-5 responsive w-75 mx-auto" src="./assets/illustrations/To_do.svg" alt="" srcset=""> -->
        </div>
    </div>
    </div>

</body>

</html>
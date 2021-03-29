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
                        <a class="nav-link" href="#">I miei viaggi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="client/settings/settings_page.php">Impostazioni</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="row mt-5 pe-2 ps-2">
        <div class="col-lg-6 col-md-12 col-sm-12 text-center">
            <h1 class="title">Ricerca un viaggio</h1>
            <p class="paragraph">Immetti i dati di un viaggio per trovare l'orario che più ti soddisfa</p>
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
                    <a class="btn btn-primary w-100" id="search_btn">Ricerca</a>
                </form>
            </div>
        </div>
        <div class="col">
            <!-- Se non ci sono ancora dati visualizzare l'illustrazione, se ci sono i dati visualizzare la tabella -->
            <div id="results">
                <img class="mt-5 responsive" src="./assets/illustrations/To_do.svg" alt="" srcset="">
            </div>
        </div>
    </div>

</body>
</html>
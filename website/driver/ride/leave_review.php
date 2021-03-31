<!DOCTYPE html>
<html lang="it">

<?php
session_start();

include_once('../../base.php');
include_once('../../config.php');

cp_head('Lascia una review', '../../');
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


    <!-- start content -->

    <div class="container">
        <div class="card mt-3">
            <div class="card-header">
                Lascia una review
            </div>
            <div class="card-body">
                <form action="send_review.php" method="post">
                    Valutazione
                    <div class="form-group w-25">
                        <div class="rate p-0">
                            <input type="radio" id="star5" name="star" value="5" />
                            <label for="star5" title="text"></label>
                            <input type="radio" id="star4" name="star" value="4" />
                            <label for="star4" title="text"></label>
                            <input type="radio" id="star3" name="star" value="3" />
                            <label for="star3" title="text"></label>
                            <input type="radio" id="star2" name="star" value="2" />
                            <label for="star2" title="text"></label>
                            <input type="radio" id="star1" name="star" value="1" />
                            <label for="star1" title="text"></label>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-group mt-2">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="name">


                    </div>


                    <div class="form-group mt-2">
                        <label for="description">Commento</label>
                        <textarea class="form-control" cols="50" id="description" name="comment" placeholder="Lascia un commento qui..." rows="5"></textarea>
                    </div>


                    <input class="d-none" name="client_id" value="<?php echo $_GET['id'] ?>">

                    <button type="submit" class="btn btn-primary mt-2 float-end">Invia</button>

                </form>
            </div>
        </div>
    </div>

    <!-- end content -->
</body>

</html>
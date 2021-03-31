<!DOCTYPE html>
<html lang="it">

<?php
session_start();

include_once('../../base.php');
include_once('../../config.php');

cp_head('Lascia una review', '../');
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


    <!-- start content -->

    <div class="container">
        <div class="card mt-3">
            <div class="card-header">
                Lascia una review
            </div>
            <div class="card-body">
                <form action="send_review.php" method="post">

                    <div class="form-group">
                        <label for="stars">Valutazione</label>
                        <div class="stars">
                            1 <input class="star star-5" id="star-5" type="radio" name="star" /> <label
                                class="star star-5" for="star-5"></label> <input class="star star-4" id="star-4"
                                type="radio" name="star" /> <label class="star star-4" for="star-4"></label> <input
                                class="star star-3" id="star-3" type="radio" name="star" /> <label class="star star-3"
                                for="star-3"></label> <input class="star star-2" id="star-2" type="radio" name="star" />
                            <label class="star star-2" for="star-2"></label> <input class="star star-1" id="star-1"
                                type="radio" name="star" /> <label class="star star-1" for="star-1"></label>5
                        </div>

                    </div>

                    <div class="form-group mt-2">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="name">


                    </div>


                    <div class="form-group mt-2">
                        <label for="description">Commento</label>
                        <textarea class="form-control" cols="50" id="description" name="comment"
                            placeholder="Lascia un commento qui..." rows="5"></textarea>
                    </div>


                    <input class="d-none" name="autista_id" value="<?php echo $_GET['driver'] ?>">
                    <input class="d-none" name="trip_id" value="<?php echo $_GET['ride'] ?>">

                    <button type="submit" class="btn btn-primary mt-2 float-end">Invia</button>

                </form>
            </div>
        </div>
    </div>

    <!-- end content -->
</body>

</html>
<!DOCTYPE html>
<html lang="it">

<?php
include_once('../../base.php');

cp_head('Passeggeri', '../');
?>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.php">CarPooling</a>
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
        <?php
        include_once('../../config.php');

        function stateText($state)
        {
            switch ($state) {
                case 0:
                    return "da confermare";
                    break;
                case 1:
                    return "confermato";
                    break;
                case 2:
                    return "rifiutato";
                    break;
            }
        }

        $stmt = $conn->prepare("SELECT passeggero.id as 'id_passeggero', viaggi_passeggeri.stato, passeggero.nome, passeggero.cognome,  AVG(feedback_passeggero.valutazione) as 'valutazione'

                    FROM viaggi_passeggeri
                    INNER JOIN passeggero ON passeggero.id = viaggi_passeggeri.passeggero_id
                    LEFT JOIN feedback_passeggero ON viaggi_passeggeri.passeggero_id = feedback_passeggero.passeggero_id
                    WHERE viaggi_passeggeri.viaggio_autista_id = ?
                    GROUP BY passeggero.nome, passeggero.id
                    ");
        $stmt->bind_param("i", $_GET['ride']);

        $stmt->execute();


        if ($res = $stmt->get_result()) {
            if ($res->num_rows == 0) {
                echo '<div class="text-center mt-5">
                            <h3 class="mb-2">Nessun passeggero</h3>
                            <img class="mt-5 responsive w-50 mx-auto" src="../../assets/illustrations/undraw_people_tax5.svg" alt="" srcset="">
                            </div>';
            } else {
                while ($row = $res->fetch_assoc()) {
                    $data_array[] = $row;
                }

                $non_approvati = array_filter($data_array, function ($row) {
                    return ($row['stato'] === 3);
                });

                $approvati = array_filter($data_array, function ($row) {
                    return ($row['stato'] === 1 || $row['stato'] === 2);
                });

                $da_approvare = array_filter($data_array, function ($row) {
                    return ($row['stato'] === 0);
                });



                if (count($da_approvare) > 0) {
                    echo '<div class="card w-100 mt-3" style="width: 18rem;">
                                <div class="card-header ">
                                  Da approvare
                                </div> <ul class="list-group list-group-flush">';


                    foreach ($da_approvare as $data) {
                        echo '  <li class="list-group-item">
                                    ' . $data['nome'] . ' ' . $data['cognome'] . '';

                        if (!is_null($data['valutazione'])) {
                            echo '<span class="ms-2">';
                            for ($i = 1; $i < $data['valutazione']; $i++) {
                                echo '<span><i class="text-warning fa fa-star"></i></span>';
                            }
                            echo '</span>';
                        }

                        echo '
                                    <a href="change_passenger_state.php?state=1&ride=' . $_GET['ride'] . '&id=' . $data['id_passeggero'] . '" class="btn btn-success float-end ms-2"><i class="fas fa-check"></i></a>
                                    <a href="change_passenger_state.php?state=3&ride=' . $_GET['ride'] . '&id=' . $data['id_passeggero'] . '" class="btn btn-danger float-end"><i class="fas fa-times"></i></a>
                                    </li>';
                    }

                    echo '</ul>
                                </div>';
                }


                if (count($approvati) > 0) {
                    echo '<div class="card w-100 mt-3" style="width: 18rem;">
                                <div class="card-header">
                                  Approvati
                                </div> <ul class="list-group list-group-flush">';


                    foreach ($approvati as $data) {
                        echo ' 
                                    <li class="list-group-item">' . $data['nome'] . ' ' . $data['cognome'] . '
                                    <a href="leave_review.php?id=' . $data['id_passeggero'] . '" class="btn btn-success float-end ms-2">Lascia recensione</a>
                                    </li>';
                    }

                    echo '</ul>
                                </div>';
                }


                if (count($non_approvati) > 0) {
                    echo '<div class="card w-100 mt-3" style="width: 18rem;">
                                <div class="card-header">
                                  Rifiutati
                                </div> <ul class="list-group list-group-flush">';


                    foreach ($non_approvati as $data) {
                        echo '  <li class="list-group-item">' . $data['nome'] . ' ' . $data['cognome'] . '
                                    </li>';
                    }

                    echo '</ul>
                                </div>';
                }
            }
        }






        ?>
    </div>
</body>

</html>
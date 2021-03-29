<!DOCTYPE html>
<html lang="it">


<?php
include_once('../../base.php');

session_start();

cp_head('Prenota un viaggio', '../../');
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
                        <a class="nav-link" href="../settings/settings_page.php">Impostazioni</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>


<div class="container">
    <div class="py-5 text-center">
        <i class="fas fa-shopping-cart fa-2x"></i>
        <h2>Checkout</h2>
        <p class="lead">Insersci i tuoi dati per effetuare la prenotazione.</p>
    </div>
    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Continua con la prenotazione</span>
                <span class="badge badge-secondary badge-pill">1</span>
            </h4>
            <ul class="list-group mb-3 sticky-top">
                <?php
                    include_once('../../config.php');

                    # usiamo i prepared statement (sempre mysqli) per evitare injection
                    $stmt = $conn->prepare("SELECT nome, cognome, data_partenza, partenza.citta_partenza,
                    destinazione.citta_destinazione, viaggio.contributo_economico, viaggio.tempo_stimato
                    
                    FROM (
                        SELECT citta.comune as 'citta_partenza'
                        FROM citta
                        WHERE citta.istat = ?
                    ) as partenza,
                    (
                        SELECT citta.comune as 'citta_destinazione'
                        FROM citta
                        WHERE citta.istat = ?
                    ) as destinazione,
                    viaggi_autisti 
                    INNER JOIN viaggio on viaggi_autisti.viaggio_id = viaggio.id
                    INNER JOIN autista on viaggi_autisti.autista_id = autista.id
                    WHERE viaggi_autisti.id=?");

                    # ora impostiamo i parametri, in questo caso stringa
                    $stmt->bind_param("iii", $_GET['start'], $_GET['end'], $_GET['id']);
                    $stmt->execute();

                    # ora possiamo eseguire la nostra query

                    if ($res = $stmt->get_result()) {
                        while ($row = $res->fetch_assoc()) {
                            echo '
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div><h6 class="my-0">Partenza</h6></div>
                                <span class="text-muted">'.$row['citta_partenza'].'</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div><h6 class="my-0">Destinazione</h6></div>
                                <span class="text-muted">'.$row['citta_destinazione'].'</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div><h6 class="my-0">Tempo stimato</h6></div>
                                <span class="text-muted">'.$row['tempo_stimato'].'</span>
                            </li>
                            
                            <li class="list-group-item d-flex justify-content-between">
                            <span>Totale (EURO)</span>
                            <strong>'.$row['contributo_economico'].'€</strong>
                            </li>
                            ';
                        }
                    }
                ?>


            </ul>
        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Il driver</h4>

            <?php
                    include_once('../../config.php');

                    # usiamo i prepared statement (sempre mysqli) per evitare injection
                    $stmt = $conn->prepare("SELECT * FROM autista WHERE id = ?");

                    # ora impostiamo i parametri, in questo caso stringa
                    $stmt->bind_param("i", $_GET['driver']);
                    $stmt->execute();

                    # ora possiamo eseguire la nostra query

                    if ($res = $stmt->get_result()) {
                        while ($row = $res->fetch_assoc()) {
                            echo '
                            <div class="card">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="'.(empty($row['fotografia_url']) ? 'https://image.ibb.co/jw55Ex/def_face.jpg' : $row['fotografia_url']).'" class="img img-rounded img-fluid" />
                        </div>
                        <div class="col-md-10">
                            <p><strong>'.$row['nome'].' '.$row['cognome'].'</strong>
                            </p>
                            <div class="clearfix"></div>
                            <p>'.(empty($row['biografia']) ? 'Questo driver preferisce rimanere riservato.' : $row['biografia']).'</p>
                        </div>
                    </div>
                </div>
            </div>
                            ';
                        }
                    }
                ?>




            <h4 class="mb-3 mt-3">Le review</h4>

            <?php
                    include_once('../../config.php');

                    # usiamo i prepared statement (sempre mysqli) per evitare injection
                    $stmt = $conn->prepare("SELECT * FROM feedback_autista WHERE autista_id = ?");

                    # ora impostiamo i parametri, in questo caso stringa
                    $stmt->bind_param("i", $_GET['driver']);
                    $stmt->execute();

                    # ora possiamo eseguire la nostra query

                    if ($res = $stmt->get_result()) {
                        while ($row = $res->fetch_assoc()) {
                            echo '
                            <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <p>
                                        <strong>'.$row['nome'].'</strong>';
                                        
                            for ($i=0; $i<$row['valutazione']; $i++) {
                                echo '<span class="float-end"><i class="text-warning fa fa-star"></i></span>';
                            }

                            echo '
                                    </p>
                                    <div class="clearfix"></div>
                                    <p>'.$row['recensione'].'</p>
            
                                </div>
                            </div>
                        </div>
                            ';
                        }
                    }
                ?>



            <h4 class="mb-3 mt-3">Dati personali</h4>

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
                                <input name="name" type="text" class="form-control" id="firstName" placeholder="" value='.$row['nome'].'  disabled>
                                <div class="invalid-feedback"> Valid first name is required. </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName">Cognome</label>
                                <input name="surname" type="text" class="form-control" id="lastName" placeholder="" value='.$row['cognome'].' disabled>
                                <div class="invalid-feedback"> Valid last name is required. </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefono">Telefono</label>
                                <input name="name" type="text" class="form-control" id="telefono" placeholder="" value='.$row['telefono'].'  disabled>
                                <div class="invalid-feedback"> Valid first name is required. </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input name="surname" type="text" class="form-control" id="email" placeholder="" value='.$row['email'].' disabled>
                                <div class="invalid-feedback"> Valid last name is required. </div>
                            </div>
                        </div>';
                        }
                    }

                ?>

            <form class="needs-validation" novalidate="" action="send_trip.php" method="post">
                <input name="item_id" type="hidden" value=<?php echo $_GET['id']?>>
                <h4 class="mb-3">Indirizzo per il ritiro</h4>
                <input name="trip_id" type="text" class="d-none" value="<?php echo $_GET['id']?>">
                <input name="client_id" type="text" class="d-none" value="<?php echo $_SESSION['id']?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="address">Indirizzo</label>
                        <input name="indirizzo" type="text" class="form-control" id="address" placeholder="" required="">
                        <div class="invalid-feedback"> Please enter your shipping address. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="city">Città</label>
                        <input name="citta" type="text" class="form-control" id="city" placeholder="" required=""
                            value="">
                        <div class="invalid-feedback"> Please enter your shipping address. </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="number">Numero</label>
                        <input type="text" class="form-control" id="number" placeholder="" required="" name="numero">
                        <div class="invalid-feedback"> number code required. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="state">Provincia</label>
                        <select class="custom-select d-block w-100" id="state" required="" name="provincia">

                            <?php

                            # usiamo i prepared statement (sempre mysqli) per evitare injection
                            $stmt = $conn->prepare("SELECT nome_province FROM province");
                            $stmt->execute();

                            if ($res = $stmt->get_result()) {
                                while ($row = $res->fetch_assoc()) {
                                    echo "<option>{$row['nome_province']}</option>";
                                }
                            }

                            ?>
                        </select>
                        <div class="invalid-feedback"> Please provide a valid state. </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="CAP">CAP</label>
                        <input type="text" class="form-control" id="CAP" placeholder="" required="" name="cap">
                        <div class="invalid-feedback"> Zip code required. </div>
                    </div>
                </div>

                <input name="buy_ride" type="submit" class="btn btn-primary w-100" value="Continua" />

            </form>
        </div>

</html>
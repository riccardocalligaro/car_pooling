<!DOCTYPE html>
<html lang="it">


<?php
include_once('../../base.php');

cp_head('Registrazione', '../../');
?>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="./registration.php">CarPooling</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../../client/registration/registration.php">Registrati</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../../client/login/login.php">Accedi </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="row vertical-center">
        <div class="col-sm-12 col-md-12 col-lg-6 cl1">
            <h1 class="title mx-auto mb-lg-3">Registrati come passeggero</h1>
            <p class="paragraph d-none d-md-block mx-auto">Entra nel fantastico mondo del car pooling, basta un click per prenotare un viaggio con uno dei nostri eccellenti autisti.</p>
            <img class="d-block pt-5 mx-auto responsive" height="400px" src="../../assets/illustrations/undraw_order_a_car_3tww.svg" alt="" srcset="">
        </div>
        <div class="col-lg-6 cl2">
            <form action="send_registration.php" method="POST" class="mx-auto">
                <div class="row">
                    <div class="mb-3 col-lg-6 col-sm-12">
                        <label for="inputName" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="inputName" aria-describedby="emailHelp" name="nome">
                    </div>
                    <div class="mb-3 col-lg-6">
                        <label for="inputSurname" class="form-label">Cognome</label>
                        <input type="text" class="form-control" id="inputSurname" name="cognome">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputEmail" name="email">
                </div>
                <div class="mb-3">
                    <label for="inputTel" class="form-label">Telefono</label>
                    <input type="tel" class="form-control" id="inputTel" name="telefono">
                </div>
                <div class="mb-3">
                    <label for="inputCodiceFiscale" class="form-label">Documento d'identità</label>
                    <input type="text" class="form-control" id="inputCodiceFiscale" name="documento_identita">
                </div>
                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="inputPassword" name="password">
                </div>
                <input name="register" type="submit" class="btn btn-primary w-100" value="Registrati" />
            </form>
        </div>
    </div>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<?php
include_once('../../base.php');

cp_head('Login', '../../');
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
                        <a class="nav-link" aria-current="page" href="../../client/registration/registration.php">Registrati</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../../client/login/login.php">Accedi </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="row vertical-center">
        <div class="col-sm-12 col-md-12 col-lg-6 cl1">
            <h1 class="title mx-auto mb-lg-3">Effettua l'accesso ora</h1>
            <p class=" text-center paragraph d-none d-md-block mx-auto">Entra nel mondo del car pooling, con un click prenoti un viaggio</p>
            <img class="d-block pt-5 mx-auto responsives" height="400px" src="../../assets/illustrations/undraw_Order_ride_re_372k.svg" alt="" srcset="">
        </div>
        <div class="col-lg-6 cl2 center">
            <form action="login_client.php" method="post" class="mx-auto">
                <div class="row">
                    <div class="mb-3 col-lg-6 col-sm-12">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" name="email">
                    </div>
                    <div class="mb-3 col-lg-6">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="inputPassword" name="password">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Accedi</button>

            </form>
        </div>
    </div>

</body>

</html>
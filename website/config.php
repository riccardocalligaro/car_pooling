<?php

/* 
Implementazione connessione al database
@author: Riccardo Calligaro
*/

# configurazione che ci permette di collegarsi al nostro db
# le credenziali
$db_username = "root";
$db_password = "";

# host del nostro database, in questo caso locale
$db_host = "localhost";

$db_name = "car_pooling";


# tentiamo di eseguire la connessione con la classe mysqli
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

# se la connessione non è andata a buon fine mostriamo un
# messaggio di errore
if (!$conn) {
    echo "Impossibile connettersi al database! Prova a controllare le credenziali";
    # usciamo
    exit;
}

# se la connessione è andata a buon fine possiamo usare questa connesisone
# al database per eseguire tutte le nostre query, etc...

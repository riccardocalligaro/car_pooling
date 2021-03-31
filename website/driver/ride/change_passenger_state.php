<!DOCTYPE html>
<html lang="it">

<?php

require_once("../../vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

include_once('../../base.php');

cp_head('Cambia stato passeggero', '../');



?>


<?php

session_start();

include_once('../../config.php');

$new_state = $_GET['state'];

$stmt = $conn->prepare("UPDATE viaggi_passeggeri SET stato = ? WHERE id = ?");
$stmt->bind_param("ii", $new_state, $_GET['id']);
$stmt->execute();

if ($stmt) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAuth = true;
    
    // credenziali account google
    $mail->Username = 'carpooling.zuccante@gmail.com';
    $mail->Password = 'xz8@GncZ^HPkJoK!&';
    
    
    $title = '';
    $body = '';
    
    
    // otteniamo la prenotazione effetuata
    $stmt = $conn->prepare("SELECT t1.comune as 'citta_partenza', t2.comune as 'citta_destinazione',
    -- autista
    CONCAT(autista.nome, ' ', autista.cognome) as 'autista_nominativo',
    -- viaggio
    viaggio.contributo_economico, viaggi_autisti.data_partenza, viaggi_autisti.data_arrivo,
    viaggi_passeggeri.stato, viaggi_passeggeri.id, viaggi_autisti.stato as 'stato_viaggio',
    autista.id as 'id_autista', automobile.nome as 'automobile',viaggi_passeggeri.data_creazione as 'data_creazione_viaggio',
    passeggero.email as 'email_passeggero', CONCAT(passeggero.nome, ' ', passeggero.cognome) as 'passeggero_nominativo'
    FROM viaggi_passeggeri
    INNER JOIN viaggi_autisti ON viaggi_autisti.id = viaggi_passeggeri.viaggio_autista_id
    INNER JOIN autista ON viaggi_autisti.autista_id = autista.id
    INNER JOIN automobile ON viaggi_autisti.automobile_targa = automobile.targa
    INNER JOIN viaggio ON viaggi_autisti.viaggio_id = viaggio.id
    INNER JOIN citta t1 ON t1.istat = viaggio.citta_partenza
    INNER JOIN citta t2 ON t2.istat = viaggio.citta_destinazione
    INNER JOIN passeggero ON viaggi_passeggeri.passeggero_id = passeggero.id
    WHERE viaggi_passeggeri.id = ?
    ");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    
    $mail->setFrom('carpooling.zuccante@gmail.com', 'Car Pooling');
    
    
    if ($res = $stmt->get_result()) {
        $row = $res->fetch_assoc();
    
    
        $mail->addAddress($row['email_passeggero'], $row['passeggero_nominativo']);
    
    
        if ($new_state == 1) {
            $title = 'Prenotazione confermata!';
            $body = 'La tua prenotazione effetuata in data '.date('d-m-Y', strtotime($row['data_creazione_viaggio'])).'
            è appena stata confermata.
            <br>
            Ti ricordiamo qui i dettagli:<br>
            <ul>
                <li>Città partenza: '.$row['citta_partenza'].'</li>
                <li>Città destinazione: '.$row['citta_destinazione'].'</li>
                <li>Data e ora di partenza: '.date('d-m-Y H:i', strtotime($row['data_partenza'])).'</li>
                <li>Autista: '.$row['autista_nominativo'].'</li>
                <li>Contributo economico: '.$row['contributo_economico'].'€</li>
                <li>Automobile: '.$row['automobile'].'</li>
            </ul>';
        } elseif ($new_state == 3) {
            $title = 'Prenotazione rifiutata!';
            $body = 'La tua prenotazione effetuata in data '.date('d-m-Y', strtotime($row['data_creazione_viaggio'])).'
                è appena stata rifiutata.
                <br>
                Ci dispiace molto!';
        }
    }
    
    
    $mail->Subject = $title;
    $mail->Body    = $body;
    $mail->IsHTML(true);
    
    //send the message, check for errors
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        if ($stmt) {
            echo '<div class="text-center pt-5 pb-5">
        <i class="fas fa-check fa-3x"></i>
        <h1>😄 Successo</h1>
        </div>';
            header("Refresh: 1; url=passengers.php?ride={$_GET['ride']}");
        }
    }
} else {
    echo 'Erorre';
}

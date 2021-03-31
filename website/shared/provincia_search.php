<?php

include_once('../config.php');

$provincia = $_POST['provincia'];
$stmt = $conn->prepare("SELECT citta.comune, citta.istat FROM citta WHERE provincia=?");


$stmt->bind_param("s", $provincia);
$stmt->execute();

if ($res = $stmt->get_result()) {
    while ($row = $res->fetch_assoc()) {
        echo "<option value='{$row['istat']}'>{$row['comune']}</option>";
    }
}

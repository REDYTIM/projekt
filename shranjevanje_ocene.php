<?php
session_start();
include 'baza.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_profesor = (int)$_POST['teacher'];
    $id_predmet = (int)$_POST['subject'];
    $komentar = mysqli_real_escape_string($link, $_POST['comment']);

    // Ocene
    $ocena1 = (int)$_POST['ocena_priljubljenost'];
    $ocena2 = (int)$_POST['ocena_dnaloge'];
    $ocena3 = (int)$_POST['ocena_vaje'];
    $ocena4 = (int)$_POST['ocena_razlage'];

    $skupna_ocena = ($ocena1 + $ocena2 + $ocena3 + $ocena4) / 4;

    // Če imaš uporabnika prijavljenega
    $id_uporabnika = isset($_SESSION['id']) ? (int)$_SESSION['id'] : null;

    // Pripravi in izvrši poizvedbo
    $stmt = mysqli_prepare($link, "INSERT INTO ocene (skupna_ocena, id_p, id_u, id_predmet, ocena_razlage, komentar) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "diiids", $skupna_ocena, $id_profesor, $id_uporabnika, $id_predmet, $ocena4, $komentar);
    mysqli_stmt_execute($stmt);

    // Preveri ali je vstavljanje uspelo
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("Location: ocena.php");
        exit;
    } else {
        echo "Napaka pri shranjevanju ocene: " . mysqli_error($link);
    }
}
?>

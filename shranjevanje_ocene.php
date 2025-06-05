<?php
session_start();
include 'baza.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 🔐 Preveri, ali je uporabnik prijavljen
    if (!isset($_SESSION['id'])) {
        echo "<script>alert('Za oddajo ocene se morate prijaviti.'); window.location.href = 'login.php';</script>";
        exit;
    }

    $id_uporabnika = (int)$_SESSION['id'];

    // Vhodni podatki
    $id_profesor = (int)$_POST['teacher'];
    $id_predmet = (int)$_POST['subject'];
    $komentar = mysqli_real_escape_string($link, $_POST['comment']);

    $ocena1 = (int)$_POST['ocena_priljubljenost'];
    $ocena2 = (int)$_POST['ocena_dnaloge'];
    $ocena3 = (int)$_POST['ocena_vaje'];
    $ocena4 = (int)$_POST['ocena_razlage'];

    $skupna_ocena = ($ocena1 + $ocena2 + $ocena3 + $ocena4) / 4;

    // ✅ Preveri, ali je ta uporabnik že ocenil tega učitelja
    // ✅ Preveri, ali je ta uporabnik že ocenil tega učitelja za ta predmet
$stmt_check = mysqli_prepare($link, "SELECT 1 FROM ocene WHERE id_p = ? AND id_u = ? AND id_predmet = ?");
mysqli_stmt_bind_param($stmt_check, "iii", $id_profesor, $id_uporabnika, $id_predmet);
mysqli_stmt_execute($stmt_check);
mysqli_stmt_store_result($stmt_check);

if (mysqli_stmt_num_rows($stmt_check) > 0) {
    echo "<script>alert('Tega učitelja ste že ocenili za ta predmet.'); window.location.href = 'ocena.php';</script>";
    exit;
}


    // ✅ Vstavi oceno
    $stmt_insert = mysqli_prepare($link, "
        INSERT INTO ocene (skupna_ocena, id_p, id_u, id_predmet, ocena_razlage, komentar)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    mysqli_stmt_bind_param($stmt_insert, "diiids", $skupna_ocena, $id_profesor, $id_uporabnika, $id_predmet, $ocena4, $komentar);

    if (mysqli_stmt_execute($stmt_insert)) {
        header("Location: ocena.php");
        exit;
    } else {
        echo "Napaka pri shranjevanju: " . mysqli_error($link);
    }
}
?>

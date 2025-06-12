<?php
$host = 'sql107.infinityfree.com';             // MySQL hostname iz tvojega cPanela
$user = 'if0_39049887';                        // MySQL uporabniško ime
$password = '0908007500167';                   // Geslo, ki si ga nastavil
$database = 'if0_39049887_projektna';          // Ime baze, kot je prikazano na tvoji sliki

$link = mysqli_connect($host, $user, $password, $database)
    or die("Povezava na bazo ni uspela: " . mysqli_connect_error());

mysqli_set_charset($link, "utf8");
?>

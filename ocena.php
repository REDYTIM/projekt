<?php
session_start();
include('baza.php');

// Popravljena poizvedba – temelji izključno na tabeli `ocene`
$sql = "
    SELECT 
        profesorji.ime AS ime_profesorja,
        profesorji.priimek AS priimek_profesorja,
        predmet.ime AS ime_predmeta,
        AVG(ocene.skupna_ocena) AS povprecna_ocena,
        COUNT(ocene.id) AS stevilo_ocen
    FROM ocene
    INNER JOIN profesorji ON ocene.id_p = profesorji.id
    INNER JOIN predmet ON ocene.id_predmet = predmet.id
    GROUP BY profesorji.id, predmet.id
";

$result = mysqli_query($link, $sql);
if (!$result) {
    die("Napaka v poizvedbi: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="sl">
<head>
  <meta charset="UTF-8">
  <title>Ocene učiteljev</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(to right, #667eea, #764ba2);
      padding: 100px 20px 20px 20px;
      min-height: 100%;
      color: #333;
    }

    .container {
      background-color: #fff;
      padding: 30px;
      border-radius: 15px;
      max-width: 900px;
      margin: 0 auto;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    h2 {
      text-align: center;
      margin-bottom: 24px;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 14px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #667eea;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tr:hover {
      background-color: #eef;
    }
  </style>
</head>
<body>
  <?php include 'header.html'; ?>

  <div class="container">
    <h2>Ocene učiteljev po predmetih</h2>
    <table>
      <thead>
        <tr>
          <th>Učitelj</th>
          <th>Predmet</th>
          <th>Povprečna ocena</th>
          <th>Število ocen</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= htmlspecialchars($row['ime_profesorja'] . ' ' . $row['priimek_profesorja']) ?></td>
            <td><?= htmlspecialchars($row['ime_predmeta']) ?></td>
            <td><?= number_format($row['povprecna_ocena'], 2) ?></td>
            <td><?= (int)$row['stevilo_ocen'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>

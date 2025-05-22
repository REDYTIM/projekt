<?php
include 'baza.php';

$predmeti = [];
$izbran_profesor = null;
$izbran_predmet = null;
$ocena = null;
$komentar = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $izbran_profesor = $_POST['profesor'] ?? null;

    if ($izbran_profesor) {
        // Load subjects for the selected teacher
        $stmt = mysqli_prepare($link, "SELECT predmet.id, predmet.ime 
            FROM predmet
            JOIN predmeti_profesorji ON predmet.id = predmeti_profesorji.id_predmet
            WHERE predmeti_profesorji.id_prof = ?");
        mysqli_stmt_bind_param($stmt, "i", $izbran_profesor);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $predmeti[] = $row;
        }
    }

    // If all fields are filled, forward to saving
    if (!empty($_POST['predmet']) && !empty($_POST['ocena']) && !empty($_POST['komentar'])) {
        $izbran_predmet = $_POST['predmet'];
        $ocena = $_POST['ocena'];
        $komentar = $_POST['komentar'];

        // Sanitize and insert into database
        $stmt = mysqli_prepare($link, "INSERT INTO ocene (id_profesor, id_predmet, ocena, komentar) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "iiis", $izbran_profesor, $izbran_predmet, $ocena, $komentar);
        mysqli_stmt_execute($stmt);

        echo "<script>alert('Ocena uspešno oddana!'); window.location = 'grade.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="sl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Ocenjevanje Učiteljev</title>
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
    }

    .rating-container {
      background-color: #fff;
      padding: 40px 50px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 500px;
      margin: 0 auto;
    }

    h2 {
      text-align: center;
      margin-bottom: 24px;
      color: #333;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #444;
    }

    .form-group select,
    .form-group textarea,
    .form-group input[type="number"] {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      transition: border-color 0.3s;
    }

    .form-group select:focus,
    .form-group textarea:focus,
    .form-group input:focus {
      border-color: #667eea;
      outline: none;
    }

    .form-group textarea {
      resize: vertical;
      min-height: 100px;
    }

    .buttons {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .btn {
      padding: 12px 32px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      background-color: #667eea;
      color: #fff;
      transition: background-color 0.3s;
    }

    .btn:hover {
      background-color: #5a67d8;
    }
  </style>
</head>
<body>
  <?php include 'header.html'; ?>

  <div class="rating-container">
    <h2>Ocenjevanje učiteljev</h2>

    <form method="POST">
      <div class="form-group">
        <label for="profesor">Izberite učitelja:</label>
        <select name="profesor" id="profesor" required onchange="this.form.submit()">
          <option value="">-- Izberi učitelja --</option>
          <?php
          $res = mysqli_query($link, "SELECT id, ime, priimek FROM profesorji");
          while ($row = mysqli_fetch_assoc($res)) {
              $selected = ($row['id'] == $izbran_profesor) ? 'selected' : '';
              echo "<option value='{$row['id']}' $selected>{$row['ime']} {$row['priimek']}</option>";
          }
          ?>
        </select>
      </div>

      <?php if (!empty($predmeti)) : ?>
        <div class="form-group">
          <label for="predmet">Izberite predmet:</label>
          <select name="predmet" id="predmet" required>
            <option value="">-- Izberi predmet --</option>
            <?php foreach ($predmeti as $predmet): ?>
              <option value="<?= $predmet['id'] ?>"><?= htmlspecialchars($predmet['ime']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="ocena">Ocena (1–5):</label>
          <input type="number" name="ocena" id="ocena" min="1" max="5" required />
        </div>

        <div class="form-group">
          <label for="komentar">Komentar:</label>
          <textarea name="komentar" id="komentar" placeholder="Vaše mnenje o učitelju..." required></textarea>
        </div>

        <div class="buttons">
          <button type="submit" class="btn">Oddaj oceno</button>
        </div>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>

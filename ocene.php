<?php
include 'baza.php';

$izbran_profesor = isset($_GET['teacher']) ? (int)$_GET['teacher'] : 0;
?>
<!DOCTYPE html>
<html lang="sl">
<head>
  <meta charset="UTF-8">
  <title>Ocenjevanje</title>
  <style>
    body {
      background: linear-gradient(to right, #667eea, #764ba2);
      padding: 60px 20px;
      font-family: Arial, sans-serif;
    }
    .form-group {
      margin-bottom: 15px;
    }
    textarea {
      width: 100%;
      height: 100px;
      resize: none;
    }
    select, input, textarea {
      width: 100%;
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .container {
      background: white;
      padding: 30px;
      max-width: 600px;
      margin: auto;
      border-radius: 10px;
    }
    .btn {
      background-color: #667eea;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .btn:hover {
      background-color: #5a67d8;
    }
  </style>
</head>
<body>
  <?php include 'header.html'; ?>
  <div class="container">
    <h2>Ocenite učitelja</h2>

    <!-- Učitelj izbirnik -->
    <form method="GET">
      <div class="form-group">
        <label for="teacher">Izberite učitelja:</label>
        <select name="teacher" id="teacher" required onchange="this.form.submit()">
          <option value="">-- Izberi učitelja --</option>
          <?php
            $res = mysqli_query($link, "SELECT id, ime, priimek FROM profesorji");
            while ($row = mysqli_fetch_assoc($res)) {
              $selected = ($izbran_profesor == $row['id']) ? 'selected' : '';
              echo "<option value=\"{$row['id']}\" $selected>{$row['ime']} {$row['priimek']}</option>";
            }
          ?>
        </select>
      </div>
    </form>

    <!-- Obrazec za ocenjevanje -->
    <?php if ($izbran_profesor): ?>
    <form method="POST" action="shranjevanje_ocene.php">
      <input type="hidden" name="teacher" value="<?php echo htmlspecialchars($izbran_profesor); ?>">

      <div class="form-group">
        <label for="subject">Izberite predmet:</label>
        <select name="subject" id="subject" required>
          <option value="">-- Izberi predmet --</option>
          <?php
            $query = "
              SELECT p.id AS predmet_id, p.ime AS predmet_ime
              FROM predmet p
              INNER JOIN predmeti_profesorji pp ON p.id = pp.id_predmet
              WHERE pp.id_prof = $izbran_profesor
            ";
            $res = mysqli_query($link, $query);
            while ($row = mysqli_fetch_assoc($res)) {
              echo "<option value=\"{$row['predmet_id']}\">{$row['predmet_ime']}</option>";
            }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="ocena_priljubljenost">Ocena priljubljenost (1–5):</label>
        <input type="number" name="ocena_priljubljenost" id="ocena_priljubljenost" min="1" max="5" required>
      </div>

      <div class="form-group">
        <label for="ocena_dnaloge">Ocena domače naloge (1–5):</label>
        <input type="number" name="ocena_dnaloge" id="ocena_dnaloge" min="1" max="5" required>
      </div>

      <div class="form-group">
        <label for="ocena_vaje">Ocena vaje (1–5):</label>
        <input type="number" name="ocena_vaje" id="ocena_vaje" min="1" max="5" required>
      </div>

      <div class="form-group">
        <label for="ocena_razlage">Ocena razlage (1–5):</label>
        <input type="number" name="ocena_razlage" id="ocena_razlage" min="1" max="5" required>
      </div>

      <div class="form-group">
        <label for="comment">Komentar (neobvezno):</label>
        <textarea name="comment" id="comment" placeholder="Dodajte komentar ..."></textarea>
      </div>

      <div>
        <button type="submit" class="btn">Oddaj oceno</button>
      </div>
    </form>
    <?php endif; ?>
  </div>
</body>
</html>

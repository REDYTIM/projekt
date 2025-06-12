<?php
require 'baza.php'; // Povezava z bazo

$sporocilo = '';
$preusmeritev = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['ime'], $_POST['priimek'], $_POST['email'], $_POST['geslo'])) {
        $i = mysqli_real_escape_string($link, $_POST['ime']);
        $p = mysqli_real_escape_string($link, $_POST['priimek']); // mysql real escape string zaradi varnosti pred napadalci
        $m = mysqli_real_escape_string($link, $_POST['email']);
        $g = mysqli_real_escape_string($link, $_POST['geslo']);
        $g2 = substr(sha1($g), 0, 40); 

        // Preveri, ali e-pošta že obstaja
        $checkQuery = "SELECT id FROM uporabniki WHERE email = '$m' LIMIT 1";
        $checkResult = mysqli_query($link, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $sporocilo = "E-poštni naslov je že registriran.";
        } else {
            // Vstavi novega uporabnika
            $query = "INSERT INTO uporabniki (ime, priimek, email, geslo) 
                      VALUES ('$i', '$p', '$m', '$g2')";
            $result = mysqli_query($link, $query);

            if ($result) {
                $sporocilo = "Uporabnik uspešno registriran. Preusmerjam na prijavo ...";
                $preusmeritev = true;
            } else {
                $sporocilo = "Napaka pri registraciji: " . mysqli_error($link);
            }
        }
    } else {
        $sporocilo = "Prosim, izpolnite vsa polja.";
    }
}
?>

<!DOCTYPE html>
<html lang="sl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registracija</title>
  <?php if ($preusmeritev): ?>
    <meta http-equiv="refresh" content="3;url=login.php">
  <?php endif; ?>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(to right, #667eea, #764ba2);
      display: flex; //nastavi celotno stran zato ker je body na način flex kar umogoča lažjo poravnavo otrok
      justify-content: center; //vodoravna poravnavo na sredino zto ker je display felx 
      align-items: center; //navpična poravnava na sredino isto ko pa pr prejšnji vrstici
      min-height: 100vh; //vh zaradi lažjega prilagajanja velikosti naprave
      padding: 40px;
    }

    .register-container {
      background-color: #fff;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 400px;
    }

    .register-container h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block; // element v novi vrstici zavzame celotno širino in višino ki sm mu jo nastavu 
      margin-bottom: 8px;
      font-weight: bold;
      color: #444;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      transition: border-color 0.3s;
    }

    .form-group input:focus {
      border-color: #667eea;
      outline: none;
    }

    .btn {
      width: 100%;
      padding: 12px;
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

    .back-link {
      text-align: center;
      margin-top: 20px;
    }

    .back-link a {
      color: #667eea;
      text-decoration: none;
    }

    .message {
      text-align: center;
      margin-top: 15px;
      color: #444;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Registracija</h2>
    <form method="post" action="">
      <div class="form-group">
        <label for="ime">Ime</label>
        <input type="text" id="ime" name="ime" placeholder="Vnesite ime" required>
      </div>
      <div class="form-group">
        <label for="priimek">Priimek</label>
        <input type="text" id="priimek" name="priimek" placeholder="Vnesite priimek" required>
      </div>
      <div class="form-group">
        <label for="email">Email naslov</label>
        <input type="email" id="email" name="email" placeholder="Vnesite email" required>
      </div>
      <div class="form-group">
        <label for="geslo">Geslo</label>
        <input type="password" id="geslo" name="geslo" placeholder="Vnesite geslo" required>
      </div>
      <button type="submit" class="btn">Registracija</button>
    </form>

    <?php if (!empty($sporocilo)): ?>
      <div class="message"><?= htmlspecialchars($sporocilo) ?></div>
    <?php endif; ?>

    <div class="back-link">
      <p>Že imate račun? <a href="login.php">Prijavite se</a></p>
    </div>
  </div>
</body>
</html>

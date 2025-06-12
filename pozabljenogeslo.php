<?php
include_once 'baza.php'; // povezava z bazo
$sporocilo = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = ($_POST['username']);
    $novo_geslo = ($_POST['new-password']);
    $hashirano = sha1($novo_geslo);

    $stmt = mysqli_prepare($link, "SELECT id FROM uporabniki WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $rezultat = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($rezultat) === 1) {
        $stmt2 = mysqli_prepare($link, "UPDATE uporabniki SET geslo = ? WHERE email = ?");
        mysqli_stmt_bind_param($stmt2, "ss", $hashirano, $email);
        if (mysqli_stmt_execute($stmt2)) {
            $sporocilo = "Geslo je bilo uspešno spremenjeno. Preusmerjam...";
            header("refresh:3;url=login.php");
        } else {
            $sporocilo = "Napaka pri posodabljanju gesla.";
        }
        mysqli_stmt_close($stmt2);
    } else {
        $sporocilo = "Uporabnik s tem emailom ne obstaja.";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="sl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pozabljeno geslo</title>
  <style>
    body {
      background: linear-gradient(to right, #667eea, #764ba2);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .reset-container {
      background-color: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      width: 90%;
      max-width: 400px;
    }

    .reset-container h2 {
      text-align: center;
      margin-bottom: 24px;
      color: #333;
      font-size: 24px;
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

    .form-group input {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }

    .form-group input:focus {
      border-color: #667eea;
      outline: none;
    }

    .buttons {
      margin-top: 16px;
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
    }

    .btn:hover {
      background-color: #5a67d8;
    }

    .back-link {
      text-align: center;
      margin-top: 20px;
    }

    .back-link a {
      font-size: 14px;
      color: #667eea;
      text-decoration: none;
    }

    .back-link a:hover {
      text-decoration: underline;
    }

    .message {
      text-align: center;
      color: green;
      margin-bottom: 20px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="reset-container">
    <h2>Ponastavi geslo</h2>
    <?php if (!empty($sporocilo)) echo "<div class='message'>$sporocilo</div>"; ?>
    <form method="POST" action="">
      <div class="form-group">
        <label for="username">Email</label>
        <input type="email" id="username" name="username" placeholder="Vnesite email" required />
      </div>
      <div class="form-group">
        <label for="new-password">Novo geslo</label>
        <input type="password" id="new-password" name="new-password" placeholder="Vnesite novo geslo" required />
      </div>
      <div class="buttons">
        <button type="submit" class="btn">Ponastavi geslo</button>
      </div>
      <div class="back-link">
        <p><a href="prijava.php">Nazaj na prijavo</a></p>
      </div>
    </form>
  </div>
</body>
</html>

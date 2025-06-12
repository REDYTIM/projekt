<?php
include_once 'baza.php';
include_once 'seja.php';

$napaka = '';

if (isset($_POST['sub'])) {
    
    $email = $_POST['email'];
    $geslo = $_POST['geslo'];
    $q = mysqli_query($link, "SELECT id, ime, je_admin, email, geslo FROM uporabniki WHERE email='$email'");

    if ($r = mysqli_fetch_assoc($q)) {
        if (substr(sha1($geslo), 0, 40) == $r['geslo']) {
            $_SESSION['id'] = $r['id'];
            $_SESSION['ime'] = $r['ime'];
            $_SESSION['je_admin'] = $r['je_admin'];

            $_SESSION['log'] = true;
            header("Location: ocene.php");
            exit;
        } else {
            $napaka = "Napačno geslo.";
        }
    } else {
        $napaka = "Uporabnik ne obstaja.";
    }
}
?>



<!DOCTYPE html>
<html lang="sl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Prijava</title>
  <style>
   * {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
  background: linear-gradient(to right, #667eea, #764ba2);
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
  min-height: 100vh;
}

.login-container {
  background-color: #fff;
  padding: 40px 48px;
  border-radius: 15px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  width: 100%;
  max-width: 400px;
}

.login-container h2 {
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
  font-size: 15px;
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

.forgot-password {
  text-align: left;
  margin-top: -10px;
  margin-bottom: 16px;
}

.forgot-password a {
  font-size: 13px;
  color: #667eea;
  text-decoration: none;
  transition: color 0.3s;
}

.forgot-password a:hover {
  color: #5a67d8;
  text-decoration: underline;
}

.buttons {
  display: flex;
  flex-direction: column;
  gap: 12px;
  margin-top: 16px;
}

.btn {
  padding: 12px;
  font-size: 16px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-primary {
  background-color: #667eea;
  color: #fff;
}

.btn-primary:hover {
  background-color: #5a67d8;
}

.btn-secondary {
  background-color: #e2e8f0;
  color: #333;
}

.btn-secondary:hover {
  background-color: #cbd5e0;
}

.error-message {
  color: red;
  margin-bottom: 16px;
  text-align: center;
  font-size: 14px;
}

/* 🔽 Responsive izboljšave */
@media (max-width: 768px) {
  .login-container {
    padding: 30px 24px;
    max-width: 90%;
  }

  .btn {
    font-size: 15px;
    padding: 10px;
  }
}

@media (max-width: 480px) {
  .login-container {
    padding: 20px 16px;
    border-radius: 10px;
  }

  .login-container h2 {
    font-size: 20px;
  }

  .form-group input {
    font-size: 14px;
    padding: 10px;
  }

  .btn {
    font-size: 14px;
    padding: 10px;
  }
}

  </style>
</head>
<body>
  <div class="login-container">
    <h2>Pozdravljeni</h2>
    <?php if (!empty($napaka)) echo "<div class='error-message'>$napaka</div>"; ?>
    <form method="post" action="login.php">
      <div class="form-group">
        <label for="mail">Email</label>
        <input type="email" id="email" name="email" placeholder="Vnesi email" required />
      </div>
      <div class="form-group">
        <label for="geslo">Geslo</label>
        <input type="password" id="geslo" name="geslo" placeholder="Vnesi geslo" required />
      </div>
      <div class="forgot-password">
        <a href="pozabljenogeslo.php">Pozabljeno geslo?</a>
      </div>
      <div class="buttons">
        <button type="submit" name="sub" class="btn btn-primary">Prijava</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='registracija.php'">Registracija</button>
      </div>
    </form>
  </div>
</body>
</html>
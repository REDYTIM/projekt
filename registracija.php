<!DOCTYPE html>
<html lang="sl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registracija</title>
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
  height: 100%;
  min-height: 100%; /* Določite višino na 100% */
  margin-top: 50px;
}


    .register-container {
      background-color: #fff;
      padding: 40px 50px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 400px;
    }

    .register-container h2 {
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
      font-size: 14px;
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

    .buttons {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-top: 20px;
    }

    .btn {
      padding: 12px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
      width: 100%;
    }

    .btn-primary {
      background-color: #667eea;
      color: #fff;
    }

    .btn-primary:hover {
      background-color: #5a67d8;
    }

    .back-to-login {
      text-align: center;
      margin-top: 20px;
    }

    .back-to-login a {
      font-size: 14px;
      color: #667eea;
      text-decoration: none;
      transition: color 0.3s;
    }

    .back-to-login a:hover {
      color: #5a67d8;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Ustvari račun</h2>
    <form action="up_v_bazo.php" method="post">
      <!-- Ime -->
      <div class="form-group">
        <label for="ime">Ime</label>
        <input type="text" id="ime" name="ime" placeholder="Vnesite vaše ime" required />
      </div>
      
      <!-- Priimek -->
      <div class="form-group">
        <label for="priimek">Priimek</label>
        <input type="text" id="priimek" name="priimek" placeholder="Vnesite vaš priimek" required />
      </div>
      
      <!-- Email -->
      <div class="form-group">
        <label for="email">Email naslov</label>
        <input type="email" id="email" name="email" placeholder="Vnesite vaš email" required />
      </div>
      
      <!-- Geslo -->
      <div class="form-group">
        <label for="password">Geslo</label>
        <input type="password" id="geslo" name="geslo" placeholder="Vnesite geslo" required />
      </div>
      
      <!-- Submit button -->
      <div class="buttons">
        <button type="submit" class="btn btn-primary" name="submit">Registracija</button>
      </div>
      
      <!-- Povezava do prijave -->
      <div class="back-to-login">
        <p>Že imate račun? <a href="login.php">Prijavite se</a></p>
      </div>
    </form>
  </div>
</body>
</html>
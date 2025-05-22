<?php
include_once 'baza.php';
include_once'seja.php';

if(isset($_POST['sub'])){
    $m=$_POST['email'];
    $g=$_POST['geslo'];
	$hashed_password = sha1($g);
    //echo''.$m.''.$g.'';
    $sql="SELECT * FROM uporabniki WHERE email='$m' AND geslo='$hashed_password';";
    $result=mysqli_query($link,$sql);
    if(mysqli_num_rows($result) === 1){
        $row=mysqli_fetch_array($result);
        //echo $row['ime'] . $row['priimek'];
        $_SESSION['ime']=$row['ime'];
        $_SESSION['priimek']=$row['priimek'];
        $_SESSION['id']=$row['id'];
        $_SESSION['log']= TRUE;
        echo $_SESSION['ime'] ." in " . $_SESSION['priimek'];

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
      height: 100vh;
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
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Pozdravljeni</h2>
    <?php if (!empty($napaka)) echo "<div class='error-message'>$napaka</div>"; ?>
    <form method="post" action="ocene.php">
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
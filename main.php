<?php
// Povezava z bazo, če jo potrebujete
// include_once 'baza.php'; 

// Tukaj lahko dodate kakšno sporočilo ali obvestilo, če želite
$sporocilo = ""; 
?>

<!DOCTYPE html>
<html lang="sl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elektro in računalniška šola Velenje</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header {
      background-color: #003366;
      color: #ffffff;
      padding: 20px 0;
      text-align: center;
    }

    .container {
      width: 90%;
      max-width: 1000px;
      margin: 0 auto;
      padding: 20px 0;
      flex: 1;
    }

    h1, h2 {
      color: #003366;
    }

    .intro, .notices {
      background-color: #ffffff;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 5px;
    }

    .notice {
      margin-bottom: 15px;
    }

    .notice-title {
      font-weight: bold;
      margin-bottom: 5px;
    }

    .notice-date {
      font-size: 14px;
      color: #555555;
      margin-bottom: 5px;
    }

    footer {
      background-color: #003366;
      color: #ffffff;
      text-align: center;
      padding: 10px 0;
      margin-top: auto;
    }
  </style>
</head>
<body>
  <?php include 'header.html'; ?>



  <!-- Glavna vsebina -->
  <div class="container">
    <!-- Oddelek o šoli -->
    <section class="intro">
      <h2>O šoli</h2>
      <p>Elektro in računalniška šola je ena izmed štirih srednjih šol na Šolskem centru Velenje. Izobraževanje poteka v petih izobraževalnih programih: elektrikar, elektrotehnik (PTI in SSI), tehnik računalništva in tehnik mehatronike. Pouk poteka v dopoldanskem času med 8.00 in 14.35. Pred in po pouku ponujamo dijakom krožke, ki so njihova interesna dejavnost.</p>
      <p>Izobražujemo na dveh lokacijah: splošno-izobraževalne predmete in strokovni del računalništva izvajamo na lokaciji Trg mladosti 3 (v središču Velenja), strokovne vsebine iz področja elektrotehnike in mehatronike pa izvajamo na lokaciji Koroška 62a (ob Škalskem in Velenjskem jezeru). Veliko pozornosti namenjamo dobri opremljenosti na vseh strokovnih področjih, kot tudi dobremu sodelovanju z gospodarstvom.</p>
    </section>

    <!-- Aktualna obvestila -->
    <section class="notices">
      <h2>Aktualna obvestila</h2>

      <div class="notice">
        <div class="notice-title">Vabilo na prvi e-šahovski turnir ŠCV</div>
        <div class="notice-date">7. junij 2023</div>
        <p>Vabimo vas na 1. šahovski turnir Šolskega centra Velenje, ki bo v sredo, 14. 6. 2023, ob 12.00 v računalniški učilnici C 003. Na turnir se morate prijaviti do 12. 6. 2023.</p>
      </div>

      <div class="notice">
        <div class="notice-title">Izid volitev dijakov v Svet ŠC Velenje</div>
        <div class="notice-date">Datum objave ni naveden</div>
        <p>Objavljeni so rezultati volitev dijakov v Svet Šolskega centra Velenje. Čestitamo vsem izvoljenim predstavnikom.</p>
      </div>

      <div class="notice">
        <div class="notice-title">Obvestilo dijakom zaključnih letnikov</div>
        <div class="notice-date">Datum objave ni naveden</div>
        <p>Obveščamo dijake zaključnih letnikov, da se pouk zaključuje. Preverite urnike zaključnih izpitov in oddajte vse dokumente pravočasno.</p>
      </div>
    </section>
  </div>

  <!-- Footer del -->
  <footer>
    <p>&copy; 2025 Elektro in računalniška šola Velenje</p>
  </footer>

</body>
</html>

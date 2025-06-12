<?php
session_start();
include('baza.php');

// 🔧 Prikaz napak za razvoj
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ➕ Dodaj profesorja
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dodaj_profesorja'])) {
    $ime = $_POST['ime'];
    $priimek = $_POST['priimek'];

    $stmt = mysqli_prepare($link, "INSERT INTO profesorji (ime, priimek) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $ime, $priimek);
    mysqli_stmt_execute($stmt);
}

// ➕ Poveži profesorja s predmetom
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dodaj_predmet_profesorju'])) {
    $id_prof = (int)$_POST['id_profesor'];
    $id_predmet = (int)$_POST['id_predmet'];

    mysqli_query($link, "INSERT INTO predmeti_profesorji (id_prof, id_predmet) VALUES ($id_prof, $id_predmet)");
}

// 🗑️ Briši profesorja — varno in v pravem vrstnem redu
if (isset($_GET['delete_profesor']) && is_numeric($_GET['delete_profesor'])) {
    $id = (int)$_GET['delete_profesor'];

    // Najprej izbriši ocene, kjer je ta profesor ocenjen
    mysqli_query($link, "DELETE FROM ocene WHERE id_p = $id");

    // Nato izbriši povezave profesorja s predmeti
    mysqli_query($link, "DELETE FROM predmeti_profesorji WHERE id_prof = $id");

    // Nato izbriši profesorja
    mysqli_query($link, "DELETE FROM profesorji WHERE id = $id");
}

// 🗑️ Briši oceno
if (isset($_GET['delete_ocena']) && is_numeric($_GET['delete_ocena'])) {
    $id = (int)$_GET['delete_ocena'];
    mysqli_query($link, "DELETE FROM ocene WHERE id = $id");
}

// 📥 Vsi profesorji
$profesorji = mysqli_query($link, "SELECT * FROM profesorji");

// 📥 Vsi predmeti
$predmeti = mysqli_query($link, "SELECT * FROM predmet");

// 📥 Vse ocene z imeni profesorjev, predmetov in uporabnikov
$ocene = mysqli_query($link, "
    SELECT ocene.id, ocene.skupna_ocena, profesorji.ime AS ime_prof, profesorji.priimek AS priimek_prof,
           predmet.ime AS predmet_ime, uporabniki.ime AS ime_upo, uporabniki.email
    FROM ocene
    JOIN profesorji ON ocene.id_p = profesorji.id
    JOIN predmet ON ocene.id_predmet = predmet.id
    JOIN uporabniki ON ocene.id_u = uporabniki.id
");

// 📥 Predmeti po profesorjih
$predmeti_profesorjev = [];
$res = mysqli_query($link, "
    SELECT pp.id_prof, p.ime 
    FROM predmeti_profesorji pp 
    JOIN predmet p ON pp.id_predmet = p.id
");
while ($row = mysqli_fetch_assoc($res)) {
    $predmeti_profesorjev[$row['id_prof']][] = $row['ime'];
}
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Admin nadzorna plošča</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f5f6fa;
        }

        h2 {
            margin-top: 40px;
        }

        form, table {
            background: #fff;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }

        input[type="text"], select {
            padding: 8px;
            margin-right: 10px;
        }

        button {
            padding: 8px 14px;
            background-color: #4c51bf;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        a {
            color: red;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .subjects {
            font-size: 0.9em;
            color: #555;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 18px;
            background-color: #718096;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .back-button:hover {
            background-color: #4a5568;
        }
    </style>
</head>
<body>

<!-- 🔙 Gumb za nazaj na domačo stran -->
<a href="main.php" class="back-button">← Nazaj na domačo stran</a>

<h2>Dodaj novega profesorja</h2>
<form method="post">
    <input type="text" name="ime" placeholder="Ime" required>
    <input type="text" name="priimek" placeholder="Priimek" required>
    <button type="submit" name="dodaj_profesorja">Dodaj</button>
</form>

<h2>Dodaj predmet profesorju</h2>
<form method="post">
    <select name="id_profesor" required>
        <option value="">-- Izberi profesorja --</option>
        <?php mysqli_data_seek($profesorji, 0); while($p = mysqli_fetch_assoc($profesorji)): ?>
            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['ime'] . ' ' . $p['priimek']) ?></option>
        <?php endwhile; ?>
    </select>

    <select name="id_predmet" required>
        <option value="">-- Izberi predmet --</option>
        <?php while($pred = mysqli_fetch_assoc($predmeti)): ?>
            <option value="<?= $pred['id'] ?>"><?= htmlspecialchars($pred['ime']) ?></option>
        <?php endwhile; ?>
    </select>

    <button type="submit" name="dodaj_predmet_profesorju">Poveži</button>
</form>

<h2>Seznam profesorjev</h2>
<table>
    <thead>
        <tr>
            <th>Ime</th>
            <th>Priimek</th>
            <th>Predmeti</th>
            <th>Dejanje</th>
        </tr>
    </thead>
    <tbody>
        <?php mysqli_data_seek($profesorji, 0); while($row = mysqli_fetch_assoc($profesorji)): ?>
            <tr>
                <td><?= htmlspecialchars($row['ime']) ?></td>
                <td><?= htmlspecialchars($row['priimek']) ?></td>
                <td class="subjects">
                    <?= isset($predmeti_profesorjev[$row['id']]) ? implode(', ', $predmeti_profesorjev[$row['id']]) : '–' ?>
                </td>
                <td><a href="?delete_profesor=<?= $row['id'] ?>" onclick="return confirm('Izbrisati profesorja?')">Izbriši</a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<h2>Ocene</h2>
<table>
    <thead>
        <tr>
            <th>Učitelj</th>
            <th>Predmet</th>
            <th>Ocena</th>
            <th>Uporabnik</th>
            <th>Dejanje</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($ocene)): ?>
            <tr>
                <td><?= htmlspecialchars($row['ime_prof'] . ' ' . $row['priimek_prof']) ?></td>
                <td><?= htmlspecialchars($row['predmet_ime']) ?></td>
                <td><?= $row['skupna_ocena'] ?></td>
                <td><?= htmlspecialchars($row['ime_upo']) ?> (<?= htmlspecialchars($row['email']) ?>)</td>
                <td><a href="?delete_ocena=<?= $row['id'] ?>" onclick="return confirm('Izbrisati oceno?')">Izbriši</a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>

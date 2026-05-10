<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once "../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $depart = $_POST["depart"];
    $arrivee = $_POST["arrivee"];
    $date_depart = $_POST["date_depart"];
    $date_arrivee = $_POST["date_arrivee"];
    $places_total = $_POST["places_total"];
    $user_id = $_SESSION["user_id"];

    $sql = "INSERT INTO trajets
    (depart_agence_id, arrivee_agence_id, date_depart, date_arrivee, places_total, places_disponibles, user_id)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $depart,
        $arrivee,
        $date_depart,
        $date_arrivee,
        $places_total,
        $places_total,
        $user_id
    ]);

    $message = "Trajet créé avec succès.";
}

$agences = $pdo->query("SELECT * FROM agences")->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un trajet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h1 class="mb-4">Créer un trajet</h1>

    <?php if ($message): ?>
        <div class="alert alert-success">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <label>Agence de départ</label>
            <select name="depart" class="form-control" required>
                <?php foreach ($agences as $agence): ?>
                    <option value="<?= $agence['id'] ?>">
                        <?= $agence['nom'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Agence d'arrivée</label>
            <select name="arrivee" class="form-control" required>
                <?php foreach ($agences as $agence): ?>
                    <option value="<?= $agence['id'] ?>">
                        <?= $agence['nom'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Date de départ</label>
            <input type="datetime-local" name="date_depart" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Date d'arrivée</label>
            <input type="datetime-local" name="date_arrivee" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nombre total de places</label>
            <input type="number" name="places_total" class="form-control" min="1" required>
        </div>

        <button class="btn btn-success">
            Créer le trajet
        </button>

    </form>

</div>

</body>
</html>
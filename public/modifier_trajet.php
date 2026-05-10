<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once "../config/database.php";

$id = $_GET['id'];

$message = "";

$sql = "SELECT * FROM trajets WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$trajet = $stmt->fetch();

$agences = $pdo->query("SELECT * FROM agences")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $depart = $_POST["depart"];
    $arrivee = $_POST["arrivee"];
    $date_depart = $_POST["date_depart"];
    $date_arrivee = $_POST["date_arrivee"];
    $places_total = $_POST["places_total"];
    $places_disponibles = $_POST["places_disponibles"];

    $sqlUpdate = "UPDATE trajets
    SET depart_agence_id = ?,
        arrivee_agence_id = ?,
        date_depart = ?,
        date_arrivee = ?,
        places_total = ?,
        places_disponibles = ?
    WHERE id = ?";

    $stmtUpdate = $pdo->prepare($sqlUpdate);

    $stmtUpdate->execute([
        $depart,
        $arrivee,
        $date_depart,
        $date_arrivee,
        $places_total,
        $places_disponibles,
        $id
    ]);

    $message = "Trajet modifié avec succès.";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un trajet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h1 class="mb-4">Modifier un trajet</h1>

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
                    <option value="<?= $agence['id'] ?>"
                    <?= $agence['id'] == $trajet['depart_agence_id'] ? 'selected' : '' ?>>
                        <?= $agence['nom'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Agence d'arrivée</label>
            <select name="arrivee" class="form-control" required>
                <?php foreach ($agences as $agence): ?>
                    <option value="<?= $agence['id'] ?>"
                    <?= $agence['id'] == $trajet['arrivee_agence_id'] ? 'selected' : '' ?>>
                        <?= $agence['nom'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Date de départ</label>
            <input type="datetime-local" name="date_depart" class="form-control"
            value="<?= date('Y-m-d\TH:i', strtotime($trajet['date_depart'])) ?>" required>
        </div>

        <div class="mb-3">
            <label>Date d'arrivée</label>
            <input type="datetime-local" name="date_arrivee" class="form-control"
            value="<?= date('Y-m-d\TH:i', strtotime($trajet['date_arrivee'])) ?>" required>
        </div>

        <div class="mb-3">
            <label>Nombre total de places</label>
            <input type="number" name="places_total" class="form-control"
            value="<?= $trajet['places_total'] ?>" min="1" required>
        </div>

        <div class="mb-3">
            <label>Places disponibles</label>
            <input type="number" name="places_disponibles" class="form-control"
            value="<?= $trajet['places_disponibles'] ?>" min="0" required>
        </div>

        <button class="btn btn-primary">
            Modifier le trajet
        </button>

    </form>

</div>

</body>
</html>
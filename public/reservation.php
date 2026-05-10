<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once "../config/database.php";
$id = $_GET['id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = $_POST['nom'];
    $places = $_POST['places'];
    $sqlCheck = "SELECT places_disponibles
FROM trajets
WHERE id = ?";

$stmtCheck = $pdo->prepare($sqlCheck);

$stmtCheck->execute([$id]);

$trajet = $stmtCheck->fetch();

if ($places > $trajet['places_disponibles']) {

    echo "<div class='alert alert-danger'>
        Pas assez de places disponibles.
    </div>";

    exit;
}
    $sqlUpdate = "UPDATE trajets
SET places_disponibles = places_disponibles - ?
WHERE id = ?";

$stmtUpdate = $pdo->prepare($sqlUpdate);

$stmtUpdate->execute([
    $places,
    $id
]);

    require_once "../config/database.php";


$sqlReservation = "INSERT INTO reservations
(user_id, trajet_id, nombre_places)
VALUES (?, ?, ?)";

$stmtReservation = $pdo->prepare($sqlReservation);

$stmtReservation->execute([
    $_SESSION['user_id'],
    $id,
    $places
]);

    echo "<div class='alert alert-success'>
    Réservation confirmée pour $nom.
    Votre réservation a bien été enregistrée.
</div>";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Réservation</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <h1 class="mb-4">Réserver un trajet</h1>

            <form method="POST">

                <div class="mb-3">
                    <label>Nom</label>

                    <input type="text" name="nom" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Nombre de places</label>

                    <input type="number" name="places" class="form-control" min="1" required>
                </div>

                <button class="btn btn-success">
                    Confirmer la réservation
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>
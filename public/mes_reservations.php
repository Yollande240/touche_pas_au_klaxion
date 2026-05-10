<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once "../config/database.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT
reservations.id,
reservations.nombre_places,
reservations.date_reservation,
trajets.date_depart,
trajets.date_arrivee
FROM reservations
JOIN trajets ON reservations.trajet_id = trajets.id
WHERE reservations.user_id = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([$user_id]);

$reservations = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <title>Mes réservations</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h1 class="mb-4">Mes réservations</h1>

    <?php foreach ($reservations as $reservation): ?>

        <div class="card mb-3 shadow">

            <div class="card-body">

                <p>
                    <strong>Date départ :</strong>
                    <?= $reservation['date_depart'] ?>
                </p>

                <p>
                    <strong>Date arrivée :</strong>
                    <?= $reservation['date_arrivee'] ?>
                </p>

                <p>
                    <strong>Places réservées :</strong>
                    <?= $reservation['nombre_places'] ?>
                </p>

                <p>
                    <strong>Date réservation :</strong>
                    <?= $reservation['date_reservation'] ?>
                </p>

                <a href="annuler_reservation.php?id=<?= $reservation['id'] ?>"
                class="btn btn-danger mt-3">
                    Annuler la réservation
                </a>

            </div>

        </div>

    <?php endforeach; ?>

</div>

</body>
</html>
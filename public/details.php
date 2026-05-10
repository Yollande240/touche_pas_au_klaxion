<?php

require_once "../config/database.php";

$id = $_GET['id'];

$sql = "
SELECT 
    trajets.*,
    depart.nom AS depart_nom,
    arrivee.nom AS arrivee_nom
FROM trajets
JOIN agences AS depart ON trajets.depart_agence_id = depart.id
JOIN agences AS arrivee ON trajets.arrivee_agence_id = arrivee.id
WHERE trajets.id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$trajet = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du trajet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h1>Détails du trajet</h1>

    <div class="card mt-4">
        <div class="card-body">
            <h4><?= $trajet['depart_nom'] ?> → <?= $trajet['arrivee_nom'] ?></h4>

            <p><strong>Date départ :</strong> <?= $trajet['date_depart'] ?></p>
            <p><strong>Date arrivée :</strong> <?= $trajet['date_arrivee'] ?></p>
            <p><strong>Places disponibles :</strong> <?= $trajet['places_disponibles'] ?></p>
            <p><strong>Nombre total de places :</strong> <?= $trajet['places_total'] ?></p>
            <a href="reservation.php?id=<?= $trajet['id'] ?>" class="btn btn-success">
    Réserver
</a>
            
        </div>
    </div>

</div>

</body>
</html>
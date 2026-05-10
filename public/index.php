<?php

session_start();

require_once "../config/database.php";

$departRecherche = $_GET['depart'] ?? '';
$arriveeRecherche = $_GET['arrivee'] ?? '';

$sql = "
SELECT
    trajets.*,
    depart.nom AS depart_nom,
    arrivee.nom AS arrivee_nom,
    users.prenom AS conducteur_prenom,
    users.nom AS conducteur_nom,
    users.email,
    users.telephone
FROM trajets
JOIN agences AS depart
ON trajets.depart_agence_id = depart.id
JOIN agences AS arrivee
ON trajets.arrivee_agence_id = arrivee.id
JOIN users
ON trajets.user_id = users.id
WHERE trajets.places_disponibles > 0

";

$params = [];

if (!empty($departRecherche)) {
    $sql .= " AND depart.nom LIKE ?";
    $params[] = "%" . $departRecherche . "%";
}

if (!empty($arriveeRecherche)) {
    $sql .= " AND arrivee.nom LIKE ?";
    $params[] = "%" . $arriveeRecherche . "%";
}

$sql .= " ORDER BY trajets.date_depart ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$trajets = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Touche pas au klaxon</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">

        <a class="navbar-brand" href="index.php">
            Touche pas au klaxon
        </a>

        <div>
            <a href="index.php" class="btn btn-outline-light btn-sm">
                Accueil
            </a>

            <a href="mes_reservations.php" class="btn btn-outline-light btn-sm">
                Mes réservations
            </a>

            <a href="creer_trajet.php" class="btn btn-outline-light btn-sm">
                Créer un trajet
            </a>
        </div>

        <form method="GET" class="d-flex">
            <input
                type="text"
                name="depart"
                class="form-control me-2"
                placeholder="Ville de départ"
                value="<?= $_GET['depart'] ?? '' ?>"
            >

            <input
                type="text"
                name="arrivee"
                class="form-control me-2"
                placeholder="Ville d'arrivée"
                value="<?= $_GET['arrivee'] ?? '' ?>"
            >

            <button type="submit" class="btn btn-primary">
                Rechercher
            </button>
        </form>

        <?php if (isset($_SESSION['user_id'])): ?>

            <span class="text-white me-3">
                Bonjour <?= $_SESSION['user_nom'] ?>
            </span>

            <a href="logout.php" class="btn btn-danger btn-sm">
                Déconnexion
            </a>

        <?php else: ?>

            <a href="login.php" class="btn btn-outline-light btn-sm">
                Connexion
            </a>

        <?php endif; ?>

    </div>
</nav>

<div class="container">

    <h1 class="mb-4">Liste des trajets disponibles</h1>

    <?php if (count($trajets) > 0): ?>

        <?php foreach ($trajets as $trajet): ?>

            <div class="card mb-3 shadow-sm">
                <div class="card-body">

                    <h5 class="card-title">
                        <?= $trajet['depart_nom'] ?> → <?= $trajet['arrivee_nom'] ?>
                    </h5>

                    <p>
                        <strong>Date départ :</strong>
                        <?= $trajet['date_depart'] ?>
                    </p>

                    <p>
                        <strong>Date arrivée :</strong>
                        <?= $trajet['date_arrivee'] ?>
                    </p>

                    <p>
                        <strong>Places disponibles :</strong>
                        <?= $trajet['places_disponibles'] ?>
                    </p>

                    <button
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modal<?= $trajet['id'] ?>"
                    >
                        Voir détails
                    </button>
                    <a href="reservation.php?id=<?= $trajet['id'] ?>"
   class="btn btn-success">
   Réserver
</a>
                    <div class="modal fade" id="modal<?= $trajet['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Détails du trajet
                                    </h5>

                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                    ></button>
                                </div>

                                <div class="modal-body">

                                    <p>
                                        <strong>Conducteur :</strong>
                                        <?= $trajet['conducteur_prenom'] ?>
                                        <?= $trajet['conducteur_nom'] ?>
                                    </p>

                                    <p>
                                        <strong>Email :</strong>
                                        <?= $trajet['email'] ?>
                                    </p>

                                    <p>
                                        <strong>Téléphone :</strong>
                                        <?= $trajet['telephone'] ?>
                                    </p>

                                    <p>
                                        <strong>Places totales :</strong>
                                        <?= $trajet['places_total'] ?>
                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>

                    <a href="supprimer_trajet.php?id=<?= $trajet['id'] ?>"
                       class="btn btn-danger">
                        Supprimer
                    </a>

                </div>
            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <div class="alert alert-warning">
            Aucun trajet disponible.
        </div>

    <?php endif; ?>

</div>

<footer class="bg-dark text-white text-center p-3 mt-5">
    Touche pas au klaxon © 2025
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$users = $pdo->query("SELECT * FROM users")->fetchAll();
$agences = $pdo->query("SELECT * FROM agences")->fetchAll();
$trajets = $pdo->query("SELECT * FROM trajets")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <h1 class="mb-4">Administration</h1>

    <h2>Utilisateurs</h2>

    <table class="table table-bordered bg-white">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>

        <?php foreach ($users as $user): ?>

        <tr>
    <td><?= $user['id'] ?></td>
    <td><?= $user['nom'] ?></td>
    <td><?= $user['prenom'] ?></td>
    <td><?= $user['email'] ?></td>
    <td><?= $user['role'] ?></td>

    <td>
        <a href="supprimer_user.php?id=<?= $user['id'] ?>"
           class="btn btn-danger btn-sm">
           Supprimer
        </a>
    </td>
</tr>
            
            

        <?php endforeach; ?>

    </table>

    <h2 class="mt-5">Agences</h2>
    <a href="creer_agence.php" class="btn btn-success mb-3">
    Ajouter une agence
</a>
    <table class="table table-bordered bg-white">
        <tr>
            <th>ID</th>
            <th>Nom</th>
        </tr>

        <?php foreach ($agences as $agence): ?>

          <tr>
    <td><?= $agence['id'] ?></td>
    <td><?= $agence['nom'] ?></td>  
            <td>

    <a href="modifier_agence.php?id=<?= $agence['id'] ?>"
       class="btn btn-warning btn-sm">
        Modifier
    </a>

    <a href="supprimer_agence.php?id=<?= $agence['id'] ?>"
       class="btn btn-danger btn-sm">
        Supprimer
    </a>

</td>
        </tr>     
        <?php endforeach; ?>

    </table>

    <h2 class="mt-5">Trajets</h2>

    <table class="table table-bordered bg-white">
        <tr>
            <th>ID</th>
            <th>Départ</th>
            <th>Arrivée</th>
            <th>Places</th>
        </tr>

        <?php foreach ($trajets as $trajet): ?>

        <tr>
    <td><?= $trajet['id'] ?></td>
    <td><?= $trajet['depart_agence_id'] ?></td>
    <td><?= $trajet['arrivee_agence_id'] ?></td>
    <td><?= $trajet['places_disponibles'] ?></td>

    <td>
        <a href="modifier_trajet.php?id=<?= $trajet['id'] ?>"
           class="btn btn-warning btn-sm">
           Modifier
        </a>

        <a href="supprimer_trajet.php?id=<?= $trajet['id'] ?>"
           class="btn btn-danger btn-sm">
           Supprimer
        </a>
    </td>
</tr>
            
        <?php endforeach; ?>

    </table>

</div>

</body>
</html>
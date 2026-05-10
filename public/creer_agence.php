<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = $_POST['nom'];

    $sql = "INSERT INTO agences (nom)
            VALUES (?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$nom]);

    $message = "Agence ajoutée avec succès.";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une agence</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h1 class="mb-4">Ajouter une agence</h1>

    <?php if ($message): ?>

        <div class="alert alert-success">
            <?= $message ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <label>Nom de l'agence</label>

            <input
                type="text"
                name="nom"
                class="form-control"
                required
            >
        </div>

        <button class="btn btn-success">
            Ajouter l'agence
        </button>

    </form>

</div>

</body>
</html>
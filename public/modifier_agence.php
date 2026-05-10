<?php
session_start();

require_once "../config/database.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM agences WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$agence = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST['nom'];

    $sqlUpdate = "UPDATE agences SET nom = ? WHERE id = ?";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->execute([$nom, $id]);

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une agence</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <h1>Modifier une agence</h1>

    <form method="POST">
        <div class="mb-3">
            <label>Nom de l’agence</label>
            <input type="text" name="nom" class="form-control"
                   value="<?= $agence['nom'] ?>" required>
        </div>

        <button class="btn btn-primary">
            Modifier
        </button>
    </form>
</div>

</body>
</html>
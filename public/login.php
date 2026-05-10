<?php
session_start();

require_once "../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$email]);

    $user = $stmt->fetch();

    if ($user && $password === $user['password']) {

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_nom"] = $user["nom"];
        $_SESSION["user_role"] = $user["role"];

        header("Location: index.php");
        exit;

    } else {

        $message = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card shadow">

                <div class="card-body">

                    <h2 class="mb-4 text-center">Connexion</h2>

                    <?php if ($message): ?>
                        <div class="alert alert-danger">
                            <?= $message ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label>Email</label>

                            <input type="email"
                                   name="email"
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Mot de passe</label>

                            <input type="password"
                                   name="password"
                                   class="form-control">
                        </div>

                        <button class="btn btn-primary w-100">
                            Se connecter
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
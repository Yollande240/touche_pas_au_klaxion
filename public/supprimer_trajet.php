<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once "../config/database.php";

$id = $_GET['id'];

$sql = "DELETE FROM trajets WHERE id = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([$id]);

header("Location: index.php");

exit;
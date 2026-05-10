<?php

session_start();

require_once "../config/database.php";

$reservation_id = $_GET['id'];

$sql = "SELECT * FROM reservations WHERE id = ? AND user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$reservation_id, $_SESSION['user_id']]);
$reservation = $stmt->fetch();

if ($reservation) {
    $sqlUpdate = "UPDATE trajets
    SET places_disponibles = places_disponibles + ?
    WHERE id = ?";

    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->execute([
        $reservation['nombre_places'],
        $reservation['trajet_id']
    ]);

    $sqlDelete = "DELETE FROM reservations WHERE id = ?";
    $stmtDelete = $pdo->prepare($sqlDelete);
    $stmtDelete->execute([$reservation_id]);
}

header("Location: mes_reservations.php");
exit;
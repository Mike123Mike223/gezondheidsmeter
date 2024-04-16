<?php
require_once '../includes/dbh.inc.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Controleer of de 'receive_notifications'-checkbox is aangevinkt en sla de waarde op (1 voor aangevinkt, 0 voor niet aangevinkt).
    $receiveNotifications = isset($_POST['receive_notifications']) ? 1 : 0;
    
    // De SQL-opdracht om de notificatievoorkeur van de gebruiker bij te werken in de database.
    $updateQuery = "UPDATE users SET receive_notifications = ? WHERE id = ?";
    $updateStmt = $pdo->prepare($updateQuery);
    // Voer de SQL-opdracht uit met de nieuwe value voor receive_notifications en de gebruikers-ID.
    $updateStmt->execute([$receiveNotifications, $userId]);
    
    header('Location: dashboard.php');
    exit;
}
?>

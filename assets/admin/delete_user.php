<?php
require_once '../includes/dbh.inc.php';
session_start();

if (!isset($_SESSION['user_id']) || !isAdmin($_SESSION['user_id'], $pdo)) {
    die('Je hebt geen toegang tot deze pagina!');
}


if (isset($_GET['id'])) {
    $deleteQuery = "DELETE FROM users WHERE id = ?";
    $deleteStmt = $pdo->prepare($deleteQuery);
    $deleteStmt->execute([$_GET['id']]);
}

header('Location: backend.php'); 
exit;
?>

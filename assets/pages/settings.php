<?php
require_once '../includes/dbh.inc.php';
session_start();

// Als de gebruiker niet is ingelogd, stuur hem/haar dan naar de inlogpagina.
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Bewaar de gebruikers-ID voor later gebruik.
$userId = $_SESSION['user_id'];

// Als de gebruiker op de knop heeft geklikt om gegevens te resetten, doe dat dan hier.
if (isset($_POST['reset_data'])) {
    // Dit is het SQL-commando om de antwoorden van de gebruiker te verwijderen.
    $resetQuery = "DELETE FROM user_responses WHERE user_id = ?";
    $resetStmt = $pdo->prepare($resetQuery);
    $resetStmt->execute([$userId]);
}

// Haal de huidige voorkeur voor meldingen op van de gebruiker.
$notifQuery = "SELECT receive_notifications FROM users WHERE id = ?";
$notifStmt = $pdo->prepare($notifQuery);
$notifStmt->execute([$userId]);
$userNotifPref = $notifStmt->fetch(PDO::FETCH_ASSOC)['receive_notifications'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/gezondheidsmeter/css/main.css">
    <link rel="stylesheet" href="/gezondheidsmeter/css/dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <title>Instellingen</title>
</head>
<body>
<div class="navbar">
    <div class="logo">
        <a href="dashboard.php">GEZONDHEIDSMETER</a>
    </div>
    <div class="menu">
        <a href="dashboard.php">Home</a>
    </div>
    <div class="login">
        <a href="/gezondheidsmeter/assets/includes/logout.inc.php">Logout</a>
    </div>
    <button class="hamburger" aria-label="Toggle menu" onclick="toggleMenu()">
        &#9776;
    </button>
</div>

<div class="container">
    <div class="sidebar">
        <a class="menu-button" href="dashboard.php">Dashboard</a>
        <a class="menu-button" href="statistics.php">Statistieken</a>
        <a class="menu-button" href="daily_questionnaire.php">Vragenlijst</a>
        <a class="menu-button" href="settings.php">Instellingen</a>

    </div>
    <div class="main-content">
        <h2>Notificatievoorkeuren</h2>
        <form action="update_notification_preference.php" method="POST">
            <label for="notif-toggle" style="color:white">Ontvang dagelijkse herinneringen:</label>
            <!-- In dit formulier wordt de checkbox aangevinkt als de gebruiker notificaties wil ontvangen -->
            <input type="checkbox" id="notif-toggle" name="receive_notifications" <?php if ($userNotifPref) { echo 'checked'; } ?>>
            <input type="submit" value="Voorkeur bijwerken">
        </form>

        <h2>Gegevens Resetten</h2>
        <form action="settings.php" method="POST" onsubmit="return confirm('Weet je zeker dat je alle gegevens wilt resetten? Deze actie kan niet ongedaan worden gemaakt.');">
            <input type="hidden" name="reset_data" value="1">
            <input type="submit" value="Reset Gegevens">
        </form>
        <?php if (isAdmin($userId, $pdo)): ?>
        <a href="/gezondheidsmeter/assets/admin/backend.php" class="admin-button">Admin Panel</a>
        <a href="/gezondheidsmeter/assets/admin/addquestions.php" class="admin-button">Add questions (admin only)</a>
    <?php endif; ?>
    </div>


    
</div>

<div class="footer">
  <p>©2024 Netherlands, All Rights Reserved by  <a href="https://github.com/Mike123Mike223/"> MikeKanAlles</a></p>
</div>

<script src="/gezondheidsmeter/assets/js/functions.js"></script>
</body>
</html>

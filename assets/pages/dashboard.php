<?php
require_once '../includes/dbh.inc.php'; 
require_once '../includes/functions/score_translator.php';
session_start(); 

// Controleren of de gebruiker is ingelogd, zo niet, stuur naar loginpagina
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$userId = $_SESSION['user_id']; // Gebruikers-ID opslaan voor later gebruik

// Controleren of de gebruiker vandaag de vragenlijst al heeft ingevuld
$today = date('Y-m-d'); // De huidige datum
$checkQuery = "SELECT * FROM user_responses WHERE user_id = ? AND response_date = ?";
$checkStmt = $pdo->prepare($checkQuery);
$checkStmt->execute([$userId, $today]);
$hasCompletedToday = $checkStmt->rowCount() > 0; // Controleer of er rijen zijn teruggekomen

// De gemiddelde score van de gebruiker ophalen
$query = "SELECT AVG(o.points) as overall_average FROM user_responses ur JOIN options o ON ur.option_id = o.id WHERE ur.user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$userId]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$overallScore = round($result['overall_average'], 2); // Afronden op het gemidelde 
$translatedOverallScore = translateToThreePointScale($overallScore); // Vertaal de score naar leesbare tekst

// De notificatievoorkeur van de gebruiker ophalen
$notifQuery = "SELECT receive_notifications FROM users WHERE id = ?";
$notifStmt = $pdo->prepare($notifQuery);
$notifStmt->execute([$userId]);
$userNotifPref = $notifStmt->fetch(PDO::FETCH_ASSOC)['receive_notifications']; // Opslaan of gebruiker notificaties wil

// Controleren of de gebruiker al eerder antwoorden heeft ingediend
$responseCheckQuery = "SELECT 1 FROM user_responses WHERE user_id = ?";
$responseCheckStmt = $pdo->prepare($responseCheckQuery);
$responseCheckStmt->execute([$userId]);
$hasResponses = $responseCheckStmt->rowCount() > 0; // Heeft de gebruiker al antwoorden ingediend?
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Unbounded:wght@200..900&display=swap" rel="stylesheet">
    <title>Gezondheidsmeter</title>
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
    <div class="notification-area">
        <h3> Meldingen </h3>
        <?php if ($userNotifPref): // Controleert of de gebruiker notificaties heeft ingeschakeld ?>
            <?php if (!$hasCompletedToday): // Controleert of de gebruiker de vragenlijst nog niet heeft ingevuld ?>
                <p class="reminder">Je hebt de dagelijkse vragenlijst nog niet ingevuld! <a href="/gezondheidsmeter/assets/pages/daily_questionnaire.php"><i>Klik hier om het nu in te vullen.</i></a></p>
            <?php else: // Als de vragenlijst al is ingevuld, toon een bevestigingsbericht ?>
                <p class="reminder">Goed gedaan! Je hebt vandaag de vragenlijst al ingevuld.</p>
            <?php endif; ?>
        <?php else: // Als notificaties zijn uitgeschakeld, toon dit bericht ?>
            <p class="reminder">Meldingen zijn momenteel uitgeschakeld.</p>
        <?php endif; ?>
    </div>

    <div class="healthscore_area">
    <!-- Dit is de titel van het gedeelte waar jouw algemene gezondheidsscore wordt getoond -->
    <h1>Jouw Algemene Gezondheidsscore</h1>

    <!-- Controleer of er reacties (antwoorden) zijn -->
    <?php if ($hasResponses): ?>
        <!-- Dit is de balk die je de gezondheidsscore laat zien. De kleur verandert op basis van je score. -->
        <div class="score-bar" style="background-color: <?= $translatedOverallScore['color'] === 'Rood' ? '#ff0000' : ($translatedOverallScore['color'] === 'Oranje' ? '#ffa500' : '#008000'); ?>">
            <!-- De tekst in het midden van de balk is jouw score. -->
            <p style="text-align:center;"><?= $translatedOverallScore['scale'] ?></p>
        </div>
    <?php else: ?>
        <!-- Als er geen antwoorden zijn, wordt dit bericht getoond. -->
        <p>Er is nog geen data beschikbaar. Vul de dagelijkse vragenlijst in om je score te zien.</p>
    <?php endif; ?>
</div>


</div>


<div class="footer">
  <p>©2024 Netherlands, All Rights Reserved by  <a href="https://github.com/Mike123Mike223/"> MikeKanAlles</a></p>
</div>


<script src="/gezondheidsmeter/assets/js/functions.js"></script>
</body>
</html>

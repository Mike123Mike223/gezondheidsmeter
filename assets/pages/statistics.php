<?php
require_once '../includes/dbh.inc.php';
require_once '../includes/functions/score_translator.php';
session_start();

// Controleer of de gebruiker is ingelogd, zo niet, stuur dan terug naar de loginpagina
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Opslaan van gebruikers-ID en de datum van een week geleden
$userId = $_SESSION['user_id'];
$oneWeekAgo = date('Y-m-d', strtotime("-1 week"));

// Query om de gemiddelde scores per gezondheidspijler van de afgelopen week op te halen
$weeklyQuery = "SELECT hp.name as pillar_name, AVG(o.points) as average_score
                FROM user_responses ur
                JOIN options o ON ur.option_id = o.id
                JOIN questions q ON ur.question_id = q.id
                JOIN health_pillars hp ON q.pillar_id = hp.id
                WHERE ur.user_id = ? AND ur.response_date >= ?
                GROUP BY hp.name";

$weeklyStmt = $pdo->prepare($weeklyQuery);
$weeklyStmt->execute([$userId, $oneWeekAgo]);
$weeklyScores = $weeklyStmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Gezondheidsmeter Statistieken</title>
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

<div class="main-content statistics">
    <!-- Titel voor de wekelijkse analyse van gezondheidspijlers -->
    <h1>Wekelijkse Analyse van Jouw Gezondheidspijlers</h1>
    
    <!-- Controleer of er scores beschikbaar zijn -->
    <?php if (count($weeklyScores) > 0): ?>
        <!-- Loop door elke score heen om deze op de pagina te tonen -->
        <?php foreach ($weeklyScores as $score): ?>
            <!-- Vertaal de score naar een schaal van drie punten en pas de kleur aan -->
            <?php $translatedScore = translateToThreePointScale(round($score['average_score'], 2)); ?>
            <!-- Toon de score met de bijbehorende kleur -->
            <div class="pillar-score" style="background-color: <?= $translatedScore['color'] === 'Rood' ? '#ff0000' : ($translatedScore['color'] === 'Oranje' ? '#ffa500' : '#008000'); ?>">
                <p><?= $score['pillar_name'] ?>: <?= $translatedScore['scale'] ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- Toon een bericht als er geen scores beschikbaar zijn -->
        <p>Er zijn geen gegevens beschikbaar voor de afgelopen week. Vul de vragenlijst in om je wekelijkse scores te zien.</p>
    <?php endif; ?>
</div>



<div class="footer">
  <p>©2024 Netherlands, All Rights Reserved by  <a href="https://github.com/Mike123Mike223/"> MikeKanAlles</a></p>
</div>


<script src="/gezondheidsmeter/assets/js/functions.js"></script>
</body>
</html>

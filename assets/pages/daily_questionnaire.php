<?php
// Verbind met de database en start een sessie
require_once '../includes/dbh.inc.php';
session_start();

// Als de gebruiker niet ingelogd is, laat een bericht zien
if (!isset($_SESSION['user_id'])) {
    echo '<p>Log in om de vragenlijst te bekijken.</p>';
    exit;
}

// Sla de ID van de gebruiker en de huidige datum op
$userId = $_SESSION['user_id'];
$currentDate = date('Y-m-d');

// Begin met de eerste pijler als er nog geen pijler is geselecteerd
if (!isset($_SESSION['pillarIndex'])) {
    $_SESSION['pillarIndex'] = 0;
}

// Haal de gezondheidspijlers op uit de database
$pillarQuery = "SELECT id, name FROM health_pillars ORDER BY id";
$pillarStmt = $pdo->query($pillarQuery);
$pillars = $pillarStmt->fetchAll(PDO::FETCH_ASSOC);

// Bepaal welke pijler nu getoond moet worden
$pillarIndex = $_SESSION['pillarIndex'] % count($pillars);
$currentPillar = $pillars[$pillarIndex];

// Check of de gebruiker vandaag al heeft ingevuld
$checkQuery = "SELECT * FROM user_responses WHERE user_id = ? AND response_date = ?";
$checkStmt = $pdo->prepare($checkQuery);
$checkStmt->execute([$userId, $currentDate]);
$alreadyCompleted = $checkStmt->fetch();

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
<title>Dagelijkse Vragenlijst</title>
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
            <?php
                // Als al ingevuld, laat dat weten
                if ($alreadyCompleted) {
                    echo '<p>Je hebt de vragenlijst voor vandaag al ingevuld. Kom morgen terug!</p>';
                } else {
                    // Haal de vragen op voor deze pijler
                    $questionQuery = "SELECT q.id, q.text, o.id as option_id, o.text as option_text FROM questions q JOIN options o ON q.id = o.question_id WHERE q.pillar_id = ? ORDER BY q.id";
                    $questionStmt = $pdo->prepare($questionQuery);
                    $questionStmt->execute([$currentPillar['id']]);
                    $questionsOptions = $questionStmt->fetchAll();

                    // Sorteer de vragen en opties netjes
                    $questions = [];
                    foreach ($questionsOptions as $item) {
                        $questions[$item['id']]['question_text'] = $item['text'];
                        $questions[$item['id']]['options'][$item['option_id']] = $item['option_text'];
                    } 
                    ?>

                    <h1><?= htmlspecialchars($currentPillar['name']) ?> Vragenlijst</h1>
                    <form action="submit_daily_questionnaire.php" method="POST">
                        <?php foreach ($questions as $questionId => $details): ?>
                            <div>
                                <!-- Toon de vraag en de antwoordopties -->
                                <strong><?= htmlspecialchars($details['question_text']) ?></strong><br>
                                <?php foreach ($details['options'] as $optionId => $optionText): ?>
                                    <input type='radio' name='answer_<?= $questionId ?>' value='<?= $optionId ?>'> <?= htmlspecialchars($optionText) ?><br>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>

                        <!-- Knoppen voor vorige en volgende/pijler -->
                        <?php if ($pillarIndex > 0): ?>
                            <input type='submit' name='previous' value='Vorige'>
                        <?php endif; ?>
                        <?php if ($pillarIndex < count($pillars) - 1): ?>
                            <input type='submit' name='next' value='Volgende'>
                        <?php else: ?>
                            <input type='submit' name='submit' value='Indienen'>
                        <?php endif; ?>
                    </form>
    </div>
</body>
</html>
<?php
} 
?>

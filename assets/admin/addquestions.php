<?php
require_once '../includes/dbh.inc.php';
session_start();

// Controleer of de gebruiker is ingelogd en of het een admin is
if (!isset($_SESSION['user_id']) || !isAdmin($_SESSION['user_id'], $pdo)) {
    die('Je hebt geen toegang tot deze pagina!');
}

// Verwerk het formulier wanneer het wordt ingediend
if (isset($_POST['submit_question'])) {
    $question = $_POST['question'];
    $pillarId = $_POST['pillar'];
    $options = $_POST['options']; // Array van opties
    $points = $_POST['points']; // Array van punten

    // Voeg de vraag in
    $questionInsertQuery = "INSERT INTO questions (pillar_id, text) VALUES (?, ?)";
    $stmt = $pdo->prepare($questionInsertQuery);
    $stmt->execute([$pillarId, $question]);
    $questionId = $pdo->lastInsertId();

    // Voeg de opties in
    foreach ($options as $index => $text) {
        if (!empty($text)) {
            $optionPoint = isset($points[$index]) ? $points[$index] : 0;
            $optionsInsertQuery = "INSERT INTO options (question_id, text, points) VALUES (?, ?, ?)";
            $optionStmt = $pdo->prepare($optionsInsertQuery);
            $optionStmt->execute([$questionId, $text, $optionPoint]);
        }
    }

    header('Location: backend.php'); // Pas de redirect aan naar de juiste locatie
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/gezondheidsmeter/css/main.css">
    <link rel="stylesheet" href="/gezondheidsmeter/css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <title>Vraag Toevoegen</title>
</head>
<body>
<div class="navbar">
    <div class="logo">
        <a href="dashboard.php">GEZONDHEIDSMETER</a>
    </div>
    <div class="menu">
        <a href="/gezondheidsmeter/assets/pages/dashboard.php">Home</a>
    </div>
    <div class="login">
        <a href="/gezondheidsmeter/assets/includes/logout.inc.php">Logout</a>
    </div>
    <button class="hamburger" aria-label="Toggle menu" onclick="toggleMenu()">
        &#9776;
    </button>
</div>

<div class="question-form">
    <h2>Voeg een nieuwe vraag toe</h2>
    <form action="addquestions.php" method="post">
        <label for="question">Vraag:</label>
        <input type="text" id="question" name="question" required>

        <label for="pillar">Gezondheidspilaar:</label>
        <select id="pillar" name="pillar" required>
            <?php
            $pillarQuery = "SELECT id, name FROM health_pillars";
            $pillarStmt = $pdo->query($pillarQuery);
            while ($pillar = $pillarStmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $pillar['id'] . "'>" . htmlspecialchars($pillar['name']) . "</option>";
            }
            ?>
        </select>

        <!-- Optie 1 -->
        <label for="option1">Optie 1:</label>
        <input type="text" id="option1" name="options[]" style="width: 70%;" required> 
        <label for="points1">Punten:</label>
        <input type="number" id="points1" name="points[]" style="width: 10%;" required><br>

        <!-- Optie 2 -->
        <label for="option2">Optie 2:</label>
        <input type="text" id="option2" name="options[]" style="width: 70%;"> 
        <label for="points2">Punten:</label>
        <input type="number" id="points2" name="points[]" style="width: 10%;"><br>

        <!-- Optie 3 -->
        <label for="option3">Optie 3:</label>
        <input type="text" id="option3" name="options[]" style="width: 70%;" > 
        <label for="points3">Punten:</label>
        <input type="number" id="points3" name="points[]" style="width: 10%;"><br>

        <!-- Optie 4 -->
        <label for="option4">Optie 4:</label>
        <input type="text" id="option4" name="options[]" style="width: 70%;"> 
        <label for="points4">Punten:</label>
        <input type="number" id="points4" name="points[]" style="width: 10%;" ><br>

        <input type="submit" name="submit_question" value="Voeg toe">
    </form>
</div>

<script src="/gezondheidsmeter/assets/js/functions.js"></script>
</body>
</html>

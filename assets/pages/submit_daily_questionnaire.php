<?php
require_once '../includes/dbh.inc.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$date = date('Y-m-d');

if (!isset($_SESSION['answers'])) {
    $_SESSION['answers'] = [];
}

// Verwerk de "next" en "previous" knoppen en sla de antwoorden op in de sessie.
if (isset($_POST['next']) || isset($_POST['previous'])) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'answer_') === 0) {
            $_SESSION['answers'][$key] = $value;
        }
    }
    
    if (isset($_POST['next'])) {
        $_SESSION['pillarIndex']++;
    } elseif (isset($_POST['previous'])) {
        $_SESSION['pillarIndex'] = max(0, $_SESSION['pillarIndex'] - 1);
    }

    header('Location: daily_questionnaire.php');
    exit;
}

// Verwerk het indienen van de vragenlijst
if (isset($_POST['submit'])) {
    foreach ($_SESSION['answers'] as $key => $value) {
        $questionId = str_replace('answer_', '', $key);
        $optionId = filter_var($value, FILTER_SANITIZE_NUMBER_INT);

        $insertQuery = "INSERT INTO user_responses (user_id, question_id, option_id, response_date) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->execute([$userId, $questionId, $optionId, $date]);
    }

    // Verwijder de opgeslagen antwoorden uit de sessie
    unset($_SESSION['answers']);
    unset($_SESSION['pillarIndex']);

    header('Location: daily_questionnaire.php?submitted=true');
    exit;
}

// Standaard omleiding terug naar de vragenlijst als geen van bovenstaande condities waar is
header('Location: daily_questionnaire.php');
exit;
?>

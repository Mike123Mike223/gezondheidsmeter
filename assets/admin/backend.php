<?php
require_once '../includes/dbh.inc.php';
session_start();

// Als de gebruiker niet is ingelogd, stuur hem/haar dan naar de inlogpagina.
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if (!isset($_SESSION['user_id']) || !isAdmin($_SESSION['user_id'], $pdo)) {
    die('Je hebt geen toegang tot deze pagina!');
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
    <a href="/gezondheidsmeter/assets/pages/dashboard.php">Home</a>
    </div>
    <div class="login">
        <a href="/gezondheidsmeter/assets/includes/logout.inc.php">Logout</a>
    </div>
    <button class="hamburger" aria-label="Toggle menu" onclick="toggleMenu()">
        &#9776;
    </button>
</div>

<div class="user-management">
    <h2>Gebruikersbeheer</h2>
    <table>
        <thead>
            <tr>
                <th>Gebruikersnaam</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $userQuery = "SELECT id, username FROM users";
            $userStmt = $pdo->query($userQuery);
            while ($user = $userStmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                echo "<td>";
                echo "<a href='edit_user.php?id=" . $user['id'] . "'>Bewerk</a> | ";
                echo "<a href='delete_user.php?id=" . $user['id'] . "' onclick='return confirm(\"Weet je zeker dat je deze gebruiker wilt verwijderen?\");'>Verwijder</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>


<div class="footer">
  <p>©2024 Netherlands, All Rights Reserved by  <a href="https://github.com/Mike123Mike223/"> MikeKanAlles</a></p>
</div>

<script src="/gezondheidsmeter/assets/js/functions.js"></script>
</body>
</html>

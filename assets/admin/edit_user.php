<?php
require_once '../includes/dbh.inc.php';
session_start();

if (!isset($_SESSION['user_id']) || !isAdmin($_SESSION['user_id'], $pdo)) {
    die('Je hebt geen toegang tot deze pagina!');
}

// Controleer of er een gebruiker-ID is opgegeven in de URL.
if (!isset($_GET['id'])) {
    header('Location: backend.php'); // Geen ID, terug naar de admin-pagina.
    exit;
}

$userId = $_GET['id'];

// Als het formulier is ingediend, werk dan de gebruikersgegevens bij.
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $updateQuery = "UPDATE users SET username = ? WHERE id = ?";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->execute([$username, $userId]);

    header('Location: backend.php'); // Terug naar de admin-pagina na het bijwerken.
    exit;
}

// Haal de huidige gebruikersgegevens op om in het formulier te tonen.
$userQuery = "SELECT username FROM users WHERE id = ?";
$stmt = $pdo->prepare($userQuery);
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/gezondheidsmeter/css/main.css">
    <title>Gebruiker Bewerken</title>
</head>
<body>
    <div class="edit-user-form">
        <h2>Gebruiker Bewerken</h2>
        <form action="" method="post">
            <label for="username">Gebruikersnaam:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            <input type="submit" name="submit" value="Bijwerken">
        </form>
    </div>
</body>
</html>

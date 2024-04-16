<?php
require_once 'assets/includes/config_session.inc.php';
require_once 'assets/includes/signup_view.inc.php';
require_once 'assets/includes/login_view.inc.php';

if (isset($_SESSION['user_id'])) {
    header('Location: assets/pages/dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Unbounded:wght@200..900&display=swap" rel="stylesheet">
    <title>Gezondheidsmeter</title>
</head>

<body>

<div class="navbar">
<div class="logo">
        <a href="#top">GEZONDHEIDSMETER</a>
    </div>
    <div class="menu">
        <a href="#top">Home</a>
        <a href="#over_ons">Over Ons</a>
        <a href="#contact">Contact</a>
    </div>
    <div class="login">
        <a href="assets/includes/login.php">Login</a>
    </div>

    <button class="hamburger" aria-label="Toggle menu" onclick="toggleMenu()">
        &#9776;
    </button>
</div>

<div class="start">
    <div class="register_col"> 
        <h1> START NU</h1>
        <p> Onze interactieve tool is ontworpen om jouw leefgewoonten te analyseren en je real-time feedback te geven over hoe gezond je leeft. Benieuwd hoe je scoort op de zes pijlers van vitaliteit? Neem de controle en begin je reis naar een gezonder jij. </p>
        <a href="assets/includes/login.php" class="button_reg">Registreer nu</a>
    </div>
    <div class="register_col2"> 
        <div class="register_img"> </div>
    </div>
</div>

<div class="cards">
        <div class="card dark">
            <div class="title">
                <h3>Over ons</h3>
            </div>
            <p>Wij zijn een team van gezondheidsprofessionals en technologische innovators die geloven in de kracht van preventie. Je bent geboren uit een passie voor een gezonde levensstijl en het empoweren van jongeren. </p>
        </div>
        <div class="card light">
            <div class="title">
                <h3>App informatie</h3>
            </div>
            <p>Met onze app wordt gezond leven een stuk makkelijker en leuker! Hij helpt je elke dag met tips over eten en bewegen die helemaal voor jou zijn gemaakt. Zo leer je kleine veranderingen in je dagelijks leven te brengen die je gezonder en blijer maken.
            </p>
        </div>
</div>

<div class="contact" id="contact">
	<div class="content">
        <div class="contact_bg">
            <form method="post">
                <h3>Heeft u hulp nodig? Stuur ons een berichtje!</h3>
                <input type="text" name="name" placeholder="Naam">
                <input type="email" name="mail" placeholder="E-Mail">
                <textarea name="message" placeholder="Bericht..."></textarea>
                <input type="submit" name="submit" value="Versturen">
            </form>
        </div>
	</div>
</div>

<div class="footer">
  <p>©2024 Netherlands, All Rights Reserved by  <a href="https://github.com/Mike123Mike223/geldmaatje"> MikeKanAlles</a></p>
</div>

<script src="assets/js/functions.js"></script>

</body>
</html>


<?php
require_once 'config_session.inc.php';
require_once 'signup_view.inc.php';
require_once 'login_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/reset.css">
    <link rel="stylesheet" href="../../css/main.css"> 
    <link rel="stylesheet" href="../../css/account.css"> <!-- Ensure this contains the styles from account.css -->
    <script defer src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script defer src="https://kit.fontawesome.com/8fc9b84c55.js" crossorigin="anonymous"></script>
	<script defer src="../../assets/js/main.js"></script>
	<script defer src="../../assets/js/account.js"></script>
    <title>Login Page</title>
</head>

<body>
    <div class="viewport">
        <div class="container" id="container">
            <?php if (!isset($_SESSION["user_id"])) { ?>
            <div class="form-container sign-in">
                <form action="login.inc.php" method="post"> 
                    <h1>Log in</h1>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="pwd" placeholder="Password" required>
                    <button name="login">Login</button>
                </form>
            </div>
            <?php check_login_errors(); ?>
            <div class="form-container sign-up">
                <form action="signup.inc.php" method="post">
                    <h1>Sign Up</h1>
                    <?php signup_inputs(); ?>
                    <button name="signup">Signup</button>
                </form>
            </div>
            <?php check_signup_errors(); ?>
            <?php } ?>
            <div class="toggle-container">
                <div class="toggle">
                    <div class="toggle-panel toggle-left">
                        <h1>Welkom terug!</h1>
                        <p>Heb je al een account?</p>
                        <button class="hidden" id="login">Inloggen</button>
                    </div>
                    <div class="toggle-panel toggle-right">
                        <h1>Welkom</h1>
                        <p>Vul hier je gegevens in om te beginnen met de app!</p>
                        <button class="hidden" id="register">Aanmelden</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

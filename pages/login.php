<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if ($session->isLoggedIn()) {
        header('Location: /pages/profile.php');
        exit();
    }

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    
    drawHeader2();
?>

<div class="loginRegister">
<form id="login-form" class="user-form" action="../actions/action_login.php" method="post">
    <label for="loginUsername">Username</label>
    <input type="text" id="loginUsername" name="loginUsername" required>
            
    <label for="loginPassword">Password</label>
    <input type="password" id="loginPassword" name="loginPassword" required>

    <input type="submit" value="Log in">
    <div class="account-link">
        Don't have an account? <a href="register.php">Sign up</a>
    </div>
</form>
</div>

<?php
    drawFooter();
?>
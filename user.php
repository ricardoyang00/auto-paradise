<?php
    declare(strict_types = 1);

    require_once('templates/common.tpl.php');
    drawHeader();
?>

<div class="login">
    <form id="login-form" class="user-form" action="login.php" method="post">
        <label for="loginUsername">Username</label>
        <input type="text" id="loginUsername" name="loginUsername" required>
                
        <label for="loginPassword">Password</label>
        <input type="password" id="loginPassword" name="loginPassword" required>
    
        <input type="submit" value="Login">
        <a href="register.php">Register</a>
    </form>
</div>

<?php drawFooter(); ?>
<?php
    declare(strict_types = 1);

    require_once('templates/common.tpl.php');
    drawHeader();
?>

<div class="login">
    <form id="register-form" class="user-form" action="register.php" method="post">
        <label for="registerEmail">Email</label>
        <input type="text" id="registerEmail" name="registerEmail" required>

        <label for="registerUsername">Username</label>
        <input type="text" id="registerUsername" name="registerUsername" required>

        <label for="registerPassword">Password</label>
        <input type="password" id="registerPassword" name="registerPassword" required>
    
        <input type="submit" value="Register">
        <a href="user.php">Login</a>
    </form>
</div>

<?php drawFooter(); ?>
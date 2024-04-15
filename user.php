<?php
    declare(strict_types = 1);

    require_once('templates/common.tpl.php');
    drawHeader2();
?>

<div class="login">
    <form id="login-form" class="user-form" action="login.php" method="post">
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

<?php drawFooter(); ?>
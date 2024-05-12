<?php
    declare (strict_types = 1);
    
    require_once(__DIR__ . '/../../utils/session.php');
    require_once(__DIR__ . '/../../database/connection.db.php');
    require_once(__DIR__ . '/../../database/user.class.php');

    $section = new Session();
    if (!$section->isLoggedIn()) {
        header('Location: ../../pages/login.php');
        exit();
    }

    $db = getDatabaseConnection();
    $user = User::getUserByUsername($db, $section->getUsername());

    function drawChangePasswordForm() { ?>
        <h2>Profile &nbsp;&nbsp;(password)</h2>
        <div id="profile" class="account-content">
            <form method="post" action="../actions/action_change_password.php">
                <div class="profile-content">
                    <h3>Current Password</h3>
                    <div class="data-container">
                        <input type="password" id="oldPassword" name="oldPassword" required>
                    </div>

                    <h3>New Password</h3>
                    <div class="data-container">
                        <input type="password" id="newPassword" name="newPassword" required>
                    </div>

                    <h3>Confirm New Password</h3>
                        <div class="data-container">
                    <input type="password" id="confirmNewPassword" name="confirmNewPassword" required>
                </div>
                </div>
                <div class="icon-and-button">
                    <button type="submit" class="profile-button" id="change-password">Change Password</button>
                </div>
            </form>
        </div>
<?php } 
    drawChangePasswordForm();
?>

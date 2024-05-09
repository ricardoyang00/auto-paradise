<h2>Profile &nbsp;&nbsp;(password)</h2>
<div id="profile" class="account-content">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="profile-content">
            <h3>Current Password</h3>
            <div class="data-container">
                <input type="password" id="oldPassword" name="oldPassword" required>
            </div>

            <h3>New Password</h3>
            <div class="data-container">
                <input type="password" id="newPassword" name="newPassword" required>
            </div>
        </div>
        <div class="icon-and-button">
            <button type="submit" class="profile-button" id="change-password">Change Password</button>
        </div>
    </form>
</div>

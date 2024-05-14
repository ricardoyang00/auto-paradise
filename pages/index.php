<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/index.tpl.php');

    $scripts = [];
    drawHeader(true, $scripts, false);
    drawMessages($session);
    drawAds();
    drawFooter(); 
?>
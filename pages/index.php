<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->generateCsrfToken();

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/index.tpl.php');

    $scripts = ['search'];
    drawHeader(true, $scripts, false);
    drawMessages($session);
    drawAds();
    drawFooter(); 
?>
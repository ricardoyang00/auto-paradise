<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();
    if (!$session->isLoggedIn()) {
        header('Location: ../pages/login.php');
        exit();
    }

    $username = $session->getUsername();
    $db = getDatabaseConnection();
    $wishList = Product::getUserWishList($db, $username);

    drawHeader2();
?>

<section id="notifications">
<h2>Notifications</h2>
  <article class="read">
    <div id="notification-details">
      <div id="notification-title">Notification title</div>
      <div id="notification-content">notification content is there</div>
      <div id="notification-date">24 May 2024, 22:30</div>
    </div>
    <div id="notification-actions">
      <button class="read-notification"><i class="fa-brands fa-readme"></i> Read</button>
    </div>
  </article>
  <article>
    <div id="notification-details">
      <div id="notification-title">Notificatiocbvbjkdbfjhabdfjkhabdfn title</div>
      <div id="notification-content">notification cofasdfjshdafl dsfho isadfghoisad iusd fhiousa fiou safiou ahsfiouh dsfiou hsdofiuh sadoifu hsadoifu asido ioas f  aisuhdaio suhd aisudh aiosu iaosuhiaos uhiaus diaous dioaus dhiasu daiosu haios u ntent is there</div>
      <div id="notification-date">24 May 2024, 22:30</div>
    </div>
    <div id="notification-actions">
      <button class="read-notification"><i class="fa-brands fa-readme"></i> Read</button>
    </div>
  </article>
</section>

<?php drawFooter(); ?>
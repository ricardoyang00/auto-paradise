<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../templates/common.tpl.php');
    drawHeader();
?>

<section id="ads">
  <article>
    <h1><a href="../index.php">Can't afford a real Ferrari? No worries! Here, you can buy even an F1 car!</a></h1>
    <img src="../images/ads/post-4.jpg" width="300" alt="">
  </article>
  <article>
    <h1><a href="../sell.php">Share your happiness with others by selling now!</a></h1>
    <img src="../images/ads/post-3.jpg" width="300" alt="">
  </article>
  <article>
    <h1><a href="index.php">Discover all the limited editions here!</a></h1>
    <img src="../images/ads/post-1.jpg" width="300" alt="">
  </article>  
</section>


<?php drawFooter(); ?>
<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");


  ?>
  <nav class="navigation">
    <ul>
        <li ><a href="index.php" class="<?= ($activePage == 'index') ? 'active':''; ?>"><i class="fa-duotone fa-house-blank"></i> <span>Accueil</span></a></li>
        <li><a href="liste-actus.php" class="<?= ($activePage == 'liste-actus') ? 'active':''; ?>"><i class="fa-duotone fa-rss"></i> <span>Actualités</span></a></li>
        <?php if(isset($_SESSION['Username'])){
          $i = 0;
          if(isset($users)){
            if($users['typeUser'] == 1){
              $i = 1;
            }
          }
          if($i != 1){
          ?>
        <li><a href="liste-cr.php" class="<?= ($activePage == 'liste-cr') ? 'active':''; ?>"><i class="fa-duotone fa-handshake-simple"></i> <span>Réunions</span></a></li>
      <?php }} ?>
        <li><a href="agenda.php" class="<?= ($activePage == 'agenda') ? 'active':''; ?>"><i class="fa-duotone fa-calendar-clock"></i> <span>Agenda</span></a></li>
        <hr>
        <li><a href="contribution.php" class="<?= ($activePage == 'contribution') ? 'active':''; ?>"><i class="fa-duotone fa-comment-lines"></i> <span>Contribuez</span></a></li>
        <li><a href="contact.php" class="<?= ($activePage == 'contact') ? 'active':''; ?>"><i class="fa-duotone fa-envelopes-bulk"></i> <span>Contactez-nous</span></a></li>

	</ul>
</nav>

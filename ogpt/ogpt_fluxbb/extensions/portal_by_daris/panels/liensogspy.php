
<?php


$panel['title'] = 'Liens OGSpy'; // title for panel
?>

  <ul class="menu-links">
<?php
 $sql = 'SELECT * from  ogspy_mod where active=1 order by position, title';
 $query = $forum_db->query($sql) or error("Impossible de rechercher le menu.", __FILE__, __LINE__, $pun_db->error());
 while($line = $forum_db->fetch_assoc($query))
 {
                echo '<a href="http://ogameportail.free.fr/ogspy/index.php?action='.$line['action'].'">'.$line['menu'].'</a><br>';

  }

   ?>

  </ul>

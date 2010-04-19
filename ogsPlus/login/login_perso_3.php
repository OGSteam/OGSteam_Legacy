<?php

      session_start();

      $_SESSION['id'] = $id;
      
  require ('../admin/connexion.php');    
  $quet=mysql_query("SELECT * FROM users WHERE id='".$id."' ");
  while ($result=mysql_fetch_array($quet))
  $lng = $result["lng"];
  
header("Location: ../users/index.php?lng=$lng&page=galerie.php");
exit;

?>

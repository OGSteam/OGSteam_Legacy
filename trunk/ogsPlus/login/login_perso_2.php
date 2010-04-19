<?php

session_start();

$_SESSION['id'] = $id;

  require ('../admin/connexion.php'); 
  $quet=mysql_query("UPDATE users SET last_log='".time()."' WHERE id ='$id'");
  mysql_close();

header("Location: login_perso_3.php");
exit;

?>

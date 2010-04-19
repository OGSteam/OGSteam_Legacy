<?php

  require ('../admin/connexion.php'); 
  $retour = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM users");
  $donnees = mysql_fetch_array($retour);

$users = $donnees['nbre_entrees'];


  require ('../admin/connexion.php'); 
  $retour = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM alli");
  $donnees = mysql_fetch_array($retour);

$alli = $donnees['nbre_entrees'];

$total = $alli+$users;

?>

document.write('<?php echo $total; ?>')

<?

mysql_close(); 
mysql_close(); 

?>

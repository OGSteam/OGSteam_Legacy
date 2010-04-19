<?php

  require ('../admin/connexion.php'); 
  $quet=mysql_query("UPDATE users SET alli='".htmlentities($_POST['1'])."', tld='".htmlentities($_POST['2'])."', lng='".htmlentities($_POST['3'])."' WHERE id='$id' ");
  mysql_close();

  require ('../admin/connexion.php');    
  $quet=mysql_query("SELECT * FROM users WHERE id='".$id."' ");
  while ($result=mysql_fetch_array($quet))
  $lngbis = $result["lng"];
  mysql_close();

?>
<?php echo $lng_be_aa ?>

<META http-EQUIV="Refresh" CONTENT="1; url=index.php?lng=<?php echo $lngbis; ?>&page=galerie.php">







<?php

  require ('../admin/connexion.php'); 
  $quet=mysql_query("UPDATE users SET p1m='".htmlentities($_POST['p1m'])."', p2m='".htmlentities($_POST['p2m'])."', p3m='".htmlentities($_POST['p3m'])."', p4m='".htmlentities($_POST['p4m'])."', p5m='".htmlentities($_POST['p5m'])."', p6m='".htmlentities($_POST['p6m'])."', p7m='".htmlentities($_POST['p7m'])."', p8m='".htmlentities($_POST['p8m'])."', p9m='".htmlentities($_POST['p9m'])."', p1c='".htmlentities($_POST['p1c'])."', p2c='".htmlentities($_POST['p2c'])."', p3c='".htmlentities($_POST['p3c'])."', p4c='".htmlentities($_POST['p4c'])."', p5c='".htmlentities($_POST['p5c'])."', p6c='".htmlentities($_POST['p6c'])."', p7c='".htmlentities($_POST['p7c'])."', p8c='".htmlentities($_POST['p8c'])."', p9c='".htmlentities($_POST['p9c'])."', p1d='".htmlentities($_POST['p1d'])."', p2d='".htmlentities($_POST['p2d'])."', p3d='".htmlentities($_POST['p3d'])."', p4d='".htmlentities($_POST['p4d'])."', p5d='".htmlentities($_POST['p5d'])."', p6d='".htmlentities($_POST['p6d'])."', p7d='".htmlentities($_POST['p7d'])"', p8d='".htmlentities($_POST['p8d'])."', p9d='".htmlentities($_POST['p9d'])."' WHERE id ='$id'");
  {  
  } mysql_close();

?>
<?php echo $lng_be_aa ?>

<META http-EQUIV="Refresh" CONTENT="1; url=index.php?lng=<?php echo $lng ?>&page=galerie.php">

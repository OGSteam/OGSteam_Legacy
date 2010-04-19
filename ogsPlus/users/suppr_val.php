<?php

  require ('../admin/connexion.php'); 
  $quet=mysql_query("DELETE FROM users WHERE id ='$id'");
  {  
  } mysql_close();

;?>

<?php
session_start();
session_destroy();
?>

<?php echo $lng_bl_ac ?> 
<br><?php echo $lng_bl_ad ?> ogplus@cc30.net<br><br>
<?php echo $lng_bl_ae ?>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-816698-2";
urchinTracker();
</script>

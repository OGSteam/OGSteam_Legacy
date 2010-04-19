<?php

  session_start();
  $_SESSION['id'] = $id;

  require ('../admin/connexion.php');
  $select = mysql_query("SELECT * FROM alli WHERE id='".$id."' ");
  $data = mysql_fetch_assoc($select);
  
if(md5($_POST['pass']) == $data['pass']) {

echo "<a href=\"index.php?lng=$lng&page=suppr_val.php\"><font color=\"#FFFFFF\">$lng_bj_aa</font></a>";

}else{

echo "$lng_bf_ab";

}

?>

 <? mysql_close(); ?>
 
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-816698-2";
urchinTracker();
</script>

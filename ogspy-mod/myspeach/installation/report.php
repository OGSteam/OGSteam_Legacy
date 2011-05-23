<?php
session_start();

if($_SESSION['report']!=""){

  mail("sky@graphiks.net","Rapport de debug MySpeach",$_SESSION['report']);

$_SESSION['report']='';

echo '<br><br><center><b>Rapport envoy&eacute; !</b> <br />Vous pouvez maintenant post&eacute; un message sur le forum et nous vous r&eacute;pondrons le plus vite possible.</b></center>';
}
?>
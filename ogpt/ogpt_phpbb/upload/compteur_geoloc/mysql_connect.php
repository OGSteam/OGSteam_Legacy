<?php
 include('config.php');
 $link = mysql_connect($host, $user, $mdp);
 if(!$link){  exit; }if(!mysql_select_db($database)){mysql_close($link);exit;} ?>

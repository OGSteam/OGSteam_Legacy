<?php
  include_once("admin/config.php");
  if (!defined('IN_SPYOGAME')) $my_ms['root']= "..";
  else $my_ms['root']=$my_ms["absolu_root"].$my_ms["repertoire"];
  require($my_ms['root'].'/chat.php');
?>

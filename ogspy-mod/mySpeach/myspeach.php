<?php
/***************************************************************************
*	filename	: myspeach.php
*	desc.		: realisation d'un mod myspeach pour ogspy
*	Author		: Naqdazar - mailto:lexa.gg@free.fr
*	created		: 31/07/2006
*	modified	: 31/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
$query = "SELECT active FROM ".TABLE_MOD." WHERE action='myspeach' AND active='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");
ob_start();
require_once("views/page_header.php");//
$my_ms['root']="mod/myspeach";
$my_ms['repertoire']=$my_ms['root'];
   echo "<HEAD>\n";
   echo "\t"."<TITLE>DONE</TITLE>";
   echo "\t"."<meta http-equiv=\"content-type\" content=\"text/html; charset=<?php echo $default_charset; ?>\">";
   echo "\t"."<link rel=stylesheet type=\"text/css\" href=\"".$link_css."/formate.css\">";
   echo "</HEAD>";
   echo "<div>\n";


   if ((isset($pub_subaction) and $pub_subaction=="ms_install") or (!file_exists("mod/myspeach/admin/config.php"))) {
      echo "\t"."<table width=\"80%\" align=\"center\">\n";
      echo "<tr>\n";
      echo "<td class=\"c\" colspan=\"1\"><div align=\"center\"><h2><b>Installation de MySpeach</b></h2></div></td>\n";
      echo "</tr>\n";
       echo "<tr>"."\t"."<th width=\"100%\">\n";
   }
   if (isset($pub_subaction) and $pub_subaction=="ms_install") {
      //ob_end_clean();

      include_once ($my_ms['root'].'/installation/install1.php');

   } else
   if (!file_exists("mod/myspeach/admin/config.php")) {


   if (is_dir($my_ms['root'])) {
      include('mod/myspeach/installation/install.php');

   } else echo "Erreur dans le chamin myspeach....\n";
   } else include($my_ms['root']."/chat.php");
      echo "</th></tr>\n";
      echo "</table></div>\n";

   echo "\t"."<br>\n";
   echo "\t"."<div align=center><font size=2>MOD Shoutbox MySpeach v3.01c adapté par <a href=mailto:lexa.gg@free.fr>Naqdazar</a> (P) 2006</font></div>\n";
   echo "\t"."</td>\n";

require_once("views/page_tail.php");//
?>
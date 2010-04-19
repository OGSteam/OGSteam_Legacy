<?php
/*
 * missiles index.php
 */

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Pour le debug
//error_reporting(E_ALL);

require_once("fonctions_missiles.php");

// Test si le module est active
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='missiles' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) 
		die("Hacking attempt");

require_once("views/page_header.php");

?>
<style type="text/css">
/* the stylesheet */
div#mis_contenair a {width:auto; color:#5CCCE8; margin-right:5px; padding:4px 16px;  border:1px solid #344566;  text-decoration:none; font-family: Tahoma,sans-serif,arial; font-size: 10px;}
div#mis_contenair a:hover {color:lime}
</style>

<script language="JavaScript">
function missiles_checkbox_on() 
{	
	document.getElementById('check_g1').checked = true ;
	document.getElementById('check_g2').checked = true ;
	document.getElementById('check_g3').checked = true ;
	document.getElementById('check_g4').checked = true ;
	document.getElementById('check_g5').checked = true ;
	document.getElementById('check_g6').checked = true ;
	document.getElementById('check_g7').checked = true ;
	document.getElementById('check_g8').checked = true ;
	document.getElementById('check_g9').checked = true ;

}
function missiles_checkbox_off()
{
	document.getElementById('check_g1').checked = false ;
	document.getElementById('check_g2').checked = false ;
	document.getElementById('check_g3').checked = false ;
	document.getElementById('check_g4').checked = false ;
	document.getElementById('check_g5').checked = false ;
	document.getElementById('check_g6').checked = false ;
	document.getElementById('check_g7').checked = false ;
	document.getElementById('check_g8').checked = false ;
	document.getElementById('check_g9').checked = false ;	
}
</script>

<?php

// Affichage interface du module
$menu  = "<div id=\"mis_contenair\">\n";
$menu .= "<a href=\"index.php?action=missiles&page=mip\">MIP</a>\n";
$menu .= "<a href=\"index.php?action=missiles&page=changelog\">Changelog</a>\n";
$menu .= "</div>\n";
$menu .= "<br />\n";
print($menu);

if (isset($pub_action) && $pub_action == "missiles")
{
	if (!isset($pub_page))
		$pub_page = "mip";
	
	switch ($pub_page)
	{
		case "mip":
			require("missiles.php");
		break;
		case "changelog";
			require("changelog.php");
		break;
		
		default:
			require("missiles.php");
	}
}
else
{
	require("missiles.php");
}


echo "<br /><div align=center><font size=2>Mod Missiles développée par <b>Badwha</b> &copy;2006, modifié par <a href=mailto:zhym.net@gmail.com>Zhym</a> version ".get_module_version()." , &copy;2007</font></div>\n";

require_once("views/page_tail.php");

?>
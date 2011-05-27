<?php
/**
* gestion.php Fichier de gestion des diferentes parties
* @package Gestion MOD
* @author Kal Nightmare
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='gestion' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");
define("GESTION_MOD", true);

global $user_data;
//recuperaiton du dossier, et de la version
$query = "SELECT root, version FROM `" . TABLE_MOD . "` WHERE `action`='gestion'";
$result = $db->sql_fetch_assoc($db->sql_query($query));
$dir = "gestionmod";
$version = $result['version'];

require_once("views/page_header.php");
require_once("mod/".$dir."/function.php");

if ($user_data["user_admin"] != 1  && $user_data["user_coadmin"] != 1)
{
  redirection("index.php?action=message&id_message=forbidden&info");
} 

if (!isset($pub_subaction)) $pub_subaction='list';

$req = "SELECT * FROM `" . TABLE_MOD . "` WHERE `action` = 'modUpdate' and `active`= 0 ";
$res = $db->sql_query($req);

if ($db->sql_numrows($res) > 0) {
 $nb_colonnes = 4;
 $row = $db->sql_fetch_assoc($res);
 $lien = 'mod/'.$row['root'].'/'.$row['link'];
} else {
 $nb_colonnes = 3;
}
?>
<table align="center" width="100%" cellpadding="0" cellspacing="1">
<tr align="center"><td class="c"   <?php echo "colspan='".$nb_colonnes."'"; ?> >GESTION MOD</td></tr>
<tr align="center">
<?php

if ($pub_subaction != 'list') echo '<td class="c" width="'.floor(100/$nb_colonnes).'%"><a href="index.php?action=gestion&subaction=list" style="color: lime;"';
else echo '<th width="'.floor(100/$nb_colonnes).'%"><a';
echo '>Liste MOD</a></td>';
echo "\n";


if ($pub_subaction != 'group') echo '<td class="c" width="'.floor(100/$nb_colonnes).'%"><a href="index.php?action=gestion&subaction=group" style="color: lime;"';
else echo '<th width="'.floor(100/$nb_colonnes).'%"><a';
echo '>Gestion Groupes</a></td>';
echo "\n";

if ($pub_subaction != 'mod') echo '<td class="c" width="'.floor(100/$nb_colonnes).'%"><a href="index.php?action=gestion&subaction=mod" style="color: lime;"';
else echo '<th width="'.floor(100/$nb_colonnes).'%"><a';
	echo '>Renommeur de MOD</a></td>';
if 	($nb_colonnes == 4) {
if ($pub_subaction != 'modUpdate') echo '<td class="c" width="'.floor(100/$nb_colonnes).'%"><a href="index.php?action=gestion&subaction=modUpdate" style="color: lime;"';
else echo '<th width="'.floor(100/$nb_colonnes).'%"><a';
	echo '>modUpdate</a></td>';}
?>
</tr>
</table>

<?php
switch ($pub_subaction) {

case 'list':
	require('mod/'.$dir.'/list.php');
	break;

case 'group':
	require('mod/'.$dir.'/group.php');
	break;

case 'mod':
	require('mod/'.$dir.'/rename.php');
	break;

case 'modUpdate':
	require($lien);
	break;
	
case 'new_group':
	new_group();
	break;

case 'action_group':
	group();
	break;
case 'action_mod' :
	mod();
	break;
	
default:
	require('mod/'.$dir.'/list.php');
}

?>

<div align=center><font size=2>Gestion MOD (<?php echo $version; ?>) développé par <a href=mailto:kalnightmare@free.fr>Kal Nightmare</a> &copy;2006</font></div>

<?php
require_once("views/page_tail.php");
?>
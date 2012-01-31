<?php
/**
* maj.php 
* @package MAJ
* @author ben.12
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) {
   die("Hacking attempt");
}

require_once('./mod/maj/functions.php');

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='mod_maj' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die('Hacking attempt');

if(!isset($pub_subaction)) $pub_subaction = 'galaxy';

// Version du Mod
$mod_version = 0;
$query = 'SELECT version FROM '.TABLE_MOD.' WHERE `action`="mod_maj"';
$result = $db->sql_query($query);
list($mod_version) = $db->sql_fetch_row($result);

require_once('views/page_header.php');
// Coloration des joueur classés
$couleur_deb = 'FF0000';
$couleur_fin = '00FF00';
//Fin des réglages

$red_deb = hextoint(preg_replace('/^(.{2}).{2}.{2}$/', '$1', $couleur_deb));
$green_deb = hextoint(preg_replace('/^.{2}(.{2}).{2}$/', '$1', $couleur_deb));
$blue_deb = hextoint(preg_replace('/^.{2}.{2}(.{2})$/', '$1', $couleur_deb));

$red_fin = hextoint(preg_replace('/^(.{2}).{2}.{2}$/', '$1', $couleur_fin));
$green_fin = hextoint(preg_replace('/^.{2}(.{2}).{2}$/', '$1', $couleur_fin));
$blue_fin = hextoint(preg_replace('/^.{2}.{2}(.{2})$/', '$1', $couleur_fin));

function get_color($rate, $total=100) {
	global $red_deb, $green_deb, $blue_deb, $red_fin, $green_fin, $blue_fin, $couleur_deb;
	
	if($total==0)
		return $couleur_deb;
	
	$r = floor(((($red_fin - $red_deb) / $total) * $rate) + $red_deb);
	$v = floor(((($green_fin - $green_deb) / $total) * $rate) + $green_deb);
	$b = floor(((($blue_fin - $blue_deb) / $total) * $rate) + $blue_deb);
	
	return inttohex($r) . inttohex($v) . inttohex($b);
}

function hextoint($h) {
        $out = 0;
        
        $hi = substr($h, 0, 1);
        $lo = substr($h, 1, 1);
        
        $out = toint($hi)*16 + toint($lo);
        
        return $out;
}

function inttohex ($j) {
	if($j>=255) return 'FF';
    if($j<=0) return '00';
	
    $out = "";
        
    $hi = floor($j/16);
    $lo = $j%16;
        
    $out = tohex($hi) . tohex($lo);
        
    return $out;
}

function toint($h) {
	switch($h) {
        case '0' : return 0;
        case '1' : return 1;
        case '2' : return 2;
        case '3' : return 3;
        case '4' : return 4;
        case '5' : return 5;
        case '6' : return 6;
        case '7' : return 7;
        case '8' : return 8;
        case '9' : return 9;
        case 'A' : return 10;
        case 'B' : return 11;
        case 'C' : return 12;
        case 'D' : return 13;
        case 'E' : return 14;
        case 'F' : return 15;
        default : return 0;
    }
}

function tohex($k) {
	switch($k) {
        case 0 : return '0';
        case 1 : return '1';
        case 2 : return '2';
        case 3 : return '3';
        case 4 : return '4';
        case 5 : return '5';
        case 6 : return '6';
        case 7 : return '7';
        case 8 : return '8';
        case 9 : return '9';
        case 10 : return 'A';
        case 11 : return 'B';
        case 12 : return 'C';
        case 13 : return 'D';
        case 14 : return 'E';
        case 15 : return 'F';
        default : return '0';
    }
}
?>

<table width="100%">
<tr>
	<td>
		<table border="1">
		<tr align="center">
<?php

	if ($pub_subaction != "galaxy") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=mod_maj&subaction=galaxy';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Galaxies</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Galaxies</a>";
		echo "</th>"."\n";
	}
	
	if ($pub_subaction != "rank") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=mod_maj&subaction=rank';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Classements</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Classements</a>";
		echo "</th>"."\n";
	}
	
	if ($pub_subaction != "obs") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=mod_maj&subaction=obs';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Syst. Obsolètes</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Syst. Obsolètes</a>";
		echo "</th>"."\n";
	}
	
	if($user_data['user_admin']==1 || $user_data['user_coadmin']==1) {
		if ($pub_subaction != "admin") {
			echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=mod_maj&subaction=admin';\">";
			echo "<a style='cursor:pointer'><font color='lime'>Administration</font></a>";
			echo "</td>"."\n";
		}
		else {
			echo "\t\t\t"."<th width='150'>";
			echo "<a>Administration</a>";
			echo "</th>"."\n";
		}
	}
?>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="center"><br>
<?php
	switch($pub_subaction) {
		case 'galaxy':
			include('./mod/maj/galaxy_maj.php');
		break;
		case 'rank':
			include('./mod/maj/rank_maj.php');
		break;
		case 'obs':
			include('./mod/maj/system_not_updated.php');
		break;
		case 'admin':
			if($user_data['user_admin']==1 || $user_data['user_coadmin']==1) 
				include('./mod/maj/maj_admin.php');
		break;
		default:
			include('./mod/maj/galaxy_maj.php');
	}
?>
	</td>
</tr>
</table>
<?php
echo '<center><p><b>MOD MAJ v'.$mod_version.' par <font color="lime">ben.12</font></b></p></center>';
echo '<center><p><b>Mise à jour par <font color="lime">Shad</font></b></p></center>';
require_once('views/page_tail.php');
?>
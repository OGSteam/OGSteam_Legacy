<?php
/** $Id$ **/
/**
* display.php
* @package varAlly
* @author Aeris
* @link http://ogsteam.fr
* @version 2.1a
 */
if (!defined('IN_SPYOGAME')) die('Hacking attempt');
/**
 *
 */
require_once('./parameters/id.php');

$sql = 'SELECT `config_value` FROM `'.TABLE_CONFIG.'` WHERE `config_name`=\'tblAlly\'';
$result = $db->sql_query($sql);
list($tblSpy)=$db->sql_fetch_row($result);
define(TABLE_VARALLY,$table_prefix.$tblSpy);

$sql = 'SELECT `config_value` FROM `'.TABLE_CONFIG.'` WHERE `config_name`=\'tblAlly\'';
$result = $db->sql_query($sql);
list($tblSpy)=$db->sql_fetch_row($result);

/**
 * AutoPub
 */ 
function page_footer() {
global $db;
	
	//Récupére le numéro de version du mod
	$request = 'SELECT `version` from `'.TABLE_MOD.'` WHERE title=\'varAlly\'';
	$result = $db->sql_query($request);
	list($version) = $db->sql_fetch_row($result);
	echo '<div>varAlly (v'.$version.') créé par Aéris, légèrement modifié par CyberSpace</div>';
}

/**
 * Barre des boutons
 */
function button_bar() {
	global $user_auth, $user_data, $pub_subaction;
?>
	<table>
		<tr align='center'>
<?php

global $tblSpy;

		//Bouton Notre alliance
		if ($pub_subaction != 'ally')
		{
			echo '<td class=\'c\' width=\'150\' onclick="window.location =\'?action=varAlly&subaction=ally\'"><a style=\'cursor:pointer\'><font color=\'lime\'>Notre alliance</font></a></td>';
		} else {
			echo '<th width=\'150\'><a>Notre alliance</a></th>';
		}

		//Bouton Stats
		if ($pub_subaction != 'display')
		{
			echo '<td class=\'c\' width=\'150\' onclick="window.location =\'?action=varAlly&subaction=display\'"><a style=\'cursor:pointer\'><font color=\'lime\'>Stats</font></a></td>';
		} else {
			echo '<th width=\'150\'><a>Stats</a></th>';
		}
		
		//Bouton Nouveau rapport
		if ($pub_subaction != 'report' && $tblSpy == 'varally')
		{
			echo '<td class=\'c\' width=\'150\' onclick="window.location =\'?action=varAlly&subaction=report\'"><a style=\'cursor:pointer\'><font color=\'lime\'>Nouveau rapport</font></a></td>';
		} elseif($tblSpy == 'varally') {
			echo '<th width=\'150\'><a>Nouveau rapport</a></th>';
		}

		//Bouton Administration
		if ($user_data['user_admin'] == 1 || $user_data['user_coadmin'] == 1) if ($pub_subaction != 'admin')
		{
			echo '<td class=\'c\' width=\'150\' onclick="window.location =\'?action=varAlly&subaction=admin\'"><a style=\'cursor:pointer\'><font color=\'lime\'>Administration</font></a></td>';
		} else {
				echo '<th width=\'150\'><a>Administration</a></th>';
		}
		
?>
		</tr>
	</table>		
<?php
}

/**
 * Verification des tags et suppression des ; excedentaires
 * @param string $tag Le tag a vérifier
 */
function check_tag ( &$tag ) {
	if (substr($tag,0,1) == ';') $tag = substr($tag,1);
	if (substr($tag,-1) == ';') $tag = substr($tag,0,strlen($tag)-1);
}

/**
 * Affiche les statistiques
 * @param string $fields Type de stats: points,fleet ou research
 * @param string $player Nom du joueur
 */
function affStats ( $field, $player ) {
	global $db;
	switch ($field) {
		case 'points': $table = TABLE_RANK_PLAYER_POINTS; break;
		case 'fleet': $table = TABLE_RANK_PLAYER_FLEET; break;
		case 'research': $table = TABLE_RANK_PLAYER_RESEARCH; break;
	}

	$query = 'SELECT `points` FROM `'.$table.'` WHERE `player`=\''.$player.'\' ORDER BY `datadate` DESC LIMIT 2';
	$result = $db->sql_query($query);
	$nb = $db->sql_numrows($result);
	
	switch ($nb) {
		case 0; echo '<th colspan=\'2\'> - </th>'; break;
		case 1; $val = $db->sql_fetch_assoc($result); echo '<th>? -> '.$val['points'].'</th><th>n/a</th>'; break;
		case 2; $val = $db->sql_fetch_assoc($result); $new = $val['points']; $val = $db->sql_fetch_assoc($result); $ex = $val['points'];
			$ecart = $new - $ex; $pourcent = round(100*$ecart/$ex,2); if ($ecart<0) { $color='red'; } elseif ($ecart>0) { $color='lime'; $ecart = '+'.$ecart; $pourcent = '+'.$pourcent; } else { $color=''; }
			echo '<th>'.$ex.' -> '.$new.' (<font color=\''.$color.'\'>'.$ecart.'</font>)</th><th><font color=\''.$color.'\'>'.$pourcent.'%</font></th>'; break;
		default; echo '<th colspan=\'2\'> - Error - </th>'; break;
	}
}

function affPoints ( $player, $where ) {
	global $db;
	
	if ($where <> '')
	{
		$query = 'SELECT min(`datadate`) AS `min`, max(`datadate`) as `max` FROM `'.TABLE_VARALLY.'` WHERE `player`=\''.$player.'\''.$where;
		$result = $db->sql_query($query);
		list($min, $max) = $db->sql_fetch_row($result);
		$date = ' AND (`datadate`=\''.$min.'\' OR `datadate`=\''.$max.'\')';
		$limit = '';
	} else {
		$date = '';
		$limit = ' LIMIT 2';
	}

	$query = 'SELECT `points` FROM `'.TABLE_VARALLY.'` WHERE `player`=\''.$player.'\''.$date.' ORDER BY `datadate` DESC'.$limit;
	$result = $db->sql_query($query);
	$nb = $db->sql_numrows($result);
    	switch ($nb) {
		case 0; echo '<th colspan=\'2\'> - </th>'; break;
		case 1; $val = $db->sql_fetch_assoc($result); echo '<th>'.$val['points'].'</th><th>n/a</th>'; break;
		case 2; $val = $db->sql_fetch_assoc($result); $new = $val['points']; $val = $db->sql_fetch_assoc($result); $ex = $val['points'];
		    $ecart = $new - $ex; 
		    $pourcent = round(100*$ecart/$ex,2);        

		    global $tblecart; 
		    $tblecart[] = array( "joueur" => $player, "pts" => $ecart, "prc" => $pourcent );        

		    if ($ecart<0) { $color='red'; } elseif ($ecart>0) { $color='lime'; $ecart = '+'.$ecart; $pourcent = '+'.$pourcent; } else { $color=''; }        

		    echo '<th>'.$ex.' -> '.$new.' (<font color=\''.$color.'\'>'.$ecart.'</font>)</th><th><font color=\''.$color.'\'>'.$pourcent.'%</font></th>'; break;
		default; echo '<th colspan=\'2\'> - Error - </th>'; break;
	}	
}

function parseDate ( $date ) {
	preg_match('#(\d{2})/(\d{2})/(\d{4})\s(\d{2}):(\d{2}):(\d{2})#', $date, $reg);
	return(mktime($reg[4], $reg[5], $reg[6], $reg[2], $reg[1], $reg[3]));
}
?>

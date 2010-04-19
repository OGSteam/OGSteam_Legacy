<style>
form
{
	display: inline;
	margin: 0;
}
</style>
<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');
$query = 'SELECT active FROM '.TABLE_MOD.' WHERE action=\'gameOgame\' AND active=\'1\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) die('Hacking attempt');

require_once('./parameters/id.php');
define('TABLE_GAME',$table_prefix.'game');
define('TABLE_GAME_USERS',$table_prefix.'game_users');
define('TABLE_GAME_RECYCLAGE',$table_prefix.'game_recyclage');
define('TABLE_GAME_VIEW',$table_prefix.'game_view');
define('TABLE_GAME_RECYCLAGE_VIEW',$table_prefix.'game_recyclage_view');

//récupération des paramètres de config
$query = "SELECT value FROM `".TABLE_MOD_CFG."` WHERE `mod`='gameOgame' and `config`='config'";
$result = $db->sql_query($query);
$config = $db->sql_fetch_row($result);
$config=unserialize($config[0]);

function convNumber($number)
{
	return(number_format($number,0,'.',' '));
}

function page_footer ()
{
global $db;
	
	//Récupére le numéro de version du mod
	$request = 'SELECT version from '.TABLE_MOD.' WHERE title=\'gameOgame\'';
	$result = $db->sql_query($request);
	list($version) = $db->sql_fetch_row($result);
	echo '<div style="background-color:#232425;">gameOgame (v'.$version.') cr&eacute;&eacute; par A&eacute;ris<br />Modifi&eacute; par ericc</div>';
}

//-------------------------------------------------------------------------------------------------------------------
// Création du menu
function menu($pub_page){
	global $pages,$user_data;
	// Definition des pages du module
	$i=-1;
  $pages['fichier'][++$i] = 'stats';					
  $pages['texte'][$i] = '&nbsp;Classements&nbsp;';								
  $pages['admin'][$i] = 0;
  
  $pages['fichier'][++$i] = 'display';					
  $pages['texte'][$i] = '&nbsp;Affichage&nbsp;';				
  $pages['admin'][$i] = 0;
  
  $pages['fichier'][++$i] = 'report';
  $pages['texte'][$i] = '&nbsp;Nouveau RC&nbsp';			
  $pages['admin'][$i] = 0;
  
  $pages['fichier'][++$i] = 'admin';
  $pages['texte'][$i] = '&nbsp;Administration&nbsp;';
  $pages['admin'][$i] = 1;
  
  $pages['fichier'][++$i] = 'changelog';
  $pages['texte'][$i] = '&nbsp;Changelog&nbsp;';
  $pages['admin'][$i] = 1;

  //Construction du menu
	echo "	<table width='100%'><tr align='center'>";
	for($i=0;$i<count($pages['fichier']);$i++)
		if (($pages['admin'][$i] && ($user_data['user_admin']==1 || $user_data['user_coadmin']==1))||(!$pages['admin'][$i]) )
			if ($pub_page != $pages['fichier'][$i])
			{
				echo "\t<td class='c' width='150' onclick=\"window.location = 'index.php?action=gameOgame&subaction=".$pages['fichier'][$i]."';\">";
				echo "<a style='cursor:pointer'><font color='lime'>".$pages['texte'][$i]."</font></a></td>";
			} else 
				echo "\t<th width='150'><a>".$pages['texte'][$i]."</a></th>";
	echo "\t\t</tr>\n\t\t</table>";
}
//-------------------------------------------------------------------------------------------------------------------

function userNameById ( $id )
{
	global $db;
	$query = 'SELECT user_name FROM '.TABLE_USER.' WHERE user_id=\''.(int)$id.'\'';
	$result = $db->sql_query($query);
	if ($db->sql_numrows($result)) list($name) = $db->sql_fetch_row($result); else $name = 'Inconnu';
	return($name);
}

function userIdByName ( $name )
{
	global $db;
	$query = 'SELECT user_id FROM '.TABLE_USER.' WHERE user_name=\''.mysql_real_escape_string($name).'\'';
	$result = $db->sql_query($query);
	if ($db->sql_numrows($result)) list($id) = $db->sql_fetch_row($result); else $id = '0';
	return($id);
}

function check_name ( &$name )
{
	if (substr($name,0,1) == ';') $name = substr($name,1);
	if (substr($name,-1) == ';') $name = substr($name,0,strlen($name)-1);
}
//Admin du mod
function isAdmin ( $id )
{
	global $db;
	$sql = 'SELECT admin FROM '.TABLE_GAME_USERS.' WHERE id=\''.(int)$id.'\'';
	$result = $db->sql_query($sql);
	if (!$db->sql_numrows($result))
	{
		$admin = 0;
	} else {
		list($admin) = $db->sql_fetch_row($result);
	}
	return($admin);
}

function isUser ( $id )
{
	global $db;
	$sql = 'SELECT user FROM '.TABLE_GAME_USERS.' WHERE id=\''.(int)$id.'\'';
	$result = $db->sql_query($sql);
	if (!$db->sql_numrows($result))
	{
		$user = 0;
	} else {
		list($user) = $db->sql_fetch_row($result);
	}
	return($user);
}

function cleanDoubleSpace(&$data)
{
	while (!(strpos($data,'  ')===FALSE))
	{
			$data = str_replace('  ',' ',$data);
	}
}
// Sauvegarde les paramètres du module 
function gog_SauvConfig ()
{
	global $db,$config;
	$sqldata=serialize($config);
    $query = "UPDATE ".TABLE_MOD_CFG." SET value = '".$sqldata."' WHERE `mod` = 'gameOgame' and `config`='config'";
	$db->sql_query($query);
}
// Purge Soft 
function softpurge()
{
	global $db,$config;
	// récupère la liste des joueurs actifs
	$query = "SELECT DISTINCT id,nb_rapport,point FROM `".TABLE_GAME_USERS."` ORDER BY id";
	$result = $db->sql_query($query);
	// pour chaque joueur
	while ($id = $db->sql_fetch_row($result))
	{
		$total = 0; //Total points
		$count = 0; //nb de RC 
		// récupère les RC du joueur qui correspondent au paramètre
		$query = "SELECT * FROM `".TABLE_GAME."` WHERE `sender`=".$id[0]." AND `points`<=".$config['soft'];
		$result2 = $db->sql_query($query);
		while ($val = $db->sql_fetch_assoc($result2))
		{
			$total += $val['points'];
			$count++ ;
			//supprime le RC
			$sql = 'DELETE FROM '.TABLE_GAME.' WHERE id=\''.$val['id'].'\'';
			$db->sql_query($sql);
			//supprime le RR 
			$sql = 'DELETE FROM '.TABLE_GAME_RECYCLAGE.' WHERE rc=\''.$val['id'].'\'';
			$db->sql_query($sql);
		}
		// On ajoute le nb de points et de nb de rapport supprimés
		$sql = "UPDATE ".TABLE_GAME_USERS." SET nb_rapport=".($id[1]+$count).",point=".($id[2]+$total)." WHERE id=".$id[0];
		$db->sql_query($sql);
	}
	// On optimize les tables 
	$query = "OPTIMIZE TABLE ".TABLE_GAME;
	$db->sql_query($query);
	$query = "OPTIMIZE TABLE ".TABLE_GAME_RECYCLAGE;
	$db->sql_query($query);
}
// Purge Hard
function hardpurge()
{
	global $db,$config;
	// récupère la liste des joueurs actifs
	$query = "SELECT DISTINCT id,nb_rapport,point FROM `".TABLE_GAME_USERS."` ORDER BY id";
	$result = $db->sql_query($query);
	// pour chaque joueur
	while ($id = $db->sql_fetch_row($result))
	{
		$total = 0; //Total points
		$count = 0; //nb de RC 
		$query = "SELECT * FROM `".TABLE_GAME."` WHERE `sender`=".$id[0]." ORDER BY points DESC LIMIT ".$config['hard'].",18446744073709551615";
		$result2 = $db->sql_query($query);
		while ($val = $db->sql_fetch_assoc($result2))
		{
			$total += $val['points'];
			$count++ ;
			//supprime le RC
			$sql = 'DELETE FROM '.TABLE_GAME.' WHERE id=\''.$val['id'].'\'';
			$db->sql_query($sql);
			//supprime le RR 
			$sql = 'DELETE FROM '.TABLE_GAME_RECYCLAGE.' WHERE rc=\''.$val['id'].'\'';
			$db->sql_query($sql);
		}
		// On ajoute le nb de points et de nb de rapport supprimés
		$sql = "UPDATE ".TABLE_GAME_USERS." SET nb_rapport=".($id[1]+$count).",point=".($id[2]+$total)." WHERE id=".$id[0];
		$db->sql_query($sql);
	}
	// On optimize les tables 
	$query = "OPTIMIZE TABLE ".TABLE_GAME;
	$db->sql_query($query);
	$query = "OPTIMIZE TABLE ".TABLE_GAME_RECYCLAGE;
	$db->sql_query($query);
}
function purge()
{
	global $db,$config;
	// récupère la liste des joueurs actifs
	$query = "SELECT DISTINCT id,nb_rapport,point FROM `".TABLE_GAME_USERS."` ORDER BY id";
	$result = $db->sql_query($query);
	// pour chaque joueur
	while ($id = $db->sql_fetch_row($result))
	{
		$total = 0; //Total points
		$count = 0; //nb de RC 
		$query = "SELECT * FROM `".TABLE_GAME."` WHERE `sender`=".$id[0]." ORDER BY points DESC ";
		$result2 = $db->sql_query($query);
		while ($val = $db->sql_fetch_assoc($result2))
		{
			$total += $val['points'];
			$count++ ;
			//supprime le RC
			$sql = 'DELETE FROM '.TABLE_GAME.' WHERE id=\''.$val['id'].'\'';
			$db->sql_query($sql);
			//supprime le RR 
			$sql = 'DELETE FROM '.TABLE_GAME_RECYCLAGE.' WHERE rc=\''.$val['id'].'\'';
			$db->sql_query($sql);
		}
		// On ajoute le nb de points et de nb de rapport supprimés
		$sql = "UPDATE ".TABLE_GAME_USERS." SET nb_rapport=".($id[1]+$count).",point=".($id[2]+$total)." WHERE id=".$id[0];
		$db->sql_query($sql);
	}
	// On optimize les tables 
	$query = "OPTIMIZE TABLE ".TABLE_GAME;
	$db->sql_query($query);
	$query = "OPTIMIZE TABLE ".TABLE_GAME_RECYCLAGE;
	$db->sql_query($query);
}
?>
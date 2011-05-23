<?php
/** $Id$ **/
/**
* Configuration/Administration du module
* @package varAlly
* @author Aeris
* @link http://ogsteam.fr
* @version 2.1a
 */
if (!defined('IN_SPYOGAME')) die('Hacking attempt');

if (!($user_data['user_admin'] == 1 || $user_data['user_coadmin'] == 1 || $user_data['management_user'] == 1)) echo die('Vous n\'avez pas les droits suffisants pour accéder à cette page');

if (isset($pub_modif))
{
	check_tag($pub_tag);
	switch ($pub_modif)
	{
		case 'tag':	   $sql = 'UPDATE `'.TABLE_CONFIG.'` SET `config_value`=\''.mysql_real_escape_string($pub_tag).'\' WHERE `config_name`=\'tagAlly\''; $db->sql_query($sql); break;
		case 'report': $sql = 'UPDATE `'.TABLE_CONFIG.'` SET `config_value`=\''.mysql_real_escape_string($pub_tag).'\' WHERE `config_name`=\'tagAllySpy\''; $db->sql_query($sql); break;
		case 'table':  $sql = 'UPDATE`'.TABLE_CONFIG.'` SET `config_value`=\''.mysql_real_escape_string($pub_tag).'\' WHERE `config_name`=\'tblAlly\''; $db->sql_query($sql); break;
		case 'bilan':  $sql = 'UPDATE`'.TABLE_CONFIG.'` SET `config_value`=\''.mysql_real_escape_string($pub_tag).'\' WHERE `config_name`=\'bilAlly\''; $db->sql_query($sql); break;
		case 'nbrjou':  $sql = 'UPDATE`'.TABLE_CONFIG.'` SET `config_value`=\''.mysql_real_escape_string($pub_tag).'\' WHERE `config_name`=\'nbrjoueur\''; $db->sql_query($sql); break;
	}
}

$sql = 'SELECT `config_value` FROM `'.TABLE_CONFIG.'` WHERE `config_name`=\'tagAlly\'';
$result = $db->sql_query($sql);
list($tag)=$db->sql_fetch_row($result);
	
$sql = 'SELECT `config_value` FROM `'.TABLE_CONFIG.'` WHERE `config_name`=\'tagAllySpy\'';
$result = $db->sql_query($sql);
list($tagSpy)=$db->sql_fetch_row($result);

$sql = 'SELECT `config_value` FROM `'.TABLE_CONFIG.'` WHERE `config_name`=\'tblAlly\'';
$result = $db->sql_query($sql);
list($tblSpy)=$db->sql_fetch_row($result);

$sql = 'SELECT `config_value` FROM `'.TABLE_CONFIG.'` WHERE `config_name`=\'bilAlly\'';
$result = $db->sql_query($sql);
list($bilSpy)=$db->sql_fetch_row($result);

$sql = 'SELECT `config_value` FROM `'.TABLE_CONFIG.'` WHERE `config_name`=\'nbrjoueur\'';
$result = $db->sql_query($sql);
list($nbrJou)=$db->sql_fetch_row($result);

echo '<form action=\'?action=varAlly&subaction=admin\' method=\'post\'>Utiliser les stats de&nbsp;: 
 <select name="tag">
  <option value="varally">varAlly</option>
  <option value="rank_members"'; if($tblSpy=='rank_members') echo 'selected="selected"'; echo '>allyRanking</option>
  <option value="rank_player_points"'; if($tblSpy=='rank_player_points') echo 'selected="selected"'; echo '>Stats générales</option>
 </select> 
 <input type=\'submit\' value=\'Valider\'>
 <input type=\'hidden\' name=\'modif\' value=\'table\'> 
</form>';

echo '<form action=\'?action=varAlly&subaction=admin\' method=\'post\'>Liste des tags à surveiller par défaut: <input type=\'text\' name=\'tag\' value=\''.$tag.'\'> <input type=\'submit\' value=\'Modifier\'><input type=\'hidden\' name=\'modif\' value=\'tag\'></form>';

echo '<form action=\'?action=varAlly&subaction=admin\' method=\'post\'>Liste des tags pouvant être gérer par ajout de rapports: <input type=\'text\' name=\'tag\' value=\''.$tagSpy.'\'> <input type=\'submit\' value=\'Modifier\'><input type=\'hidden\' name=\'modif\' value=\'report\'></form>';

echo '<form action=\'?action=varAlly&subaction=admin\' method=\'post\'>Afficher le bilan : <input type=\'checkbox\' name=\'tag\' value=\'oui\'';
if($bilSpy=='oui') echo 'checked="checked" ';
echo '> <input type=\'submit\' value=\'Valider\'><input type=\'hidden\' name=\'modif\' value=\'bilan\'></form>';
echo '<form action=\'?action=varAlly&subaction=admin\' method=\'post\'>Nombre de joueur par défaut dans le bilan: <input type=\'text\' name=\'tag\' size=\'2\' value=\''.$nbrJou.'\'> <input type=\'submit\' value=\'Modifier\'><input type=\'hidden\' name=\'modif\' value=\'nbrjou\'></form>';

?>

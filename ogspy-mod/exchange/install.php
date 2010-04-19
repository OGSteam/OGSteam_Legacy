<?php
 

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db, $table_prefix;
define("TABLE_EXCHANGE_USER",	$table_prefix."eXchange_User");
define("TABLE_EXCHANGE_ALLY",	$table_prefix."eXchange_Ally");
define("TABLE_EXCHANGE_OPTS",	$table_prefix."eXchange_Opts");
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");

//Si les tables existent, on les supprime
$query="DROP TABLE IF EXISTS ".TABLE_EXCHANGE_USER."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_EXCHANGE_ALLY."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_EXCHANGE_OPTS."";
$db->sql_query($query);

$query = "DELETE FROM ".TABLE_MOD." WHERE root='eXchange'";
$db->sql_query($query);

//Ensuite, on cr�e les tables


$query = "CREATE TABLE ".TABLE_EXCHANGE_USER." ("
	. " id INT NOT NULL AUTO_INCREMENT, "
	. " date INT(11) NOT NULL, "
	. " user_id INT NOT NULL, "
	. " pos_galaxie INT NOT NULL, "
	. " pos_sys INT NOT NULL, "
	. " pos_pos INT NOT NULL, "
	. " player TINYTEXT NOT NULL, "
	. " title TEXT NOT NULL, "
	. " body TEXT NOT NULL, "
	. " FULLTEXT (player,title,body), "
	. " primary key ( id )"
	. " )TYPE=MyISAM";
$db->sql_query($query);

$query = "CREATE TABLE ".TABLE_EXCHANGE_ALLY." ("
	. " id INT NOT NULL AUTO_INCREMENT, "
	. " date INT(11) NOT NULL, "
	. " user_id INT NOT NULL, "
	. " alliance TINYTEXT NOT NULL, "
	. " player TINYTEXT NOT NULL, "
	. " body TEXT NOT NULL, "
	. " FULLTEXT (player,alliance,body), "
	. " primary key ( id )"
	. " )TYPE=MyISAM";
$db->sql_query($query);

$query = "CREATE TABLE ".TABLE_EXCHANGE_OPTS." ("
	. " id INT NOT NULL AUTO_INCREMENT, "
	. " user_id INT NOT NULL, "
	. " opts INT NOT NULL, "
	. " val INT NOT NULL, "
	. " primary key ( id )"
	. " )";
$db->sql_query($query);

$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES (null,'eXchange','eXchange','eXchange','eXchange','index.php','0.2.1','1')";
$db->sql_query($query);
$mod_id = $db->sql_insertid();

// On regarde si la table xtense_callbacks existe :
$query = 'show tables from '.$db->dbname.' like "'.TABLE_XTENSE_CALLBACKS.'" ';
$result = $db->sql_query($query);
if($db->sql_numrows($result) != 0)
{
	//Bonne nouvelle le mod xtense 2 est install� !
	//Maintenant on regarde si eXchange est dedans normalement il devrait pas mais on est jamais trop prudent...
	$query = 'Select * From '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
	$result = $db->sql_query($query);
	$nresult = $db->sql_numrows($result);
	if($nresult == 0)
	{
		// Il est pas dedans alors on l'ajoute :
		$query = 'INSERT INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES 
				('.$mod_id.', "eXchange_xtense2_msg", "msg", 1)';
		$db->sql_query($query);		
		$query = 'INSERT INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES 
		('.$mod_id.', "eXchange_xtense2_ally_msg", "ally_msg", 1)';
		$db->sql_query($query);		
		echo("<script> alert('La compatibilit� du mod eXchange avec le mod Xtense2 est install�e !') </script>");
	}
}
else
{
	//On averti qu'Xtense 2 n'est pas install� :
	echo("<script> alert('Le mod Xtense 2 n\'est pas install�. \nLa compatibilit� du mod eXchange ne sera donc pas install�e !\nPensez � installer Xtense 2 c'est pratique ;)') </script>");
}

?>

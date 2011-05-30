<?php


if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db, $table_prefix;
define("TABLE_EXPEDITION", $table_prefix."eXpedition");
define("TABLE_EXPEDITION_TYPE_0", $table_prefix."eXpedition_Type_0");
define("TABLE_EXPEDITION_TYPE_1", $table_prefix."eXpedition_Type_1");
define("TABLE_EXPEDITION_TYPE_2", $table_prefix."eXpedition_Type_2");
define("TABLE_EXPEDITION_TYPE_3", $table_prefix."eXpedition_Type_3");
define("TABLE_EXPEDITION_OPTS", $table_prefix."eXpedition_Opts");
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");

//Si les tables existent, on les supprime
$query="DROP TABLE IF EXISTS ".TABLE_EXPEDITION."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_EXPEDITION_TYPE_0."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_EXPEDITION_TYPE_1."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_EXPEDITION_TYPE_2."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_EXPEDITION_TYPE_3."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_EXPEDITION_OPTS."";
$db->sql_query($query);

$is_ok = false;
$mod_folder = "expedition";
$is_ok = install_mod ($mod_folder);
if ($is_ok == true)
	{
		//Ensuite, on crée les tables
		$query = "CREATE TABLE ".TABLE_EXPEDITION." ("
			. " id INT NOT NULL AUTO_INCREMENT, "
			. " user_id INT NOT NULL, "
			. " date INT(11) NOT NULL, "
			. " pos_galaxie INT NOT NULL, "
			. " pos_sys INT NOT NULL, "
			. " type INT NOT NULL, "
			. " primary key ( id )"
			. " )";
		$db->sql_query($query);

		$query = "CREATE TABLE ".TABLE_EXPEDITION_TYPE_0." ("
			. " id INT NOT NULL AUTO_INCREMENT, "
			. " id_eXpedition INT NOT NULL, "
			. " typeVitesse INT NOT NULL, "
			. " primary key ( id )"
			. " )";
		$db->sql_query($query);
		$query = "CREATE TABLE ".TABLE_EXPEDITION_TYPE_1." ("
			. " id INT NOT NULL AUTO_INCREMENT, "
			. " id_eXpedition INT NOT NULL, "
			. " typeRessource INT NOT NULL, "
			. " metal INT NOT NULL, "
			. " cristal INT NOT NULL, "
			. " deuterium INT NOT NULL, "
			. " antimatiere INT NOT NULL, "
			. " primary key ( id )"
			. " )";
		$db->sql_query($query);
		$query = "CREATE TABLE ".TABLE_EXPEDITION_TYPE_2." ("
			. " id INT NOT NULL AUTO_INCREMENT, "
			. " id_eXpedition INT NOT NULL, "
			. " pt INT NOT NULL, "
			. " gt INT NOT NULL, "
			. " cle INT NOT NULL, "
			. " clo INT NOT NULL, "
			. " cr INT NOT NULL, "
			. " vb INT NOT NULL, "
			. " vc INT NOT NULL, "
			. " rec INT NOT NULL, "
			. " se INT NOT NULL, "
			. " bmb INT NOT NULL, "
			. " dst INT NOT NULL, "
			. " tra INT NOT NULL, "
			. " units INT NOT NULL, "
			. " primary key ( id )"
			. " )";
		$db->sql_query($query);

		$query = "CREATE TABLE ".TABLE_EXPEDITION_TYPE_3." ("
			. " id INT NOT NULL AUTO_INCREMENT, "
			. " id_eXpedition INT NOT NULL, "
			. " typeRessource INT NOT NULL, "
			. " primary key ( id )"
			. " )";
		$db->sql_query($query);
		
		$query = "CREATE TABLE ".TABLE_EXPEDITION_OPTS." ("
			. " id INT NOT NULL AUTO_INCREMENT, "
			. " user_id INT NOT NULL, "
			. " opts INT NOT NULL, "
			. " val INT NOT NULL, "
			. " primary key ( id )"
			. " )";
		$db->sql_query($query);
		
		// On regarde si la table xtense_callbacks existe :
		$query = 'show tables from '.$db->dbname.' like "'.TABLE_XTENSE_CALLBACKS.'" ';
		$result = $db->sql_query($query);
		// On récupère le n° d'id du mod
		$query = "SELECT `id` FROM `".TABLE_MOD."` WHERE `action`='eXchange' AND `active`='1' LIMIT 1";
		$result = $db->sql_query($query);
		$mod_id = $db->sql_fetch_row($result);
		$mod_id = $mod_id[0];
		if($db->sql_numrows($result) != 0)
			{
				//Bonne nouvelle le mod xtense 2 est installé !
				//Maintenant on regarde si eXpedition est dedans normalement il devrait pas mais on est jamais trop prudent...
				$query = 'Select * From '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
				$result = $db->sql_query($query);
				$nresult = $db->sql_numrows($result);
				if($nresult == 0)
					{
						// Il est pas dedans alors on l'ajoute :
						$query = 'INSERT INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES 
						('.$mod_id.', "eXpedition_xtense2_integration", "expedition", 1)';
						$db->sql_query($query);		
						echo("<script> alert('La compatibilité du mod eXpedition avec le mod Xtense2 est installée !') </script>");
					}
			}
		else
			{
				//On averti qu'Xtense 2 n'est pas installé :
				echo("<script> alert('Le mod Xtense 2 n\'est pas installé. \nLa compatibilité du mod eXpedition ne sera donc pas installée !\nPensez à installer Xtense 2 c'est pratique ;)') </script>");
			}
	}
else
	{
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}
?>

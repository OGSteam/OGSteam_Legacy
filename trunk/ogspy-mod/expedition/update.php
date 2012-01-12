<?php
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db, $table_prefix;

define("TABLE_EXPEDITION_TYPE_2", $table_prefix."eXpedition_Type_2");
define("TABLE_EXPEDITION_OPTS", $table_prefix."eXpedition_Opts");
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");

// recupérer le nombre d'unite d'une flotte
function calculUnits($tabFlotte)
{
	$units = 0;
	$units += ( 2  + 2  + 0  ) * $tabFlotte['pt'];
	$units += ( 6  + 6  + 0  ) * $tabFlotte['gt'];
	$units += ( 3  + 1  + 0  ) * $tabFlotte['cle'];
	
	$units += ( 6  + 4  + 0  ) * $tabFlotte['clo'];
	$units += ( 20 + 7  + 2  ) * $tabFlotte['cr'];
	$units += ( 45 + 15 + 0  ) * $tabFlotte['vb'];
	
	$units += ( 10 + 20 + 10 ) * $tabFlotte['vc'];
	$units += ( 10 + 6  + 2  ) * $tabFlotte['rec'];
	$units += ( 0  + 1  + 0  ) * $tabFlotte['se'];
	
	$units += ( 50 + 25 + 15 ) * $tabFlotte['bmb'];
	$units += ( 60 + 50 + 15 ) * $tabFlotte['dst'];
	$units += ( 30 + 40 + 15 ) * $tabFlotte['tra'];
	return $units;
}

//On récupère la version actuel du mod	
$query = "SELECT id, version FROM ".TABLE_MOD." WHERE action='eXpedition'";
$result = $db->sql_query($query);
list($mod_id, $version) = $db->sql_fetch_row($result);
switch($version)
{
	case "0.1.0":
	case "0.1.1":
	case "0.1.2":
	case "0.1.3":
	case "0.1.4":
	case "0.1.5":
		$query = "CREATE TABLE ".TABLE_EXPEDITION_OPTS." ("
			. " id INT NOT NULL AUTO_INCREMENT, "
			. " user_id INT NOT NULL, "
			. " opts INT NOT NULL, "
			. " val INT NOT NULL, "
			. " primary key ( id )"
			. " )";
		$db->sql_query($query);
	case "0.1.6":
	case "0.1.7":
		$query = "SELECT id, pt, gt, cle, clo, cr, vb, vc, rec, se, bmb, dst, tra FROM ".TABLE_EXPEDITION_TYPE_2;
		$result = $db->sql_query($query);
		while($row = $db->sql_fetch_assoc($result))
		{
			$superTab[] = $row;
		}		
		$query = "ALTER TABLE ".TABLE_EXPEDITION_TYPE_2." ADD units INT NOT NULL";
		$db->sql_query($query);
		if(count($superTab) != 0)
		{
			foreach($superTab as $row)
			{
				$units = calculUnits($row);
				$query = "UPDATE ".TABLE_EXPEDITION_TYPE_2."
					  SET units =  $units
					  WHERE id = $row[id]";
				$db->sql_query($query);
			}
		}
				
	break;
}

// On regarde si la table xtense_callbacks existe :
$query = 'show tables from '.$db->dbname.' like "'.TABLE_XTENSE_CALLBACKS.'" ';
$result = $db->sql_query($query);
if($db->sql_numrows($result) != 0)
{
	//Bonne nouvelle le mod xtense 2 est installé !
	
	//Maintenant on regarde si eXpedition est dedans :
	$query = 'Select * From '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
	$result = $db->sql_query($query);
	if($db->sql_numrows($result) == 0)
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
	echo("<script> alert('Le mod Xtense 2 n\'est pas installé. \nLa compatibilité du mod eXpedition ne sera donc pas installée !\nPensez à installer Xtense 2 c'est pratique ;)') </script>");
}

$query = "UPDATE ".TABLE_MOD." SET `version`='0.4.3a' WHERE `action`='eXpedition'";
$db->sql_query($query);
?>

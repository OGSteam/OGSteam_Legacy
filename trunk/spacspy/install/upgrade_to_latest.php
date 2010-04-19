<?php
/**
* Mise à jour d'OGSpy : update_to_latest.php
* @package OGSpy
* @subpackage install
* @created 28/11/2005
* @modified 30/09/2007
* @version 3.04b
*/
?>
<html>
<head>
<title>Mise à jour OGSpy</title>
<link rel="stylesheet" type="text/css" href="../skin/OGSpy_skin/formate.css" />
</head>
<body>

<?php
define("IN_SPACSPY", true);
define("UPGRADE_IN_PROGRESS", true);

require_once("../common.php");

$request = "SELECT config_value FROM ".TABLE_CONFIG." WHERE config_name = 'version'";
$result = $db->sql_query($request);
list($ogsversion) = $db->sql_fetch_row($result);

$requests = array();
$up_to_date = false;
while (!$up_to_date){
	switch ($ogsversion) {
		case "0.1" :
		$ogsversion = "0.1b";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '".$ogsversion."' WHERE config_name = 'version'";
		break;

		case "0.1b" :
		$ogsversion = "0.1c";
		$requests[] = "ALTER TABLE ".TABLE_UNIVERSE." ADD `ope` BOOL NOT NULL DEFAULT '0' AFTER `status`";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '".$ogsversion."' WHERE config_name = 'version'";
		break;
		
		case "0.1c" :
		$ogsversion = "0.2";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '".$ogsversion."' WHERE config_name = 'version'";
		break;
		
		case "0.2" :
		$ogsversion = "0.3";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '".$ogsversion."' WHERE config_name = 'version'";
		break;
		
		case "0.3" :
		$ogsversion = "0.3b";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '".$ogsversion."' WHERE config_name = 'version'";
		$up_to_date = true;
		break;
		
		default:
		die("Aucune mise à jour n'est disponible");
	}
}
foreach ($requests as $request) {
	$db->sql_query($request);
}
?>
	<h3 align='center'><font color='yellow'>Mise à jour du serveur OGSpy vers la version <?php echo $ogsversion;?> effectuée avec succès</font></h3>
	<center>
	<b><i>Le script a seulement modifié la base de données, pensez à mettre à jour vos fichiers</i></b><br />
	</center>
</body>
</html>
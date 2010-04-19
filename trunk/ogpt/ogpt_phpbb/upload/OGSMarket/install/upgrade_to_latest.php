<?php
/***************************************************************************
*	filename	: update_to_latest.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 28/11/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/
?>

<html>
<head>
<title>Mise à jour OGSpy</title>
<link rel="stylesheet" type="text/css" href="http://80.237.203.201/download/use/epicblue/formate.css" />
</head>
<body>

<?php
define("IN_OGSMARKET", true);
define("UPGRADE_IN_PROGRESS", true);

require_once("../common.php");

$request = "SELECT value FROM ".TABLE_CONFIG." WHERE name = 'version'";
$result = $db->sql_query($request);
list($version) = $db->sql_fetch_row($result);

$requests = array();
$up_to_date = false;
// $version="0.2";

switch ($version) {
	
	case "0.2a" :
		$version = "0.2";
	break;
	
	case "0.2b" :
		$version = "0.2";
	break;

	case "0.2" :
	$requests[] = "UPDATE ".TABLE_CONFIG." SET value = '0.3' WHERE name = 'version'";
	$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES (null, 'home', '<p>Bienvenu sur votre Market!</font></b></p>')";
	$requests[] = "INSERT INTO `".TABLE_CONFIG."` VALUES(null,'menuprive','privé')";
	$requests[] = "INSERT INTO `".TABLE_CONFIG."` VALUES(null,'menulogout','logout')";
	$requests[] = "INSERT INTO `".TABLE_CONFIG."` VALUES(null,'menuforum','Forum et IRC')";
	$requests[] = "INSERT INTO `".TABLE_CONFIG."` VALUES(null,'menuautre','autre')";
	$requests[] = "INSERT INTO `".TABLE_CONFIG."` VALUES(null,'adresseforum','Adresse de votre forum')";
	$requests[] = "INSERT INTO `".TABLE_CONFIG."` VALUES(null,'nomforum','nom de votre forum')";
	$requests[] = "INSERT INTO `".TABLE_CONFIG."` VALUES(null,'menuautre','autre')";
	
	$version = "0.3";
	break;


	case "0.3" :
	$request = "SELECT MAX(pos_user)  FROM ".TABLE_TRADE." ";
	if(!($result = $db->sql_query($request)))
	{
		$requests[] = "ALTER TABLE `".TABLE_TRADE."` ADD `pos_user` INT NOT NULL DEFAULT '0'";

		$requests[] = "ALTER TABLE `".TABLE_TRADE."` ADD `pos_date` INT NOT NULL ";
	}

	$requests[] = "UPDATE ".TABLE_CONFIG." SET value = '0.4' WHERE name = 'version'";
	$version = "0.4";
	break;

	case "0.41" :
		$version = "0.4";
	break;
	
	case "0.4b" :
		$version = "0.4";
	break;
	
	case "0.4" :
	$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES(null, 'users_active', '0')";
	
	$request = "SELECT *  FROM ".TABLE_INFOS." WHERE `name` = 'home'";
	if(!($result = $db->sql_query($request)))
	{
		
		$requests[] = "CREATE TABLE `".TABLE_INFOS."` (".
  			"`id` int(11) NOT NULL auto_increment COMMENT 'Identificateur de la variable infos',".
  			"`name` varchar(20) NOT NULL default '' COMMENT 'Nom de la variable infos',".
  			"`value` longtext NOT NULL COMMENT 'Valeur de la variable infos',".
 			 "PRIMARY KEY  (`id`)".
			")";

		$requests[] = "INSERT INTO `".TABLE_INFOS."` SELECT * FROM `".TABLE_CONFIG."` WHERE `name` = 'home'";
	}
	
	$requests[] = "DELETE FROM `".TABLE_CONFIG."` WHERE `name` = 'home'";

	$requests[] = "UPDATE ".TABLE_CONFIG." SET value = '0.5' WHERE name = 'version'";
	$version = "0.5";
	break;

	case "0.5" :
	$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES (null, 'tauxmetal', '3')";
	$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES (null, 'tauxcristal', '2')";
	$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES (null, 'tauxdeuterium', '1')";
	$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES (null, 'view_trade', '0')";
	$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES (null, 'users_adr_auth_db', '')";
	$requests[] = "UPDATE ".TABLE_CONFIG." SET value = '0.6' WHERE name = 'version'";
	$version = "0.6";
	$up_to_date = true;
	break;

	default:
	die("Aucune mise à jour est disponible");
}

foreach ($requests as $request) {
	if(!($result = $db->sql_query($request)))
	{
		$out = "La requête : ".$request." est non exécuté, erreur de version!!!";
		echo  $out;
	}
}
?>
	<h3 align='center'><font color='yellow'>Mise à jour du serveur OGSMarket vers la version <?php echo $version;?> effectuée avec succès</font></h3>
	<center>
	<b><i>Le script a seulement modifié la base de données, pensez à mettre à jour vos fichiers</i></b><br />
<?php
if ($up_to_date) {
	echo "\t"."<b><i>Pensez à supprimer le dossier 'install'</i></b><br />"."\n";
	echo "\t"."<br /><a href='../index.php'>Retour</a>"."\n";
}
else {
	echo "\t"."<br><font color='orange'><b>Cette version n'est pas la dernière en date, veuillez rééxécuter le script</font><br />"."\n";
	echo "\t"."<a href=''>Recommencer l'opération</a>"."\n";
}
?>
	</center>
</body>
</html>
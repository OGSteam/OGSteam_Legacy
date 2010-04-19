<?php
/***************************************************************************
*	filename	: update_to_latest.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 28/11/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

define("IN_SPYOGAME", true);
define("UPGRADE_IN_PROGRESS", true);
// Retrieve installation language , french by default , cocorico.

$lang_install = "french";

if (!empty($_GET["lang"])) {
	$lang_install = $_GET["lang"];
}elseif (!empty($_POST["lang"])){
	$lang_install = $_POST["lang"];
}

require_once("../common.php");

require_once("language/lang_$lang_install/lang_install.php");
?>

<html>
<head>
<title>Mise � jour UniSpy</title>
<link rel="stylesheet" type="text/css" href="http://80.237.203.201/download/use/epicblue/formate.css" />
</head>
<body>

<?php

$request = "SELECT config_value FROM ".TABLE_CONFIG." WHERE config_name = 'version'";
$result = $db->sql_query($request);
list($version) = $db->sql_fetch_row($result);

$requests = array();
$up_to_date = false;
switch ($version) {
	case "1.0" :
	$version = "1.1";
	$requests[] = "CREATE TABLE unispy_group_perms ("
					."group_id mediumint(8) NOT NULL default '0',"
					."mod_id mediumint(8) NOT NULL default '0',"
					."PRIMARY KEY  (group_id, mod_id)"
					.")";
	$requests[] = "ALTER TABLE ".TABLE_MOD." CHANGE `menupos` `menupos` TINYINT( 1 ) NOT NULL DEFAULT '0' "; 
	break;
	
	case "1.0beta" :
	$version = "1.0";
	//Ajout de la vitesse de l'univers
	$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('uni_speed',1)";
	//Ajustement de la taille points des classements
	$requests[] = " ALTER TABLE `".$table_prefix."rank_ally_points` CHANGE `points` `points` BIGINT( 13 ) NOT NULL DEFAULT '0' ";
	$requests[] = " ALTER TABLE `".$table_prefix."rank_ally_fleet` CHANGE `points` `points` BIGINT( 13 ) NOT NULL DEFAULT '0' ";
	$requests[] = " ALTER TABLE `".$table_prefix."rank_ally_research` CHANGE `points` `points` BIGINT( 13 ) NOT NULL DEFAULT '0' ";
	$requests[] = " ALTER TABLE `".$table_prefix."rank_player_points` CHANGE `points` `points` BIGINT( 13 ) NOT NULL DEFAULT '0' ";
	$requests[] = " ALTER TABLE `".$table_prefix."rank_player_fleet` CHANGE `points` `points` BIGINT( 13 ) NOT NULL DEFAULT '0' ";
	$requests[] = " ALTER TABLE `".$table_prefix."rank_player_research` CHANGE `points` `points` BIGINT( 13 ) NOT NULL DEFAULT '0' ";
	
	//Modifications batiments.
	 $requests[] = "ALTER TABLE `".$table_prefix."user_building` "
		."CHANGE `M` `Ti` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `M_percentage` `Ti_percentage` SMALLINT(3) NOT NULL DEFAULT '100', "
		."CHANGE `C` `Ca` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `C_Percentage` `Ca_Percentage` SMALLINT(3) NOT NULL DEFAULT '100', "
		."CHANGE `D` `Tr` SMALLINT(2) NOT NULL DEFAULT '0',"
		."CHANGE `D_percentage` `Tr_percentage` SMALLINT(3) NOT NULL DEFAULT '100', "
		."CHANGE `CES` `CG` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `CES_percentage` `CG_percentage` SMALLINT(3) NOT NULL DEFAULT '100', "
		."CHANGE `CEF` `CaT` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `CEF_percentage` `CaT_percentage` SMALLINT(3) NOT NULL DEFAULT '100', "
		."CHANGE `UdR` `UdD` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `UdN` `UdA` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `CSp` `UA` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `HM` `STi` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `HC` `SCa` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `HD` `STr` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `Lab` `CT` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `Ter` `Ter` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `Silo` `HM` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `BaLu` `CM` SMALLINT(2) NOT NULL DEFAULT '0', "
		."DROP `Pha`, "
		."DROP `PoSa`";
	//Modifications d�fenses.
	$requests[] = "ALTER TABLE `".$table_prefix."user_defence` "
		."CHANGE `LM` `BFG` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', "
		."CHANGE `LLE` `SBFG` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', "
		."CHANGE `LLO` `PFC` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', "
		."CHANGE `CG` `DeF` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', "
		."CHANGE `AI` `PFI` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', "
		."CHANGE `LP` `AMD` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', "
		."CHANGE `PB` `CF` SMALLINT(1) NOT NULL DEFAULT '0', "
		."CHANGE `GB` `Ho` SMALLINT(1) NOT NULL DEFAULT '0', "
		."CHANGE `MIC` `CME` SMALLINT(5) NOT NULL DEFAULT '0', "
		."CHANGE `MIP` `EMP` SMALLINT(5) NOT NULL DEFAULT '0'";
		
	//Modifications technos
	$requests[] = "ALTER TABLE `".$table_prefix."user_technology` "
		."CHANGE `Esp` `Esp` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `Ordi` `Qua` SMALLINT(2) NOT NULL DEFAULT '0', "
		."ADD `Alli` SMALLINT(2) NOT NULL, "
		."ADD `SC` SMALLINT(2) NOT NULL, "
		."ADD `Raf` SMALLINT(2) NOT NULL, "
		."CHANGE `Armes` `Armes` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `Bouclier` `Bouclier` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `Protection` `Blindage` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `NRJ` `Ther` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `Hyp` `Anti` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `RC` `HD` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `RI` `Imp` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `PH` `Warp` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `Laser` `Smart` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `Ions` `Ions` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `Plasma` `Aereon` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `RRI` `Sca` SMALLINT(2) NOT NULL DEFAULT '0', "
		."CHANGE `Graviton` `Graviton` SMALLINT(2) NOT NULL DEFAULT '0', "
		."ADD `Admi` SMALLINT(2) NOT NULL, ADD `Expl` SMALLINT(2) NOT NULL, "
		."ADD `xp_mineur` SMALLINT(2) NOT NULL, "
		."ADD `xp_raideur` SMALLINT(2) NOT NULL";
		
	//Modifications nombre de galaxies
	$requests[] = "ALTER TABLE `".$table_prefix."spy` "
		."CHANGE `spy_galaxy` `spy_galaxy` SMALLINT(2) NOT NULL DEFAULT '1', "
		."CHANGE `spy_row` `spy_row` SMALLINT(2) NOT NULL DEFAULT '1'";
	$requests[] = "ALTER TABLE `".$table_prefix."user` CHANGE `user_galaxy` `user_galaxy` SMALLINT( 2 ) NOT NULL DEFAULT '1'";
	$requests[] = "ALTER TABLE `".$table_prefix."user_favorite` CHANGE `galaxy` `galaxy` SMALLINT( 2 ) NOT NULL DEFAULT '1' ";
	
	$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '".$version."' WHERE config_name = 'version'";
	
	$up_to_date = true;
	break;

	default:
	die($LANG["install_noupdateavailable"]);
}

foreach ($requests as $request) {
	$db->sql_query($request);
}
?>
	<h3 align='center'><font color='yellow'>Mise � jour du serveur UniSpy vers la version <?php echo $version;?> effectu�e avec succ�s</font></h3>
	<center>
	<b><i><?echo $LANG["install_sqlupdated"];?></i></b><br />
<?php
if ($up_to_date) {
	echo "\t"."<b><i>".$LANG["install_deleteinstall"]."</i></b><br />"."\n";
	echo "\t"."<br /><a href='../index.php'>".$LANG["install_back"]."</a>"."\n";
}
else {
	echo "\t"."<br><font color='orange'><b>".$LANG["install_notuptodate"]."</font><br />"."\n";
	echo "\t"."<a href=''>".$LANG["install_newupdate"]."</a>"."\n";
}
?>
	</center>
</body>
</html>

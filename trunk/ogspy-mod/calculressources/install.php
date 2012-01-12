<?php
/**
* install.php
* @package CalculRessources
* @author varius9
* @version 1.4
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @description Fichier d'installation du mod
*/
if (!defined('IN_SPYOGAME')) die ('Hacking attempt');

global $db, $table_prefix, $server_config;
define("TABLE_CALCULRESS_USER", $table_prefix."mod_calculress");
define("TABLE_CALCUL_BESOIN", $table_prefix."mod_calculbesoin");
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");

//Si les tables existent, on les supprime avant de les recréer
$query="DROP TABLE IF EXISTS ".TABLE_CALCULRESS_USER;
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_CALCUL_BESOIN;
$db->sql_query($query);

$query = "DELETE FROM ".TABLE_MOD." WHERE root='calculressources'";
$db->sql_query($query);
		
$is_ok = false;
$mod_folder = "calculressources";
$is_ok = install_mod ($mod_folder);

$mod_id = $db->sql_insertid(); //besoin pour callbacks
if ($is_ok == true) {
$query = "CREATE TABLE ".TABLE_CALCULRESS_USER." ("
	. " user_id INT NOT NULL default '0', "
	. " planet_id INT NOT NULL, "
	. " date_heure DATETIME NOT NULL, "
	. " metal INT NOT NULL default '0', "
	. " cristal INT NOT NULL default '0', "
	. " deut INT NOT NULL default '0',"
	. " metal1 INT NOT NULL default '0', "
	. " cristal1 INT NOT NULL default '0', "
	. " deut1 INT NOT NULL default '0',"
	. " PRIMARY KEY  (user_id, planet_id))";

$db->sql_query($query);

$query = "CREATE TABLE ".TABLE_CALCUL_BESOIN." ("
	. " id INT NOT NULL default '0', "
	. " type_construction VARCHAR(20) NOT NULL default \"\", "
	. " construction VARCHAR(20) NOT NULL default \"\", "
	. " base_metal INT NOT NULL default '0', "
	. " base_cristal INT NOT NULL default '0', "
	. " base_deut INT NOT NULL default '0',"
	. " coef FLOAT NOT NULL default '0',"
	. " PRIMARY KEY  (type_construction, construction))";

$db->sql_query($query);

$var =  "INSERT INTO ".TABLE_CALCUL_BESOIN." (id, type_construction, construction, base_metal, base_cristal, base_deut, coef) VALUES ";
$query = $var."('1','Batiment','Mine Metal','60','15','0','1.5')";
$db->sql_query($query);
$query = $var."('2','Batiment','Mine Cristal','48','24','0','1.6')";
$db->sql_query($query);
$query = $var."('3','Batiment','Deut','225','75','0','1.5')";
$db->sql_query($query);
$query = $var."('4','Batiment','Solaire','75','30','0','1.5')";
$db->sql_query($query);
$query = $var."('5','Batiment','Fusion','900','360','180','1.8')";
$db->sql_query($query);
$query = $var."('6','Batiment','Usine Robot','400','120','200','2')";
$db->sql_query($query);
$query = $var."('7','Batiment','Usine Nanites','1000000','500000','100000','2')";
$db->sql_query($query);
$query = $var."('8','Batiment','Chantier Spatial','400','200','100','2')";
$db->sql_query($query);
$query = $var."('9','Batiment','Labo recherche','200','400','200','2')";
$db->sql_query($query);
$query = $var."('10','Batiment','Terraformeur','0','50000','100000','2')";
$db->sql_query($query);
$query = $var."('11','Batiment Lune','Base Lunaire','20000','40000','20000','2')";
$db->sql_query($query);
$query = $var."('12','Batiment Lune','Phalange','20000','40000','20000','2')";
$db->sql_query($query);
$query = $var."('13','Batiment Lune','Porte Saut','2000000','4000000','2000000','2')";
$db->sql_query($query);
$query = $var."('14','Defenses','Lance Missiles','2000','0','0','1')";
$db->sql_query($query);
$query = $var."('15','Defenses','Laser leger','1500','500','0','1')";
$db->sql_query($query);
$query = $var."('16','Defenses','Laser Lourd','6000','2000','0','1')";
$db->sql_query($query);
$query = $var."('17','Defenses','Ion','2000','6000','0','1')";
$db->sql_query($query);
$query = $var."('18','Defenses','Gauss','20000','15000','2000','1')";
$db->sql_query($query);
$query = $var."('19','Defenses','Plasma','50000','50000','30000','1')";
$db->sql_query($query);
$query = $var."('20','Defenses','P Bouclier','10000','10000','0','1')";
$db->sql_query($query);
$query = $var."('21','Defenses','G Bouclier','50000','50000','0','1')";
$db->sql_query($query);
$query = $var."('22','Defenses','MI','8000','0','2000','1')";
$db->sql_query($query);
$query = $var."('23','Defenses','MIP','12500','2500','10000','1')";
$db->sql_query($query);
$query = $var."('24','Flottes','Sat Sol','0','2000','500','1')";
$db->sql_query($query);
$query = $var."('25','Flottes','Sonde','1000','0','0','1')";
$db->sql_query($query);
$query = $var."('26','Flottes','pT','2000','2000','0','1')";
$db->sql_query($query);
$query = $var."('27','Flottes','GT','6000','6000','0','1')";
$db->sql_query($query);
$query = $var."('28','Flottes','Colonisation','10000','20000','10000','1')";
$db->sql_query($query);
$query = $var."('29','Flottes','Recycleur','10000','6000','2000','1')";
$db->sql_query($query);
$query = $var."('30','Flottes','Bombardier','50000','25000','15000','1')";
$db->sql_query($query);
$query = $var."('31','Flottes','Chasseur Leger','3000','1000','0','1')";
$db->sql_query($query);
$query = $var."('32','Flottes','Chasseur Lourd','6000','4000','0','1')";
$db->sql_query($query);
$query = $var."('33','Flottes','Croiseur','20000','7000','2000','1')";
$db->sql_query($query);
$query = $var."('34','Flottes','VdB','45000','15000','0','1')";
$db->sql_query($query);
$query = $var."('35','Flottes','Destructeur','60000','50000','15000','1')";
$db->sql_query($query);
$query = $var."('36','Flottes','Traqueur','30000','40000','15000','1')";
$db->sql_query($query);
$query = $var."('37','Flottes','EDLM','5000000','4000000','1000000','1')";
$db->sql_query($query);
$query = $var."('38','Techno','Tech Espion','200','1000','200','2')";
$db->sql_query($query);
$query = $var."('39','Techno','Tech Ordi','0','400','600','2')";
$db->sql_query($query);
$query = $var."('40','Techno','Tech Armes','800','200','0','2')";
$db->sql_query($query);
$query = $var."('41','Techno','Tech Bouclier','200','600','0','2')";
$db->sql_query($query);
$query = $var."('42','Techno','Tech Coques','1000','0','0','2')";
$db->sql_query($query);
$query = $var."('43','Techno','Tech Energie','0','800','400','2')";
$db->sql_query($query);
$query = $var."('44','Techno','Tech HyperEspace','0','4000','2000','2')";
$db->sql_query($query);
$query = $var."('45','Techno','Combustion','400','0','600','2')";
$db->sql_query($query);
$query = $var."('46','Techno','Impulsion','2000','4000','600','2')";
$db->sql_query($query);
$query = $var."('47','Techno','Prop. HyperEspace','10000','20000','6000','2')";
$db->sql_query($query);
$query = $var."('48','Techno','Tech Laser','200','100','0','2')";
$db->sql_query($query);
$query = $var."('49','Techno','Tech Plasma','2000','4000','1000','2')";
$db->sql_query($query);
$query = $var."('50','Techno','Reseau','240000','400000','160000','2')";
$db->sql_query($query);

//On vérifie que la table xtense_callbacks existe (Xtense2)
		if( mysql_num_rows( mysql_query("SHOW TABLES LIKE '".$table_prefix."xtense_callbacks"."'")))
			{
				// Si oui, on récupère le n° d'id du mod
				$query = "SELECT `id` FROM `".TABLE_MOD."` WHERE `action`='calculressources' AND `active`='1' LIMIT 1";
				$result = $db->sql_query($query);
				$mod_id = $db->sql_fetch_row($result);
				$mod_id = $mod_id[0];
				// on fait du nettoyage au cas ou
				$query = "DELETE FROM `".$table_prefix."xtense_callbacks"."` WHERE `mod_id`=".$mod_id;
				$db->sql_query($query);
				// Insert les données pour récuperer les informations de la page Alliance
				$query = "INSERT INTO ".$table_prefix."xtense_callbacks"." ( `mod_id` , `function` , `type` )
				VALUES ( '".$mod_id."', 'get_overview', 'overview')";
				$db->sql_query($query);
			}
			
		
if($db->sql_numrows($result) != 0) {
	//Bonne nouvelle le mod xtense 2 est installé !
	//Maintenant on regarde s'il est dedans normalement il devrait pas mais on est jamais trop prudent...
	$query = 'Select * From '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
	$result = $db->sql_query($query);
	$nresult = $db->sql_numrows($result);
	if($nresult == 0)	{	// Il est pas dedans alors on l'ajoute :
		$query = 'INSERT INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES (mod_id, "get_overview", "overview", 1)';
		$db->sql_query($query);		
		echo("<script> alert('La compatibilité du mod eXchange avec le mod Xtense2 est installée !') </script>");}
}}
else
{
	echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
}
?>
<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}
global $db, $table_prefix;
define("TABLE_FRAME", $table_prefix."mod_frames");
$is_ok = false;
$mod_folder = "frame";
$is_ok = install_mod ($mod_folder);
//et si tu as pris la fonction boléenne faut que je rajoute sae
if ($is_ok == true)
	{
		$query = "CREATE TABLE ".TABLE_FRAME." ("
			." `id` INT( 15 ) NOT NULL AUTO_INCREMENT,"
			." `name` VARCHAR( 255 ) NOT NULL ,"
			." `url` VARCHAR( 255 ) NOT NULL ,"
			." `frame_id` INT( 15 ) NOT NULL ,"
			." `hauteur` INT( 15 ) NOT NULL DEFAULT '50' ,"
			." UNIQUE (`id`)"
			.")";
		$db->sql_query($query);
	}
else
	{
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}

?>
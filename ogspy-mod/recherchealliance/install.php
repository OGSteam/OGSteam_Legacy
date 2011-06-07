<?php
/**
* @Page principale du module
* @package rechercheAlly
* @Créateur du script Aeris
* @link http://www.ogsteam.fr
*
* @Modifier par Kazylax
* @Site internet www.kazylax.net
* @Contact kazylax-fr@hotmail.fr
*
 */
 
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db;
$is_ok = false;
$mod_folder = "recherchealliance";
$is_ok = install_mod ($mod_folder);
if ($is_ok == true)
	{
        // Si besoin de creer des tables, à faire ici
	}
else
	{
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}
?>

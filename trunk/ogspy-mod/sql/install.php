<?php
/**
* install.php Installation du module modSQL
* @package modSQL
* @author oXid_FoX
* @link http://www.ogsteam.fr
* created : 11/03/2007 10:08:10
*/


if (!defined('IN_SPYOGAME')) die('Hacking attempt');
$is_ok = false;
$mod_folder = "sql";
$is_ok = install_mod ($mod_folder);
if ($is_ok == true)
	{
		$queries = array();

		// ajout du choix d'acc�s pour les coadmins
		$queries[] = 'INSERT INTO `'.TABLE_CONFIG.'` (`config_name`, `config_value`) VALUES (\'modSQL_coadmin\', \'0\')';
		// ajout de l'option fullscreen
		$queries[] = 'INSERT INTO `'.TABLE_CONFIG.'` (`config_name`, `config_value`) VALUES (\'modSQL_fullscreen\', \'0\')';

		// ex�cution de toutes les requ�tes
		foreach ($queries as $query) 
			{
				$db->sql_query($query, false);
			}
	}
else
	{
		echo  "<script>alert('D�sol�, un probl�me a eu lieu pendant l'installation, corrigez les probl�mes survenue et r�essayez.');</script>";
	}
?>

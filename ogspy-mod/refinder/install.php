<?php
//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//D�finitions
global $db, $table_prefix;

//on ins�re les donn�es du mod, dans la table mod. Module r�serv� aux administrateurs
$is_ok = false;
$mod_folder = "refinder";
$is_ok = install_mod ($mod_folder);
if ($is_ok == true)
	{
		// On traite des donn�es si necessaire
	}
else
	{
		echo  "<script>alert('D�sol�, un probl�me a eu lieu pendant l'installation, corrigez les probl�mes survenue et r�essayez.');</script>";
	}
?>

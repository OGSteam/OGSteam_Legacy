<?php
define("IN_SPYOGAME", true);
require_once("common.php");
global $db;
$is_ok = false;
$mod_folder = "leslunes";
$is_ok = install_mod($mod_folder);
if ($is_ok == true)
	{
		//si besoin de creer des tables, � faire ici
	}
else
	{	
		echo  "<script>alert('D�sol�, un probl�me a eu lieu pendant l'installation, corrigez les probl�mes survenue et r�essayez.');</script>";
	}
?>
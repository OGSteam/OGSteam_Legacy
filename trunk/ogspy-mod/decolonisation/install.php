<?php 
if (!defined('IN_SPYOGAME')) die("Hacking Attempt!");
 
//Fichier install
$is_ok = false;
$mod_folder = "decolonisation";
$is_ok = install_mod ($mod_folder);
//et si tu as pris la fonction bol�enne faut que je rajoute sae
if ($is_ok == true)
{
             // Si besoin de creer des tables, � faire ici
}
else
{
   echo  "<script>alert('D�sol�, un probl�me a eu lieu pendant l'installation, corrigez les probl�mes survenue et r�essayez.');</script>";
}
?>
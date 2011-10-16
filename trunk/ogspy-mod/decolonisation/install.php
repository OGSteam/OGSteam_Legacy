<?php 
if (!defined('IN_SPYOGAME')) die("Hacking Attempt!");
 
//Fichier install
$is_ok = false;
$mod_folder = "decolonisation";
$is_ok = install_mod ($mod_folder);
//et si tu as pris la fonction boléenne faut que je rajoute sae
if ($is_ok == true)
{
             // Si besoin de creer des tables, à faire ici
}
else
{
   echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
}
?>
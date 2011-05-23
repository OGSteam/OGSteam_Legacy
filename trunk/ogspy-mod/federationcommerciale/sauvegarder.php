<?php
//Sécuriter
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

//on récupère les valleur du deuxième formulaire
$nb_vendeur=$_POST['nb_vendeur'];
$nb_acheteur=$_POST['nb_acheteur'];
$pseudo_vendeur=$_POST['pseudo_vendeur'];
$pseudo_acheteur=$_POST['pseudo_acheteur'];
$metal_vendeur=$_POST['metal_vendeur'];
$cristal_vendeur=$_POST['cristal_vendeur'];
$deuterium_vendeur=$_POST['deuterium_vendeur'];
$metal_acheteur=$_POST['metal_acheteur'];
$cristal_acheteur=$_POST['cristal_acheteur'];
$deuterium_acheteur=$_POST['deuterium_acheteur'];
$M_taux=$_POST['M_taux'];
$C_taux=$_POST['C_taux'];
$D_taux=$_POST['D_taux'];

sauvegarde($nb_vendeur, $nb_acheteur, $M_taux, $C_taux, $D_taux, $pseudo_vendeur, $pseudo_acheteur, $metal_vendeur, $cristal_vendeur ,$deuterium_vendeur, $metal_acheteur, $cristal_acheteur ,$deuterium_acheteur);

require_once("pieddepage.php");
?>
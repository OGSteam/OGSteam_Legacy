<?php
define("IN_SPYOGAME", true);
require_once("common.php");
// naq_ogsplugmod
require_once("mod/naq_ogsplugin/ogsplugincl.php");
require_once("ogsplugmod_func.php");

global $server_config, $user_data;

$mod_coadmin_const=2;

//----- petit nettoyage de printemps

$query = "DELETE FROM ".TABLE_MOD." WHERE action='naq_ogsplugin'";
$db->sql_query($query);

//******************************************************************************
//Appel des fichiers linguistiques
// déplacement avant include autres script, nécessaire pour help.php

if (!empty($user_data['user_language'])) {
	include_once("mod/naq_ogsplugin/ogsplugin_lang_".$user_data['user_language'].".php"); 
} else require_once("mod/naq_ogsplugin/ogsplugin_lang_french.php"); //Fichier anglais en premier dans le but d'avoir au moins une traduction anglaise si elle n'est pas disponible dans la langue désirée

//******************************************************************************

//----------------------------------------------------------------

if (strcasecmp($server_config["version"],"3.10")>=0) {
   $ogsplugin_tooltip = "<font color=\"white\">Module d&#39;administration du module OGS Plugin  v".OGP_MODULE_VERSION." pour OGSpy 3.02c/UniSpy 3.1</font>";


   $query = "INSERT IGNORE INTO ".TABLE_MOD." ( title, menu, action, menupos, tooltip, dateinstall, noticeifnew, catuser,  root, link, version, active) VALUES ('OGS Plugin MOD','OGS Plugin','naq_ogsplugin', 3, '".addslashes($ogsplugin_tooltip)."', ".time().", 1, $mod_coadmin_const ,'naq_ogsplugin','ogsplugmod.php','".OGP_MODULE_VERSION."','1')";
   
} elseif(strcasecmp($server_config["version"],"3.02c")<=0 || strcasecmp($server_config["version"],"3.03")<=0 || strcasecmp($server_config["version"],"3.04"<=0) || strcasecmp($server_config["version"],"3.04b")<=0)
$query = "INSERT IGNORE INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','OGS Plugin MOD','OGS Plugin','naq_ogsplugin','naq_ogsplugin','ogsplugmod.php','".OGP_MODULE_VERSION."','1')";

$db->sql_query($query, false, false); // ne pas abandonner en cas d'erreur, ni journaliser


//---------------------

# Si version hors 3.1, création des Tables pour la structure de recensement des fonctions d'importation
// désactivé !! : la création de la table n'a plus d'intérêt à ce jour
 /*if (strcasecmp($server_config["version"],"3.10")<0) OGP_CreatePlugModsTable(); */

clearstatcache(); // effacer le cache concernant l'existence et droits de fichiers/dossiers

// création par défaut des valeurs de base des options du panneau d'options
OGP_CheckVarsInsideDB();

# Copie du script de liaison à la racine du serveur OGSPY
ogsmod_copyogsplugin();

# Création du répertoire pour les fichiers débug si inexistant
ogsmod_createdebugdir();

 ?>
 <script>
alert("L'installation du MOD OGS Plugin v<?php echo OGP_MODULE_VERSION; ?> est normallement terminée.\n\n"+
"Pensez d'abord à configurer les droits OGS (import./export.) de vos groupes d'utitisateurs\n"+
"puis à vous rendre sur la page d'administration du module [OGS Plugin(admin)] pour configurer les options nécessaires:\n"+
"_ nom de serveur Ogame et numéro d'univers\n"+
"_ les TAGS d'alliances pour la surbrillance(diplomatie)\n"+
"_ les autres options que vous jugerez nécessaires ou pertinentes");
</script>

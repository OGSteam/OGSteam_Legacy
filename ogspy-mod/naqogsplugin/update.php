<?php
// met à jour la version du module
define("IN_SPYOGAME", true);
require_once("common.php");
require_once("mod/naq_ogsplugin/ogsplugincl.php");
require_once("ogsplugmod_func.php");

/* mise à jour de la version du module */
global $ogsplugin_menutooltip;
if (strcasecmp($server_config["version"],"3.10")>=0 || defined("SERVER_IS_UNISPY")) {
    $query = "UPDATE ".TABLE_MOD." SET menupos=3, tooltip='".addslashes($ogsplugin_menutooltip)."', version='".OGP_MODULE_VERSION."', menu='OGS Plugin' WHERE action='naq_ogsplugin'";
    $db->sql_query($query);
} else {
    $query = "UPDATE ".TABLE_MOD." SET version='".OGP_MODULE_VERSION."', menu='OGS Plugin' WHERE action='naq_ogsplugin'";
    $db->sql_query($query);
}

//-------------------------------------------------------------------------------------------------

 OGP_CheckVarsInsideDB();


clearstatcache(); // effacer le cache concernant l'existence et droits de fichiers/dossiers

//-----------------------------------------------------------------------------------------------
# Copie du script de liaison à la racine du serveur OGSPY
ogsmod_copyogsplugin();

# Création du répertoire pour les fichiers débug si inexistant
ogsmod_createdebugdir();

?>

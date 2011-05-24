<?php
/** $Id$ **/
/**
* install.php Fichier d'installation
* @package [MOD] AutoUpdate
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 1.0c
* created	: 27/10/2006
* modified	: 18/01/2007
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}
// Ajout du module dans la table des mod de OGSpy
$mod_folder = "autoupdate";
install_mod($mod_folder);
?>

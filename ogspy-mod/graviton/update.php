<?php

/**
* update.php Fichier de mise à jour du MOD Graviton
* @package MOD Graviton
* @author Kal Nightmare
* @link http://www.ogsteam.fr
*/


if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

$mod_folder = "graviton";
$mod_name = "graviton";
update_mod($mod_folder, $mod_name);

?>
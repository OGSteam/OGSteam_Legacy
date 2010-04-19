<?php
/**
 * footer.php 

Pied de page

 * @package QuiMSonde
 * @author Sylar
 * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08

 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
global $mod_name;
//On récupère la version actuel du mod   
$version=get_QMS_version();
$link_quimobserve = "'";
$link_quimsonde = "'";
echo "\n\n<!-- Pied de Page  -->\n";
echo sprintf($lang['qms_footer'],$mod_name,$version);
echo "\n\n<!-- FIN de QUIMSONDE -->\n";
?>
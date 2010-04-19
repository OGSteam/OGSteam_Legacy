<?php
/**
* sog_admin.php : Page d'administration du mod
* @author tsyr2ko <tsyr2ko-sogsrov@yahoo.fr>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @version 0.4
* @package Sogsrov
*/

if (!defined('IN_SOGSROV')) die("Hacking attempt");

/**
* Affichage des options d'administration du mod
* @return string Renvoit une chaîne contenant tout le bloc d'administration
*/
function AfficheAdmin() {
   global $lang, $config;
   $sp = '      ';
   
   $output = $sp . "<!-- Bloc d'administration -->\n";
   $output .= $sp . "<td align=\"center\" class=\"b\">\n";
   $output .= $sp . '   <big><b>' . $lang['admin.title'] . "</b></big>\n";
   $output .= $sp . "   <br /><br /><br />\n";
   $output .= $sp . '   <input type="checkbox" id="restrict_re"';
   $output .= ' value="' . $config['sog_restrict_re'] . '"';
   $output .= (($config['sog_restrict_re'] == "1") ? ' checked="checked"' : '') . ">\n";
   $output .= $sp . "   <label for=\"restrict_re\">\n";
   $output .= $sp . '      ' . $lang['admin.restrict_re'] . "\n";
   $output .= $sp . "   </label>\n";
   $output .= $sp . "<br /><br />\n";
   $output .= $sp . "</td>\n";
   $output .= $sp . "<td classe=\"b\"><div id=\"response\"></div></td>\n";
   $output .= $sp . "<!-- Fin du bloc d'administration -->\n";
   
   return ($output);
}

/**
* Vérification si l'utilisateur a le droit d'accéder à l'administration du mod
*/
if (IsAdmin()) {
   echo AfficheAdmin();
}
else {
   echo $lang['admin.error'] . "\n";
}

?>
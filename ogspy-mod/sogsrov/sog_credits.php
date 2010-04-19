<?php
/**
* sog_credits.php : Page affichant les crédits
* @author tsyr2ko <tsyr2ko-sogsrov@yahoo.fr>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @version 0.4
* @package Sogsrov
*/

if (!defined('IN_SOGSROV')) die("Hacking attempt");

/**
* Affichage des crédits avec lien vers forum et mail
* @return string Renvoit une chaîne contenant le bloc des crédits
*/
function AfficheCredits() {
   global $lang;
   $sp = '         ';
   $topic = 'http://www.ogsteam.fr/forums/';
   $mail = 'tsyr2ko-sogsrov@yahoo.fr';

   $output = $sp . "<!-- Bloc de crédits -->\n";
   $output .= $sp . "<table>\n";
   $output .= $sp . "   <tr align=\"center\">\n";
   $output .= $sp . "      <td align=\"center\" class=\"b\" width=\"50%\">\n";
   $output .= $sp . '         <big><b>' . $lang['credits'] . "</b></big><br />\n";
   $output .= $sp . "         <br />\n";
   $output .= $sp . '         <a href="' . $topic . "\" target=\"_blank\">SOGSROV</a>\n";
   $output .= $sp . '         ' . sprintf($lang['credits.version'], GetVersion()) . "\n";
   $output .= $sp . '         <a href="mailto:' . $mail . "\">tsyr2ko</a><br />\n";
   $output .= $sp . "         <br />\n";
   $output .= $sp . '         ' . $lang['credits.more_info'] . "\n";
   $output .= $sp . '         <a href="' . $topic . "\" target=\"_blank\">\n";
   $output .= $sp . '            ' . $lang['credits.board'] . "\n";
   $output .= $sp . "         </a><br />\n";
   $output .= $sp . "         <br />\n";
   $output .= $sp . "      </td>\n";
   $output .= $sp . "   </tr>\n";
   $output .= $sp . "</table>\n";
   $output .= $sp . "<!-- Fin du bloc de crédits -->\n";
   
   return ($output);
}

/**
* Affichage des informations sur la version originale par StalkR
* @return string Renvoit une chaîne contenant le bloc de remerciements
*/
function AfficheRemerciements() {
   global $lang;
   $sp = '         ';
   $topic = 'http://stalkr.net/forum/viewtopic.php?t=2327';

   $output = $sp . "<!-- Bloc de remerciement à Stalkr -->\n";
   $output .= $sp . "<table>\n";
   $output .= $sp . "   <tr align=\"center\">\n";
   $output .= $sp . "      <td align=\"center\" class=\"b\" width=\"50%\">\n";
   $output .= $sp . "         <big><b>Sogsrov</b></big><br />\n";
   $output .= $sp . "         <br />\n";
   $output .= $sp . '         ' . $lang['credits.create_by'] . "<br />\n";
   $output .= $sp . "         <br />\n";
   $output .= $sp . '         ' . $lang['credits.update'] . "<br />\n";
   $output .= $sp . '         ' . $lang['credits.official_version'] . "\n";
   $output .= $sp . '         <a href="' . $topic . "\" target=\"_blank\">\n";
   $output .= $sp . '            ' . $lang['credits.here'] . "\n";
   $output .= $sp . "         </a><br />\n";
   $output .= $sp . "         <br />\n";
   $output .= $sp . "      </td>\n";
   $output .= $sp . "   </tr>\n";
   $output .= $sp . "</table>\n";
   $output .= $sp . "<!-- Fin du bloc de remerciement -->\n";
   
   return ($output);
}

echo "      <td>\n";
echo AfficheCredits();
echo "         <br /><br />\n";
echo AfficheRemerciements();
echo "      </td>\n";

?>
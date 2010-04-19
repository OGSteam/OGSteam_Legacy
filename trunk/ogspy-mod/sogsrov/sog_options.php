<?php
/**
* sog_options.php : Page regroupant les options du module
* @author tsyr2ko <tsyr2ko-sogsrov@yahoo.fr>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @version 0.4
* @package Sogsrov
*/

if (!defined('IN_SOGSROV')) die("Hacking attempt");

/**
* Génère le <tr> pour une option de type 'text'
* @param string $key Option devant être affichée
* @return string Renvoie une chaîne contenant la ligne <tr> à afficher
*/
function MakeTextInput($key) {
   global $lang, $config;

   $output = '<!-- Text input for ' . $key . ' //-->
            <tr>
               <td align="center">
                  ' . $lang['options.' . $key] . '
               </td>
               <td align="center">
                  <input type="text" id="' . $key . '" size="10" value="' . $config[$key] . '"
                     onBlur="update_conf(\'options\', \'' . $key . '\');" />
               </td>
            </tr>
            <!-- End of text input //-->';

   return ($output);
}

/**
* Génère le <tr> pour le select des langues
* @return string Renvoie une chaîne contenant la ligne <tr> des langues
*/
function MakeLangSelect() {
   global $lang, $config;

   $output = '<!-- Lang select //-->
            <tr>
               <td align="center">
                  ' . $lang['options.language'] . '
               </td>
               <td align="center">
                  <select id="language" onChange="update_conf(\'options\', \'language\');">';
   
   $languages = GetAvailableLanguage();
   foreach ($languages as $language)
   {
      $output .= '
                     <option value="' . $language . '" ';
      if ($config['language'] == $language) { $output .= 'selected="selected" '; }
      $output .= '/>' . $language;
   }
   $output .= '
                  </select>
               </td>
            </tr>
            <!-- End of lang select //-->';

   return ($output);
}

/**
* Génère le <tr> pour le select du tri
* @return string Renvoie une chaîne contenant la ligne <tr> du tri
*/
function MakeOrderBySelect() {
   global $lang, $config;
   $tab_order = array(
      'm' => 'metal',
      'c' => 'crystal',
      'd' => 'deuterium',
      'e' => 'energy',
      't' => 'total',
      'p' => 'position',
      'y' => 'priority'
   );
   
   $output = '<!-- Order By select //-->
            <tr>
               <td align="center">
                  ' . $lang['options.order_by'] . '
               </td>
               <td align="center">
                  <select id="order_by" onChange="update_conf(\'options\', \'order_by\');">';
   
   foreach ($tab_order as $letter => $order)
   {
      $output .= '
                     <option value="' . $letter . '" ' . 
                     (($config['order_by'] == $letter) ? 'selected="selected" ' : '') .
                     '/>' . $lang['options.order_by_' . $order];
   }
   $output .= '
                  </select>
               </td>
            </tr>
            <!-- End of order by select //-->';

   return ($output);
}

/**
*
*/
function AfficheOptions() {
   global $lang, $config;
   
   $output = '
      <!-- Bloc des préférences d\'affichage -->
      <td align="center" class="b">
         <big><b>' . $lang['options.pref'] . '</b></big>
         <br /><br /><br />
         <table align="center" width="100%">
            <tr>
               <td align="center">' . $lang['options.menu'] . '</td>
               <td align="center">
                  <select id="menu_disp" onChange="update_conf(\'options\', \'menu_disp\');">
                     <option value="0" ' .
                     (($config['menu_disp'] == 0) ? 'selected="selected" ' : '') .
                     '/>' . $lang['options.left'] . '
                     <option value="1" ' .
                     (($config['menu_disp'] == 1) ? 'selected="selected" ' : '') .
                     '/>' . $lang['options.right'] . '
                  </select>
               </td>
            </tr>
            ' . MakeTextInput('reports_per_page') . '
            ' . MakeLangSelect() . '
            ' . MakeTextInput('default_color') . '
            ' . MakeTextInput('critical_limit_color') . '
            ' . MakeTextInput('moon_color') . '
            ' . MakeTextInput('low_priority_color') . '
            ' . MakeTextInput('normal_priority_color') . '
            ' . MakeTextInput('high_priority_color') . '
            ' . MakeTextInput('min_metal') . '
            ' . MakeTextInput('min_crystal') . '
            ' . MakeTextInput('min_deuterium') . '
            ' . MakeTextInput('min_energy') . '
            ' . MakeTextInput('min_fleet') . '
            ' . MakeTextInput('min_defense') . '
            ' . MakeTextInput('min_buildings') . '
            ' . MakeTextInput('min_research') . '
            ' . MakeOrderBySelect() . '
            <!-- Load default values button //-->
            <tr>
               <td align="center" colspan="2">
                  <br /><br />
                  <input type="button" value="' . $lang['options.default'] . '">
               </td>
            </tr>
            <!-- End of default values button //-->
         </table>
         <br /><br />
      </td>
      <!-- Fin du bloc des préférences d\'affichage -->
';

   return ($output);
}

echo AfficheOptions();

?>
<?php
/**
* sogsrov.php : Fichier principal du module SOGSROV
* @author tsyr2ko <tsyr2ko-sogsrov@yahoo.fr>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @version 0.4
* @package Sogsrov
*/

/**
* Vérification de sécurité
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$result = $db->sql_query("SELECT root FROM " . TABLE_MOD . " WHERE `action` = 'sogsrov'";
list($dirmod) = $db->sql_fetch_row($result);

require_once("./mod/" . $dirmod . "/sog_inc.php");

/**
* Gestion des fichiers de langue
*/
$files_lang = GetAvailableLanguage();

if (is_file("mod/" . $dirmod . "/sog_lang_" . $config['language'] . ".php"))
	require_once("mod/" . $dirmod . "/sog_lang_" . $config['language'] . ".php");
elseif (is_file("mod/" . $dirmod . "/sog_lang_" . $files_lang[0] . ".php"))
	require_once("mod/" . $dirmod . "/sog_lang_" . $files_lang[0] . ".php");
else
   die("Error! No language file to load (file /mod/" . $dirmod . "/sog_lang_XX.php missing)");

unset($files_lang);

/**
* Gestion des utilisateurs ayant accès au mod (fortement inspiré du code de ben.12)
*/
if (!IsAdmin()) {
   $request = "SELECT group_id FROM " . TABLE_GROUP . " WHERE group_name='sogsrov'";
   $result = $db->sql_query($request);
   
   if (list($group_id) = $db->sql_fetch_row($result)) {
      $request = "SELECT COUNT(*) FROM " . TABLE_USER_GROUP;
      $request .=  " WHERE group_id=" . $group_id . " AND user_id=" . $user_data['user_id'];
      $result = $db->sql_query($request);
      list($row) = $db->sql_fetch_row($result);
      if($row == 0) redirection("index.php?action=message&id_message=forbidden&info");
   }
}

/**
* Chargement du menu de OGSpy
*/
require_once("views/page_header.php");

echo '

<!-- Début du code du Module SOGSROV -->

<script language="javascript" type="text/javascript" src="./mod/' . $dirmod . '/sog_xmlhttprequest.js"></script>

<!-- code du menu (fonction DisplayMenu) -->
' . DisplayMenu() . '
<!-- fin du menu -->

<br /><br />
<table width="50%">
   <tr align="center">
';

if (!IsActive()) {
   echo '
      <td>
         <center>
            <font size="2">
               Le mod est actuellement désactivé.<br />
               Adressez-vous à l\'administrateur du serveur OGSpy.
            </font>
         </center>
      </td>';
}
else {
   switch ($pub_subaction) {
      case "main" : require_once("sog_main.php"); break;
      case "options" : require_once("sog_options.php"); break;
      case "admin" : require_once("sog_admin.php"); break;
      case "credits" : require_once("sog_credits.php"); break;
      default : require_once("sog_main.php"); break;
   }
}
echo '   </tr>
</table>

<!-- Fin du Module SOGSROV -->

';

require_once("views/page_tail.php");

?>
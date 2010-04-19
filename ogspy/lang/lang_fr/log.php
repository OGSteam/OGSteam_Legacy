<?php
// Log
$lang['inclog_paramserv'] = '[admin] %s modifie les param&egrave;tres du serveur';  // %s = admin nickname
$lang['inclog_paramdisplayserv'] = '[admin] %s modifie les param&egrave;tres d\'affichage du serveur';  // %s = admin nickname
$lang['inclog_changesizegala'] = '[admin] %1$s modifie la taille de l\'univers sa nouvelle taille est %2$i galaxies et %3$i syst&egrave;mes.'; // %1$s = admin nickname ; %2$i = galaxy count ; %3$i = system count
$lang['inclog_InstallMod'] = '[admin] %1$s installe le mod &quot;%2$s&quot;'; // %1$s = Admin nickname ; %2$s = mod name
$lang['inclog_UpdateMod'] = '[admin] %1$s met à jour le mod &quot;%2$s&quot;';  // %1$s = Admin nickname ; %2$s = mod name
$lang['inclog_RemoveMod'] = '[admin] %1$s d&eacute;sinstalle le mod &quot;%2$s&quot;';  // %1$s = Admin nickname ; %2$s = mod name
$lang['inclog_OnMod'] = '[admin] %1$s active le mod &quot;%2$s&quot;';  // %1$s = Admin nickname ; %2$s = mod name
$lang['inclog_OffMod'] = '[admin] %1$s d&eacute;sactive le mod &quot;%2$s&quot;';  // %1$s = Admin nickname ; %2$s = mod name
$lang['inclog_RepoMod'] = '[admin] %1$s repositionne le mod &quot;%2$s&quot;';  // %1$s = Admin nickname ; %2$s = mod name
$lang['inclog_DisplayMod'] = '[admin] %1$s affiche le mod &quot;%2$s&quot; aux utilisateurs normaux.';   // %1$s = Admin nickname ; %2$s = mod name
$lang['inclog_HideMod'] = '[admin] %1$s cache le mod &quot;%2$s&quot; aux utilisateurs normaux.';   // %1$s = Admin nickname ; %2$s = mod name
$lang['inclog_Mod_Rename'] = '[admin] %1$s change le texte menu du mod &quot;%2$s&quot;';  // %1$s = Admin nickname ; %2$s = mod name
$lang['inclog_Mod_admin_link'] = '[admin] %1$s change le lien admin du mod &quot;%2$s&quot;';  // %1$s = Admin nickname ; %2$s = mod name

$lang['inclog_Cat_AddMod'] = '[admin] %1$s ajoute le mod &quot;%2$s&quot; à la cat&eacute;gorie &quot;%3$s&quot;'; // %1$s = Admin nickname ; %2$s = mod name ; %3$s category name
$lang['inclog_Cat_RemMod'] = '[admin] %1$s supprime le mod &quot;%2$s&quot; des cat&eacute;gories'; // %1$s = Admin nickname ; %2$s = mod name
$lang['inclog_Cat_Create'] = '[admin] %1$s cr&eacute;e la cat&eacute;gorie &quot;%2$s&quot;'; // %1$s = Admin nickname ; %2$s =cat name
$lang['inclog_Cat_Delete'] = '[admin] %1$s efface la cat&eacute;gorie &quot;%2$s&quot;'; // %1$s = Admin nickname ; %2$s = cat name
$lang['inclog_Cat_Order'] = '[admin] %1$s repositionne la cat&eacute;gorie &quot;%2$s&quot;';  // %1$s = Admin nickname ; %2$s = cat name
$lang['inclog_Cat_Rename'] = '[admin] %1$s change le texte menu de la cat&eacute;gorie &quot;%2$s&quot;';  // %1$s = Admin nickname ; %2$s = cat name

$lang['inclog_LoadSysSol'] = '%1$s charge le syst&egrave;me solaire %2$s';   // %1$s = Member nickname ; %2$s = System position
$lang['inclog_load_system_OGS'] = '%1$s charge %2$i plan&egrave;tes via Xtense² : insertion(%3$i), mise à jour(%4$i), obsol&egrave;te(%5$i), &eacute;chec(%6$i) - %7$i sec'; // %1 : member name, %2, %3, %4, %5, %6 = option 0 to 5 from Xtense² (insert count, update count, outdate count, fail count, time)
$lang['inclog_get_galaxy_OGS'] = '%1$s r&eacute;cup&egrave;re les plan&egrave;tes de la galaxie %2$s';
$lang['inclog_get_universe_OGS'] = '%s r&eacute;cup&egrave;re toutes les plan&egrave;tes de l\'univers';
$lang['inclog_load_spy'] = '%1$s charge %2$s rapport(s) d\'espionnage'; // %1 = player name ; %2 = spy count
$lang['inclog_load_rc'] = '%1$s charge le rapport de combat #%2$s '; // %1 = player name ; %2 = rc count
$lang['inclog_delete_rc'] = '%1$s efface le rapport de combat #%2$s'; // %1 = player name ; %2 = rc number
$lang['inclog_load_spy_OGS'] = '%1$s charge %2$s rapport(s) d\'espionnage via Xtense²'; // %1 = player name ; %2 = spy count
$lang['inclog_export_spy_sector'] = '%1$s r&eacute;cup&egrave;re %2$i rapport(s) d\'espionnage du syst&egrave;me [%3$s]'; // %1 player name, %2 spy count, %3 position.
$lang['inclog_export_spy_date'] = '%1$s r&eacute;cup&egrave;re %2$i rapport(s) d\'espionnage post&eacute;rieur au %3$s'; // %1 player name, %2 spy count, %3 date
$lang['inclog_mysql_error'] = 'Erreur critique mysql - Req : %1$s - Erreur n°%2$i %3$s'; // %1 requet, %2 error num, %3 ??
$lang['inclog_login'] = '%s se connecte'; // %s player name
$lang['inclog_login_ogs'] = '%s se connecte via Xtense²'; // %s player name
$lang['inclog_logout'] = '%s se d&eacute;connecte'; // %s player name
$lang['inclog_modify_account'] = '%s change son profil'; // player name
$lang['inclog_modify_account_admin'] = '[admin] %1$s change le profil de %2$s'; // %1 admin name, %2 player name
$lang['inclog_create_account'] = '[admin] %1$s cr&eacute;&eacute; le compte de %2$s';
$lang['inclog_regeneratepwd'] = '[admin] %1$s g&eacute;n&egrave;re un nouveau mot de passe pour %2$s';
$lang['inclog_delete_account'] = '[admin] %1$s supprime le compte de %2$s';
$lang['inclog_create_usergroup'] = '[admin] %1$s cr&eacute;&eacute; le groupe %2$s';
$lang['inclog_modify_usergroup'] = '[admin] %1$s modifie les param&egrave;tres du groupe %2$s';
$lang['inclog_delete_usergroup'] = '[admin] %1$s supprime le groupe %2$s';
$lang['inclog_add_usergroup'] = '[admin] %1$s ajoute %2$s dans le groupe %3$s';
$lang['inclog_del_usergroup'] = '[admin] %1$s supprime %2$s du groupe %3$s';
$lang['inclog_WebServ'] = 'serveur web';
$lang['inclog_sendHighscore'] = '%1$s envoie le classement %2$s du %3$s via %4$s [%5$i lignes]'; // %1 playername, %2 type of rank, %3 date, %4 web or ogs, %5 count
$lang['inclog_recoverHighscore'] = '%1$s r&eacute;cup&egrave;re le classement %2$s du %3$s'; // %1 playername,  %2 type of rank, %3 date
$lang['inclog_check_var'] = '%1$s envoie des donn&eacute;es refus&eacute;es par le contr&ocirc;leur : %2$s'; // %1 playername, %2 refused data
$lang['inclog_Err_LogFile'] = 'Erreur appel fichier log - ';
$lang['inclog_local_undefined'] = 'Texte introuvable \'%1$s\'. (Pack [%2$s] Langue [%3$s] - Fichier \'%4$s.php\').';
$lang['inclog_local_file_missing'] = 'Fichier de language introuvable : &quot;%s&quot;';
$lang['inclog_local_pack_missing'] = 'Pack de language [%1$s] introuvable pour [%2$s]';

?>

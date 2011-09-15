<?php
/***************************************************************************
*	filename	: Adv_functions.php
*	desc.		: AdvSpy, mod for OGSpy.
*	Author		: kilops - http://ogs.servebbs.net/
*	created		: 16/08/2006
***************************************************************************/

// Déclarations OgSpy
if (!defined('IN_SPYOGAME'))
    die("Hacking attempt");
if (!defined('IN_MOD_ADVSPY'))
    die("Hacking attempt");


// compatibilité php4/php5 pour stripos
// merci à rchillet at hotmail dot com
// http://php.net/stripos
if (!function_exists("stripos")) {
    function stripos($str, $needle, $offset = 0)
    {
        return strpos(strtolower($str), strtolower($needle), $offset);
    }
}

$BlockRecherche = array();

function AdvSpy_START()
{
    global $AdvSpyConfig, $lang, $BlockRecherche, $user_data, $db;

    //on charge les variables d'environement Ogspy dans AdvSpy.
    $AdvSpyConfig['User_Empire'] = user_get_empire();
	$AdvSpyConfig['User_Data'] = $user_data;

    $AdvSpyConfig['UserIsAdmin'] = 0;
    if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1)
        $AdvSpyConfig['UserIsAdmin'] = 1;


    //$AdvSpyConfig['UserIsAdmin']=0;

    $request = "SELECT * FROM " . TABLE_CONFIG . " WHERE 1;";
    $result = $db->sql_query($request);
    while ($val = @mysql_fetch_assoc($result)) {
        $AdvSpyConfig['OgspyConfig'][$val['config_name']] = $val['config_value'];
    }
    unset($result);

    $AdvSpyConfig['Current']['PrintedIdList'] = array();

    //autoconfiguration galaxie/system max
    if (@$AdvSpyConfig['OgspyConfig']['num_of_galaxies']) {
        $AdvSpyConfig['Settings']['OgameUniverse_Galaxy_Max'] = $AdvSpyConfig['OgspyConfig']['num_of_galaxies'];
    }
    if (@$AdvSpyConfig['OgspyConfig']['num_of_systems']) {
        $AdvSpyConfig['Settings']['OgameUniverse_System_Max'] = $AdvSpyConfig['OgspyConfig']['num_of_systems'];
    }


    //on re-attribue les valeurs qui vont bien, meme si du coup on le fais 2 fois (adv_config.php)
    // car on vien de lire les 'veritables' valeures de galaxy_max et system_max dans la config ogspy (si elles existent)
    // du coup on re définis les verifications de sécurité.
    $lang['BlockRechercheElements']['AdvSpy_GalaxyMin']['Type'] =
        'integer 1 ' . $AdvSpyConfig['Settings']['OgameUniverse_Galaxy_Max'];
    $lang['BlockRechercheElements']['AdvSpy_GalaxyMax']['Type'] =
        'integer 1 ' . $AdvSpyConfig['Settings']['OgameUniverse_Galaxy_Max'];
    $lang['BlockRechercheElements']['AdvSpy_SystemMin']['Type'] =
        'integer 1 ' . $AdvSpyConfig['Settings']['OgameUniverse_System_Max'];
    $lang['BlockRechercheElements']['AdvSpy_SystemMax']['Type'] =
        'integer 1 ' . $AdvSpyConfig['Settings']['OgameUniverse_System_Max'];


    /*
    $universxtense1='';
    $universxtense1=@mod_get_option('xtense_ogsplugin_numuniv');
    $universxtense2='';
    if (isset($AdvSpyConfig['OgspyConfig']['xtense2_univers'])) { $universxtense2=$AdvSpyConfig['OgspyConfig']['xtense2_univers']; }
    */
    //mod_set_option("AdvSpy_opt",$optionvalue,'AdvSpy');
    //foreach($lang['Options'] as $OptionVar=>$props){
    //	$lang['Options'][$OptionVar]['Value_User']=FALSE;
    //	$lang['Options'][$OptionVar]['Value_Admin']=FALSE;
    //}


	// la partie chargement des "Options" à faire relativement tôt
	$Current_Edition_Target=-1;
	if ((array_key_exists('AdvSpy_OptionsTarget',$_POST)) AND ($AdvSpyConfig['UserIsAdmin']) ) {
		if (is_numeric($_POST['AdvSpy_OptionsTarget'])) { $Current_Edition_Target=$_POST['AdvSpy_OptionsTarget']; }
	}


	AdvSpy_Options_ImportFromDB($Current_Edition_Target);
	if (isset($_POST['ChercherOK']))
	{
		if ($_POST['ChercherOK']==$lang['UI_Lang']['BT_OptSubmit']) {
			AdvSpy_Options_ReadPostedOptions();
			AdvSpy_Options_ExportToDB($Current_Edition_Target);
		}
	}


    // On fais l'évaluation des POST maintenant : Total de l'ensemble des criteres de recherche (et de tris, de simulation...)
    $BlockRecherche = AdvSpy_CalcBlockRechercheFromPosts(AdvSpy_GetBlankBlockRecherche());


    // Un peut de javascript pour plus tard ...
    AdvSpy_PrintHtml_JavaScript_StaticFunctions();
    // On affiche le debut du tableau général pour mettre le menu à gauche.
    AdvSpy_PrintHtml_Header();


    if (($BlockRecherche['ChercherOK'] == "-- LOAD --") and ($BlockRecherche['AdvSpy_SaveIdToLoad'])) {
        AdvSpy_log("Chargement d'une sauvegarde (" . $BlockRecherche['AdvSpy_SaveIdToLoad'] .
            ")");
        $BlockRecherche = AdvSpy_SaveLoad_GetLoadedBlockRecherche($BlockRecherche['AdvSpy_SaveIdToLoad'],
            $BlockRecherche);
    }
    if (isset($pub_ForceDefaultSavesInstallation))
        if (($pub_ForceDefaultSavesInstallation == "ON") && ($AdvSpyConfig['UserIsAdmin'])) {
            include $AdvSpyConfig['Settings']['AdvSpy_BasePath'] . "Adv_DefaultSaves.php";
            $db->sql_query(AdvSpy_Config_GetSqlOfDefaultSaves($AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad']));
        }


    // Contribution d'ericc pour avoir un fond grisé pour une meilleure lisibilité =)

    if (is_numeric(AdvSpy_Options_GetValue('BackgroundOpacity'))) {
        $opacity = AdvSpy_Options_GetValue('BackgroundOpacity');
    } else {
        $opacity = 50;
    }

    $opacity100 = $opacity / 100;

    print "\n\n<style type=\"text/css\">
/*This is where the magic happens!*/
div.box {
     border: 0px solid #000000;
     position: relative;
     width: 100%;
}
div.box_contents {
     background-color:transparent;
     height: 100%;
     position: relative;
     width: 100%;
     z-index: 101;
}
div.box_background {
     background-color: black;
     height: 100%;
     filter:alpha(opacity=$opacity); /* IE's opacity*/
     left: 0px;
     opacity: $opacity100;
     position: absolute;
     top: 0px;
     width: 100%;
     z-index: 99;
}
</style>\n\n";

    print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
    print AdvSpy_PrintHtml_Menu_Tris();
    print "</div></div>";
    print AdvSpy_GetHtml_SubmitBT();

    print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
    print AdvSpy_PrintHtml_Menu_Secteur();
    print "</div></div>";
    print AdvSpy_GetHtml_SubmitBT();

    print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
    print AdvSpy_PrintHtml_Menu_RE();
    print "</div></div>";
    print AdvSpy_GetHtml_SubmitBT();

    print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
    print AdvSpy_PrintHtml_Menu_Player();
    print "</div></div>";
    print AdvSpy_GetHtml_SubmitBT();

    print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
    print AdvSpy_PrintHtml_Menu_Ressources();
    print "</div></div>";
    print AdvSpy_GetHtml_SubmitBT();

    print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
    print AdvSpy_PrintHtml_Menu_Analyses();
    print "</div></div>";
    print AdvSpy_GetHtml_SubmitBT();


    //print AdvSpy_GetHtml_SubmitBT();
    print AdvSpy_PrintHtml_Menu_FIN();

    print "<td align=\"left\" valign=\"top\">";


    // Corps des elements du menu

    $StyleInvisible = "style=\"visibility:hidden;display:none;\"";
    $StyleVisible = "style=\"visibility:visible;display:'';\"";

    $StyleOf_Frontpage = $StyleInvisible;
    $StyleOf_Resultat = $StyleInvisible;
    $StyleOf_Simulateur = $StyleInvisible;
    $StyleOf_Statistiques = $StyleInvisible;
    $StyleOf_Options = $StyleInvisible;
    $StyleOf_Administration = $StyleInvisible;
    $StyleOf_SaveLoad = $StyleInvisible;


    $AdvSpy_ActiveTab = 'AdvSpy_DivFrontPage';
    if ($BlockRecherche['ChercherOK'] == $lang['UI_Lang']['BT_Search']) {
        $AdvSpy_ActiveTab = 'AdvSpy_DivResultatRecherche';
        AdvSpy_log($lang['UI_Lang']['Loging_NewSearch']);
    }
    if ($BlockRecherche['ChercherOK'] == $lang['UI_Lang']['BT_Sim']) {
        $AdvSpy_ActiveTab = 'AdvSpy_DivSimulateur';
        AdvSpy_log($lang['UI_Lang']['Loging_NewSim']);
    }
    if ($BlockRecherche['ChercherOK'] == $lang['UI_Lang']['BT_Load']) {
        $AdvSpy_ActiveTab = 'AdvSpy_DivResultatRecherche';
    }
    if ($BlockRecherche['ChercherOK'] == $lang['UI_Lang']['BT_Save']) {
        $AdvSpy_ActiveTab = 'AdvSpy_DivSaveLoad';
    }
    if ($BlockRecherche['ChercherOK'] == $lang['UI_Lang']['BT_Del']) {
        $AdvSpy_ActiveTab = 'AdvSpy_DivSaveLoad';
    }
    if ($BlockRecherche['ChercherOK'] == $lang['UI_Lang']['BT_Admin']) {
        $AdvSpy_ActiveTab = 'AdvSpy_DivAdmin';
    }
    if ($BlockRecherche['ChercherOK'] == $lang['UI_Lang']['BT_OptSubmit']) {
        $AdvSpy_ActiveTab = 'AdvSpy_DivOptions';
    }
    if ($BlockRecherche['ChercherOK'] == $lang['UI_Lang']['BT_OptRefresh']) {
        $AdvSpy_ActiveTab = 'AdvSpy_DivOptions';
    }


    if ($AdvSpy_ActiveTab == 'AdvSpy_DivFrontPage') {
        $StyleOf_Frontpage = $StyleVisible;
        AdvSpy_log($lang['UI_Lang']['Loging_OpeningAdvSpy']);
    }
    if ($AdvSpy_ActiveTab == 'AdvSpy_DivSimulateur') {
        $StyleOf_Simulateur = $StyleVisible;
    } // le simulateur en 1er pour les calculs de flotte (correction ticket #277)
    if ($AdvSpy_ActiveTab == 'AdvSpy_DivResultatRecherche') {
        $StyleOf_Resultat = $StyleVisible;
    }
    if ($AdvSpy_ActiveTab == 'AdvSpy_DivStats') {
        $StyleOf_Statistiques = $StyleVisible;
    }
    if ($AdvSpy_ActiveTab == 'AdvSpy_DivOptions') {
        $StyleOf_Options = $StyleVisible;
    }
    if ($AdvSpy_ActiveTab == 'AdvSpy_DivAdmin') {
        $StyleOf_Administration = $StyleVisible;
    }
    if ($AdvSpy_ActiveTab == 'AdvSpy_DivSaveLoad') {
        $StyleOf_SaveLoad = $StyleVisible;
    }

    // div firefox copy alert    z-index:10000 pour etre par dessus tous les autres
    print "\n\n<div id=\"AdvSpy_FireFoxCopyAlertDiv\" style=\"visibility:hidden;display:none;position: absolute; z-index:10000;\">";
    AdvSpy_PrintHtml_ClipboardCopyAlert();
    print "</div>\n\n\n\n";

    // div Recherche PLUS
    print "\n\n<div id=\"AdvSpy_DivRecherchePlus\" $StyleInvisible>";
    AdvSpy_PrintHtml_Tab_RecherchePLUS();
    print "</div>\n\n\n\n";

    // les 'onglets', ou plutot les div qui vont les contenir pour les afficher/masquer
    print "\n\n<div id=\"AdvSpy_DivFrontPage\" $StyleOf_Frontpage>";
    AdvSpy_PrintHtml_Tab_FrontPage();
    print "</div>\n\n\n\n";

    print "\n\n<div id=\"AdvSpy_DivSimulateur\" $StyleOf_Simulateur>";
    AdvSpy_PrintHtml_Tab_Simulateur();
    print "</div>\n\n\n\n";

    print "\n\n<div id=\"AdvSpy_DivOptions\" $StyleOf_Options>";
    AdvSpy_PrintHtml_Tab_Options();
    print "</div>\n\n\n\n";

    print "\n\n<div id=\"AdvSpy_DivSaveLoad\" $StyleOf_SaveLoad>";
    AdvSpy_PrintHtml_Tab_SaveLoad();
    print "</div>\n\n\n\n";

    print "</form>";

    // on ferme le formulaire ici avant d'afficher les resultats de la recherche pour eviter d'envoyer à chaque fois 3 Mo de data inutile en POST (les RE pour le presse-papier sont dans des TEXTAREA)
    print "\n\n<div id=\"AdvSpy_DivResultatRecherche\" $StyleOf_Resultat>\n\n";
    AdvSpy_PrintHtml_Tab_ResultatRecherche();
    print "\n\n</div>\n\n\n\n";

    // de toute facon, avec le jeux des afficher/cacher, mettre le div des resultat en permier ou dernier change rien à l'affichage.
    // au passage, la fonction  AdvSpy_PrintHtml_Tab_ResultatRecherche à renseigné les informations statistiques, donc on peut les afficher (que) maintenant.
    print "\n\n<div id=\"AdvSpy_DivStats\" $StyleOf_Statistiques>";
    AdvSpy_PrintHtml_Tab_Statistiques();
    print "</div>\n\n\n\n";

    print "\n\n<div id=\"AdvSpy_DivAdmin\" $StyleOf_Administration>";
    AdvSpy_PrintHtml_Tab_Administration();
    print "</div>\n\n\n\n";

    //et puis la fin !

    $AdvSpy_MemoryMsg = "";
    $AdvSpy_MemoryUsage = 0;
    if (function_exists("memory_get_usage")) {
        $AdvSpy_MemoryUsage = memory_get_usage();
        if ($AdvSpy_MemoryUsage > 1) {
            $AdvSpy_MemoryMsg = "<br/><font size=\"1\">" . $lang['UI_Lang']['UsedMemory'] .
                " " . AdvSpy_GetFormatedNumber(round($AdvSpy_MemoryUsage / 1024)) . " Ko</font>";
        }
    }
    //ne pas modifier cette dernière ligne svp, mon travail merite bien que vous respectiez celà.
    print "</td></tr></table><br/><a href=\"http://ogsteam.fr/forums/sujet-1273\" target=\"_new\">- AdvSpy -</a> v" .
        $AdvSpyConfig['version']['advspy'] . " par <a href=\"http://ogsteam.fr/forums/message_send.php?id=3391\" target=\"_new\">kilops</a><br/>pour, ogame:" .
        $AdvSpyConfig['version']['ogame'] . " ogspy:" . $AdvSpyConfig['version']['ogspy'] .
        " $AdvSpy_MemoryMsg <a href=\"http://v75.xiti.com/publications/publique.aspx?site=266506\" title=\"Bien vu lulu ! (click pour voir)\" target=\"_blank\"><script type=\"text/javascript\">\n<!--\nXt_param = 's=266506&p=AdvSpy_" .
        $AdvSpyConfig['version']['advspy'] . "';\ntry {Xt_r = top.document.referrer;}\ncatch(e) {Xt_r = document.referrer; }\nXt_h = new Date();\nXt_i = '<img width=\"1\" height=\"1\" border=\"0\" ';\nXt_i += 'src=\"http://logv31.xiti.com/hit.xiti?'+Xt_param;\nXt_i += '&hl='+Xt_h.getHours()+'x'+Xt_h.getMinutes()+'x'+Xt_h.getSeconds();\nif(parseFloat(navigator.appVersion)>=4)\n{Xt_s=screen;Xt_i+='&r='+Xt_s.width+'x'+Xt_s.height+'x'+Xt_s.pixelDepth+'x'+Xt_s.colorDepth;}\ndocument.write(Xt_i+'&ref='+Xt_r.replace(/[<>\"]/g, '').replace(/&/g, '$')+'\" title=\"Bien vu lulu ! (click pour voir)\">');\n//-->\n</script><noscript><img width=\"1\" height=\"1\" border=\"0\" src=\"http://logv31.xiti.com/hit.xiti?s=266506&p=AdvSpy_" .
        $AdvSpyConfig['version']['advspy'] . "\" alt=\"AdvSpy\" /></noscript></a>";
}


// ptite inclusion en loosedé
if (!function_exists('memory_get_usage')) {
    function memory_get_usage()
    {
        //If its Windows
        //Tested on Win XP Pro SP2. Should work on Win 2003 Server too
        //Doesn't work for 2000
        //If you need it to work for 2000 look at http://us2.php.net/manual/en/function.memory-get-usage.php#54642
        if (substr(PHP_OS, 0, 3) == 'WIN') {
            if (substr(PHP_OS, 0, 3) == 'WIN') {
                $output = array();
                exec('tasklist /FI "PID eq ' . getmypid() . '" /FO LIST', $output);

                return preg_replace('/[\D]/', '', $output[5]) * 1024;
            }
        } else {
            //We now assume the OS is UNIX
            //Tested on Mac OS X 10.4.6 and Linux Red Hat Enterprise 4
            //This should work on most UNIX systems
            $pid = getmypid();
            exec("ps -eo%mem,rss,pid | grep $pid", $output);
            $output = explode("  ", $output[0]);
            //rss is given in 1024 byte units
            return $output[1] * 1024;
        }
    }
}


// à améliorer ...
function AdvSpy_GetFormatedNumber($num = 0)
{
    global $AdvSpyConfig, $lang, $BlockRecherche;

    if (!($seuil = $BlockRecherche['AdvSpy_SeuilGrandNombre'] * 1000)) {
        $seuil = 200000;
    }

    $Separator = AdvSpy_Options_GetValue('SeparateurDeMilliers');

    $num = intval($num);
    $seuil = intval($seuil);
    if ($num < $seuil) { // PAS GRAND NOMBRE
        $first3 = "";
        $next3 = "";
        $others = "";
        if (strlen($num) > 6) {
            $first3 = substr($num, -3);
            $next3 = substr($num, -6, 3);
            $others = substr($num, 0, -6);
            return "<font color='#77FF77'>$others</font>$Separator$next3$Separator$first3";
        } elseif (strlen($num) > 3) {
            $first3 = substr($num, -3);
            $others = substr($num, 0, -3);
            return "<font color='#88FF88'>$others</font>$Separator$first3";
        } else {
            return $num;
        }
    } else { // GRAND NOMBRE
        $first3 = "";
        $next3 = "";
        $others = "";
        if (strlen($num) > 6) {
            $first3 = substr($num, -3);
            $next3 = substr($num, -6, 3);
            $others = substr($num, 0, -6);
            return "<b><font color='#FF0000'>$others</font>$Separator<font color='#FF5555'>$next3</font>$Separator<font color='#FF8888'>$first3</font></b>";
        } elseif (strlen($num) > 3) {
            $first3 = substr($num, -3);
            $others = substr($num, 0, -3);
            return "<b><font color='#FF5555'>$others</font>$Separator<font color='#FF8888'>$first3</font></b>";
        } else {
            return "<b>$num</b>";
        }
    }
}

function AdvSpy_GetFormatedNumberBBCode($num = 0)
{
    $out = AdvSpy_GetFormatedNumber($num);
    $out = str_replace(array('<b>', '</b>', "<font color='", "'>", '</font>'), array
        ('[b]', '[/b]', '[color=', ']', '[/color]'), $out);
    return $out;
}

// ================================= FONCTIONS HONTEUSEMENT POMPEES SUR SOGSORV !!!!!!
function raid_transp_calc($nb_t, $t_load, $m_avail, $c_avail, $d_avail, $extra_fret =
    0)
{
    // 1st pass
    $total_load = $nb_t * $t_load - $extra_fret;
    $can_load = floor($total_load / 3);
    $ress_limit_m = floor($m_avail / 2);
    $ress_limit_c = floor($c_avail / 2);
    $ress_limit_d = floor($d_avail / 2);
    $taken_m = (($ress_limit_m - $can_load) > 0 ? $can_load : $ress_limit_m);
    $taken_c = (($ress_limit_c - $can_load) > 0 ? $can_load : $ress_limit_c);
    $taken_d = (($ress_limit_d - $can_load) > 0 ? $can_load : $ress_limit_d);
    $inload = $taken_m + $taken_c + $taken_d;
    $load_remaining = $total_load - $inload;
    // 2nd pass, s'il reste de la place
    if ($load_remaining > 0) {
        $can_load2 = floor($load_remaining / 2);
        $taken2_m = (($ress_limit_m - $taken_m - $can_load2) > 0 ? $can_load2 : $ress_limit_m -
            $taken_m);
        $taken2_c = (($ress_limit_c - $taken_c - $can_load2) > 0 ? $can_load2 : $ress_limit_c -
            $taken_c);
        $inload += $taken2_m + $taken2_c;
        $taken_m += $taken2_m;
        $taken_c += $taken2_c;
    }
    $arr[0] = $taken_m;
    $arr[1] = $taken_c;
    $arr[2] = $taken_d;
    return $arr;
}

function raid_transp_opt($capacite, $met, $cri, $deut, $extra_fret = 0)
{
    // on essaye de minorer et majorer le nombre exact pour limiter les calculs
    // je ne suis absolument pas sûr de ça, et je cherche une meilleure méthode pour trouver
    // le bon résultat parce que celle là est bourrin quand même
    // * pour la minoration c'est simplement le max qu'on peut transporter en théorie pure
    //   dans la limite de la moitié des ressources
    $start = floor(($met + $cri + $deut) / $capacite / 2);
    // * pour la majoration en revanche, on prend le double d'un transport normal
    $end = ceil(($met + $cri + $deut) / $capacite * 2);
    $opt = $end;
    $af = array(0 => floor($met / 2), 1 => floor($cri / 2), 2 => floor($deut / 2));
    for ($i = $start; $i < $end; $i++) {
        $a = raid_transp_calc($i, $capacite, $met, $cri, $deut, $extra_fret);
        if ($a == $af) {
            $opt = $i;
            $i = $end;
        }
    }
    return $opt;
}
// ========================== FIN ======= FONCTIONS HONTEUSEMENT POMPEES SUR SOGSORV !!!!!!

function AdvSpy_duration($secs)
{
    global $AdvSpyConfig, $lang;
    $vals = array($lang['UI_Lang']['WeekAsName'] => (int)($secs / 86400 / 7),
        $lang['UI_Lang']['DayAsName'] => $secs / 86400 % 7, $lang['UI_Lang']['HourAsLetter'] =>
        $secs / 3600 % 24, $lang['UI_Lang']['MinuteAsLetter'] => $secs / 60 % 60,
        $lang['UI_Lang']['SecondAsLetter'] => $secs % 60);
    $ret = array();
    $added = false;
    foreach ($vals as $k => $v) {
        if ($v > 0 || $added) {
            //$added = true;
            if (($v > 1) && (($k == $lang['UI_Lang']['WeekAsName']) or ($k == $lang['UI_Lang']['DayAsName']))) {
                $ret[] = "<b>" . $v . "</b> " . $k . $lang['UI_Lang']['TrailingLetterForPlurial'];
            } else {
                $ret[] = "<b>" . $v . "</b> " . $k;
            }
        }
    }
    return join(' ', $ret);
}


// merci à : msajko at gmail dot com (php.net/array) + mes corrections pour la valeure 0 et '' et TRUE et FALSE
// array_to_string and sister function string_to_array with multi dimensional array support.

// Converts an array to a string that is safe to pass via a URL
function AdvSpy_array_to_string($array)
{
    $retval = '';
    $null_value = "^^^";
    $false_value = '¤FALSE¤';
    $true_value = '¤TRUE¤';
    foreach ($array as $index => $val) {
        if (gettype($val) == 'array')
            $value = '^^array^' . AdvSpy_array_to_string($val);
        else
            $value = $val;

        if ($value === '') {
            $value = $null_value;
        }
        if ($value === null) {
            $value = $null_value;
        }
        if ($value === true) {
            $value = $true_value;
        }
        if ($value === false) {
            $value = $false_value;
        }

        $retval .= urlencode(base64_encode($index)) . '|' . urlencode(base64_encode($value)) .
            '||';
    }
    return urlencode(substr($retval, 0, -2));
}

// Converts a string created by array_to_string() back into an array.
function AdvSpy_string_to_array($string)
{
    $retval = array();
    if ($string == '') {
        return $retval;
    }
    $string = urldecode($string);
    $tmp_array = explode('||', $string);
    $null_value = urlencode(base64_encode("^^^"));
    $false_value = urlencode(base64_encode('¤FALSE¤'));
    $true_value = urlencode(base64_encode('¤TRUE¤'));

    foreach ($tmp_array as $tmp_val) {
        list($index, $value) = explode('|', $tmp_val);
        $decoded_index = base64_decode(urldecode($index));

        if ($value === $null_value) {
            $retval[$decoded_index] = null;
        } elseif ($value === $true_value) {
            $retval[$decoded_index] = true;
        } elseif ($value === $false_value) {
            $retval[$decoded_index] = false;
        } elseif (@$value) {
            $val = base64_decode(urldecode($value));
            if (substr($val, 0, 8) == '^^array^')
                $val = AdvSpy_string_to_array(substr($val, 8));
            $retval[$decoded_index] = $val;
        }
    }
    return $retval;
}


function AdvSpy_GetBlankFlatSpyRepport()
{
    global $AdvSpyConfig, $lang;
    $BlankFlatSpyRepport['coord'] = '[0:0:0]';
    $BlankFlatSpyRepport['name'] = '';
    $BlankFlatSpyRepport['lune'] = '0';
    $BlankFlatSpyRepport['timetext'] = '00-00 00:00:00';
    $BlankFlatSpyRepport['metal'] = '0';
    $BlankFlatSpyRepport['cristal'] = '0';
    $BlankFlatSpyRepport['deut'] = '0';
    $BlankFlatSpyRepport['energie'] = '0';
    $BlankFlatSpyRepport['lastseen'] = '';
    $SpyCatList = $lang['DicOgame']['SpyCatList'];
    foreach ($SpyCatList as $Cat => $name) {
        $BlankFlatSpyRepport[$Cat] = '0';
        foreach ($lang['DicOgame'][$Cat] as $num => $valuesarray) {
            $postvar = $valuesarray['PostVar'];
            $BlankFlatSpyRepport[$postvar] = 0;
        }
    }
    $BlankFlatSpyRepport['proba'] = '0';
    return $BlankFlatSpyRepport;
}


function AdvSpy_GetBlankFlatFleet()
{
    global $AdvSpyConfig, $lang;
    $BlankFleet = array();
    foreach ($lang['DicOgame']['Fleet'] as $num => $values) {
        $BlankFleet[$values['PostVar']] = 0;
    }
    return $BlankFleet;
}

function AdvSpy_GetBlankFlatDef()
{
    global $AdvSpyConfig, $lang;
    $BlankDef = array();
    foreach ($lang['DicOgame']['Def'] as $num => $values) {
        $BlankDef[$values['PostVar']] = 0;
    }
    return $BlankDef;
}

function AdvSpy_GetBlankFlatARMY()
{
    global $AdvSpyConfig, $lang;

    $BlankArmy = array();
    foreach (AdvSpy_GetBlankFlatFleet() as $name => $value) {
        $BlankArmy[$name] = 0;
    }
    foreach (AdvSpy_GetBlankFlatDef() as $name => $value) {
        $BlankArmy[$name] = 0;
    }

    $BlankArmy['t_armes'] = 0;
    $BlankArmy['t_bouclier'] = 0;
    $BlankArmy['t_protect'] = 0;

    return $BlankArmy;
}


//Un BlockRecherche c'est la totalité de tous les POST possibles et imaginables du script
//cette fonction renvois un array vide de cette liste de POST (à analyser plus tard)
//seulement ce qui est présent dans cette liste sera analysé en POST (meme nom) et envoyé dans $BlockRecherche
function AdvSpy_GetBlankBlockRecherche()
{
    global $AdvSpyConfig, $lang;
    $BlockRecherche = array();

    $BlockRecherche['ChercherOK'] = '';
    $BlockRecherche['AdvSpy_TRIS'] = '1';

    $BlockRecherche['AdvSpy_OnlyMyScan'] = '';

    $BlockRecherche['AdvSpy_SearchResult_Min'] = '1';
    $BlockRecherche['AdvSpy_SearchResult_Max'] = AdvSpy_Options_GetValue('SearchResult_DefaultMax');

    $BlockRecherche['AdvSpy_GalaxyMin'] = '1';
    $BlockRecherche['AdvSpy_GalaxyMax'] = $AdvSpyConfig['Settings']['OgameUniverse_Galaxy_Max'];
    $BlockRecherche['AdvSpy_SystemMin'] = '1';
    $BlockRecherche['AdvSpy_SystemMax'] = $AdvSpyConfig['Settings']['OgameUniverse_System_Max'];
    $BlockRecherche['AdvSpy_RowMin'] = '1';
    $BlockRecherche['AdvSpy_RowMax'] = $AdvSpyConfig['Settings']['OgameUniverse_Row_Max'];
    $BlockRecherche['AdvSpy_CoordsToHide'] = '';
    $BlockRecherche['AdvSpy_AgeMax'] = $AdvSpyConfig['Settings']['ListeAgeMax'][0];
    $BlockRecherche['AdvSpy_NoDoublon'] = 'ON';
    foreach ($lang['DicOgame']['SpyCatList'] as $Cat => $name) {
        $BlockRecherche["AdvSpy_Scanned_$Cat"] = '';
        $BlockRecherche["AdvSpy_Reduire_$Cat"] = '';
    }
    $BlockRecherche['AdvSpy_OnlyInactif'] = '';
    $BlockRecherche['AdvSpy_ShowOnlyMoon'] = '';
    $BlockRecherche['AdvSpy_PlayerSearch'] = '';
    $BlockRecherche['AdvSpy_AllySearch'] = '';
    $BlockRecherche['AdvSpy_PlanetSearch'] = '';
    $BlockRecherche['AdvSpy_SeuilGrandNombre'] = '200';
    $BlockRecherche['AdvSpy_OnlyGrandNombre'] = '';
    $BlockRecherche['AdvSpy_RessourceMinMetal'] = '0';
    $BlockRecherche['AdvSpy_RessourceMinCristal'] = '0';
    $BlockRecherche['AdvSpy_RessourceMinDeut'] = '0';
    $BlockRecherche['AdvSpy_RessourceMinEnergie'] = '0';
    $BlockRecherche['AdvSpy_TauxPatateMini'] = '';
    $BlockRecherche['AdvSpy_HideRaided'] = '';
    $BlockRecherche['AdvSpy_OnlyRaided'] = '';
    $BlockRecherche['AdvSpy_RaidAgeMax'] = $AdvSpyConfig['Settings']['ListeAgeMax'][6];
    $BlockRecherche['AdvSpy_PatateTotalMin'] = '';
    $BlockRecherche['AdvSpy_PatateTotalMax'] = '';
    foreach ($lang['DicOgame']['SpyCatList'] as $Cat => $Catname) {
        foreach ($lang['DicOgame'][$Cat] as $num => $valuesarray) {
            $BlockRecherche["AdvSpy_" . $valuesarray['PostVar']] = 'indifferent';
            $BlockRecherche["AdvSpy_" . $valuesarray['PostVar'] . "_Min"] = '';
            $BlockRecherche["AdvSpy_" . $valuesarray['PostVar'] . "_Max"] = '';
        }
    }
    foreach ($lang['DicOgame']['Fleet'] as $num => $valuesarray) {
        $BlockRecherche['AdvSpy_Sim_atk_' . $valuesarray['PostVar']] = '';
    }

    //$AdvSpyConfig['User_Empire'][technology]

    $BlockRecherche['AdvSpy_Sim_atk_t_armes'] = '';
    $BlockRecherche['AdvSpy_Sim_atk_t_bouclier'] = '';
    $BlockRecherche['AdvSpy_Sim_atk_t_protect'] = '';

    foreach ($lang['DicOgame']['Fleet'] as $num => $valuesarray) {
        $BlockRecherche['AdvSpy_Sim_def_' . $valuesarray['PostVar']] = '';
    }
    foreach ($lang['DicOgame']['Def'] as $num => $valuesarray) {
        $BlockRecherche['AdvSpy_Sim_def_' . $valuesarray['PostVar']] = '';
    }

    $BlockRecherche['AdvSpy_Sim_def_t_armes'] = '';
    $BlockRecherche['AdvSpy_Sim_def_t_bouclier'] = '';
    $BlockRecherche['AdvSpy_Sim_def_t_protect'] = '';

    //--------------------------------------------------------
    $BlockRecherche['AdvSpy_SaveIdToLoad'] = '';
    $BlockRecherche['AdvSpy_SaveDelConfirmation'] = '';
    $BlockRecherche['AdvSpy_SaveNameToSave'] = '';
    $BlockRecherche['AdvSpy_SaveIsPublic'] = '';
    $BlockRecherche['AdvSpy_SaveIsDefault'] = '';
    $BlockRecherche['AdvSpy_SaveElement_Tris'] = '';
    $BlockRecherche['AdvSpy_SaveElement_Secteur'] = '';
    $BlockRecherche['AdvSpy_SaveElement_RE'] = '';
    $BlockRecherche['AdvSpy_SaveElement_Joueur'] = '';
    $BlockRecherche['AdvSpy_SaveElement_Ressources'] = '';
    $BlockRecherche['AdvSpy_SaveElement_Analyse'] = '';
    $BlockRecherche['AdvSpy_SaveElement_MMFleet'] = '';
    $BlockRecherche['AdvSpy_SaveElement_MMDef'] = '';
    $BlockRecherche['AdvSpy_SaveElement_MMBuildings'] = '';
    $BlockRecherche['AdvSpy_SaveElement_MMTech'] = '';
    $BlockRecherche['AdvSpy_SaveElement_Sim_atk'] = '';
    $BlockRecherche['AdvSpy_SaveElement_Sim_atk_tech'] = '';
    $BlockRecherche['AdvSpy_SaveElement_Sim_def'] = '';
    $BlockRecherche['AdvSpy_SaveElement_Sim_def_tech'] = '';

    //--------------------------------------------------------

    return $BlockRecherche;
}


function AdvSpy_CalcBlockRechercheFromPosts($BlockRecherche)
{
    global $AdvSpyConfig, $lang;

    $BlockRechercheCalcule = $BlockRecherche;
    foreach ($BlockRecherche as $postname => $defaultvalue) {


// chhé pas ki a fais ça mais ça casse tout ...

//        if (isset($pub_{$postname})) {
//            $PostValue = '';
//            $PostValue = $pub_{$postname};

       	if (array_key_exists($postname,$_POST)) {
       		$PostValue='';
       		$PostValue=$_POST[$postname];

            //ici se joue la securité et la correction d'erreurs ... (en fait ya pas de correction pour le moment, juste des flics)
            // le die est un peut hard mais au moin ca met les points sur les i.  En général y a pas de faux positifs.
            // tous les classiques sont là ou presque
            // les casseurs de quotes, les sql injection, insersions html, dépréciateurs de path et compagnie ...

            $Illegals = array("'", '"', '`', '/', '\\', '%', '?', ';', '$', '&', '<', '>',
                '@', '..', '=', '~', '|', ';', '^', '¤');
            foreach ($Illegals as $Forbiden) {
                if (stripos($PostValue, $Forbiden) !== false) {
                    die($lang['UI_Lang']['Error_InvalidChar'] . " '$Forbiden' ( '$postname' ) ");
                }
            }

            if (AdvSpy_CheckVarAgainstTypeMask($PostValue, $lang['BlockRechercheElements'][$postname]['Type'])) {
                $BlockRechercheCalcule[$postname] = $PostValue;
            } else {
                die($lang['UI_Lang']['Error_InvalidInput'] . " '" . $lang['BlockRechercheElements'][$postname]['Name'] .
                    "' ($postname) - !! '" . $PostValue . "' !! ");
            }


        } elseif ((@$BlockRechercheCalcule['ChercherOK'] != '') and ($defaultvalue ==
        'ON')) {
            // Si un élément du $BlockRecherche n'est pas posté
            // alors que le formulaire est posté
            // mais que la valeure par défaut est 'ON' alors c'est un checkbox et il est pas coché.
            // ca c'est pour 'NoDoublons' qui est ON par défaut et ca fais chier à détecter lol.
            $BlockRechercheCalcule[$postname] = '';
        }
    }


    //$BlockRechercheCalcule['AdvSpy_Sim_def_t_armes']

    $DefTechArmes = 10;
    $DefTechArmes = @$AdvSpyConfig['User_Empire']['technology']['Armes'];
    $DefTechBouclier = 10;
    $DefTechBouclier = @$AdvSpyConfig['User_Empire']['technology']['Bouclier'];
    $DefTechProtect = 10;
    $DefTechProtect = @$AdvSpyConfig['User_Empire']['technology']['Protection'];

    if (!$BlockRechercheCalcule['AdvSpy_Sim_def_t_armes']) {
        $BlockRechercheCalcule['AdvSpy_Sim_def_t_armes'] = $DefTechArmes;
    }
    if (!$BlockRechercheCalcule['AdvSpy_Sim_def_t_bouclier']) {
        $BlockRechercheCalcule['AdvSpy_Sim_def_t_bouclier'] = $DefTechBouclier;
    }
    if (!$BlockRechercheCalcule['AdvSpy_Sim_def_t_protect']) {
        $BlockRechercheCalcule['AdvSpy_Sim_def_t_protect'] = $DefTechProtect;
    }

    if (!$BlockRechercheCalcule['AdvSpy_Sim_atk_t_armes']) {
        $BlockRechercheCalcule['AdvSpy_Sim_atk_t_armes'] = $DefTechArmes;
    }
    if (!$BlockRechercheCalcule['AdvSpy_Sim_atk_t_bouclier']) {
        $BlockRechercheCalcule['AdvSpy_Sim_atk_t_bouclier'] = $DefTechBouclier;
    }
    if (!$BlockRechercheCalcule['AdvSpy_Sim_atk_t_protect']) {
        $BlockRechercheCalcule['AdvSpy_Sim_atk_t_protect'] = $DefTechProtect;
    }


    return $BlockRechercheCalcule;
}


//le parser de RE (la partie sensible)  >> inutile depuis OGSPY 3.05
//la methode peut parraitre bourrin mais en fait
//c'est ce qu'il y a de plus compatible (et y a plein de correction de bug venant d'ogspy, ogs, barre d'outil...)
function AdvSpy_GetFlatSpyRepportFromRawText($TextSpyRepport)
{
    global $AdvSpyConfig, $lang;

    $FlatSpyRepport = AdvSpy_GetBlankFlatSpyRepport();

    //avant tout :
    //Cleanup et mass downgrade
    $TextSpyRepport = str_replace('\\', '', $TextSpyRepport);
    $TextSpyRepport = str_replace("	", " ", $TextSpyRepport); // tab
    $TextSpyRepport = str_replace("|", " ", $TextSpyRepport); // ché pu ou mais g deja vu un soft bourrin poster ca partout...
    $TextSpyRepport = str_replace("\r\n", " ", $TextSpyRepport); // retour à la ligne ms dos
    $TextSpyRepport = str_replace("\r", " ", $TextSpyRepport); // retour à la ligne des barbares
    $TextSpyRepport = str_replace("\n", " ", $TextSpyRepport); // retour à la ligne nunux

    $TextSpyRepport = ereg_replace(" +", " ", $TextSpyRepport); // reduction des espaces (mahn's optimisation)

    //On commence par virer ce qui dépasse du RE (en cas de bug)
    //au debut
    $TextSpyRepport = strstr($TextSpyRepport, $lang['DicOgame']['Text']['Spy']['start']);
    //le signe % marque la fin
    $debut = strlen($lang['DicOgame']['Text']['Spy']['start']);
    $fin = strpos($TextSpyRepport, '%');
    $TextSpyRepport = substr($TextSpyRepport, $debut, $fin - $debut);


    // au passage: Correction d'un bug avec OGS ki bouffe tous les espaces .... le relouuuuuuuuuuuuu ;)
    foreach ($lang['DicOgame']['SpyCatList'] as $Cat => $Catname) {
        foreach ($lang['DicOgame'][$Cat] as $num => $valuesarray) {
            $TextSpyRepport = str_replace($valuesarray['Name'], " str_" . $valuesarray['PostVar'] .
                " ", $TextSpyRepport);
        }
    }

    $TextSpyRepport = str_replace($lang['DicOgame']['Text']['Spy']['metal'],
        " " . 'str_metal' . " ", $TextSpyRepport);
    $TextSpyRepport = str_replace($lang['DicOgame']['Text']['Spy']['cristal'],
        " " . 'str_cristal' . " ", $TextSpyRepport);
    $TextSpyRepport = str_replace($lang['DicOgame']['Text']['Spy']['deut'],
        " " . 'str_deut' . " ", $TextSpyRepport);
    $TextSpyRepport = str_replace($lang['DicOgame']['Text']['Spy']['energie'],
        " " . 'str_energie' . " ", $TextSpyRepport);
    $TextSpyRepport = str_replace($lang['DicOgame']['Text']['Spy']['Fleet'],
        " " . 'str_Fleet' . " 1 ", $TextSpyRepport);
    $TextSpyRepport = str_replace($lang['DicOgame']['Text']['Spy']['Def'],
        " " . 'str_Def' . " 1 ", $TextSpyRepport);
    $TextSpyRepport = str_replace($lang['DicOgame']['Text']['Spy']['Buildings'],
        " " . 'str_Buildings' . " 1 ", $TextSpyRepport);
    $TextSpyRepport = str_replace($lang['DicOgame']['Text']['Spy']['Tech'],
        " " . 'str_Tech' . " 1 ", $TextSpyRepport);
    $TextSpyRepport = str_replace($lang['DicOgame']['Text']['Spy']['end'],
        " " . 'str_proba' . " ", $TextSpyRepport);
    $TextSpyRepport = str_replace($lang['DicOgame']['Text']['Spy']['interlude'],
        " " . 'str_interlude' . " ", $TextSpyRepport);

    $TextSpyRepport = str_replace($lang['DicOgame']['Text']['Spy']['nolastseen'],
        '', $TextSpyRepport);
    $TextSpyRepport = str_replace($lang['DicOgame']['Text']['Spy']['lastseenstart'],
        " " . 'str_lastseen' . " ", $TextSpyRepport);
    $TextSpyRepport = str_replace($lang['DicOgame']['Text']['Spy']['lastseenend'],
        '', $TextSpyRepport);

    $TextSpyRepport = ereg_replace(" +", " ", $TextSpyRepport); // reduction des espaces (mahn's optimisation)

    // Fini de convertir, on passe à l'analyse

    //Au point ou on en est $TextSpyRepport ressemble à ca :
    // pl nete (Lune) [1:234:5] str_interlude 01-01 01:01:01 str_metal 9.594.800 str_cristal 2.108.380 str_deut 7.452.320 str_energie 0 str_Fleet 1 str_f_gt 1.368 str_f_cle 3.526 str_f_vb 122 str_f_rec 135 str_f_se 92 str_f_des 2 str_f_traq 3 str_Def 1 str_d_mis 487 str_d_gaus 1.773 str_d_pla 120 str_d_pb 1 str_d_gb 1 str_Buildings 1 str_b_spatial 12 str_b_lune 8 str_b_phalange 4 str_b_stargate 1 str_Tech 1 str_t_spy 11 str_t_ordi 11 str_t_armes 13 str_t_bouclier 12 str_t_protect 15 str_t_energie 12 str_t_hyper 8 str_t_combu 12 str_t_impu 6 str_t_phyper 6 str_t_laser 12 str_t_ions 8 str_t_plasma 7 str_t_reseau 1 str_proba 36

    //Nom de la planete (et lune)
    $fin = strpos($TextSpyRepport, '[');
    $nometlune = substr($TextSpyRepport, 0, $fin);
    $FlatSpyRepport['planet_name'] = trim(str_replace($lang['DicOgame']['Text']['Spy']['lune'],
        '', $nometlune));
    //lune
    $FlatSpyRepport['lune'] = 0;
    if (strpos($nometlune, $lang['DicOgame']['Text']['Spy']['lune']) !== false) {
        $FlatSpyRepport['lune'] = 1;
    }

    if (($AdvSpyConfig['Settings']['OldMoonDetection']) and ($FlatSpyRepport['planet_name'] ==
        "lune")) {
        $FlatSpyRepport['lune'] = 1;
    }
    //coordonées
    $debut = strpos($TextSpyRepport, '[');
    $fin = strpos($TextSpyRepport, ']') + 1;
    $FlatSpyRepport['coord'] = substr($TextSpyRepport, $debut, $fin - $debut);

    $TextSpyRepport = substr($TextSpyRepport, $fin); // on coupe jusqu'aux coord (inclus)

    //date time
    $debut = strpos($TextSpyRepport, 'str_interlude') + 13;
    $fin = strpos($TextSpyRepport, 'str_metal');
    $FlatSpyRepport['timetext'] = trim(substr($TextSpyRepport, $debut, $fin - $debut));

    $TextSpyRepport = substr($TextSpyRepport, $fin); // on coupe jusqu'a la date

    //on passe en mode 'array'

    $ArraySpyRepport = explode(' ', $TextSpyRepport);

    $PreviousValue = '';
    foreach ($ArraySpyRepport as $value) {
        $valuesanspoints = str_replace('.', '', $value);
        $PreviousValueSansStr = str_replace('str_', '', $PreviousValue);
        $ValueSansStr = str_replace('str_', '', $Value);
        if ((is_numeric($valuesanspoints)) && (array_key_exists($PreviousValueSansStr, $FlatSpyRepport))) {
            $FlatSpyRepport[$PreviousValueSansStr] = $valuesanspoints;
        }
        $PreviousValue = $value;
    }

    // lune encore .... apres avoir analysé les batiments ...
    if ($AdvSpyConfig['Settings']['SmartMoonDetection']) {

        if (($FlatSpyRepport['planet_name'] === "lune") and ($FlatSpyRepport['energie'] ==
            0)) {
            $FlatSpyRepport['lune'] = 1;
        }

        //[b_metal][b_cristal][b_deut][b_solaire][b_fusion][b_robot][b_nanites][b_spatial][b_hmetal][b_hcristal][b_hdeut][b_labo][b_terra][b_missiles][b_lune][b_phalange][b_stargate]
        if (($FlatSpyRepport['b_metal']) or ($FlatSpyRepport['b_cristal']) or ($FlatSpyRepport['b_deut'])) {
            $FlatSpyRepport['lune'] = 0;
        }
        if (($FlatSpyRepport['b_lune']) or ($FlatSpyRepport['b_phalange']) or ($FlatSpyRepport['b_stargate'])) {
            $FlatSpyRepport['lune'] = 1;
        }
    }

    //$FlatSpyRepport['system']=$FlatSpyRepport['spy_system'];
    //$FlatSpyRepport['galaxy']=$FlatSpyRepport['spy_galaxy'];
    //$FlatSpyRepport['row']=$FlatSpyRepport['spy_row'];

    //c fini
    return $FlatSpyRepport;
}

/**
 * @access public
 * @return void
 **/
function AdvSpy_GetFlatSpyRepportFromParsedSpy($ParsedSpy)
{
    global $AdvSpyConfig, $lang;

    $FlatSpyRepport = AdvSpy_GetBlankFlatSpyRepport();

    // champs des nouvaux RE :
    // id_spy 	planet_name 	coordinates 	metal 	cristal 	deuterium 	energie
    // activite 	M 	C 	D 	CES 	CEF 	UdR 	UdN 	CSp 	HM 	HC 	HD
    // Lab 	Ter 	DdR 	Silo 	BaLu 	Pha 	PoSa 	LM 	LLE 	LLO 	CG 	AI 	LP
    // PB 	GB 	MIC 	MIP 	PT 	GT 	CLE 	CLO 	CR 	VB 	VC 	REC 	SE 	BMD 	DST
    // EDLM 	SAT 	TRA 	Esp 	Ordi 	Armes 	Bouclier 	Protection 	NRJ 	Hyp
    // RC 	RI 	PH 	Laser 	Ions 	Plasma 	RRI 	Graviton 	Expeditions 	dateRE 	proba 	active 	sender_id

    // galaxy 	system 	row 	moon 	phalanx 	gate 	name 	ally 	player 	status 	last_update 	last_update_moon 	last_update_user_id

    $FlatSpyRepport['coord'] = '[' . $ParsedSpy['coordinates'] . ']';
    $FlatSpyRepport['name'] = $ParsedSpy['name'];
    $FlatSpyRepport['lune'] = '0';
    $FlatSpyRepport['timetext'] = date('m-d G:i:s', $ParsedSpy['dateRE']);
    $FlatSpyRepport['metal'] = $ParsedSpy['metal'];
    $FlatSpyRepport['cristal'] = $ParsedSpy['cristal'];
    $FlatSpyRepport['deut'] = $ParsedSpy['deuterium'];
    $FlatSpyRepport['energie'] = $ParsedSpy['energie'];

    if ($ParsedSpy['activite'] == -1) {
        $FlatSpyRepport['lastseen'] = '??';
    } else {
        $FlatSpyRepport['lastseen'] = $ParsedSpy['activite'];
    }

    $FlatSpyRepport['proba'] = $ParsedSpy['proba'];

    $FlatSpyRepport['planet_name'] = $ParsedSpy['planet_name'];

    $FlatSpyRepport['spy_galaxy'] = $ParsedSpy['galaxy'];
    $FlatSpyRepport['spy_system'] = $ParsedSpy['system'];
    $FlatSpyRepport['spy_row'] = $ParsedSpy['row'];

    $FlatSpyRepport['spy_id'] = $ParsedSpy['id_spy'];
    $FlatSpyRepport['sender_id'] = $ParsedSpy['sender_id'];

    $FlatSpyRepport['datadate'] = $ParsedSpy['dateRE'];


    foreach ($lang['DicOgame']['SpyCatList'] as $Cat => $Catname) {
        foreach ($lang['DicOgame'][$Cat] as $num => $valuesarray) {
            $PostVar = $valuesarray['PostVar'];
            $OgsName = $valuesarray['OgsName'];

            if ($ParsedSpy[$OgsName] >= 0) {
                $FlatSpyRepport[$PostVar] = $ParsedSpy[$OgsName];
                $FlatSpyRepport[$Cat] = 'true';

            } else {
                $FlatSpyRepport[$PostVar] = '';
                $FlatSpyRepport[$Cat] = '';
            }


            //if ( ($FlatSpyRepport[$PostVar] >= 0)  ) { $FlatSpyRepport[$Cat]='true'; } else { $FlatSpyRepport[$Cat]=''; }
        }
    }


    //lune
    $FlatSpyRepport['lune'] = 0;
    if (stripos($FlatSpyRepport['planet_name'], '(Lune)') !== false) {
        $FlatSpyRepport['planet_name'] = str_replace(' (Lune)', '', $FlatSpyRepport['planet_name']);
        $FlatSpyRepport['lune'] = 1;
    }

    if (($AdvSpyConfig['Settings']['OldMoonDetection']) and ($FlatSpyRepport['planet_name'] ==
        "lune")) {
        $FlatSpyRepport['lune'] = 1;
    }

    if ($AdvSpyConfig['Settings']['SmartMoonDetection']) {

        if (($FlatSpyRepport['planet_name'] === "lune") and ($FlatSpyRepport['energie'] ==
            0)) {
            $FlatSpyRepport['lune'] = 1;
        }

        //[b_metal][b_cristal][b_deut][b_solaire][b_fusion][b_robot][b_nanites][b_spatial][b_hmetal][b_hcristal][b_hdeut][b_labo][b_terra][b_missiles][b_lune][b_phalange][b_stargate]
        if (($FlatSpyRepport['b_metal']) or ($FlatSpyRepport['b_cristal']) or ($FlatSpyRepport['b_deut'])) {
            $FlatSpyRepport['lune'] = 0;
        }
        if (($FlatSpyRepport['b_lune']) or ($FlatSpyRepport['b_phalange']) or ($FlatSpyRepport['b_stargate'])) {
            $FlatSpyRepport['lune'] = 1;
        }
    }


    //c fini
    return $FlatSpyRepport;
}


/**
 * Calcul des info suplémentaires (force de flotte, grand nombre...) à partir d'un $FlatSpyRepport
 **/
function AdvSpy_GetAdvancedSpyInfosFromFlatSpyRepport($FlatSpyRepport)
{
    global $AdvSpyConfig, $lang;

    $AdvancedSpyInfos = array();

    $FlatArmy = AdvSpy_GetFlatArmyFromBlockRechercheMask($FlatSpyRepport, '');

    $AdvancedSpyInfos['PATATE_f'] = AdvSpy_GetPatateFromFlatArmy($FlatArmy, 'Fleet');
    $AdvancedSpyInfos['PATATE_d'] = AdvSpy_GetPatateFromFlatArmy($FlatArmy, 'Def');
    //$AdvancedSpyInfos['PATATE']=AdvSpy_GetPatateFromFlatArmy($FlatArmy);
    $AdvancedSpyInfos['PATATE'] = $AdvancedSpyInfos['PATATE_f'] + $AdvancedSpyInfos['PATATE_d'];


    if (($AdvancedSpyInfos['PATATE_f'] + $AdvancedSpyInfos['PATATE_d']) > 0) {
        $AdvancedSpyInfos['PATATE_Balance_f'] = round($AdvancedSpyInfos['PATATE_f'] / ($AdvancedSpyInfos['PATATE_f'] +
            $AdvancedSpyInfos['PATATE_d']) * 100);
        $AdvancedSpyInfos['PATATE_Balance_d'] = round($AdvancedSpyInfos['PATATE_d'] / ($AdvancedSpyInfos['PATATE_f'] +
            $AdvancedSpyInfos['PATATE_d']) * 100);
    } else {
        $AdvancedSpyInfos['PATATE_Balance_f'] = 0;
        $AdvancedSpyInfos['PATATE_Balance_d'] = 0;
    }

    $AdvancedSpyInfos['ArmyRessourcesD_f'] = AdvSpy_GetRessourcesFromFlatArmy($FlatArmy,
        'Fleet', 'MCD');
    $AdvancedSpyInfos['ArmyRessourcesD_d'] = AdvSpy_GetRessourcesFromFlatArmy($FlatArmy,
        'Def', 'MCD');
    //$AdvancedSpyInfos['ArmyRessourcesD']=AdvSpy_GetRessourcesFromFlatArmy($FlatArmy);
    $AdvancedSpyInfos['ArmyRessourcesD'] = $AdvancedSpyInfos['ArmyRessourcesD_f'] +
        $AdvancedSpyInfos['ArmyRessourcesD_d'];


    $AdvancedSpyInfos['ArmyRessources_f'] = AdvSpy_GetRessourcesFromFlatArmy($FlatArmy,
        'Fleet', 'MC');
    $AdvancedSpyInfos['ArmyRessources_d'] = AdvSpy_GetRessourcesFromFlatArmy($FlatArmy,
        'Def', 'MC');
    //$AdvancedSpyInfos['ArmyRessources']=AdvSpy_GetRessourcesFromFlatArmy($FlatArmy,'Fleet+Def','MC');
    $AdvancedSpyInfos['ArmyRessources'] = $AdvancedSpyInfos['ArmyRessources_f'] + $AdvancedSpyInfos['ArmyRessources_d'];

    $AdvancedSpyInfos['GrandNombre'] = 0;

    foreach (array('metal', 'cristal', 'deut', 'energie') as $name) {
        if ($FlatSpyRepport[$name] > $AdvancedSpyInfos['GrandNombre']) {
            $AdvancedSpyInfos['GrandNombre'] = $FlatSpyRepport[$name];
        }
    }

    $AdvancedSpyInfos['Transport_PT'] = ceil(($FlatSpyRepport['metal'] + $FlatSpyRepport['cristal'] +
        $FlatSpyRepport['deut']) / $lang['DicOgame']['Fleet'][0]['Fret']);
    $AdvancedSpyInfos['Transport_GT'] = ceil(($FlatSpyRepport['metal'] + $FlatSpyRepport['cristal'] +
        $FlatSpyRepport['deut']) / $lang['DicOgame']['Fleet'][1]['Fret']);

    $AdvancedSpyInfos['Ressources_total'] = 0 + $FlatSpyRepport['metal'] + $FlatSpyRepport['cristal'] +
        $FlatSpyRepport['deut'];

    $AdvancedSpyInfos['Raid_metal'] = round($FlatSpyRepport['metal'] / 2);
    $AdvancedSpyInfos['Raid_cristal'] = round($FlatSpyRepport['cristal'] / 2);
    $AdvancedSpyInfos['Raid_deut'] = round($FlatSpyRepport['deut'] / 2);
    $AdvancedSpyInfos['Raid_total'] = $AdvancedSpyInfos['Raid_metal'] + $AdvancedSpyInfos['Raid_cristal'] +
        $AdvancedSpyInfos['Raid_deut'];

    $AdvancedSpyInfos['Raid2_metal'] = $AdvancedSpyInfos['Raid_metal'] + round($FlatSpyRepport['metal'] /
        4);
    $AdvancedSpyInfos['Raid2_cristal'] = $AdvancedSpyInfos['Raid_cristal'] + round($FlatSpyRepport['cristal'] /
        4);
    $AdvancedSpyInfos['Raid2_deut'] = $AdvancedSpyInfos['Raid_deut'] + round($FlatSpyRepport['deut'] /
        4);
    $AdvancedSpyInfos['Raid2_total'] = $AdvancedSpyInfos['Raid2_metal'] + $AdvancedSpyInfos['Raid2_cristal'] +
        $AdvancedSpyInfos['Raid2_deut'];

    $AdvancedSpyInfos['Raid3_metal'] = $AdvancedSpyInfos['Raid2_metal'] + round($FlatSpyRepport['metal'] /
        8);
    $AdvancedSpyInfos['Raid3_cristal'] = $AdvancedSpyInfos['Raid2_cristal'] + round($FlatSpyRepport['cristal'] /
        8);
    $AdvancedSpyInfos['Raid3_deut'] = $AdvancedSpyInfos['Raid2_deut'] + round($FlatSpyRepport['deut'] /
        8);
    $AdvancedSpyInfos['Raid3_total'] = $AdvancedSpyInfos['Raid3_metal'] + $AdvancedSpyInfos['Raid3_cristal'] +
        $AdvancedSpyInfos['Raid3_deut'];

    $AdvancedSpyInfos['Raid_PT'] = raid_transp_opt($lang['DicOgame']['Fleet'][0]['Fret'],
        $FlatSpyRepport['metal'], $FlatSpyRepport['cristal'], $FlatSpyRepport['deut']);
    $AdvancedSpyInfos['Raid_GT'] = raid_transp_opt($lang['DicOgame']['Fleet'][1]['Fret'],
        $FlatSpyRepport['metal'], $FlatSpyRepport['cristal'], $FlatSpyRepport['deut']);


    $AdvancedSpyInfos['CDR_f_m'] = round(AdvSpy_GetRessourcesFromFlatArmy($FlatArmy,
        'Fleet', 'M') * (3 / 10));
    $AdvancedSpyInfos['CDR_f_c'] = round(AdvSpy_GetRessourcesFromFlatArmy($FlatArmy,
        'Fleet', 'C') * (3 / 10));
    $AdvancedSpyInfos['CDR_f_t'] = $AdvancedSpyInfos['CDR_f_m'] + $AdvancedSpyInfos['CDR_f_c'];
    $AdvancedSpyInfos['CDR_f_rec'] = ceil($AdvancedSpyInfos['CDR_f_t'] / $lang['DicOgame']['Fleet'][7]['Fret']);

    $AdvancedSpyInfos['CDR_d_m'] = round(AdvSpy_GetRessourcesFromFlatArmy($FlatArmy,
        'Def', 'M') * (3 / 10));
    $AdvancedSpyInfos['CDR_d_c'] = round(AdvSpy_GetRessourcesFromFlatArmy($FlatArmy,
        'Def', 'C') * (3 / 10));
    $AdvancedSpyInfos['CDR_d_t'] = $AdvancedSpyInfos['CDR_d_m'] + $AdvancedSpyInfos['CDR_d_c'];
    $AdvancedSpyInfos['CDR_d_rec'] = ceil($AdvancedSpyInfos['CDR_d_t'] / $lang['DicOgame']['Fleet'][7]['Fret']);


    if (AdvSpy_Options_GetValue('RecycleDef')) {
        $AdvancedSpyInfos['CDR_t_m'] = $AdvancedSpyInfos['CDR_f_m'] + $AdvancedSpyInfos['CDR_d_m'];
        $AdvancedSpyInfos['CDR_t_c'] = $AdvancedSpyInfos['CDR_f_c'] + $AdvancedSpyInfos['CDR_d_c'];
        $AdvancedSpyInfos['CDR_t_t'] = $AdvancedSpyInfos['CDR_t_m'] + $AdvancedSpyInfos['CDR_t_c'];
        $AdvancedSpyInfos['CDR_t_rec'] = ceil($AdvancedSpyInfos['CDR_t_t'] / $lang['DicOgame']['Fleet'][7]['Fret']);
    } else {
        $AdvancedSpyInfos['CDR_t_m'] = $AdvancedSpyInfos['CDR_f_m'];
        $AdvancedSpyInfos['CDR_t_c'] = $AdvancedSpyInfos['CDR_f_c'];
        $AdvancedSpyInfos['CDR_t_t'] = $AdvancedSpyInfos['CDR_f_t'];
        $AdvancedSpyInfos['CDR_t_rec'] = ceil($AdvancedSpyInfos['CDR_t_t'] / $lang['DicOgame']['Fleet'][7]['Fret']);
    }


    if ($AdvancedSpyInfos['Ressources_total'] <= 0) {
        $AdvancedSpyInfos['Indice_PR'] = 9999;
    } else {
        $AdvancedSpyInfos['Indice_PR'] = round($AdvancedSpyInfos['PATATE'] / $AdvancedSpyInfos['Ressources_total'],
            3);
    }

    return $AdvancedSpyInfos;
}


function AdvSpy_AddZeroToNum($num, $minlenght)
{
    if (strlen("$num") < $minlenght) {
        return str_repeat("0", $minlenght - strlen("$num")) . $num / 1;
    } else {
        return $num;
    }
}


/**
 *
 * @access public
 * @return void
 **/
function AdvSpy_GetSqlRequestFromBlockRecherche()
{
    global $AdvSpyConfig, $lang, $BlockRecherche;

    //if ($AdvSpyConfig['OgspyConfig']['version'] >= '3.05') {
    if (1) {
        // champs des nouvaux RE :
        // id_spy 	planet_name 	coordinates 	metal 	cristal 	deuterium 	energie
        // activite 	M 	C 	D 	CES 	CEF 	UdR 	UdN 	CSp 	HM 	HC 	HD
        // Lab 	Ter 	DdR 	Silo 	BaLu 	Pha 	PoSa 	LM 	LLE 	LLO 	CG 	AI 	LP
        // PB 	GB 	MIC 	MIP 	PT 	GT 	CLE 	CLO 	CR 	VB 	VC 	REC 	SE 	BMD 	DST
        // EDLM 	SAT 	TRA 	Esp 	Ordi 	Armes 	Bouclier 	Protection 	NRJ 	Hyp
        // RC 	RI 	PH 	Laser 	Ions 	Plasma 	RRI 	Graviton 	Expeditions 	dateRE 	proba 	active 	sender_id

        // galaxy 	system 	row 	moon 	phalanx 	gate 	name 	ally 	player 	status 	last_update 	last_update_moon 	last_update_user_id

        /*
        SELECT * FROM ogspy_parsedspy,ogspy_universe
        WHERE `active`='1'
        AND `coordinates`=CONCAT(`galaxy`,':',`system`,':',`row`)
        (merci Gorn pour le CONCAT() :] )
        * */

/*
        $SqlRequest = "SELECT p.* , u.* FROM " . $AdvSpyConfig['Settings']['AdvSpy_TablePrefix'] .
            "parsedspy as p," . TABLE_UNIVERSE . " as u
WHERE p.active='1'
AND p.coordinates=CONCAT(u.galaxy,':',u.system,':',u.row)";
*/


    	// SELECT * FROM A INNER JOIN B ON B.id = A.foo

    	$SqlRequest = "SELECT * FROM " . $AdvSpyConfig['Settings']['AdvSpy_TablePrefix'] . "parsedspy".
    		" as p INNER JOIN " . TABLE_UNIVERSE . " as u ON p.coordinates=CONCAT(u.galaxy,':',u.system,':',u.row)
WHERE p.active='1'";



        $SqlRequest .= "\nAND u.galaxy>=" . $BlockRecherche['AdvSpy_GalaxyMin'];
        $SqlRequest .= "\nAND u.galaxy<=" . $BlockRecherche['AdvSpy_GalaxyMax'];
        $SqlRequest .= "\nAND u.system>=" . $BlockRecherche['AdvSpy_SystemMin'];
        $SqlRequest .= "\nAND u.system<=" . $BlockRecherche['AdvSpy_SystemMax'];
        $SqlRequest .= "\nAND u.row>=" . $BlockRecherche['AdvSpy_RowMin'];
        $SqlRequest .= "\nAND u.row<=" . $BlockRecherche['AdvSpy_RowMax'];
        $SqlRequest .= "\nAND p.dateRE>=";
        $SqlRequest .= time() - ($BlockRecherche['AdvSpy_AgeMax']);


        // Elements sondés
        foreach ($lang['DicOgame']['SpyCatList'] as $Cat => $Catname) {
            if ($BlockRecherche['AdvSpy_Scanned_' . $Cat]) {
                foreach ($lang['DicOgame'][$Cat] as $CatElements) {
                    $OgsName = $CatElements['OgsName'];
                    $SqlRequest .= "\nAND `$OgsName`!= '-1'";
                }
            }
        }

        // Joueur inactif
        if ($BlockRecherche['AdvSpy_OnlyInactif']) {
            $SqlRequest .= "\nAND u.status LIKE '%i%'";
        }

        // nom d joueur
        if ($BlockRecherche['AdvSpy_PlayerSearch']) {
            $SqlRequest .= "\nAND u.player LIKE '%" . $BlockRecherche['AdvSpy_PlayerSearch'] .
                "%'";
        }

        // tag d'ally
        if ($BlockRecherche['AdvSpy_AllySearch']) {
            $SqlRequest .= "\nAND u.ally LIKE '%" . $BlockRecherche['AdvSpy_AllySearch'] .
                "%'";
        }

        // nom de planete
        if ($BlockRecherche['AdvSpy_PlanetSearch']) {
            $SqlRequest .= "\nAND u.name LIKE '%" . $BlockRecherche['AdvSpy_PlanetSearch'] .
                "%'";
        }

        // afinement spécial pour patate maxi=0
        $NeoBR = array();
        if (($BlockRecherche['AdvSpy_PatateTotalMax'] != '') and (($BlockRecherche['AdvSpy_PatateTotalMax']
            === 0) or ($BlockRecherche['AdvSpy_PatateTotalMax'] === '0'))) {
            $NeoBR['AdvSpy_f_pt'] = 'absent';
            $NeoBR['AdvSpy_f_pt_Max'] = 0;
            $NeoBR['AdvSpy_f_gt'] = 'absent';
            $NeoBR['AdvSpy_f_gt_Max'] = 0;
            $NeoBR['AdvSpy_f_cle'] = 'absent';
            $NeoBR['AdvSpy_f_cle_Max'] = 0;
            $NeoBR['AdvSpy_f_clo'] = 'absent';
            $NeoBR['AdvSpy_f_clo_Max'] = 0;
            $NeoBR['AdvSpy_f_cro'] = 'absent';
            $NeoBR['AdvSpy_f_cro_Max'] = 0;
            $NeoBR['AdvSpy_f_vb'] = 'absent';
            $NeoBR['AdvSpy_f_vb_Max'] = 0;
            $NeoBR['AdvSpy_f_vc'] = 'absent';
            $NeoBR['AdvSpy_f_vc_Max'] = 0;
            $NeoBR['AdvSpy_f_rec'] = 'absent';
            $NeoBR['AdvSpy_f_rec_Max'] = 0;
            $NeoBR['AdvSpy_f_bom'] = 'absent';
            $NeoBR['AdvSpy_f_bom_Max'] = 0;
            $NeoBR['AdvSpy_f_des'] = 'absent';
            $NeoBR['AdvSpy_f_des_Max'] = 0;
            $NeoBR['AdvSpy_f_edlm'] = 'absent';
            $NeoBR['AdvSpy_f_edlm_Max'] = 0;
            $NeoBR['AdvSpy_f_traq'] = 'absent';
            $NeoBR['AdvSpy_f_traq_Max'] = 0;
            $NeoBR['AdvSpy_d_mis'] = 'absent';
            $NeoBR['AdvSpy_d_mis_Max'] = 0;
            $NeoBR['AdvSpy_d_lle'] = 'absent';
            $NeoBR['AdvSpy_d_lle_Max'] = 0;
            $NeoBR['AdvSpy_d_llo'] = 'absent';
            $NeoBR['AdvSpy_d_llo_Max'] = 0;
            $NeoBR['AdvSpy_d_gaus'] = 'absent';
            $NeoBR['AdvSpy_d_gaus_Max'] = 0;
            $NeoBR['AdvSpy_d_ion'] = 'absent';
            $NeoBR['AdvSpy_d_ion_Max'] = 0;
            $NeoBR['AdvSpy_d_pla'] = 'absent';
            $NeoBR['AdvSpy_d_pla_Max'] = 0;
            $NeoBR['AdvSpy_d_pb'] = 'absent';
            $NeoBR['AdvSpy_d_pb_Max'] = 0;
            $NeoBR['AdvSpy_d_gb'] = 'absent';
            $NeoBR['AdvSpy_d_gb_Max'] = 0;
        }

        // Criteres de flottes/def/batiments/tech présent/min/max
        foreach ($lang['DicOgame']['SpyCatList'] as $Cat => $Catname) {
            foreach ($lang['DicOgame'][$Cat] as $num => $valuesarray) {
                $PostVar = $valuesarray['PostVar'];
                $OgsName = $valuesarray['OgsName'];

                if ($BlockRecherche['AdvSpy_' . $PostVar] == 'present') {
                    $SqlRequest .= "\nAND `$OgsName` >= '1'";
                } elseif ($BlockRecherche['AdvSpy_' . $PostVar] == 'absent') {
                    $SqlRequest .= "\nAND `$OgsName` = '0'";
                }

                $MinVal = '';
                $MaxVal = '';

                $MinVar = 'AdvSpy_' . $PostVar . '_Min';
                $MaxVar = 'AdvSpy_' . $PostVar . '_Max';

                $MinVal = $BlockRecherche[$MinVar];
                $MaxVal = $BlockRecherche[$MaxVar];

                if (array_key_exists($MinVar, $NeoBR)) {
                    $MinVal = $NeoBR[$MinVar];
                }
                if (array_key_exists($MaxVar, $NeoBR)) {
                    $MaxVal = $NeoBR[$MaxVar];
                }

                if (($MinVal != '') or ($MinVal === 0) or ($MinVal === '0')) {
                    $SqlRequest .= "\nAND `$OgsName` >= '$MinVal'";
                }
                if (($MaxVal != '') or ($MaxVal === 0) or ($MaxVal === '0')) {
                    $SqlRequest .= "\nAND `$OgsName` <= '$MaxVal'";
                }

            }
        }


        //Critères metal/cristal/deut/energie mini
        if ($BlockRecherche['AdvSpy_RessourceMinMetal']) {
            $SqlRequest .= "\nAND p.metal >= '" . (intval($BlockRecherche['AdvSpy_RessourceMinMetal']) *
                1000) . "'";
        }
        if ($BlockRecherche['AdvSpy_RessourceMinCristal']) {
            $SqlRequest .= "\nAND p.cristal >= '" . (intval($BlockRecherche['AdvSpy_RessourceMinCristal']) *
                1000) . "'";
        }
        if ($BlockRecherche['AdvSpy_RessourceMinDeut']) {
            $SqlRequest .= "\nAND p.deuterium >= '" . (intval($BlockRecherche['AdvSpy_RessourceMinDeut']) *
                1000) . "'";
        }
        if ($BlockRecherche['AdvSpy_RessourceMinEnergie']) {
            $SqlRequest .= "\nAND p.energie >= '" . (intval($BlockRecherche['AdvSpy_RessourceMinEnergie']) *
                1000) . "'";
        }


        if ($BlockRecherche['AdvSpy_ShowOnlyMoon']) {
            $SqlRequest .= "\nAND p.energie <= '0'";
        }

        if ($BlockRecherche['AdvSpy_OnlyMyScan']) {
            $SqlRequest .= "\nAND p.sender_id = '" . $AdvSpyConfig['User_Data']['user_id'] .
                "'";
        }


        $SqlRequest .= "\n ORDER BY p.dateRE DESC";
        return $SqlRequest;
    }

}


/**
 *
 **/
function AdvSpy_GetRaidAlertSqlRequestFromBlockRecherche()
{
    global $AdvSpyConfig, $lang, $BlockRecherche;

    $RAtablename = $AdvSpyConfig['Settings']['AdvSpy_TableName_RaidAlert'];

    $SqlRequest = "SELECT * FROM " . $RAtablename . "," . TABLE_USER . "
	WHERE `RaidOwner`=`user_id`";
    $SqlRequest .= "\nAND `RaidGalaxy`>=" . $BlockRecherche['AdvSpy_GalaxyMin'];
    $SqlRequest .= "\nAND `RaidGalaxy`<=" . $BlockRecherche['AdvSpy_GalaxyMax'];
    $SqlRequest .= "\nAND `RaidSystem`>=" . $BlockRecherche['AdvSpy_SystemMin'];
    $SqlRequest .= "\nAND `RaidSystem`<=" . $BlockRecherche['AdvSpy_SystemMax'];
    $SqlRequest .= "\nAND `RaidRow`>=" . $BlockRecherche['AdvSpy_RowMin'];
    $SqlRequest .= "\nAND `RaidRow`<=" . $BlockRecherche['AdvSpy_RowMax'];
    $SqlRequest .= "\nAND `RaidDate`>=";
    $SqlRequest .= time() - ($BlockRecherche['AdvSpy_RaidAgeMax']);
    //$SqlRequest.=" ORDER BY `RaidDate` DESC";
    return $SqlRequest;
}


//===================Save/load======================
// SaveType 0 = Sauvegarde publique générale (par défaut)
// SaveType 1 = Sauvegarde privée partagée  (publique)
// SaveType 2 = Sauvegarde privée (pas publique)
// 3 à 7 reservé pour plus tard
// 8 et 9 pour les sauvegardes 'spéciales'
// SaveType 8 = Options personelles
// SaveType 9 = Options d'administration


// saveload/sql/request
function AdvSpy_SaveLoad_GetSqlRequestForSaveList($OnlyPublic = 0, $OwnerId = '')
{
    global $AdvSpyConfig, $lang;

    $SqlRequest = "SELECT * FROM " . $AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad'] .
        "," . TABLE_USER . "
WHERE `SaveOwner`=`user_id`";

    if ($OnlyPublic) {
        $SqlRequest .= "\nAND `SaveType`<=1";
    } else {
        $SqlRequest .= "\nAND `SaveType`<=2";
    }

    if ($OwnerId) {
        $SqlRequest .= "\nAND `SaveOwner`=$OwnerId";
    }

    $SqlRequest .= "\nORDER BY `SaveName` ASC";
    return $SqlRequest;
}


function AdvSpy_SaveLoad_GetSqlRequestForNewSave($SaveOwner = 0, $SaveType, $SaveName,
    $SaveData)
{
    global $AdvSpyConfig, $lang;
    $SqlRequest = "INSERT INTO " . $AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad'] .
        "
(`SaveId`, `SaveOwner`, `SaveType`, `SaveData`, `SaveName`)
VALUES ('', '$SaveOwner','$SaveType','$SaveData','$SaveName');";
    return $SqlRequest;
}


function AdvSpy_SaveLoad_GetSqlRequestForEditSave($SaveId = 0, $SaveOwner = 0, $SaveType,
    $SaveName, $SaveData)
{
    global $AdvSpyConfig, $lang;
    $SqlRequest = "UPDATE " . $AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad'] .
        "
SET `SaveOwner` = '$SaveOwner',`SaveType`='$SaveType',`SaveData`='$SaveData',`SaveName`='$SaveName'
WHERE `SaveId`='$SaveId'
LIMIT 1;";
    return $SqlRequest;
}

/**
 *
 **/
function AdvSpy_SaveLoad_GetSqlRequestForLoad($SaveId = 0)
{
    global $AdvSpyConfig, $lang;
    $SqlRequest = "SELECT * FROM `" . $AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad'] .
        "`
WHERE `SaveId`='$SaveId';";
    return $SqlRequest;
}

/**
 *
 **/
function AdvSpy_SaveLoad_GetSqlRequestForDelete($SaveId = 0)
{
    global $AdvSpyConfig, $lang;
    $SqlRequest = "DELETE FROM `" . $AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad'] .
        "`
WHERE `SaveId`='$SaveId' LIMIT 1;";
    return $SqlRequest;
}

/**
 *
 **/
function AdvSpy_SaveLoad_GetLoadedBlockRecherche($SaveId, $BlockRecherche)
{
    global $AdvSpyConfig, $lang, $db;

    $requete = AdvSpy_SaveLoad_GetSqlRequestForLoad($SaveId);
    $result = $db->sql_query($requete);
    $SaveList = array();
    while ($val = @mysql_fetch_assoc($result)) {
        $SaveList[] = $val;
    }
    //$SaveList[0][SaveId][SaveOwner][SaveType][SaveData][SaveName]
    $SaveDataArray = AdvSpy_string_to_array($SaveList[0]['SaveData']);

    foreach ($SaveDataArray as $Var => $Value) {
        $BlockRecherche[$Var] = $Value;
    }
    return $BlockRecherche;
}


/**
 *
 **/
function AdvSpy_SaveLoad_GetSaveArrayFromBlockRecherche($BlockRecherche)
{
    global $AdvSpyConfig, $lang;
    $SaveArray = array();

    if ($BlockRecherche['AdvSpy_SaveElement_Tris'] == 'ON') {
        $SaveArray['AdvSpy_TRIS'] = $BlockRecherche['AdvSpy_TRIS'];
        $SaveArray['AdvSpy_SearchResult_Min'] = $BlockRecherche['AdvSpy_SearchResult_Min'];
        $SaveArray['AdvSpy_SearchResult_Max'] = $BlockRecherche['AdvSpy_SearchResult_Max'];
        $SaveArray['AdvSpy_OnlyMyScan'] = $BlockRecherche['AdvSpy_OnlyMyScan'];
    }
    if ($BlockRecherche['AdvSpy_SaveElement_Secteur'] == 'ON') {
        $SaveArray['AdvSpy_GalaxyMin'] = $BlockRecherche['AdvSpy_GalaxyMin'];
        $SaveArray['AdvSpy_GalaxyMax'] = $BlockRecherche['AdvSpy_GalaxyMax'];
        $SaveArray['AdvSpy_SystemMin'] = $BlockRecherche['AdvSpy_SystemMin'];
        $SaveArray['AdvSpy_SystemMax'] = $BlockRecherche['AdvSpy_SystemMax'];
        $SaveArray['AdvSpy_RowMin'] = $BlockRecherche['AdvSpy_RowMin'];
        $SaveArray['AdvSpy_RowMax'] = $BlockRecherche['AdvSpy_RowMax'];
        $SaveArray['AdvSpy_CoordsToHide'] = $BlockRecherche['AdvSpy_CoordsToHide'];
    }

    if ($BlockRecherche['AdvSpy_SaveElement_RE'] == 'ON') {
        $SaveArray['AdvSpy_AgeMax'] = $BlockRecherche['AdvSpy_AgeMax'];
        $SaveArray['AdvSpy_NoDoublon'] = $BlockRecherche['AdvSpy_NoDoublon'];
        $SaveArray['AdvSpy_ShowOnlyMoon'] = $BlockRecherche['AdvSpy_ShowOnlyMoon'];
        $SaveArray['AdvSpy_PlanetSearch'] = $BlockRecherche['AdvSpy_PlanetSearch'];
        foreach ($lang['DicOgame']['SpyCatList'] as $Cat => $name) {
            $SaveArray["AdvSpy_Scanned_$Cat"] = $BlockRecherche["AdvSpy_Scanned_$Cat"];
            $SaveArray["AdvSpy_Reduire_$Cat"] = $BlockRecherche["AdvSpy_Reduire_$Cat"];
        }
    }
    if ($BlockRecherche['AdvSpy_SaveElement_Joueur'] == 'ON') {
        $SaveArray['AdvSpy_OnlyInactif'] = $BlockRecherche['AdvSpy_OnlyInactif'];
        $SaveArray['AdvSpy_PlayerSearch'] = $BlockRecherche['AdvSpy_PlayerSearch'];
        $SaveArray['AdvSpy_AllySearch'] = $BlockRecherche['AdvSpy_AllySearch'];
    }
    if ($BlockRecherche['AdvSpy_SaveElement_Ressources'] == 'ON') {
        $SaveArray['AdvSpy_SeuilGrandNombre'] = $BlockRecherche['AdvSpy_SeuilGrandNombre'];
        $SaveArray['AdvSpy_OnlyGrandNombre'] = $BlockRecherche['AdvSpy_OnlyGrandNombre'];
        $SaveArray['AdvSpy_RessourceMinMetal'] = $BlockRecherche['AdvSpy_RessourceMinMetal'];
        $SaveArray['AdvSpy_RessourceMinCristal'] = $BlockRecherche['AdvSpy_RessourceMinCristal'];
        $SaveArray['AdvSpy_RessourceMinDeut'] = $BlockRecherche['AdvSpy_RessourceMinDeut'];
        $SaveArray['AdvSpy_RessourceMinEnergie'] = $BlockRecherche['AdvSpy_RessourceMinEnergie'];
    }
    if ($BlockRecherche['AdvSpy_SaveElement_Analyse'] == 'ON') {
        $SaveArray['AdvSpy_TauxPatateMini'] = $BlockRecherche['AdvSpy_TauxPatateMini'];
        $SaveArray['AdvSpy_HideRaided'] = $BlockRecherche['AdvSpy_HideRaided'];
        $SaveArray['AdvSpy_OnlyRaided'] = $BlockRecherche['AdvSpy_OnlyRaided'];
        $SaveArray['AdvSpy_RaidAgeMax'] = $BlockRecherche['AdvSpy_RaidAgeMax'];
        $SaveArray['AdvSpy_PatateTotalMin'] = $BlockRecherche['AdvSpy_PatateTotalMin'];
        $SaveArray['AdvSpy_PatateTotalMax'] = $BlockRecherche['AdvSpy_PatateTotalMax'];
    }

    foreach ($lang['DicOgame']['SpyCatList'] as $Cat => $Catname) {
        if ($BlockRecherche["AdvSpy_SaveElement_MM$Cat"] == 'ON') {
            foreach ($lang['DicOgame'][$Cat] as $num => $valuesarray) {
                $SaveArray["AdvSpy_" . $valuesarray['PostVar']] = $BlockRecherche["AdvSpy_" . $valuesarray['PostVar']];
                $SaveArray["AdvSpy_" . $valuesarray['PostVar'] . "_Min"] = $BlockRecherche["AdvSpy_" .
                    $valuesarray['PostVar'] . "_Min"];
                $SaveArray["AdvSpy_" . $valuesarray['PostVar'] . "_Max"] = $BlockRecherche["AdvSpy_" .

                    $valuesarray['PostVar'] . "_Max"];
            }
        }
    }

    if ($BlockRecherche['AdvSpy_SaveElement_Sim_atk'] == 'ON') {
        foreach ($lang['DicOgame']['Fleet'] as $num => $valuesarray) {
            $SaveArray['AdvSpy_Sim_atk_' . $valuesarray['PostVar']] = $BlockRecherche['AdvSpy_Sim_atk_' .
                $valuesarray['PostVar']];
        }
    }
    if ($BlockRecherche['AdvSpy_SaveElement_Sim_atk_tech'] == 'ON') {
        $SaveArray['AdvSpy_Sim_atk_t_armes'] = $BlockRecherche['AdvSpy_Sim_atk_t_armes'];
        $SaveArray['AdvSpy_Sim_atk_t_bouclier'] = $BlockRecherche['AdvSpy_Sim_atk_t_bouclier'];
        $SaveArray['AdvSpy_Sim_atk_t_protect'] = $BlockRecherche['AdvSpy_Sim_atk_t_protect'];
    }
    if ($BlockRecherche['AdvSpy_SaveElement_Sim_def'] == 'ON') {
        foreach ($lang['DicOgame']['Fleet'] as $num => $valuesarray) {
            $SaveArray['AdvSpy_Sim_def_' . $valuesarray['PostVar']] = $BlockRecherche['AdvSpy_Sim_def_' .
                $valuesarray['PostVar']];
        }
        foreach ($lang['DicOgame']['Def'] as $num => $valuesarray) {
            $SaveArray['AdvSpy_Sim_def_' . $valuesarray['PostVar']] = $BlockRecherche['AdvSpy_Sim_def_' .
                $valuesarray['PostVar']];
        }
    }

    if ($BlockRecherche['AdvSpy_SaveElement_Sim_def_tech'] == 'ON') {
        $SaveArray['AdvSpy_Sim_def_t_armes'] = $BlockRecherche['AdvSpy_Sim_def_t_armes'];
        $SaveArray['AdvSpy_Sim_def_t_bouclier'] = $BlockRecherche['AdvSpy_Sim_def_t_bouclier'];
        $SaveArray['AdvSpy_Sim_def_t_protect'] = $BlockRecherche['AdvSpy_Sim_def_t_protect'];
    }

    return $SaveArray;

}


/**
 *
 * @access public
 * @return void
 **/
function AdvSpy_log($message, $type = "Info")
{
    global $AdvSpyConfig, $lang;
    if ($AdvSpyConfig['Settings']['EnableLog']) {
        log_('debug', "-AdvSpy- (v " . $AdvSpyConfig['version']['advspy'] . ") [$type] <" .
            $AdvSpyConfig['User_Data']['user_name'] . "> : $message");
    }
}


/**
 *
 **/
function AdvSpy_SaveLoad_GetHtmlSaveRadioList($SaveList, $RadioName =
    "AdvSpy_SaveIdToLoad", $RadioIdPrefix = "AdvSpy_SaveIdToLoad_g_")
{
    //$SaveList[0]=>Array([SaveId][SaveOwner][SaveType][SaveData][SaveName]
    //[user_id][user_name][user_password][user_admin][user_coadmin][user_active][user_regdate][user_lastvisit]
    //[user_galaxy][user_system][planet_added_web][planet_added_ogs][planet_exported][search][spy_added_web][spy_added_ogs][spy_exported]
    //[rank_added_web][rank_added_ogs][rank_exported][user_skin][user_stat_name][management_user][management_ranking][disable_ip_check]
    //$out.=nl2br(print_r($SaveList,1));

    $out = "<table width=\"100%\">";

    foreach ($SaveList as $SaveNum => $Save) {
        $SaveId = $Save['SaveId'];
        $SaveName = $Save['SaveName'];
        $SaveOwnerName = $Save['user_name'];
        if ($Save['SaveOwner'] == '1') {
            $SaveOwnerName = '-AdvSpy-';
        }

        $out .= "<tr><td class=\"f\" align=\"left\">";
        $out .= "<input type=\"radio\" name=\"$RadioName\" id=\"" . $RadioIdPrefix . $SaveId .
            "\" value=\"$SaveId\" />";
        $out .= "<label for=\"" . $RadioIdPrefix . $SaveId . "\" style=\"cursor:pointer\"><b>$SaveName</b> (par $SaveOwnerName)</label>
" . AdvSpy_GetHtml_OgspyTooltipImage("Eléments de la sauvegarde différent de la recherche actuèlle : ",
            AdvSpy_SaveLoad_GetHtmlSaveInfo(AdvSpy_string_to_array($Save['SaveData']), 1),
            300, 'images/help.png') . "
		<br/>";

        $out .= "</td></tr>";

        // ".AdvSpy_GetHtml_OgspyTooltipImage("Contenu complet de cette sauvegarde : "							,AdvSpy_SaveLoad_GetHtmlSaveInfo(AdvSpy_string_to_array($Save['SaveData']),0),300,'images/help.png')."

    }

    $out .= "</table>";
    return $out;
}


/**
 *
 * @access public
 * @return void
 **/
function AdvSpy_SaveLoad_GetHtmlSaveInfo($SaveData, $ShowOnlyDiffs = 0)
{
    global $AdvSpyConfig, $lang, $BlockRecherche;
    $out = "<table border=\"0\">";
    foreach ($SaveData as $PostVar => $Value) {
        if ((array_key_exists($PostVar, $SaveData))) {

            if (($Value != $BlockRecherche[$PostVar]) or ($ShowOnlyDiffs != 1)) {
                $SaveValue = $SaveData[$PostVar];
                $TexteBarre = false;
                if (($SaveValue == '')) {
                    if (($lang['BlockRechercheElements'][$PostVar]['Type'] == 'onoff')) {
                        $SaveValue = 'OFF';
                    }
                    if ((strpos($lang['BlockRechercheElements'][$PostVar]['Type'], '*') ===
                        0)) {
                        $TexteBarre = true;
                    }
                }

                if (($lang['BlockRechercheElements'][$PostVar]['Type'] == 'duration')) {
                    $SaveValue = AdvSpy_duration($SaveValue);
                }

                if ($PostVar == 'AdvSpy_TRIS') {
                    $SaveValue = $AdvSpyConfig['Liste_Tris'][$SaveValue];
                }

                if ($TexteBarre) {
                    $out .= "<tr><td colspan=\"2\"><strike>" . $lang['BlockRechercheElements'][$PostVar]['Name'] .
                        "</strike></td></tr>";
                } else {
                    $out .= "<tr><td>" . $lang['BlockRechercheElements'][$PostVar]['Name'] .
                        "</td><td>" . $SaveValue . "</td></tr>";
                }
            }
        }
    }
    return $out . "</tr></table>";
}


/**
 *
 * @access public
 * @return TRUE/FALSE
 **/
function AdvSpy_CheckVarAgainstTypeMask($VarValue, $TypeMask)
{
    // $TypeMask =
    // integer 1 8 = nombre entier de 1 à 8 (inclus)
    // si pas de max... pas de max.
    // duration = entier (en secondes, convertis en texte)
    // *onoff = 'ON' (en maj) ou '' (rien=off)
    // *num = (numeric) nombre entier (un . pour virgule)
    // boolean = 0 ou 1
    // L'étoile * en 1ere position signifie que NULL ('') est aussi accepté (avec le 0)
    // *integer = pareil pour un nombre entier , l'etoile compte partout (y compris dans duration ...)

    // le cas des variables vides
    if (strpos($TypeMask, '*') === 0) {
        if ($VarValue == '') {
            return true;
        }
        $TypeMask = substr($TypeMask, 1); // on vire l'étoile (important)
    } else {
        if ($VarValue == '') {
            return false;
        }
    }

    // on/off (le cas off (variable vide) est deja pris en compte)
    if (substr($TypeMask, 0, strlen('onoff')) == 'onoff') {
        if ($VarValue == 'ON') {
            return true;
        } else {
            return false;
        }
    }

    // le split...
    $TypeMaskArr = array();
    $TypeMaskArr = explode(' ', $TypeMask);

    // duration est un entier positif, on ajuste le type pour que l'analyse se fasse comme 'integer' <eh ouais, ca economise une fonction, fleme pawa>
    if ($TypeMaskArr[0] == 'duration') {
        $TypeMaskArr = array();
        $TypeMaskArr[0] = 'integer';
        $TypeMaskArr[1] = 1; // le minimum (positif)
    }

    // au choix : 0 ou 1
    if ($TypeMaskArr[0] == 'boolean') {
        $TypeMaskArr = array();
        $TypeMaskArr[0] = 'integer';
        $TypeMaskArr[1] = 0; // le minimum
        $TypeMaskArr[2] = 1; // le maximum
    }


    // Le cas des integer
    if ($TypeMaskArr[0] == 'integer') {
        if (!is_numeric($VarValue)) {
            return false;
        }
        if (strstr($VarValue, '.')) {
            return false;
        } // pas de virgule on a dis !
        // avec min
        if (isset($TypeMaskArr[1])) {
            if ($VarValue < $TypeMaskArr[1]) {
                return false;
            }
        }
        // avec max
        if (isset($TypeMaskArr[2])) {
            if ($VarValue > $TypeMaskArr[2]) {
                return false;
            }
        }
        // les tests élimiatoires sont passés donc il est validé.
        return true;
    }

    // Le cas des 'num'(ériques) : les nombres à virgules (.)
    if ($TypeMaskArr[0] == 'num') {
        if (!is_numeric($VarValue)) {
            return false;
        }
        // avec min
        if (isset($TypeMaskArr[1])) {
            if ($VarValue < $TypeMaskArr[1]) {
                return false;
            }
        }
        // avec max
        if (isset($TypeMaskArr[2])) {
            if ($VarValue > $TypeMaskArr[2]) {
                return false;
            }
        }
        // les tests élimiatoires sont passés donc il est validé.
        return true;
    }

    //à finir donc ...

    //ipa = indifferent/present/absent


    //string


    //par défaut ...
    return true;
}


// merci à jamin42b at gmail dot com pour sa fonction (+ mes ajustements)
// http://fr2.php.net/manual/fr/function.print-r.php#56437
function AdvSpy_Print_Rvar($array, $base)
{
    $js = '';
    foreach ($array as $key => $val) {
        if (is_array($val)) {
            $js .= AdvSpy_Print_Rvar($val, $base . (is_numeric($key) ? '[' . $key . ']' :
                "['" . addslashes($key) . "']"));
        } else {
            $js .= $base;
            $js .= is_numeric($key) ? '[' . $key . ']' : "['" . addslashes($key) . "']";
            $js .= ' = ';
            $js .= is_numeric($val) ? '' . $val . '' : "'" . addslashes($val) . "'";
            $js .= ";\n";
        }
    }
    return $js;
}


function AdvSpy_GetEmpirePlanetsListAsOptions()
{
    global $AdvSpyConfig, $lang, $BlockRecherche;
    $Str = '';

    foreach ($AdvSpyConfig['User_Empire']['building'] as $num => $planetarray) {
        if (!$planetarray['BaLu'] && $planetarray['coordinates']) {
            $Coord = preg_split('/:/', $planetarray['coordinates']);
            $Str .= "<option value='" . $Coord[0] . ":" . $Coord[1] . "'>" . $planetarray['planet_name'] .
                "-&gt; " . $Coord[0] . ":" . $Coord[1] . "</option>\n";
        }
    }
    return $Str;
}


//function AdvSpy_Options_GetPostVar($OptionVar){ return "AdvSpy_Option_".$OptionVar; }


/**
 **/
function AdvSpy_Options_GetValue($OptionVar, $ForceUnlock = 0, $ForceAdmin = 0)
{
    global $AdvSpyConfig, $lang;
    /*
    $lang['Options'][$OptionVar]['Name']='xx';
    $lang['Options'][$OptionVar]['Desc']='xx';
    $lang['Options'][$OptionVar]['Type']='xx';
    $lang['Options'][$OptionVar]['Value_Config']='xx';
    $lang['Options'][$OptionVar]['Value_Admin']='xx';
    $lang['Options'][$OptionVar]['Value_Admin_IsLocked']='0';
    $lang['Options'][$OptionVar]['Value_User']='xx';
    */
    $TheValue = '';
    if (isset($lang['Options'][$OptionVar]['Value_Config'])) {
        $TheValue = $lang['Options'][$OptionVar]['Value_Config'];
    }
    if (isset($lang['Options'][$OptionVar]['Value_Admin'])) {
        $TheValue = $lang['Options'][$OptionVar]['Value_Admin'];
    }
    if ((isset($lang['Options'][$OptionVar]['Value_User'])) and ($ForceAdmin ==
        0)) {
        $TheValue = $lang['Options'][$OptionVar]['Value_User'];
    }

    if ($ForceUnlock == 0) {
        if (isset($lang['Options'][$OptionVar]['Value_Admin_IsLocked'])) {
            if ($lang['Options'][$OptionVar]['Value_Admin_IsLocked']) {
                //bon ok il y a de la répétition dnas l'air, mais bon , il est tard et mes nerones me disent que ça ira bien comme ça.
                if (isset($lang['Options'][$OptionVar]['Value_Admin'])) {
                    $TheValue = $lang['Options'][$OptionVar]['Value_Admin'];
                }
            }
        }
    }


    return $TheValue;
}


/**
 * @access public
 * @return void
 **/
function AdvSpy_Options_SetValue($OptionVar, $OptionValue, $level = 'User', $locked = 0) {
    global $AdvSpyConfig, $lang;
    /*
    $lang['Options'][$OptionVar]['Name']='xx';
    $lang['Options'][$OptionVar]['Desc']='xx';
    $lang['Options'][$OptionVar]['Type']='xx';
    $lang['Options'][$OptionVar]['Value_Config']='xx';
    $lang['Options'][$OptionVar]['Value_Admin']='xx';
    $lang['Options'][$OptionVar]['Value_Admin_IsLocked']='0';
    $lang['Options'][$OptionVar]['Value_User']='xx';
    */
    $level = strtolower($level);

    if (!isset($lang['Options'][$OptionVar]['Name'])) {
        return false;
    }
    if (!isset($lang['Options'][$OptionVar]['Desc'])) {
        return false;
    }
    if (!isset($lang['Options'][$OptionVar]['Type'])) {
        return false;
    }
    if (!AdvSpy_CheckVarAgainstTypeMask($OptionValue, $lang['Options'][$OptionVar]['Type'])) {
        return false;
    }

    if ($level == 'user') {
        // c'est pas la peine de verifier Admin_IsLocked ou pas: le Options_GetValue s'en charge
        $lang['Options'][$OptionVar]['Value_User'] = $OptionValue;
    }

    if ($level == 'admin') {
        if ($AdvSpyConfig['UserIsAdmin']) {
            $lang['Options'][$OptionVar]['Value_Admin'] = $OptionValue;
            if ($locked) {
                $lang['Options'][$OptionVar]['Value_Admin_IsLocked'] = 1;
            } else {
                $lang['Options'][$OptionVar]['Value_Admin_IsLocked'] = 0;
            }
        }
    }

}


/**
 * @access public
 * @return void
 **/
function AdvSpy_Options_GetHtmlFormatedValue($Value = '', $Type)
{
    global $AdvSpyConfig, $lang;

    if (strpos($Type, '*') === 0) {
        $Type = substr($Type, 1);
    } // on vire l'étoile (important)
    $Type = strtolower($Type);

    if ($Type == 'boolean') {
        if ($Value == '') {
            return '';
        } elseif ($Value == 1) {
            return "<img border=\"0\" src=\"./mod/advspy/images/checked.png\" title=\"" . $lang['UI_Lang']['OptionIsYes'] .
                " ($Value)\"/>";
        } elseif ($Value == 0) {
            return "<img border=\"0\" src=\"./mod/advspy/images/unchecked.png\" title=\"" . $lang['UI_Lang']['OptionIsNo'] .
                " ($Value)\"/>";
        }
    }

    if ($Type == 'string') {
        return $Value;
    }

    return $Value;
}


/**
 * la partie chargement des "Options"

 * @access public
 * @return void
 **/
function AdvSpy_Options_ImportFromDB($UserId = -1)
{
    global $AdvSpyConfig, $lang, $db;

    if ($UserId == '') {
        $UserId = -1;
    }
    if (($UserId < 1) and ($AdvSpyConfig['UserIsAdmin'])) {
        $Current_Edition_Target = $AdvSpyConfig['User_Data']['user_id'];
    } else {
        $Current_Edition_Target = $UserId;
    }

    $requete = "SELECT * FROM `" . $AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad'] .
        "`
			WHERE `SaveType`='9'
			AND `SaveOwner`='0'
			OR `SaveType`='8'
			AND `SaveOwner`='$Current_Edition_Target'";

    $result = $db->sql_query($requete);
    while ($val = @mysql_fetch_assoc($result)) {
        //SaveId 	SaveOwner 	SaveType 	SaveData 	SaveName
        //$val['SaveType']
        $SaveDataArray = AdvSpy_string_to_array($val['SaveData']);

        foreach ($SaveDataArray as $OptionVar => $OptionProp) {

            if (($val['SaveType'] == '9') and ($val['SaveOwner'] == '0')) { // admin
                $islocked = 0;
                if (isset($OptionProp['Value_Admin_IsLocked'])) {
                    $islocked = $OptionProp['Value_Admin_IsLocked'];
                }

                if (isset($OptionProp['Value_Admin'])) {
                    AdvSpy_Options_SetValue($OptionVar, $OptionProp['Value_Admin'], 'Admin', $islocked);
                }
            }

            if (($val['SaveType'] == '8') and ($val['SaveOwner'] == $Current_Edition_Target)) { // user
                if (isset($OptionProp['Value_User'])) {
                    AdvSpy_Options_SetValue($OptionVar, $OptionProp['Value_User'], 'User', $islocked);
                }
            }

        }

    }
    unset($result);
}


/**
 * @access public
 * @return void
 **/
function AdvSpy_Options_ExportToDB($UserId = -1)
{
    global $AdvSpyConfig, $lang, $db;
    //-1 = Current user
    //0 = Admin
    //1+ = user x
    $SaveName = '';
    if ($UserId == '') {
        $UserId = -1;
    }
    if ($UserId <= -1) {
        $Current_Edition_Target = $AdvSpyConfig['User_Data']['user_id'];
        $SaveType = 8;
        $SaveName = 'Option perso: ' . $AdvSpyConfig['User_Data']['user_name'];
    }
    if (($UserId == 0) and ($AdvSpyConfig['UserIsAdmin'])) {
        $Current_Edition_Target = 0;
        $SaveType = 9;
        $SaveName = 'Option d`Administration';
    }
    if (($UserId >= 1) and ($AdvSpyConfig['UserIsAdmin'])) {
        $Current_Edition_Target = $UserId;
        $SaveType = 8;
        $SaveName = 'Option perso: ' . $AdvSpyConfig['User_Data']['user_name'];
    }


    $SaveData = AdvSpy_Options_GetOptionsArrayForSave($Current_Edition_Target);

    $query = "SELECT * FROM `" . $AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad'] .
        "`
	WHERE `SaveType`='$SaveType'
	AND `SaveOwner`='$Current_Edition_Target'
	LIMIT 1";


    $saveadmin = 0;
    if ($Current_Edition_Target == 0) {
        $saveadmin = 1;
    }

    if (!$db->sql_numrows($db->sql_query($query))) { // aucune sauvegarde n'existe: INSERT

        $SaveData = AdvSpy_array_to_string(AdvSpy_Options_GetOptionsArrayForSave($saveadmin));

        $query = "INSERT INTO " . $AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad'] .
            "
		(`SaveId`, `SaveOwner`, `SaveType`, `SaveData`, `SaveName`)
		VALUES ( NULL , '$Current_Edition_Target','$SaveType','$SaveData','$SaveName')";
        $db->sql_query($query);

    } else { // une sauvegarde existe déjà, UPDATE au lieu de INSERT

        $SaveData = AdvSpy_array_to_string(AdvSpy_Options_GetOptionsArrayForSave($saveadmin));

        $query = "UPDATE " . $AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad'] . "
			SET `SaveData`='$SaveData'
			WHERE `SaveOwner`='$Current_Edition_Target'
			AND `SaveType`='$SaveType'
			LIMIT 1";

        $db->sql_query($query);
    }


    /*
    "UPDATE IGNORE `ogspy_advspy_save`
    SET `SaveOwner` = '3',
    `SaveType`='8',
    `SaveData`='',
    `SaveName`='ahhh'
    WHERE `SaveOwner` =3 LIMIT 1 ";
    */

}


function AdvSpy_Options_ReadPostedOptions(){
	global $AdvSpyConfig,$lang;

	//-1 = Current user
	//0 = Admin
	//1+ = user x

	$Current_Edition_Target=-1;
	if ((isset($_POST['AdvSpy_OptionsTarget'])) AND ($AdvSpyConfig['UserIsAdmin']) ) {
		if (is_numeric($_POST['AdvSpy_OptionsTarget'])) { $Current_Edition_Target=$_POST['AdvSpy_OptionsTarget']; }
	}

	foreach($lang['Options'] as $OptionVar=>$OptionProp){
		if (isset($_POST["AdvSpy_Options_$OptionVar"])) {
			$PostedOption=$_POST["AdvSpy_Options_$OptionVar"];
			if (AdvSpy_CheckVarAgainstTypeMask($PostedOption,$OptionProp['Type'])) {
				if ($Current_Edition_Target==0) {
					if ($AdvSpyConfig['UserIsAdmin']) {

						$AdminLock=0;
						if (isset($_POST["AdvSpy_Options_LockAdmin_".$OptionVar])) {
							if ($_POST["AdvSpy_Options_LockAdmin_".$OptionVar]=='ON') { $AdminLock=1;
							} else { $AdminLock=0; }
						}
						//print "-$AdminLock-";
						AdvSpy_Options_SetValue($OptionVar,$PostedOption,'Admin',$AdminLock);
					}
				} elseif ($Current_Edition_Target==-1) {
					AdvSpy_Options_SetValue($OptionVar,$PostedOption,'User');
				} elseif ($Current_Edition_Target>=1) {
					AdvSpy_Options_SetValue($OptionVar,$PostedOption,'User');
				}
			}
		}
	}

}


function AdvSpy_Options_GetOptionsArrayForSave($AdminOptions = 0)
{
    global $AdvSpyConfig, $lang;
    $outarray = array();
    foreach ($lang['Options'] as $OptionVar => $OptionProp) {
        if ($AdminOptions == 0) {
            if (isset($OptionProp['Value_User'])) {
                $outarray[$OptionVar]['Value_User'] = $OptionProp['Value_User'];
            }
        } else {
            if (isset($OptionProp['Value_Admin'])) {
                $outarray[$OptionVar]['Value_Admin'] = $OptionProp['Value_Admin'];
            }
            if (isset($OptionProp['Value_Admin_IsLocked'])) {
                $outarray[$OptionVar]['Value_Admin_IsLocked'] = $OptionProp['Value_Admin_IsLocked'];
            }
        }
    }
    return $outarray;
}




?>
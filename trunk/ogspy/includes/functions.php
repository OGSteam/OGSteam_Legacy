<?php
/** $Id$ **/
/**
 * Fonctions globales d'Ogspy
 * @package OGSpy
 * @subpackage main
 * @author Kyser
 * @copyright Copyright &copy; 2007, http://ogsteam.fr/
 * @version 3.04b ($Rev$)
 * @modified $Date$
 * @link $HeadURL$
 */

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

/**
 * Redirection des url
 * @param string $url Url de destination
 */
function redirection($url)
{
    if (headers_sent()) {
        die('<meta http-equiv="refresh" content="0; URL=' . $url . '">');
    } else {
        header("Location: " . $url);
        exit();
    }
}
/**
 * Verifie les droits en �criture d'ogspy sur un fichier ou repertoire 
 * @param string $path le fichier ou repertoire � tester
 * @return boolean True si acc�s en �criture
 * @comment http://fr.php.net/manual/fr/function.is-writable.php#68598
 */
function is__writable($path)
{

    if ($path{strlen($path) - 1} == '/')
        return is__writable($path . uniqid(mt_rand()) . '.tmp');

    elseif (@ereg('.tmp', $path)) {

        if (!($f = @fopen($path, 'w+')))
            return false;
        fclose($f);
        unlink($path);
        return true;

    } else
        die("return 0; // Or return error - invalid path...<br>" . getcwd() . "<br>$path");

}
/**
 * Ecrit un texte ou un tableau de texte dans un fichier
 * @param string $file Nom du fichier
 * @param string $mode Mode d'ouverture du fichier
 * @param string|Array $text Chaine ou tableau a �crire
 * @return boolean false si �chec
 */
function write_file($file, $mode, $text)
{
    if ($fp = fopen($file, $mode)) {
        if (is_array($text)) {
            foreach ($text as $t) {
                fwrite($fp, rtrim($t));
                fwrite($fp, "\r\n");
            }
        } else {
            fwrite($fp, $text);
            fwrite($fp, "\r\n");
        }
        fclose($fp);
        return true;
    } else
        return false;
}

/**
 * Ecrit un texte ou un tableau de texte dans un fichier compress� gz
 * @param string $file Nom du fichier
 * @param string $mode Mode d'ouverture du fichier
 * @param string|Array $text Chaine ou tableau a �crire
 * @return boolean false si �chec
 */
function write_file_gz($file, $mode, $text)
{
    if ($fp = gzopen($file . ".gz", $mode)) {
        if (is_array($text)) {
            foreach ($text as $t) {
                gzwrite($fp, rtrim($t));
                gzwrite($fp, "\r\n");
            }
        } else {
            gzwrite($fp, $text);
            gzwrite($fp, "\r\n");
        }
        gzclose($fp);
        return true;
    } else
        return false;
}

/**
 * Codage d'ip en hexadecimal
 * @param string $ip sous la forme xxx.xxx.xxx.xxx en IPv4 et xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx en IPv6
 * @return string IP cod� en hexa : HHHHHHHH en IPv4 et HHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH en IPv6
 */
function encode_ip($ip)
{
    if (substr_count($ip, ":") > 0 && substr_count($ip, ".") == 0) {
        $ip_sep = explode(":", uncompress_ipv6($ip));
        return implode($ip_sep);
    } else {
        $ip_sep = explode(".", $ip);
        return sprintf("%02x%02x%02x%02x", $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
    }
}

/**
 * D�compression d'adresses IPv6
 * @param string $ip IPv6 sous la forme xx::xxxx
 * @return string IP sous la forme xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx
 */
function uncompress_ipv6($ipv6)
{
    if (strpos($ipv6, "::") == false) {
        $e = explode(":", $ipv6);
        $s = 8 - sizeof($e) + 1;
        foreach ($e as $key => $val) {
            if ($val == "") {
                for ($i == 0; $i <= $s; $i++)
                    $newip[] = '0000';
            } else
                $newip[] = padleft($val, '0', 4);
        }
        $ip = implode(":", $newip);
    }
    return $ip;
}
/**
 * Compl�te une cha�ne avec des caract�res � gauche
 * @param string $str cha�ne � compl�ter
 * @param string $strChar caract�re de remplissage
 * @param string $strChar longeur finale
 * @return string cha�ne compl�t�e
 */
function padleft($str, $strChar, $intLength)
{
    $str = $str . '';
    if (strlen($str) > 0) {
        while (strlen($str) < $intLength)
            $str = $strChar . $str;
    }
    return $str;
}

/**
 * D�codage d'ip d'hexadecimal � la forme xxx.xxx.xxx.xxx
 * @param string $ip_encode IP encod�
 * @return string IP sous la forme xxx.xxx.xxx.xxx
 */
function decode_ip($ip_encode)
{
    $hexipbang = explode('.', chunk_split($ip_encode, 2, '.'));
    return hexdec($hexipbang[0]) . '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) .
        '.' . hexdec($hexipbang[3]);
}

/**
 * G�n�ratrice de mot de passe de 6 caract�res
 */
function password_generator()
{
    $string = "abBDEFcdefghijkmnPQRSTUVWXYpqrst23456789";
    srand((double)microtime() * 1000000);
    $password = '';
    for ($i = 0; $i < 6; $i++) {
        $password .= $string[rand() % strlen($string)];
    }
    return $password;
}
/**
 * Initialisation du tableau de confifuration $server_config
 */
function init_serverconfig()
{
    global $server_config;

    $request = "select * from " . TABLE_CONFIG;
    $result = mysql_query($request);

    while (list($name, $value) = mysql_fetch_row($result)) {
        $server_config[$name] = stripslashes($value);
    }
}

function set_server_view()
{
    global $db, $user_data;
    global $pub_enable_portee_missil, $pub_enable_members_view, $pub_enable_stat_view,
        $pub_galaxy_by_line_stat, $pub_system_by_line_stat, $pub_galaxy_by_line_ally, $pub_system_by_line_ally,
        $pub_nb_colonnes_ally, $pub_color_ally, $pub_enable_register_view, $pub_register_alliance,
        $pub_register_forum, $pub_open_user, $pub_open_admin;

    if (!check_var($pub_enable_members_view, "Num") || !check_var($pub_enable_stat_view,
        "Num") || !check_var($pub_galaxy_by_line_stat, "Num") || !check_var($pub_system_by_line_stat,
        "Num") || !check_var($pub_galaxy_by_line_ally, "Num") || !check_var($pub_system_by_line_ally,
        "Num")) {
        redirection("index.php?action=message&id_message=errordata&info");
    }
    if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
        redirection("planetindex.php?action=message&id_message=forbidden&info");
    }

    if (!isset($pub_galaxy_by_line_stat) || !isset($pub_system_by_line_stat) || !
        isset($pub_galaxy_by_line_ally) || !isset($pub_system_by_line_ally)) {
        redirection("index.php?action=message&id_message=setting_server_view_failed&info");
    }

    if (is_null($pub_enable_portee_missil))
        $pub_enable_portee_missil = 0;
    if (is_null($pub_enable_stat_view))
        $pub_enable_stat_view = 0;
    if (is_null($pub_enable_members_view))
        $pub_enable_members_view = 0;

    $break = false;


    if (!is_numeric($pub_galaxy_by_line_stat))
        $break = true;
    if (!is_numeric($pub_system_by_line_stat))
        $break = true;
    if ($pub_enable_stat_view != 0 && $pub_enable_stat_view != 1)
        $break = true;
    if ($pub_enable_members_view != 0 && $pub_enable_members_view != 1)
        $break = true;
    if (!is_numeric($pub_galaxy_by_line_ally))
        $break = true;
    if (!is_numeric($pub_system_by_line_ally))
        $break = true;
    if ($pub_nb_colonnes_ally == 0 || $pub_nb_colonnes_ally > 9 || !is_numeric($pub_nb_colonnes_ally))
        $break = true;
    if ($pub_enable_register_view != 0 && $pub_enable_register_view != 1)
        $break = true;

    if ($break) {
        redirection("index.php?action=message&id_message=setting_server_view_failed&info");
    }

    //
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_enable_portee_missil .
        " where config_name = 'portee_missil'";
    $db->sql_query($request);

    //
    if ($pub_galaxy_by_line_stat < 1)
        $pub_galaxy_by_line_stat = 1;
    if ($pub_galaxy_by_line_stat > 100)
        $pub_galaxy_by_line_stat = 100;
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_galaxy_by_line_stat .
        " where config_name = 'galaxy_by_line_stat'";
    $db->sql_query($request);

    //
    if ($pub_system_by_line_stat < 1)
        $pub_system_by_line_stat = 1;
    if ($pub_system_by_line_stat > 100)
        $pub_system_by_line_stat = 100;
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_system_by_line_stat .
        " where config_name = 'system_by_line_stat'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = '" . $pub_open_user .
        "' where config_name = 'open_user'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = '" . $pub_open_admin .
        "' where config_name = 'open_admin'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_enable_stat_view .
        " where config_name = 'enable_stat_view'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_enable_members_view .
        " where config_name = 'enable_members_view'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = '" .
        mysql_real_escape_string($pub_nb_colonnes_ally) .
        "' where config_name = 'nb_colonnes_ally'";
    $db->sql_query($request);


    $array = $pub_color_ally; //die(var_dump($pub_color_ally));
    $color_ally = implode("_", $array);
    //
    $request = "update " . TABLE_CONFIG . " set config_value = '" .
        mysql_real_escape_string($color_ally) . "' where config_name = 'color_ally'";
    $db->sql_query($request);

    //
    if ($pub_galaxy_by_line_ally < 1)
        $pub_galaxy_by_line_ally = 1;
    if ($pub_galaxy_by_line_ally > 100)
        $pub_galaxy_by_line_ally = 100;
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_galaxy_by_line_ally .
        " where config_name = 'galaxy_by_line_ally'";
    $db->sql_query($request);

    //
    if ($pub_system_by_line_ally < 1)
        $pub_system_by_line_ally = 1;
    if ($pub_system_by_line_ally > 100)
        $pub_system_by_line_ally = 100;
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_system_by_line_ally .
        " where config_name = 'system_by_line_ally'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = '" . $pub_enable_register_view .
        "' where config_name = 'enable_register_view'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = '" .
        mysql_real_escape_string($pub_register_alliance) .
        "' where config_name = 'register_alliance'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = '" .
        mysql_real_escape_string($pub_register_forum) .
        "' where config_name = 'register_forum'";
    $db->sql_query($request);


    log_("set_server_view");
    redirection("index.php?action=administration&subaction=affichage");
}

function set_serverconfig()
{
    global $db, $user_data, $server_config;
    global $pub_max_battlereport, $pub_max_favorites, $pub_max_favorites_spy, $pub_max_spyreport,
        $pub_server_active, $pub_session_time, $pub_max_keeplog, $pub_default_skin, $pub_debug_log,
        $pub_reason, $pub_ally_protection, $pub_url_forum, $pub_max_keeprank, $pub_keeprank_criterion,
        $pub_max_keepspyreport, $pub_servername, $pub_allied, $pub_disable_ip_check, $pub_num_of_galaxies,
        $pub_num_of_systems, $pub_log_phperror, $pub_block_ratio, $pub_ratio_limit, $pub_speed_uni,
        $pub_ddr, $pub_astro_strict;

    if (!isset($pub_num_of_galaxies))
        $pub_num_of_galaxies = intval($server_config['num_of_galaxies']);
    if (!isset($pub_num_of_systems))
        $pub_num_of_systems = intval($server_config['num_of_systems']);

    if (!check_var($pub_max_battlereport, "Num") || !check_var($pub_max_favorites,
        "Num") || !check_var($pub_max_favorites_spy, "Num") || !check_var($pub_ratio_limit,
        "Special", "#^[\w\s,\.\-]+$#") || !check_var($pub_max_spyreport, "Num") || !
        check_var($pub_server_active, "Num") || !check_var($pub_session_time, "Num") ||
        !check_var($pub_max_keeplog, "Num") || !check_var($pub_default_skin, "URL") || !
        check_var($pub_debug_log, "Num") || !check_var($pub_block_ratio, "Num") || !
        check_var(stripslashes($pub_reason), "Text") || !check_var($pub_ally_protection,
        "Special", "#^[\w\s,\.\-]+$#") || !check_var($pub_url_forum, "URL") || !
        check_var($pub_max_keeprank, "Num") || !check_var($pub_keeprank_criterion,
        "Char") || !check_var($pub_max_keepspyreport, "Num") || !check_var(stripslashes
        ($pub_servername), "Text") || !check_var($pub_allied, "Special", "#^[\w\s,\.\-]+$#") ||
        !check_var($pub_disable_ip_check, "Num") || !check_var($pub_num_of_galaxies,
        "Galaxies") || !check_var($pub_num_of_systems, "Galaxies")) {
        redirection("index.php?action=message&id_message=errordata&info");
    }
    if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
        redirection("planetindex.php?action=message&id_message=forbidden&info");
    }

    if (!isset($pub_max_battlereport) || !isset($pub_max_favorites) || !isset($pub_max_favorites_spy) ||
        !isset($pub_ratio_limit) || !isset($pub_max_spyreport) || !isset($pub_session_time) ||
        !isset($pub_max_keeplog) || !isset($pub_default_skin) || !isset($pub_reason) ||
        !isset($pub_ally_protection) || !isset($pub_url_forum) || !isset($pub_max_keeprank) ||
        !isset($pub_keeprank_criterion) || !isset($pub_max_keepspyreport) || !isset($pub_servername) ||
        !isset($pub_allied)) {
        redirection("index.php?action=message&id_message=setting_serverconfig_failed&info");
    }

    if (is_null($pub_server_active))
        $pub_server_active = 0;
    if (is_null($pub_disable_ip_check))
        $pub_disable_ip_check = 0;
    if (is_null($pub_log_phperror))
        $pub_log_phperror = 0;

    if (is_null($pub_debug_log))
        $pub_debug_log = 0;
    if (is_null($pub_block_ratio))
        $pub_block_ratio = 0;

    $break = false;


    if ($pub_server_active != 0 && $pub_server_active != 1)
        $break = true;
    if ($pub_debug_log != 0 && $pub_debug_log != 1)
        $break = true;
    if ($pub_block_ratio != 0 && $pub_block_ratio != 1)
        $break = true;
    if (!is_numeric($pub_max_favorites))
        $break = true;
    if (!is_numeric($pub_max_favorites_spy))
        $break = true;
    if (!is_numeric($pub_ratio_limit))
        $break = true;
    if (!is_numeric($pub_max_spyreport))
        $break = true;
    if (!is_numeric($pub_max_battlereport))
        $break = true;
    if (!is_numeric($pub_session_time))
        $break = true;
    if (!is_numeric($pub_max_keeplog))
        $break = true;
    if ($pub_disable_ip_check != 0 && $pub_disable_ip_check != 1)
        $break = true;
    if ($pub_log_phperror != 0 && $pub_log_phperror != 1)
        $break = true;

    if ($break) {
        redirection("index.php?action=message&id_message=setting_serverconfig_failed&info");
    }

    if (($pub_num_of_galaxies != intval($server_config['num_of_galaxies'])) || ($pub_num_of_systems !=
        intval($server_config['num_of_systems']))) {
        resize_db($pub_num_of_galaxies, $pub_num_of_systems);
    }
    //
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_server_active .
        " where config_name = 'server_active'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_debug_log .
        " where config_name = 'debug_log'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_block_ratio .
        " where config_name = 'block_ratio'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_log_phperror .
        " where config_name = 'log_phperror'";
    $db->sql_query($request);
    //
    $pub_max_favorites = intval($pub_max_favorites);
    if ($pub_max_favorites < 0)
        $pub_max_favorites = 0;
    if ($pub_max_favorites > 99)
        $pub_max_favorites = 99;
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_max_favorites .
        " where config_name = 'max_favorites'";
    $db->sql_query($request);

    //
    $pub_max_favorites_spy = intval($pub_max_favorites_spy);
    if ($pub_max_favorites_spy < 0)
        $pub_max_favorites_spy = 0;
    if ($pub_max_favorites_spy > 99)
        $pub_max_favorites_spy = 99;
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_max_favorites_spy .
        " where config_name = 'max_favorites_spy'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_ratio_limit .
        " where config_name = 'ratio_limit'";
    $db->sql_query($request);

    //
    $pub_max_spyreport = intval($pub_max_spyreport);
    if ($pub_max_spyreport < 1)
        $pub_max_spyreport = 1;
    if ($pub_max_spyreport > 10)
        $pub_max_spyreport = 10;
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_max_spyreport .
        " where config_name = 'max_spyreport'";
    $db->sql_query($request);

    //
    $pub_max_battlereport = intval($pub_max_battlereport);
    if ($pub_max_battlereport < 0)
        $pub_max_battlereport = 0;
    if ($pub_max_battlereport > 99)
        $pub_max_battlereport = 99;
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_max_battlereport .
        " where config_name = 'max_battlereport'";
    $db->sql_query($request);

    //
    $pub_session_time = intval($pub_session_time);
    if ($pub_session_time < 5 && $pub_session_time != 0)
        $pub_session_time = 5;
    if ($pub_session_time > 180)
        $pub_session_time = 180;
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_session_time .
        " where config_name = 'session_time'";
    $db->sql_query($request);

    //
    $pub_max_keeplog = intval($pub_max_keeplog);
    if ($pub_max_keeplog < 0)
        $pub_max_keeplog = 0;
    if ($pub_max_keeplog > 365)
        $pub_max_keeplog = 365;
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_max_keeplog .
        " where config_name = 'max_keeplog'";
    $db->sql_query($request);

    //
    if (substr($pub_default_skin, strlen($pub_default_skin) - 1) != "/")
        $pub_default_skin .= "/";
    $request = "update " . TABLE_CONFIG . " set config_value = '" .
        mysql_real_escape_string($pub_default_skin) .
        "' where config_name = 'default_skin'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = '" .
        mysql_real_escape_string($pub_reason) . "' where config_name = 'reason'";
    $db->sql_query($request);

    //
    if (substr($pub_ally_protection, strlen($pub_ally_protection) - 1) == ",")
        $pub_ally_protection = substr($pub_ally_protection, 0, strlen($pub_ally_protection) -
            1);
    $request = "update " . TABLE_CONFIG . " set config_value = '" .
        mysql_real_escape_string($pub_ally_protection) .
        "' where config_name = 'ally_protection'";
    $db->sql_query($request);

    //
    if ($pub_url_forum != "" && !preg_match("#^http://#", $pub_url_forum))
        $pub_url_forum = "http://" . $pub_url_forum;
    $request = "update " . TABLE_CONFIG . " set config_value = '" .
        mysql_real_escape_string($pub_url_forum) . "' where config_name = 'url_forum'";
    $db->sql_query($request);

    //
    $pub_max_keeprank = intval($pub_max_keeprank);
    if ($pub_max_keeprank < 1)
        $pub_max_keeprank = 1;
    if ($pub_max_keeprank > 50)
        $pub_max_keeprank = 50;
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_max_keeprank .
        " where config_name = 'max_keeprank'";
    $db->sql_query($request);

    //
    if ($pub_keeprank_criterion != "quantity" && $pub_keeprank_criterion != "day")
        $pub_keeprank_criterion = "quantity";
    $request = "update " . TABLE_CONFIG . " set config_value = '" .
        mysql_real_escape_string($pub_keeprank_criterion) .
        "' where config_name = 'keeprank_criterion'";
    $db->sql_query($request);

    //
    $pub_max_keepspyreport = intval($pub_max_keepspyreport);
    if ($pub_max_keepspyreport < 1)
        $pub_max_keepspyreport = 1;
    if ($pub_max_keepspyreport > 90)
        $pub_max_keepspyreport = 90;
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_max_keepspyreport .
        " where config_name = 'max_keepspyreport'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = '" .
        mysql_real_escape_string($pub_servername) . "' where config_name = 'servername'";
    $db->sql_query($request);

    //
    if (substr($pub_allied, strlen($pub_allied) - 1) == ",")
        $pub_allied = substr($pub_allied, 0, strlen($pub_allied) - 1);
    $request = "update " . TABLE_CONFIG . " set config_value = '" .
        mysql_real_escape_string($pub_allied) . "' where config_name = 'allied'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_disable_ip_check .
        " where config_name = 'disable_ip_check'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_num_of_galaxies .
        " where config_name = 'num_of_galaxies'";
    $db->sql_query($request);

    //
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_num_of_systems .
        " where config_name = 'num_of_systems'";
    $db->sql_query($request);

    //
    if (!isset($pub_ddr) || !is_numeric($pub_ddr))
        $pub_ddr = 0;
    $request = "update " . TABLE_CONFIG . " set config_value = '" . $pub_ddr .
        "' where config_name = 'ddr'";
    $db->sql_query($request);

    //
    if (!isset($pub_astro_strict) || !is_numeric($pub_astro_strict))
        $pub_ddr = 0;
    $request = "update " . TABLE_CONFIG . " set config_value = '" . $pub_astro_strict .
        "' where config_name = 'astro_strict'";
    $db->sql_query($request);

    //
    if (!is_numeric($pub_speed_uni) || $pub_speed_uni < 1)
        $pub_speed_uni = 1;
    $request = "update " . TABLE_CONFIG . " set config_value = " . $pub_speed_uni .
        " where config_name = 'speed_uni'";
    $db->sql_query($request);

    log_("set_serverconfig");
    redirection("index.php?action=administration&subaction=parameter");
}
/**
 * Renvoi un tableau contenant la taille de la base
 * @return Array [Server], et [Total]
 */
function db_size_info()
{
    global $db;
    global $table_prefix;

    $dbSizeServer = 0;
    $dbSizeTotal = 0;

    $request = "SHOW TABLE STATUS";
    $result = $db->sql_query($request);
    while ($row = $db->sql_fetch_assoc($result)) {
        $dbSizeTotal += $row['Data_length'] + $row['Index_length'];
        if (preg_match("#^" . $table_prefix . ".*$#", $row['Name'])) {
            $dbSizeServer += $row['Data_length'] + $row['Index_length'];
        }
    }

    $bytes = array('Octets', 'Ko', 'Mo', 'Go', 'To');

    if ($dbSizeServer < 1024)
        $dbSizeServer = 1;
    for ($i = 0; $dbSizeServer > 1024; $i++)
        $dbSizeServer /= 1024;
    $dbSize_info["Server"] = round($dbSizeServer, 2) . " " . $bytes[$i];

    if ($dbSizeTotal < 1024)
        $dbSizeTotal = 1;
    for ($i = 0; $dbSizeTotal > 1024; $i++)
        $dbSizeTotal /= 1024;
    $dbSize_info["Total"] = round($dbSizeTotal, 2) . " " . $bytes[$i];

    return $dbSize_info;
}
/**
 *  Routine d'Optimisation de la base de donn�e
 *  @param boolean $maintenance_action true si aucune redirection souhait�,false pour avoir une redirection sur un message de r�sum�
 */
function db_optimize($maintenance_action = false)
{
    global $db;

    $dbSize_before = db_size_info();
    $dbSize_before = $dbSize_before["Total"];

    $request = 'SHOW TABLES';
    $res = $db->sql_query($request);
    while (list($table) = $db->sql_fetch_row($res)) {
        $request = 'OPTIMIZE TABLE ' . $table;
        $db->sql_query($request);
    }
    $request = 'TRUNCATE ' . TABLE_UNIVERSE_TEMPORARY;
    $db->sql_query($request);

    $dbSize_after = db_size_info();
    $dbSize_after = $dbSize_after["Total"];

    if (!$maintenance_action) {
        redirection("index.php?action=message&id_message=db_optimize&info=" . $dbSize_before .
            "�" . $dbSize_after);
    }
}
/**
 * Adaptation de la base aux nombres de galaxies et systemes
 * @param int $new_num_of_galaxies Nombre de Galaxies
 * @param int $new_num_of_systems Nombre de syst�mes
 * @return null
 */
function resize_db($new_num_of_galaxies, $new_num_of_systems)
{
    global $db, $db_host, $db_user, $db_password, $db_database, $table_prefix, $server_config;

    // si on reduit on doit supprimez toutes les entr�es qui font reference au systemes ou galaxies que l'on va enlevez
    if ($new_num_of_galaxies < intval($server_config['num_of_galaxies'])) {
        $db->sql_query("DELETE FROM " . TABLE_SPY . " WHERE spy_galaxy > $new_num_of_galaxies");
        $db->sql_query("DELETE FROM " . TABLE_UNIVERSE . " WHERE galaxy > $new_num_of_galaxies");
        $db->sql_query("UPDATE " . TABLE_USER . " SET user_galaxy=1 WHERE user_galaxy > $new_num_of_galaxies");
        $db->sql_query("DELETE FROM " . TABLE_USER_FAVORITE . " WHERE galaxy > $new_num_of_galaxies");
    }
    if ($new_num_of_systems < intval($server_config['num_of_systems'])) {
        $db->sql_query("DELETE FROM " . TABLE_SPY . " WHERE spy_system > $new_num_of_systems");
        $db->sql_query("DELETE FROM " . TABLE_UNIVERSE . " WHERE system > $new_num_of_systems");
        $db->sql_query("UPDATE " . TABLE_USER . " SET user_system=1 WHERE user_system > $new_num_of_systems");
        $db->sql_query("DELETE FROM " . TABLE_USER_FAVORITE . " WHERE system > $new_num_of_systems");
    }

    $request = "ALTER TABLE `" . TABLE_SPY .
        "` CHANGE `spy_galaxy` `spy_galaxy` ENUM(";
    for ($i = 1; $i < $new_num_of_galaxies; $i++)
        $request .= "'$i' , ";
    $request .= "'$new_num_of_galaxies') NOT NULL DEFAULT '1'";
    $db->sql_query($request);

    $request = "ALTER TABLE `" . TABLE_UNIVERSE . "` CHANGE `galaxy` `galaxy` ENUM(";
    for ($i = 1; $i < $new_num_of_galaxies; $i++)
        $request .= "'$i' , ";
    $request .= "'$new_num_of_galaxies') NOT NULL DEFAULT '1'";
    $db->sql_query($request);

    $request = "ALTER TABLE `" . TABLE_USER .
        "` CHANGE `user_galaxy` `user_galaxy` ENUM(";
    for ($i = 1; $i < $new_num_of_galaxies; $i++)
        $request .= "'$i' , ";
    $request .= "'$new_num_of_galaxies') NOT NULL DEFAULT '1'";
    $db->sql_query($request);

    $request = "ALTER TABLE `" . TABLE_USER_FAVORITE .
        "` CHANGE `galaxy` `galaxy` ENUM(";
    for ($i = 1; $i < $new_num_of_galaxies; $i++)
        $request .= "'$i' , ";
    $request .= "'$new_num_of_galaxies') NOT NULL DEFAULT '1'";
    $db->sql_query($request);

    $server_config['num_of_galaxies'] = "$new_num_of_galaxies";
    $server_config['num_of_systems'] = "$new_num_of_systems";
    $requests = "REPLACE INTO " . TABLE_CONFIG .
        " (config_name, config_value) VALUES ('num_of_galaxies','$new_num_of_galaxies')";
    $db->sql_query($request);
    $requests = "REPLACE INTO " . TABLE_CONFIG .
        " (config_name, config_value) VALUES ('num_of_systems','$new_num_of_systems')";
    $db->sql_query($request);

    log_("set_db_size");
}
/**
 * Taille des logs sur le serveur
 * @return Array tableau [type] et [size]
 */
function log_size_info()
{
    $logSize = 0;
    $res = opendir(PATH_LOG);
    $directory = array();
    //R�cup�ration de la liste des fichiers pr�sents dans les r�pertoires r�pertori�s
    while ($file = readdir($res)) {
        if ($file != "." && $file != "..") {
            if (is_dir(PATH_LOG . $file)) {
                $directory[] = PATH_LOG . $file;
            }
        }
    }
    closedir($res);

    foreach ($directory as $v) {
        $res = opendir($v);
        $directory = array();
        //R�cup�ration de la liste des fichiers pr�sents dans les r�pertoires r�pertori�s
        while ($file = readdir($res)) {
            if ($file != "." && $file != "..") {
                $logSize += @filesize($v . "/" . $file);
            }
        }
        closedir($res);
    }

    $bytes = array('Octets', 'Ko', 'Mo', 'Go', 'To');

    if ($logSize < 1024)
        $logSize = 1;

    for ($i = 0; $logSize > 1024; $i++)
        $logSize /= 1024;

    $log_size_info['size'] = round($logSize, 2);
    $log_size_info['type'] = $bytes[$i];

    return $log_size_info;
}
/**
 * Verifie l'existence de log � une date donn�
 * @param int $date Date demand�
 * @return boolean 
 * @internal Bien trop compliqu� pour une simple v�rification d'existence... 
 */
function log_check_exist($date)
{
    if (!isset($date))
        redirection("index.php?action=message&id_message=errorfatal&info");

    require_once ('library/zip.lib.php');

    $typelog = array("sql", "log", "txt");

    $root = PATH_LOG;
    $path = opendir("$root");

    //R�cup�ration de la liste des r�pertoires correspondant � cette date
    while ($file = readdir($path)) {
        if ($file != "." && $file != "..") {
            if (is_dir($root . $file) && preg_match("/^" . $date . "/", $file))
                $directories[] = $file;
        }
    }
    closedir($path);

    if (!isset($directories)) {
        return false;
    }

    foreach ($directories as $d) {
        $path = opendir($root . $d);

        while ($file = readdir($path)) {
            if ($file != "." && $file != "..") {
                $extension = substr($file, (strrpos($file, ".") + 1));
                if (in_array($extension, $typelog)) {
                    $files[] = $d . "/" . $file;
                }
            }
        }
        closedir($path);
    }

    if (!isset($files)) {
        return false;
    }

    return true;
}
/**
 * Envoi d'une archive ZIP au browser d'un log pour une date donn�
 * @global array $user_data
 */
function log_extractor()
{
    global $pub_date, $user_data;

    if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
        redirection("index.php?action=message&id_message=forbidden&info");
    }

    if (!isset($pub_date))
        redirection("index.php?action=message&id_message=errorfatal&info");

    require_once ('library/zip.lib.php');

    $typelog = array("sql", "log", "txt");

    $root = PATH_LOG;
    $path = opendir("$root");

    //R�cup�ration de la liste des r�pertoires correspondant � cette date
    while ($file = readdir($path)) {
        if ($file != "." && $file != "..") {
            if (is_dir($root . $file) && preg_match("/^" . $pub_date . "/", $file))
                $directories[] = $file;
        }
    }
    closedir($path);

    if (!isset($directories)) {
        redirection("index.php?action=message&id_message=log_missing&info");
    }

    foreach ($directories as $d) {
        $path = opendir($root . $d);

        while ($file = readdir($path)) {
            if ($file != "." && $file != "..") {
                $extension = substr($file, (strrpos($file, ".") + 1));
                if (in_array($extension, $typelog)) {
                    $files[] = $d . "/" . $file;
                }
            }
        }
        closedir($path);
    }

    if (!isset($files)) {
        redirection("index.php?action=message&id_message=log_missing&info");
    }

    // cr�ation d'un objet 'zipfile'
    $zip = new zipfile();
    foreach ($files as $filename) {
        // contenu du fichier
        $fp = fopen($root . $filename, 'r');
        $content = @fread($fp, @filesize($root . $filename));
        fclose($fp);

        // ajout du fichier dans cet objet
        $zip->addfile($content, $filename);
        // production de l'archive Zip
        $archive = $zip->file();
    }

    // ent�tes HTTP
    header('Content-Type: application/x-zip');
    // force le t�l�chargement
    header('Content-Disposition: inline; filename=log_' . $pub_date . '.zip');

    // envoi du fichier au navigateur
    echo $archive;
}

/**
 * Effacement du log s�l�ction�
 *
 */
function log_remove()
{
    global $pub_date, $user_data, $pub_directory;

    if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
        redirection("index.php?action=message&id_message=forbidden&info");

    if ($pub_directory == true) {
        @unlink("journal/" . $pub_date . "/log_" . $pub_date . ".log");
        @unlink("journal/" . $pub_date . "/index.htm");
        if (rmdir("journal/" . $pub_date)) {
            redirection("index.php?action=message&id_message=log_remove&info");
        } else {
            redirection("index.php?action=message&id_message=log_missing&info");
        }
    } else {
        if (unlink("journal/" . $pub_date . "/log_" . $pub_date . ".log")) {
            redirection("index.php?action=message&id_message=log_remove&info");
        } else {
            redirection("index.php?action=message&id_message=log_missing&info");
        }
    }
}

/**
 * Purge des fichiers logs , selon configuration du serveur
 */
function log_purge()
{
    global $server_config;

    $time = $server_config["max_keeplog"];
    $limit = time() - (60 * 60 * 24 * $time);
    $limit = intval(date("ymd", $limit));

    $root = PATH_LOG;
    $path = opendir("$root");
    while ($file = readdir($path)) {
        if ($file != "." && $file != "..") {
            if (is_dir($root . $file) && intval($file) < $limit && @ereg("[0-9]{6}", $file)) {
                $directories[] = $file;
            }
        }
    }
    closedir($path);

    if (!isset($directories)) {
        return;
    }

    $files = array();
    foreach ($directories as $d) {
        $path = opendir($root . $d);

        while ($file = readdir($path)) {
            if ($file != "." && $file != "..") {
                $extension = substr($file, (strrpos($file, ".") + 1));
                unlink($root . $d . "/" . $file);
            }
        }
        closedir($path);
        rmdir($root . $d);
    }
}

function formate_number($number, $decimal = 0)
{
    return number_format($number, $decimal, ",", " ");
}

/**
 * Maintenance du serveur (Purge des galaxies,des rapports d'espionages,des logs, et optimisation de la base)
 */
function maintenance_action()
{
    global $db, $server_config;

    $time = mktime(0, 0, 0);
    if (isset($server_config["last_maintenance_action"]) && $time > $server_config["last_maintenance_action"]) {
        galaxy_purge_ranking();
        log_purge();
        galaxy_purge_spy();
        db_optimize(true);

        $request = "update " . TABLE_CONFIG . " set config_value = '" . $time .
            "' where config_name = 'last_maintenance_action'";
        $db->sql_query($request);
    }
}

function check_var($value, $type_check, $mask = "", $auth_null = true)
{
    if ($auth_null && $value == "") {
        return true;
    }

    switch ($type_check) {
            //Pseudo des membres
        case "Pseudo_Groupname":
            if (!preg_match("#^[\w\s\-]{3,15}$#", $value)) {
                log_("check_var", array("Pseudo_Groupname", $value));
                return false;
            }
            break;

            //Mot de passe des membres
        case "Password":
            if (!preg_match("#^[\w\s\-]{6,15}$#", $value)) {
                return false;
            }
            break;

            //Cha�ne de caract�res avec espace
        case "Text":
            if (!preg_match("#^[\w'�������������\s\.\*\-]+$#", $value)) {
                log_("check_var", array("Text", $value));
                return false;
            }
            break;

            //Cha�ne de caract�res et  chiffre
        case "CharNum":
            if (!preg_match("#^[\w\.\*\-\#]+$#", $value)) {
                log_("check_var", array("CharNum", $value));
                return false;
            }
            break;

            //Caract�res
        case "Char":
            if (!preg_match("#^[[:alpha:]_\.\*\-]+$#", $value)) {
                log_("check_var", array("Char", $value));
                return false;
            }
            break;

            //Chiffres
        case "Num":
            if (!preg_match("#^[[:digit:]]+$#", $value)) {
                log_("check_var", array("Num", $value));
                return false;
            }
            break;

            //Galaxies
        case "Galaxies":
            if ($value < 1 || $value > 999) {
                log_("check_var", array("Galaxy or system", $value));
                return false;
            }
            break;

            //Adresse internet
        case "URL":
            if (!preg_match("#^(((?:http?)://)?(?(2)(www\.)?|(www\.){1})?[-a-z0-9~_]{2,}(\.[-a-z0-9~._]{2,})?[-a-z0-9~_\/&\?=.]{2,})$#i",
                $value)) {
                log_("check_var", array("URL", $value));
                return false;
            }
            break;

            //Plan�te, Joueur et alliance
        case "Galaxy":
            //		if (!preg_match("#^[\w\s\.\*\-]+$#", $value)) {
            //			log_("check_var", array("Galaxy", $value));
            //			return false;
            //		}
            break;

            //Rapport d'espionnage
        case "Spyreport":
            //		if (!preg_match("#^[\w\s\[\]\:\-'%\.\*]+$#", $value)) {
            //			log_("check_var", array("Spyreport", $value));
            //			return false;
            //		}
            break;

            //Masque param�trable
        case "Special":
            if (!preg_match($mask, $value)) {
                log_("check_var", array("Special", $value));
                return false;
            }
            break;

        default:
            return false;
    }

    return true;
}

function admin_raz_ratio($maintenance_action = false)
{
    global $db, $user_data;

    if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] !=
        1) {
        die("Acces interdit");
    }

    $request = "UPDATE " . TABLE_USER . " set search='0'";
    $db->sql_query($request);

    if (!$maintenance_action) {
        redirection("index.php?action=message&id_message=raz_ratio&info");
    }
}
/**
 * Valeur courant de microtime() format� pour les benchmarks et mesure de temps
 */
function benchmark()
{
    $mtime = microtime();
    $mtime = explode(" ", $mtime);
    $mtime = $mtime[1] + $mtime[0];

    return $mtime;
}

function check_getvalue($secvalue)
{
    if (!is_array($secvalue)) {
        if ((preg_match("/<[^>]*script*\"?[^>]*>/i", $secvalue)) || (preg_match("/<[^>]*object*\"?[^>]*>/i",
            $secvalue)) || (preg_match("/<[^>]*iframe*\"?[^>]*>/i", $secvalue)) || (preg_match
            ("/<[^>]*applet*\"?[^>]*>/i", $secvalue)) || (preg_match("/<[^>]*meta*\"?[^>]*>/i",
            $secvalue)) || (preg_match("/<[^>]*style*\"?[^>]*>/i", $secvalue)) || (preg_match
            ("/<[^>]*form*\"?[^>]*>/i", $secvalue)) || (preg_match("/<[^>]*img*\"?[^>]*>/i",
            $secvalue)) || (preg_match("/\([^>]*\"?[^)]*\)/i", $secvalue)) || (preg_match("/\"/i",
            $secvalue))) {
            return false;
        }
    } else {
        foreach ($secvalue as $subsecvalue) {
            if (!check_getvalue($subsecvalue))
                return false;
        }
    }
    return true;
}

function check_postvalue($secvalue)
{
    if (!is_array($secvalue)) {
        if ((preg_match("/<[^>]*script*\"?[^>]*>/", $secvalue)) || (preg_match("/<[^>]*style*\"?[^>]*>/",
            $secvalue))) {
            return false;
        }
    } else {
        foreach ($secvalue as $subsecvalue) {
            if (!check_postvalue($subsecvalue))
                return false;
        }
    }
    return true;
}


//\\ fonctions utilisable pour les mods //\\

function install_mod($mod_folder)
{
    global $db;
    $is_ok = false ;
    $filename = 'mod/' . $mod_folder . '/version.txt';
    if (file_exists($filename)) {
        $file = file($filename);
    }


    // On r�cup�re les donn�es du fichier version.txt
    $mod_version = trim($file[1]);
    $mod_config = trim($file[2]);

    // On explode la chaine d'information
    $value_mod = explode(',', $mod_config);


    // On v�rifie si le mod est d�j� install�""
    $check = "SELECT title FROM " . TABLE_MOD . " WHERE title='" . $value_mod[0] .
        "'";
    $query_check = $db->sql_query($check);
    $result_check = mysql_num_rows($query_check);

    if ($result_check != 0) {
    } else
        if (count($value_mod) == 7) {
            // On v�rifie le nombre de valeur de l'explode
            $query = "INSERT INTO " . TABLE_MOD .
                " (title, menu, action, root, link, version, active,admin_only) VALUES ('" . $value_mod[0] .
                "','" . $value_mod[1] . "','" . $value_mod[2] . "','" . $value_mod[3] . "','" .
                $value_mod[4] . "','" . $mod_version . "','" . $value_mod[5] . "','" . $value_mod[6] .
                "')";
            $db->sql_query($query);
            $is_ok = true; /// tout c 'est bien passe'
        }
        return $is_ok;
}


function uninstall_mod($mod_uninstall_name, $mod_uninstall_table)
{
    global $db;
    $db->sql_query("DELETE FROM " . TABLE_MOD . " WHERE title='" . $mod_uninstall_name .
        "';");
    if (!empty($mod_uninstall_table)) {
        $db->sql_query("DROP TABLE IF EXISTS " . $mod_uninstall_table . "");
    }
}

function update_mod($mod_folder, $mod_name)
{
    global $db;
    $filename = 'mod/' . $mod_folder . '/version.txt';
    if (file_exists($filename))
        $file = file($filename);
    $mod_version = trim($file[1]);
    $query = "UPDATE " . TABLE_MOD . " SET version='" . $mod_version .
        "' WHERE action='" . $mod_name . "'";
    $db->sql_query($query);
}


?>

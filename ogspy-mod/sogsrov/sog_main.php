<?php
/**
* sog_main.php : Page affichant les rapports d'espionnage
* @author tsyr2ko <tsyr2ko-sogsrov@yahoo.fr>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @version 0.4
* @package Sogsrov
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");
if (!defined('IN_SOGSROV')) die("Hacking attempt");

// fichier du script
$scrfn = substr($_SERVER["SCRIPT_FILENAME"], strrpos($_SERVER["SCRIPT_FILENAME"], "/") + 1);
$language = "fr";
// fichier o� mettre les rapports d'espionnage
// le r�pertoire est le r�pertoire du mod
$path = "mod/sogsrov/";
$savedir = $path . "data/";
$save = $savedir . intval($user_data["user_id"]) . ".txt";

// si on ne peut pas �crire dessus :s
if (!is_writable($savedir)) die('Error: the directory ' . $savedir . ' used to save spy reports is not writable and the script must have access in +rw to it (a "chmod -R 777 ' . $savedir . '" may help).');
// si le fichier n'existe pas : on le cr�e vide
if (!file_exists($save)) file_put_contents($save, "");
// sinon, s'il existe, on v�rifie qu'on peut �crire dessus
elseif (!is_writable($save)) die('Error: the file ' . $save . ' used to save spy reports for user id ' . intval($user_data["user_id"]) . ' is not writeble and the script must have access in +rw to it, and more precisely must have access in +rw to the entire directory ' . $savedir . ' (a "chmod -R 777 ' . $savedir . '" may help).');
// une fois sur 20 on va vider le dossier data des utilisateurs qui n'existent plus dans OGSpy
if (rand(1, 20) == 1)
{
	// on r�cup les user_id existants
	$req = "SELECT `user_id` FROM `" . TABLE_USER . "";
	$res = $db->sql_query($req) or die("MySQL Error !<br />\nRequest: " . $req . "<br />\nError: " . $db->sql_error());
	$exists = Array();
	while ($row = $db->sql_fetch_assoc($res)) $exists[] = $row['user_id'] . ".txt";
	$db->sql_free_result($res);
	
	// on regarde les user_id pr�sents dans le r�p data
	$present = Array();
	if ($dh = opendir($savedir))
	{
		while (($file = readdir($dh)) !== false)
		{
			// si c'est le fichier <user_id>.txt on r�cup que user_id
			if (!is_dir($file)) $present[] = $file;
		}
		closedir($dh);
	}
	else die('Error: could not open directory ' . $savedir);
	
	// on compare (dans cet ordre) les userid pr�sents et ceux existants pour qu'il ne nous reste
	// que les user_id pr�sents qui n'existent plus
	$delete = array_diff($present, $exists);
	
	// enfin, on supprime les fichiers data qui n'existent plus
	foreach ($delete as $file) unlink($savedir . $file);
}

// pour les cookies, on se sert des infos donn�es par $_SERVER
$cookie_path = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/') + 1);
$cookie_domain = $_SERVER["HTTP_HOST"];
$cookie_secure = 0;


##########################
### Functions

// -- raid_transp_calc (int, int, int, int, int, [ int ]) : array(3)
// Calcule exactement ce que vont r�colter les transporteurs (cf. http://board.ogame.fr/thread.php?threadid=169276)
// Les arguments sont tels que :
//$nb_t = 5; // nombre de transporteurs
//$t_load = 25000; // capacit� du transporteur (5.000 pour le PT, 25.000 pour le GT)
//$m_avail = 125000; // m�tal disponible sur la plan�te/lune
//$c_avail = 60000; // cristal disponible sur la plan�te/lune
//$d_avail = 34000; // deut�rium disponible sur la plan�te/lune
//$extra_fret = 0; // si vous avez du fret en moins (carburant par exemple) [facultatif]
function raid_transp_calc($nb_t, $t_load, $m_avail, $c_avail, $d_avail, $extra_fret = 0)
{
	$debug = false;
	if ($debug) echo "Sur la plan�te/lune : " . $m_avail . " m�tal, " . $c_avail . " cristal, " . $d_avail . " deut�rium<br />\n";
	if ($debug) echo "Capacit� des transporteurs : " . $nb_t . " * " . $t_load . " = " . ($nb_t * $t_load) . "<br />\n";
	if ($debug) echo "<br />\n";
	// 1st pass
	if ($debug) echo " :: Phase 1 ::<br />\n";
	$total_load = $nb_t * $t_load - $extra_fret;
	$can_load = floor($total_load / 3);
	if ($debug) echo "les transporteurs vont tenter de pr�lever " . $can_load . " de chaque ressource<br />\n";
	$ress_limit_m = floor($m_avail / 2);
	$ress_limit_c = floor($c_avail / 2);
	$ress_limit_d = floor($d_avail / 2);
	$taken_m = (($ress_limit_m - $can_load) > 0 ? $can_load : $ress_limit_m);
	if ($debug) echo "pour le m�tal : la limite est " . $ress_limit_m . ", donc " . $taken_m . " sont pr�lev�s<br />\n";
	$taken_c = (($ress_limit_c - $can_load) > 0 ? $can_load : $ress_limit_c);
	if ($debug) echo "pour le cristal : la limite est " . $ress_limit_c . ", donc " . $taken_c . " sont pr�lev�s<br />\n";
	$taken_d = (($ress_limit_d - $can_load) > 0 ? $can_load : $ress_limit_d);
	if ($debug) echo "pour le deut�rium : la limite est " . $ress_limit_d . ", donc " . $taken_d . " sont pr�lev�s<br />\n";
	$inload = $taken_m + $taken_c + $taken_d;
	$load_remaining = $total_load - $inload;
	if ($debug) echo "la place restante est " . $load_remaining . "<br />\n";
	// 2nd pass, s'il reste de la place
	if ($load_remaining > 0)
	{
		if ($debug) echo "<br />\n";
		if ($debug) echo " :: Phase 2 ::<br />\n";
		$can_load2 = floor($load_remaining / 2);
		if ($debug) echo "les transporteurs vont tenter de pr�lever " . $can_load2 . " de m�tal et de cristal uniquement<br />\n";
		$taken2_m = (($ress_limit_m - $taken_m - $can_load2) > 0 ? $can_load2 : $ress_limit_m - $taken_m);
		if ($debug) echo "pour le m�tal : la limite est " . $ress_limit_m . ", donc " . $taken_m . " sont pr�lev�s<br />\n";
		$taken2_c = (($ress_limit_c - $taken_c - $can_load2) > 0 ? $can_load2 : $ress_limit_c - $taken_c);
		if ($debug) echo "pour le cristal : la limite est " . $ress_limit_c . ", donc " . $taken_c . " sont pr�lev�s<br />\n";
		$inload += $taken2_m + $taken2_c;
		$taken_m += $taken2_m;
		$taken_c += $taken2_c;
	}
	if ($debug) echo "<br />\n";
	if ($debug) echo "Finalement, sont pris : " . $taken_m . " m�tal, " . $taken_c . " cristal, " . $taken_d . " deut�rium<br />\n";
	if ($debug) echo "il restera sur la plan�te/lune : " . ($m_avail - $taken_m) . " m�tal, " . ($c_avail - $taken_c) . " cristal, " . ($d_avail - $taken_d) . " deut�rium<br />\n";
	$arr[0] = $taken_m;
	$arr[1] = $taken_c;
	$arr[2] = $taken_d;
	return $arr;
}

// -- raid_transp_opt (int, int, int, int, [ int ]) : int
// Calcule le nombre de transporteurs qu'il faut pour le raid (fonctionne avec raid_transp_calc();)
// Les arguments sont tels que :
//$capacite = 25000; // capacit� du transporteur (5.000 pour le PT, 25.000 pour le GT)
//$met = 125000; // m�tal disponible sur la plan�te/lune
//$cri = 60000; // cristal disponible sur la plan�te/lune
//$deut = 34000; // deut�rium disponible sur la plan�te/lune
//$extra_fret = 0; // si vous avez du fret en moins (carburant par exemple) [facultatif]
function raid_transp_opt($capacite, $met, $cri, $deut, $extra_fret = 0)
{
	$debug = false;
	// on essaye de minorer et majorer le nombre exact pour limiter les calculs
	// je ne suis absolument pas s�r de �a, et je cherche une meilleure m�thode pour trouver
	// le bon r�sultat parce que celle l� est bourrin quand m�me
	// * pour la minoration c'est simplement le max qu'on peut transporter en th�orie pure
	// dans la limite de la moiti� des ressources
	$start = floor(($met + $cri + $deut) / $capacite / 2);
	// * pour la majoration en revanche, on prend le double d'un transport normal
	$end = ceil(($met + $cri + $deut) / $capacite * 2);
	$opt = $end; $af = Array(0 => floor($met / 2), 1 => floor($cri / 2), 2 => floor($deut / 2));
	if ($debug) echo "commence la boucle de minoration=" . $start . " � majoration=" . $end . "<br />\n";
	for ($i = $start; $i < $end; $i++)
	{
		$a = raid_transp_calc($i, $capacite, $met, $cri, $deut, $extra_fret);
		if ($debug) echo "avec " . $i . " transports de capacit� " . $capacite . " on prend " . $a[0] . "/" . $a[1] . "/" . $a[2] . "<br />\n";
		if ($a == $af) { $opt = $i; $i = $end; }
	}
	return $opt;
}


################################
### The script itself :)

// si l'utilisateur est d�j� venu et a sauv� ses pr�f�rences dans les cookies, alors on charge tout �a!
if (isset($_COOKIE['sogsrov_use_prefs']))
{
	$cookieprefs_use_prefs = $_COOKIE['sogsrov_use_prefs'];
	$cookieprefs_controlmenu_disp = $_COOKIE['sogsrov_controlmenu_disp'];
	$cookieprefs_rapports_par_page = $_COOKIE['sogsrov_rapports_par_page'];
	$cookieprefs_limit_color1 = $_COOKIE['sogsrov_limit_color1'];
	$cookieprefs_limit_color2 = $_COOKIE['sogsrov_limit_color2'];
	$cookieprefs_moon_color = $_COOKIE['sogsrov_moon_color'];
	$cookieprefs_priority_color0 = $_COOKIE['sogsrov_priority_color0'];
	$cookieprefs_priority_color1 = $_COOKIE['sogsrov_priority_color1'];
	$cookieprefs_priority_color2 = $_COOKIE['sogsrov_priority_color2'];
	$cookieprefs_seuils[0] = $_COOKIE['sogsrov_seuils_m�tal'];
	$cookieprefs_seuils[1] = $_COOKIE['sogsrov_seuils_cristal'];
	$cookieprefs_seuils[2] = $_COOKIE['sogsrov_seuils_deut�rium'];
	$cookieprefs_seuils[3] = $_COOKIE['sogsrov_seuils_�nergie'];
	$cookieprefs_seuils[4] = $_COOKIE['sogsrov_seuils_flotte'];
	$cookieprefs_seuils[5] = $_COOKIE['sogsrov_seuils_d�fense'];
	$cookieprefs_seuils[6] = $_COOKIE['sogsrov_seuils_b�timents'];
	$cookieprefs_seuils[7] = $_COOKIE['sogsrov_seuils_recherche'];
	$cookieprefs_orderby_default = $_COOKIE['sogsrov_orderby'];
	$cookieprefs_language = $_COOKIE['sogsrov_language'];
}
// sinon, on lui met les trucs par d�faut
else
{
	$cookieprefs_use_prefs = $use_prefs;
	$cookieprefs_controlmenu_disp = $controlmenu_disp;
	$cookieprefs_rapports_par_page = $rapports_par_page;
	$cookieprefs_limit_color1 = $limit_color1;
	$cookieprefs_limit_color2 = $limit_color2;
	$cookieprefs_moon_color = $moon_color;
	$cookieprefs_priority_color0 = $priority_color0;
	$cookieprefs_priority_color1 = $priority_color1;
	$cookieprefs_priority_color2 = $priority_color2;
	$cookieprefs_seuils[0] = $seuils[0];
	$cookieprefs_seuils[1] = $seuils[1];
	$cookieprefs_seuils[2] = $seuils[2];
	$cookieprefs_seuils[3] = $seuils[3];
	$cookieprefs_seuils[4] = $seuils[4];
	$cookieprefs_seuils[5] = $seuils[5];
	$cookieprefs_seuils[6] = $seuils[6];
	$cookieprefs_seuils[7] = $seuils[7];
	$cookieprefs_orderby_default = $orderby_default;
	$cookieprefs_language = $language;
}

// le javascript pour charger les pr�f�rences par d�faut (oblig� de le mettre l� car c'est modifi� juste apr�s en cas de cookie)
$javascript = "\n";
$javascript .= "		<script language='JavaScript' type='text/javascript'>\n";
$javascript .= "		<!--\n";
$javascript .= "		function load_default_prefs() {\n";
$javascript .= "			set_prefs.controlmenu_disp.value=\"" . $controlmenu_disp."\";\n";
$javascript .= "			set_prefs.rapports_par_page.value=\"" . $rapports_par_page."\";\n";
$javascript .= "			set_prefs.limit_color1.value=\"" . $limit_color1."\";\n";
$javascript .= "			set_prefs.limit_color2.value=\"" . $limit_color2."\";\n";
$javascript .= "			set_prefs.moon_color.value=\"" . $moon_color."\";\n";
$javascript .= "			set_prefs.priority_color0.value=\"" . $priority_color0."\";\n";
$javascript .= "			set_prefs.priority_color1.value=\"" . $priority_color1."\";\n";
$javascript .= "			set_prefs.priority_color2.value=\"" . $priority_color2."\";\n";
$javascript .= "			set_prefs.seuils_m�tal.value=\"" . $seuils[0] . "\";\n";
$javascript .= "			set_prefs.seuils_cristal.value=\"" . $seuils[1] . "\";\n";
$javascript .= "			set_prefs.seuils_deut�rium.value=\"" . $seuils[2] . "\";\n";
$javascript .= "			set_prefs.seuils_�nergie.value=\"" . $seuils[3] . "\";\n";
$javascript .= "			set_prefs.seuils_flotte.value=\"" . $seuils[4] . "\";\n";
$javascript .= "			set_prefs.seuils_d�fense.value=\"" . $seuils[5] . "\";\n";
$javascript .= "			set_prefs.seuils_b�timents.value=\"" . $seuils[6] . "\";\n";
$javascript .= "			set_prefs.seuils_recherche.value=\"" . $seuils[7] . "\";\n";
$javascript .= "			set_prefs.orderby.value=\"" . $orderby_default."\";\n";
$javascript .= "			set_prefs.language.value=\"" . $language."\";\n";
$javascript .= "		}\n";
$javascript .= "		-->\n";
$javascript .= "		</script>\n";

// si l'utilisateur a mis des pr�f�rences en cookie, et qu'il d�sire les utiliser, alors chargeons-les !
if ($_COOKIE['sogsrov_use_prefs'] == "1")
{
	$use_prefs = $cookieprefs_use_prefs;
	$controlmenu_disp = $cookieprefs_controlmenu_disp;
	$rapports_par_page = $cookieprefs_rapports_par_page;
	$limit_color1 = $cookieprefs_limit_color1;
	$limit_color2 = $cookieprefs_limit_color2;
	$moon_color = $cookieprefs_moon_color;
	$priority_color0 = $cookieprefs_priority_color0;
	$priority_color1 = $cookieprefs_priority_color1;
	$priority_color2 = $cookieprefs_priority_color2;
	$seuils[0] = $cookieprefs_seuils[0];
	$seuils[1] = $cookieprefs_seuils[1];
	$seuils[2] = $cookieprefs_seuils[2];
	$seuils[3] = $cookieprefs_seuils[3];
	$seuils[4] = $cookieprefs_seuils[4];
	$seuils[5] = $cookieprefs_seuils[5];
	$seuils[6] = $cookieprefs_seuils[6];
	$seuils[7] = $cookieprefs_seuils[7];
	$orderby_default = $cookieprefs_orderby_default;
	$language = $cookieprefs_language;
}


// ajout de rapports d'espionnage, par le formulaire ou par importation OGSpy
if (!empty($pub_import_ogs_re))
{
	// Parsing des rapports d'espionnage (RE) donn�es et ajout dans la base de donn�e
	// Note : comme on identifie par position, les doublons sont automatiquement remplac�s par
	// les RE donn�s. Attention cependant, le RE d'une lune ne doit pas �craser celui
	// d'une plan�te et vice versa. De plus, lors d'une copie du RE donn� par sogsrov, les
	// Notes sont prises en compte, il faut alors les r�encoder et remettre le 'EndNotes' avant
	// de les r�ins�rer dans le fichier de RE. Enfin, si on ajoute un RE alors qu'il en existe d�j�
	// un avec une priorit� et/ou des Notes, la priorit� sera conserv�e, ainsi que les Notes (sous r�serve
	// que le nouveau rapport n'apporte pas de nouvelles Notes)

	// on obtient les rapports
	$text = file_get_contents($save);
	$rapports = Array(); $cpos = "";
	$priority = Array();
	$exp = explode("\n", $text);
	// PHASE 1 : lecture des rapports qu'on a
	for ($k = 0; $k < sizeof($exp); $k++)
	{
		$e = trim($exp[$k]);
		// si on lit la priorit�, on la sauve
		if (substr($e, 0, strlen($lang['parse.priority'])) == $lang['parse.priority'])
		{
			$priority[$cpos] = $e . "\n";
		}
		// ici, dans tous les cas on sauve le rapports complet
		if (!empty($cpos) && !empty($e)) $rapports[$cpos] .= $e . "\n";
		if (substr($e, 0, strlen($lang['parse.resources'])) == $lang['parse.resources'])
		{
			// nouveau rapport � lire
			$planet = substr($e, strlen($lang['parse.resources']), strpos($e, '[') - strlen($lang['parse.resources']) - 1); //"Azuria"
			$cpos = substr($e, strpos($e, '[') + 1, strpos($e, ']') - strpos($e, '[') - 1); //"1:7:2"
			// si c'est une lune, on rajoute un caract�re pour �viter de remplacer le rapport de la plan�te correspondante, et inversement
			if (strtolower($planet) == $lang['parse.moon']) $cpos .= "a";
			$rapports[$cpos] = $e . "\n";
		}
		elseif (!empty($cpos) && (substr($e, 0, strlen($lang['parse.chance'])) == $lang['parse.chance']))
		{
			// th�oriquement l� c'est fini (on vient d'avoir la probabilit�)
			$cpos = "";
		}
	}
	// maintenant qu'on a r�cup�r� tous les rapports qu'on a d�j�
	// on regarde ceux qu'on nous soumet, et on remplace si d�j� existant, de m�me que si on nous soumet 2 RE pour la m�me plan�te/lune
	// PHASE 2 : lecture des nouveaux rapports donn�s
	$cpos = "";
	
	// si on doit les importer de la base de donn�e OGSpy
	if (!empty($pub_import_ogs_re))
	{
		if ($pub_import_ogs_re == 'spec') $where = " WHERE `spy_galaxy`>='" . intval($pub_gala_from) . "' AND `spy_galaxy`<='" . intval($pub_gala_to) . "' AND `spy_system`>='" . intval($pub_syst_from) . "' AND `spy_system`<='" . intval($pub_syst_to) . "' AND `datadate`>='" . (time() - (intval($pub_duration) * 3600)) . "'";
		else $where = ""; // on prend tout !
		// on n'oublie pas de les obtenir par ordre croissant d'anciennet�, comme �a lors du traitement,
		// s'il y a des doublons, le dernier trait� sera bien le plus r�cent
		$req = "SELECT `rawdata` FROM `" . TABLE_SPY . "`" . $where . " ORDER BY `datadate` ASC";
		$res = $db->sql_query($req) or die("MySQL Error !<br />\nRequest: " . $req . "<br />\nError: " . $db->sql_error());
		$text = "";
		while ($row = $db->sql_fetch_assoc($res))
		{
			// l� parfois y'a des bougs entre des rapports qu'on des \r\n d'autres que \r d'autres que \n
			// alors comme �a, tout en \n ! ah mais :D
			$row['rawdata'] = str_replace("\r\n", "\n", $row['rawdata']);
			$row['rawdata'] = str_replace("\r", "\n", $row['rawdata']);
			$text .= $row['rawdata'] . "\n";
		}
		$db->sql_free_result($res);
	}
	
	$exp = explode("\n", $text);
	for ($k = 0; $k < sizeof($exp); $k++)
	{
		$e = trim($exp[$k]);
		// si on lit la probabilit� de destruction des sondes, c'est que c'est fini
		if (!empty($cpos) && (substr($e, 0, strlen($lang['parse.chance'])) == $lang['parse.chance']))
		{
			// si on a l'ancienne priorit� � mettre
			if (!empty($priority[$cpos]))
			{
				$rapports[$cpos] .= $priority[$cpos];
			}
			$rapports[$cpos] .= $e . "\n";
		}
		// ici, on sauve le rapport que apr�s ces conditions (sachant que l'avant derni�re sauve aussi)
		elseif (!empty($cpos) && !empty($e)) $rapports[$cpos] .= $e . "\n";
		if (substr($e, 0, strlen($lang['parse.resources'])) == $lang['parse.resources'])
		{
			// nouveau rapport � lire
			$planet = substr($e, strlen($lang['parse.resources']), strpos($e, '[') - strlen($lang['parse.resources']) - 1); //"Azuria"
			$cpos = substr($e, strpos($e, '[') + 1,strpos($e, ']') - strpos($e, '[') - 1); //"1:7:2"
			// si c'est une lune, on rajoute un caract�re pour �viter de remplacer le rapport de la plan�te correspondante, et inversement
			if (strtolower($planet) == $lang['parse.moon']) $cpos .= "a";
			$rapports[$cpos] = $e . "\n";
		}
		elseif (!empty($cpos) && (substr($e, 0, strlen($lang['parse.chance'])) == $lang['parse.chance']))
		{
			// th�oriquement l� c'est fini (on vient d'avoir la probabilit�)
			$cpos = "";
		}
	}
	// on g�n�re la nouvelle liste brute de rapports
	$addtext = "";
	foreach ($rapports as $text) $addtext .= $text;
	// on remet tous les rapports + ceux ajout�s
	file_put_contents($save, $addtext . "\n");
	// on r�cup�re les param�tres de tri, d'abord pour le classement
	switch ($pub_o)
	{
		case 'm': $orderby = "m"; break;
		case 'c': $orderby = "c"; break;
		case 'd': $orderby = "d"; break;
		case 't': $orderby = "t"; break;
		case 'p': $orderby = "p"; break;
		case 'y': $orderby = "y"; break;
		default: $orderby = $orderby_default;
	}
	// puis pour l'affichage d'une galaxie en particulier ou de toutes les galaxies
	switch ($pub_g)
	{
		case "1": case "2": case "3": case "4": case "5": case "6": case "7": case "8": case "9": $galax = trim($pub_g); break;
		default: $galax = "all";
	}
	// cela nous permet de s�curiser le renvoi, ainsi on est s�r que rien de dangereux n'est pass� en param�tre
	redirection($scrfn."?action=sogsrov&o=" . $orderby . "&g=" . $galax . "&f=" . intval($pub_f));
}

// changer la priorit� d'un message
// priorit�s = 1 ou rien : normal, 0 : bas, 2 : haut
elseif (!empty($pub_edit_priority_pos))
{
	// on obtient les rapports
	$text = file_get_contents($save);
	$rapports = Array(); $planet = ""; $cpos = ""; $done = false; $thisone = false;
	$exp = explode("\n", $text);
	for ($k = 0; $k < sizeof($exp); $k++)
	{
		$e = trim($exp[$k]);
		// si on est sur la plan�te/lune sur laquelle on doit �diter la priorit�
		if (!empty($cpos) && $thisone)
		{
			// si on lit la priorit� => on remplace tout de suite
			if (substr($e, 0, strlen($lang['parse.priority'])) == $lang['parse.priority'])
			{
				$rapports[$cpos] .= $lang['parse.priority'] . "=" . intval($pub_edit_priority_val) . "\n";
				$done = true;
			}
			// si on lit la probabilit� de destruction des sondes, c'est que c'est fini
			elseif (substr($e, 0, strlen($lang['parse.chance'])) == $lang['parse.chance'])
			{
				// si on a pas d�j� mis la priorit�, on la met maintenant
				if (!$done)
				{
					$rapports[$cpos] .= $lang['parse.priority'] . "=" . intval($pub_edit_priority_val) . "\n";
					$done = true;
				}
				$rapports[$cpos] .= $e . "\n";
			}
			else $rapports[$cpos] .= $e . "\n";
		}
		// si c'est pas la plan�te/lune qu'on veut, on ne se pose pas de question et on lit tout
		elseif (!empty($cpos) && !empty($e)) $rapports[$cpos] .= $e . "\n";
		if (substr($e, 0, strlen($lang['parse.resources'])) == $lang['parse.resources'])
		{
			// nouveau rapport � lire
			$planet = substr($e, strlen($lang['parse.resources']), strpos($e, '[') - strlen($lang['parse.resources']) - 1); //"Azuria"
			$cpos = substr($e, strpos($e, '[') + 1, strpos($e, ']') - strpos($e, '[') - 1); //"1:7:2"
			// si c'est une lune, on rajoute un caract�re pour �viter de remplacer le rapport de la plan�te correspondante, et inversement
			if (strtolower($planet) == $lang['parse.moon']) $cpos .= "a";
			$rapports[$cpos] = $e . "\n";
			$done = false;
			if ($cpos == $pub_edit_priority_pos) $thisone = true;
		}
		elseif (!empty($cpos) && (substr($e, 0, strlen($lang['parse.chance'])) == $lang['parse.chance']))
		{
			// th�oriquement l� c'est fini (on vient d'avoir la probabilit�)
			$cpos = ""; $planet = ""; $done = false; $thisone = false;
		}
	}
	// on g�n�re la nouvelle liste brute de rapports
	$addtext = "";
	foreach ($rapports as $text) $addtext .= $text;
	// on remet tous les rapports, avec la nouvelle priorit�
	file_put_contents($save, $addtext . "\n");
	// on r�cup�re les param�tres de tri, d'abord pour le classement
	switch ($pub_o)
	{
		case 'm': $orderby = "m"; break;
		case 'c': $orderby = "c"; break;
		case 'd': $orderby = "d"; break;
		case 't': $orderby = "t"; break;
		case 'p': $orderby = "p"; break;
		case 'y': $orderby = "y"; break;
		default: $orderby = $orderby_default;
	}
	// puis pour l'affichage d'une galaxie en particulier ou de toutes les galaxies
	switch ($pub_g)
	{
		case "1": case "2": case "3": case "4": case "5": case "6": case "7": case "8": case "9": $galax = trim($pub_g); break;
		default: $galax = "all";
	}
	// cela nous permet de s�curiser le renvoi, ainsi on est s�r que rien de dangereux n'est pass� en param�tre
	redirection($scrfn . "?action=sogsrov&o=" . $orderby . "&g=" . $galax . "&f=" . intval($pub_f) . "#" . intval($pub_edit_anchor_id));
}

// supprimer des rapports (tous / uniquement ceux marqu�s / tous sauf ceux marqu�s)
elseif (!empty($pub_delete_re))
{
	if ($pub_delete_re == "deleteall")
	{
		// on supprime tous les rapports
		file_put_contents($save, "");
	}
	else
	{
		// on obtient les rapports
		$text = file_get_contents($save);
		$addtext = ""; $add = false;
		$exp = explode("\n", $text);
		for ($k = 0; $k < sizeof($exp); $k++)
		{
			$e = trim($exp[$k]);
			if ($add) $addtext .= $e . "\n";
			if (substr($e, 0, strlen($lang['parse.resources'])) == $lang['parse.resources'])
			{
				// nouveau rapport � lire
				$planet = substr($e, strlen($lang['parse.resources']), strpos($e, '[') - strlen($lang['parse.resources']) - 1); //"Azuria"
				$pos = substr($e, strpos($e, '[') + 1, strpos($e, ']') - strpos($e, '[') - 1); //"1:7:2"
				// si c'est une lune, on rajoute un caract�re pour �viter de remplacer le rapport de la plan�te correspondante, et inversement
				if (strtolower($planet) == $lang['parse.moon']) $pos .= "a";
				$tbl = explode(":", $pos);
				// il s'agit ici de garder les RE qu'on ne supprime pas
				// si on est en mode "supprimer affich�s", et qu'on regarde les messages affich�s, ne pas conserver
				if (($pub_delete_re == "deletedisplayed") && ($_POST['present_' . $pos] == "1"))	{ /* ne pas conserver */ }
				// si on est en mode "supprimer s�lectionn�s", �a veut dire qu'on garde ceux non s�lectionn�s
				elseif (($pub_delete_re == "deletemarked") && ($_POST['present_' . $pos] == "1") && ($_POST['delete_' . $pos] == "1")) { /* ne pas conserver */ }
				// si on est en mode "supprimer non s�lectionn�s", �a veut dire qu'on garde ceux s�lectionn�s
				elseif (($pub_delete_re == "deletenonmarked") && ($_POST['present_' . $pos] == "1") && ($_POST['delete_' . $pos] != "1")) { /* ne pas conserver */ }
				// si on est en mode "supprimer qu'un seul RE", �a veut dire qu'on garde ceux qui ne correspondent pas � la position � supprimer
				elseif (($pub_delete_re == "deleteone") && ($_POST['present_' . $pos] == "1") && ($pub_delete_one == $pos)) { /* ne pas conserver */ }
				// si on est en mode "supprimer flotte > seuil"
				elseif (($pub_delete_re == "deletesomefleet") && ($_POST['fleet_' . $pos] == "2")) { /* ne pas conserver */ }
				// si on est en mode "supprimer d�fense > seuil"
				elseif (($pub_delete_re == "deletesomedefense") && ($_POST['defense_' . $pos] == "2")) { /* ne pas conserver */ }
				// si on est en mode "supprimer toutes les flottes"
				elseif (($pub_delete_re == "deleteallfleet") && ($_POST['fleet_' . $pos] != "0")) { /* ne pas conserver */ }
				// si on est en mode "supprimer toutes les d�fenses"
				elseif (($pub_delete_re == "deletealldefense") && ($_POST['defense_' . $pos] != "0")) { /* ne pas conserver */ }
				// normalement l� c'est all good!
				else { $add = true; $addtext .= $e . "\n"; }
			}
			elseif (substr($e, 0, strlen($lang['parse.chance'])) == $lang['parse.chance'])
			{
				// th�oriquement l� c'est fini (on vient d'avoir la probabilit�)
				$add = false;
			}
		}
		// maintenant on supprime tous les rapports, et on rajoute tous les rapports non supprim�s
		file_put_contents($save, $addtext . "\n");
	}
	// on r�cup�re les param�tres de tri, d'abord pour le classement
	switch ($pub_o)
	{
		case 'm': $orderby = "m"; break;
		case 'c': $orderby = "c"; break;
		case 'd': $orderby = "d"; break;
		case 't': $orderby = "t"; break;
		case 'p': $orderby = "p"; break;
		case 'y': $orderby = "y"; break;
		default: $orderby = $orderby_default;
	}
	// puis pour l'affichage d'une galaxie en particulier ou de toutes les galaxies
	switch ($pub_g)
	{
		case "1": case "2": case "3": case "4": case "5": case "6": case "7": case "8": case "9": $galax = trim($pub_g); break;
		default: $galax = "all";
	}
	// cela nous permet de s�curiser le renvoi, ainsi on est s�r que rien de dangereux n'est pass� en param�tre
	redirection($scrfn . "?action=sogsrov&o=" . $orderby . "&g=" . $galax . "&f=" . intval($pub_f));
}

// si l'utilisateur d�sire sauvegarder ses pr�f�rences
elseif ($pub_save_prefs == "1")
{
	// on sauve chaque variable dans un cookie... pfiuh �a en fait des cookies ^^
	setcookie("sogsrov_use_prefs", ($pub_use_prefs == '1' ? '1' : '0'), time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_controlmenu_disp", $pub_controlmenu_disp, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_rapports_par_page", $pub_rapports_par_page, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_limit_color1", $pub_limit_color1, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_limit_color2", $pub_limit_color2, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_moon_color", $pub_moon_color, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_priority_color0", $pub_priority_color0, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_priority_color1", $pub_priority_color1, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_priority_color2", $pub_priority_color2, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_seuils_m�tal", $pub_seuils_m�tal, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_seuils_cristal", $pub_seuils_cristal, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_seuils_deut�rium", $pub_seuils_deut�rium, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_seuils_�nergie", $pub_seuils_�nergie, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_seuils_flotte", $pub_seuils_flotte, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_seuils_d�fense", $pub_seuils_d�fense, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_seuils_b�timents", $pub_seuils_b�timents, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_seuils_recherche", $pub_seuils_recherche, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_orderby", $pub_orderby, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	setcookie("sogsrov_language", $pub_language, time() + $cookie_expire, $cookie_path, $cookie_domain, $cookie_secure);
	// on r�cup�re les param�tres de tri, d'abord pour le classement
	switch ($pub_o)
	{
		case 'm': $orderby = "m"; break;
		case 'c': $orderby = "c"; break;
		case 'd': $orderby = "d"; break;
		case 't': $orderby = "t"; break;
		case 'p': $orderby = "p"; break;
		case 'y': $orderby = "y"; break;
		default: $orderby = $orderby_default;
	}
	// puis pour l'affichage d'une galaxie en particulier ou de toutes les galaxies
	switch ($pub_g)
	{
		case "1": case "2": case "3": case "4": case "5": case "6": case "7": case "8": case "9": $galax = trim($pub_g); break;
		default: $galax = "all";
	}
	// cela nous permet de s�curiser le renvoi, ainsi on est s�r que rien de dangereux n'est pass� en param�tre
	redirection($scrfn . "?action=sogsrov&o=" . $orderby . "&g=" . $galax . "&f=" . intval($pub_f));
}

// afficher la page principale, avec les rapports, les options...
else
{
	$RE = Array(); $RE_m = Array(); $RE_c = Array(); $RE_d = Array(); $RE_t = Array(); $RE_y = Array(); $RE_p0 = Array(); $RE_p1 = Array(); $RE_p2 = Array();
	$galaxy_count = Array("1" => 0, "2" => 0, "3" => 0, "4" => 0, "5" => 0, "6" => 0, "7" => 0, "8" => 0, "9" => 0);
	
	// on obtient les rapports
	$text = file_get_contents($save);
	$i = -1; $encours = false;
	$exp = explode("\n", $text);
	for ($k = 0; $k < sizeof($exp); $k++)
	{
		$e = trim($exp[$k]);
		// si on lit les mati�res premi�res
		if (substr($e, 0, strlen($lang['parse.resources'])) == $lang['parse.resources'])
		{
			// nouveau rapport � lire
			$i++;
			$RE[$i]['planet'] = substr($e, strlen($lang['parse.resources']), strpos($e, '[') - strlen($lang['parse.resources']) - 1); //"Azuria"
			$RE[$i]['pos'] = substr($e, strpos($e, '[') + 1, strpos($e, ']') - strpos($e, '[') - 1); //"1:7:2"
			$position = explode(":", $RE[$i]['pos']);
			$galaxy_count[$position[0]]++;
			$RE[$i]['date'] = substr($e, strpos($e, $lang['parse.at'], strpos($e, ']')) + 3); //"06-16 15:28:23"
			
			$k++; $e = trim($exp[$k]);
			/* les tabulations ne sont recopi�es que sous FireFox... donc on ne peut malheureusement pas utilis� ce truc fut� !
			$tbl = explode("	",$e); // c'est une tabulation, non un espace
			$RE[$i]['m�tal'] = trim($tbl[1]); //"101199"
			$RE[$i]['cristal'] = trim($tbl[3]); //"132186" */
			// donc on va prendre la m�thode bourrin des substr/strpos qui marche tout le temps !
			$RE[$i]['m�tal'] = trim(substr($e, strpos($e, $lang['parse.metal']) + strlen($lang['parse.metal']) + 1, strpos($e, $lang['parse.crystal']) - strlen($lang['parse.metal']) - 1)); //"101199"
			$RE[$i]['cristal'] = trim(substr($e, strpos($e, $lang['parse.crystal']) + strlen($lang['parse.crystal']) + 1)); //"132186"
			
			$k++; $e = trim($exp[$k]);
			/* les tabulations ne sont recopi�es que sous FireFox... donc on ne peut malheureusement pas utilis� ce truc fut� !
			$tbl = explode("	",$e); // c'est une tabulation, non un espace
			$RE[$i]['deut�rium'] = trim($tbl[1]); //"104473"
			$RE[$i]['�nergie'] = trim($tbl[3]); //"2324" */
			// donc on va prendre la m�thode bourrin des substr/strpos qui marche tout le temps !
			$RE[$i]['deut�rium'] = trim(substr($e, strpos($e, $lang['parse.deuterium']) + strlen($lang['parse.deuterium']) + 1, strpos($e, $lang['parse.energy']) - strlen($lang['parse.deuterium']) - 1)); //"104473"
			$RE[$i]['�nergie'] = trim(substr($e, strpos($e, $lang['parse.energy']) + strlen($lang['parse.energy']) + 1)); //"2324"
			
			// si y'a des points pour s�parer les centaines :)
			$RE[$i]['m�tal'] = str_replace(".", "", $RE[$i]['m�tal']);
			$RE[$i]['cristal'] = str_replace(".", "", $RE[$i]['cristal']);
			$RE[$i]['deut�rium'] = str_replace(".", "", $RE[$i]['deut�rium']);
			$RE[$i]['�nergie'] = str_replace(".", "", $RE[$i]['�nergie']);
			
			// on d�finit les variables au cas o� �a n'est pas pr�sent dans le rapport
			$RE[$i][$lang['parse.fleet']] = 'not present'; $RE[$i][$lang['parse.defense']] = 'not present';
			$RE[$i][$lang['parse.buildings']] = 'not present'; $RE[$i][$lang['parse.research']] = 'not present';
			$RE[$i]['proba'] = -1; $encours = false;
			// par d�faut la priorit� est normale (=1)
			$RE[$i]['priority'] = "1";
			
			// pour pouvoir ordonner comme il faut
			$RE_m[$i] = $RE[$i]['m�tal'];
			$RE_c[$i] = $RE[$i]['cristal'];
			$RE_d[$i] = $RE[$i]['deut�rium'];
			$RE_t[$i] = $RE[$i]['m�tal'] + $RE[$i]['cristal'] + $RE[$i]['deut�rium'];
			$RE_p0[$i] = $position[0]; $RE_p1[$i] = $position[1]; $RE_p2[$i] = $position[2];
		}
		// dans le cas o� on arrive sur flotte/d�fense/b�timents/recherche
		elseif ((substr($e, 0, strlen($lang['parse.fleet'])) == $lang['parse.fleet']) || (substr($e, 0, strlen($lang['parse.defense'])) == $lang['parse.defense']) || (substr($e, 0, strlen($lang['parse.buildings'])) == $lang['parse.buildings']) || (substr($e, 0, strlen($lang['parse.research'])) == $lang['parse.research']))
		{
			if (substr($e, 0, strlen($lang['parse.fleet'])) == $lang['parse.fleet']) $m = $lang['parse.fleet'];
			elseif (substr($e, 0, strlen($lang['parse.defense'])) == $lang['parse.defense']) $m = $lang['parse.defense'];
			elseif (substr($e, 0, strlen($lang['parse.buildings'])) == $lang['parse.buildings']) $m = $lang['parse.buildings'];
			elseif (substr($e, 0, strlen($lang['parse.research'])) == $lang['parse.research']) $m = $lang['parse.research'];
			$encours = true;
			$RE[$i][$m] = Array();
		}
		// si on lit la probabilit�, normalement c'est la fin du rapport
		elseif (substr($e, 0, strlen($lang['parse.chance'])) == $lang['parse.chance'])
		{
			$RE_y[$i] = $RE[$i]['priority'];
			$RE[$i]['proba'] = substr($e, strlen($lang['parse.chance']), strpos($e, '%') - strlen($lang['parse.chance'])); //"0"
			// th�oriquement l� c'est fini (on vient d'avoir la probabilit�)
			$encours = false;
		}
		// si on lit la priorit�
		elseif (substr($e, 0, strlen($lang['parse.priority'])) == $lang['parse.priority'])
		{
			$tbl = explode("=", $e);
			$RE[$i]['priority'] = $tbl[1];
		}
		// cas d'exploration de flotte/d�fense/b�timents/recherche, rajouter les infos l� o� il faut
		elseif ($encours)
		{
			// si on a la cha�ne scind�e par des tabulations (FireFox), alors c'est simple
			if (strstr($e,"	") !== FALSE) // c'est une tabulation, non un espace 
			{
				$tbl = explode("	",$e); // c'est une tabulation, non un espace
				$RE[$i][$m][trim($tbl[0])] = trim($tbl[1]);
				if ($m == $lang['parse.fleet']) $RE[$i][$lang['parse.fleet'] . "_sum"] += trim($tbl[1]);
				if ($m == $lang['parse.defense']) $RE[$i][$lang['parse.defense'] . "_sum"] += trim($tbl[1]);
				// dans le cas fr�quent o� y'en a 2 sur la m�me ligne
				if (sizeof($tbl) > 2)
				{
					$RE[$i][$m][trim($tbl[2])] = trim($tbl[3]);
					if ($m == $lang['parse.fleet']) $RE[$i][$lang['parse.fleet'] . "_sum"] += trim($tbl[3]);
					if ($m == $lang['parse.defense']) $RE[$i][$lang['parse.defense'] . "_sum"] += trim($tbl[3]);
				}

			}
			// Sinon (Internet Explorer), on est oblig� d'utiliser une m�thode bourrin qui repose sur le fait que les
			// blocs sont de la forme : "du texte" "un nombre" "du texte" "un nombre" (et sans les guillemets ")
			// On va donc scinder la cha�ne avec les espaces, et tant qu'on a pas un nombre, c'est qu'on est en train
			// de lire le nom du vaisseau/d�fense/b�timent/recherche...
			else
			{
				$tbl = explode(" ", $e); // cette fois, c'est un espace
				$key = "";
				for ($j = 0; $j < sizeof($tbl); $j++)
				{
					// on sait jamais si y'a un truc parasite, �a co�te rien...
					$tbl[$j] = trim($tbl[$j]);
					if (is_numeric($tbl[$j]))
					{
						// on a commenc� $key par un espace (cf. le 'else' ci-apr�s)
						$RE[$i][$m][trim($key)] = $tbl[$j];
						if ($m == $lang['parse.fleet']) $RE[$i][$lang['parse.fleet'] . "_sum"] += trim($tbl[$j]);
						if ($m == $lang['parse.defense']) $RE[$i][$lang['parse.defense'] . "_sum"] += trim($tbl[$j]);
						$key = "";
					}
					else
					{
						// n'oublions pas de mettre un espace dans la concat�nation o� notre cl�,
						// qui repr�sente une unit�, ne va plus ressembler � grand chose
						$key .= " " . $tbl[$j];
					}
				}
			}
		}
	}
	
	// on trie comme il faut les trucs facile (avec *r*sort pour garder les cl�s)
	arsort($RE_m); arsort($RE_c); arsort($RE_d); arsort($RE_t); arsort($RE_y);
	// pour ordonner avec la position c'est un tout petit peu plus compliqu�...
	// on passe par un tableau 'ind' qui va garder les cl�s originelle en m�moire
	$ind = Array(); for ($i = 0; $i < sizeof($RE_m); $i++) $ind[] = $i;
	// on classe le tout avec multisort, 'ind' est alors modifi� en fonction de p1/p2/p3 qui sont bien class�s
	array_multisort($RE_p0, $RE_p1, $RE_p2, $ind);
	// et comme 'ind' a gard� les bonnes cl�s en m�moire, plus qu'� remettre le tout dans $RE_p, correctement gr�ce � 'ind'
	$RE_p = Array(); foreach ($ind as $i => $v) { $RE_p[$v] = $RE_p0[$i] . ":" . $RE_p1[$i] . ":" . $RE_p2[$i]; }
	// Hop, magie ! C'est tout bien class�, et on a gard� les cl�s comme si on avait fait un genre de array_multi*r*sort ^^
	
	// on r�cup�re les param�tres de tri
	// 1) pour le classement
	switch ($pub_o)
	{
		case 'm': $orderby = "m"; break;
		case 'c': $orderby = "c"; break;
		case 'd': $orderby = "d"; break;
		case 't': $orderby = "t"; break;
		case 'p': $orderby = "p"; break;
		case 'y': $orderby = "y"; break;
		default: $orderby = $orderby_default;
	}
	// 2) pour l'affichage d'une galaxie en particulier ou de toutes les galaxies
	switch ($pub_g)
	{
		case "1": case "2": case "3": case "4": case "5": case "6": case "7": case "8": case "9": $galax = trim($pub_g); break;
		default: $galax = "all";
	}
	
	// et on en d�duit l'affichage des rapports d'espionnage
	switch ($orderby)
	{
		case 'm': $RE_chosen = $RE_m; break;
		case 'c': $RE_chosen = $RE_c; break;
		case 'd': $RE_chosen = $RE_d; break;
		case 't': $RE_chosen = $RE_t; break;
		case 'p': $RE_chosen = $RE_p; break;
		case 'y': $RE_chosen = $RE_y; break;
		default: $RE_chosen = $RE_t;
	}
	
	// a propos de la pagination
	if (!empty($pub_f)) $re_disp_from = intval($pub_f);
	else $re_disp_from = 0;
	
	require_once("views/page_header.php");
	// et on affiche le javascript que maintenant, en plein milieu car pas d'autre moyen avec OGSpy
	echo $javascript;
	
	echo "<div align='center'>\n";
	echo "<table>\n";
		echo "<tr>\n";
		// suivant le choix d'affichage
		if ($controlmenu_disp == '1') // � droite
		{
			echo "<td><table width='519'><tr><td>&nbsp;</td></tr></table></td>\n";
			echo "<td width='50'>&nbsp;</td>\n";
			echo "<td><table width='330'><tr><td>&nbsp;</td></tr></table></td>\n";
		}
		else // � gauche
		{
			echo "<td><table width='330'><tr><td>&nbsp;</td></tr></table></td>\n";
			echo "<td width='50'>&nbsp;</td>\n";
			echo "<td><table width='519'><tr><td>&nbsp;</td></tr></table></td>\n";
		}
		echo "</tr>\n";
		
		// d�but du bloc du menu de contr�le
		$controlmenu = "";
		
		// le bloc de choix de galaxie et d'ajout de rapports d'espionnage
		$controlmenu .= "&nbsp;<br />&nbsp;\n";
		$controlmenu .= "<table width='330'><tr><td align='center' class='b'>\n";
		$controlmenu .= "<big><b>" . $lang['Spy reports'] . "</b></big>\n";
		$controlmenu .= "&nbsp; &nbsp; &nbsp; &nbsp; [<a href='" . $scrfn . "?action=sogsrov&o=" . $orderby . "&g=" . $galax . "&f=" . $re_disp_from . "'>" . $lang['refresh page'] . "</a>]";
		$controlmenu .= "<br />&nbsp;\n";
		$controlmenu .= "<form name='galaxy_choose' method='get' action='" . $scrfn . "'>\n";
		$controlmenu .= "<input type='hidden' name='action' value='sogsrov' />\n";
		$controlmenu .= "<input type='hidden' name='o' value='" . $orderby . "' />\n";
		$controlmenu .= "<input type='hidden' name='f' value='" . $re_disp_from . "' />\n";
		$controlmenu .= "" . $lang['Show reports of'] . "&nbsp; <select name='g' onChange='galaxy_choose.submit();'>\n";
		$controlmenu .= "	<option value='all'" . ($galax == "all" ? " selected" : "") . ">" . $lang['all galaxies'] . " (" . sizeof($RE_chosen) . ")</option>\n";
		for ($i=1; $i <= 9; $i++)
		{
			$controlmenu .= "	<option value='" . $i . "'" . ($galax == "" . $i ? " selected" : "") . ">" . sprintf($lang['the galaxy x only'], $i) . " (" . $galaxy_count[$i] . ")</option>\n";
		}
		$controlmenu .= "</select>\n";
		$controlmenu .= "</form>\n";
		$controlmenu .= "</td>\n</tr>\n</table>\n";
		
		// le bloc d'importation des RE d'OGSpy, si on a un serveur OGSpy disponible
		$controlmenu .= "&nbsp;<br />&nbsp;\n";
		$controlmenu .= "<table width='330'><tr><td align='center' class='b'>\n";
		$controlmenu .= "<big><b>" . $lang['Import OGSpy reports'] . "</b></big>\n";
		$controlmenu .= "<br />&nbsp;<br />\n";
		$controlmenu .= "<form name='import_ogs' method='post' action='" . $scrfn . "?action=sogsrov&o=" . $orderby . "&g=" . $galax . "&f=" . $re_disp_from . "'>\n";
		$controlmenu .= "<table width='100%'>\n";
		$controlmenu .= "<tr><td align='left' colspan='2'><input type='radio' name='import_ogs_re' value='all' /> " . $lang['Import all'] . "</td></tr>\n";
		$controlmenu .= "<tr><td align='left' valign='top'><input type='radio' name='import_ogs_re' value='spec' checked /> " . $lang['only'] . "</td>";
		$controlmenu .= "<td align='left' valign='top'>" . $lang['from galaxy'] . " &nbsp; <input type='text' name='gala_from' value='1' size='1' style='text-align: center;' /> &nbsp; " . $lang['to'] . " &nbsp; <input type='text' name='gala_to' value='9' size='1' style='text-align: center;' />\n";
		$controlmenu .= "<br />" . $lang['from system'] . " &nbsp; <input type='text' name='syst_from' value='1' size='3' style='text-align: center;' /> &nbsp; " . $lang['to'] . " &nbsp; <input type='text' name='syst_to' value='499' size='3' style='text-align: center;' />\n";
		$controlmenu .= "<br />" . $lang['of max'] . " &nbsp; <input type='text' name='duration' value='6' size='4' style='text-align: center;' /> &nbsp; " . $lang['hours old'] . "\n";
		$controlmenu .= "</td></tr>\n";
		$controlmenu .= "<tr><td align='center' colspan='2'>&nbsp;<br /><input type='submit' value=\"" . $lang['Import from OGSpy'] . "\" /></td></tr>\n";
		$controlmenu .= "</table>";
		$controlmenu .= "</form>\n";
		$controlmenu .= "</td>\n</tr>\n</table>\n";
		
		// le bloc des pr�f�rences
		$controlmenu .= "&nbsp;<br />&nbsp;\n";
		$controlmenu .= "<table width='330'><tr><td align='center' class='b'>\n";
		$controlmenu .= "<big><b>" . $lang['Display preferences'] . "</b></big>\n";
		$controlmenu .= "<br />&nbsp;\n";
		$controlmenu .= "<form name='set_prefs' method='post' action='" . $scrfn . "?action=sogsrov&o=" . $orderby . "&g=" . $galax . "&f=" . $re_disp_from . "'>\n";
		$controlmenu .= "<input type='hidden' name='save_prefs' value='1' />\n";
		$controlmenu .= "<input type='hidden' name='language' value='" . $cookieprefs_language . "' />\n";
		$controlmenu .= "<table width='100%'>\n";
		$controlmenu .= "</select></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Control menu'] . "</td>";
		$controlmenu .= "<td align='center'><select name='controlmenu_disp'><option value='0'" . ($cookieprefs_controlmenu_disp == '0' ? ' selected' : '') . ">" . $lang['left'] . "</option><option value='1'" . ($cookieprefs_controlmenu_disp == '1' ? ' selected' : '') . ">" . $lang['right'] . "</option></select></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Reports per page'] . "<br /><small>" . $lang['(0 for all)'] . "</small></td>";
		$controlmenu .= "<td align='center'><input type='text' name='rapports_par_page' value='" . $cookieprefs_rapports_par_page . "' size='10' style='text-align: center;' /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Default color'] . "</td>";
		$controlmenu .= "<td align='center'><input type='text' name='limit_color1' value='" . $cookieprefs_limit_color1."' size='10' style='text-align: center;' /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Critical limit color'] . "</td>";
		$controlmenu .= "<td align='center'><input type='text' name='limit_color2' value='" . $cookieprefs_limit_color2."' size='10' style='text-align: center;' /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Moon color'] . "</td>";
		$controlmenu .= "<td align='center'><input type='text' name='moon_color' title=\"" . $lang['Can be empty for no color'] . "\" value='" . $cookieprefs_moon_color."' size='10' style='text-align: center;' /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Low priority color'] . "</td>";
		$controlmenu .= "<td align='center'><input type='text' name='priority_color0' title=\"" . $lang['Can be empty for no color'] . "\" value='" . $cookieprefs_priority_color0 . "' size='10' style='text-align: center;' /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Normal priority color'] . "</td>";
		$controlmenu .= "<td align='center'><input type='text' name='priority_color1' title=\"" . $lang['Can be empty for no color'] . "\" value='" . $cookieprefs_priority_color1 . "' size='10' style='text-align: center;' /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['High priority color'] . "</td>";
		$controlmenu .= "<td align='center'><input type='text' name='priority_color2' title=\"" . $lang['Can be empty for no color'] . "\" value='" . $cookieprefs_priority_color2 . "' size='10' style='text-align: center;' /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Metal limit'] . "</td>";
		$controlmenu .= "<td align='center'><input type='text' name='seuils_m�tal' value='" . $cookieprefs_seuils[0] . "' size='10' style='text-align: center;' /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Crystal limit'] . "</td>";
		$controlmenu .= "<td align='center'><input type='text' name='seuils_cristal' value='" . $cookieprefs_seuils[1] . "' size='10' style='text-align: center;' /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Deuterium limit'] . "</td>";
		$controlmenu .= "<td align='center'><input type='text' name='seuils_deut�rium' value='" . $cookieprefs_seuils[2] . "' size='10' style='text-align: center;' /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Energy limit'] . "</td>";
		$controlmenu .= "<td align='center'><input type='text' name='seuils_�nergie' value='" . $cookieprefs_seuils[3] . "' size='10' style='text-align: center;' /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Fleet limit'] . "</td>";
		$controlmenu .= "<td align='center'><input type='text' name='seuils_flotte' value='" . $cookieprefs_seuils[4] . "' size='10' style='text-align: center;' /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Defense limit'] . "</td>";
		$controlmenu .= "<td align='center'><input type='text' name='seuils_d�fense' value='" . $cookieprefs_seuils[5] . "' size='10' style='text-align: center;' /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Buildings limit'] . "</td>";
		$controlmenu .= "<td align='center'><input type='text' name='seuils_b�timents' value='" . $cookieprefs_seuils[6] . "' size='10' style='text-align: center;' /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Research limit'] . "</td>";
		$controlmenu .= "<td align='center'><input type='text' name='seuils_recherche' value='" . $cookieprefs_seuils[7] . "' size='10' style='text-align: center;' /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'>" . $lang['Order by'] . "</td>";
		$controlmenu .= "<td align='center'><select name='orderby'>";
		$controlmenu .= "<option value='m'" . ($cookieprefs_orderby_default == 'm' ? ' selected' : '') . ">" . $lang['quantity of metal'] . "</option>";
		$controlmenu .= "<option value='c'" . ($cookieprefs_orderby_default == 'c' ? ' selected' : '') . ">" . $lang['quantity of crystal'] . "</option>";
		$controlmenu .= "<option value='d'" . ($cookieprefs_orderby_default == 'd' ? ' selected' : '') . ">" . $lang['quantity of deuterium'] . "</option>";
		$controlmenu .= "<option value='t'" . ($cookieprefs_orderby_default ==  't' ? ' selected' : '') . ">" . $lang['total quantity of resources'] . "</option>";
		$controlmenu .= "<option value='p'" . ($cookieprefs_orderby_default == 'p' ? ' selected' : '') . ">" . $lang['position of the planet/moon'] . "</option>";
		$controlmenu .= "<option value='y'" . ($cookieprefs_orderby_default == 'y' ? ' selected' : '') . ">" . $lang['report priority'] . "</option>";
		$controlmenu .= "</select></td></tr>\n";
		$controlmenu .= "<tr><td align='center' colspan='2'>&nbsp;</td></tr>";
		$controlmenu .= "</table>";
		$controlmenu .= "<table width='100%'>\n";
		$controlmenu .= "<tr><td align='center' colspan='2'><input type='checkbox' name='use_prefs' value='1'" . ($cookieprefs_use_prefs == '1' ? ' checked' : '') . " /> &nbsp;" . $lang['use these values instead of default ones'] . "</td></tr>";
		$controlmenu .= "<tr><td align='center' colspan='2'>&nbsp;</td></tr>";
		$controlmenu .= "<tr><td align='center'><input type='button' value=\"" . $lang['Default values'] . "\" onClick='load_default_prefs();' /></td>";
		$controlmenu .= "<td align='center'><input type='submit' value=\"" . $lang['Save'] . "\" /></td></tr>\n";
		$controlmenu .= "<tr><td align='center'></td>";
		$controlmenu .= "<td align='center'></td></tr>";
		$controlmenu .= "</table>";
		$controlmenu .= "</form>\n";
		$controlmenu .= "</td>\n</tr>\n</table>\n";
		
		// le bloc de cr�dits ^^ 
		$controlmenu .= "&nbsp;<br />&nbsp;\n";
		$controlmenu .= "<table width='330'><tr><td align='center' class='b'>\n";
		$controlmenu .= "<big><b>" . $lang['Credits'] . "</b></big>\n";
		$controlmenu .= "<br />&nbsp;<br />\n";
		$controlmenu .= "<a href='http://stalkr.net/forum/viewtopic.php?t=2327' target='_blank'>SOGSROV</a> ";
		$controlmenu .= sprintf($lang['version x by y'], "<b>" . $version . "</b>","<a href='mailto:sogsrov@stalkr.net'>StalkR</a>") . "\n";
		$controlmenu .= "<br />&nbsp;<br />\n";
		$controlmenu .= $lang['for more info it\'s on the official forum'] . "\n";
		$controlmenu .= "</td>\n</tr>\n</table>\n";
		
		// -- fin du bloc menu de contr�le
		
		
		
		// d�but du bloc de rapports d'espionnage
		$blocrapports = "";
		
		// le bloc de suppression et choix du classement (ici, celui du haut)
		$blocrapports .= "<form name='actions_reports' method='post' action='" . $scrfn . "?action=sogsrov&o=" . $orderby . "&g=" . $galax . "&f=" . $re_disp_from . "'>\n";
		// ce champ d�terminera l'action � effectuer si on doit supprimer des rapports
		$blocrapports .= "<input type='hidden' name='delete_re' value='' />";
		// ce champ d�terminera l'action � effectuer si on doit supprimer un seul rapport
		$blocrapports .= "<input type='hidden' name='delete_one' value='' />";
		// ces deux champs d�termineront quelle priorit� pour quelle plan�te/lune
		$blocrapports .= "<input type='hidden' name='edit_priority_pos' value='' />";
		$blocrapports .= "<input type='hidden' name='edit_priority_val' value='' />";
		// pour l'ancre apr�s �dition priorit�, on indique le $i de l'ancre
		$blocrapports .= "<input type='hidden' name='edit_anchor_id' value='' />";
		$blocrapports .= "<table width='519'>\n";
		$blocrapports .= "	<tr>\n";
		$blocrapports .= "		<td colspan='3' class='b' align='center'>\n";
		$blocrapports .= "			<table width='100%' cellspacing='1' cellpadding='1'><tr><td align='left'>\n";
		$blocrapports .= "			<select name='delete_re1' onChange='actions_reports.delete_re2.value=actions_reports.delete_re1.value;'>\n";
		$blocrapports .= "				<option value='deletemarked'>" . $lang['Delete selected'] . "</option>\n";
		$blocrapports .= "				<option value='deletenonmarked'>" . $lang['Delete unselected'] . "</option>\n";
		$blocrapports .= "				<option value='deletesomefleet'>".sprintf($lang['Delete fleet'], $seuils[4]) . "</option>\n";
		$blocrapports .= "				<option value='deletesomedefense'>".sprintf($lang['Delete defense'], $seuils[5]) . "</option>\n";
		$blocrapports .= "				<option value='deleteallfleet'>" . $lang['Delete all fleet'] . "</option>\n";
		$blocrapports .= "				<option value='deletealldefense'>" . $lang['Delete all defense'] . "</option>\n";
		$blocrapports .= "				<option value='deletedisplayed'>" . $lang['Delete displayed'] . "</option>\n";
		$blocrapports .= "				<option value='deleteall'>" . $lang['Delete all'] . "</option>\n";
		$blocrapports .= "			</select>&nbsp;\n";
		$blocrapports .= "			<input type='button' value=\"" . $lang['submit delete messages'] . "\" onClick=\"actions_reports.delete_re.value=actions_reports.delete_re1.value;actions_reports.submit();\" />\n";
		$blocrapports .= "			</td><td align='right'>\n";
		$blocrapports .= "			" . $lang['Order by2'] . "";
		$blocrapports .= "<a href='" . $scrfn . "?action=sogsrov&o=m&g=" . $galax . "&f=" . $re_disp_from . "' title=\"" . $lang['Order by metal.explain'] . "\"" . ($orderby == "m" ? " style='font-weight: normal;'" : "") . ">" . $lang['Order by metal'] . "</a>, ";
		$blocrapports .= "<a href='" . $scrfn . "?action=sogsrov&o=c&g=" . $galax . "&f=" . $re_disp_from . "' title=\"" . $lang['Order by crystal.explain'] . "\"" . ($orderby == "c" ? " style='font-weight: normal;'" : "") . ">" . $lang['Order by crystal'] . "</a>, ";
		$blocrapports .= "<a href='" . $scrfn . "?action=sogsrov&o=d&g=" . $galax . "&f=" . $re_disp_from . "' title=\"" . $lang['Order by deuterium.explain'] . "\"" . ($orderby == "d" ? " style='font-weight: normal;'" : "") . ">" . $lang['Order by deuterium'] . "</a>, ";
		$blocrapports .= "<a href='" . $scrfn . "?action=sogsrov&o=t&g=" . $galax . "&f=" . $re_disp_from . "' title=\"" . $lang['Order by total.explain'] . "\"" . ($orderby == "t" ? " style='font-weight: normal;'" : "") . ">" . $lang['Order by total'] . "</a>, ";
		$blocrapports .= "<a href='" . $scrfn . "?action=sogsrov&o=p&g=" . $galax . "&f=" . $re_disp_from . "' title=\"" . $lang['Order by position.explain'] . "\"" . ($orderby == "p" ? " style='font-weight: normal;'" : "") . ">" . $lang['Order by position'] . "</a>, ";
		$blocrapports .= "<a href='" . $scrfn . "?action=sogsrov&o=y&g=" . $galax . "&f=" . $re_disp_from . "' title=\"" . $lang['Order by priority.explain'] . "\"" . ($orderby == "y" ? " style='font-weight: normal;'" : "") . ">" . $lang['Order by priority'] . "</a>\n";
		$blocrapports .= "			</td></tr></table>\n";
		$blocrapports .= "		</td>\n";
		$blocrapports .= "	</tr>\n";
		
		// bloc titre des rapports d'espionnage + nombre + pagination pr�c/suiv
		$blocretitre = "	<tr>\n";
		$blocretitre .= "		<td colspan=\"3\" class='c'>";
		$blocretitre .= "<table width='100%'><tr><td><b>" . $lang['Spy reports'];
		if ($galax != "all") $blocretitre .= " &nbsp;(" . sprintf($lang['x for the galaxy y'], $galaxy_count[$galax], $galax) . ")";
		$blocretitre .= " &nbsp;(" . sprintf($lang['total reports: x'], sizeof($RE_chosen)) . ")</b></td><td align='right'><b>";
		$lnkprec = (($re_disp_from - $rapports_par_page) > 0 ? $re_disp_from - $rapports_par_page : 0);
		if (($rapports_par_page != 0) && ($re_disp_from > 0)) $blocretitre .= "<a href='" . $scrfn . "?action=sogsrov&o=" . $orderby . "&g=" . $galax . "&f=" . $lnkprec . "'>" . $lang['previous page'] . "</a>";
		else $blocretitre .= $lang['previous page.blank.length'];
		$blocretitre .= " &nbsp; &nbsp; ";
		if (($rapports_par_page != 0) && ((($galax != "all") && (($re_disp_from + $rapports_par_page) < $galaxy_count[$galax])) || (($galax == "all") && (($re_disp_from + $rapports_par_page) < sizeof($RE_chosen))))) $blocretitre .= "<a href='" . $scrfn . "?action=sogsrov&o=" . $orderby . "&g=" . $galax . "&f=" . ($re_disp_from + $rapports_par_page) . "'>" . $lang['next page'] . "</a>";
		else $blocretitre .= $lang['next page.blank.length'];
		$blocretitre .= "</b></td></tr></table></td>\n";
		$blocretitre .= "	</tr>\n";
		// -- fin du bloc titre des RE + nombre + pagination
		
		$blocrapports .= $blocretitre;
		
		$blocrapports .= "	<tr>\n";
		$blocrapports .= "		<th>" . $lang['Action'] . "</th>\n";
		$blocrapports .= "	 	<th>" . $lang['Date'] . "</th>\n";
		$blocrapports .= "	 	<th>" . $lang['Player'] . "</th>\n";
		$blocrapports .= "	</tr>\n";
		$blocrapports .= "\n";
		
		// on affiche un par un chaque rapport d'espionnage
		$count_re = 0;
		foreach ($RE_chosen as $i => $osef)
		{
			$tbl = explode(":", $RE[$i]['pos']);
			// on n'affiche que si l'utilisateur a choisit toutes les galaxies ou la galaxie dont la plan�te/lune fait partie
			// et que si ce sont les rapports de la page choisie
			if ((($rapports_par_page == 0) || (($count_re >= $re_disp_from) && ($count_re < ($re_disp_from + $rapports_par_page)))) && (($galax == "all") || ($galax == $tbl[0])))
			{
				$blocrapports .= "<!-- start spy report for " . $RE[$i]['planet'] . " [" . $RE[$i]['pos'] . "] -->\n";
				$blocrapports .= "	\n";
				$blocrapports .= "	<tr>\n";
				$priority_bg = "";
				if (($RE[$i]['priority'] == "0") && !empty($priority_color0)) $priority_bg = " style=\"background-color: " . $priority_color0 . ";\"";
				elseif (($RE[$i]['priority'] == "1") && !empty($priority_color1)) $priority_bg = " style=\"background-color: " . $priority_color1 . ";\"";
				elseif (($RE[$i]['priority'] == "2") && !empty($priority_color2)) $priority_bg = " style=\"background-color: " . $priority_color2 . ";\"";
				// on ajoute l'ancre pour apr�s �dition priorit�
				$blocrapports .= "	 <th" . $priority_bg . "><a name='" . $i . "' id='" . $i . "'>";
				// dans le cas d'une lune on rajoute le caract�re qui diff�rencie d'une plan�te
				// cet input hidden nous sert � d�tecter si un rapport �tait pr�sent ou pas, pour la suppression entre autres
				$blocrapports .= "<input type='hidden' name=\"present_" . $RE[$i]['pos'] . (strtolower($RE[$i]['planet']) == $lang['parse.moon'] ? "a" : '') . "\" value='1' />";
				$blocrapports .= "<input type='checkbox' name=\"delete_" . $RE[$i]['pos'] . (strtolower($RE[$i]['planet']) == $lang['parse.moon'] ? "a" : '') . "\" value='1' /></a></th>\n";
				$blocrapports .= "	 <th" . $priority_bg . ">" . $RE[$i]['date'] . "</th>\n";
				$blocrapports .= "	 <th" . $priority_bg . ">";
				// si on a un serveur OGSpy disponible, on va r�cup les informations sur la plan�te/lune
				$req = "SELECT `player`,`status`,`ally`,`moon` FROM `" . TABLE_UNIVERSE . "` WHERE `galaxy`='" . intval($tbl[0]) . "' AND `system`='" . intval($tbl[1]) . "' AND `row`='" . intval($tbl[2]) . "' LIMIT 1";
				$res = $db->sql_query($req) or die("MySQL Error !<br />\nRequest: " . $req . "<br />\nError: " . $db->sql_error());
				if ($db->sql_numrows($res) > 0)
				{
					$row = $db->sql_fetch_assoc($res);
					if (!empty($row['player']) && ($row['player'] != '(unknown)')) $blocrapports .= $row['player'];
					else $blocrapports .= "<span title=\"" . $lang['OGSpy.information not available.explain'] . "\">n/a</a>";
					if (!empty($row['status'])) $blocrapports .= ' (' . $row['status'] . ')';
					if (!empty($row['ally']) && ($row['ally'] != '(unknown)')) $blocrapports .= ' [' . $row['ally'] . ']';
					if (!empty($row['moon']) && ($row['moon'] != '(unknown)')) $blocrapports .= ' (+' . $lang['parse.moon'] . ')';
				}
				else $blocrapports .= "<span title=\"" . $lang['OGSpy.information not available.explain'] . "\">n/a</a>";
				$db->sql_free_result($res);
				$blocrapports .= "</th>\n";
				$blocrapports .= "	</tr>\n";
				$blocrapports .= "	<tr>\n";
				// bloc priorit�
				$blocrapports .= "		<td class=\"b\" align='center' valign='top'><b>" . $lang['parse.priority'] . "</b><br />&nbsp;<br />\n";
				$blocrapports .= "<select name='priority_" . $i . "' onChange=\"actions_reports.edit_priority_pos.value='" . $RE[$i]['pos'] . (strtolower($RE[$i]['planet']) == $lang['parse.moon'] ? "a" : '') . "';actions_reports.edit_priority_val.value=actions_reports.priority_" . $i .".value;actions_reports.edit_anchor_id.value='" . $i . "';actions_reports.submit();\">";
				$blocrapports .= "<option value='0'" . ($RE[$i]['priority'] == "0" ? ' selected' : '') . ">" . $lang['low'] . "</option><option value='1'" . ($RE[$i]['priority'] == "1" ? ' selected' : '') . ">" . $lang['normal'] . "</option><option value='2'" . ($RE[$i]['priority'] == "2" ? ' selected' : '') . ">" . $lang['high'] . "</option>";
				$blocrapports .= "</select><br />&nbsp;<br /><input type='button' title='" . $lang['Delete one.explain'] . "' value='" . $lang['Delete one'] . "' onClick=\"actions_reports.delete_one.value='" . $RE[$i]['pos'] . (strtolower($RE[$i]['planet']) == $lang['parse.moon'] ? "a" : '') . "';actions_reports.delete_re.value='deleteone';actions_reports.submit();\" /></td>\n";
				// fin du bloc priorit�
				$blocrapports .= "		<td colspan=\"2\" class=\"b\">\n";
				$blocrapports .= "			<table width='100%'>\n";
				$blocrapports .= "				<tr>\n";
				$blocrapports .= "					<td class=c colspan=4>" . $lang['parse.resources'] . "<b>";
				if (!empty($moon_color) && (strtolower($RE[$i]['planet']) == $lang['parse.moon'])) $blocrapports .= "<font color='" . $moon_color . "'>" . $lang['parse.moon'] . "</b> [" . $RE[$i]['pos'] . "]</font>";
				else $blocrapports .= "<font color='" . $limit_color1 . "'>" . $RE[$i]['planet'] . "</b> [" . $RE[$i]['pos'] . "]</font>";
				$blocrapports .= " " . $lang['parse.at'] . " " . $RE[$i]['date'] . "</td>\n";
				$blocrapports .= "				</tr>\n";
				$blocrapports .= "				<tr>\n";
				$blocrapports .= "					<td>" . $lang['parse.metal'] . "</td><td>";
				if ($RE[$i]['m�tal'] >= $seuils[0]) $blocrapports .= "<font color='" . $limit_color2 . "'>" . number_format($RE[$i]['m�tal'], 0, ',', '.') . "</font>";
				else $blocrapports .= "<font color='" . $limit_color1 . "'>" . number_format($RE[$i]['m�tal'], 0, ',', '.') . "</font>";
				$blocrapports .= "</td>\n";
				$blocrapports .= "					<td>" . $lang['parse.crystal'] . "</td><td>";
				if ($RE[$i]['cristal'] >= $seuils[1]) $blocrapports .= "<font color='" . $limit_color2 . "'>" . number_format($RE[$i]['cristal'], 0, ',', '.') . "</font>";
				else $blocrapports .= "<font color='" . $limit_color1 . "'>" . number_format($RE[$i]['cristal'], 0, ',', '.') . "</font>";
				$blocrapports .= "</td>\n";
				$blocrapports .= "				</tr>\n";
				$blocrapports .= "				<tr>\n";
				$blocrapports .= "					<td>" . $lang['parse.deuterium'] . "</td><td>";
				if ($RE[$i]['deut�rium'] >= $seuils[2]) $blocrapports .= "<font color='" . $limit_color2 . "'>" . number_format($RE[$i]['deut�rium'], 0, ',', '.') . "</font>";
				else $blocrapports .= "<font color='" . $limit_color1 . "'>" . number_format($RE[$i]['deut�rium'], 0, ',', '.') . "</font>";
				$blocrapports .= "</td>\n";
				$blocrapports .= "					<td>" . $lang['parse.energy'] . "</td><td>";
				if ($RE[$i]['�nergie'] >= $seuils[3]) $blocrapports .= "<font color='" . $limit_color2 . "'>" . number_format($RE[$i]['�nergie'], 0, ',', '.') . "</font>";
				else $blocrapports .= "<font color='" . $limit_color1 . "'>" . number_format($RE[$i]['�nergie'], 0, ',', '.') . "</font>";
				$blocrapports .= "</td>\n";
				$blocrapports .= "				</tr>\n";
				// et si on rajoutait une petite info pour savoir environ combien de transporteurs il faut
				// pour raider cette plan�te/lune...
				$blocrapports .= "				<tr>\n";
				$total = $RE[$i]['m�tal'] + $RE[$i]['cristal'] + $RE[$i]['deut�rium'];
				$seuil_total = $seuils[0] + $seuils[1] + $seuils[2];
				$blocrapports .= "					<td>" . $lang['total resources'] . "</td><td>";
				if ($total >= $seuil_total) $blocrapports .= "<font color='" . $limit_color2 . "'>" . number_format($total, 0, ',', '.') . "</font>";
				else $blocrapports .= "<font color='" . $limit_color1 . "'>" . number_format($total, 0, ',', '.') . "</font>";
				$blocrapports .= "</td>\n";
				// capacit�s des vaisseaux communs :
				// pt: 5000, gt: 25000, cr: 800, vb: 1500, rcy: 20000, des: 2000, sonde: 5
				// attention �a demande pas mal de calcul, surtout lorsque la capacit� est petite (sondes)
				// alors allez-y mollo :)
				$blocrapports .= "					<td colspan='2'>~ " . number_format(raid_transp_opt(5000, $RE[$i]['m�tal'], $RE[$i]['cristal'], $RE[$i]['deut�rium']), 0, ',', '.') . " PT,";
				$blocrapports .= " " . number_format(raid_transp_opt(25000, $RE[$i]['m�tal'], $RE[$i]['cristal'], $RE[$i]['deut�rium']), 0, ',', '.') . " GT,";
				$blocrapports .= " " . number_format(raid_transp_opt(1500, $RE[$i]['m�tal'], $RE[$i]['cristal'], $RE[$i]['deut�rium']), 0, ',', '.') . " VB,";
				$blocrapports .=" " . number_format(raid_transp_opt(2000, $RE[$i]['m�tal'], $RE[$i]['cristal'], $RE[$i]['deut�rium']), 0, ',', '.') . " DES</td>\n";
				$blocrapports .= "				</tr>\n";
				$blocrapports .= "			</table>\n";
				// on affiche d'un coup Flotte/D�fense/B�timents/Recherche
				$types = Array(4 => $lang['parse.fleet'], 5 => $lang['parse.defense'], 6 => $lang['parse.buildings'], 7 => $lang['parse.research']);
				foreach ($types as $cle => $m)
				{
					if ($RE[$i][$m] != 'not present')
					{
						$blocrapports .= "			<table width='100%'>\n";
						$blocrapports .= "				<tr><td class=c colspan=4>";
						if ((($m == $lang['parse.fleet']) || ($m == $lang['parse.defense'])) && !empty($RE[$i][$m])) $blocrapports .= "<font color='" . $limit_color2 . "'>" . $m."</font>";
						else $blocrapports .= $m;
						$blocrapports .= "</td></tr>\n";
						$k = true;
						foreach ($RE[$i][$m] as $key => $value)
						{
							if ($k) $blocrapports .= "				<tr>";
							$blocrapports .= "<td>" . $key . "</td><td>";
							if ($value >= $seuils[$cle]) $blocrapports .= "<font color='" . $limit_color2 . "'>" . $value . "</font>";
							else $blocrapports .= "<font color='" . $limit_color1 . "'>" . $value . "</font>";
							$blocrapports .= "</td>";
							if (!$k) $blocrapports .= "</tr>\n";
							$k = !$k;
						}
						$blocrapports .= "			</table>\n";
					}
				}
				// et enfin, la probabilit� de destruction des sondes
				$blocrapports .= "			<div align='center'>" . $lang['parse.chance'] . " ";
				if ($RE[$i]['proba'] > 0) $blocrapports .= "<font color='" . $limit_color2 . "'><big><big><b>" . $RE[$i]['proba'] . "%</b></big></big></font>";
				else $blocrapports .= $RE[$i]['proba'] . "%";
				$blocrapports .= "</div>\n";
				$blocrapports .= "		</td>\n";
				$blocrapports .= "	</tr>\n";
				$blocrapports .= "\n";
				$blocrapports .= "<!-- end spy report for " . $RE[$i]['planet'] . " [" . $RE[$i]['pos'] . "] -->		\n";
			}
			// on comptabilise tous les rapports, pour savoir o� on en est
			if (($galax == "all") || ($galax == $tbl[0])) $count_re++;
			// on r�cup�re le nombre de vaisseaux dans la flotte
			// => 2 => nombre de vaisseaux sup�rieur au seuil pr�d�fini
			// => 1 => nombre de vaisseaux sup�rieur � 0
			// => 0 => absence de flotte
			$flotte = ($RE[$i][$lang['parse.fleet'] . "_sum"] >= $seuils[4]) ? 2 : (($RE[$i][$lang['parse.fleet'] . "_sum"] > 0) ? 1 : 0);
			// on r�cup�re le nombre de batiments dans la d�fense
			// => 2 => nombre de d�fenses sup�rieur au seuil pr�d�fini
			// => 1 => nombre de d�fenses sup�rieur � 0
			// => 0 => absence de d�fense
			$defense = ($RE[$i][$lang['parse.defense'] . "_sum"] >= $seuils[5]) ? 2 : (($RE[$i][$lang['parse.defense'] . "_sum"] > 0) ? 1 : 0);
			// cet input hidden nous sert � d�tecter si une flotte poss�de plus de 10 vaisseaux
			$blocrapports .= "<input type='hidden' name=\"fleet_" . $RE[$i]['pos'] . (strtolower($RE[$i]['planet']) == $lang['parse.moon'] ? "a" : '') . "\" value='" . $flotte . "' />\n";
			// cet input hidden nous sert � d�tecter si une d�fense poss�de plus de 10 b�timents
			$blocrapports .= "<input type='hidden' name=\"defense_" . $RE[$i]['pos'] . (strtolower($RE[$i]['planet']) == $lang['parse.moon'] ? "a" : '') . "\" value='" . $defense . "' />\n";
		}
		
		// on remet le bloc de titre + fl�ches de pagination
		$blocrapports .= $blocretitre;
		
		// le bloc de suppression et choix du classement (ici, celui du bas)
		$blocrapports .= "	<tr>\n";
		$blocrapports .= "		<td colspan='3' class='b' align='center'>\n";
		$blocrapports .= "			<table width='100%' cellspacing='1' cellpadding='1'><tr><td align='left'>\n";
		$blocrapports .= "			<select name='delete_re2' onChange='actions_reports.delete_re1.value=actions_reports.delete_re2.value;'>\n";
		$blocrapports .= "				<option value='deletemarked'>" . $lang['Delete selected'] . "</option>\n";
		$blocrapports .= "				<option value='deletenonmarked'>" . $lang['Delete unselected'] . "</option>\n";
		$blocrapports .= "				<option value='deletesomefleet'>" . sprintf($lang['Delete fleet'], $seuils[4]) . "</option>\n";
		$blocrapports .= "				<option value='deletesomedefense'>" . sprintf($lang['Delete defense'], $seuils[5]) . "</option>\n";
		$blocrapports .= "				<option value='deleteallfleet'>" . $lang['Delete all fleet'] . "</option>\n";
		$blocrapports .= "				<option value='deletealldefense'>" . $lang['Delete all defense'] . "</option>\n";
		$blocrapports .= "				<option value='deletedisplayed'>" . $lang['Delete displayed'] . "</option>\n";
		$blocrapports .= "				<option value='deleteall'>" . $lang['Delete all'] . "</option>\n";
		$blocrapports .= "			</select>&nbsp;\n";
		$blocrapports .= "			<input type='button' value=\"" . $lang['submit delete messages'] . "\" onClick=\"actions_reports.delete_re.value=actions_reports.delete_re2.value;actions_reports.submit();\" />\n";
		$blocrapports .= "			</td><td align='right'>\n";
		$blocrapports .= "			" . $lang['Order by2'] . "";
		$blocrapports .= "<a href='" . $scrfn . "?action=sogsrov&o=m&g=" . $galax . "&f=" . $re_disp_from . "' title=\"" . $lang['Order by metal.explain'] . "\"" . ($orderby == "m" ? " style='font-weight: normal;'" : "") . ">" . $lang['Order by metal'] . "</a>, ";
		$blocrapports .= "<a href='" . $scrfn . "?action=sogsrov&o=c&g=" . $galax . "&f=" . $re_disp_from . "' title=\"" . $lang['Order by crystal.explain'] . "\"" . ($orderby == "c" ? " style='font-weight: normal;'" : "") . ">" . $lang['Order by crystal'] . "</a>, ";
		$blocrapports .= "<a href='" . $scrfn . "?action=sogsrov&o=d&g=" . $galax . "&f=" . $re_disp_from . "' title=\"" . $lang['Order by deuterium.explain'] . "\"" . ($orderby == "d" ? " style='font-weight: normal;'" : "") . ">" . $lang['Order by deuterium'] . "</a>, ";
		$blocrapports .= "<a href='" . $scrfn . "?action=sogsrov&o=t&g=" . $galax . "&f=" . $re_disp_from . "' title=\"" . $lang['Order by total.explain'] . "\"" . ($orderby == "t" ? " style='font-weight: normal;'" : "") . ">" . $lang['Order by total'] . "</a>, ";
		$blocrapports .= "<a href='" . $scrfn . "?action=sogsrov&o=p&g=" . $galax . "&f=" . $re_disp_from . "' title=\"" . $lang['Order by position.explain'] . "\"" . ($orderby == "p" ? " style='font-weight: normal;'" : "") . ">" . $lang['Order by position'] . "</a>, ";
		$blocrapports .= "<a href='" . $scrfn . "?action=sogsrov&o=y&g=" . $galax . "&f=" . $re_disp_from . "' title=\"" . $lang['Order by priority.explain'] . "\"" . ($orderby == "y" ? " style='font-weight: normal;'" : "") . ">" . $lang['Order by priority'] . "</a>\n";
		$blocrapports .= "			</td></tr></table>\n";
		$blocrapports .= "		</td>\n";
		$blocrapports .= "	</tr>\n";
		$blocrapports .= "</table>\n";
		$blocrapports .= "</form>\n";
		
		// -- fin du bloc de rapports d'espionnage
		
		
		echo "<tr>";
		// suivant le choix d'affichage
		if ($controlmenu_disp == '1') // � droite
		{
			echo "<td valign='top'>\n";
			echo $blocrapports;
			echo "</td>\n";
			echo "<td width='50'>&nbsp;</td>\n";
			echo "<td valign='top' align='center'>\n";
			echo $controlmenu;
			echo "</td>";
		}
		// en fait c'est le cas o� ($controlmenu_disp == '0')
		else // � gauche
		{
			echo "<td valign='top' align='center'>\n";
			echo $controlmenu;
			echo "</td>\n";
			echo "<td width='50'>&nbsp;</td>\n";
			echo "<td valign='top'>\n";
			echo $blocrapports;
			echo "</td>";
		}
	
	echo "</tr></table>\n";
	echo "</div>\n";
	
	require_once("views/page_tail.php");
}


// et wouala c'est fini :)

//EOF
?>
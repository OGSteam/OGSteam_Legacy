<?php
/** $Id$ **/
/**
* functions.php Défini les fonctions du mod
* @package [MOD] AutoUpdate
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 1.0
*	created		: 20/11/2006
*	modified	: 17/01/2007
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

$ban_mod = array('sql','mplogger','naqogsplugin','ogsfox','quimobserve','packmod','modupdate','market','myspeach');

/**
*Récupère la version du mod
*/
function versionmod() {
	global $db, $pub_action;
	$sql = "SELECT version FROM ".TABLE_MOD." WHERE action = '".$pub_action."' LIMIT 1";
	$query = $db->sql_query($sql);
	$fetch = $db->sql_fetch_assoc($query);
	return $fetch['version'];
}

/**
*Génère le fichier parameters.php
*/
function generate_parameters($coadmin, $downjson, $cycle, $begind, $beginh, $multi, $auto, $ban_mods) {
	global $lang;
	
	$id_php = '<?php'."\n";
	$id_php .= '/**'."\n";
	$id_php .= '* parameters.php Défini les paramètres du mod'."\n";
	$id_php .= '* @package [MOD] AutoUpdate'."\n";
	$id_php .= '* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>'."\n";
	$id_php .= '* @version '.versionmod()."\n";
	$id_php .= '* created	: '.date("d/m/Y H:i:s").' ('.$lang['autoupdate_admin_time'].')'."\n";
	$id_php .= '*/'."\n";
	$id_php .= "\n";
	$id_php .= 'if (!defined("IN_SPYOGAME")) die("Hacking attempt");'."\n";
	$id_php .= "\n";
	$id_php .= 'DEFINE("COADMIN", '.$coadmin.');'."\n";
	$id_php .= 'DEFINE("AUTO_MAJ", '.$auto.');'."\n";
	$id_php .= 'DEFINE("DOWNJSON", '.$downjson.');'."\n";
	$id_php .= 'DEFINE("CYCLE", '.$cycle.');'."\n";
	$id_php .= 'DEFINE("BEGIND", '.$begind.');'."\n";
	$id_php .= 'DEFINE("BEGINH", '.$beginh.');'."\n";
	$id_php .= 'DEFINE("MULTI", '.$multi.');'."\n";
	$id_php .= 'DEFINE("BAN_MODS", '.$ban_mods.');'."\n";
	$id_php .= '?>';
	//On ouvre le fichier en écriture et on efface ce qu'il y a dedans
	if (!fopen("mod/autoupdate/parameters.php", "wb")) {
		die($lang['autoupdate_admin_writeerror']);
		$generate = "no";
	} else {
		$fp = fopen("mod/autoupdate/parameters.php", "wb");
		fputs($fp,$id_php); //On écrit dans le fichier les nouveaux paramètres
		fclose($fp);
		chmod("mod/autoupdate/parameters.php", 0777);
		$generate = "yes";
	}
	return $generate;
}

/**
*Copie le fichier modupdate.json dans mod/modupdate.json
*/
function copymodupdate($param) {
	global $lang;
	if ($param == "yes") {
		$affiche1 = " : <a href='index.php?action=autoupdate&sub=tableau&down=yes'>".$lang['autoupdate_tableau_ok1']."</a>";
	} else {
		$affiche1 = "";
	}
	if (!copy("http://update.ogsteam.fr/mods/latest.php", "parameters/modupdate.json")) {
		$affiche2 = "<br />\n".$lang['autoupdate_tableau_error2'];
	} else {
		$affiche2 = "<br />\n".$lang['autoupdate_tableau_ok'];
	}
	$affiche = $affiche2.$affiche1;
	return $affiche;
}

function io_mkdir_p($target) {
	if (@is_dir($target)||empty($target)) return 1;
	if (@file_exists($target) && !is_dir($target)) return 0;
	if (io_mkdir_p(substr($target,0,strrpos($target,'/')))) {
		$ret=false;
		if (! file_exists($target)) $ret = @mkdir($target,0777);
		if (is_dir($target)) chmod($target, 0777);
		return $ret;
	}
	return 0;
}	

function ap_mkdir($d) {
	$ok = io_mkdir_p($d);
	return $ok;
}

/**
* Affiche sous forme de tableau table à 2 colonne les fichiers du zip et son état.
*/
function tableau($tableau, $type = "maj") {
	global $lang;
	while(list($key,$valeur) = each($tableau)) {
		$fichier = explode("/", $key);
		$nom = "";
		for($i = 1; $i < count($fichier); $i++) {
			if (count($fichier) >= 3 AND count($fichier) != $i AND $i > 1) {
				$slash = "/";
			} else {
				$slash = "";
			}
			$nom .= $slash.$fichier[$i];
		}
		$explode = explode(".", $key);
		if ($nom != "" AND $explode[0] != $key) {
			if ($type == "maj") {
				$etat = $lang['autoupdate_MaJ_uptodateok'];
			} else if ($type == "down") {
				$etat = $lang['autoupdate_MaJ_downok'];
			}
			echo "\t".'<tr>'."\n";
			echo "\t\t".'<td class="a">'.$nom.'</td>'."\n";
			echo "\t\t".'<td class="a">'.$etat.'</td>'."\n";
			echo "\t".'</tr>'."\n";
		}
	}
}

if (! function_exists("is__writable") ) {
/**
* Verifie les droits en écriture d'ogspy sur un fichier ou repertoire 
* @param string $path le fichier ou repertoire à tester
* @return boolean True si accés en écriture
* @comment http://fr.php.net/manual/fr/function.is-writable.php#68598
*/
	function is__writable($path)
	{
	
	    if ($path{strlen($path)-1}=='/')
	       
	        return is__writable($path.uniqid(mt_rand()).'.tmp');
	   
	    elseif (ereg('.tmp', $path))
	    {
	       
	        if (!($f = @fopen($path, 'w+')))
	            return false;
	        fclose($f);
	        unlink($path);
	        return true;
	
	    }
	    else
	       
	        return 0; // Or return error - invalid path...
	
	}
}
function getmodlist(){
	global $ban_mod;
	// Récupérer la liste des dernières versions dans le fichier JSON
    if(!file_exists("parameters/modupdate.json")) {
	//Retry once to not overload the server.
		if (!copy("http://update.ogsteam.fr/mods/latest.php", "parameters/modupdate.json")){
			die ("Fichier JSON Introuvable !");
		}
	}
	$contents = file_get_contents("parameters/modupdate.json");	
	$results = utf8_encode($contents);
	$data = json_decode($results, true);
	//Suppresion des Mods interdits
	if( BAN_MODS == 1){
		foreach( $ban_mod as $to_ban)
		{
			unset($data[$to_ban]);
		}
	}
	//var_dump($data);
	return $data;	
}	
?>

<?php
/** $Id$ **/
/**
* modUpdIncl.php Fichier d'includes du module AutoUpdate
* @package [MOD] AutoUpdate
* @author Jibus
* @version 1.0
* created	: 27/10/2006
* modified	: 19/01/2007
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

/**
* D�fini o� se trouve le fichier qui contient les derni�res versions des mods.
* Diff�rent suivant si allow_url_fopen est activ� ou non. S'il n'est pas activ�, on va chercher le fichier en local apr�s t�l�chargement.
*/
if(DOWNXML == 0) {
	DEFINE("XML_FILE","http://ogsteam.fr/download/modxml.xml");
} else {
	DEFINE("XML_FILE","parameters/modupdate.xml");
}

class Module {
	var $name;  		// nom du module
	var $version;   // num�ro de version
	var $link;		// lien pour t�l�chargement. Non pr�vu
	
	function Module ($m) {
		foreach ($m as $k=>$v) $this->$k = $m[$k];
	}
}

function readXML($filename) {
	// lit la base de donn�es xml des modules 
	$lines = @file($filename);
	
	if ($lines == false)
		return false;
	
	$data = implode("",$lines);
	
	if (function_exists("iconv")) {
		$data = iconv("ISO-8859-1","UTF-8",$data);  // Conversion du fichier .XML pour les caract�res sp�ciaux
	}

	$parser = xml_parser_create();
	xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
	xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
	xml_parse_into_struct($parser,$data,$values,$tags);
	xml_parser_free($parser);
	
	// boucle � travers les structures
	foreach ($tags as $key=>$val) {
		if ($key == "mod") {
			$modranges = $val;
			
			for ($i=0; $i < count($modranges); $i+=2) {
				$offset = $modranges[$i] + 1;
				$len = $modranges[$i + 1] - $offset;
				$tdb[] = parseMod(array_slice($values, $offset, $len));
			}
		} else {
			continue;
		}
	}
	return $tdb;
}

function parseMod($mvalues) {
	for ($i=0; $i < count($mvalues); $i++) $mod[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
	return new Module($mod);
}

function mustUpdate($curver,$xmlver) {
	$itis=2; // Non d�fini
	$xml=explode(".",$xmlver);
	$current=explode(".",$curver);
	for ($i=0;(($i<sizeof($current)) && ($i<sizeof($xml)));$i++) {
		if ($current[$i]>$xml[$i]) {
			$itis=false; // A jour
			break; 
		}
		if ($current[$i]<$xml[$i]) {
			$itis=true; // Pas a jour
			break; 
		} 
	}
	if ($itis===2) {
		if (sizeof($current)>=sizeof($xml)) {
			$itis=false; //$current est une sous version de $xml
		} else {
			for ($i=sizeof($current)-1;$i<sizeof($xml);$i++) {
				if ($xml[$i]) {
					$itis=true; // La version XML est une sous version de $current
				}
			}
			if ($itis==2) {
				$itis=false; // �galit� totale : A jour
			}
		}
	}
	return($itis);
}

?>

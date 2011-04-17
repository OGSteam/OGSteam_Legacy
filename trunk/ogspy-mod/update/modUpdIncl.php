<?php

/**
 *	modUpdIncl.php Fichier d'includes du module modUpdate
 *	@package	modUpdate
 *	@author		Jibus 
 */

define("MODULE_NAME","modUpdate");
define("MODULE_ACTION","modUpdate");
define("MODULE_VERSION","0.3b");
define("XML_FILE","http://www.ogsteam.fr/modupdate.xml");


/**
 *
 */
	class Module {
	   var $name;  		// nom du module
	   var $version;   // numéro de version
	   var $link;		// lien pour téléchargement. Non prévu
	   
	   function Module ($m) {
		   foreach ($m as $k=>$v)
			   $this->$k = $m[$k];
	   }
	}

	function readXML($filename) {
	   // lit la base de données xml des modules 
	   $lines = @file($filename);
	   
	   if ($lines == false)
		   return false;
	   
	   $data = implode("",$lines);
	   $parser = xml_parser_create();
	   xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
	   xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
	   xml_parse_into_struct($parser,$data,$values,$tags);
	   xml_parser_free($parser);
	
	   // boucle à travers les structures
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
	   for ($i=0; $i < count($mvalues); $i++)
		   $mod[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
	   return new Module($mod);
	}
	
	function mustUpdate($curver,$xmlver) 
	{ 
		$itis=2; // Non défini 
		$xml=explode(".",$xmlver); 
		$current=explode(".",$curver); 
		for ($i=0;(($i<sizeof($current)) && ($i<sizeof($xml)));$i++) 
		{ 
		  if ($current[$i]>$xml[$i]) 
		  { 
			$itis=false; // A jour
			break; 
		  } 
		  if ($current[$i]<$xml[$i])  
		  { 
			$itis=true; // Pas a jour
			break; 
		  } 
		} 
		if ($itis===2) 
		{ 
			if (sizeof($current)>=sizeof($xml)) 
			{ 
				$itis=false; //$current est une sous version de $xml
			} 
			else 
			{ 
				for ($i=sizeof($current)-1;$i<sizeof($xml);$i++)  
				{ 
					if ($xml[$i]) 
					{ 
						$itis=true; // La version XML est une sous version de $current
					} 
				} 
				if ($itis==2) 
				{ 
					$itis=false; // égalité totale : A jour
				} 
			} 
		}
		return($itis); 
	} 


?>

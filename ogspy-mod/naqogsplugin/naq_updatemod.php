<?php

/***************************************************************************
*	filename	: naq_updatemod.php
*	desc.		  : fonctions de consultation à partir d'un fichier référence
*	desc.     : de mises à jour disponibles
*	Author		: Naqdazar inspiré d'un code de Jibus
*	created		: 26/12/2006
*	modified	: 26/12/2006 01:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

define("OGSPLUGXML_FILE","http://ogsteam.fr/firespy/ogsplugin.xml");

/**
 *
 */
	class Module {
	   var $name;  		// nom du module(court sans espace)
	   var $title;  		// titre du module
	   var $version;   // numéro de version
	   var $link;		// lien pour téléchargement. Non prévu
	   var $history; // lien historique
	   var $tutorial; // lien tutoriel
	   var $forum; // lien forum
	   var $description; // ligne description , encodé utf8
     var $svn; // chemin svn
	   
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
  
  function GetModuleInfo($module_name) {
  
      $module_infos= array("name"=>"", "version"=>"", "link"=>"", "history"=>"", "tutorial"=>"", "forum"=>"", "description"=>"", "svn"=>"");
      // Récupérer la liste des dernières versions dans le fichier XML
      $file = OGSPLUGXML_FILE;
      // lecture du fichier des versions de mods
      $xml_mods = readXML($file);
      $getxml_error = false;
      if ($xml_mods == false)
      {
      	  $getxml_error = true;
      } else // naq_ogsplugincl.php
      {
            $prevver_exists = false; //count($xml_mods)>0;
            $mod_rank=0;
            while ($prevver_exists==false && $mod_rank<count($xml_mods)) {              
                  if ($xml_mods[$mod_rank]->name==$module_name) {
                     $prevver_exists=true;
                     $module_infos['name'] = $xml_mods[$mod_rank]->name;
                     $module_infos['title'] = $xml_mods[$mod_rank]->title;
                     $module_infos['link'] = $xml_mods[$mod_rank]->link;
          	         $module_infos['version'] = $xml_mods[$mod_rank]->version;                  
          	         $module_infos['history'] = $xml_mods[$mod_rank]->history;
          	         $module_infos['tutorial'] = $xml_mods[$mod_rank]->tutorial;
          	         $module_infos['forum'] = $xml_mods[$mod_rank]->forum;
          	         $module_infos['description'] = $xml_mods[$mod_rank]->description;
          	         $module_infos['svn'] = $xml_mods[$mod_rank]->svn;
                  } 
                  $mod_rank ++;
            }
      }
     if ($prevver_exists==true) {
        return $module_infos;
     } else return false; 
        
  } 
  
?>

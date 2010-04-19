<?php
/**
* xtense_uni_man.php
* @package Xtense
*  @author Naqdazar, then modified by OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

//Définitions
global $db;

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='xtense' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");


define("XTENSE_PLUGXML_FILE","http://ajdr.free.fr/Ogame/OGSpy/downloads/ogspyplugin/ogsplugin.xml");

/**
 *
 */
	class ListeUnivXML {
	   var $name;  		// labelunivers: ex univers1
	   var $univserver;  		// nom du serveur ogame

	   
	   function ListeUnivXML ($m) {
		   foreach ($m as $k=>$v)
			   $this->$k = $m[$k];
	   }
	}

	function readUniXML($filename) {
	   // lit la base de données xml des modules 
	   $lines = @file($filename);
	   
	   if ($lines == false) {		   
       return false;
		   
		   }
	   
	   $data = implode("",$lines);
	   $parser = xml_parser_create();
	   xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
	   xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
	   xml_parse_into_struct($parser,$data,$values,$tags);
	   xml_parser_free($parser);
	
	   // boucle à travers les structures
	   foreach ($tags as $key=>$val) {
		   if ($key == "uni") {
			   $modranges = $val;
	       
			   for ($i=0; $i < count($modranges); $i+=2) {
				   $offset = $modranges[$i] + 1;
				   $len = $modranges[$i + 1] - $offset;
				   $tdb[] = parseUniv(array_slice($values, $offset, $len));
			   }
		   } else {
			   continue;
		   }
	   }
	   return $tdb;
	}
	
	function parseUniv($mvalues) {
	   for ($i=0; $i < count($mvalues); $i++)
		   $mod[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
	   return new ListeUnivXML($mod);
	}
	
  
  function GetUnivInfo($univ_label) {
  
      $module_infos= array("name"=>"", "univserver"=>"");
      // Récupérer la liste des dernières versions dans le fichier XML
      $file = XTENSE_PLUGXML_FILE;
      // lecture du fichier des versions de mods
      $xml_mods = readUniXML($file);
      $getxml_error = false;
      if ($xml_mods == false)
      {
      	  $getxml_error = true;
      } else // naq_ogsplugincl.php
      {
            $prevver_exists = false; //count($xml_mods)>0;
            $mod_rank=0;
            while ($prevver_exists==false && $mod_rank<count($xml_mods)) {              
                  if ($xml_mods[$mod_rank]->label==$univ_label) {
                     $prevver_exists=true;
                     $module_infos['name'] = $xml_mods[$mod_rank]->name;
                     $module_infos['univserver'] = $xml_mods[$mod_rank]->univserver;
                  } 
                  $mod_rank ++;
            }
      }
     if ($prevver_exists==true) {
        return $module_infos;
     } else return false; 
        
  } 
  
    function GetUnivList($lang_tag) {
  
      $module_infos= array("name"=>"", "univserver"=>"");
      // Récupérer la liste des dernières versions dans le fichier XML
      $file = XTENSE_PLUGXML_FILE;
      // lecture du fichier des versions de mods
      $xml_mods = readUniXML($file);
      $getxml_error = false;
      if ($xml_mods == false)
      {
      	  $getxml_error = true;
      } else // naq_ogsplugincl.php
      {
            $mod_rank=0;
            while ($mod_rank<count($xml_mods)) {                                                     
                  $module_infos['name'] = $xml_mods[$mod_rank]->name;
                  $module_infos['univserver'] = $xml_mods[$mod_rank]->univserver;
                  $mod_rank ++;
            }
      }
     if ($getxml_error==false) {
        return $module_infos;
     } else return false; 
        
  } 
  
?>

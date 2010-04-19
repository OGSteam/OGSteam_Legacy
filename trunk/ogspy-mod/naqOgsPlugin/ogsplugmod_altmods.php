<?php
/**
* naqplg_altmods.php 
* @package OGS Plugin
* @author Naqdazar
* @link http://
* @version 1.2.n
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

require_once("mod/naq_ogsplugin/ogsplugincl.php");
require_once("mod/naq_ogsplugin/naq_updatemod.php");

//Définitions
global $db;

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='naq_ogsplugin' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");



// affichage dans une boucle

      $module_infos= array("name"=>"", "version"=>"", "link"=>"", "history"=>"", "tutorial"=>"", "forum"=>"", "description"=>"", "svn"=>"");
      // Récupérer la liste des dernières versions dans le fichier XML
      $file = OGSPLUGXML_FILE;
      // lecture du fichier des versions de mods
      $xml_mods = readXML($file);
      //*******************************************
      if (count($xml_mods)>0)
      echo "<div align=\"left\"><h1><font color='white'>(Mise à jour des données automatique)</font></h1></div>\n";
      else  echo "<div align=\"left\"><h1><font color='white'>(<font color='red'>La liste des modules n'a pu être récupérée!</font>)</font></h1></div>\n";
      //*************************************************************************
      $getxml_error = false;
      if ($xml_mods == false)
      {
      	  $getxml_error = true;
      } else // naq_ogsplugincl.php
      {
            $prevver_exists = false; //count($xml_mods)>0;
            $mod_rank=0;
            while ($mod_rank<count($xml_mods)) {              
                  if ($xml_mods[$mod_rank]->name!='naq_ogsplugin') {
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
          	         //----- AFFICHAGE
                      echo"<fieldset><legend><b><font color='#0080FF'>".$module_infos['title']." v".$module_infos['version']."</font></b></legend>";
                      echo"<p align='left'><font color='white'>";
                      echo $module_infos['description']."<br>";
                      echo "<a href=\"".$module_infos['link']."\">Télécharger l'archive</a> - ";
                      echo "<a href=\"".$module_infos['forum']."\">Article Forum</a><br>";                  
                      echo "</p>";
                      echo "</fieldset>";
                      echo "<br>";
                  } 
                  $mod_rank ++;

            }
      }


echo"<br>";
echo"</font></table>";



?>

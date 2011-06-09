<?php
/**
 * common.php 

Variables communes

 * @package QuiMSonde
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 1.5
 * dernière modification : 29.06.08
 * Largement inspiré du formidable mod QuiMObserve de Santory
 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

/*/ Mode débug
define( "QMS_DEBUG", 0 );
error_reporting(E_ALL);//*/

// Nom des tables
global $table_prefix;
define("TABLE_QMS", $table_prefix."QuiMeSonde");
define("TABLE_QMS_config", $table_prefix."QuiMeSonde_config");

// Nom des Dossiers
define("FOLDER_QMS","mod/quimsonde");
define("FOLDER_INCLUDE","mod/quimsonde/includes");
define("FOLDER_LANG","mod/quimsonde/lang");


// Variables Globales 
$mod_name = "QuiMSonde";
// Chemin des images 
$image_logo = FOLDER_QMS."/images/logo.gif";
$image_bbcode = FOLDER_QMS."/images/bbcode.gif";
$image_graph = FOLDER_QMS."/images/graph.gif";
$image_on = FOLDER_QMS."/images/on.gif";
$image_off = FOLDER_QMS."/images/off.gif";

// Les langues
include(FOLDER_LANG."/lang_french.php");


// Tableau du menu
$pages = Array(
Array('admin'=>0,'fichier'=>'accueil','texte'=>$lang['qms_menu_accueil'],'image_on'=>$image_on,'image_off'=>$image_off),
Array('admin'=>0,'fichier'=>'spy_list','texte'=>$lang['qms_menu_mes_espions'],'image_on'=>$image_on,'image_off'=>$image_off),
Array('admin'=>0,'fichier'=>'own_details','texte'=>$lang['qms_menu_mes_details'],'image_on'=>$image_on,'image_off'=>$image_off),
Array('admin'=>0,'fichier'=>'spy_list_public','texte'=>$lang['qms_menu_les_espions'],'image_on'=>$image_on,'image_off'=>$image_off),
Array('admin'=>0,'fichier'=>'all_details','texte'=>$lang['qms_menu_hall_of_fame'],'image_on'=>$image_on,'image_off'=>$image_off),
Array('admin'=>0,'fichier'=>'analyse','texte'=>$lang['qms_menu_analyse'],'image_on'=>$image_on,'image_off'=>$image_off),
Array('admin'=>0,'fichier'=>'insertion','texte'=>$lang['qms_menu_insertion'],'image_on'=>$image_on,'image_off'=>$image_off),
Array('admin'=>0,'fichier'=>'config','texte'=>$lang['qms_menu_config'],'image_on'=>$image_on,'image_off'=>$image_off),
Array('admin'=>1,'fichier'=>'admin','texte'=>$lang['qms_menu_admin'],'image_on'=>$image_on,'image_off'=>$image_off)
);

// Tableau des config
$config_list = Array(
Array('name'=>"",'titre'=>$lang['qms_config_titre1']),
Array('name'=>"lignes",'titre'=>$lang['qms_config_lignes']),
Array('name'=>"",'titre'=>$lang['qms_config_titre2']),
Array('name'=>"nbrapport",'titre'=>$lang['qms_config_nbrapport']),
Array('name'=>"periode",'titre'=>$lang['qms_config_periode']),
Array('name'=>"",'titre'=>$lang['qms_config_titre3']),
Array('name'=>"time_start",'titre'=>$lang['qms_config_time_start']),
Array('name'=>"time_end",'titre'=>$lang['qms_config_time_end']),
Array('name'=>"",'titre'=>$lang['qms_config_titre4']),
Array('name'=>"add_home",'titre'=>$lang['qms_config_add_home']),
Array('name'=>"banniere",'titre'=>$lang['qms_config_banniere']),
Array('name'=>"imgmenu",'titre'=>$lang['qms_config_imgmenu'])
);
?>
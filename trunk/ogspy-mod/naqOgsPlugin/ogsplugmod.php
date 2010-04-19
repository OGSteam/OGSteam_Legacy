<?php
/***************************************************************************
*	filename	: ogsplugmod.php
*	desc.		:
*	Author		: Naqdazar - lexa.gg@free.fr
*	created		: 01/08/2006
*	modified	: 01/08/2006
***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");



if(isset($_SERVER['HTTP_HOST'])){
  $hote=$_SERVER['HTTP_HOST'];
}else{
  $hote=$HTTP_HOST;
}

// Quelques fonctions nécessaires pour l'affichage du module
require("mod/naq_ogsplugin/ogsplugmod_func.php");

/* if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
    require_once("views/page_header.php");
    require("mod/naq_ogsplugin/ogsplugmod_user.php");
    require_once("views/page_tail.php");
    //exit();
	  // redirection("index.php?action=message&id_message=forbidden&info");
} */

require_once("mod/naq_ogsplugin/ogsplugincl.php");

// déplacement avant include autres script, nécessaire pour help.php

global $user_language, $pub_subaction;
$num_fr_servers = 51; // nombre d'univers

// traitement paramètres




// action conditionnelle suivant motif subaction
switch ($pub_subaction) {
    	case "set_ogspluginconfig" :
    	   set_ogspluginconfig(); // enregistrements paramètres
    	break;
    	
    	case "updateogsplugin" :
    	    # Copie du script de liaison à la racine du serveur OGSPY
          ogsmod_copyogsplugin();
    	break;
    	
    	case "changemenupos" :
    	    # Copie du script de liaison à la racine du serveur OGSPY
          OGSPlugin_set_menupos($pub_newmenupos);
          set_configvalue('naq_newmenupos', $pub_newmenupos);
          if ($pub_newmenupos=='5') redirection('index.php?action=administration&subaction=naq_ogsplugin');
          else if ($pub_newmenupos=='5') redirection('index.php?action=naq_ogsplugin');
    	break;
    	
    	case "setmodlanguage" :
          // modifie la langue de la page du module
          set_configvalue('naq_modlanguage', $pub_modlanguage);
          $server_config["naq_modlanguage"] = $pub_modlanguage;
    	break;
	
	}
$pub_subaction = ''; // réinitialisation
$_GET['subaction'] = '';


//******************************************************************************
//Appel des fichiers linguistiques
// Prévision version  bilingue
if (!empty($user_language) && strcasecmp($server_config["version"],"3.10")>=0) {
	include_once("mod/naq_ogsplugin/ogsplugin_lang_".$user_language.".php"); 
} else {
  switch ($server_config["naq_modlanguage"]) {
    case 'french':
       include_once("mod/naq_ogsplugin/ogsplugin_lang_french.php"); //Fichier anglais en premier dans le but d'avoir au moins une traduction anglaise si elle n'est pas disponible dans la langue désirée
       break;
    case 'english':
       include_once("mod/naq_ogsplugin/ogsplugin_lang_english.php"); //Fichier anglais en premier dans le but d'avoir au moins une traduction anglaise si elle n'est pas disponible dans la langue désirée
       break;
    default:
        include_once("mod/naq_ogsplugin/ogsplugin_lang_french.php"); //Fichier anglais en premier dans le but d'avoir au moins une traduction anglaise si elle n'est pas disponible dans la langue désirée
    break;
    
  }    
}  

global $ogp_lang;

//------------------------------------------------------------------------------



//******************************************************************************

// Affichage interface du module

require_once("views/page_header.php");
?>

<table width="100%">
<tr>
	<td>
		<table border="1">
		<tr align="center">
		<div align='center'>
<?php
if (!isset($pub_nqzaction)) {
	$pub_nqzaction = "mainpanel";
}

if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
    if ($pub_nqzaction != "mainpanel") {
    		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=naq_ogsplugin&nqzaction=mainpanel';\">";
    		echo "<a style='cursor:pointer'><font color='lime'>".$ogp_lang["principal_menu"]."</font></a>";
    		echo "</td>"."\n";
    	}
    	else {
    		echo "\t\t\t"."<th width='150'>";
    		echo "<a>".$ogp_lang["principal_menu"]."</a>";
    		echo "</th>"."\n";
    }

    if ($pub_nqzaction != "ogspylog") {
      	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=naq_ogsplugin&nqzaction=ogspylog';\">";
      	echo "<a style='cursor:pointer'><font color='lime'>".$ogp_lang["ogspylog_menu"]."</font></a>";
      	echo "</td>"."\n";
    }
    else {
      	echo "\t\t\t"."<th width='150'>";
      	echo "<a>".$ogp_lang["ogspylog_menu"]."</a>";
      	echo "</th>"."\n";
    }

    if ($pub_nqzaction != "ogspygroupman") {
      	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=naq_ogsplugin&nqzaction=ogspygroupman';\">";
      	echo "<a style='cursor:pointer'><font color='lime'>".$ogp_lang["ogspygroupman_menu"]."</font></a>";
      	echo "</td>"."\n";
    }
    else {
      	echo "\t\t\t"."<th width='150'>";
      	echo "<a>".$ogp_lang["ogspygroupman_menu"]."</a>";
      	echo "</th>"."\n";
    }

    if ($pub_nqzaction != "changelog") {
      	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=naq_ogsplugin&nqzaction=changelog';\">";
      	echo "<a style='cursor:pointer'><font color='lime'>".$ogp_lang["history_menu"]."</font></a>";
      	echo "</td>"."\n";
    }
    else {
      	echo "\t\t\t"."<th width='150'>";
      	echo "<a>".$ogp_lang["history_menu"]."</a>";
      	echo "</th>"."\n";
    }

    if ($pub_nqzaction != "othermods") {
      	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=naq_ogsplugin&nqzaction=othermods';\">";
      	echo "<a style='cursor:pointer'><font color='lime'>".$ogp_lang["thirdpartymods_menu"]."</font></a>";
      	echo "</td>"."\n";
    }
    else {
      	echo "\t\t\t"."<th width='150'>";
      	echo "<a>".$ogp_lang["thirdpartymods_menu"]."</a>";
      	echo "</th>"."\n";
    }
}

?>
    </div> <!-- <div align='center'> -->
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
<?php
switch ($pub_nqzaction) {
	case "mainpanel" :
	require_once("ogsplugmod_main.php");
	break;

	case "changelog" :
	require_once("ogsplugmod_chglog.php");
	break;
	
	case "ogspylog" :
	require_once("views/admin_viewer.php");
	break;
	
	// ogspygroupman
	case "ogspygroupman" :
	require_once("views/admin_members_group.php");
	break;
		
  
  case "othermods" :
	require_once("ogsplugmod_altmods.php");
	break;

}
?>
	</td>
</tr>
</table>

<?php


require_once("ogsplugmod_tail.php");


 ?>

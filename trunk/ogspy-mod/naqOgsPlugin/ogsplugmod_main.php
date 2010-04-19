<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $user_language, $pub_subaction, $user_data, $num_fr_servers, $server_config;

// filtrage aux non admins reporté plus loin pour afficher infos de config de la barre d'outils


require_once("includes/help.php");
require_once("mod/naq_ogsplugin/ogsplugmod_func.php");


?>
<script  Language="Javascript">

function GetServerUniverse(server_num) {

   /* var fr_servers = new Array("", "uni1.ogame.fr", "uni2.ogame.fr", "uni3.ogame.fr", "uni4.ogame.fr", 
                                  "uni5.ogame.fr", "uni6.ogame.fr", "uni7.ogame.fr", "uni8.ogame.fr", 
                                  "uni9.ogame.fr", "uni10.ogame.fr", "uni11.ogame.fr", "uni12.ogame.fr",
                                  "uni13.ogame.fr", "uni14.ogame.fr", "uni15.ogame.fr", "uni16.ogame.fr",
                                  "uni17.ogame.fr", "uni18.ogame.fr", "uni19.ogame.fr", "uni20.ogame.fr", 
                                  "uni21.ogame.fr", "uni22.ogame.fr", "uni23.ogame.fr", "uni24.ogame.fr", 
                                  "uni25.ogame.fr", "uni26.ogame.fr", "uni27.ogame.fr", "uni28.ogame.fr", 
                                  "uni29.ogame.fr", "uni30.ogame.fr", "uni31.ogame.fr", "uni32.ogame.fr", 
                                  "uni33.ogame.fr", "uni34.ogame.fr", "uni35.ogame.fr", "uni36.ogame.fr", 
                                  "uni37.ogame.fr", "uni38.ogame.fr", "uni39.ogame.fr", "uni40.ogame.fr",
                                 "uni41.ogame.fr", "uni42.ogame.fr", "uni43.ogame.fr", "uni44.ogame.fr",
                                 "uni45.ogame.fr", "uni46.ogame.fr", "uni47.ogame.fr", "uni48.ogame.fr",
                                 "uni49.ogame.fr", "uni51.ogame.fr", "uni52.ogame.fr", "uni53.ogame.fr",
                                  "uni54.ogame.fr", "uni55.ogame.fr", "uni56.ogame.fr", "uni57.ogame.fr"  ); */

   //document.getElementByName('ogspluginuniv').value = fr_servers[server_num];
   document.ogspluginparams.ogsplugin_numuniv.value =server_num;
   document.ogspluginparams.ogsplugin_nameuniv.value= document.univserver_name.value; //fr_servers[server_num];
}
   
   function resetuniversedetails() {
       document.ogspluginparams.univserver_name.selectedIndex=0;
       document.ogspluginparams.ogsplugin_nameuniv.value = '';
       document.ogspluginparams.ogsplugin_numuniv.value = '0';
   }



</script>
<?php

// traduction des chaînes d'aide en chaîne de langue
$help["ogsplug_univ"] = $ogp_lang["ogsplug_univ_help"];
$help["ogsplug_log"] = $ogp_lang["ogsplug_log_help"];
$help["ogsgametype"] = $ogp_lang["ogsgametype_help"];
$help["ogsportailurl"] = $ogp_lang["ogsportailurl_help"];
$help["ogsactivate_debuglog"] = $ogp_lang["ogsactivate_debuglog_help"];
$help["ogspageman"] = $ogp_lang["ogspageman_help"];
$help["ogsstats_timetable"] = $ogp_lang["ogsstats_timetable_help"];

global $ogp_lang;

init_serverconfig();

$modlanguage = $server_config["naq_modlanguage"];
$newmenupos = $server_config["naq_newmenupos"];

$gametype = $server_config["naq_gametype"];
if (!isset($gametype) || $gametype=='') $gametype = 'ogame'; // au cas où
if ($gametype=='eunivers') $gamename = 'E-Univers';
elseif($gametype=='ogame') $gamename = 'Ogame';
else $gamename = 'inconnu';

$logogslogon = $server_config["naq_logogslogon"]== 1 ? "checked" : "";
$logogsspyadd = $server_config["naq_logogsspyadd"]== 1 ? "checked" : "";

//--------
$logogsgalview = $server_config["naq_logogsgalview"]== 1 ? "checked" : "";
$logogsplayerstats = $server_config["naq_logogsplayerstats"]== 1 ? "checked" : "";
$logogsallystats = $server_config["naq_logogsallystats"]== 1 ? "checked" : "";
$logogsallyhistory = $server_config["naq_logogsallyhistory"]== 1 ? "checked" : "";
//--------------------

//logogsuserbuildings
$logogsuserbuildings = $server_config["naq_logogsuserbuildings"]== 1 ? "checked" : "";

//logogsusertechnos
$logogsusertechnos = $server_config["naq_logogsusertechnos"]== 1 ? "checked" : "";

//logogsuserdefence
$logogsuserdefence = $server_config["naq_logogsuserdefence"]== 1 ? "checked" : "";

//------------------------------------------------------------------------------
//logogsuserplanetempire
$logogsuserplanetempire = $server_config["naq_logogsuserplanetempire"]== 1 ? "checked" : "";
//logogsuserplanetmoon
$logogsusermoonempire = $server_config["naq_logogsusermoonempire"]== 1 ? "checked" : "";
//------------------------------------------------------------------------------
// gestion pages
$handlegalaxyviews  = $server_config["naq_handlegalaxyviews"]== 1 ? "checked" : "";
$handleplayerstats  = $server_config["naq_handleplayerstats"]== 1 ? "checked" : "";
$handleallystats    = $server_config["naq_handleallystats"]== 1 ? "checked" : "";
$statshoursaccept   = $server_config["naq_statshoursaccept"];
$handleespioreports = $server_config["naq_handleespioreports"]== 1 ? "checked" : "";
//------------------------------------------------------------------------------
$logogssqlfailure = $server_config["naq_logogssqlfailure"]== 1 ? "checked" : "";
//pub_allowstricnameuniv
$forcestricnameuniv = $server_config["naq_forcestricnameuniv"]== 1 ? "checked" : "";
$forceupdate_outdatedext = $server_config["naq_forceupdate_outdatedext"]== 1 ? "checked" : "";
$ogsactivate_debuglog = $server_config["naq_ogsactivate_debuglog"]== 1 ? "checked" : "";
$logunallowedconnattempt = $server_config["naq_logunallowedconnattempt"]== 1 ? "checked" : "";
//------------------------
$ogsplugin_nameuniv = $server_config["naq_ogsplugin_nameuniv"];
$ogsplugin_numuniv = $server_config["naq_ogsplugin_numuniv"];

$ogsportailurl = $server_config["naq_ogsportailurl"];

//naq_ogshttp_headerver
$ogshttp_headerver = $server_config["naq_ogshttp_headerver"];
//----------------- DILPLOMATIE----------------------
$ogsalliednames = $server_config["allied"];
$ogsenemyallies = $server_config["naq_ogsenemyallies"];
//naq_ogshttp_headerver
$ogstradingallies = $server_config["naq_ogstradingallies"];
$ogspnaalliesnames= $server_config["naq_ogspnaalliesnames"];
//------------------REDIRECTION---------------------
$notifyplugredirect= $server_config["naq_notifyplugredirect"]== 1 ? "checked" : "";;
$plugredirectmsg= $server_config["naq_plugredirectmsg"];

//ogspluginuniv
//-----------------------------


//-------------------------------------------

if(isset($_SERVER['PHP_SELF'])){
  $temp_phpself = $_SERVER['PHP_SELF'];
  $script_ogsplugin=str_replace('/index.php','/ogsplugin.php',$temp_phpself);
}else{
  $script_ogsplugin=str_replace('/index.php','/ogsplugin.php',$PHP_SELF);
}

// $rep_install=substr(htmlentities($repertoire, ENT_QUOTES), 1); // inutile


//-----------
require_once("mod/naq_ogsplugin/ogsplugincl.php");
require_once("mod/naq_ogsplugin/naq_updatemod.php");
$xpiplugin_info = GetModuleInfo('naq_ogsplugin');

//------------------------------------------------------------------------------

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
    require("mod/naq_ogsplugin/ogsplugmod_user.php");
    require_once("ogsplugmod_tail.php");

	  //redirection("index.php?action=message&id_message=forbidden&info");
}

//------------------------------------------------------------------------------

if ($xpiplugin_info===false) $targetogspyplugversion = OGP_MODULE_VERSION;
else $targetogspyplugversion=$xpiplugin_info["version"];

if ($xpiplugin_info===false) $targetogspyplugforum = 'http://naqdazar.goldzoneweb.info/forum/index.php';
else $targetogspyplugforum=$xpiplugin_info["forum"];


if ($xpiplugin_info===false) $targetogspyplugtutorial = "http://ogsteam.fr/firespy/Tutoriel%20MOD%20OGS%20Plugin.pdf";
else $targetogspyplugtutorial=$xpiplugin_info["tutorial"];

if ($xpiplugin_info===false) $targetogspyplughistory = '"http://ogsteam.fr/firespy/modogsplugin_history.txt';
else $targetogspyplughistory=$xpiplugin_info["history"];

	if ($xpiplugin_info===false || (strcasecmp(OGP_MODULE_VERSION,$targetogspyplugversion)>=0)) $prevver_message="( ".$ogp_lang["noupdate_header"]." )";
	else $prevver_message="( <blink>".$ogp_lang["newversionfound.prefix_header"]." <b>".$targetogspyplugversion."</b> ".$ogp_lang["newversionfound.suffix_header"]."</blink> : <a href=\"".$xpiplugin_info["link"]."\">".$ogp_lang["downloadaction_header"]."</a> | <a href=\"".$targetogspyplughistory."\" target=\"_blank\">".$ogp_lang["history_menu"]."</a>)";


// comparaison des fichiers ogsplugin.php
if (!file_exists('ogsplugin.php') || md5_file('ogsplugin.php')!=md5_file('mod/naq_ogsplugin/ogsplugin.php')) {
    echo '<div align="center" ><fieldset style="width:600;"><legend><blink><b>AVERTISSEMENT</b></blink></legend>';
    echo '<form name="ogspluginupdateroot" method="POST" action="index.php?action=naq_ogsplugin">'; // &subaction=updateogsplugin">';
    echo '<input type="hidden" name="subaction" size="1" value="updateogsplugin">';
    echo '<br><b><u>Le fichier ogsplugin.php n\'est pas à jour à la racine ou n\'est pas présent:</b></u>  ';
    echo '<input type="submit" size="15" value="Mettre à jour le fichier de liaison" >';
    echo '</fieldset></div></form>';
}


?>

<div align="center">
<br>
<a href="<?php echo $targetogspyplugtutorial; ?>" target="_blank"><?php echo $ogp_lang["tutorialmodmenu_header"]; ?></a> - <?php echo $prevver_message; ?>
<br><br>

<table width="100%">
<tr> <?php // Interface Module ?>
	<td class="c" colspan="2"><?php echo $ogp_lang["moduleinterf_main"];?></td>
</tr>

<form name='ogsplugin_modlanguage' method="POST" action="index.php?action=naq_ogsplugin">
<input type="hidden" name="subaction" size="1" value="setmodlanguage">
<tr>  <?php // langue ?>
	<th width="40%"><?php echo $ogp_lang["modlanguage_lang"];?>:</th>
	<th><select name="modlanguage" >
      <option value="french" <?php echo ($modlanguage=="french" ? "selected" : "") ?>>Français</option>
			<option value="english" <?php echo ($modlanguage=="english" ? "selected" : "") ?>>English</option>
      <!-- <option value="italian" <?php echo ($modlanguage=="italian" ? "selected" : "") ?>>Italiano</option> -->
      <!-- <option value="deutsch" <?php echo ($modlanguage=="deutsch" ? "selected" : "") ?>>Deutsch</option> -->
      <!-- <option value="spanish" <?php echo ($modlanguage=="spanish" ? "selected" : "") ?>>Español</option> -->
		</select>
		<?php echo "\t\t"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"submit\" value=\"".$ogp_lang["actionvalidate_form"]."\"></th>";
        ?>
</tr>
</form>


<?php if (strcasecmp($server_config["version"],"3.10")>=0 || strcasecmp($server_config["version"],"1.0")>=0) { /* seulement pour ogspy/unispy 3.1dev + */?>
    <form name='ogsplugin_changemenupos' method="POST" action="index.php?action=naq_ogsplugin">
    <input type="hidden" name="subaction" size="1" value="changemenupos">
        <tr>
            <th width="40%"><?php echo $ogp_lang["menupos_label"];?>:</th>
          	<th><select name="newmenupos" >
                <option value="5" <?php echo ((int)$newmenupos==5 ? "selected" : "") ?>>Administration</option>
          			<option value="3" <?php echo ((int)$newmenupos==3 ? "selected" : "").">".$ogp_lang["menupos_common"]; ?></option>

          		  </select>
          		<?php echo "\t\t"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"submit\" value=\"".$ogp_lang["actionvalidate_form"]."\">";
                  ?>
            </th>
        </tr>
    </form>
<?php } ?>

</table>
</form>
<br />

<?php // RUBRIQUE DECURITE / DIVERS ?>

<form name='ogspluginparams' method="POST" action="index.php?action=naq_ogsplugin">
<input type="hidden" name="subaction" size="1" value="set_ogspluginconfig">
<table width="100%">
    <thead>
        <tr>
        	<td class="c" colspan="4"><?php echo $ogp_lang["gameident_main"];?>:</td>
        </tr>
    </thead>
    <tbody>
        <tr>  <?php // langue ?>
          <th>1</th>
        	<th width="50%"><?php echo $ogp_lang["servergametype"]; echo ogsplugin_help("ogsgametype"); ?>:</th>
        	<th><select name="gametype" onchange="document.ogspluginparams.ogsportailurl.selectedIndex=0; resetuniversedetails();">
              <option value="ogame" <?php echo ($gametype=="ogame" ? "selected" : "") ?>  >Ogame</option>
        			<option value="eunivers" <?php echo ($gametype=="eunivers" ? "selected" : "") ?>>E-Univers</option>
        			<option value="projet42" <?php echo ($gametype=="projet42" ? "selected" : "") ?>>Projet 42</option>
        		</select>
         </th>
         <th>
            <input type="submit" value="<?php echo $ogp_lang["actionvalidate_form"]; ?>"/>
         </th>
        </tr>
        <tr >  <?php // Portail Ogame ?>
          <th>2</th>
        	<th width="50%"><?php echo $ogp_lang[$gametype."gate_misc"];/*( $gametype=='eunivers' ? $ogp_lang["euniversgate_misc"]:$ogp_lang["ogamegate_misc"]);  */echo ogsplugin_help("ogsportailurl"); ?> :</th>  <!-- naq_ogsportailurl -->
        	<th><select name="ogsportailurl" onChange="resetuniversedetails();" >
        			<option><?php echo $ogp_lang["gamegate"]; ?></option>
        			<?php if ($gametype=='ogame') {
                      echo '<option value="fr" '.($ogsportailurl=="fr" ? "selected" : "").'>www.ogame.fr</option>';
                			echo '<option value="org" '.($ogsportailurl=="org" ? "selected" : "").'>www.ogame.org(en)</option>';
                      echo '<option value="it" '.($ogsportailurl=="it" ? "selected" : "").'>www.ogame.it(en)</option>';
                      echo '<option value="de" '.($ogsportailurl=="de" ? "selected" : "").'>www.ogame.de(en)</option>';
                      echo '<option value="spa" '.($ogsportailurl=="spa" ? "selected" : "").'>www.ogame.com.es(en)</option>';
              } else if($gametype=='eunivers') {
                    echo '<option value="org" '.($ogsportailurl=="org" ? "selected" : "").' >www.e-univers.org</option>';

              } else if($gametype=='projet42') {
                    echo '<option value="org" '.($ogsportailurl=="org" ? "selected" : "").' >www.projet42.org</option>';

              } ?>
        		</select>
           <th>
              <input type="submit" value="<?php echo $ogp_lang["actionvalidate_form"]; ?>"/>
           </th>
            
        </tr>

        <tr>  <?php // Serveur d'univers Ogame® associé au serveur OGSPY ?>
          <th>3</th>
        	<th width="50%"><?php echo $ogp_lang[$gametype."server_misc"] /*( $gametype=='eunivers' ? $ogp_lang["euniversserver_misc"] : $ogp_lang["ogameserver_misc"])*/." (".( $gametype=='eunivers' ? "www.e-univers.".$ogsportailurl:( $gametype=='projet42' ? "www.projet42.".$ogsportailurl:($ogsportailurl!="" ? "www.ogame.$ogsportailurl" : $ogp_lang["domain_misc"]."?"))); ?>): </th>  <!-- naq_ogsplugin_nameuniv -->
        	<th><select name="univserver_name" onChange="document.ogspluginparams.ogsplugin_nameuniv.value=this.value;document.ogspluginparams.ogsplugin_numuniv.value=this.selectedIndex;">
          <!-- onChange="GetServerUniverse(this.selectedIndex);" > -->
        			<option><?php echo $ogp_lang["universe_misc"]; ?></option>
                 <?php
                      //for ($cpt=1; $cpt<=$num_fr_servers; $cpt++ ) {
        	      //echo "\t\t\t\t"."<option value='".$cpt."' ".($ogsplugin_numuniv==$cpt? "SELECTED":"").">Univers ".$cpt."</option>";
               // }
                  require("mod/naq_ogsplugin/ogsplugin_uniman.php");
                  // récupération liste univers depuis fichier XML


                  // Récupérer la liste des dernières versions dans le fichier XML
                  if ($ogsportailurl!="" && gametype!='') {
                      $file = "mod/naq_ogsplugin/ogp_".$gametype."_unilist_".$ogsportailurl.".xml";

                  } else $file = "mod/naq_ogsplugin/ogp_unilist_fr.xml";

                  // lecture du fichier des univers
                  $xml_mods = readUniXML($file);
                  $getxml_error = false;
                  if ($xml_mods == false)
                  {
                  	  echo "\t\t\t\t"."<option value='".$mod_rank."' SELECTED>".$ogp_lang["errorreadingxmluni_misc"]."(".count($xml_mods).")</option>";
                      $getxml_error = true;
                  } else // naq_ogsplugincl.php
                  {
                        $mod_rank=0;
                        while ($mod_rank<count($xml_mods)) {
                               echo "\t\t\t\t"."<option value='".($xml_mods[$mod_rank]->univserver)."' ".($ogsplugin_numuniv==($mod_rank+1)? "SELECTED":"").">".$ogp_lang["universelabel_misc"]." ".($mod_rank+1)."</option>";
                              $mod_rank ++;
                        }
                  }
                  //***********************************************
                 ?>
        		</select>
            <input type="hidden" name="ogsplugin_numuniv" size="1" value="<?php echo $ogsplugin_numuniv;?>">&nbsp; : &nbsp;
            <input type="text" name="ogsplugin_nameuniv" size="20" value="<?php echo $ogsplugin_nameuniv;?>" onkeypress="document.ogspluginparams.ogsplugin_numuniv.type='text';"><?php echo ogsplugin_help("ogsplug_univ"); ?>
            </th>
             <th>
                <input type="submit" value="<?php echo $ogp_lang["actionvalidate_form"]; ?>"/>
             </th>
        </tr>
        <tr>
        	<?php if ($user_data["user_admin"] == 1  || $user_data["user_coadmin"] == 1)
                      echo "\t\t"."<th colspan=\"4\">". /*<input type=\"submit\" value=\"".$ogp_lang["actionvalidate_form"]."\">&nbsp; */"<input type=\"reset\" value=\"".$ogp_lang["actionreset_form"]."\"></th>";
                ?>
        </tr>
    </tbody>
</table>


<br />

<table width="100%">
<tr> <?php // Rubrique Gestion des pages ?>
	<td class="c" colspan="3"><?php echo $ogp_lang["pagehandling_main"]; echo ogsplugin_help("ogspageman"); ?></td>
</tr>

<tr>  <?php // Traitement des vues galaxies ?>
	<th width="60%" colspan="2"><?php echo $ogp_lang["galviews_pghand"];?>:</th>
        <th><input name="handlegalaxyviews" type="checkbox" value="1" <?php echo $handlegalaxyviews;?>></th>
</tr>


<tr>  <?php // Traitement des classements joueur ?>
	<th width="60%" colspan="2"><?php echo $ogp_lang["playerstats_pghand"];?>:</th>
        <th><input name="handleplayerstats" type="checkbox" value="1" <?php echo $handleplayerstats;?>></th>
</tr>

<tr>  <?php // Traitement des classements alliance ?>
	<th width="60%" colspan="2"><?php echo $ogp_lang["allystats_pghand"];?>:</th>
        <th><input name="handleallystats" type="checkbox" value="1" <?php echo $handleallystats;?>></th>
</tr>

<tr>  <?php // Horaires stats acceptés ?>
  <th width="10%">&nbsp;</th>
	<th width="30%"><?php echo "<ul><li>".$ogp_lang["allystats_timetable"].ogsplugin_help("ogsstats_timetable").":";?></li></ul></th>
        <th><input name="statshoursaccept" type="text" value="<?php echo $statshoursaccept;?>"/></th>
</tr>

<tr>  <?php // Traitement des rapports d'espionnage ?>
	<th width="60%" colspan="2"><?php echo $ogp_lang["spyreports_pghand"];?>:</th>
        <th><input name="handleespioreports" type="checkbox" value="1" <?php echo $handleespioreports;?>></th>
</tr>


<tr>
	<?php if ($user_data["user_admin"] == 1  || $user_data["user_coadmin"] == 1)
              echo "\t\t"."<th colspan=\"3\"><input type=\"submit\" value=\"".$ogp_lang["actionvalidate_form"]."\">&nbsp;<input type=\"reset\" value=\"".$ogp_lang["actionreset_form"]."\"></th>";
        ?>
</tr>
</table>


<br />

<?php // RUBRIQUE DECURITE / DIVERS ?>


<table width="100%">
<tr>
	<td class="c" colspan="2"><?php echo $ogp_lang["miscellanous_main"];?></td>
</tr>

<tr>  <?php // Tentative de connexion non autorisée/inconnue ?>
	<th width="60%"><?php echo $ogp_lang["connectattempt_misc"]; ?> :</th>  <!-- naq_logunallowconnattempt -->
        <th><input name="logunallowedconnattempt" type="checkbox" value="1" <?php echo $logunallowedconnattempt;?>></th>
</tr>


<tr>  <?php // Bloquer les requètes provenant d'un serveur ogame non désigné ?>
	<th width="60%"><?php echo $ogp_lang["blockextrarequests_misc"]; ?>  (<?php echo $ogsplugin_nameuniv;?>):</th>  <!-- naq_allowstricnameuniv -->
        <th><input name="forcestricnameuniv" type="checkbox" value="1" <?php echo $forcestricnameuniv;?>></th>
</tr>

<tr>  <?php // Bloquer barre d'outils obsolètes ?>
	<th width="60%"><?php echo $ogp_lang["blockoutdatedtoolbars_misc"]; ?>  :</th>
        <th><input name="forceupdate_outdatedext" type="checkbox" value="1" <?php echo $forceupdate_outdatedext;?>></th>
</tr>

<tr>  <?php // Activer journalisation du plugin ?>
	<th width="60%"><?php echo $ogp_lang["logogspluginphp_misc"]; echo ogsplugin_help("ogsactivate_debuglog"); ?> :</th>
        <th><input name="ogsactivate_debuglog" type="checkbox" value="1" <?php echo $ogsactivate_debuglog;?>>
        <?php // if ($ogsactivate_debuglog=='checked') echo"<a href=\"mod/naq_ogsplugin/debug/ogsplugin.txt\" target=\"_blank\">Journal</a>"; ?></th>
</tr>

<tr>  <?php // Échecs de requète base de données ?>
	<th width="60%"><?php echo $ogp_lang["databasefailure_misc"]; ?> :</th>  <!-- naq_logogssqlfailure -->
        <th><input name="logogssqlfailure" type="checkbox" value="1" <?php echo $logogssqlfailure;?>></th>
</tr>



<tr>
	<?php if ($user_data["user_admin"] == 1  || $user_data["user_coadmin"] == 1)
              echo "\t\t"."<th colspan=\"2\"><input type=\"submit\" value=\"".$ogp_lang["actionvalidate_form"]."\">&nbsp;<input type=\"reset\" value=\"".$ogp_lang["actionreset_form"]."\"></th>";
        ?>
</tr>


</table>


<br />


<table width="100%">

<tr> <?php // rubrique journalisation ?>
	<td class="c" colspan="2"><?php echo $ogp_lang["pluglogopts_main"]; echo ogsplugin_help("ogsplug_log"); ?></td>
</tr>
<tr> <?php // Connection du plugin ?>
	<th width="60%"><?php echo $ogp_lang["plugconnection_logopts"]; ?>:</th>  <?php // naq_logogslogon ?>
        <th><input name="logogslogon" type="checkbox" value="1" <?php echo $logogslogon;?>></th>
</tr>

<tr> <?php // Mises à jour de rapports d'espionnage ?>
	<th width="60%"><?php echo $ogp_lang["spyreportupdate_logopts"]; ?>:</th>  <?php // naq_logogsspyadd ?>
        <th><input name="logogsspyadd" type="checkbox" value="1" <?php echo $logogsspyadd;?>></th>
</tr>

<tr> <?php // Mises à jour de galaxie ?>
	<th width="60%"><?php echo $ogp_lang["galviewsupdate_logopts"]; ?>:</th>  <?php // naq_logogsgalview ?>
        <th><input name="logogsgalview" type="checkbox" value="1" <?php echo $logogsgalview;?>></th>
</tr>
<tr> <?php // Mises à jour classements joueurs ?>
	<th width="60%"><?php echo $ogp_lang["playerstatsupdate_logopts"]; ?>:</th>  <?php // naq_logogsplayerstats   ?>
        <th><input name="logogsplayerstats" type="checkbox" value="1" <?php echo $logogsplayerstats;?>></th>
</tr>
<tr> <?php // Mises à jour classements alliances ?>
	<th width="60%"><?php echo $ogp_lang["allystatsupdate_logopts"]; ?>:</th> <?php // naq_logogsallystats  ?>
        <th><input name="logogsallystats" type="checkbox" value="1" <?php echo $logogsallystats;?>></th>
</tr>

<tr> <?php // Mises à jour classements alliance interne ?>
	<th width="60%"><?php echo $ogp_lang["allyhistoryupdate_logopts"]; ?>:</th>  <?php // naq_logogsallyhistory ?>
        <th><input name="logogsallyhistory" type="checkbox" value="1" <?php echo $logogsallyhistory;?>></th>
</tr>

<tr> <?php // Mises à jour de la page bâtiments ?>
	<th width="60%"><?php echo $ogp_lang["buildingspageupdate_logopts"]; ?>:</th>  <?php // naq_logogsuserbuildings ?>
        <th><input name="logogsuserbuildings" type="checkbox" value="1" <?php echo $logogsuserbuildings;?>></th>
</tr>

<tr> <?php // Mises à jour de la page technologie ?>
	<th width="60%"><?php echo $ogp_lang["technopageupdate_logopts"]; ?>:<?php echo $ogp_lang["plugconnection_logopts"]; ?>:</th>  <!-- naq_logogsusertechnos -->
        <th><input name="logogsusertechnos" type="checkbox" value="1" <?php echo $logogsusertechnos;?>></th>
</tr>

<tr> <?php // Mises à jour de la page défense ?>
	<th width="60%"><?php echo $ogp_lang["defencepageupdate_logopts"]; ?>:</th>  <?php // naq_logogsuserdefence ?>
        <th><input name="logogsuserdefence" type="checkbox" value="1" <?php echo $logogsuserdefence;?>></th>
</tr>

<tr> <?php // Mises à jour de la page empire(planètes) ?>
	<th width="60%"><?php echo $ogp_lang["planetempireupdate_logopts"]; ?>:</th>  <?php // naq_logogsuserdefence ?>
        <th><input name="logogsuserplanetempire" type="checkbox" value="1" <?php echo $logogsuserplanetempire;?>></th>
</tr>

<tr> <?php // Mises à jour de la page empire(lunes) ?>
	<th width="60%"><?php echo $ogp_lang["moonempireupdate_logopts"]; ?>:</th>  <?php // naq_logogsuserplanetmoon ?>
        <th><input name="logogsusermoonempire" type="checkbox" value="1" <?php echo $logogsusermoonempire;?>></th>
</tr>
<tr>
	<?php if ($user_data["user_admin"] == 1  || $user_data["user_coadmin"] == 1)
              echo "\t\t"."<th colspan=\"2\"><input type=\"submit\" value=\"".$ogp_lang["actionvalidate_form"]."\">&nbsp;<input type=\"reset\" value=\"".$ogp_lang["actionreset_form"]."\"></th>";
        ?>
</tr>
</table>


<br />

<?php  /* if (file_exists('includes/ogame.php') && !file_exists('includes/univers.php') && strcasecmp($server_config["version"],"3.02")>=0)  */ { ?>
<table width="100%">
<tr>
	<td class="c" colspan="2"><?php echo $ogp_lang["diplomaty_main"];?></td>
</tr>
<tr>  <?php // Alliances en pacte total ?>
	<th width="50%"><font color='limegreen'><?php echo $ogp_lang["ptcontract_diplo"]; ?>:</font></th>
	<th><input type="text" name="ogsalliednames" size="50" value="<?php echo $ogsalliednames;?>" ></th>
</tr>
<tr>  <?php // Alliances en pacte de non agression ?>
	<th width="50%"><font color='deepskyblue'><?php echo $ogp_lang["pnacontract_diplo"]; ?>:</font></th>
	<th><input type="text" name="ogspnaalliesnames" size="50" value="<?php echo $ogspnaalliesnames;?>" ></th>
</tr>
<tr>  <?php // Alliances enemies ?>
	<th width="50%"><font color='red'><?php echo $ogp_lang["enemiesallies_diplo"]; ?>:</font></th>
	<th><input type="text" name="ogsenemyallies" size="50" value="<?php echo $ogsenemyallies;?>" ></th>
</tr>
<tr>  <?php // Alliances commerçantes ?>
	<th width="50%"><font color='gold'><?php echo $ogp_lang["tradingallies_diplo"]; ?>:</font></th>
	<th><input type="text" name="ogstradingallies" size="50" value="<?php echo $ogstradingallies;?>" ></th>
</tr>
<tr>
	<?php if ($user_data["user_admin"] == 1  || $user_data["user_coadmin"] == 1)
              echo "\t\t"."<th colspan=\"2\"><input type=\"submit\" value=\"".$ogp_lang["actionvalidate_form"]."\">&nbsp;<input type=\"reset\" value=\"".$ogp_lang["actionreset_form"]."\"></th>";
        ?>
</tr>

</table>
<?php } // fermeture cas test UNISPY ?>


<br />


<table width="100%">
    <tr>
    	<td class="c" colspan="2"><?php echo $ogp_lang["redirection_main"];?></td>
    </tr>

    <tr>  <?php // Notifier la redirection du script ?>
    	<th width="60%"><?php echo $ogp_lang["notifyredir_redir"];?>:</th>  <!-- naq_notifyplugredirect -->
            <th><input name="notifyplugredirect" type="checkbox" value="1" <?php echo $notifyplugredirect;?>></th>
    </tr>
    <tr>  <?php // Message à afficher(url) ?>
    	<th width="60%"><font color='limegreen'><?php echo $ogp_lang["redirmessage_redir"];?>:</font></th>
    	<th><input type="text" name="plugredirectmsg" size="60" value="<?php echo $plugredirectmsg;?>" ></th>
    </tr>

    <tr>
    	<?php if ($user_data["user_admin"] == 1  || $user_data["user_coadmin"] == 1)
                  echo "\t\t"."<th colspan=\"2\"><input type=\"submit\" value=\"".$ogp_lang["actionvalidate_form"]."\">&nbsp;<input type=\"reset\" value=\"".$ogp_lang["actionreset_form"]."\"></th>";
            ?>
    </tr>
</table>

</form>



<?php require("mod/naq_ogsplugin/ogsplugmod_user.php"); ?>

<br>

<?php // Si Forum OGS Team indisponible ?>
<font color='white'><?php echo $ogp_lang["forumlinkinfo_tail"];?> : </font><a href="<?php echo $targetogspyplugforum; ?>" target="_blank"><?php echo $ogp_lang["authorforum_tail"];?></a>

<br>

</div> <!-- <div align="center"> -->

<!-- </table> -->


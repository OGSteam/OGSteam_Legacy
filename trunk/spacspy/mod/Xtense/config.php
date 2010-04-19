<?php
/**
* xtense_plugin_mod_main.php
* @package Xtense
*  @author Naqdazar, then modified by OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

if (!defined('IN_SPACSPY')) die("Hacking attempt");

//Définitions
global $db;

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='xtense' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");


global $user_language, $pub_subaction;
require_once("mod/Xtense/xtense_uni_man.php");
$num_fr_servers = 49;

init_serverconfig();

$debug = $server_config["xtense_debug"]== 1 ? "checked" : "";
$maintenance = $server_config["xtense_maintenance"]== 1 ? "checked" : "";

$logogslogon = $server_config["xtense_logogslogon"]== 1 ? "checked" : "";
$logogsspyadd = $server_config["xtense_logogsspyadd"]== 1 ? "checked" : "";

//--------

$logogsgalview = $server_config["xtense_logogsgalview"]== 1 ? "checked" : "";

$logogsplayerstats = $server_config["xtense_logogsplayerstats"]== 1 ? "checked" : "";

$logogsallystats = $server_config["xtense_logogsallystats"]== 1 ? "checked" : "";

$logogsallyhistory = $server_config["xtense_logogsallyhistory"]== 1 ? "checked" : "";
//--------------------

//logogsuserbuildings
$logogsuserbuildings = $server_config["xtense_logogsuserbuildings"]== 1 ? "checked" : "";

//logogsusertechnos
$logogsusertechnos = $server_config["xtense_logogsusertechnos"]== 1 ? "checked" : "";

//logogsuserdefence
$logogsuserdefence = $server_config["xtense_logogsuserdefence"]== 1 ? "checked" : "";

//------------------------------------------------------------------------------

//logogsuserplanetempire
$logogsuserplanetempire = $server_config["xtense_logogsuserplanetempire"]== 1 ? "checked" : "";

//logogsuserplanetmoon
$logogsusermoonempire = $server_config["xtense_logogsusermoonempire"]== 1 ? "checked" : "";

//------------------------------------------------------------------------------

// gestion pages
$handlegalaxyviews  = $server_config["xtense_handlegalaxyviews"]== 1 ? "checked" : "";
$handleplayerstats  = $server_config["xtense_handleplayerstats"]== 1 ? "checked" : "";
$handleallystats    = $server_config["xtense_handleallystats"]== 1 ? "checked" : "";
$handleespioreports = $server_config["xtense_handleespioreports"]== 1 ? "checked" : "";


//------------------------------------------------------------------------------

$logogssqlfailure = $server_config["xtense_logogssqlfailure"]== 1 ? "checked" : "";

//pub_allowstricnameuniv
$forcestricnameuniv = $server_config["xtense_forcestricnameuniv"]== 1 ? "checked" : "";
//
$logunallowedconnattempt = $server_config["xtense_logunallowedconnattempt"]== 1 ? "checked" : "";
//------------------------

$ogsplugin_nameuniv = $server_config["xtense_ogsplugin_nameuniv"];
$ogsplugin_numuniv = $server_config["xtense_ogsplugin_numuniv"];
//xtense_ogshttp_headerver
//$ogshttp_headerver = $server_config["xtense_ogshttp_headerver"]; // variable inutile

//-----------------------------
?>
<script  Language="Javascript">

function GetServerUniverse(server_num) {   
   
   /* var fr_servers = new Array("", "ogame312.de", "ogame290.de", "ogame199.de", "ogame235.de", 
                                  "ogame333.de", "ogame200.de", "ogame316.de", "ogame259.de", 
                                  "ogame124.de", "ogame250.de", "ogame251.de", "ogame190.de",
                                  "81.169.184.163", "ogame317.de", "ogame144.de", "ogame170.de", 
                                  "ogame181.de", "ogame186.de", "ogame193.de", "ogame221.de", 
                                  "ogame208.de", "ogame140.de", "ogame123.de", "ogame286.de", 
                                  "ogame525.de", "ogame240.de", "ogame213.de", "ogame447.de", 
                                  "ogame618.de", "ogame338.de", "ogame311.de", "ogame216.de", 
                                  "ogame388.de", "81.169.184.253", "ogame380.de", "s058.gfsrv.net", 
                                  "81.169.131.155", "ogame391.de", "ogame449.de", "ogame444.de", 
                                  "ogame464.de", "ogame474.de", "ogame496.de", "ogame501.de", 
                                  "ogame544.de", "ogame396.de", "ogame593.de", "ogame??.de"  ); */

   //document.getElementByName('ogspluginuniv').value = fr_servers[server_num];
   document.ogspluginparams.ogsplugin_numuniv.value =server_num;
   document.ogspluginparams.ogsplugin_nameuniv.value= document..univserver_name.value; //fr_servers[server_num];

}

</script>
<?php

//-------------------------------------------

if(isset($_SERVER['PHP_SELF'])){
  $temp_phpself = $_SERVER['PHP_SELF'];
  $script_ogsplugin=str_replace('/index.php','/xtense_plugin.php',$temp_phpself);
}else{
  $script_ogsplugin=str_replace('/index.php','/xtense_plugin.php',$PHP_SELF);
}
//$rep_install=substr(htmlentities($repertoire, ENT_QUOTES), 1); // variable inutile

if(isset($_SERVER['HTTP_HOST'])){
  $hote=$_SERVER['HTTP_HOST'];
}else{
  $hote=$HTTP_HOST;
}
//-----------

//------------------------------------------------------------------------------

?>

<div align="center">
<br><br>

<table width="75%">
<form name='ogspluginparams' method="POST" action="index.php?action=xtense">
<input type="hidden" name="subaction" value="set_xtense_plugin_config">

<tr>
	<td class="c" colspan="2">Debug/Maintenance </td>
</tr>
<tr>
	<th width="60%">Activer le mode debug:</th>  <!-- xtense_debug -->
        <th><input name="debug" type="checkbox" value="1" <?php echo $debug;?>></th>
</tr>

<tr>
	<th width="60%">Mise en mode maintenance du plugin:</th>  <!-- xtense_maintenance -->
        <th><input name="maintenance" type="checkbox" value="1" <?php echo $maintenance;?>></th>
</tr>
<tr>
	<?php if ($user_data["user_admin"] == 1  || $user_data["user_coadmin"] == 1)
              echo "\t\t"."<th colspan=\"2\"><input type=\"submit\" value=\"Valider\">&nbsp;<input type=\"reset\" value=\"Réinitialiser\"></th>";
        ?>
</tr>
</table>
<br><br>

<table width="75%">
<tr>
	<td class="c" colspan="2">Option de journalisation du plugin </td>
</tr>
<tr>
	<th width="60%">Connexion du plugin:</th>  <!-- xtense_logogslogon -->
        <th><input name="logogslogon" type="checkbox" value="1" <?php echo $logogslogon;?>></th>
</tr>

<tr>
	<th width="60%">Mise à jour des rapports d'espionnage:</th>  <!-- xtense_logogsspyadd -->
        <th><input name="logogsspyadd" type="checkbox" value="1" <?php echo $logogsspyadd;?>></th>
</tr>

<tr>
	<th width="60%">Mise à jour des galaxies:</th>  <!--xtense_logogsgalview -->
        <th><input name="logogsgalview" type="checkbox" value="1" <?php echo $logogsgalview;?>></th>
</tr>
<tr>
	<th width="60%">Mise à jour des classements joueurs:</th>  <!-- xtense_logogsplayerstats   -->
        <th><input name="logogsplayerstats" type="checkbox" value="1" <?php echo $logogsplayerstats;?>></th>
</tr>
<tr>
	<th width="60%">Mise à jour des classements alliances:</th> <!-- xtense_logogsallystats  -->
        <th><input name="logogsallystats" type="checkbox" value="1" <?php echo $logogsallystats;?>></th>
</tr>

<tr>
	<th width="60%">Mise à jour des classements alliance interne:</th>  <!-- xtense_logogsallyhistory -->
        <th><input name="logogsallyhistory" type="checkbox" value="1" <?php echo $logogsallyhistory;?>></th>
</tr>

<tr>
	<th width="60%">Mise à jour de la page bâtiments</th>  <!-- xtense_logogsuserbuildings -->
        <th><input name="logogsuserbuildings" type="checkbox" value="1" <?php echo $logogsuserbuildings;?>></th>
</tr>

<tr>
	<th width="60%">Mise à jour de la page technologie:</th>  <!-- xtense_logogsusertechnos -->
        <th><input name="logogsusertechnos" type="checkbox" value="1" <?php echo $logogsusertechnos;?>></th>
</tr>

<tr>
	<th width="60%">Mise à jour de la page défense:</th>  <!-- xtense_logogsuserdefence -->
        <th><input name="logogsuserdefence" type="checkbox" value="1" <?php echo $logogsuserdefence;?>></th>
</tr>



<tr>
	<th width="60%">Mise à jour de la page empire (planètes):</th>  <!-- xtense_logogsuserdefence -->
        <th><input name="logogsuserplanetempire" type="checkbox" value="1" <?php echo $logogsuserplanetempire;?>></th>
</tr>

<tr>
	<th width="60%">Mise à jour de la page empire (lunes):</th>  <!-- xtense_logogsuserplanetmoon -->
        <th><input name="logogsusermoonempire" type="checkbox" value="1" <?php echo $logogsusermoonempire;?>></th>
</tr>
<tr>
	<?php if ($user_data["user_admin"] == 1  || $user_data["user_coadmin"] == 1)
              echo "\t\t"."<th colspan=\"2\"><input type=\"submit\" value=\"Valider\">&nbsp;<input type=\"reset\" value=\"Réinitialiser\"></th>";
        ?>
</tr>

</table>
<br><br>

<table width="75%">
<tr>
	<td class="c" colspan="2">Traitement des Pages - Données Communes</td>
</tr>

<tr>
	<th width="60%">Traitement des vues galaxies:</th>  <!-- xtense_logunallowconnattempt -->
        <th><input name="handlegalaxyviews" type="checkbox" value="1" <?php echo $handlegalaxyviews;?>></th>
</tr>


<tr>
	<th width="60%">Traitement des classements joueurs:</th>  <!-- xtense_allowstricnameuniv -->
        <th><input name="handleplayerstats" type="checkbox" value="1" <?php echo $handleplayerstats;?>></th>
</tr>

<tr>
	<th width="60%">Traitement des classements alliances:</th>  <!-- xtense_allowstricnameuniv -->
        <th><input name="handleallystats" type="checkbox" value="1" <?php echo $handleallystats;?>></th>
</tr>

<tr>
	<th width="60%">Traitement des rapports d'espionnage:</th>  <!-- xtense_allowstricnameuniv -->
        <th><input name="handleespioreports" type="checkbox" value="1" <?php echo $handleespioreports;?>></th>
</tr>


<tr>
	<?php if ($user_data["user_admin"] == 1  || $user_data["user_coadmin"] == 1)
              echo "\t\t"."<th colspan=\"2\"><input type=\"submit\" value=\"Valider\">&nbsp;<input type=\"reset\" value=\"Réinitialiser\"></th>";
        ?>
</tr>


</table>

<br><br>


<table width="75%">
<tr>
	<td class="c" colspan="2">Divers</td>
</tr>

<tr>
	<th width="60%">Tentative de connexion non autorisée/inconnue:</th>  <!-- xtense_logunallowconnattempt -->
        <th><input name="logunallowedconnattempt" type="checkbox" value="1" <?php echo $logunallowedconnattempt;?>></th>
</tr>


<tr>
	<th width="60%">Bloquer les requêtes provenant d'un serveur OGame® non désigné (<?php echo $ogsplugin_nameuniv;?>):</th>  <!-- xtense_allowstricnameuniv -->
        <th><input name="forcestricnameuniv" type="checkbox" value="1" <?php echo $forcestricnameuniv;?>></th>
</tr>

<tr>
	<th width="60%">Échecs de requête base de données:</th>  <!-- xtense_logogssqlfailure -->
        <th><input name="logogssqlfailure" type="checkbox" value="1" <?php echo $logogssqlfailure;?>></th>
</tr>
<tr>
	<th width="60%">Serveur d'univers OGame® associé au serveur OGSpy (www.ogame.fr): </th>  <!-- xtense_ogsplugin_nameuniv -->
	<th><select name="univserver_name" onChange="document.ogspluginparams.ogsplugin_nameuniv.value=this.value;document.ogspluginparams.ogsplugin_numuniv.value=this.selectedIndex;">
  <!-- onChange="GetServerUniverse(this.selectedIndex);" > -->
			<option>Univers ?</option>
         <?php
              //for ($cpt=1; $cpt<=$num_fr_servers; $cpt++ ) {
	      //echo "\t\t\t\t"."<option value='".$cpt."' ".($ogsplugin_numuniv==$cpt? "SELECTED":"").">Univers ".$cpt."</option>";
       // }          
       
          
          // Récupérer la liste des dernières versions dans le fichier XML
          $file = "mod/Xtense/ogp_unilist_fr.xml";
          // lecture du fichier des univers
          $xml_mods = readUniXML($file);
          $getxml_error = false;
          if ($xml_mods == false)
          {
          	  echo "\t\t\t\t"."<option value='".$mod_rank."' SELECTED>Erreur lecture fichier(".count($xml_mods).")</option>";
              $getxml_error = true;
          } else // naq_ogsplugincl.php
          {
                $mod_rank=0;
                while ($mod_rank<count($xml_mods)) {              

                         // $module_infos['label'] = $xml_mods[$mod_rank]->label;
                         // $module_infos['univserver'] = $xml_mods[$mod_rank]->univserver;
                         echo "\t\t\t\t"."<option value='".($xml_mods[$mod_rank]->univserver)."' ".($ogsplugin_numuniv==($mod_rank+1)? "SELECTED":"").">Univers ".($mod_rank+1)."</option>";
                      
                      $mod_rank ++;
                }
          }
    
       
          //***********************************************
         ?>
		</select>  
                <input type="hidden" name="ogsplugin_numuniv" value="<?php echo $ogsplugin_numuniv;?>">
                <input type="text" name="ogsplugin_nameuniv" size="15" value="<?php echo $ogsplugin_nameuniv;?>" ></th>
</tr>



<tr>
	<?php if ($user_data["user_admin"] == 1  || $user_data["user_coadmin"] == 1)
              echo "\t\t"."<th colspan=\"2\"><input type=\"submit\" value=\"Valider\">&nbsp;<input type=\"reset\" value=\"Réinitialiser\"></th>";
        ?>
</tr>


</table>

<br><br>

<table width="75%">
<tr>
	<td class="c" colspan="2">Infos de configuration Utilisateur</td>
</tr>
<tr>
	<th width="60%">Serveur d'Univers Ogame</th>
	<th><input type="text" name="galviewslog" size="60" value="<?php echo $ogsplugin_nameuniv;?>" readonly="true"></th>
</tr>
<tr>
	<th width="60%">URL du plugin</th>
	<th><input type="text" name="ogsurlplugin" size="60" value="<?php echo "http://".$hote.$script_ogsplugin;?>" readonly="true"></th>
</tr>

</table>

<br><br>
</div>

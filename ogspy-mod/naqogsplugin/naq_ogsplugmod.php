<?php
/***************************************************************************
*	filename	: naq_ogsplugmod.php
*	desc.		:
*	Author		: Naqdazar - lexa.gg@free.fr
*	created		: 01/08/2006
*	modified	: 01/08/2006
***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $help;
$help["naq_ogsplug_univ"] = "Nom du serveur de l'univers associé au serveur OGSPY courant.<br><i>Ex pour l'univers 12: ogame190.de</i>";

require_once("views/page_header.php");
if ($user_data["user_admin"] == 0  && $user_data["user_coadmin"] == 0)
{
  redirection("index.php?action=message&id_message=forbidden&info");
}
if (isset($pub_subaction) && $pub_subaction=="set_ogspluginconfig") { // enregistrements paramètres
   set_ogspluginconfig();
}

init_serverconfig();
// //naq_logogsplayerstats - naq_logogsallystats -  naq_logogsallyhistory - naq_logogssqlfailure

// ftp://ftpperso.free.fr/Ogame/OGSpy/mod/naq_ogsplugin
require_once("mod/naq_ogsplugin/naq_ogsplugincl.php");

$logogslogon_on = $logogslogon_off = "";
if ($server_config["naq_logogslogon"]=='1') $logogslogon_on = "checked";
else $logogslogon_off = "checked";

$logogsspyadd_on = $logogsspyadd_off = "";
if ($server_config["naq_logogsspyadd"]=='1') $logogsspyadd_on = "checked";
else $logogsspyadd_off = "checked";

//--------

$logogsgalview_on = $logogsgalview_off = "";
if ($server_config["naq_logogsgalview"]=='1') $logogsgalview_on = "checked";
else $logogsgalview_off = "checked";

$logogsplayerstats_on = $logogsplayerstats_off = "";
if ($server_config["naq_logogsplayerstats"]=='1') $logogsplayerstats_on = "checked";
else $logogsplayerstats_off = "checked";

$logogsallystats_on = $logogsallystats_off = "";
if ($server_config["naq_logogsallystats"]=='1') $logogsallystats_on = "checked";
else $logogsallystats_off = "checked";

$logogsallyhistory_on = $logogsallyhistory_off = "";
if ($server_config["naq_logogsallyhistory"]=='1') $logogsallyhistory_on = "checked";
else $logogsallyhistory_off = "checked";

$logogssqlfailure_on = $logogssqlfailure_off = "";
if ($server_config["naq_logogssqlfailure"]=='1') $logogssqlfailure_on = "checked";
else $logogssqlfailure_off = "checked";

//------------------------

if ($ogsplugin_nameuniv = $server_config["naq_ogsplugin_nameuniv"]);
if ($ogsplugin_numuniv = $server_config["naq_ogsplugin_numuniv"]);

                               //ogspluginuniv
//-----------------------------
?>
<script  Language="Javascript">
function GetServerUniverse(server_num) {
   //alert('lklklkl');
   var fr_servers = new Array("", "uni1.ogame.fr", "uni2.ogame.fr", "uni3.ogame.fr", "uni4.ogame.fr", 
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
                                  "uni54.ogame.fr", "uni55.ogame.fr", "uni56.ogame.fr", "uni57.ogame.fr",
								  "uni58.ogame.fr", "uni59.ogame.fr",  );

   //document.getElementByName('ogspluginuniv').value = fr_servers[server_num];
   document.ogspluginparams.ogsplugin_numuniv.value =server_num;
   document.ogspluginparams.ogsplugin_nameuniv.value= fr_servers[server_num];

}

</script>
<?php

//-------------------------------------------

if(isset($_SERVER['PHP_SELF'])){
  $script_ogsplugin=str_replace('/index.php','/ogsplugin.php',$_SERVER['PHP_SELF']);
}else{
  $script_ogsplugin=str_replace('/index.php','/ogsplugin.php',$PHP_SELF);
}
$rep_install=substr(htmlentities($repertoire, ENT_QUOTES), 1);

if(isset($_SERVER['HTTP_HOST'])){
  $hote=$_SERVER['HTTP_HOST'];
}else{
  $hote=$HTTP_HOST;
}
//-----------

	// Récupérer la liste des dernières versions dans le fichier XML
	$file = OGSPLUGXML_FILE;
	
	$xml_mods = readXML($file);
	$getxml_error = false;
	if ($xml_mods == false)
	{
		$getxml_error = true;
	}  // naq_ogsplugincl.php
	
        $prevver_exists = count($xml_mods)>0;
        if ($prevver_exists) {
           $prevver_modname = $xml_mods[0]->name;
	   $prevver_modversion = $xml_mods[0]->version;
        }

	if ($prevver_exists==false || (strcasecmp(NAQ_MODULE_VERSION,$prevver_modversion)>=0)) $prevver_message="( Aucune mise à jour détectée )";
	else $prevver_message="( <blink>Une nouvelle version <b>".$prevver_modversion."</b> a été trouvée</blink> : <a href=\"".$xml_mods[0]->link."\">Télécharger )"
?>
<table width="100%">
<form name='ogspluginparams' method="POST" action="index.php?action=naq_ogsplugin">
<input type="hidden" name="subaction" value="set_ogspluginconfig">



<tr>
	<td class="c" colspan="2">Option de journalisation du plugin <?php echo $prevver_message; ?></td>
</tr>
<tr>
	<th width="60%">Connection du plugin:</th>  <!-- naq_logogslogon -->
	<th>Oui<input name="logogslogon" value="1" type="radio" <?php echo $logogslogon_on;?>>&nbsp;Non<input name="logogslogon" value="0" type="radio" <?php echo $logogslogon_off;?>></th>
</tr>

<tr>
	<th width="60%">Mises à jour de rapports d'espionnage:</th>  <!-- naq_logogsspyadd -->
	<th>Oui<input name="logogsspyadd" value="1" type="radio" <?php echo $logogsspyadd_on;?>>&nbsp;Non<input name="logogsspyadd" value="0" type="radio" <?php echo $logogsspyadd_off;?>></th>
</tr>

<tr>
	<th width="60%">Mises à jour de galaxie:</th>  <!-- naq_logogsgalview -->
	<th>Oui<input name="logogsgalview" value="1" type="radio" <?php echo $logogsgalview_on;?>>&nbsp;Non<input name="logogsgalview" value="0" type="radio" <?php echo $logogsgalview_off;?>></th>
</tr>
<tr>
	<th width="60%">Mises à jour classements joueurs:</th>  <!-- naq_logogsplayerstats   -->
	<th>Oui<input name="logogsplayerstats" value="1" type="radio" <?php echo $logogsplayerstats_on;?>>&nbsp;Non<input name="logogsplayerstats" value="0" type="radio" <?php echo $logogsplayerstats_off;?>></th>
</tr>
<tr>
	<th width="60%">Mises à jour classements alliances:</th> <!-- naq_logogsallystats  -->
	<th>Oui<input name="logogsallystats" value="1" type="radio" <?php echo $logogsallystats_on;?>>&nbsp;Non<input name="logogsallystats" value="0" type="radio" <?php echo $logogsallystats_off;?>></th>
</tr>

<tr>
	<th width="60%">Mises à jour classements alliance interne:</th>  <!-- naq_logogsallyhistory -->
	<th>Oui<input name="logogsallyhistory" value="1" type="radio" <?php echo $logogsallyhistory_on;?>>&nbsp;Non<input name="logogsallyhistory" value="0" type="radio" <?php echo $logogsallyhistory_off;?>></th>
</tr>

<tr>
	<th width="60%">Échecs de requète base de données:</th>  <!-- naq_logogssqlfailure -->
	<th>Oui<input name="logogssqlfailure" value="1" type="radio" <?php echo $logogssqlfailure_on;?>>&nbsp;Non<input name="logogssqlfailure" value="0" type="radio" <?php echo $logogssqlfailure_off;?>></th>
</tr>
<tr>
	<th width="60%">Serveur d'univers ogame associé au serveur OGSPY: </th>  <!-- naq_ogsplugin_nameuniv -->
	<th><select name="group_id" onChange="GetServerUniverse(this.selectedIndex);" >
			<option>Choix univers</option>
         <?php
              for ($cpt=1; $cpt<=41; $cpt++ ) {
	      echo "\t\t\t\t"."<option value='".$cpt."' ".($ogsplugin_numuniv==$cpt? "SELECTED":"").">Univers ".$cpt."</option>";
        }
         ?>
		</select>  
                <input type="hidden" name="ogsplugin_numuniv" value="">
                <input type="text" name="ogsplugin_nameuniv" size="20" value="<?php echo $ogsplugin_nameuniv;?>" ></th>
</tr>

<tr>
	<?php if ($user_data["user_admin"] == 1  || $user_data["user_coadmin"] == 1)
              echo "\t\t"."<th colspan=\"2\"><input type=\"submit\" value=\"Valider\">&nbsp;<input type=\"reset\" value=\"Réinitialiser\"></th>";
        ?>
</tr>

</form>
</table>
<br><br>
<table width="600">
<tr>
	<td class="c" colspan="2">Infos de configuration Utilisateur</td>
</tr>
<tr>
	<th width="60%">Serveur d'Univers Ogame



        <?php help("naq_ogsplug_nameuniv"); ?></th>
	<th><input type="text" name="galviewslog" size="60" value="<?php echo $ogsplugin_nameuniv;?>" readonly="true"></th>
</tr>
<tr>
	<th width="60%">URL plugin</th>
	<th><input type="text" name="ogsurlplugin" size="60" value="<?php echo "http://".$hote.$script_ogsplugin;?>" readonly="true"></th>
</tr>


<tr>
	<td>&nbsp;</td>
</tr>
</table>
</table>

<?php

echo "\t"."<br>\n";
   echo "\t"."<div align=center><font size=2>MOD OGS Plugin v".NAQ_MODULE_VERSION." développé par <a href=mailto:lexa.gg@free.fr>Naqdazar</a> (P) 2006</font></div>\n";
   echo "\t"."</td>\n";

require_once("views/page_tail.php");

function set_ogspluginconfig() {
        global $db, $pub_logogsgalview, $pub_logogsplayerstats, $pub_logogsallystats, $pub_logogsallyhistory,
        $pub_logogsallyhistory, $pub_logogssqlfailure, $pub_logogsspyadd, $pub_logogslogon, 
        $pub_ogsplugin_numuniv, $pub_ogsplugin_nameuniv;
	
        
        //
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogslogon."' where config_name = 'naq_logogslogon'";
	$db->sql_query($request);

        //
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsspyadd."' where config_name = 'naq_logogsspyadd'";
	$db->sql_query($request);

        //
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsgalview."' where config_name = 'naq_logogsgalview'";
	$db->sql_query($request);

        //
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsplayerstats."' where config_name = 'naq_logogsplayerstats'";
	$db->sql_query($request);  //naq_logogsplayerstats - naq_logogsallystats -  naq_logogsallyhistory - naq_logogssqlfailure
        
        	//
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsallystats."' where config_name = 'naq_logogsallystats'";
	$db->sql_query($request);
        
        	//
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsallyhistory."' where config_name = 'naq_logogsallyhistory'";
	$db->sql_query($request);

        	//
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogssqlfailure."' where config_name = 'naq_logogssqlfailure'";
	$db->sql_query($request);
	
	//
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_ogsplugin_numuniv."' where config_name = 'naq_ogsplugin_numuniv'";
	$db->sql_query($request);


        //
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_ogsplugin_nameuniv."' where config_name = 'naq_ogsplugin_nameuniv'";
	$db->sql_query($request);

        redirection("index.php?action=naq_ogsplugin");
}

 ?>
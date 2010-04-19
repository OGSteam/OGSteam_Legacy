<?php
/**
* xtense_plugin_mod.php
* @package Xtense
*  @author Naqdazar, then modified by OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

if (!defined('IN_SPACSPY')) die("Hacking attempt");

//Définitions
global $db, $subaction;
require_once("views/page_header.php");
require_once("mod/Xtense/functions.php");

//Si l'utilisateurs n'est pas admin ou coadmin, on affiche les infos de config de la toolbar
if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
	//Appel des infos de config de la toolbar
	$ogsplugin_nameuniv = $server_config["xtense_ogsplugin_nameuniv"];
	if(isset($_SERVER['HTTP_HOST'])){
  		$hote=$_SERVER['HTTP_HOST'];
	}else{
  		$hote=$HTTP_HOST;
	}
	if(isset($_SERVER['PHP_SELF'])){
  		$temp_phpself = $_SERVER['PHP_SELF'];
  		$script_ogsplugin=str_replace('/index.php','/xtense_plugin.php',$temp_phpself);
	}else{
  		$script_ogsplugin=str_replace('/index.php','/xtense_plugin.php',$PHP_SELF);
	}
?>
<table width="75%">
<tr>
	<td class="c" colspan="2">Infos de configuration Utilisateur</td>
</tr>
<tr>
	<th width="60%">Serveur d'Univers Ogame</th>
	<th><input type="text" name="galviewslog" size="60" value="<?php echo $ogsplugin_nameuniv;?>" readonly="true"></th>
</tr>
<tr>
	<th width="60%">URL plugin</th>
	<th><input type="text" name="ogsurlplugin" size="60" value="<?php echo "http://".$hote.$script_ogsplugin;?>" readonly="true"></th>
</tr>

</table>
<?php
}

//$num_fr_servers = 48;
else {
//Enregistrement de la config
if (isset($pub_subaction) && $pub_subaction=="set_xtense_plugin_config") {
   set_xtense_plugin_config();
}

// Affichage interface du module
?>
<table width="100%">
<tr>
	<td>
		<table border="1">
		<tr align="center">
		<div align='center'>
<?php
if (!isset($pub_page)) {
	$pub_page = "mainpanel";
}

if ($pub_page != "mainpanel") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=xtense&page=mainpanel';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Configuration</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Configuration</a>";
		echo "</th>"."\n";
}

if ($pub_page != "journal") {
  	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=xtense&page=journal';\">";
  	echo "<a style='cursor:pointer'><font color='lime'>Journal (debug)</font></a>";
  	echo "</td>"."\n";
}
else {
  	echo "\t\t\t"."<th width='150'>";
  	echo "<a>Journal (debug)</a>";
  	echo "</th>"."\n";
}

if ($pub_page != "changelog") {
  	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=xtense&page=changelog';\">";
  	echo "<a style='cursor:pointer'><font color='lime'>Changelog</font></a>";
  	echo "</td>"."\n";
}
else {
  	echo "\t\t\t"."<th width='150'>";
  	echo "<a>changelog</a>";
  	echo "</th>"."\n";
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
switch ($pub_page) {
	case "mainpanel" :
	require_once("config.php");
	break;
	
	case "journal" :
	require_once("journal.php");
	break;

	case "changelog" :
	require_once("changelog.php");
	break;

}
?>
	</td>
</tr>
</table>

<?php
}
echo"<hr width='300px'>";
echo "\t"."<div align=center><font size=2>".XTENSE_MODULE_NAME." version ".XTENSE_MODULE_VERSION." développé par <a href='http://www.ogsteam.fr'>l'OGSTeam</a> © 2007</font></div>\n";

require_once("views/page_tail.php");


 ?>

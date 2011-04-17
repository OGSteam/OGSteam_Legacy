<?php
/** $Id$ **/
/**
* down.php Télécharge de nouveaux mods sur le serveur
* @package [MOD] AutoUpdate
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 1.0
* created	: 27/10/2006
* modified	: 18/01/2007
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");
/**
*
*/
require_once("views/page_header.php");

if($user_data['user_admin'] == 1 OR (COADMIN == 1 AND $user_data['user_coadmin'] == 1)) {
	/**
	*Récupère les version du SVN
	*/
	require_once("mod/autoupdate/modUpdIncl.php");
	
	
	// Récupérer la liste des modules installés
	$sql = "SELECT title,root,version from ".TABLE_MOD;
	$res = $db->sql_query($sql,false,true);
	
	$a = 0;
	while (list($modname,$modroot,$modversion) = $db->sql_fetch_row($res)) {
		$installed_mods[$a]['name'] = $modname;	
		$installed_mods[$a]['root'] = $modroot;
		$installed_mods[$a++]['version'] = $modversion;
	}
	
	// Récupérer la liste des dernières versions dans le fichier XML
	$file = XML_FILE;
	
	$xml_mods = readXML($file);
	$getxml_error = false;
	if ($xml_mods == false) {
		$getxml_error = true;
	}
	?>
<table width='600'>
<?php
	if (!is__writable("./mod/")) {
	echo "<tr><td class='c' colspan='100'><font color='red'>Attention le mod autoupdate n'a pas accès en écriture au repertoire '<b>mod</b>'.<br /> Les installations de nouveaux modules ne sont pas possible.<br>Donnez les droits 777 au répertoire <b>'[OGSPY]/mod'</b></font></td></tr>";
	}
	if ($getxml_error == true) {
?>
	<tr>
		<td class='c' colspan='100'><font color="lime"><?php echo $lang['autoupdate_tableau_error']." ".XML_FILE; ?><br />
			<?php echo $lang['autoupdate_tableau_error1']; ?></font>
		</td>
	</tr>
<?php
	}
?>
	<tr>
		<td class='c' colspan='4'><?php echo $lang['autoupdate_tableau_modnoinstall']; ?></td>
	</tr>
	<tr>
		<td class='c'><?php echo $lang['autoupdate_tableau_namemod']; ?></td>
		<td class='c'><?php echo $lang['autoupdate_tableau_description']; ?></td>
		<td class='c' width="150"><?php echo $lang['autoupdate_tableau_versionSVN']; ?></td>
		<?php if($user_data['user_admin'] == 1 OR (COADMIN == 1 AND $user_data['user_coadmin'] == 1)) echo '<td class=\'c\' width = "100">'.$lang['autoupdate_tableau_action'].'</td>'; ?>
	</tr>
	<?php	
	//
	for ($i = 0 ; $i < count($xml_mods) ; $i++) {
		
		$cur_modname = $xml_mods[$i]->name;
		$cur_description = $xml_mods[$i]->description;
		$cur_version = $xml_mods[$i]->version;
		
		$install = false;
		for ($j = 0 ; $j < $a ; $j++) {
			if ($installed_mods[$j]['root'] == $cur_modname) {
				$install = true;
			}
		}
		if ($install == false) {
			$link = "<a href=\"?action=autoupdate&sub=maj&type=down&mod=".$cur_modname."&tag=".$cur_version."\">Télécharger</a>";
			echo "\t<tr>\n";
			echo "\t\t<th>".$cur_modname."</th>\n";
			echo "\t\t<th>".$cur_description."</th>\n";
			echo "\t\t<th>".$cur_version."</th>\n";
			echo "\t\t<th><font color='lime'>".$link."</font></th>\n";
			echo "\t</tr>\n";
		}
	}
	?>
	<tr>
		<td class="c" colspan="100"><?php echo $lang['autoupdate_tableau_link']; ?></td>
	</tr>
	<tr>
		<th colspan="100"><a href="index.php?action=administration&subaction=mod"><?php echo $lang['autoupdate_tableau_pageadmin']; ?></a></th>
	</tr>
	<tr>
		<th colspan="100"><a href="http://ogsteam.fr">OGSteam.fr</a></th>
	</tr>
</table><?php
} else die($lang['autoupdate_MaJ_rights']);

echo '<br />'."\n";
echo 'AutoUpdate '.$lang['autoupdate_version'].' '.versionmod();
echo '<br />'."\n";
echo $lang['autoupdate_createdby'].' Jibus '.$lang['autoupdate_and'].' Bartheleway.</div>';

require_once("views/page_tail.php");
?>

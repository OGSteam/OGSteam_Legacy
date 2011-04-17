<?php
/**
 *	modUpdate.php Page d'accès au module modUpdate
 *	@package modUpdate
 *	@author Jibus 
 * 	@version 0.3
 */

	
	if (!defined('IN_SPYOGAME')) die("Hacking attempt");

	require_once("./mod/modUpdate/modUpdIncl.php");		
	
	global $db;

	$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='".MODULE_ACTION."' AND `active`='1' LIMIT 1";
	if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

	require_once("views/page_header.php");
	
	// Récupérer la liste des modules installés
	$sql = "SELECT title,root,link,version from ".TABLE_MOD;
	$res = $db->sql_query($sql,false,true);

	$i=0;
	while (list($modname,$modroot,$modlink,$modversion) = $db->sql_fetch_row($res))
	{
		$installed_mods[$i]['name'] 		= $modname;	
		$installed_mods[$i]['root']		= $modroot;
		$installed_mods[$i]['link']		= $modlink;
		$installed_mods[$i++]['version'] 	= $modversion;
	}
	
	// Récupérer la liste des dernières versions dans le fichier XML
	$file = XML_FILE;
	
	$xml_mods = readXML($file);
	$getxml_error = false;
	if ($xml_mods == false)
	{
		$getxml_error = true;
	}
?>
	<table width='700'>
<?php
	if ($getxml_error == true)
	{
	
?>
		<tr>
			<td class='c' colspan='100'><font color="lime">Erreur lors de l'accès au fichier <? echo XML_FILE; ?>
			<BR>Récupération des informations de version impossible !</font></td>
		</tr>
		
<?php		
	}

?>
		<tr>
			<td class='c' colspan='100'>Modules installés - Recherche des mises à jour sur SVN OGSteam</td>
		</tr>
		<tr>
			<td class='c'>Nom du module</td>
			<td class='c' width = "150">Version installée</td>
			<td class='c' width = "150">Dernière version sur SVN</td>
			<td class='c' width = "100">Téléchargement</td>
		</tr>
<?php	
	
	// 
	for ($i=0 ; $i<count($installed_mods) ; $i++)
	{
		// on n'affiche pas les groupes du mod "MODGestion_MOD"
		if ( $installed_mods[$i]['link'] != 'group' && $installed_mods[$i]['version'] !== 0 ) {
			echo "\t\t<tr>\n";
			echo "\t\t\t<th>".$installed_mods[$i]['name']."</th>\n";
			echo "\t\t\t<th>".$installed_mods[$i]['version']."</th>\n";
			$found=0;
			for ($j=0; $j<count($xml_mods);$j++)
			{
				$cur_modname = $xml_mods[$j]->name;
				$cur_version = $xml_mods[$j]->version;

				if ($installed_mods[$i]['root'] == $cur_modname)
				{
					$found=1;

					echo "\t\t\t<th>".$cur_version."</th>\n";

					//if (version_compare($installed_mods[$i]['version'],$cur_version,"<"))
					if (mustUpdate($installed_mods[$i]['version'],$cur_version))
					{
						// $ziplink = "<a href='http://www.ogsteam.fr/downloadmod.php?mod=".$cur_modname."&tag=".$cur_version."'>Télécharger</a>";
						$ziplink = "<a href='".$xml_mods[$j]->link."'>Télécharger</a>";
						echo "\t\t\t<th><font color='lime'>".$ziplink."</font></th>\n";
					}
					else
					{
						echo "\t\t\t<th>&nbsp;</th>\n";
					}
				}
			}
			if ($found==0)
			{
					echo "\t\t\t<th>Non référencé</th>\n";
					echo "\t\t\t<th>&nbsp;</th>\n";


			}
			echo "\t\t</tr>\n";
		}
	}

 	if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) 
	{
		// Proposer le lien vers le panneau d'administration des modules

?>
		<tr>
			<td class="c" colspan="100">Liens</td>
		</tr>
		<tr>
			<th colspan="100"><a href="index.php?action=administration&subaction=mod">Page d'administration des modules OGSpy</a></th>
		</tr>
		<tr>
		<th colspan="100"><a href="http://www.ogsteam.fr">OGSteam.fr</a></th>
		</tr>


<?php
	}
?>
	</table>

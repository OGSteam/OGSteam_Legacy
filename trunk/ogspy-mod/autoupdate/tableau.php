<?php
/** $Id$ **/
/**
* autoupdate.php Met � jour les mods depuis le serveur
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
	if (DOWNJSON == 1) {
		if (!empty($pub_down) AND $pub_down == 'yes') {
			$affiche = copymodupdate("yes");
		} elseif (CYCLE == 0) {
			$affiche = copymodupdate("no");
		} elseif (CYCLE == 1) {
			if(MULTI == 1) {
				if(BEGIND != date("d")) {
					$begind = date("d");
					$multi = 0;
				} else {
					$begind = BEGIND;
					$multi = 1;
				}
/*die ("--".COADMIN."--".DOWNJSON."--".CYCLE."--".$begind."--".BEGINH."--".$multi."--");*/
				generate_parameters(COADMIN, DOWNJSON, CYCLE, $begind, BEGINH, $multi, AUTO_MAJ);
				$affiche = "<br />\n".$lang['autoupdate_tableau_error3']." : <a href='index.php?action=autoupdate&sub=tableau&down=yes'>".$lang['autoupdate_tableau_ok1']."</a>";
			} else {
				$affiche = copymodupdate("yes");
				generate_parameters(COADMIN, DOWNJSON, CYCLE, date("d"), BEGINH, 1, AUTO_MAJ);
			}
		} elseif (CYCLE > 1) {
			if(MULTI == CYCLE) {
				if(BEGIND != date("d")) {
					$begind = date("d");
					$multi = 0;
				} else {
					$begind = BEGIND;
					$multi = MULTI;
				}
				generate_parameters(COADMIN, DOWNJSON, CYCLE, $begind, BEGINH, $multi, AUTO_MAJ);
				$affiche = "<br />\n".$lang['autoupdate_tableau_error3']." : <a href='index.php?action=autoupdate&sub=tableau&down=yes'>".$lang['autoupdate_tableau_ok1']."</a>";
			} else {
				$cycle1 = CYCLE - 1;
				if(BEGIND != date("d")) {
					$begind = date("d");
					$multi = 1;
					$beginh = date("H");
					$affiche = copymodupdate("yes");
					generate_parameters(COADMIN, DOWNJSON, CYCLE, $begind, $beginh, $multi, AUTO_MAJ);
				} else {
					$begind = BEGIND;
					$calcul = (date("H") - BEGINH);
					if($calcul >= $cycle1) {
						$multi = MULTI + 1;
						$beginh = date("H");
						$affiche = copymodupdate("yes");
						generate_parameters(COADMIN, DOWNJSON, CYCLE, $begind, $beginh, $multi, AUTO_MAJ);
					} else {
						$affiche = "<br />\n".$lang['autoupdate_tableau_error3']." : <a href='index.php?action=autoupdate&sub=tableau&down=yes'>".$lang['autoupdate_tableau_ok1']."</a>";
					}
				}
			}
		}
	} else {
		$affiche = "";
	}
} else {
	$affiche = "";
}

if (AUTO_MAJ == 1) {
	$auto = "<a href=\"?action=autoupdate&sub=maj&type=all\"> ".$lang['autoupdate_tableau_autoMaJ']."</a>";
} else {
	$auto = "";
}

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='autoupdate' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

	// R�cup�rer la liste des modules install�s
	$sql = "SELECT title,root,version from ".TABLE_MOD;
	$res = $db->sql_query($sql,false,true);

	$i=0;
	while (list($modname,$modroot,$modversion) = $db->sql_fetch_row($res))
	{
		$installed_mods[$i]['name'] 		= $modname;	
		$installed_mods[$i]['root']		= $modroot;
		$installed_mods[$i++]['version'] 	= $modversion;
	}
	
	// R�cup�rer la liste des derni�res versions dans le fichier JSON
  $getjson_error = false; // R�initialidation Code Erreur
  $contents = file_get_contents(JSON_FILE);
  if($contents === false) $getjson_error=true; //Erreur de lecture
  $results = utf8_encode($contents);
  $data = json_decode($results, true);
  $mod_names = array_keys($data); // R�cup�ration des cl�s
?>
<div align="center"><?php echo $lang['autoupdate_tableau_info']; ?></div>
<br />
<table width='700'>
<?php
	if ($getjson_error == true)
	{
	
?>
	<tr>
		<td class='c' colspan='100'><font color="lime"><?php echo $lang['autoupdate_tableau_error']." ".JSON_FILE; ?><br />
		<?php echo $lang['autoupdate_tableau_error1']; ?></font></td>
	</tr>
		
<?php		
	}

?>
	<tr>
		<td class='c' colspan='100'><?php echo $lang['autoupdate_tableau_modinstall'].$auto.$affiche; ?></td>
	</tr>
	<tr>
		<td class='c'><?php echo $lang['autoupdate_tableau_namemod']; ?></td>
		<td class='c' width = "50"><?php echo $lang['autoupdate_tableau_version']; ?></td>
		<td class='c' width = "50"><?php echo $lang['autoupdate_tableau_versionSVN']; ?></td>
		<?php if($user_data['user_admin'] == 1 OR (COADMIN == 1 AND $user_data['user_coadmin'] == 1)) echo '<td class=\'c\' width = "100">'.$lang['autoupdate_tableau_action'].'</td>'; ?>
		
	</tr>
<?php	
	
	// 
	for ($i=0 ; $i<count($installed_mods) ; $i++) {
		if (substr($installed_mods[$i]['name'], 0, 5) != "Group") {
			echo "\t<tr>\n";
			echo "\t\t<th>".$installed_mods[$i]['name']."</th>\n";
			echo "\t\t<th>".$installed_mods[$i]['version']."</th>\n"; 
			$found=0;
			for ($j=0; $j<count($mod_names);$j++) {
				$cur_modname = $mod_names[$j];
				$cur_version = $data[$mod_names[$j]];
		
				if ($installed_mods[$i]['root'] == $cur_modname) {
					$found=1;
					
					echo "\t\t<th>".$cur_version."</th>\n";
					
					if($user_data['user_admin'] == 1 OR (COADMIN == 1 AND $user_data['user_coadmin'] == 1)) {
						echo "\t\t<th>";
						if (!is__writable("./mod/".$installed_mods[$i]['root']."/")) echo "<a title='Pas de droit en �criture sur:./mod/".$installed_mods[$i]['root']."'><font color=red>(RO)</font></a>";
						else {
							//if (mustUpdate($installed_mods[$i]['version'],$cur_version))
							if (version_compare($installed_mods[$i]['version'],$cur_version,"<"))
							{
								// $ziplink = "<a href='index.php?action=autoupdate&sub=maj&mod=".$cur_modname."&tag=".$cur_version."'>".$lang['autoupdate_tableau_uptodate']."</a>;
								$ziplink = "<a href='index.php?action=autoupdate&sub=maj&mod=".$cur_modname."&tag=".$cur_version."'>".$lang['autoupdate_tableau_uptodate']."</a>";
								echo "<font color='lime'>".$ziplink."</font>";
							} else {
								echo "Aucune";
							}
						}
						echo "</th>\n";
					}

				}
			}
			if ($found==0) {
				echo "\t\t<th>".$lang['autoupdate_tableau_norefered']."</th>\n";
				if($user_data['user_admin'] == 1 OR (COADMIN == 1 AND $user_data['user_coadmin'] == 1)) {
					echo "\t\t<th>&nbsp;</th>\n";
				}
			}
			echo "\t</tr>\n";
		}
	}

 	if ($user_data["user_admin"] == 1 OR $user_data['user_coadmin'] == 1) {
		// Proposer le lien vers le panneau d'administration des modules
		
		?>
	<tr>
		<td class="c" colspan="100"><?php echo $lang['autoupdate_tableau_link']; ?></td>
	</tr>
	<tr>
		<th colspan="100"><a href="index.php?action=administration&subaction=mod"><?php echo $lang['autoupdate_tableau_pageadmin']; ?></a></th>
	</tr>
	<tr>
		<th colspan="100"><a href="http://board.ogsteam.fr">OGSteam.fr</a></th>
	</tr>
		<?php
	}
	?>
</table>
<?php
echo '<br />'."\n";
echo 'AutoUpdate '.$lang['autoupdate_version'].' '.versionmod();
echo '<br />'."\n";
echo $lang['autoupdate_createdby'].' Jibus '.$lang['autoupdate_and'].' Bartheleway.</div>';
require_once("views/page_tail.php");
?>

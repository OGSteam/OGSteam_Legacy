<?php
/** $Id$ **/
/**
* MaJ.php Met à jour les mods depuis le serveur
* @package [MOD] AutoUpdate
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 1.0a
* created	: 27/10/2006
* modified	: 18/01/2007
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");
/**
*Récupère les fonctions zip
*/
require_once("./mod/autoupdate/ziplib.php");
$zip = new ZipLib;
/**
*
*/
require_once("views/page_header.php");

if($user_data['user_admin'] == 1 OR (COADMIN == 1 AND $user_data['user_coadmin'] == 1)) {
	
	if (empty($pub_type)) {
		$modroot = mysql_real_escape_string($pub_mod);
		$version = mysql_real_escape_string($pub_tag);
		$modzip = "http://update.ogsteam.fr/mods/download.php?download=".$modroot."-".$version;
		
		if (!is__writable("./mod/autoupdate/tmp/")) {
			die("Erreur: Le repertoire /mod/autoupdate/tmp/ doit etre accessible en écriture (777) ".__FILE__. "(Ligne: ".__LINE__.")");
		}
		if(@copy($modzip , "./mod/autoupdate/tmp/".$modroot.".zip")) {
			
			if ($tab = $zip->Extract("./mod/autoupdate/tmp/".$modroot.".zip", "./mod/".$modroot."/")) {
				
				echo '<table align="center" style="width : 400px">'."\n";
				echo "\t".'<tr>'."\n";
				echo "\t\t".'<td class="c">'.$lang['autoupdate_MaJ_file'].'</td>'."\n";
				echo "\t\t".'<td class="c">'.$lang['autoupdate_MaJ_condition'].'</td>'."\n";
				echo "\t".'</tr>'."\n";
				
				tableau($tab);
				
				echo '</table>'."\n";
				echo '<br />'."\n";
				unlink("./mod/autoupdate/tmp/".$modroot.".zip");
			}
		}
	} else if (AUTO_MAJ == 1 AND $pub_type == "all") {
		
		
		// Récupérer la liste des modules installés
		$sql = "SELECT title,root,version from ".TABLE_MOD;
		$res = $db->sql_query($sql,false,true);
		
		$i = 0;
		while (list($modname,$modroot,$modversion) = $db->sql_fetch_row($res)) {
			$installed_mods[$i]['name'] 		= $modname;	
			$installed_mods[$i]['root']		= $modroot;
			$installed_mods[$i++]['version'] 	= $modversion;
		}
		
	   // Récupérer la liste des dernières versions dans le fichier JSON
	  $getjson_error = false; // Réinitialidation Code Erreur
	  $contents = file_get_contents(JSON_FILE);
	  if($contents === false) $getjson_error=true; //Erreur de lecture
	  $results = utf8_encode($contents);
	  $data = json_decode($results, true);
	  $mod_names = array_keys($data); // Récupération des clés
		
		if ($getjson_error == true) {
			die ('<font color="lime">'.$lang['autoupdate_tableau_error'].' '.JSON_FILE.'<br />'."\n".$lang['autoupdate_tableau_error1'].'</font>');
		}
		
		$tab = 0;
		$num_mod = 0;
		
		//
		for ($i = 0 ; $i<count($installed_mods) ; $i++) {
			if (substr($installed_mods[$i]['name'], 0, 5) != "Group") {
				$found = 0;
				for ($j = 0; $j < count($mod_names); $j++) {
					$cur_modname = $mod_names[$j];
					$cur_version = $data[$mod_names[$j]];
					
					if ($installed_mods[$i]['root'] == $cur_modname) {
						$found = 1;
						
						if($user_data['user_admin'] == 1 OR (COADMIN == 1 AND $user_data['user_coadmin'] == 1)) {
							//if (version_compare($installed_mods[$i]['version'],$cur_version,"<"))
							if (version_compare($installed_mods[$i]['version'],$cur_version,"<")) {
								$modzip = "http://update.ogsteam.fr/mods/download.php?download=".$cur_modname."-".$cur_version;
								
								if(@copy($modzip , "./mod/autoupdate/tmp/".$cur_modname.".zip")) {
									if ($table = $zip->extract("./mod/autoupdate/tmp/".$cur_modname.".zip", "./mod/".$cur_modname."/")) {
										$tab = $tab + count($table);
										$num_mod++;
									}
									unlink("./mod/autoupdate/tmp/".$cur_modname.".zip");
								}
							}
						}
					}
				}
			}
		}
	} else if ($pub_type == "down") {
		$modroot = mysql_real_escape_string($pub_mod);
		$version = mysql_real_escape_string($pub_tag);
		$modzip = "http://update.ogsteam.fr/mods/download.php?download=".$modroot."-".$version;
		//die($modzip);
		if (!is__writable("./mod/autoupdate/tmp/")) {
			die("Erreur: Le repertoire ./mod/autoupdate/tmp/ doit etre accessible en écriture (777)".__FILE__. "(Ligne: ".__LINE__.")");
		}
		if(@copy($modzip , "./mod/autoupdate/tmp/".$modroot.".zip")) {
			
			if ($tab = $zip->extract("./mod/autoupdate/tmp/".$modroot.".zip", "./mod/".$modroot."/")) {
				
				echo '<table align="center" style="width : 400px">'."\n";
				echo "\t".'<tr>'."\n";
				echo "\t\t".'<td class="c">'.$lang['autoupdate_MaJ_file'].'</td>'."\n";
				echo "\t\t".'<td class="c">'.$lang['autoupdate_MaJ_condition'].'</td>'."\n";
				echo "\t".'</tr>'."\n";
				
				tableau($tab, $pub_type);
				
				echo '</table>'."\n";
				echo '<br />'."\n";
				unlink("./mod/autoupdate/tmp/".$modroot.".zip");
			}
		}
	} else die($lang['autoupdate_MaJ_rights']);
	
	if (!isset($tab)) $tab=0;	
	if (is_array($tab)) {
		$num = count($tab);
	} else {
		$num = $tab;
	}
	
	
	if (!is_null($num)) {
		echo '<table>'."\n";
		echo "\t".'<tr>'."\n";
		echo "\t\t".'<td colspan="2" align="center" class="c">'.$lang['autoupdate_MaJ_statistic'].'</td>'."\n";
		echo "\t".'</tr>'."\n";
		echo "\t".'<tr>'."\n";
		echo "\t\t".'<td class="c">'.$lang['autoupdate_MaJ_number'].'</td>'."\n";
		echo "\t\t".'<th>'.$num.'</th>'."\n";
		echo "\t".'</tr>'."\n";
		if ( isset ( $pub_type ) && $pub_type == "all") {
			echo "\t".'<tr>'."\n";
			echo "\t\t".'<td class="c">'.$lang['autoupdate_MaJ_numbermod'].'</td>'."\n";
			echo "\t\t".'<th>'.$num_mod.'</th>'."\n";
			echo "\t".'</tr>'."\n";
			echo "\t".'<tr>'."\n";
			echo "\t\t".'<td class="c">'.$lang['autoupdate_MaJ_wantupdatemod'].'</td>'."\n";
			echo "\t\t".'<th><a href="index.php?action=autoupdate&sub=tableau&maj=all">'.$lang['autoupdate_MaJ_linkupdate'].'</th>'."\n";
			echo "\t".'</tr>'."\n";
		} else if ( isset ( $pub_type ) && $pub_type == "down") {
			echo "\t".'<tr>'."\n";
			echo "\t\t".'<td class="c">'.$lang['autoupdate_MaJ_wantinstall'].'</td>'."\n";
			echo "\t\t".'<th><a href="index.php?action=administration&subaction=mod">'.$lang['autoupdate_MaJ_linkupdate'].'</th>'."\n";
			echo "\t".'</tr>'."\n";
		} else {
			echo "\t".'<tr>'."\n";
			echo "\t\t".'<td class="c">'.$lang['autoupdate_MaJ_wantupdate'].'</td>'."\n";
			echo "\t\t".'<th><a href="index.php?action=autoupdate&maj=yes&modroot='.$modroot.'">'.$lang['autoupdate_MaJ_linkupdate'].'</a></th>'."\n";
			echo "\t".'</tr>'."\n";
		}
		echo '</table>'."\n";
	} else {
		redirection('?action=autoupdate');
	}
	echo '<br />'."\n";
	echo 'AutoUpdate '.$lang['autoupdate_version'].' '.versionmod();
	echo '<br />'."\n";
	echo $lang['autoupdate_createdby'].' Jibus '.$lang['autoupdate_and'].' Bartheleway.</div>';
	
} else {
	echo $lang['autoupdate_MaJ_rights'];
}

require_once("views/page_tail.php");
?>

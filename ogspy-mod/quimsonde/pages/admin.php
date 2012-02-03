<?php
/**
 * admin.php 

Page de configuration, réservé aux Admins

 * @package QuiMSonde
 * @author Sylar
  * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08
*/
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
global $db,$user_data,$config_list;
	// Affichage du formulaire réservé à l'admin 
	// Ouverture du FiledSet
	echo"<fieldset>\n<legend><b><font color='#80FFFF'>".$lang['qms_menu_admin_long'].help('qms_admin')."</font></b></legend>\n\n";
?>
	<br />
	<table width='100%'>
		<tr>
			<td class='c' colspan='2'>
				<?php echo $lang['qms_admin_titre1']; ?>
			</td>
		</tr>
		<tr>
			<th width='40%'><?php echo $lang['qms_admin_nbspies'].help('qms_nombre total'); ?></th>
			<th><?php echo get_espionnage_count(); ?></th>
		</tr>
		<tr>
			<th width='40%'><?php echo $lang['qms_admin_user_using'].help('qms_membres utilisant'); ?></th>
			<th><?php echo get_user_using(); ?></th>
		</tr>
	</table>
	<br/>
	<form action='index.php<?php echo "?action=$mod_name&page=admin"; ?>' method='post'>
		<table width='100%'>
			<tr>
				<td class='c' colspan='2'>
					<?php echo $lang['qms_admin_titre2']; ?>
				</td>
			</tr>
<?php
	$param = "type='text' size='11' maxlength='10' align='center'";
	foreach($config_list as $config){
		if(($a=$config['name'])!=""){
			$value = get_qms_config($a,$b=0);
			$name = "admin_".$a;
			echo"\t<tr>\n\t\t<th>".$config['titre']." ".help('qms_'.$name)."</th>\n\t\t";
			if($a=="time_start"||$a=="time_end"){ // Type DATE
				echo"<th><input id='$name' name='$name' $param value='".date("d/m/Y",$value)."' /></th>";
			}else
			if($a=="add_home"||$a=="imgmenu"||$a=="banniere"){ // Type YES/NO
				echo"<th><select name='$name'>";
				echo"<option value='1' ".(get_qms_config($a,$b)=="yes"?'selected':'').">".$lang['qms_oui']."</option>";
				echo"<option value='0' ".(get_qms_config($a,$b)!="yes"?'selected':'').">".$lang['qms_non']."</option>";
				echo"</select></th>";
			}else{ // Autre : Type nombre
				echo"<th><input name='$name' id='$name' type='text' value='$value' size='5';' onchange='chk_nb(\"$name\",$value);'/>\n";
				echo"\t</th>\n\t</tr>";
			}
		}else{
			echo"\t<tr>\n\t\t<th colspan='2' style='text-align:left;'><a>".$config['titre']."</th>\n";
		}
	}
?>		
			<tr>
				<th width='40%'><?php echo $lang['qms_admin_nb_jours_max'].help('qms_jours max'); ?></th>
				<th><?php
		$a = 'admin_jours';
		$b = get_qms_config("jours");
		echo"<input name='$a' id='$a' type='text' value='$b' size='6' onchange='chk_nb(\"$a\",$b);'/></th>";
?>
			</tr>
		</table>
		<center><input name='valider_admin' type='submit' value='<?php echo $lang['qms_admin_config_submit']; ?>'/></center>
	</form>
	<br/>
	<form action='index.php<?php echo "?action=$mod_name&page=admin"; ?>' method='post'>
			<table width='100%'>
				<tr>
					<td class='c' colspan='2'>
						<?php echo $lang['qms_admin_titre3']; ?>
					</td>
				</tr>
				<tr>
					<th width='40%'><?php echo $lang['qms_chercher_nouveaux_noms'].help('qms_check_newnames'); ?></th>
					<th><input name='check_newnames' type='submit' value='<?php echo $lang['qms_chercher_nouveaux_noms_submit']; ?>'/></th>
				</tr>
				<tr>
					<th width='40%'><?php echo $lang['qms_check membre_effaces'].help('qms_delete_oldspies'); ?></th>
					<th><input name='delete_oldspies' type='submit' value='<?php echo $lang['qms_check membre_effaces_submit']; ?>'/></th>
				</tr>
				<tr>
					<th width='40%'> <?php echo $lang['qms_restore_xtense2_callback'].help('qms_callbacks'); ?></th>
					<th><input name='add_callbacks' type='submit' value='<?php echo $lang['qms_restore_xtense2_callback_submit']; ?>'/></th>
				</tr>
<?php
	// Si le mode QuiMobserve est installé, on affiche l'option d'importation
	$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='QuiMobserve' AND `active`='1' LIMIT 1";
	if ($db->sql_numrows($db->sql_query($query))){	
		echo"<tr><th width='40%'>".$lang['qms_import_from_quimobserve'].help('qms_impoter')."</th>";
		echo"<th><input name='import_from_qmo' type='submit' value='".$lang['qms_import_from_quimobserve_submit']."'/></th></tr>";
	}
?>
			</table>
	</form>
	<br/>
	<form action='index.php<?php echo "?action=$mod_name&page=admin"; ?>' method='post'>
			<table width='100%'>
				<tr>
					<td class='c' colspan='5'>
						<?php echo $lang['qms_admin_titre4'].help('qms_search'); ?>
					</td>
				</tr>
				<tr>
					<th width='10%'>&nbsp</th>
					<th width='20%'><?php echo $lang['qms_admin_search_nom'].help('qms_search_nom'); ?></th>
					<th width='40%'><?php echo $lang['qms_admin_search_link'].help('qms_search_link'); ?></th>
					<th width='20%'><?php echo $lang['qms_admin_search_type'].help('qms_search_type'); ?></th>
					<th width='10%'><?php echo $lang['qms_admin_search_actif'].help('qms_search_actif'); ?></th>
				</tr>
<?php
if(($a=get_search_list())!=false){
	foreach($a as $s){
?>
				<tr>
					<th width='10%'><?php echo $s['id']; ?></th>
					<th><input type='text' name ='search_name<?php echo $s['id']; ?>' value="<?php echo stripslashes($s['name']); ?>" /></th>
					<th><input type='text' size='100' name ='search_link<?php echo $s['id']; ?>' value="<?php echo stripslashes($s['link']); ?>" /></th>
					<th>
						<select name='search_type<?php echo $s['id']; ?>'>
							<option value='Alliance' <?php echo ($s['type']=='Alliance'?'selected':'').">".$lang['qms_alliance']; ?></option>
							<option value='Joueur' <?php echo ($s['type']=='Joueur'?'selected':'').">".$lang['qms_joueur']; ?></option>
							<option value='Position' <?php echo ($s['type']=='Position'?'selected':'').">".$lang['qms_position']; ?></option>
						</select>
					</th>
					<th width='10%'><input name='search_actif<?php echo $s['id']; ?>' type='checkbox' <?php echo ($s['actif']=='1'?'checked':''); ?>></th>
				</tr>
<?php
	}
?>
			<tr>
				<td class='d' colspan='5' align='center'>
					<input name='search_modify' type='submit' value='<?php echo $lang['qms_admin_search_modify']; ?>'/>
				</td>
			</tr>
<?php
}
?>
				<tr>
					<td class='d'><a><?php echo $lang['qms_admin_search_add'].help('qms_search_add'); ?></a></td>
					<th><input type='text' name ='search_name' value='' /></th>
					<th><input type='text' name='search_link' size='100' value='' /></th>
					<th>
						<select name='search_type'>
							<option value='-'><?php echo $lang['qms_admin_search_choose']; ?></option>
							<option value='Alliance'><?php echo $lang['qms_alliance']; ?></option>
							<option value='Joueur'><?php echo $lang['qms_joueur']; ?></option>
							<option value='Position'><?php echo $lang['qms_position']; ?></option>
						</select>
					</th>
					<td class='d'><input name='search_create' type='submit' value='<?php echo $lang['qms_admin_search_creer']; ?>'/></td>
			</table>
	</form>
</fieldset>
<?php
define("FROM_ADMIN",1);
include_once "calendar.php";
?>

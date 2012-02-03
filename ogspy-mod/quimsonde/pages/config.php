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
// Affichage des options du membre
// Ouverture du FiledSet
echo"<fieldset>\n<legend><b><font color='#80FFFF'>".$lang['qms_menu_config_long'].help('qms_config')."</font></b></legend>\n<br /><br />\n";
?>
<form action='index.php<?php echo "?action=$mod_name&page=admin"; ?>' method='post'>
<table width='80%'>
<?php
$param = "type='text' size='11' maxlength='10' align='center'";
foreach($config_list as $config){
	if(($a=$config['name'])!=""){
		$name = "user_".$a;
		$value = get_qms_config($a,$b=$user_data['user_id']);
		echo"\t<tr>\n\t\t<th>".$config['titre']." ".help('qms_user_'.$a)."</th>\n\t\t";
		if($a=="time_start"||$a=="time_end"){ // Type DATE
			echo"<th><input id='$name' name='$name' $param value='".date($lang['qms_format_date'],$value)."' /></th>";
		}else
		if($a=="add_home"||$a=="imgmenu"||$a=="banniere"){ // Type YES/NO
			echo"<th><select name='$name'>";
			echo"<option value='1' ".(get_qms_config($a,$b)=="yes"?'selected':'').">".$lang['qms_oui']."</option>";
			echo"<option value='0' ".(get_qms_config($a,$b)!="yes"?'selected':'').">".$lang['qms_non']."</option>";
			echo"</select></th>";
		}else{ // Autre : Type nombre
			echo"<th><input name='$name' id='$name' type='text' value='$value' size='5';' onchange='chk_nb(\"$name\",$value);'/>\n";
			echo"\t</tr>";
		}
	}else{
		echo"\t<tr>\n\t\t<td class='c'>".$config['titre']."</td>\n\t\t<td class='d'>&nbsp<td>\n\t</tr>\n";
	}
}
?>
</table>
<center>
<input name='valider_user' type='submit' value='<?php echo $lang['qms_admin_config_submit']; ?>'/>&nbsp
<input name='restore_user' type='submit' value='<?php echo $lang['qms_admin_config_restore']; ?>'/>
</center>
</form>
<?php
echo"</fieldset>\n<br /><br /><br /><br />\n";
define("FROM_DETAILS",1);
include_once "calendar.php";
?>

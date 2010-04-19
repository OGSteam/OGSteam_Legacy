<?php
/**
* index.php Fichier principal
* @package [MOD] RCConv
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 0.7
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

$query = 'SELECT `active` FROM `'.TABLE_MOD.'` WHERE `action`=\'RCConv\' AND `active`=\'1\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) die('Hacking attempt');

if (!is_dir("mod/RCConv/inc")) {
	echo "Retélécharger le mod via : <a href='http://www.ogsteam.fr/downloadmod.php?mod=RCConv'>Zip link</a><br />\n";
	exit;
}

require_once('mod/RCConv/include.php');

init_all();

//Enregistre les couleurs dans des cookies
if(!empty($pub_cookie) AND isset($pub_cookie)) {
	foreach ($ship as $key => $value) {
		$result = "pub_".$key;
		setcookie("config_RCConv[".$key."]", $$result, time()+60*60*24*365*2 );
	}
    foreach ($def as $key => $value) {
		$result = "pub_".$key;
		setcookie("config_RCConv[".$key."]", $$result, time()+60*60*24*365*2 );
	}
    foreach ($other as $key => $value) {
		$result = "pub_".$key;
		setcookie("config_RCConv[".$key."]", $$result, time()+60*60*24*365*2 );
	}
    redirection("index.php?action=RCConv&page=cookie");
}
// Détruit tout les cookies
if(!empty($pub_del) AND isset($pub_del)) {
	destroy_cookie();
}

require_once('views/page_header.php');

if(empty($pub_page)) $pub_page = "RC";

if($pub_page != 'RC') {
	$bouton1 = "\t\t"."<td class='c' align='center' width='150' onclick=\"window.location = 'index.php?action=RCConv&page=RC';\">";
	$bouton1 .= "<a style='cursor:pointer'><font color='lime'>Convertisseur de RC</font></a>";
	$bouton1 .= "</td>\n";
} else {
	$bouton1 = "\t\t"."<th width='150'>";
	$bouton1 .= "<a>Convertisseur de RC</a>";
	$bouton1 .= "</th>\n";
}
if($pub_page != 'RR') {
	$bouton2 = "\t\t"."<td class='c' align='center' width='150' onclick=\"window.location = 'index.php?action=RCConv&page=RR';\">";
	$bouton2 .= "<a style='cursor:pointer'><font color='lime'>Convertisseur de RR</font></a>";
	$bouton2 .= "</td>\n";
} else {
	$bouton2 = "\t\t"."<th width='150'>";
	$bouton2 .= "<a>Convertisseur de RR</a>";
	$bouton2 .= "</th>\n";
}
if($pub_page != 'cookie') {
	$bouton3 = "\t\t"."<td class='c' align='center' width='150' onclick=\"window.location = 'index.php?action=RCConv&page=cookie';\">";
	$bouton3 .= "<a style='cursor:pointer'><font color='lime'>Définir les paramètres</font></a>";
	$bouton3 .= "</td>\n";
} else {
	$bouton3 = "\t\t"."<th width='150'>";
	$bouton3 .= "<a>Définir les paramètres</a>";
	$bouton3 .= "</th>\n";
}

echo "\n<table>\n\t<tr>\n";
echo $bouton1.$bouton2.$bouton3;
echo "\t</tr>\n</table>\n<br />\n";

if(!empty($pub_page) AND $pub_page == 'cookie') {
?>
<link rel="stylesheet" type="text/css" href="mod/RCConv/inc/ColorPicker.css" />
<script type="text/javascript" src="mod/RCConv/inc/CP_Class.js"></script>
<script type="text/javascript">
window.onload = function() {
	fctLoad();
}
window.onscroll = function() {
	fctShow();
}
window.onresize = function() {
	fctShow();
}
</script>
<br />
<form name='objForm' method='post' action='index.php?action=RCConv&page=cookie'>
<table>
    <tr>
        <td class="c">Vaisseaux</td>
        <td class="c">Couleur</td>
        <td rowspan="21">&nbsp;</td>
        <td class="c">Défense</td>
        <td class="c">Couleur</td>
        <td rowspan="21">&nbsp;</td>
        <td class="c">Autre</td>
        <td class="c">Couleur</td>
    </tr>

<?php

reset($ship);
reset($def);
reset($other);

while (list($key3, $val3) = each($other)) {
    list($key2, $val2) = each($def);
    list($key1, $val1) = each($ship);

	echo "\t<tr>\n";
	if (!empty($key1)) {
		echo "\t\t<th>".$val1."</th>\n";
		echo "\t\t<th><input type='text' name='".$key1."' value='".$RC_var[$key1]."' maxlength='7'/>\n";
		echo "\t\t\t<img src='mod/RCConv/inc/color.gif' align='absmiddle' onclick='fctShow(document.objForm.".$key1.")' style='cursor:pointer; width : 21 ; height : 20 ; border :0 ;'/></th>\n";
	} else { echo "\t\t<td></td>\n\t\t<td></td>\n"; }
	if (!empty($key2)) {
		echo "\t\t<th>".$val2."</th>\n";
		echo "\t\t<th><input type='text' name='".$key2."' value='".$RC_var[$key2]."' maxlength='7'/>\n";
		echo "\t\t\t<img src='mod/RCConv/inc/color.gif' align='absmiddle' onclick='fctShow(document.objForm.".$key2.")' style='cursor:pointer; width : 21 ; height : 20 ; border :0 ;'/></th>\n";
	} else { echo "\t\t<td></td>\n\t\t<td></td>\n"; }
	if (!empty($key3)) {
		echo "\t\t<th>".$val3."</th>\n";
		if ($key3 != "seuil" AND $key3{0} != "o") {
			echo "\t\t<th><input type='text' name='".$key3."' value='".$RC_var[$key3]."' maxlength='7'/>\n";
			echo "\t\t\t<img src='mod/RCConv/inc/color.gif' align='absmiddle' onclick='fctShow(document.objForm.".$key3.")' style='cursor:pointer; width : 21 ; height : 20 ; border :0 ;'/></th>\n";
		} else {
			if ($key3{0} == "o") {
				if ($key3 == "o_af") {
					echo "\t\t".'<th><select name="'.$key3.'">'."\n";
					echo "\t\t\t\t".'<option value="1"'.(($RC_var[$key3] == 1) ? ' selected' : '').'>&nbsp;&nbsp;&nbsp;&nbsp;1 ligne&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>'."\n";
					echo "\t\t\t\t".'<option value="2"'.(($RC_var[$key3] == 2) ? ' selected' : '').'>&nbsp;&nbsp;&nbsp;&nbsp;2 lignes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>'."\n";
					echo "\t\t\t\t".'<option value="c"'.(($RC_var[$key3] == 'c') ? ' selected' : '').'>&nbsp;&nbsp;&nbsp;&nbsp;1 colonne&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>'."\n";
					echo "\t\t\t".'</select>'."\n";
					echo "\t\t\t<img src='mod/RCConv/inc/vide.gif' align='absmiddle' style='width : 21 ; height : 20 ; border :0 ;'/></th>\n";
				} else if ($key3 == "o_word" OR $key3 == "o_nsize") {
					echo "\t\t<th><input type='text' name='".$key3."' value='".$RC_var[$key3]."' maxlength='7'/>\n";
					echo "\t\t\t<img src='mod/RCConv/inc/vide.gif' align='absmiddle' style='width : 21 ; height : 20 ; border :0 ;'/></th>\n";
				} else echo "\t\t".'<th><input type="checkbox" value=" checked" name="'.$key3.'"'.$RC_var[$key3].'/>'."\n";
			} else {
				echo "\t\t<th><input type='text' name='".$key3."' value='".$RC_var[$key3]."' maxlength='7'/>\n";
				echo "\t\t\t<img src='mod/RCConv/inc/vide.gif' align='absmiddle' style='width : 21 ; height : 20 ; border :0 ;'/></th>\n";
			}
		}
	} else { echo "\t\t<td></td>\n\t\t<td></td>\n"; }
	echo "\t</tr>\n";
}
?>

</table>
<br />
<input type="submit" name="cookie" value="Enregistrer le cookie"/><input type="submit" name="del" value="Supprimer le cookie"/>
</form>
<?php
} else if(empty($pub_page) OR $pub_page == 'RC') {

	if (!empty($pub_sizeSize)) {
		$pub_sizeSize = ((int)$pub_sizeSize > 0) ? (int)$pub_sizeSize : 0;
	} else {
		$pub_sizeSize = 18;
	}

	if (empty($pub_data) AND !(isset($pub_data) && $pub_data <> '')) {
		$pub_noCoords = $RC_var['o_coord'];
		$pub_renta = $RC_var['o_renta'];
		$pub_noTechs = $RC_var['o_tech'];
		$pub_center = $RC_var['o_center'];
		$pub_quote = $RC_var['o_quote'];
		$pub_size = $RC_var['o_size'];
		$pub_resum = $RC_var['o_resum'];
		$pub_sizeSize = $RC_var['o_nsize'];
		$pub_comment = $RC_var['o_word'];
		$pub_format = $RC_var['o_af'];
	}

	if (!empty($pub_data) AND isset($pub_data) && $pub_data <> '') {
		
		if(empty($pub_noCoords)) $pub_noCoords = "";
		if(empty($pub_renta)) $pub_renta = "";
		if(empty($pub_noTechs)) $pub_noTechs = "";
		if(empty($pub_center)) $pub_center = "";
		if(empty($pub_quote)) $pub_quote = "";
		if(empty($pub_size)) $pub_size = "";
		if(empty($pub_comment)) $pub_comment = "";
		if(empty($pub_resum)) $pub_resum = "";
		
		//Enlève les anti-slashes qui pourrait être présent.
		$pub_data = str_replace("\\", "", $pub_data);
		
		$pub_data = stripslashes($pub_data);
		//Compatibilité UNIX/Windows
		$pub_data = str_replace("\r\n","\n",$pub_data);
		//Compatibilité IE/Firefox
		$pub_data = str_replace("\t",' ',$pub_data);
		//A priori, certains obtiennent des rapports avec de multiples espaces, donc on élimine le problème à la base
		//cleanDoubleSpace($pub_data);
		//echo $pub_data.'<br>';
		
		// Test si le rapport est valide et récupère la date
		if (!preg_match('#Les\sflottes\ssuivantes\sse\ssont\saffrontées\sle\s(\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2}) \.:#',$pub_data,$date))
		{
			echo 'Rapport de combat invalide<br />'."\n";
		} else {
			
			// Récupère la flotte de l'attaquant
			$nb_A = preg_match_all('#Attaquant\s(.*)\s\((.*)\)\n?Armes:\s(\d{2,})%\sBouclier:\s(\d{2,})%\sCoque:\s(\d{2,})%\n?Type\s(.*)\n?Nombre\s(.*)\n?Armes:#', $pub_data, $A, PREG_SET_ORDER);
			// Récupère la flotte du défenseur
			$nb_D = preg_match_all('#Défenseur\s(.*)\s\((.*)\)\n?Armes:\s(\d{2,})%\sBouclier:\s(\d{2,})%\sCoque:\s(\d{2,})%\n?Type\s(.*)\n?Nombre\s(.*)\n?Armes:#', $pub_data, $D, PREG_SET_ORDER);
			
			if ($nb_A > 1 OR $nb_D > 1) {
				echo converter_g($pub_data);
			} else {
				echo converter_n($pub_data);
			}
		}
	}
?>

<form name='form' method='post' action='?action=RCConv'>
<table>
	<tr>
		<td class="c">Option</td>
		<td class="c">Valeur</td>
		<td rowspan="4">&nbsp;</td>
		<td class="c">Option</td>
		<td class="c">Valeur</td>
		<td rowspan="4">&nbsp;</td>
		<td class="c">Option</td>
		<td class="c">Valeur</td>
	</tr>
	<tr>
		<th><label for='center'>BBCode [center]</label></th>
		<th><input type='checkbox' name='center' id='center' value=" checked"<?php echo $pub_center; ?>/></th>
		<th><label for='noCoords'>Afficher les coordonnées</label></th>
		<th><input type='checkbox' name='noCoords' id='noCoords' value=" checked"<?php echo $pub_noCoords; ?>/></th>
		<th>Mot entre le début et la fin</th>
		<th><input type='text' name='comment' size='10' value='<?php echo ($pub_comment != "") ? $pub_comment : ""; ?>'/></th>
	</tr>
	<tr>
		<th><label for='quote'>BBCode [quote]</label></th>
		<th><input type='checkbox' name='quote' id='quote' value=" checked"<?php echo $pub_quote; ?>/></th>
		<th><label for='noTechs'>Afficher les Technologies</label></th>
		<th><input type='checkbox' name='noTechs' id='noTechs' value=" checked"<?php echo $pub_noTechs; ?>/></th>
		<th>Affichage sur</th>
		<th><select name='format' id='format' style='text-align : center'>
				<option value="1"<?php echo ($pub_format == 1) ? ' selected' : ''; ?>>1 ligne</option>
				<option value="2"<?php echo ($pub_format == 2) ? ' selected' : ''; ?>>2 lignes</option>
				<option value="c"<?php echo ($pub_format == 'c') ? ' selected' : ''; ?>>2 colonnes</option>
			</select>
		</th>
	</tr>
	<tr>
		<th><label for='size'>BBCode [size]</label></td>
		<th><input type='checkbox' name='size' id='size' value=" checked"<?php echo $pub_size; ?>/><input type='text' name='sizeSize' value='<?php if ($pub_sizeSize == 0) echo 18; else echo $pub_sizeSize; ?>' size='2'/></th>
		<th><label for='renta'>Afficher la Rentabilité</label></th>
		<th><input type='checkbox' name='renta' id='renta' value=" checked"<?php echo $pub_renta; ?>/></th>
		<th><label for='resum'>Mode résumé</label></th>
		<th><input type='checkbox' name='resum' id='resum' value=" checked"<?php echo $pub_resum; ?>></th>
	</tr>
</table>
<br />
Collez ici votre rapport de combat brut:
<textarea name='data' rows='10' cols='10'><?php echo $pub_data; ?></textarea>
<input type='submit' value='Convertir'>

<?php
} else if (!empty($pub_page) AND $pub_page == 'RR') {
	
	if (!empty($pub_sizeSize)) {
		$pub_sizeSize = ((int)$pub_sizeSize > 0) ? (int)$pub_sizeSize : 0;
	} else {
		$pub_sizeSize = 18;
	}
	if (empty($pub_datarr) AND !(isset($pub_datarr) && $pub_datarr <> '')) {
		$pub_noCoords = $RC_var['o_coord'];
		$pub_noTechs = $RC_var['o_tech'];
		$pub_center = $RC_var['o_center'];
		$pub_quote = $RC_var['o_quote'];
		$pub_size = $RC_var['o_size'];
		$pub_sizeSize = $RC_var['o_nsize'];
	}
	
	if (!empty($pub_datarr) AND isset($pub_datarr) AND $pub_datarr <> '') {
		
		//Enlève les anti-slashes qui pourrait être présent.
		$pub_datarr = str_replace("\\", "", $pub_datarr);
		
		$pub_datarr = stripslashes($pub_datarr);
		//Compatibilité UNIX/Windows
		$pub_datarr = str_replace("\r\n","\n",$pub_datarr);
		//Compatibilité IE/Firefox
		$pub_datarr = str_replace("\t",' ',$pub_datarr);
		//A priori, certains obtiennent des rapports avec de multiples espaces, donc on élimine le problème à la base
		//cleanDoubleSpace($pub_datare);
		//echo $pub_datare.'<br>';
		
		// Test si le rapport est valide et récupère la date
		if (!preg_match('#(\d{2})\-(\d{2})\s{0,}(\d{2}):(\d{2}):(\d{2})\s*Flotte\s*Rapport\s*d\'exploitation\s*du\s*champ\s*de\s*débris\s*aux\s*coordonnées\s*\[(.*)\]#i',$pub_datarr,$daterr)) {
			echo 'Rapport de recyclage invalide<br />'."\n";
		} else {
			
			//Mise en page
			$header = (($pub_quote == ' checked') ? '[quote]' : '').(($pub_center == ' checked') ? '[center]' : '');
			$footer = (($pub_center == ' checked') ? '[/center]' : '').(($pub_quote == ' checked') ? '[/quote]' : '');
			$size_opening = (($pub_size == ' checked') ? '[size='.$pub_sizeSize.']' : '').'[b]';
			$size_closing = '[/b]'.(($pub_size == ' checked') ? '[/size]' : '');
			
			// Récupère les données du recyclage
			preg_match('#Vos\s*((?:\.?\d*)+)\s*recycleurs\s*ont\s*une\s*capacité\s*totale\s*de\s*((?:\.?\d*)+)\.\s*((?:\.?\d*)+)\s*unités\s*de\s*métal\s*et\s*((?:\.?\d*)+)\s*unités\s*de\s*cristal\s*sont\s*dispersées\s*dans\s*ce\s*champ\.\s*Vous\s*avez\s*collecté\s*((?:\.?\d*)+)\s*unités\s*de\s*métal\s*et\s*((?:\.?\d*)+)\s*unités\s*de\s*cristal\.#i',$pub_datarr,$rrr);
			
			//Met la date au format français
			$daterr1 = date('d/m/Y à H:i:s',mktime($daterr[3],$daterr[4],$daterr[5],$daterr[1],$daterr[2],date('Y')));
			
			//Enlèvement des points dans les nombres
			$rrr = preg_replace("#\.#", "", $rrr);
			
			//Calcul le pourcentage ramassé
			if (($rrr[3] + $rrr[4]) != 0) {
				$pourc = round(((100 * ($rrr[5] + $rrr[6])) / ($rrr[3] + $rrr[4])), 1);
			} else {
				$pourc = 0;
			}
			
			//Déclare le texte converti
			$convrr = $header.'La flotte de recyclage est arrivée le '.$daterr1 ;
			$convrr .= ' sur le champ de ruine en '.(($pub_noCoords == ' checked') ? $size_opening.$daterr[6].$size_closing : 'x:xxx:x') ;
			$convrr .= ' pour exploitation.'."\n";
			$convrr .= 'Vos recycleurs au nombre de '.$rrr[1] ;
			$convrr .= ' et d\'une capacité totale de '.$rrr[2] ;
			$convrr .= ' ont détectés '.convColor($rrr[3]);
			$convrr .= ' unités de métal et '.convColor($rrr[4]);
			$convrr .= ' unités de cristal en suspension dans l\'espace.'."\n" ;
			$convrr .= 'Vous avez collecté un total de '.$size_opening.convColor($rrr[5]).$size_closing ;
			$convrr .= ' unités de métal et '.$size_opening.convColor($rrr[6]).$size_closing ;
			$convrr .= ' unités de cristal.'."\n";
			$convrr .= '[u]Pourcentage ramassé :[/u]'."\n";
			$convrr .= $pourc.' %';
			$conv .= convfooter("Rappport de recyclage");
			$convrr .= $footer;
			
			echo 'Rapport converti<br /><textarea rows=\'3\' cols=\'5\'>'.$convrr.'</textarea>';
		}
	}
?>
<form name='form' method='post' action='?action=RCConv&page=RR'>
<table>
	<tr>
		<td class="c">Option</td>
		<td class="c">Valeur</td>
		<td rowspan="3">&nbsp;</td>
		<td class="c">Option</td>
		<td class="c">Valeur</td>
	</tr>
	<tr>
		<th><label for="center">BBCode [center]</label></th>
		<th><input type="checkbox" name="center" id="center" value=" checked"<?php echo $pub_center; ?>></th>
		<th><label for="noCoords">Afficher les coordonnées</label></th>
		<th><input type="checkbox" name="noCoords" id="noCoords" value=" checked"<?php echo $pub_noCoords; ?>></th>
	</tr>
	<tr>
		<th><label for="quote">BBCode [quote]</label></th>
		<th><input type="checkbox" name="quote" id="quote" value=" checked"<?php echo $pub_quote; ?>></th>
		<th><label for="size">BBCode [size]</label></th>
		<th><input type="checkbox" name="size" id="size" value=" checked"<?php echo $pub_size; ?>/><input type='text' name='sizeSize' value='<?php echo ($pub_sizeSize == 0) ? 18 : $pub_sizeSize; ?>' size='2'/></th>
	</tr>
</table>
<br />
Collez ici votre rapport de recyclage brut:
<textarea name='datarr' rows='3' cols='1'><?php echo $pub_datarr; ?></textarea>
<input type='submit' value='Convertir'>
</form>
<?php
}
echo "<br />\n";
page_footer();
require_once('views/page_tail.php');
?>
<?php
/**
* sign_conf_ally.php Configuration de la signature des stats alliance
* @package OGSign
* @author oXid_FoX
* @author Kal Nightmare
* @link http://www.ogsteam.fr
*/


// vérification de sécurité
if (!defined('IN_SPYOGAME')) die('Hacking attempt');

// vérification des droits
if ($user_data['user_admin'] != 1 && $user_data['user_coadmin'] != 1) {
	redirection('index.php?action=message&id_message=forbidden&info');
}



// listing de toutes les alliances
$request = "SELECT distinct ally FROM ".TABLE_RANK_ALLY_POINTS." order by ally";
$result = $db->sql_query($request);
while ($row = $db->sql_fetch_assoc($result)) {
		if ($row["ally"] != "")	$ally_list[] = $row["ally"];
	}



$options_1 = '<option></option>'."\n";
foreach ($ally_list as $ally_name) {
	$options_1 .= '<option>'.$ally_name.'</option>'."\n";
}
?>
<script language="JavaScript" type="text/javascript" src="js/autocomplete.js"></script>
<?php

// si l'ally a été choisie
if (isset($pub_ally_l)) {

$tag_choisi = $pub_ally_l;
// si la liste de choix est vide, on prend ce qui est dans le champ texte (correction du bug de la sélection dans l'historique des champs textes)
if (empty($tag_choisi))
	$tag_choisi = $pub_select_ally_l;

// recherche des paramètres de la signature
$query = 'SELECT `ally_id` FROM `'.TABLE_ALLY_SIGN.'` WHERE `TAG` = '.quote_smart($tag_choisi);
$result = $db->sql_query($query);
$sign_exist = $db->sql_numrows($result);
$para = $db->sql_fetch_assoc($result);
$ally_id = $para['ally_id'];

if (empty($sign_exist)) {
	// création des paramètres (très peu de params à la création, car on choisit après, (donc tout par défaut dans la base) les params seront à l'UPDATE)
	if (!empty($tag_choisi)) {
		$query = 'INSERT INTO `'.TABLE_ALLY_SIGN.'` (`ally_id`, `TAG`) VALUES ("", '.quote_smart($tag_choisi).')';
		$db->sql_query($query);

		// récupération de l'id
		$query = 'SELECT `ally_id` FROM `'.TABLE_ALLY_SIGN.'` WHERE `TAG` = '.quote_smart($tag_choisi);
		$result = $db->sql_query($query);
		$para = $db->sql_fetch_assoc($result);
		$ally_id = $para['ally_id'];
	}
} else {
	// modification des paramètres
	if (!empty($tag_choisi) && !empty($pub_choix_fond)) {
		$query = 'UPDATE `'.TABLE_ALLY_SIGN.'` SET `nom_ally` = '.quote_smart($pub_nom_ally).', `founder_ally` = '.quote_smart($pub_founder).', `nom_fond` = '.quote_smart($pub_choix_fond);
		if (!empty($pub_couleur_txt) && is_numeric('0x'.$pub_couleur_txt)) $query .= ', `couleur_txt` = \''.$pub_couleur_txt.'\'';
		if (!empty($pub_couleur_txt_var) && is_numeric('0x'.$pub_couleur_txt_var)) $query .= ', `couleur_txt_var` = \''.$pub_couleur_txt_var.'\'';
		$query .= ', `sign_active` = ';
		if (isset($pub_sign_active)) $query .= '\'1\''; else $query .= '\'0\'';

		// pour le système de détection des stats 1: ancien systeme ; 2: systeme actuel
		$query .= ', `stats_detection_system` = ';
		if (isset($pub_syst_detect_stats)) $query .= '1'; else $query .= '2';

		// pour le séparateur de milliers
		$query .= ', `sepa_milliers` = ';
		if (isset($pub_sepa_milliers) && $pub_sepa_milliers != 'sans') {
			if ($pub_sepa_milliers == 'espace')
				$query .= '\'s\'';
			if ($pub_sepa_milliers == 'point')
				$query .= '\'.\'';
		} else $query .= '\'\'';

		// pour le style des textes
		$query .= ', `style_texte` = ';
		if (isset($pub_style_texte) && $pub_style_texte != 'nu') {
			if ($pub_style_texte == 'detour')
				$query .= '\'d\'';
			if ($pub_style_texte == 'ombre')
				$query .= '\'o\'';
		} else $query .= '\'\'';

		if (!empty($pub_couleur_style_txt) && is_numeric('0x'.$pub_couleur_style_txt)) $query .= ', `couleur_style_txt` = \''.$pub_couleur_style_txt.'\'';

		$query .= ' WHERE `TAG` = '.quote_smart($tag_choisi);
		$db->sql_query($query);

		// et on va supprimer la signature pour qu'elle se régénère ('A' pour purger l'ally)
	
		vide_sign_cacheally('A', $tag_choisi);
		
	}
}

// recherche des paramètres de la signature
if (isset($pub_ally_id)) $ally_id = $pub_ally_id;

$query = 'SELECT * FROM `'.TABLE_ALLY_SIGN.'` WHERE `ally_id` = '.$ally_id;
$result = $db->sql_query($query);
$param_sign = $db->sql_fetch_assoc($result);

// création de l'adresse de la signature
$url_sign = $full_url_sign = '';
if (!empty($param_sign['TAG'])) {
	$url_sign = 'mod/OGSign/'.$param_sign['ally_id'].'.A.png';
	$full_url_sign = str_replace(' ','%20','http://'.substr($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],0, strlen($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'])-9) . $url_sign);
}

// dossier des fonds
$dir_src_fonds = 'mod/OGSign/fonds/ally';
?>
<script language="JavaScript" type="text/javascript">
function show_fonds() {
	if(document.getElementById('list_fonds_ogsign').style.display == 'none') {
		document.getElementById('list_fonds_ogsign').style.display = 'inline';
		document.getElementById('submit_bar2').style.display = 'block'; // pour IE (6) qui ne connait pas 'table-cell'
		document.getElementById('submit_bar2').style.display = 'table-cell';
		document.getElementById('voir_fonds').value = 'Cacher la liste';
	}
	else {
		document.getElementById('list_fonds_ogsign').style.display = 'none';
		document.getElementById('submit_bar2').style.display = 'none';
		document.getElementById('voir_fonds').value = 'Choix du fond';
	}
}

function show_txtcolor() {
	if(document.getElementById('choice_color_txt').style.display == 'none') {
		document.getElementById('choice_color_txt').style.display = 'inline';
		document.getElementById('bloc_preview_txt_color').style.display = 'block';
		document.getElementById('voir_txt_color').value = 'Masquer le choix de la couleur de texte';
	}
	else {
		document.getElementById('choice_color_txt').style.display = 'none';
		document.getElementById('bloc_preview_txt_color').style.display = 'none';
		document.getElementById('voir_txt_color').value = 'Choix de la couleur de texte';
	}
}
</script>
<form method="POST" action="" name="ogsign">
<table align="center" width="100%" cellpadding="0" cellspacing="1">

<!-- INFO ALLY -->
	<tr><td class="c" colspan="2">Information sur l'Alliance</td></tr>

	<?php echo '<input type="hidden" name="ally_id" value="',$ally_id,'" />','<input type="hidden" name="ally_l" value="',$pub_ally_l,'" />'; ?>
		<tr><th width="50%">TAG alliance</th>
			<th width="50%"><input type="text" disabled="disabled" size="15" maxlength="20" value="<?php echo $param_sign['TAG']; ?>"><br />
		</th></tr>
	<tr><th width="50%">Nom alliance</th>
			<th width="50%"><input type="text" name="nom_ally" size="30" maxlength="30" value="<?php
			if (!empty($param_sign['nom_ally'])) echo $param_sign['nom_ally']; ?>"><br />
		</th></tr>
	<tr><th width="50%">Fondateur de l'alliance</th>
		<th width="50%"><input type="text" name="founder" size="30" maxlength="30" value="<?php
		if (!empty($param_sign['founder_ally'])) echo $param_sign['founder_ally']; ?>"><br />
	</th></tr>

<!-- SEPARATEUR DE MILLIERS -->
	<tr><td class="c" colspan="2">Choix du séparateur de milliers</td></tr>
	<tr><th width="50%">Séparateur de milliers</th>
	<th width="50%"><input type="radio" id="sepa_milliers_sans" name="sepa_milliers" value="sans"<?php
	if ($param_sign['sepa_milliers'] == '') echo ' checked="checked"'; ?>>
	<label for="sepa_milliers_sans">sans séparateur <?php echo infobulle('1234567890', 'Exemple'); ?></label>
	<input type="radio" id="sepa_milliers_espace" name="sepa_milliers" value="espace"<?php
	if ($param_sign['sepa_milliers'] == 's') echo ' checked="checked"'; ?>>
	<label for="sepa_milliers_espace">espace <?php echo infobulle('1 234 567 890', 'Exemple'); ?></label>
	<input type="radio" id="sepa_milliers_point" name="sepa_milliers" value="point"<?php
	if ($param_sign['sepa_milliers'] == '.') echo ' checked="checked"'; ?>>
	<label for="sepa_milliers_point">point <?php echo infobulle('1.234.567.890', 'Exemple'); ?></label>
	</th></tr>

<!-- APERCU DE LA SIGNATURE -->
	<tr><td class="c" colspan="2">Signature actuelle</td></tr>
	<tr><th colspan="2" style="-moz-opacity: 1; filter: alpha(opacity=100); /*suppression de la transparence éventuelle*/">
	<a href=<?php echo $full_url_sign; ?>>
	<img src="<?php $img_size = @getimagesize($full_url_sign);
	echo $url_sign.'" alt="signature de l\'alliance '.$param_sign['TAG'].'" title="signature de l\'alliance '.$param_sign['TAG'].'" id="sign_actuelle" '.$img_size[3];
	?>"></img></a></th></tr>

<!-- ADRESSE DE LA SIGNATURE -->
	<tr><td class="c" colspan="2">Adresse de la signature</td></tr>
	<tr><th colspan="2"><input type="text" id="url_sign" value="<?php echo $full_url_sign; ?>" size="70" readonly="readonly" onClick="this.focus(); this.select();" style="text-align: center;"><br />
	<input type="text" id="url_sign_img" value="[img]<?php echo $full_url_sign; ?>[/img]" size="80" readonly="readonly" onClick="this.focus(); this.select();" style="text-align: center;">
	</th></tr>

<!-- ACTIVATION DE LA SIGNATURE -->
	<tr><td class="c" colspan="2">Activation de la signature</td></tr>
	<tr><th width="50%">Activer cette signature
	<?php echo infobulle('Dans le cas où vous ne voudriez pas avoir votre signature, désactivez-la'); ?></th>
	<th width="50%"><input type="checkbox" name="sign_active"<?php
	if (isset($param_sign['sign_active'])) {
		if ($param_sign['sign_active'] == 1)
			echo ' checked="checked"';
	} else
	echo ' checked="checked"'; ?>></th></tr>

<!-- SYSTEME DE DETECTION DES STATS-->
	<tr><td class="c" colspan="2">Système de détection des statistiques</td></tr>
	<tr><th width="50%">Utiliser l'ancien système de détection des statistiques
	<?php echo infobulle('L\'<span style=color:orange>ancien système</span> permet d\'avoir beaucoup moins de \'?\' mais la signature ne sera pas forcément à jour : <span style=color:orange><i>OGSign recherche les dernières stats de l\'alliance</i></span>.<br><br>Le <span style=color:orange>système actuel</span> quant à lui garantit une signature toujours à jour, mais au risque d\'avoir plus de \'?\' : <span style=color:orange><i>OGSign recherche l\'alliance parmi les dernières stats</i></span>.', 'Aide', 290); ?></th>
	<th width="50%"><input type="checkbox" name="syst_detect_stats"<?php
	if ($param_sign['stats_detection_system'] == 1)
		echo ' checked="checked"'; ?>></th></tr>

<!-- CHOIX DU FOND -->
	<tr><td class="c" colspan="2"><input type="button" onClick="show_fonds();" id="voir_fonds" value="Choix du fond"></td></tr>
	<tr><th colspan="2" id="submit_bar2"><input type="submit" value="Valider"> <input type="reset" value="Réinitialiser"></th></tr>
	<tr><th colspan="2" style="-moz-opacity: 1; filter: alpha(opacity=100); /*suppression de la transparence éventuelle*/">
	<div id="list_fonds_ogsign" style="display: inline; float: left; margin: 0; padding: 0;">
<?php

	// liste tous les fonds (obligatoirement des PNG)
	unset($liste_fonds);
	if ($dh = opendir($dir_src_fonds)) {
		while (($nom_fichier = readdir($dh)) !== false) {
			if (preg_match('/.png/',$nom_fichier))
				$liste_fonds[] = $nom_fichier;
		}
		closedir($dh);
	}

	// tri de la liste par ordre alphabétique naturel, sans tenir compte de la casse ( "Foo10" après "foo2" )
	natcasesort($liste_fonds);
	$liste_triee_fonds = array_values($liste_fonds);

	// on affiche les images
	$i = 0;
	while ($i < count($liste_triee_fonds))
	{
		$img_size = @getimagesize($dir_src_fonds.'/'.$liste_triee_fonds[$i]);
		// le bloc (img + radio), avec un cadre
		echo "\t\t",'<div style="display: block; margin: 10px; padding: 5px; float: left; border: 1px solid ';
		// surlignage du contour si c'est le fond sélectionné
		if ($liste_triee_fonds[$i] == $param_sign['nom_fond']) echo '#DFDFDF'; else echo '#3F3F3F';
		// le label permet que le clic sur l'image coche le bouton radio. magique ! (mais juste sous FF, IE ne veut pas du clic sur l'img)
		echo ";\">\n\t\t",'<label for="choix_fond_',$liste_triee_fonds[$i],'"><img src="',$dir_src_fonds,'/',$liste_triee_fonds[$i],'" ',$img_size[3],'></label>'
		,"<br />\n\t\t",'<input type="radio" id="choix_fond_',$liste_triee_fonds[$i],'" name="choix_fond" value="',$liste_triee_fonds[$i],'"';
		if ($liste_triee_fonds[$i] == $param_sign['nom_fond']) echo ' checked="checked"';
		echo "></div>\n";
		$i++;
	}

	?>
	</div></th></tr>

<!-- CHOIX DE LA COULEUR DU TEXTE -->
	<tr><td class="c" colspan="2"><input type="button" onClick="show_txtcolor();" id="voir_txt_color" value="Choix de la couleur de texte"></td></tr>
	<tr>
		<th><div id="choice_color_txt" style="display: inline;">Couleurs
		<?php echo infobulle('Code hexadécimal de la couleur du texte, en 6 chiffres allant de 0 (zéro) à f, répartis ainsi:<br />Rouge Vert Bleu : RRVVBB.<br />ex: ff0000 donne le rouge,<br />ff8800 pour du orange,<br />00ffff pour un turquoise'); ?><br />
		Textes "fixes" ("Nom", "TAG", etc...)<br />
		<input type="radio" name="position_color_picker" id="position_color_picker_txtfixes" checked="checked">
		<input type="text" name="couleur_txt" id="couleur_txt" value="<?php if (!empty($param_sign['couleur_txt'])==TRUE) echo $param_sign['couleur_txt']; else echo '000000'; ?>" onChange="document.getElementById('preview_txt1_color').style.color=this.value;" onKeyUp="document.getElementById('preview_txt1_color').style.color=this.value;" maxlength="6"><br />
		Textes "variables" (le pseudo, les points et classements, etc...)<br />
		<input type="radio" name="position_color_picker" id="position_color_picker_txtvar">
		<input type="text" name="couleur_txt_var" id="couleur_txt_var" value="<?php if (!empty($param_sign['couleur_txt_var'])==TRUE) echo $param_sign['couleur_txt_var']; else echo '000000'; ?>" onChange="document.getElementById('preview_txt2_color').style.color=this.value;" onKeyUp="document.getElementById('preview_txt2_color').style.color=this.value;" maxlength="6"><br />
		Ombre / Contour<br />
		<input type="radio" name="position_color_picker" id="position_color_picker_detour">
		<input type="text" name="couleur_style_txt" id="couleur_style_txt" value="<?php if (!empty($param_sign['couleur_style_txt'])==TRUE) echo $param_sign['couleur_style_txt']; else echo '828282'; ?>" onKeyUp="document.getElementById('preview_txt3_color').style.color=this.value;" maxlength="6"><br />

		<!-- color picker -->
		<table style="background-color: transparent; border: 0px; padding: 0px; margin: 5px auto; display: none;" border="0" cellpadding="0" cellspacing="0" id="colorpicker">
		<tr>
			<td width="169" style="border: 1px solid #cccccc; background-color: #ffffff;">
			<div id="temoin" style="float: right; width: 40px; height: 128px;"></div>

			<script language="Javascript" type="text/javascript">
			var total=1657;
			var X=Y=j=RG=B=0;
			var aR=new Array(total);
			var aG=new Array(total);
			var aB=new Array(total);
			for (var i=0;i<256;i++){
				aR[i+510]=aR[i+765]=aG[i+1020]=aG[i+5*255]=aB[i]=aB[i+255]=0;
				aR[510-i]=aR[i+1020]=aG[i]=aG[1020-i]=aB[i+510]=aB[1530-i]=i;
				aR[i]=aR[1530-i]=aG[i+255]=aG[i+510]=aB[i+765]=aB[i+1020]=255;
				if(i<255)
					aR[i/2+1530]=127;aG[i/2+1530]=127;aB[i/2+1530]=127;

			}

			var hexbase=new Array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
			var i=0;
			var jl=new Array();
			for(x=0;x<16;x++)
				for(y=0;y<16;y++)
					jl[i++]=hexbase[x]+hexbase[y];
			document.write('<'+'table border="0" cellspacing="0" cellpadding="0" onMouseover="t(event)" onClick="p()">');
			var H=W=63;
			for (Y=0;Y<=H;Y++){
				s='<'+'tr height="2">';j=Math.round(Y*(510/(H+1))-255);
				for (X=0;X<=W;X++){
					i=Math.round(X*(total/W));
					R=aR[i]-j;if(R<0)R=0;if(R>255||isNaN(R))R=255;
					G=aG[i]-j;if(G<0)G=0;if(G>255||isNaN(G))G=255;
					B=aB[i]-j;if(B<0)B=0;if(B>255||isNaN(B))B=255;
					s=s+'<'+'td width="2" bgcolor="#'+jl[R]+jl[G]+jl[B]+'"><'+'/td>';
				}
				document.write(s+'<'+'/tr>\n');
			}
			document.write('<'+'/table>');
			var ns6=document.getElementById&&!document.all;
			var ie=document.all;
			var couleur_clic='';

			// appelée au survol, affiche la couleur survolée dans la case témoin
			function t(e){
				source=ie?event.srcElement:e.target;
				if(source.tagName=='TABLE') return
				while(source.tagName!='TD' && source.tagName!='HTML')source=ns6?source.parentNode:source.parentElement;
				// couleur dans la zone témoin
				document.getElementById('temoin').style.backgroundColor=couleur_clic;
				couleur_clic=source.bgColor;
			}

			// fonction qui écrit la couleur choisie, etc...
			// appelée au clic
			// substring pour ne pas prendre le #
			function p(){
				if (document.getElementById('position_color_picker_txtvar').checked) {
					document.getElementById('couleur_txt_var').value=couleur_clic.substring(1,7);
					document.getElementById('preview_txt2_color').style.color=couleur_clic.substring(1,7);
				}
				if (document.getElementById('position_color_picker_txtfixes').checked) {
					document.getElementById('couleur_txt').value=couleur_clic.substring(1,7);
					document.getElementById('preview_txt1_color').style.color=couleur_clic.substring(1,7);
				}
				if (document.getElementById('position_color_picker_detour').checked) {
					document.getElementById('couleur_style_txt').value=couleur_clic.substring(1,7);
					document.getElementById('preview_txt3_color').style.color=couleur_clic.substring(1,7);
				}
			}
			</script>

			</td>
		<td><?php echo infobulle('Cliquez sur la couleur pour la sélectionner.<br />Pour alterner le texte à colorer (fixe/variable), cochez celui désiré.'); ?></td>
		</tr>
		</table>

		</div></th>
		<th style="-moz-opacity: 1; filter: alpha(opacity=100); /*suppression de la transparence éventuelle*/">
		<div id="bloc_preview_txt_color" style="background-repeat: no-repeat;
		background-image: url('<?php echo $dir_src_fonds,'/',$param_sign['nom_fond']; ?>');
<?php
if (!empty($param_sign['nom_fond'])) {
$img_size = @getimagesize($dir_src_fonds.'/'.$param_sign['nom_fond']);
echo "\t\twidth: ",$img_size[0],'px; /*taille complète*/'
,"\n\t\theight:",$img_size[1]*0.7,'px; /* taille moins le padding */'
,"\n\t\tpadding: ",$img_size[1]*0.3,'px 0px; /* 30% de la hauteur du fond. la largeur, sans importance puisque le texte est centré */',"\n"; } ?>
		margin: 1px;
		font-family: arial;
		font-weight: normal;
		text-align: center;">
		<span id="preview_txt1_color" style="color: <?php echo $param_sign['couleur_txt']; ?>; font-size: <?php
		echo min($img_size[0],$img_size[1]*0.4); ?>px; /* 40% max de la taille du fond */">TEST</span>
		<span id="preview_txt2_color" style="color: <?php echo $param_sign['couleur_txt_var']; ?>; font-size: <?php
		echo min($img_size[0],$img_size[1]*0.4); ?>px; /* 40% max de la taille du fond */">TEST</span>
		</div></th>
	</tr>

<!-- STYLE DES TEXTES -->
	<tr><td class="c" colspan="2">Style des textes</td></tr>
	<tr><th width="50%">Style des textes de la signature</th>
	<th width="50%">
		<input type="radio" id="style_texte_nu" name="style_texte" value="nu"<?php
		if ($param_sign['style_texte'] == '') echo ' checked="checked"'; ?>>
		<label for="style_texte_nu">sans style particulier</label>
		<input type="radio" id="style_texte_detour" name="style_texte" value="detour"<?php
		if ($param_sign['style_texte'] == 'd') echo ' checked="checked"'; ?>>
		<label for="style_texte_detour">détouré <?php echo infobulle('Cela concerne <b>tous</b> les textes ; ajoute un contour (comme pour les dessins de bandes dessinées).', 'Info'); ?></label>
		<input type="radio" id="style_texte_ombre" name="style_texte" value="ombre"<?php
		if ($param_sign['style_texte'] == 'o') echo ' checked="checked"'; ?>>
		<label for="style_texte_ombre">ombré <?php echo infobulle('Ajoute une ombre au-dessous et à droite.<br />Uniquement pour les textes "fixes" ("Nom", "TAG", etc...)', 'Info'); ?></label>
	</th></tr>

<!-- VALIDATION DES PARAMETRES -->
	<tr><th colspan="2"><input type="submit" value="Valider"> <input type="reset" value="Réinitialiser"></th></tr>

</table>
</form>
<script language="JavaScript" type="text/javascript">
// cela permet de rester compatible avec le javascript désactivé.
document.getElementById('list_fonds_ogsign').style.display = 'none';
document.getElementById('submit_bar2').style.display = 'none';
document.getElementById('choice_color_txt').style.display = 'none';
document.getElementById('bloc_preview_txt_color').style.display = 'none';
document.getElementById('colorpicker').style.display = 'block'; // pour IE
document.getElementById('colorpicker').style.display = 'table';
</script>

<?php
}
// si l'ally n'a pas été choisie, on le fait ici
else {
?>
<form method="POST" action="">
<table align="center" cellpadding="0" cellspacing="1" width="100%">
<tr>
	<td class="c" colspan="3">Choix de l'alliance</td>
</tr>
<tr>
	<th width="33%">TAG de l'alliance : <?php echo infobulle('Sensible à la casse<br />(majuscules / minuscules)','Attention'); ?></th>
	<th width="33%"><input type="text" name="select_ally_l" size="20" maxlength="30" onkeyup="autoComplete(this,this.form.elements['ally_l'],'text',false)"></th>
	<th width="33%"><select name="ally_l"><?php echo $options_1; ?></select></th>
</tr>
<tr>
	<th colspan="3"><input type="submit" value="Configurer"></th>
</tr>
</table>
</form>
<?php
}
?>

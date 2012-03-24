<?php
/***************************************************************************
*	filename	: enregistrements.php
*	version		: 1.0.2
*	desc.			: Affichage des enregistrements du mod pandore
*	Authors		: Scaler - http://ogsteam.fr
*	created		: 18:34 05/09/2009
*	modified	: 18:03 24/03/2012
***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $table_prefix;

if (isset($pub_save)) {
	$query = "INSERT INTO `".$table_prefix."mod_pandore` (joueur, classement_general, points_general, classement_flotte, points_flotte, classement_recherche, points_recherches, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, SAT, DST, EDLM, TRA, points, points_manquants, flottes, flottes_manquantes, user_name, date) VALUES ('".$pub_joueur."', ".$pub_classement_general.", ".$pub_points_general.", ".$pub_classement_flotte.", ".$pub_points_flotte.", ".$pub_classement_recherche.", ".$pub_points_recherches.", ".$pub_PT.", ".$pub_GT.", ".$pub_CLE.", ".$pub_CLO.", ".$pub_CR.", ".$pub_VB.", ".$pub_VC.", ".$pub_REC.", ".$pub_SE.", ".$pub_BMD.", ".$pub_SAT.", ".$pub_DST.", ".$pub_EDLM.", ".$pub_TRA.", ".$pub_points.", ".$pub_points_manquants.", ".$pub_flottes.", ".$pub_flottes_manquantes.", '".$user_data['user_name']."', '".date('Y-m-d H:i:s', time())."')";
	$db->sql_query($query);
}

$query = "SELECT id, joueur, classement_general, points_general, classement_flotte, points_flotte, classement_recherche, points_recherches, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, SAT, DST, EDLM, TRA, points, points_manquants, flottes, flottes_manquantes, user_name, date FROM `".$table_prefix."mod_pandore` ORDER BY id DESC";
$quet = mysql_query($query);
$donnees = array('id', 'joueur', 'classement_general', 'points_general', 'classement_flotte', 'points_flotte', 'classement_recherche', 'points_recherches', 'points', 'points_manquants', 'flottes', 'flottes_manquantes', 'user_name', 'date');
?>
<script type="text/javascript">
var donnees = new Array();
var donnees1 = new Array();
var donnees2 = new Array();
<?php
echo "user_name = '".$user_data["user_name"]."';\n";
echo "user_admin = ".($user_data["user_admin"] + $user_data["user_coadmin"]).";\n";
$i = 0;
while ($row = mysql_fetch_assoc($quet)) {
	if (($user_data['user_name'] == $row['user_name'] || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) && isset(${"pub_del".$row['id']}) && ${"pub_del".$row['id']} == "on") {
		$query = "DELETE FROM `".$table_prefix."mod_pandore` WHERE id = ".$row['id'];
		$db->sql_query($query);
	} else {
		echo "donnees[".$i++."] = new Array('";
		foreach ($donnees as $key) echo $row[$key]."', '";
		echo "');\n";
	}
}
echo "text_page = '".sprintf($lang['pandore_page'], 'chaine1', 'chaine2')."';\n";
?>
donnees1 = donnees2 = donnees;
taille_page = 10;
page_actuelle = 0;
nom = '';

function affichage (page) {
ligne = '<table>\n<tr>\n\t<td rowspan="2"></td>\n'
	+ '\t<td class="c" rowspan="2" style="text-align: center; min-width: 80px"><a><?php echo $lang['pandore_player'];?></a></td>\n'
	+ '\t<td class="c" colspan="3" style="text-align: center"><a><?php echo $lang['pandore_ranks_points'];?></a></td>\n'
	+ '\t<td class="c" rowspan="2" style="text-align: center; min-width: 100px"><a><?php echo $lang['pandore_fleet_points']." / ".$lang['pandore_missing_points'];?></a></td>\n'
	+ '\t<td class="c" rowspan="2" style="text-align: center; min-width: 100px"><a><?php echo $lang['pandore_fleets']." / ".$lang['pandore_missing_fleet'];?></a></td>\n'
	+ '\t<td class="c" rowspan="2" style="text-align: center; min-width: 80px"><a><?php echo $lang['pandore_saved_by'];?></a></td>\n'
	+ '\t<td class="c" rowspan="2" style="text-align: center; min-width: 120px"><a><?php echo $lang['pandore_date'];?></a></td>\n'
	+ '</tr>\n<tr>\n'
	+ '\t<td class="c" style="text-align: center; min-width: 40px"><a><?php echo $lang['pandore_points'];?></a></td>\n'
	+ '\t<td class="c" style="text-align: center; min-width: 40px"><a><?php echo $lang['pandore_fleet'];?></a></td>\n'
	+ '\t<td class="c" style="text-align: center; min-width: 40px"><a><?php echo $lang['pandore_research'];?></a></td>\n</tr>\n';

row = 'f';
if (page != null) page_actuelle = page;
if (page_actuelle > Math.floor((donnees2.length - 1) / taille_page)) page_actuelle = Math.max(0, Math.floor((donnees2.length - 1) / taille_page));

// Remplissage du tableau
if (donnees2.length > 0) {
	for (i = taille_page * page_actuelle; i < Math.min(donnees2.length, taille_page * (page_actuelle + 1)); i++) {
		ligne += '<tr>\n'
		+ '\t<td rowspan="2" style="text-align: center">';
		if (user_name == donnees2[i][12] || user_admin > 0) ligne += '<input type="checkbox" name="del' + donnees2[i][0] + '" id="' + i + '" / >';
		ligne += '</td>\n'
		+ '\t<td class="' + row + '" rowspan="2" style="text-align: center; cursor: pointer" onclick="window.open(&quot;?action=pandore&id=' + donnees2[i][0] + '&quot;,&quot;_self&quot;)" title ="<?php echo $lang['pandore_click']?>">' + donnees2[i][1] + '</td>\n'
		+ '\t<td class="' + row + '" style="text-align: center; cursor: pointer" onclick="window.open(&quot;?action=pandore&id=' + donnees2[i][0] + '&quot;,&quot;_self&quot;)" title ="<?php echo $lang['pandore_click']?>">' + format(donnees2[i][2]) + '</td>\n'
		+ '\t<td class="' + row + '" style="text-align: center; cursor: pointer" onclick="window.open(&quot;?action=pandore&id=' + donnees2[i][0] + '&quot;,&quot;_self&quot;)" title ="<?php echo $lang['pandore_click']?>">' + format(donnees2[i][4]) + '</td>\n'
		+ '\t<td class="' + row + '" style="text-align: center; cursor: pointer" onclick="window.open(&quot;?action=pandore&id=' + donnees2[i][0] + '&quot;,&quot;_self&quot;)" title ="<?php echo $lang['pandore_click']?>">' + format(donnees2[i][6]) + '</td>\n'
		+ '\t<td class="' + row + '" rowspan="2" style="text-align: center; cursor: pointer" onclick="window.open(&quot;?action=pandore&id=' + donnees2[i][0] + '&quot;,&quot;_self&quot;)" title ="<?php echo $lang['pandore_click']?>">' + format(donnees2[i][8]) + '&nbsp;/&nbsp;' + format(donnees2[i][9]) + '</td>\n'
		+ '\t<td class="' + row + '" rowspan="2" style="text-align: center; cursor: pointer" onclick="window.open(&quot;?action=pandore&id=' + donnees2[i][0] + '&quot;,&quot;_self&quot;)" title ="<?php echo $lang['pandore_click']?>">' + format(donnees2[i][10]) + '&nbsp;/&nbsp;' + format(donnees2[i][11]) + '</td>\n'
		+ '\t<td class="' + row + '" rowspan="2" style="text-align: center; cursor: pointer" onclick="window.open(&quot;?action=pandore&id=' + donnees2[i][0] + '&quot;,&quot;_self&quot;)" title ="<?php echo $lang['pandore_click']?>">' + donnees2[i][12] + '</td>\n'
		+ '\t<td class="' + row + '" rowspan="2" style="text-align: center; cursor: pointer" onclick="window.open(&quot;?action=pandore&id=' + donnees2[i][0] + '&quot;,&quot;_self&quot;)" title ="<?php echo $lang['pandore_click']?>">' + donnees2[i][13] + '</td>\n'
		+ '</tr>\n<tr>\n'
		+ '\t<td class="' + row + '" style="text-align: center; cursor: pointer" onclick="window.open(&quot;?action=pandore&id=' + donnees2[i][0] + '&quot;,&quot;_self&quot;)" title ="<?php echo $lang['pandore_click']?>">' + format(donnees2[i][3]) + '</td>\n'
		+ '\t<td class="' + row + '" style="text-align: center; cursor: pointer" onclick="window.open(&quot;?action=pandore&id=' + donnees2[i][0] + '&quot;,&quot;_self&quot;)" title ="<?php echo $lang['pandore_click']?>">' + format(donnees2[i][5]) + '</td>\n'
		+ '\t<td class="' + row + '" style="text-align: center; cursor: pointer" onclick="window.open(&quot;?action=pandore&id=' + donnees2[i][0] + '&quot;,&quot;_self&quot;)" title ="<?php echo $lang['pandore_click']?>">' + format(donnees2[i][7]) + '</td>\n'
		+ '</tr>\n';
		if (row == 'b') row = 'f';
		else row = 'b';
	}
} else ligne += '<tr><td></td><th rowspan="2" colspan="8" style="text-align: center"><?php echo $lang['pandore_no_records'];?></th></tr>';

if (donnees2.length > 1) ligne += '<tr>\n\t<td colspan="9"><a onclick="javascript: selection (1)" style="cursor: pointer"><?php echo $lang['pandore_select_all'];?></a>&nbsp;/&nbsp;<a onclick="javascript: selection (0)" style="cursor: pointer"><?php echo $lang['pandore_unselect_all'];?></a></td>\n</tr>\n';
ligne += '<tr>\n\t<td></td>\n\t<td colspan="2" style="text-align: center';
if (page_actuelle > 0) ligne += '; cursor: pointer" class="c" onclick="javascript: nextpage (-1)"><a style="display: block"><<<</a';
else ligne += '"';
ligne += '></td>\n\t<td style="text-align: center" colspan="4">\n';
if (donnees2.length > taille_page) {
	text_temp = text_page.replace('chaine2', Math.ceil(donnees2.length / taille_page));
	ligne += '\t\t<select id ="page" onChange="javascript: menu_page ()">\n';
	for (i=0; i<Math.ceil(donnees2.length/taille_page); i++) {
		text = text_temp.replace('chaine1', i + 1);
		ligne += '\t\t\t<option value="' + i + '"';
		if (page_actuelle == i) ligne += 'selected="selected"';
		ligne += '>' + text + '</option>\n';
	}
	ligne += '\t\t</select>\n';
}
ligne += '\t</td>\n\t<td></td>\n\t<td colspan="2" style="text-align: center';
if (donnees2.length > taille_page * (page_actuelle + 1)) ligne += '; cursor: pointer" class="c" onclick="javascript: nextpage (1)" style=""><a style="display: block">>>></a';
else ligne += '"';
ligne += '></td>\n</tr>\n';

// Affichage des valeurs
document.getElementById('ligne').innerHTML = ligne + '</table>\n';
}

// Touner une page
function nextpage (a) {
affichage (page_actuelle + a);
}

// Changement de page
function menu_page () {
affichage (parseFloat(document.getElementById('page').value));
}

// Sélection-désélection
function selection (sel) {
if (sel == 0) sel = false;
else sel = true;
for (i = taille_page * page_actuelle; i < Math.min(donnees2.length, taille_page * (page_actuelle + 1)); i++) {
	if (user_name == donnees2[i][12] || user_admin > 0) document.getElementById(i).checked = sel;
}
}

// Recherche d'un nom
function search () {
donnees2 = donnees1.sort(tri_date);
nom = document.getElementById('pandoresearch').value;
if (nom != '') {
	donnees2.sort(tri_nom);
	i=0;
	while (i < donnees2.length) {
		if (donnees2[i][1] != nom) break;
		i++;
	}
	donnees2 = donnees2.slice(0, i);
}
affichage(page_actuelle);
}

// Tri par nom pour recherche
function tri_nom (a,b) {
if (a[1] == b[1]) return 0;
else if (a[1] == nom) return -1;
else if (b[1] == nom) return 1;
else return 0;
}

// Tri par date pour recherche
function tri_date (a,b) {
return b[0]-a[0];
}

// Affichage des ses enregistrements
function mine () {
donnees1 = donnees.sort(tri_date);
if (document.getElementById('mine').checked) {
	donnees1.sort(tri_user);
	i=0;
	while (i < donnees1.length) {
		if (donnees1[i][12] != user_name) break;
		i++;
	}
	donnees1 = donnees1.slice(0, i);
}
search();
}

// Tri par user pour affichage des ses enregistrements
function tri_user (a,b) {
if (a[12] == b[12]) return 0;
else if (a[12] == user_name) return -1;
else if (b[12] == user_name) return 1;
else return 0;
}

// Mise en forme des nombres
function format (x) {
var signe = '';
if (x < 0) {
	x = Math.abs(x);
	signe = '-';
}
var str = x.toString(), n = str.length;
if (n < 4) return (signe + x);
else return (signe + ((n % 3) ? str.substr(0, n % 3) + '&nbsp;' : '')) + str.substr(n % 3).match(new RegExp('[0-9]{3}', 'g')).join('&nbsp;');
}

// Lancement du script au chargement de la page
window.onload = function () {Biper(); affichage(0);}
</script>

<?php echo $lang['pandore_player_search'];?>&nbsp;<input type='text' id='pandoresearch' size='14' maxlength='20' onblur='javascript: search ()' />
<br /><br />
<label><input type='checkbox' id='mine' onclick='javascript: mine ()' />&nbsp;<span style="cursor: pointer"><?php echo $lang['pandore_mine'];?></span></label>
<br /><br />
<form action='./?action=pandore&page=enregistrements' method='post'>
	<span id='ligne'></span>
	<br />
	<input type='submit' value="<?php echo $lang['pandore_erase'];?>" />
</form>
<br />


<?php
/** $Id$ **/
/**
* page Principale
* @package varAlly
* @author Aeris
* @link http://ogsteam.fr
* @version 1.0.0
*/

if (!defined('IN_SPYOGAME')) {
	exit('Hacking attempt');
}

$sql = 'SELECT value FROM '. TABLE_MOD_CFG .' WHERE config = \'tagAlly\'';
$result = $db->sql_query($sql);
list($tag) = $db->sql_fetch_row($result);

check_tag($tag);
$listTag = explode(';', $tag);

$dateMin = $dateMax = '';

// If Truc débile pour initialiser les champs
if (!isset($pub_dateMin)) {
	$query = 'SELECT DISTINCT datadate FROM '. TABLE_VARALLY .' ORDER BY datadate ASC';
	$result = $db->sql_query($query);
	list($pub_dateMin) = $db->sql_fetch_row($result);
	$pub_dateMin = date('d/m/Y H:i:s', $pub_dateMin);
}

if (!isset($pub_dateMax)) { 
	$query = 'SELECT DISTINCT datadate FROM '. TABLE_VARALLY .' ORDER BY datadate DESC';
	$result = $db->sql_query($query);
	list($pub_dateMax) = $db->sql_fetch_row($result);
	$pub_dateMax = date('d/m/Y H:i:s', $pub_dateMax);
}

$query = 'SELECT DISTINCT datadate FROM '. TABLE_VARALLY .' ORDER BY datadate DESC';
$result = $db->sql_query($query);

while (list($date) = $db->sql_fetch_row($result))
{
	$dateMin .= '<option'. ((date('d/m/Y H:i:s', $date) == $pub_dateMin) ? ' selected' : '') .'>'. date('d/m/Y H:i:s', $date). '</option>';
	$dateMax .= '<option'. ((date('d/m/Y H:i:s', $date) == $pub_dateMax) ? ' selected' : '') .'>'. date('d/m/Y H:i:s', $date). '</option>';
}
?>
<form method='post' action='?action=varAlly&amp;subaction=ally'>
Date min: <select name='dateMin'><?php echo $dateMin; ?></select>&nbsp;-&nbsp;
Date max: <select name='dateMax'><?php echo $dateMax; ?></select>&nbsp;
<input type='submit' value='Afficher'>
</form>
<?php

if ($tag == '')
{
	echo '<table width=\'100%\'><tr><td class=\'c\'>Pas d\'alliance sélectionnée</th></tr></table></br>';
} else {
	$whereDate = '';
	if (isset($pub_dateMin) && isset($pub_dateMax))
	{
		$dateMinStamped = parseDate($pub_dateMin);
		$dateMaxStamped = parseDate($pub_dateMax);
		if ($dateMinStamped <= $dateMaxStamped)
		{
			$whereDate = ' AND `datadate`>=\''.$dateMinStamped.'\' AND `datadate`<=\''.$dateMaxStamped.'\'';
		} else {
			die ('Dates incorrectes: Merci de sélectionner deux dates cohérentes');
		}
	}
	foreach ($listTag as $tag)
	{
		$tblecart = array();
		
		$sql = 'SELECT DISTINCT `datadate` FROM `'.TABLE_VARALLY.'` WHERE `ally`=\''.mysql_real_escape_string($tag).'\''.$whereDate.' ORDER BY `datadate` DESC LIMIT 2';
		$result = $db->sql_query($sql);
		$nb = $db->sql_numrows($result);
		
		switch ($nb)
		{
			case '0':
				$evolution = 'Classement inconnu';
				$where = '';
				break;
			
			case '1':
				list($new) = $db->sql_fetch_row($result);
				$evolution = 'Classement du '. date('d/m/Y H:i:s', $new);
				$where = ' AND datadate = \''. $new .'\' ';
				break;
			
			case '2':
				list($new) = $db->sql_fetch_row($result);
				list($ex) = $db->sql_fetch_row($result);
				$evolution = 'Evolution entre le '. (isset($pub_dateMin) ? $pub_dateMin : date('d/m/Y H:i:s', $ex)) .' et le '. (isset($pub_dateMax) ? $pub_dateMax : date('d/m/Y H:i:s', $new));
				$where = ' AND (datadate = \''. $new .'\' OR datadate = \''. $ex .'\') ';
				break;
		}
		
		$query = 'SELECT DISTINCT `player` FROM `'.TABLE_VARALLY.'` WHERE `ally`=\''.mysql_real_escape_string($tag).'\''.$where.' ORDER BY `points` DESC';
		$result = $db->sql_query($query);

?>
		<h2>Alliance [<?php echo $tag; ?>]</h2>
		<table width='100%'>
			<tr>
				<td class='c' colspan='7'><?php echo $evolution; ?></td>
			</tr>
			<tr>
				<td class='c'>Joueur</td>
				<td class='c'>Écart général</td>
				<td class='c'>%</td>
			</tr>		
<?php
		while ($val = $db->sql_fetch_assoc($result))
		{
			$player = $val['player'];
			echo '<tr><th>'.$player.'</th>';
			affPoints($player, $whereDate);
			echo '</tr>';
		}
?>
		</table><br><br />
<?php
$sql = 'SELECT `value` FROM `'.TABLE_MOD_CFG.'` WHERE `config`=\'bilAlly\'';
$result = $db->sql_query($sql);
list($bilSpy)=$db->sql_fetch_row($result);

if ($bilSpy =="oui") {
	
?>
<h2>Bilan entre les deux dates choisies :</h2>

<?php
// Récupération du nombre de joueur par défaut
$sql = "SELECT value FROM ".TABLE_MOD_CFG." WHERE config='nbrjoueur'";
$result = $db->sql_query($sql);
list($nbrjou)=$db->sql_fetch_row($result);
?>

<style type="text/css" media="screen">
	.varally-label {
		display: block;
		float: left;
		width: 180px;
	}
	
	input[type="text"] {
		text-align: right;
	}
</style>

<form method='post' action='?action=varAlly&amp;subaction=ally#bilanJ<?php echo $tag ?>' name="bilanJ<?php echo $tag ?>" id="bilanJ<?php echo $tag ?>">
	<fieldset>
		Nombre de joueurs à afficher pour (<em>-1 pour tout afficher, 0 pour ne pas afficher</em>)<br /><br />
	
		<label class="varally-label">Tous les membres</label>
		<input type="text" size="3" name="membr<?php echo $tag ?>" value="<?php if (isset(${'pub_membr'.$tag})) echo ${'pub_membr'.$tag}; else echo '-1';?>" /><br />
	
		<label class="varally-label">Les plus fortes évolutions</label>
		<input type="text" size="3" name="evol<?php echo $tag ?>" value="<?php if (isset(${'pub_evol'.$tag})) echo ${'pub_evol'.$tag}; else echo $nbrjou;?>" /><br />
	
		<label class="varally-label">Les plus gros gains de points</label>
		<input type="text" size="3" name="pointsplus<?php echo $tag ?>" value="<?php if (isset(${'pub_pointsplus'.$tag})) echo ${'pub_pointsplus'.$tag}; else echo $nbrjou;?>" /><br />
	
		<label class="varally-label">Les chutes</label>
		<input type="text" size="3" name="chute<?php echo $tag ?>" value="<?php if (isset(${'pub_chute'.$tag})) echo ${'pub_chute'.$tag}; else echo '-1';?>" /><br />
	
		<label class="varally-label">Les plus faible gains de points</label>
		<input type="text" size="3" name="pointsmoins<?php echo $tag ?>" value="<?php if (isset(${'pub_pointsmoins'.$tag})) echo ${'pub_pointsmoins'.$tag}; else echo $nbrjou;?>" /><br />
	
		<label class="varally-label">Hauteur du champs du bilan</label>
		<input type="text" size="3" name="tarea<?php echo $tag ?>" value="<?php if (isset(${'pub_tarea'.$tag})) echo ${'pub_tarea'.$tag}; else echo '20';?>" /><br />
	
		<input type="hidden" name='dateMin' value="<?php echo isset($pub_dateMin) ? $pub_dateMin : $ex; ?>" />
		<input type="hidden" name='dateMax' value="<?php echo isset($pub_dateMin) ? $pub_dateMax : $new; ?>" />
		<input type='submit' value='Afficher' />
	</fieldset>
</form>

<?php

// Réinitialisation des variables dans le cas où l'on l'a déjà fait pour une autre alliance avant (ca créé un bug si elle avait moins de membre)
$pts = array();
$prc = array();
$new = array();

foreach ($tblecart as $key => $row) {
    $pts[$key] = $row['pts'];
    $prc[$key] = $row['prc'];
	$new[$key] = $row['new'];
}

if (!isset(${'pub_tarea'.$tag})) {
	${'pub_tarea'.$tag} = 20;
}

?>

<textarea rows="<?php echo ${'pub_tarea'.$tag}; ?>">
Évolution entre le [b]<?php echo isset($pub_dateMin) ? $pub_dateMin : date('d/m/Y H:i:s', $ex) ?>[/b] et le [b]<?php echo isset($pub_dateMax) ? $pub_dateMax : date('d/m/Y H:i:s',$new) ?> [<?php echo $tag; ?>][/b]

<?php

$nb_membres = count($tblecart);

/* Tous les membres */

@array_multisort($new, SORT_DESC, SORT_NUMERIC, $pts, $prc, $tblecart);

if (!isset(${'pub_membr'.$tag}) || ${'pub_membr'.$tag} == -1 || ${'pub_membr'.$tag} > $nb_membres) {
	${'pub_membr'.$tag} = $nb_membres;
}

if (${'pub_membr'. $tag} > 0) {
	
	echo '[u]Tous les membres :[/u][list=1]'."\n";
	$nbr = 0;
	
	for ($a = 0; $a < ${'pub_membr'. $tag}; $a++) {
		echo '[*] [b]'. $tblecart[$a]['joueur'] .'[/b] avec '. formate_number($tblecart[$a]['ex']) .' -> '. formate_number($tblecart[$a]['new']) .' soit [color=#FF9900]'. sign($tblecart[$a]['pts']) . formate_number($tblecart[$a]['pts']) .' points[/color] ([color=#FF9900]'. sign($tblecart[$a]['prc']) . formate_number($tblecart[$a]['prc'], 2) .'%[/color])'."\n";
	}
	
	echo '[/list]'."\n\n";
}

/* Plus fortes evolutions */

@array_multisort($prc, SORT_DESC, SORT_NUMERIC, $pts, SORT_DESC, SORT_NUMERIC, $new, $tblecart);

if (!isset(${'pub_evol'.$tag}) || ${'pub_evol'.$tag} == -1 || ${'pub_evol'.$tag} > $nb_membres) {
	${'pub_evol'.$tag} = $nb_membres;
}

if (${'pub_evol'.$tag} > 0) {
	echo '[u]Les '.${'pub_evol'.$tag}.' plus fortes évolutions :[/u][list=1]'."\n";
	
	for ($a = 0; $a < ${'pub_evol'.$tag}; $a++) {
		echo '[*] [b]'. $tblecart[$a]['joueur'] .'[/b] avec [color=#008000]'. sign($tblecart[$a]['pts']) . formate_number($tblecart[$a]['pts']) .' points[/color] soit [color=#008000]'. sign($tblecart[$a]['prc']) . formate_number($tblecart[$a]['prc'], 2) .'%[/color]'."\n";
	}
	
	echo '[/list]'."\n\n";
}

/* Plus gros gains de points */

@array_multisort($pts, SORT_DESC, SORT_NUMERIC, $prc, SORT_DESC, SORT_NUMERIC, $new, $tblecart);

if (!isset(${'pub_pointsplus'.$tag}) || ${'pub_pointsplus'.$tag} == -1 || ${'pub_pointsplus'.$tag} > $nb_membres) {
	${'pub_pointsplus'.$tag} = $nb_membres;
}

if (${'pub_pointsplus'.$tag} > 0) {
	echo '[u]Les '.${'pub_pointsplus'.$tag}.' plus gros gains de points : [/u][list=1]'."\n";
	
	for ($b = 0; $b < ${'pub_pointsplus'.$tag}; $b++) {
		echo "[*] [b]". $tblecart[$b]['joueur'] ."[/b] avec [color=#008000]". sign($tblecart[$b]['prc']) . formate_number($tblecart[$b]['prc'], 2) ."%[/color] soit [color=#008000]". sign($tblecart[$b]['pts']) . formate_number($tblecart[$b]['pts']) ." points[/color]\n";
	}
	
	echo '[/list]'."\n\n";
}

/* Chutes */

@array_multisort($prc, SORT_ASC, SORT_NUMERIC, $pts, SORT_ASC, SORT_NUMERIC, $new, $tblecart);

if (!isset(${'pub_chute'.$tag}) || ${'pub_chute'.$tag} == -1 || ${'pub_chute'.$tag} > $nb_membres) {
	${'pub_chute'.$tag} = $nb_membres;
}

if (${'pub_chute'.$tag} > 0) {
	
	echo '[u]Les chutes :[/u][list=1]'."\n";
	$nbr = 0;
	
	for ($c = 0; $c < ${'pub_chute'.$tag}; $c++) {
		$infc = $tblecart[$c]['pts'];
		
		if (strstr($infc, '-')) {
			echo "[*] [b]". $tblecart[$c]['joueur']."[/b] avec [color=#FF0000]". formate_number($tblecart[$c]['pts']) ." points[/color] soit [color=#FF0000]". formate_number($tblecart[$c]['prc'], 2) ."%[/color]\n";
			$nbr++;
		}
	}
	
	if ($nbr < 1) {
		echo "[b]Personne n'a chuté[/b]";    
	}
	
	echo '[/list]'."\n\n";
}

/* Plus faibles gains de points */

@array_multisort($pts, SORT_ASC, SORT_NUMERIC, $prc, $new, SORT_ASC, SORT_NUMERIC, $tblecart);

if (!isset(${'pub_pointsmoins'.$tag}) || ${'pub_pointsmoins'.$tag} == -1 || ${'pub_pointsmoins'.$tag} > $nb_membres) {
	${'pub_pointsmoins'.$tag} = $nb_membres;
}

if (${'pub_pointsmoins'.$tag} > 0) {
	echo '[u]Les plus faibles gains de points (faut se reveiller là !!!) : [/u][list=1]'."\n";
	
	for ($d = 0; $d < ${'pub_pointsmoins'.$tag}; $d++) {
		
		$infd = (integer) $tblecart[$d]['pts'];
		
		if (!strstr($infd,'-')) {
			echo "[*] [b]". $tblecart[$d]['joueur'] ."[/b] avec [color=#808000]+". formate_number($tblecart[$d]['prc'], 2) ."%[/color] soit [color=#808000]+". formate_number($tblecart[$d]['pts']) ." points[/color]\n";
		}
		else {
			${'pub_pointsmoins'.$tag}--;
		}
	}
	
	echo '[/list]';
}
?>
</textarea>

<?php
$tblecart = array_fill(0, count($tblecart),'');
}
    }
}
?>

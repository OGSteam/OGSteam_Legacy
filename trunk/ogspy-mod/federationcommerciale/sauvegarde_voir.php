<?php
$id=$_POST['id'];

	//on récupère les donnés sur la vente
	global $db;

	define("TABLE_FEDERATION_COMMERCIAL_VENTE", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."federation_commercial_vente");
	define("TABLE_FEDERATION_COMMERCIAL_PARTICIPANTS", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."federation_commercial_participants");
	
	$query = 'SELECT `nb_vendeur`, `nb_acheteur`, `m_taux`, `c_taux`, `d_taux`, `date` FROM `'.TABLE_FEDERATION_COMMERCIAL_VENTE.'` WHERE `id`=\''.$id.'\'';
	$result = $db->sql_query($query);
	if (!$db->sql_numrows($result)) die('Hacking attempt');
	list($nb_vendeur, $nb_acheteur, $M_taux, $C_taux, $D_taux, $date) = $db->sql_fetch_row($result);

	//on récupère les données sur les participants
	$query = 'SELECT `pseudo`, `metal`, `cristal`, `deuterium`, `rang`, `groupe` FROM `'.TABLE_FEDERATION_COMMERCIAL_PARTICIPANTS.'` WHERE `vente_id`=\''.$id.'\'';
	$result = $db->sql_query($query);
	if (!$db->sql_numrows($result)) die('Hacking attempt');
	while(list($pseudo, $metal, $cristal, $deuterium, $rang, $groupe) = $db->sql_fetch_row($result)){
		if ($groupe==1){
			$pseudo_vendeur[$rang]=$pseudo;
			$metal_vendeur[$rang]=$metal;
			$cristal_vendeur[$rang]=$cristal;
			$deuterium_vendeur[$rang]=$deuterium;
		}
		elseif ($groupe==2){
			$pseudo_acheteur[$rang]=$pseudo;
			$metal_acheteur[$rang]=$metal;
			$cristal_acheteur[$rang]=$cristal;
			$deuterium_acheteur[$rang]=$deuterium;
		}
	}
	
	//on calcule les résultat grace a la fonction aproprier
	$valeur_vendeur=qt_ressource1_merge($metal_vendeur,$cristal_vendeur,$deuterium_vendeur,$M_taux,$C_taux,$D_taux,$nb_vendeur);
	$valeur_acheteur=qt_ressource1_merge($metal_acheteur,$cristal_acheteur,$deuterium_acheteur,$M_taux,$C_taux,$D_taux,$nb_acheteur);

	$qt_ressource_vendeur=qt_ressource1($nb_vendeur,$nb_acheteur,$valeur_vendeur,$valeur_acheteur);
	$qt_ressource_acheteur=qt_ressource1($nb_acheteur,$nb_vendeur,$valeur_acheteur, $valeur_vendeur);

	$M_vendeur=qt_ressource1_devide($metal_acheteur,$cristal_acheteur,$deuterium_acheteur,$qt_ressource_vendeur,$M_taux,$C_taux,$D_taux,$nb_vendeur,$nb_acheteur);
	$C_vendeur=qt_ressource1_devide($cristal_acheteur,$metal_acheteur,$deuterium_acheteur,$qt_ressource_vendeur,$C_taux,$M_taux,$D_taux,$nb_vendeur,$nb_acheteur);
	$D_vendeur=qt_ressource1_devide($deuterium_acheteur,$cristal_acheteur,$metal_acheteur,$qt_ressource_vendeur,$D_taux,$C_taux,$M_taux,$nb_vendeur,$nb_acheteur);
	
	$M_acheteur=qt_ressource1_devide($metal_vendeur,$cristal_vendeur,$deuterium_vendeur,$qt_ressource_acheteur,$M_taux,$C_taux,$D_taux,$nb_acheteur,$nb_vendeur);
	$C_acheteur=qt_ressource1_devide($cristal_vendeur,$metal_vendeur,$deuterium_vendeur,$qt_ressource_acheteur,$C_taux,$M_taux,$D_taux,$nb_acheteur,$nb_vendeur);
	$D_acheteur=qt_ressource1_devide($deuterium_vendeur,$cristal_vendeur,$metal_vendeur,$qt_ressource_acheteur,$D_taux,$C_taux,$M_taux,$nb_acheteur,$nb_vendeur);
	
//on trouve le total acheter
for ($i=1 ; $i<=$nb_vendeur ; $i++) {
	$total_metal_vendeur = $total_metal_vendeur+$metal_vendeur[$i];
	$total_cristal_vendeur = $total_cristal_vendeur+$cristal_vendeur[$i];
	$total_deuterium_vendeur = $total_deuterium_vendeur+$deuterium_vendeur[$i];
}
for ($i=1 ; $i<=$nb_acheteur ; $i++) {
	$total_metal_acheteur = $total_metal_acheteur+$metal_acheteur[$i];
	$total_cristal_acheteur = $total_cristal_acheteur+$cristal_acheteur[$i];
	$total_deuterium_acheteur = $total_deuterium_acheteur+$deuterium_acheteur[$i];
}
$total_metal=$total_metal_vendeur+$total_metal_acheteur;
$total_cristal=$total_cristal_vendeur+$total_cristal_acheteur;
$total_deuterium=$total_deuterium_vendeur+$total_deuterium_acheteur;
$total=$total_metal+$total_cristal+$total_deuterium;

for ($i=1 ; $i<=$nb_vendeur ; $i++) {
	$total_M_vendeur = $total_M_vendeur+$M_vendeur[$i];
	$total_C_vendeur = $total_C_vendeur+$C_vendeur[$i];
	$total_D_vendeur = $total_D_vendeur+$D_vendeur[$i];
}
for ($i=1 ; $i<=$nb_acheteur ; $i++) {
	$total_M_acheteur = $total_M_acheteur+$M_acheteur[$i];
	$total_C_acheteur = $total_C_acheteur+$C_acheteur[$i];
	$total_D_acheteur = $total_D_acheteur+$D_acheteur[$i];
}
$total_M=$total_metal_vendeur+$total_metal_acheteur;
$total_C=$total_cristal_vendeur+$total_cristal_acheteur;
$total_D=$total_deuterium_vendeur+$total_deuterium_acheteur;
$total_ressu=$total_M+$total_C+$total_D;

//maintenant on fait des statistique sur la participation de chacun
for ($i=1 ; $i<=$nb_vendeur ; $i++) {
	if($total_metal_vendeur>0){
		$pourcentage_metal_vendeur[$i]=$metal_vendeur[$i]/$total_metal_vendeur*100;
	}
	else{
		$pourcentage_metal_vendeur[$i]=0;
	}
	if($total_cristal_vendeur>0){
		$pourcentage_cristal_vendeur[$i]=$cristal_vendeur[$i]/$total_cristal_vendeur*100;
	}
	else{
		$pourcentage_cristal_vendeur[$i]=0;
	}
	if($total_deuterium_vendeur>0){
		$pourcentage_deuterium_vendeur[$i]=$deuterium_vendeur[$i]/$total_deuterium_vendeur*100;
	}
	else{
		$pourcentage_deuterium_vendeur[$i]=0;
	}
}
for ($i=1 ; $i<=$nb_acheteur ; $i++) {
	if($total_metal_acheteur>0){
		$pourcentage_metal_acheteur[$i]=$metal_acheteur[$i]/$total_metal_acheteur*100;
	}
	else{
		$pourcentage_metal_acheteur[$i]=0;
	}
	if($total_cristal_acheteur>0){
		$pourcentage_cristal_acheteur[$i]=$cristal_acheteur[$i]/$total_cristal_acheteur*100;
	}
	else{
		$pourcentage_cristal_acheteur[$i]=0;
	}
	if($total_deuterium_acheteur>0){
		$pourcentage_deuterium_acheteur[$i]=$deuterium_acheteur[$i]/$total_deuterium_acheteur*100;
	}
	else{
		$pourcentage_deuterium_acheteur[$i]=0;
	}
}

for ($i=1 ; $i<=$nb_vendeur ; $i++) {
	if($total_M_vendeur>0){
		$pourcentage_M_vendeur[$i]=$M_vendeur[$i]/$total_M_vendeur*100;
	}
	else{
		$pourcentage_metal_vendeur[$i]=0;
	}
	if($total_C_vendeur>0){
		$pourcentage_C_vendeur[$i]=$C_vendeur[$i]/$total_C_vendeur*100;
	}
	else{
		$pourcentage_C_vendeur[$i]=0;
	}
	if($total_D_vendeur>0){
		$pourcentage_D_vendeur[$i]=$D_vendeur[$i]/$total_D_vendeur*100;
	}
	else{
		$pourcentage_D_vendeur[$i]=0;
	}
}
for ($i=1 ; $i<=$nb_acheteur ; $i++) {
	if($total_M_acheteur>0){
		$pourcentage_M_acheteur[$i]=$M_acheteur[$i]/$total_M_acheteur*100;
	}
	else{
		$pourcentage_M_acheteur[$i]=0;
	}
	if($total_C_acheteur>0){
		$pourcentage_C_acheteur[$i]=$C_acheteur[$i]/$total_C_acheteur*100;
	}
	else{
		$pourcentage_C_acheteur[$i]=0;
	}
	if($total_D_acheteur>0){
		$pourcentage_D_acheteur[$i]=$D_acheteur[$i]/$total_D_acheteur*100;
	}
	else{
		$pourcentage_D_acheteur[$i]=0;
	}
}
//on fait le pourcentage de chaque ressources dans le total
$pourcentage_metal_total=$total_metal/$total*100;
$pourcentage_cristal_total=$total_cristal/$total*100;
$pourcentage_deuterium_total=$total_deuterium/$total*100;

//on fait le pourcentage de chaque ressources dans le total
$pourcentage_M_total=$total_metal/$total_ressu*100;
$pourcentage_C_total=$total_cristal/$total_ressu*100;
$pourcentage_D_total=$total_deuterium/$total_ressu*100;
//maintenant on devrais avoir tout ce qu'il faut pour refaire le tableau du convertisseur, mais on vas éventuellement rajouter quelques petites choses

//on afiche le tableau des résultats
echo'<table width="70%">';
echo'<tr>';
echo'<th>Échange du ';
echo date('d/m/Y', $date);
echo' à ';
echo date('H\h i\m\i\n', $date);
echo'</th>';
echo'</tr>';
echo'<tr>';
echo'<td>';
//tableau de l'échange
echo'<table width="100%">';
echo'<tr>';
echo'<td class="c" colspan="7">Résultat</td>';
echo'</tr> <tr>';
echo'<th rowspan="2">Pseudo</th>';
echo'<th colspan="3">Quantiter de ressources envoyer</th>';
echo'<th colspan="3">Quantiter de ressources à recevoir</th>';
echo'</tr> <tr>';
echo'<th>métal</th><th>Cristal</th><th>deutérium</th><th>métal</th><th>Cristal</th><th>deutérium</th>';
echo'</tr> <tr>';
for ($i=1 ; $i<=$nb_vendeur ; $i++) {
	echo'<th><font color="#00FF00">'.$pseudo_vendeur[$i].'</font></th>';
	echo'<th><font color="#00FF00">'.$metal_vendeur[$i].'</font></th>';
	echo'<th><font color="#00FF00">'.$cristal_vendeur[$i].'</font></th>';
	echo'<th><font color="#00FF00">'.$deuterium_vendeur[$i].'</font></th>';
	echo'<th><font color="#00FF00">'.round($M_vendeur[$i]).'</font></th>';
	echo'<th><font color="#00FF00">'.round($C_vendeur[$i]).'</font></th>';
	echo'<th><font color="#00FF00">'.round($D_vendeur[$i]).'</font></th>';
	echo'</tr> <tr>';
}
for ($i=1 ; $i<=$nb_acheteur ; $i++) {
	echo'<th><font color="#0000FF">'.$pseudo_acheteur[$i].'</font></th>';
	echo'<th><font color="#0000FF">'.$metal_acheteur[$i].'</font></th>';
	echo'<th><font color="#0000FF">'.$cristal_acheteur[$i].'</font></th>';
	echo'<th><font color="#0000FF">'.$deuterium_acheteur[$i].'</font></th>';
	echo'<th><font color="#0000FF">'.round($M_acheteur[$i]).'</font></th>';
	echo'<th><font color="#0000FF">'.round($C_acheteur[$i]).'</font></th>';
	echo'<th><font color="#0000FF">'.round($D_acheteur[$i]).'</font></th>';
	echo'</tr> <tr>';
}
echo'</table>';
echo'</td>';
echo'</tr> <tr>';
echo'<td>';
echo'<table width="100%">';
echo'<tr>';
echo'<td class="c" colspan="2">';
echo'Taux';
echo'</td>';
echo'</tr><tr>';
echo'<th>';
echo'Métal';
echo'</th>';
echo'<th>';
echo $M_taux;
echo'</th>';
echo'</tr> <tr>';
echo'<th>';
echo'Cristal';
echo'</th>';
echo'<th>';
echo $C_taux;
echo'</tr> <tr>';
echo'<th>';
echo'Deutérium';
echo'</th>';
echo'<th>';
echo $D_taux;
echo'</th>';
echo'</tr>';
echo'</table>';
echo'</td>';
echo'</tr>';
echo'<tr>';
echo'<td>';
echo'<table width="100%">';
echo'<tr>';
echo'<td class="c" colspan="7">Pourcentage</td>';
echo'</tr> <tr>';
echo'<th rowspan="2">Pseudo</th>';
echo'<th colspan="3">Quantiter de ressources envoyer</th>';
echo'<th colspan="3">Quantiter de ressources à recevoir</th>';
echo'</tr> <tr>';
echo'<th>métal</th><th>Cristal</th><th>deutérium</th><th>métal</th><th>Cristal</th><th>deutérium</th>';
echo'</tr> <tr>';
for ($i=1 ; $i<=$nb_vendeur ; $i++) {
	echo'<th><font color="#00FF00">'.$pseudo_vendeur[$i].'</th>';
	echo'<th><font color="#00FF00">'.round($pourcentage_metal_vendeur[$i]).'%</font></th>';
	echo'<th><font color="#00FF00">'.round($pourcentage_cristal_vendeur[$i]).'%</font></th>';
	echo'<th><font color="#00FF00">'.round($pourcentage_deuterium_vendeur[$i]).'%</font></th>';
	echo'<th><font color="#00FF00">'.round($pourcentage_M_vendeur[$i]).'%</font></th>';
	echo'<th><font color="#00FF00">'.round($pourcentage_C_vendeur[$i]).'%</font></th>';
	echo'<th><font color="#00FF00">'.round($pourcentage_D_vendeur[$i]).'%</font></th>';
	echo'</tr> <tr>';
}
for ($i=1 ; $i<=$nb_acheteur ; $i++) {
	echo'<th><font color="#0000FF">'.$pseudo_acheteur[$i].'</th>';
	echo'<th><font color="#0000FF">'.round($pourcentage_metal_acheteur[$i]).'%</font></th>';
	echo'<th><font color="#0000FF">'.round($pourcentage_cristal_acheteur[$i]).'%</font></th>';
	echo'<th><font color="#0000FF">'.round($pourcentage_deuterium_acheteur[$i]).'%</font></th>';
	echo'<th><font color="#0000FF">'.round($pourcentage_M_acheteur[$i]).'%</font></th>';
	echo'<th><font color="#0000FF">'.round($pourcentage_C_acheteur[$i]).'%</font></th>';
	echo'<th><font color="#0000FF">'.round($pourcentage_D_acheteur[$i]).'%</font></th>';
	echo'</tr> <tr>';
}
/*
echo'<th>Total</th>';
echo'<th>'.round($pourcentage_metal_total).'%</th>';
echo'<th>'.round($pourcentage_cristal_total).'%</th>';
echo'<th>'.round($pourcentage_deuterium_total).'%</th>';
echo'<th>'.round($M_acheteur[$i]).'</th>';
echo'<th>'.round($C_acheteur[$i]).'</th>';
echo'<th>'.round($D_acheteur[$i]).'</th>';
*/
echo'</tr>';
echo'</table>';
echo'</td>';
echo'</tr>';
echo'</table>';
?>
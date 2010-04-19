<?php




define('PUN_ROOT', './');
require PUN_ROOT . 'include/common.php';

// Load the index.php language file
require PUN_ROOT . 'lang/' . $pun_user['language'] . '/index.php';

///ogpt
$lien = "prod.php";
$page_title = "production";
require_once  PUN_ROOT . 'ogpt/include/ogpt.php';
/// fin ogpt


define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT . 'header.php';

$page_title = "production";


?>


<?php 


if ( $_GET['type']=="autonomie" )

{
	?>
	<div class="blockform"><h2><span> <a href="prod.php">Production</a> | <a href="prod.php">Galerie miniere</a> | Autonomie </span></h2><div class="box"><div class="infldset">
	<?php

///: autonomie

//Varriable a modifier si on est dans l'univers 50
$multiplier = 1;



//*Début calculs

// mines, hangars, productions, infos planètes
$user_building=mine_production_empire($user_data['user_id']);
//autonomie
$autonomieM=autonomie($user_building, 'M');
$autonomieC=autonomie($user_building, 'C');
$autonomieD=autonomie($user_building, 'D');
//ressources minimum
$ressourcesP=ressourcespetithangar($autonomieM,$autonomieC,$autonomieD,$user_building);
$ressourcesG=ressourcesgrandhangar($autonomieM,$autonomieC,$autonomieD,$user_building);
//transporteurs
$maxGT=transporteur($ressourcesG,"GT",$user_building);
$minGT=transporteur($ressourcesP,"GT",$user_building);
$maxPT=transporteur($ressourcesG,"PT",$user_building);
$minPT=transporteur($ressourcesP,"PT",$user_building);

//*Fin calculs

//On transforme les résultat en fonction du multiplicateur
if($multiplier>0){
	for ($i=1 ; $i<=9 ; $i++) {
		//autonomie
		$autonomieM[$i] = $autonomieM[$i] / $multiplier;
		$autonomieC[$i] = $autonomieC[$i] / $multiplier;
		$autonomieD[$i] = $autonomieD[$i] / $multiplier;
		//transporteurs
		$maxGT[$i] = $maxGT[$i]*$multiplier;
		$minGT[$i] = $minGT[$i]*$multiplier;
		$maxPT[$i] = $maxPT[$i]*$multiplier;
		$minPT[$i] = $minPT[$i]*$multiplier;
		//production des mines
		$user_building[$i]['M_hour']=$user_building[$i]['M_hour']*$multiplier;
		$user_building[$i]['C_hour']=$user_building[$i]['C_hour']*$multiplier;
		$user_building[$i]['D_hour']=$user_building[$i]['D_hour']*$multiplier;
	}
}


?>
<tr><th colspan="4">Calculateur du temps d'autonomie de votre empire</th></tr>
<tr>
<table>
<?php
//on initialise les variables
$planète_rouge=0;
$planète_jaune=0;
$planète_verte=0;
$somme_hangarM=0;
$somme_hangarC=0;
$somme_hangarD=0;
$maxempGT=0;
$minempGT=0;
$maxempPT=0;
$minempPT=0;
// la durée d'autonomie
$seuil_autonomie_courte=24;
$seuil_autonomie_longue=48;

for ($i=1 ; $i<=9 ; $i++) {
//	if ($coordinates[$i]!="&nbsp;"){
		// test planète existante
		if($user_building[$i][0] === TRUE){
		///////////////////////////////////////////////////////
		//*hangar à augmenter +autonomie planetairez
		if($autonomieD[$i]!= ''){
			if($autonomieM[$i]<$autonomieC[$i] and $autonomieM[$i]<$autonomieD[$i]){
				$petit_hangar= "Hangar de métal";
				$somme_hangarM= $somme_hangarM+1;
				$autoplanete=$autonomieM[$i];
			}
			elseif($autonomieC[$i]<$autonomieM[$i] and $autonomieC[$i]<$autonomieD[$i]){
				$petit_hangar= "Hangar de cristal";
				$somme_hangarC= $somme_hangarC+1;
				$autoplanete=$autonomieC[$i];
			}
			// on fait attention à la production de deuterium nulle (quand pas de synthétiseur)
			elseif($autonomieD[$i]<$autonomieM[$i] and $autonomieD[$i]<$autonomieC[$i]){
				$petit_hangar= "Réservoir de deutérium";
				$somme_hangarD= $somme_hangarD+1;
				$autoplanete=$autonomieD[$i];
			}
		}
		else{
			if($autonomieM[$i]<$autonomieC[$i]){
				$petit_hangar= "Hangar de métal";
				$somme_hangarM= $somme_hangarM+1;
				$autoplanete=$autonomieM[$i];
			}
			elseif($autonomieC[$i]<$autonomieM[$i]){
				$petit_hangar= "Hangar de cristal";
				$somme_hangarC= $somme_hangarC+1;
				$autoplanete=$autonomieC[$i];
			}
		}
		
		//*fin hangar à augmenter
		///////////////////////////////////////////////////////
		//*couleur hangar
		$rouge="#FF0000";
		$jaune="#333399";
		$verte="#006400";
		if ($autoplanete<=$seuil_autonomie_courte){
			$color=	$rouge;
			$planète_rouge=$planète_rouge+1;
		}
		elseif ($autoplanete<$seuil_autonomie_longue and $autoplanete>$seuil_autonomie_courte){
			$color=$jaune;
			$planète_jaune=$planète_jaune+1;
		}
		else{
			$color=	$verte;
			$planète_verte=$planète_verte+1;
		}
		//*fin couleur hangar
		///////////////////////////////////////////////////////
		//*Transporteurs de l'empire
		$minempPT+=$minPT[$i];
		$maxempPT+=$maxPT[$i];
		$minempGT+=$minGT[$i];
		$maxempGT+=$maxGT[$i];
		//*fin Transporteurs de l'empire
		///////////////////////////////////////////////////////

		//*Afichage des infos sur la planete
		echo'<tr><td rowspan="6" class="c"><center><b>'.$user_building[$i]['planet_name'].'</b><p style="margin-top: 0; margin-bottom: 0">'.$user_building[$i]['coordinates']."</p></center></td>\n";
		echo'<td></td>';
		echo'<th>Niveau de la mine</th>';
		echo'<th>Production par heure</th>';
		echo'<th>Niveau des hangars</th>';
		echo'<th>Capacité de vos hangars</th>';
		echo'<th>Temps d\'autonomie de la planète</th>';
		echo"</tr>\n<tr>";
		echo'<th>Métal</th>';
		echo'<td>'.$user_building[$i]['M'].'</td>';
		echo'<td>'.number($user_building[$i]['M_hour']).'</td>';
		echo'<td>'.$user_building[$i]['HM'].'</td>';
		echo'<td>'.number($user_building[$i]['HM_capacity']).' K</td>';
		if ($autonomieM[$i]<72) {echo '<td>'.$autonomieM[$i].' Heures</td>';} else {echo '<td title="'.$autonomieM[$i].' Heures">'.round(($autonomieM[$i])/24,1).' Jours</td>';}
		echo"</tr>\n<tr>";
		echo'<th>Cristal</th>';
		echo'<td>'.$user_building[$i]['C'].'</td>';
		echo'<td>'.number($user_building[$i]['C_hour']).'</td>';
		echo'<td>'.$user_building[$i]['HC'].'</td>';
		echo'<td>'.number($user_building[$i]['HC_capacity']).' K</td>';
		if ($autonomieC[$i]<72) {echo '<td>'.$autonomieC[$i].' Heures</td>';} else {echo '<td title="'.$autonomieC[$i].' Heures">'.round(($autonomieC[$i])/24,1).' Jours</td>';}
		echo"</tr>\n<tr>";
		echo'<th>Deutérium</th>';
		echo'<td>'.$user_building[$i]['D'].'</td>';
		echo'<td>'.number($user_building[$i]['D_hour']).'</td>';
		echo'<td>'.$user_building[$i]['HD'].'</td>';
		echo'<td>'.number($user_building[$i]['HD_capacity']).' K</td>';
		// on fait attention à la production de deuterium nulle (quand pas de synthétiseur)
		if ($autonomieD[$i]=='') {echo '<td title="infini !">-</td>';} elseif ($autonomieD[$i]<72) {echo '<td>'.$autonomieD[$i].' Heures</td>';} else {echo '<td title="'.$autonomieD[$i].' Heures">'.round(($autonomieD[$i])/24,1).' Jours</td>';}
		echo"</tr>\n\n<tr>";
		echo'<td colspan="6"rowspan="2">';
			echo'<table>';
			echo'<tr><th colspan="6">Transport</th>';
			echo"</tr>\n<tr>";
			echo'<th colspan="1" rowspan="2">Nb de transporteurs minimal pour vider la planète avant que le plus petit hangar soit plein (pour éviter les pertes)</th>';
			echo'<th>PT:</th>';
			echo'<th><b>'.$minPT[$i]."</b></th>\n";
			echo'<th colspan="1" rowspan="2">Nb de transporteurs minimal pour vider la planète avant que tous les hangars soient pleins</th>';
			echo'<th>PT:</th>';
			echo'<th><b>'.$maxPT[$i].'</b></th>';
			echo"</tr>\n<tr>";
			echo'<th>GT:</th>';
			echo'<th><b>'.$minGT[$i].'</b></th>';
			echo'<th>GT:</th>';
			echo'<th><b>'.$maxGT[$i].'</b></th>';
			echo"</tr>\n\n<tr>";
			echo'</table>';
			echo'<table width="100%">';
			echo'<tr><td class="c" width="70%">Pour augmenter l\'autonomie de cette planète, vous devriez améliorer votre <font color="'.$color.'"><b>'.$petit_hangar.'</b></font></td>';
			echo'<th width="30%"> Vous pouvez attendre <font color="'.$color.'"><b>'.$autoplanete.'</b> heures (<b>'.round(($autoplanete)/24,1).'</b> jours)</font> <br>avant de vider votre planète.</th></tr>';
			echo'</table>';
		echo'</td></tr>';
		echo"</tr>\n\n<tr>";//';
		//*Affichage des infos sur la planete
		///////////////////////////////////////////////////////
	}
}
echo'</table>';
///////////////////////////////////////////////////////
//*infos générales
echo'<table width="100%">';
echo'<tr><td class="c" colspan="6">Vue d\'ensemble</tr>';
echo'<tr><th colspan="6">Somme du nombre de transporteurs nécessaires à votre empire.</th></tr>';
echo'<tr>';
echo'<th rowspan="2">Pour vider toutes vos colonies avant que les plus petits hangars soit pleins</th>';
echo'<th>PT:</th><th><b>'.$minempPT.'</b></th>';
echo'<th rowspan="2">Pour vider toutes vos colonies lorsque tous les hangars sont pleins</th>';
echo'<th>PT:</th><th><b>'.$maxempPT.'</b></th>';
echo"</tr>
<tr>";
echo'<th>GT:</th><th><b>'.$minempGT.'</b></th>';
echo'<th>GT:</th><th><b>'.$maxempGT.'</b></th>';
echo"</tr>\n<tr>";
echo'<th colspan="6">Statistiques globales de votre empire.</th>';
echo"</tr>\n<tr>";
echo'<th colspan="2">Nombre de vos planètes ayant une autonomie nettement trop petite (- de <b>'.$seuil_autonomie_courte.'</b>h):</th><th><b>'.$planète_rouge.'</b></th>';
echo'<th colspan="2">Nombre de hangars de métal baissant l\'autonomie de sa planète:</th><th><b>'.$somme_hangarM.'</b></th>';
echo"</tr>\n<tr>";
echo'<th colspan="2">Nombre de vos planètes ayant une autonomie raisonnable (entre <b>'.$seuil_autonomie_courte.'</b> et <b>'.$seuil_autonomie_longue.'</b>h):</th><th><b>'.$planète_jaune.'</b></th>';
echo'<th colspan="2">Nombre de hangars de cristal baissant l\'autonomie de sa planète:</th><th><b>'.$somme_hangarC.'</b></th>';
echo"</tr>\n<tr>";
echo'<th colspan="2">Nombre de vos planètes ayant une très bonne autonomie (+ de <b>'.$seuil_autonomie_longue.'</b>h):</th><th><b>'.$planète_verte.'</b></th>';
echo'<th colspan="2">Nombre de réservoirs de deutérium baissant l\'autonomie de sa planète:</th><th><b>'.$somme_hangarD.'</b></th>';
echo"</tr>\n";
echo'</table>';
//*fin infos générales
///////////////////////////////////////////////////////
//*légende
?>

	<table width="31%" align="right">
	<tr>
		<th width="100%" height="50%">
		<font color="<?php echo ''.$verte.''; ?>">Legende = cette planète est autonome + de <?php echo $seuil_autonomie_longue; ?> heures.</font><br>
		<font color="<?php echo ''.$jaune.''; ?>">Legende = attention, cette planète est autonome entre <?php echo $seuil_autonomie_courte.' et '.$seuil_autonomie_longue; ?> heures.</font><br>
		<font color="<?php echo ''.$rouge.''; ?>">Legende = cette planète risque fort de vous faire perdre des ressources, car son autonomie est inférieure à <?php echo $seuil_autonomie_courte; ?>h.</font>
		</th>
	</tr>
</table>
</div></div></div>

<?php

}

















//////////////////////////////galerie/////////

else if ( $_GET['type']=="galerie" )

{
	?>
	<div class="blockform"><h2><span> <a href="prod.php">Production</a> | Galerie miniere | <a href="prod.php?type=autonomie">Autonomie</a> </span></h2><div class="box"><div class="infldset">
	<?php



?>

<?php
/// inspiré du mod hof


/// on va chercher les id utilisateur ...
	$test = 'SELECT distinct( user_id ) FROM '.$pun_config["ogspy_prefix"].'user_building';
$retest = $db->query($test);

	while ( $id	= $db->fetch_assoc($retest)   )
	{
	/// on met les compteurs a 0
		
		$prodMetal		= 0;
		$prodCristal	= 0;
		$prodDeut		= 0;
		$prodTotal		= 0;
		/// pondere : 2.3/1.3/1)
		$prodPond		= 0;
		
	//// on va selectionner  la techno energie
	$sql = 'SELECT NRJ FROM '.$pun_config["ogspy_prefix"].'user_technology WHERE user_id=\'' . $id['user_id'] . '\'';
$result = $db->query($sql);
while ($NRJ = $db->fetch_assoc($result)) {
    $NRJ = $NRJ['NRJ'];
}



	/// on selectionne les diferentes planetes du joueur
		$bat_users	= 'SELECT user_id, planet_id, temperature, Sat, M, C, D, CES, CEF, Sat_percentage, M_percentage, C_percentage, D_percentage, CES_percentage, CEF_percentage
			FROM '.$pun_config["ogspy_prefix"].'user_building WHERE user_id=\'' . $id['user_id'] . '\'';
			$bat_user = $db->query($bat_users);
		while ($users	= $db->fetch_assoc($bat_user)   )
	{		
		/* On verifie que ce n'est pas une lune */
		
			if ($users['planet_id'] >= 1 AND $users['planet_id'] <= 9)
			{
			
		
				
			
				/* ** Facteur de production = Energie produite / Energie nécessaire ** */
				
				/* Energie produite = CES + CEF + Sat */
				
				$cesProd		= ($users['CES_percentage'] / 100) * 20 * $users['CES'] * pow (1.1, $users['CES']);
				$cefProd		= ($users['CEF_percentage'] / 100) * 30 * $users['CEF'] * pow ((1.05 + $NRJ * 0.01), $users['CEF']);
				$satProd		= ($users['Sat_percentage'] / 100) * floor (($users['temperature'] / 4) + 20) * $users['Sat'];
				
				$prodEnergie	= $cesProd + $cefProd + $satProd;
				
				/* Energie nécessaire = Metal + Cristal + Deut */
				
				$metalConso		= ($users['M_percentage'] / 100) * 10 * $users['M'] * pow (1.1, $users['M']);
				$cristalConso	= ($users['C_percentage'] / 100) * 10 * $users['C'] * pow (1.1, $users['C']);
				$deutConso		= ($users['D_percentage'] / 100) * 20 * $users['D'] * pow (1.1, $users['D']);
				
				$consoEnergie	= $metalConso + $cristalConso + $deutConso;
				
				// Facteur de production
				
				if ($consoEnergie == 0)
					$prodFacteur = 1;
				else
					$prodFacteur	= $prodEnergie / $consoEnergie;
				
				if ($prodFacteur > 1)
					$prodFacteur = 1;
				
				/* ** Calcul des production horaire ** */
				// Consomation de deut par la CEF
				
				$cefConso		= ($users['CEF_percentage'] / 100) * 10 * $users['CEF'] * pow (1.1, $users['CEF']);
				
				$prodMetal		= floor ($prodMetal + 20 + $prodFacteur * ($users['M_percentage'] / 100) * (30 * $users['M'] * pow (1.1, $users['M'])));
				$prodCristal	= floor ($prodCristal + 10 + $prodFacteur * ($users['C_percentage'] / 100) * (20 * $users['C'] * pow (1.1, $users['C'])));
				$prodDeut		= floor ($prodDeut + $prodFacteur * ($users['D_percentage'] / 100) * (10 * $users['D'] * pow (1.1, $users['D']) * (-0.002 * $users['temperature'] + 1.28)) - $cefConso);
			
		
		$id_joueur=$users['user_id'];
		$prodTotal		= $prodMetal+ $prodCristal+ $prodDeut ;
		
		/// pondere : 2.3/1.3/1)
		$prodPond		= ($prodMetal+ ($prodCristal*1.3)+ ($prodDeut*2.3)) ;
		
			
		}
			
		}
		
	
		/// preparation du tableau 
				$production_joueur[$id_joueur]=userNameById($id_joueur);
				$production_metal[$id_joueur]=$prodMetal*24;
				$production_cristal[$id_joueur]=$prodCristal*24;
				$production_deuterium[$id_joueur]=$prodDeut*24;
				$production_total[$id_joueur]=$prodTotal*24;	
				$production_pondere[$id_joueur]=$prodPond*24;		
		

	}
			
			
?>			
	
 <table>

		<tr>
			
			<th class="c" colspan="2">Classement</th>
			<th class="c" colspan="2">joueur</th>
			<th class="c" colspan="2"><a href='prod.php?type=galerie'>metal</a></th>
			<th class="c" colspan="2"><a href='prod.php?type=galerie&amp;tri=c'>cristal</a></th>
			<th class="c" colspan="2"><a href='prod.php?type=galerie&amp;tri=d'>deuterium</a></th>
			<th class="c" colspan="2"><a href='prod.php?type=galerie&amp;tri=t'>total</a></th>
			<th class="c" colspan="2"><a href='prod.php?type=galerie&amp;tri=p'>pondere</a> ( 1=1.3=2.3 )</th>

		</tr>			

<?php
	
	/// choix du tri
		if (isset($_GET['tri']) && $_GET['tri'] == 'c')
		$tri = $production_cristal;
	else if (isset($_GET['tri']) && $_GET['tri'] == 'd')
		$tri = $production_deuterium;
			else if (isset($_GET['tri']) && $_GET['tri'] == 't')
		$tri = $production_total;
			else if (isset($_GET['tri']) && $_GET['tri'] == 'p')
		$tri = $production_pondere;
	else
		$tri = $production_metal;
	
	
	
	// tri
					arsort($tri);
					$nb = 1;
					
		foreach ($tri as $key => $val)
					{
						?>

						
						
						
						<tr>
							<td style='background-color : #273234;' colspan="2"><?php echo '<span style=\'color : white; font-weight : bold;\'>' . $nb . '</span>'; ?></td>
							
							<td style='background-color : #273234;'colspan="2"><?php echo '<span style=\'color : white; font-weight : bold;\'>' . $production_joueur[$key] . '</span>'; ?></td>
							
							<td style='background-color : #273234;' colspan="2"><font color='red'><b><?php echo number($production_metal[$key]); ?></b></font></td>
							
							<td style='background-color : #273234;' colspan="2"><font color='lightblue'><b><?php echo number($production_cristal[$key]); ?></b></font></td>
							
							<td style='background-color : #273234;' colspan="2"><font color='green'><b><?php echo number($production_deuterium[$key]); ?></b></font></td>
							
							<td style='background-color : #273234;' colspan="2"><b><font color='yellow'><?php echo number($production_total[$key]); ?></b></font></td>
							
							<td style='background-color : #273234;' colspan="2"><b><font color='pink'><?php echo number($production_pondere[$key]); ?></b></font></td>
						</tr>
							
						<?php
						$nb++;
					}				


?>


			
	</table>		
			
				
	<?php						
		
		
		
		




	







echo '</div></div></div>';




}
else {
?>





<?php
////////////////////////// production ///////////////////////



$sql = 'SELECT NRJ FROM '.$pun_config["ogspy_prefix"].'user_technology';
$result = $db->query($sql);
while ($NRJ = $db->fetch_assoc($result)) {
    $NRJ = $NRJ['NRJ'];
}




echo '<div class="blockform"><h2><span> Production| <a href="prod.php?type=galerie">Galerie miniere</a>| <a href="prod.php?type=autonomie">Autonomie</a> </span></h2><div class="box"><div class="infldset">';


echo '<table border="0" cellpadding="2" cellspacing="0" align="center"';


// recherche des planetes et batiments
$sql = 'SELECT * FROM ' . $pun_config["ogspy_prefix"] .
    'user_building where user_id =' . $pun_user['id_ogspy'] .
    ' and planet_id >= 1 and planet_id <= 9  ORDER BY planet_id asc';
$result = $db->query($sql);


while ($empire = $db->fetch_assoc($result)) {
    $i = $empire['planet_id'];

    $bat[$i][user_id] = $empire['user_id'];
    $bat[$i][planet_id] = $empire['planet_id'];
    $bat[$i][planet_name] = $empire['planet_name'];
    $bat[$i][coordinates] = $empire['coordinates'];
    $bat[$i][fields] = $empire['fields'];
    $bat[$i][temperature] = $empire['temperature'];
    $bat[$i][Sat] = $empire['Sat'];
    $bat[$i][Sat_percentage] = $empire['Sat_percentage'];
    $bat[$i][M] = $empire['M'];
    $bat[$i][M_percentage] = $empire['M_percentage'];
    $bat[$i][C] = $empire['C'];
    $bat[$i][C_Percentage] = $empire['C_Percentage'];
    $bat[$i][D] = $empire['D'];
    $bat[$i][D_percentage] = $empire['D_percentage'];
    $bat[$i][CES] = $empire['CES'];
    $bat[$i][CES_percentage] = $empire['CES_percentage'];
    $bat[$i][CEF] = $empire['CEF'];
    $bat[$i][CEF_percentage] = $empire['CEF_percentage'];
    $bat[$i][UdR] = $empire['UdR'];
    $bat[$i][UdN] = $empire['UdN'];
    $bat[$i][CSp] = $empire['CSp'];
    $bat[$i][HM] = $empire['HM'];
    $bat[$i][HC] = $empire['HC'];
    $bat[$i][HD] = $empire['HD'];
    $bat[$i][Lab] = $empire['Lab'];
    $bat[$i][Ter] = $empire['Ter'];
    $bat[$i][DdR] = $empire['DdR'];
    $bat[$i][Silo] = $empire['Silo'];
    $bat[$i][BaLu] = $empire['BaLu'];
    $bat[$i][Pha] = $empire['planet_id'];
    $bat[$i][PoSa] = $empire['PoSa'];
    ;
}

echo '<tr><th colspan="10"><b>Vue d\'ensemble de votre empire</b></th></tr> ';


///utilisation fonctio tableau pour creation ligne a ligne

//images de planete
$tableau = tableau_bis('planete', 'planet_id');
echo '' . $tableau . '';


//nom de planete
$tableau = tableau('Nom', 'planet_name');
echo '' . $tableau . '';

//nom de planete
$tableau = tableau('Coordonnée', 'coordinates');
echo '' . $tableau . '';


//temerature
$tableau = tableau('température', 'temperature');
echo '' . $tableau . '';


echo '<tr><th colspan="' . ($i + 1) . '"><b>Production par jour</b></th></tr> ';

//M

////////////////////////////////////////////////////////// ////////////
//prod M
$tableau = '<tr>';
$tableau .= ' <th>Mine de Métal</th>';
$j = 1;
while ($i >= $j) {
    $P_M[$j] = production_m($bat[$j][M]);
    $tableau .= '<td style="text-align:center;">' . convNumber(24 * $P_M[$j]) .
        '</td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
//////////////////////////////////////////////////////////////////
//prod C
$tableau = '<tr>';
$tableau .= ' <th>Mine de cristal</th>';
$j = 1;
while ($i >= $j) {
    $P_C[$j] = production_c($bat[$j][C]);
    $tableau .= '<td style="text-align:center;">' . convNumber(24 * $P_C[$j]) .
        '</td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
////////////////////////////////////////////////////////// ////////////
//////////////////////////////////////////////////////////////////
//prod D
$tableau = '<tr>';
$tableau .= ' <th>Mine de deut</th>';
$j = 1;
while ($i >= $j) {
    $P_D[$j] = production_d($bat[$j][D], $bat[$j][temperature]);
    $tableau .= '<td style="text-align:center;">' . convNumber(24 * $P_D[$j]) .
        '</td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
////////////////////////////////////////////////////////// ////////////

////Total Prod par heure
$j = 1;
$total_m = 0;
$total_c = 0;
$total_d = 0;

while ($i >= $j) {
    $total_m = $total_m + $P_M[$j];
    $total_c = $total_c + $P_C[$j];
    $total_d = $total_d + $P_D[$j];
    $j = $j + 1;

}


echo '<tr><th><b>total</b></th><td colspan="3">Métal : <b>' . convNumber((24 * $total_m)) .
    '</b></td><td colspan="3">Cristal : <b>' . convNumber(24 * $total_c) .
    '</b></td><td colspan="3">Deut : <b>' . convNumber(24 * $total_d) .
    '</b></td></tr> ';


echo '<tr><th colspan="' . ($i + 1) .
    '"><b>Production par semaine</b></th></tr> ';

////////////////////////////////////////////////////////// ////////////
//prod M
$tableau = '<tr>';
$tableau .= ' <th>Mine de Métal</th>';
$j = 1;
while ($i >= $j) {
    $P_M[$j] = production_m($bat[$j][M]);
    $tableau .= '<td style="text-align:center;">' . convNumber(24 * 7 * $P_M[$j]) .
        '</td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
//////////////////////////////////////////////////////////////////
//prod C
$tableau = '<tr>';
$tableau .= ' <th>Mine de cristal</th>';
$j = 1;
while ($i >= $j) {
    $P_C[$j] = production_c($bat[$j][C]);
    $tableau .= '<td style="text-align:center;">' . convNumber(24 * 7 * $P_C[$j]) .
        '</td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
////////////////////////////////////////////////////////// ////////////
//////////////////////////////////////////////////////////////////
//prod D
$tableau = '<tr>';
$tableau .= ' <th>Mine de deut</th>';
$j = 1;
while ($i >= $j) {
    $P_D[$j] = production_d($bat[$j][D], $bat[$j][temperature]);
    $tableau .= '<td style="text-align:center;">' . convNumber(24 * 7 * $P_D[$j]) .
        '</td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
////////////////////////////////////////////////////////// ////////////

////Total Prod par heure
$j = 1;
$total_m = 0;
$total_c = 0;
$total_d = 0;

while ($i >= $j) {
    $total_m = $total_m + $P_M[$j];
    $total_c = $total_c + $P_C[$j];
    $total_d = $total_d + $P_D[$j];
    $j = $j + 1;

}


echo '<tr><th><b>total</b></th><td colspan="3">Métal : <b>' . convNumber((24 * 7 *
    $total_m)) . '</b></td><td colspan="3">Cristal : <b>' . convNumber(24 * 7 * $total_c) .
    '</b></td><td colspan="3">Deut : <b>' . convNumber(24 * 7 * $total_d) .
    '</b></td></tr> ';


echo '<tr><th colspan="' . ($i + 1) . '"><b>Production par mois</b></th></tr> ';

////////////////////////////////////////////////////////// ////////////
//prod M
$tableau = '<tr>';
$tableau .= ' <th>Mine de Métal</th>';
$j = 1;
while ($i >= $j) {
    $P_M[$j] = production_m($bat[$j][M]);
    $tableau .= '<td style="text-align:center;">' . convNumber(24 * 30 * $P_M[$j]) .
        '</td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
//////////////////////////////////////////////////////////////////
//prod C
$tableau = '<tr>';
$tableau .= ' <th>Mine de cristal</th>';
$j = 1;
while ($i >= $j) {
    $P_C[$j] = production_c($bat[$j][C]);
    $tableau .= '<td style="text-align:center;">' . convNumber(24 * 30 * $P_C[$j]) .
        '</td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
////////////////////////////////////////////////////////// ////////////
//////////////////////////////////////////////////////////////////
//prod D
$tableau = '<tr>';
$tableau .= ' <th>Mine de deut</th>';
$j = 1;
while ($i >= $j) {
    $P_D[$j] = production_d($bat[$j][D], $bat[$j][temperature]);
    $tableau .= '<td style="text-align:center;">' . convNumber(24 * 30 * $P_D[$j]) .
        '</td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
////////////////////////////////////////////////////////// ////////////

////Total Prod par heure
$j = 1;
$total_m = 0;
$total_c = 0;
$total_d = 0;

while ($i >= $j) {
    $total_m = $total_m + $P_M[$j];
    $total_c = $total_c + $P_C[$j];
    $total_d = $total_d + $P_D[$j];
    $j = $j + 1;

}


echo '<tr><th><b>total</b></th><td colspan="3">Métal : <b>' . convNumber((24 *
    30 * $total_m)) . '</b></td><td colspan="3">Cristal : <b>' . convNumber(24 * 30 *
    $total_c) . '</b></td><td colspan="3">Deut : <b>' . convNumber(24 * 30 * $total_d) .
    '</b></td></tr> ';


echo '<tr><th colspan="' . ($i + 1) . '"><b>Energie</b></th></tr> ';
////////////////////////////////////////////////////////////
//nb de sat + energi par sat
$tableau = '<tr>';
$tableau .= ' <th>Satellite</th>';
$j = 1;
while ($i >= $j) {
    // energie = nb de sat * % / 100 * energe par sat
    $E_par_sat[$j] = production_sat($bat[$j][temperature]);
    $E_sat[$j] = $bat[$j][Sat] / 100 * $bat[$j][Sat_percentage] * $E_par_sat[$j];
    $tableau .= '<td style="text-align:center;">' . convNumber($E_sat[$j]) . '</td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
////////////////////////////////////////////////////////// ////////////
//nb de sat + energi par sat
$tableau = '<tr>';
$tableau .= ' <th>Centrale solaire</th>';
$j = 1;
while ($i >= $j) {
    // energie = nb de sat * % / 100 * energe par sat
    $E_ces[$j] = production_ces($bat[$j][CES]);
    $tableau .= '<td style="text-align:center;">' . convNumber($E_ces[$j]) . '</td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
////////////////////////////////////////////////////////// ////////////
////////////////////////////////////////////////////////// ////////////
//nb de sat + energi par sat
$tableau = '<tr>';
$tableau .= ' <th>Centrale a fusion</th>';
$j = 1;
while ($i >= $j) {
    // energie = nb de sat * % / 100 * energe par sat
    $E_ces[$j] = production_ces($bat[$j][CEF], $NRJ);
    $tableau .= '<td style="text-align:center;">' . convNumber($E_ces[$j]) . '</td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
////////////////////////////////////////////////////////// ////////////
//conso M
$tableau = '<tr>';
$tableau .= ' <th>Mine de métal</th>';
$j = 1;
while ($i >= $j) {
    // energie = nb de sat * % / 100 * energe par sat
    $E_M[$j] = conso_m($bat[$j][M]);
    $tableau .= '<td style="text-align:center;">-' . convNumber($E_M[$j]) . '</td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
////////////////////////////////////////////////////////// ////////////
//conso M
$tableau = '<tr>';
$tableau .= ' <th>Mine de cristal</th>';
$j = 1;
while ($i >= $j) {
    // energie = nb de sat * % / 100 * energe par sat
    $E_C[$j] = conso_c($bat[$j][C]);
    $tableau .= '<td style="text-align:center;">-' . convNumber($E_C[$j]) . '</td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
////////////////////////////////////////////////////////// ////////////
//conso M
$tableau = '<tr>';
$tableau .= ' <th>Mine de deut</th>';
$j = 1;
while ($i >= $j) {
    // energie = nb de sat * % / 100 * energe par sat
    $E_D[$j] = conso_d($bat[$j][D]);
    $tableau .= '<td style="text-align:center;">-' . convNumber($E_D[$j]) . '</td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
////////////////////////////////////////////////////////// ////////////
//Total
$tableau = '<tr>';
$tableau .= ' <th><b>Total</b></th>';
$j = 1;
while ($i >= $j) {
    // energie = nb de sat * % / 100 * energe par sat
    $E_total[$j] = ($E_sat[$j] + $E_cef[$j] + $E_ces[$j] - $E_D[$j] - $E_C[$j] - $E_M[$j]);
    $tableau .= '<td style="text-align:center;"><b>' . convNumber($E_total[$j]) .
        '</b></td>';
    $j = $j + 1;
}
$tableau .= '</tr>';
echo '' . $tableau . '';
////////////////////////////////////////////////////////// ////////////


echo '</table> ';


echo '</div></div></div>';

}

?>




   <div class="blockform">
	<h2><span>Propulsé par ogspy/<a href="http://www.ogsteam.fr">ogsteam</a></span></h2>



    </div>
<?php



require PUN_ROOT . 'footer.php';

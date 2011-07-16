<?php
/**
* Autonomie.php
* @package autonomie
* @author Mirtador
* @author oXid_FoX
* @link http://www.ogsteam.fr
*/

//*test de securite
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");
require_once("includes/ogame.php");
require_once("includes/user.php");

$start = 101; 
$nb_planete = find_nb_planete_user();
//*Debut Fonction

// fonction calculant l'autonomie de production
function autonomie($user_building,$ress)
	{
		$start = 101;
		$nb_planete = find_nb_planete_user();
		$result = array();//force l'interpretation de $result comme un array : retire des erreurs (silencieuses) dns le journal des PHP 5
	
		for ($i=$start ; $i<=$start+$nb_planete-1 ; $i++) 
			{
				// test planete existante
				if($user_building[$i][0] === TRUE)
					{
						if ($user_building[$i][$ress.'_hour'] > 0)
							$result[$i]=round(($user_building[$i]['H'.$ress.'_capacity'])/$user_building[$i][$ress.'_hour']);
						else							
							$result[$i] = '';
					}
			}
		return $result;
	}

//fonction ressource lorsque que le plus petit silo est plein
function ressourcespetithangar($autonomieM,$autonomieC,$autonomieD,$user_building)
	{
		$start = 101;
		$nb_planete = find_nb_planete_user();
		$result = array();//force l'interpretation de $result comme un array : retire des erreurs (silencieuses) dns le journal des PHP 5
		
		for ($i=$start ; $i<=$start+$nb_planete -1 ; $i++) 
			{
				// test planete existante
				if($user_building[$i][0] === TRUE)
					{
						// lorsque pas d'autonomie, il faut quand meme des valeurs pour comparer
						if (empty($autonomieM[$i])) $autonomieM[$i] = 9999999;
						if (empty($autonomieC[$i])) $autonomieC[$i] = 9999999;
						if (empty($autonomieD[$i])) $autonomieD[$i] = 9999999;

						if($autonomieM[$i]<$autonomieC[$i] and $autonomieM[$i]<$autonomieD[$i])
							{
								$temps= $autonomieM[$i];
							}
						elseif($autonomieC[$i]<$autonomieM[$i] and $autonomieC[$i]<$autonomieD[$i])
							{
								$temps= $autonomieC[$i];
							}
						elseif($autonomieD[$i]<$autonomieM[$i] and $autonomieD[$i]<$autonomieC[$i])
							{
								$temps= $autonomieD[$i];
							}
						$result[$i]=($user_building[$i]['M_hour']+$user_building[$i]['C_hour']+$user_building[$i]['D_hour'])*$temps;
					}
			}
		return $result;
	}

//fonction ressource lorsque TOUS les silos sont pleins
//on considere que toutes les mines continuent a produire (meme si leur silo associe est deja plein)
function ressourcesgrandhangar($autonomieM,$autonomieC,$autonomieD,$user_building)
	{
		$start = 101;
		$nb_planete = find_nb_planete_user();
		$result = array();//force l'interpretation de $result comme un array : retire des erreurs (silencieuses) dns le journal des PHP 5
		
		for ($i=$start ; $i<=$start+$nb_planete -1 ; $i++) 
			{
				// test planete existante
				if($user_building[$i][0] === TRUE)
					{
						// lorsque pas d'autonomie, il faut quand meme des valeurs pour comparer
						if (empty($autonomieM[$i])) $autonomieM[$i] = 1;
						if (empty($autonomieC[$i])) $autonomieC[$i] = 1;
						if (empty($autonomieD[$i])) $autonomieD[$i] = 1;
						
						$result[$i]=($user_building[$i]['M_hour']*$autonomieM[$i]+$user_building[$i]['C_hour']*$autonomieC[$i]+$user_building[$i]['D_hour']*$autonomieD[$i]);
					}
			}
		return $result;
	}

// calcule le nombre de transporteurs necessaire pour une quantite de ressources donnees pour toutes les planetes
function transporteur($ressources,$transporteur,$user_building)
	{
		$start = 101;
		$nb_planete = find_nb_planete_user();
		$result = array();//force l'interpretation de $result comme un array : retire des erreurs (silencieuses) dns le journal des PHP 5
		
		for ($i=$start ; $i<=$start+$nb_planete -1 ; $i++) 
			{
				$result[$i]=1;
				// test planète existante
				if($user_building[$i][0] === TRUE)
					{
						if($transporteur=="GT")
						$result[$i]=ceil($ressources[$i]/25000);

						if($transporteur=="PT")
						$result[$i]=ceil($ressources[$i]/5000);
					}
			}
		return $result;
	}

// Recupere les informations sur les mines, hangars, production...
function mine_production_empire($user_id) 
	{
		global $user_data;
		$start=101;
		$nb_planete = find_nb_planete_user();
		// Recuperation des informations sur les mines
		$planet = array(false, 'planet_name' => '', 'coordinates' => '', 'temperature' => '', 'Sat' => '',
		'M' => 0, 'C' => 0, 'D' => 0, 'CES' => 0, 'CEF' => 0 ,
		'M_percentage' => 0, 'C_percentage' => 0, 'D_percentage' => 0, 'CES_percentage' => 100, 'CEF_percentage' => 100, 'Sat_percentage' => 100,
		'HM' => 0, 'HC' => 0, 'HD' => 0);

		$quet = mysql_query('SELECT planet_id, planet_name, coordinates, temperature_min, temperature_max, Sat, M, C, D, CES, CEF, M_percentage, C_percentage, D_percentage, CES_percentage, CEF_percentage, Sat_percentage, HM, HC, HD FROM '.TABLE_USER_BUILDING.' WHERE user_id = '.$user_id.' ORDER BY planet_id');

		$user_building = array_fill($start, $start+$nb_planete-1, $planet);
		while ($row = mysql_fetch_assoc($quet)) 
			{
				$user_building[$row['planet_id']] = $row;
				$user_building[$row['planet_id']][0] = TRUE;
			}
		$user_empire = user_get_empire();
	
		// calcul des productions
		unset($metal_heure);
		unset($cristal_heure);
		unset($deut_heure);

		for ($i=$start ; $i<=$start+$nb_planete -1 ; $i++) 
			{
				// si la planete existe, on calcule la prod de ressources
				if ($user_building[$i][0] === TRUE) 
					{
						$M = $user_building[$i]['M'];
						$C = $user_building[$i]['C'];
						$D = $user_building[$i]['D'];
						$CES = $user_building[$i]['CES'];
						$CEF = $user_building[$i]['CEF'];
						$SAT = $user_building[$i]['Sat'];
						$M_per = $user_building[$i]['M_percentage'];
						$C_per = $user_building[$i]['C_percentage'];
						$D_per = $user_building[$i]['D_percentage'];
						$CES_per = $user_building[$i]['CES_percentage'];
						$CEF_per = $user_building[$i]['CEF_percentage'];
						$SAT_per = $user_building[$i]['Sat_percentage'];
						$temperature_min = $user_building[$i]['temperature_min'];
						$temperature_max = $user_building[$i]['temperature_max'];
						$HM = $user_building[$i]['HM'];
						$HC = $user_building[$i]['HC'];
						$HD = $user_building[$i]['HD'];
			
						$production_CES = ( $CES_per / 100 ) * ( production ( "CES", $CES, $user_data['off_ingenieur'] ));
						$production_CEF = ( $CEF_per / 100 ) * ( production ("CEF", $CEF, $user_data['off_ingenieur'] ));
						$production_SAT = ( $SAT_per / 100 ) * ( production_sat ( $temperature_min, $temperature_max, $user_data['off_ingenieur'] ) * $SAT );
			
						$prod_energie = $production_CES + $production_CEF + $production_SAT;
						
						$consommation_M = ( $M_per / 100 ) * ( consumption ( "M", $M ));
						$consommation_C = ( $C_per / 100 ) * ( consumption ( "C", $C ));
						$consommation_D = ( $D_per / 100 ) * ( consumption ( "D", $D ));
						$consommation_CEF = consumption("CEF", $CEF);
						$cons_energie = $consommation_M + $consommation_C + $consommation_D;
			
						if ($cons_energie == 0) $cons_energie = 1;
						$ratio = floor(($prod_energie/$cons_energie)*100)/100;
						if ($ratio > 1) $ratio = 1;

						// calcul de la production horaire
						$user_building[$i]['M_hour'] = $ratio * ( production ( "M", $M, $user_data['off_geologue'] ));
						$user_building[$i]['C_hour'] = $ratio * ( production ( "C", $C, $user_data['off_geologue'] ));
						$user_building[$i]['D_hour'] = ( $ratio * ( production ( "D", $D, $user_data['off_geologue'], $temperature_max, $NRJ ))) - $consommation_CEF ;
			
						// calcul des capacites par defaut
						$user_building[$i]['HM_capacity'] = depot_capacity($HM);
						$user_building[$i]['HC_capacity'] = depot_capacity($HC);
						$user_building[$i]['HD_capacity'] = depot_capacity($HD);
					} // fin du test d'existence de la planete
			}
		return $user_building;
	}

//*Fin fonctions

//*Debut calculs

// mines, hangars, productions, infos planetes
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

echo "<tr><th colspan='4'>Calculateur du temps d'autonomie de votre empire</th></tr>";
echo '<tr>';

//on initialise les variables
$planete_rouge=0;
$planete_jaune=0;
$planete_verte=0;
$somme_hangarM=0;
$somme_hangarC=0;
$somme_hangarD=0;
$maxempGT=0;
$minempGT=0;
$maxempPT=0;
$minempPT=0;
// la duree d'autonomie
$seuil_autonomie_courte=24;
$seuil_autonomie_longue=48;
for ($i=$start ; $i<=$start+$nb_planete -1 ; $i++) {
//	if ($coordinates[$i]!="&nbsp;"){
		// test planète existante
		if($user_building[$i][0] === TRUE){
		///////////////////////////////////////////////////////
		//*hangar a augmenter +autonomie planetaire
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
			// on fait attention a la production de deuterium nulle (quand pas de synthetiseur)
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
		
		//*fin hangar a augmenter
		///////////////////////////////////////////////////////
		//*couleur hangar
		if ($autoplanete<=$seuil_autonomie_courte){
			$color="red";
			$planete_rouge=$planete_rouge+1;
		}
		elseif ($autoplanete<$seuil_autonomie_longue and $autoplanete>$seuil_autonomie_courte){
			$color="yellow";
			$planete_jaune=$planete_jaune+1;
		}
		else{
			$color="lime";
			$planete_verte=$planete_verte+1;
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

		// Formatage des nombres.
		
		$M_hour = number_format($user_building[$i]['M_hour'], 0, ',', ' ');
		$C_hour = number_format($user_building[$i]['C_hour'], 0, ',', ' ');
		$D_hour = number_format($user_building[$i]['D_hour'], 0, ',', ' ');
		
		$HM_capacity = number_format($user_building[$i]['HM_capacity']/1000, 0, ',', ' ');
		$HC_capacity = number_format($user_building[$i]['HC_capacity']/1000, 0, ',', ' ');
		$HD_capacity = number_format($user_building[$i]['HD_capacity']/1000, 0, ',', ' ');
		
		$minimum_PT = number_format($minPT[$i], 0, ',', ' ');
		$maximum_PT = number_format($maxPT[$i], 0, ',', ' ');
		$minimum_GT = number_format($minGT[$i], 0, ',', ' ');
		$maximum_GT = number_format($maxGT[$i], 0, ',', ' ');
		
		$minimum_emp_PT = number_format($minempPT, 0, ',', ' ');
		$maximum_emp_PT = number_format($maxempPT, 0, ',', ' ');
		$minimum_emp_GT = number_format($minempGT, 0, ',', ' ');
		$maximum_emp_GT = number_format($maxempGT, 0, ',', ' ');
		
		//*Affichage des infos sur la planete
	
		echo'<tr><td rowspan="6" class="c"><center>'.$user_building[$i]['planet_name'].'<p style="margin-top: 0; margin-bottom: 0">'.$user_building[$i]['coordinates']."</p></center></td>\n";
		echo'<td></td>';
		echo'<th>Niveau de la mine</th>';
		echo'<th>Production par heure</th>';
		echo'<th>Niveau des hangars</th>';
		echo'<th>Capacité de vos hangars</th>';
		echo'<th>Temps d\'autonomie de la planète</th>';
		echo"</tr>\n<tr>";
		echo'<th>Métal</th>';
		echo'<th>'.$user_building[$i]['M'].'</th>';
		echo'<th>'.$M_hour.'</th>';
		echo'<th>'.$user_building[$i]['HM'].'</th>';
		echo'<th>'.$HM_capacity.' K</th>';
		if ($autonomieM[$i]<72) {echo '<th>'.$autonomieM[$i].' Heures</th>';} else {echo '<th title="'.$autonomieM[$i].' Heures">'.round(($autonomieM[$i])/24,1).' Jours</th>';}
		echo"</tr>\n<tr>";
		echo'<th>Cristal</th>';
		echo'<th>'.$user_building[$i]['C'].'</th>';
		echo'<th>'.$C_hour.'</th>';
		echo'<th>'.$user_building[$i]['HC'].'</th>';
		echo'<th>'.$HC_capacity.' K</th>';
		if ($autonomieC[$i]<72) {echo '<th>'.$autonomieC[$i].' Heures</th>';} else {echo '<th title="'.$autonomieC[$i].' Heures">'.round(($autonomieC[$i])/24,1).' Jours</th>';}
		echo"</tr>\n<tr>";
		echo'<th>Deutérium</th>';
		echo'<th>'.$user_building[$i]['D'].'</th>';
		echo'<th>'.$D_hour.'</th>';
		echo'<th>'.$user_building[$i]['HD'].'</th>';
		echo'<th>'.$HD_capacity.' K</th>';
		// on fait attention à la production de deuterium nulle (quand pas de synthétiseur)
		if ($autonomieD[$i]=='') {echo '<th title="infini !">-</th>';} elseif ($autonomieD[$i]<72) {echo '<th>'.$autonomieD[$i].' Heures</th>';} else {echo '<th title="'.$autonomieD[$i].' Heures">'.round(($autonomieD[$i])/24,1).' Jours</th>';}
		echo"</tr>\n\n<tr>";
		echo'<td colspan="6"rowspan="2">';
			echo'<table>';
			echo'<tr><th colspan="6">Transport</th>';
			echo"</tr>\n<tr>";
			echo'<th colspan="1" rowspan="2" >Nb de transporteurs minimal pour vider la planète avant que le plus petit hangar soit plein (pour éviter les pertes)</th>';
			echo'<th>PT:</th>';
			echo'<th width="34">'.$minimum_PT."</th>\n";
			echo'<th colspan="1" rowspan="2">Nb de transporteurs minimal pour vider la planète avant que tous les hangars soient pleins</th>';
			echo'<th>PT:</th>';
			echo'<th width="34">'.$maximum_PT.'</th>';
			echo"</tr>\n<tr>";
			echo'<th>GT:</th>';
			echo'<th>'.$minimum_GT.'</th>';
			echo'<th>GT:</th>';
			echo'<th>'.$maximum_GT.'</th>';
			echo"</tr>\n\n<tr>";
			echo'</table>';
			echo'<table width="100%">';
			echo'<tr><td class="c" width="70%">Pour augmenter l\'autonomie de cette planète, vous devriez améliorer votre <font color="lime">'.$petit_hangar.'</font></td>';
			echo'<th width="30%"> Vous pouvez attendre <font color="'.$color.'">'.$autoplanete.' heures ('.round(($autoplanete)/24,1).' jours)</font> <br>avant de vider votre planète.</th></tr>';
			echo'</table>';
		echo'</td></tr>';
		echo"</tr>\n\n<tr>";//';
		//*Affichage des infos sur la planete
		///////////////////////////////////////////////////////
	}
}
echo'</table>';
///////////////////////////////////////////////////////
//*infos generales
echo'<table width="100%">';
echo'<tr><td class="c" colspan="6">Vue d\'ensemble</tr>';
echo'<tr><th colspan="6">Somme du nombre de transporteurs nécessaires à votre empire.</th></tr>';
echo'<tr>';
echo'<th rowspan="2">Pour vider toutes vos colonies avant que les plus petits hangars soit pleins</th>';
echo'<th>PT:</th><th>'.$minimum_emp_PT.'</th>';
echo'<th rowspan="2">Pour vider toutes vos colonies lorsque tous les hangars sont pleins</th>';
echo'<th>PT:</th><th>'.$maximum_emp_PT.'</th>';
echo"</tr>
<tr>";
echo'<th>GT:</th><th>'.$minimum_emp_GT.'</th>';
echo'<th>GT:</th><th>'.$maximum_emp_GT.'</th>';
echo"</tr>\n<tr>";
echo'<th colspan="6">Statistiques globales de votre empire.</th>';
echo"</tr>\n<tr>";
echo'<th colspan="2">Nombre de vos plan&ètes ayant une autonomie nettement trop petite (- de '.$seuil_autonomie_courte.'h):</th><th>'.$planete_rouge.'</th>';
echo'<th colspan="2">Nombre de hangars de métal baissant l\'autonomie de sa planète:</th><th>'.$somme_hangarM.'</th>';
echo"</tr>\n<tr>";
echo'<th colspan="2">Nombre de vos planètes ayant une autonomie raisonnable (entre '.$seuil_autonomie_courte.' et '.$seuil_autonomie_longue.'h):</th><th>'.$planete_jaune.'</th>';
echo'<th colspan="2">Nombre de hangars de cristal baissant l\'autonomie de sa planète:</th><th>'.$somme_hangarC.'</th>';
echo"</tr>\n<tr>";
echo'<th colspan="2">Nombre de vos planètes ayant une très bonne autonomie (+ de '.$seuil_autonomie_longue.'h):</th><th>'.$planete_verte.'</th>';
echo'<th colspan="2">Nombre de réservoirs de deutérium baissant l\'autonomie de sa planète:</th><th>'.$somme_hangarD.'</th>';
echo"</tr>\n";
echo'</table>';
//*fin infos generales
///////////////////////////////////////////////////////
//*legende
?>

<table width="31%" align="right">
	<tr>
		<th width="100%" height="50%">
		<font color="#00FF00">Vert = cette planète est autonome + de <?php echo $seuil_autonomie_longue; ?> heures.</font><br>
		<font color="#FFFF00">Jaune = attention, cette planète est autonome entre <?php echo $seuil_autonomie_courte.' et '.$seuil_autonomie_longue; ?> heures.</font><br>
		<font color="#FF0000">Rouge = cette planète risque fort de vous faire perdre des ressources, car son autonomie est inférieure à <?php echo $seuil_autonomie_courte; ?>h.</font>
		</th>
	</tr>
</table>


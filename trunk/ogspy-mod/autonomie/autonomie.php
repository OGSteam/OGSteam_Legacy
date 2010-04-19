<?php
/**
* Autonomie.php
* @package autonomie
* @author Mirtador
* @author oXid_FoX
* @link http://www.ogsteam.fr
*/

//*test de s�curit�
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");

//Variable � modifier si on est dans l'univers 50. dans la prochaine version, �a sera modifiable au panneau d'administration
$multiplier = 1;

//*D�but Fonction

// fonction calculant l'autonomie de production
function autonomie($user_building,$ress){
	$result = array();//force l'interpr�tation de $result comme un array : retire des erreurs (silencieuses) dns le journal d�s PHP 5
	for ($i=1 ; $i<=9 ; $i++) {
		// test plan�te existante
		if($user_building[$i][0] === TRUE){
			if ($user_building[$i][$ress.'_hour'] > 0)
				$result[$i]=round(($user_building[$i]['H'.$ress.'_capacity']*1000)/$user_building[$i][$ress.'_hour']);
			else
				$result[$i] = '';
		}
	}
	return $result;
}

//fonction ressource lorsque que le plus petit silo est plein
function ressourcespetithangar($autonomieM,$autonomieC,$autonomieD,$user_building){
	$result = array();//force l'interpr�tation de $result comme un array : retire des erreurs (silencieuses) dns le journal d�s PHP 5
	for ($i=1 ; $i<=9 ; $i++) {
		// test plan�te existante
		if($user_building[$i][0] === TRUE){
			// lorsque pas d'autonomie, il faut quand meme des valeurs pour comparer
			if (empty($autonomieM[$i])) $autonomieM[$i] = 9999999;
			if (empty($autonomieC[$i])) $autonomieC[$i] = 9999999;
			if (empty($autonomieD[$i])) $autonomieD[$i] = 9999999;

			if($autonomieM[$i]<$autonomieC[$i] and $autonomieM[$i]<$autonomieD[$i]){
				$temps= $autonomieM[$i];
			}
			elseif($autonomieC[$i]<$autonomieM[$i] and $autonomieC[$i]<$autonomieD[$i]){
				$temps= $autonomieC[$i];
			}
			elseif($autonomieD[$i]<$autonomieM[$i] and $autonomieD[$i]<$autonomieC[$i]){
				$temps= $autonomieD[$i];
			}
			$result[$i]=($user_building[$i]['M_hour']+$user_building[$i]['C_hour']+$user_building[$i]['D_hour'])*$temps;
		}
	}
	return $result;
}

//fonction ressource lorsque TOUS les silos sont pleins
//on consid�re que toutes les mines continuent � produire (meme si leur silo associ� est d�j� plein)
function ressourcesgrandhangar($autonomieM,$autonomieC,$autonomieD,$user_building){
	$result = array();//force l'interpr�tation de $result comme un array : retire des erreurs (silencieuses) dns le journal d�s PHP 5
	for ($i=1 ; $i<=9 ; $i++) {
		// test plan�te existante
		if($user_building[$i][0] === TRUE){
			// lorsque pas d'autonomie, il faut quand meme des valeurs pour comparer
			if (empty($autonomieM[$i])) $autonomieM[$i] = 1;
			if (empty($autonomieC[$i])) $autonomieC[$i] = 1;
			if (empty($autonomieD[$i])) $autonomieD[$i] = 1;

			if($autonomieM[$i]>$autonomieC[$i] and $autonomieM[$i]>$autonomieD[$i]){
				$temps= $autonomieM[$i];
			}
			elseif($autonomieC[$i]>$autonomieM[$i] and $autonomieC[$i]>$autonomieD[$i]){
				$temps= $autonomieC[$i];
			}
			elseif($autonomieD[$i]>$autonomieM[$i] and $autonomieD[$i]>$autonomieC[$i]){
				$temps= $autonomieD[$i];
			}
			$result[$i]=($user_building[$i]['M_hour']+$user_building[$i]['C_hour']+$user_building[$i]['D_hour'])*$temps;
		}
	}
	return $result;
}

// calcule le nombre de transporteurs n�cessaire pour une quantit� de ressources donn�es pour toutes les plan�tes
function transporteur($ressources,$transporteur,$user_building){
	$result = array();//force l'interpr�tation de $result comme un array : retire des erreurs (silencieuses) dns le journal d�s PHP 5
	for ($i=1 ; $i<=9 ; $i++) {
    $result[$i]=0;
		// test plan�te existante
		if($user_building[$i][0] === TRUE){
			if($transporteur=="GT")
				$result[$i]=ceil($ressources[$i]/25000);

			if($transporteur=="PT")
				$result[$i]=ceil($ressources[$i]/5000);
		}
	}
	return $result;
}

// R�cup�re les informations sur les mines, hangars, production...
function mine_production_empire($user_id) {
	// R�cup�ration des informations sur les mines
	$planet = array(false, 'planet_name' => '', 'coordinates' => '', 'temperature' => '', 'Sat' => '',
	'M' => 0, 'C' => 0, 'D' => 0, 'CES' => 0, 'CEF' => 0 ,
	'M_percentage' => 0, 'C_percentage' => 0, 'D_percentage' => 0, 'CES_percentage' => 100, 'CEF_percentage' => 100, 'Sat_percentage' => 100,
	'HM' => 0, 'HC' => 0, 'HD' => 0);

	$quet = mysql_query('SELECT planet_id, planet_name, coordinates, temperature, Sat, M, C, D, CES, CEF, M_percentage, C_percentage, D_percentage, CES_percentage, CEF_percentage, Sat_percentage, HM, HC, HD FROM '.TABLE_USER_BUILDING.' WHERE user_id = '.$user_id.' ORDER BY planet_id');

	$user_building = array_fill(1, 9, $planet);
	while ($row = mysql_fetch_assoc($quet)) {
		$user_building[$row['planet_id']] = $row;
		$user_building[$row['planet_id']][0] = TRUE;
	}

	// calcul des productions
	unset($metal_heure);
	unset($cristal_heure);
	unset($deut_heure);

	for ($i=1; $i<=9; $i++) {
		// si la plan�te existe, on calcule la prod de ressources
		if ($user_building[$i][0] === TRUE) {
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
			$temperature = $user_building[$i]['temperature'];
			$HM = $user_building[$i]['HM'];
			$HC = $user_building[$i]['HC'];
			$HD = $user_building[$i]['HD'];

			$prod_energie = (($CES_per/100)*(floor(20 * $CES * pow(1.1, $CES)))) + (($CEF_per/100)*(floor(50 * $CEF * pow(1.1, $CEF)))) + (($SAT_per/100)* ($SAT * floor(($temperature / 4) + 20))) ;
			$cons_enregie = (($M_per/100)*(floor(10 * $M * pow(1.1, $M)))) + (($C_per/100)*(floor(10 * $C * pow(1.1, $C)))) + (($D_per/100)*(floor(20 * $D * pow(1.1, $D)))) ;
			if ($cons_enregie == 0) $cons_enregie = 1;
			$ratio = round(($prod_energie/$cons_enregie)*100)/100;
			if ($ratio > 1) $ratio = 1;

			// calcul de la production horaire
			$user_building[$i]['M_hour'] = 20 + round(($M_per/100)*$ratio*floor(30 * $M * pow(1.1, $M)));
			$user_building[$i]['C_hour'] = 10 + round(($C_per/100)*$ratio*floor(20 * $C * pow(1.1, $C)));
			$user_building[$i]['D_hour'] =  (round(($D_per/100)*$ratio*floor(10 * $D * pow(1.1, $D) * (-0.002 * $temperature + 1.28))) - round(($CEF_per/100)*10 * $CEF * pow(1.1, $CEF)));

	 		// ajout des capacit�s par d�faut
			$HM_capacity = 100;
			$HC_capacity = 100;
			$HD_capacity = 100;
			// calcul des capacit�s de stockage
			if ($HM > 0)
				$HM_capacity = 100 + 50 * floor(pow(1.6, $HM));
			$user_building[$i]['HM_capacity'] = round($HM_capacity);

			if ($HC > 0)
				$HC_capacity = 100 + 50 * floor(pow(1.6, $HC));
			$user_building[$i]['HC_capacity'] = round($HC_capacity);

			if ($HD > 0)
				$HD_capacity = 100 + 50 * floor(pow(1.6, $HD));
			$user_building[$i]['HD_capacity'] = round($HD_capacity);

		} // fin du test d'existence de la plan�te
	}
	return $user_building;
}

//*Fin fonctions

//*D�but calculs

// mines, hangars, productions, infos plan�tes
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

//On transforme les r�sultats en fonction du multiplicateur
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
$plan�te_rouge=0;
$plan�te_jaune=0;
$plan�te_verte=0;
$somme_hangarM=0;
$somme_hangarC=0;
$somme_hangarD=0;
$maxempGT=0;
$minempGT=0;
$maxempPT=0;
$minempPT=0;
// la dur�e d'autonomie
$seuil_autonomie_courte=24;
$seuil_autonomie_longue=48;

for ($i=1 ; $i<=9 ; $i++) {
//	if ($coordinates[$i]!="&nbsp;"){
		// test plan�te existante
		if($user_building[$i][0] === TRUE){
		///////////////////////////////////////////////////////
		//*hangar � augmenter +autonomie planetaire
		if($autonomieD[$i]!= ''){
			if($autonomieM[$i]<$autonomieC[$i] and $autonomieM[$i]<$autonomieD[$i]){
				$petit_hangar= "Hangar de m�tal";
				$somme_hangarM= $somme_hangarM+1;
				$autoplanete=$autonomieM[$i];
			}
			elseif($autonomieC[$i]<$autonomieM[$i] and $autonomieC[$i]<$autonomieD[$i]){
				$petit_hangar= "Hangar de cristal";
				$somme_hangarC= $somme_hangarC+1;
				$autoplanete=$autonomieC[$i];
			}
			// on fait attention � la production de deuterium nulle (quand pas de synth�tiseur)
			elseif($autonomieD[$i]<$autonomieM[$i] and $autonomieD[$i]<$autonomieC[$i]){
				$petit_hangar= "R�servoir de deut�rium";
				$somme_hangarD= $somme_hangarD+1;
				$autoplanete=$autonomieD[$i];
			}
		}
		else{
			if($autonomieM[$i]<$autonomieC[$i]){
				$petit_hangar= "Hangar de m�tal";
				$somme_hangarM= $somme_hangarM+1;
				$autoplanete=$autonomieM[$i];
			}
			elseif($autonomieC[$i]<$autonomieM[$i]){
				$petit_hangar= "Hangar de cristal";
				$somme_hangarC= $somme_hangarC+1;
				$autoplanete=$autonomieC[$i];
			}
		}
		
		//*fin hangar � augmenter
		///////////////////////////////////////////////////////
		//*couleur hangar
		if ($autoplanete<=$seuil_autonomie_courte){
			$color="red";
			$plan�te_rouge=$plan�te_rouge+1;
		}
		elseif ($autoplanete<$seuil_autonomie_longue and $autoplanete>$seuil_autonomie_courte){
			$color="yellow";
			$plan�te_jaune=$plan�te_jaune+1;
		}
		else{
			$color="lime";
			$plan�te_verte=$plan�te_verte+1;
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
		echo'<tr><td rowspan="6" class="c"><center>'.$user_building[$i]['planet_name'].'<p style="margin-top: 0; margin-bottom: 0">'.$user_building[$i]['coordinates']."</p></center></td>\n";
		echo'<td></td>';
		echo'<th>Niveau de la mine</th>';
		echo'<th>Production par heure</th>';
		echo'<th>Niveau des hangars</th>';
		echo'<th>Capacit� de vos hangars</th>';
		echo'<th>Temps d\'autonomie de la plan�te</th>';
		echo"</tr>\n<tr>";
		echo'<th>M�tal</th>';
		echo'<th>'.$user_building[$i]['M'].'</th>';
		echo'<th>'.$user_building[$i]['M_hour'].'</th>';
		echo'<th>'.$user_building[$i]['HM'].'</th>';
		echo'<th>'.$user_building[$i]['HM_capacity'].' K</th>';
		if ($autonomieM[$i]<72) {echo '<th>'.$autonomieM[$i].' Heures</th>';} else {echo '<th title="'.$autonomieM[$i].' Heures">'.round(($autonomieM[$i])/24,1).' Jours</th>';}
		echo"</tr>\n<tr>";
		echo'<th>Cristal</th>';
		echo'<th>'.$user_building[$i]['C'].'</th>';
		echo'<th>'.$user_building[$i]['C_hour'].'</th>';
		echo'<th>'.$user_building[$i]['HC'].'</th>';
		echo'<th>'.$user_building[$i]['HC_capacity'].' K</th>';
		if ($autonomieC[$i]<72) {echo '<th>'.$autonomieC[$i].' Heures</th>';} else {echo '<th title="'.$autonomieC[$i].' Heures">'.round(($autonomieC[$i])/24,1).' Jours</th>';}
		echo"</tr>\n<tr>";
		echo'<th>Deut�rium</th>';
		echo'<th>'.$user_building[$i]['D'].'</th>';
		echo'<th>'.$user_building[$i]['D_hour'].'</th>';
		echo'<th>'.$user_building[$i]['HD'].'</th>';
		echo'<th>'.$user_building[$i]['HD_capacity'].' K</th>';
		// on fait attention � la production de deuterium nulle (quand pas de synth�tiseur)
		if ($autonomieD[$i]=='') {echo '<th title="infini !">-</th>';} elseif ($autonomieD[$i]<72) {echo '<th>'.$autonomieD[$i].' Heures</th>';} else {echo '<th title="'.$autonomieD[$i].' Heures">'.round(($autonomieD[$i])/24,1).' Jours</th>';}
		echo"</tr>\n\n<tr>";
		echo'<td colspan="6"rowspan="2">';
			echo'<table>';
			echo'<tr><th colspan="6">Transport</th>';
			echo"</tr>\n<tr>";
			echo'<th colspan="1" rowspan="2">Nb de transporteurs minimal pour vider la plan�te avant que le plus petit hangar soit plein (pour �viter les pertes)</th>';
			echo'<th>PT:</th>';
			echo'<th>'.$minPT[$i]."</th>\n";
			echo'<th colspan="1" rowspan="2">Nb de transporteurs minimal pour vider la plan�te avant que tous les hangars soient pleins</th>';
			echo'<th>PT:</th>';
			echo'<th>'.$maxPT[$i].'</th>';
			echo"</tr>\n<tr>";
			echo'<th>GT:</th>';
			echo'<th>'.$minGT[$i].'</th>';
			echo'<th>GT:</th>';
			echo'<th>'.$maxGT[$i].'</th>';
			echo"</tr>\n\n<tr>";
			echo'</table>';
			echo'<table width="100%">';
			echo'<tr><td class="c" width="70%">Pour augmenter l\'autonomie de cette plan�te, vous devriez am�liorer votre <font color="lime">'.$petit_hangar.'</font></td>';
			echo'<th width="30%"> Vous pouvez attendre <font color="'.$color.'">'.$autoplanete.' heures ('.round(($autoplanete)/24,1).' jours)</font> <br>avant de vider votre plan�te.</th></tr>';
			echo'</table>';
		echo'</td></tr>';
		echo"</tr>\n\n<tr>";//';
		//*Affichage des infos sur la planete
		///////////////////////////////////////////////////////
	}
}
echo'</table>';
///////////////////////////////////////////////////////
//*infos g�n�rales
echo'<table width="100%">';
echo'<tr><td class="c" colspan="6">Vue d\'ensemble</tr>';
echo'<tr><th colspan="6">Somme du nombre de transporteurs n�cessaires � votre empire.</th></tr>';
echo'<tr>';
echo'<th rowspan="2">Pour vider toutes vos colonies avant que les plus petits hangars soit pleins</th>';
echo'<th>PT:</th><th>'.$minempPT.'</th>';
echo'<th rowspan="2">Pour vider toutes vos colonies lorsque tous les hangars sont pleins</th>';
echo'<th>PT:</th><th>'.$maxempPT.'</th>';
echo"</tr>
<tr>";
echo'<th>GT:</th><th>'.$minempGT.'</th>';
echo'<th>GT:</th><th>'.$maxempGT.'</th>';
echo"</tr>\n<tr>";
echo'<th colspan="6">Statistiques globales de votre empire.</th>';
echo"</tr>\n<tr>";
echo'<th colspan="2">Nombre de vos plan�tes ayant une autonomie nettement trop petite (- de '.$seuil_autonomie_courte.'h):</th><th>'.$plan�te_rouge.'</th>';
echo'<th colspan="2">Nombre de hangars de m�tal baissant l\'autonomie de sa plan�te:</th><th>'.$somme_hangarM.'</th>';
echo"</tr>\n<tr>";
echo'<th colspan="2">Nombre de vos plan�tes ayant une autonomie raisonnable (entre '.$seuil_autonomie_courte.' et '.$seuil_autonomie_longue.'h):</th><th>'.$plan�te_jaune.'</th>';
echo'<th colspan="2">Nombre de hangars de cristal baissant l\'autonomie de sa plan�te:</th><th>'.$somme_hangarC.'</th>';
echo"</tr>\n<tr>";
echo'<th colspan="2">Nombre de vos plan�tes ayant une tr�s bonne autonomie (+ de '.$seuil_autonomie_longue.'h):</th><th>'.$plan�te_verte.'</th>';
echo'<th colspan="2">Nombre de r�servoirs de deut�rium baissant l\'autonomie de sa plan�te:</th><th>'.$somme_hangarD.'</th>';
echo"</tr>\n";
echo'</table>';
//*fin infos g�n�rales
///////////////////////////////////////////////////////
//*l�gende
?>

<table width="31%" align="right">
	<tr>
		<th width="100%" height="50%">
		<font color="#00FF00">Vert = cette plan�te est autonome + de <?php echo $seuil_autonomie_longue; ?> heures.</font><br>
		<font color="#FFFF00">Jaune = attention, cette plan�te est autonome entre <?php echo $seuil_autonomie_courte.' et '.$seuil_autonomie_longue; ?> heures.</font><br>
		<font color="#FF0000">Rouge = cette plan�te risque fort de vous faire perdre des ressources, car son autonomie est inf�rieure � <?php echo $seuil_autonomie_courte; ?>h.</font>
		</th>
	</tr>
</table>


<?php
///   prod de sat
function production_sat($temperature)
{
    return floor(($temperature / 4) + 20);
}


function production_ces($level)
{
    $result = 20 * $level * pow(1.1, $level);
    return round($result);
}

function production_cef($level, $NRJ)
{
    $result = 30 * $level * pow((1.05 + 0.01 * $NRJ), $level);
    return round($result);
}

function production_m($level)
{
    $result = 30 * $level * pow(1.1, $level);
    return round($result);
}

function conso_m($level)
{
    $result = 10 * $level * pow(1.1, $level);
    return round($result);
}

function production_c($level)
{
    $result = 20 * $level * pow(1.1, $level);
    return round($result);
}

function conso_c($level)
{
    $result = 10 * $level * pow(1.1, $level);
    return round($result);
}

function production_d($level, $temp)
{
    $result = 10 * $level * pow(1.1, $level) * (-0.002 * $temp + 1.28);
    return round($result);
}


function conso_d($level)
{
    $result = 20 * $level * pow(1.1, $level);
    return round($result);
}


//*Début Fonction

// fonction calculant l'autonomie de production
function autonomie($user_building,$ress){
	for ($i=1 ; $i<=9 ; $i++) {
		// test planète existante
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
	for ($i=1 ; $i<=9 ; $i++) {
		// test planète existante
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
//on considère que toutes les mines continuent à produire (meme si leur silo associé est déjà plein)
function ressourcesgrandhangar($autonomieM,$autonomieC,$autonomieD,$user_building){
	for ($i=1 ; $i<=9 ; $i++) {
		// test planète existante
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

// calcule le nombre de transporteurs nécessaire pour une quantité de ressources données pour toutes les planètes
function transporteur($ressources,$transporteur,$user_building){
	for ($i=1 ; $i<=9 ; $i++) {
    $result[$i]=0;
		// test planète existante
		if($user_building[$i][0] === TRUE){
			if($transporteur=="GT")
				$result[$i]=ceil($ressources[$i]/25000);

			if($transporteur=="PT")
				$result[$i]=ceil($ressources[$i]/5000);
		}
	}
	return $result;
}

// Récupére les informations sur les mines, hangars, production...
function mine_production_empire($user_id) {
	
	global $db;
	global  $pun_config;
	global $pun_user;
	// Récupération des informations sur les mines
	$planet = array(false, 'planet_name' => '', 'coordinates' => '', 'temperature' => '', 'Sat' => '',
	'M' => 0, 'C' => 0, 'D' => 0, 'CES' => 0, 'CEF' => 0 ,
	'M_percentage' => 0, 'C_percentage' => 0, 'D_percentage' => 0, 'CES_percentage' => 100, 'CEF_percentage' => 100, 'Sat_percentage' => 100,
	'HM' => 0, 'HC' => 0, 'HD' => 0);








$sql = 'SELECT planet_id, planet_name, coordinates, temperature, Sat, M, C, D, CES, CEF, M_percentage, C_percentage, D_percentage, CES_percentage, CEF_percentage, Sat_percentage, HM, HC, HD FROM '.$pun_config['ogspy_prefix'].'user_building  WHERE user_id = \''.$pun_user['id_ogspy'].'\' ORDER BY planet_id';
 $result = $db->query($sql);

$user_building = array_fill(1, 9, $planet);


	    while($row = $db->fetch_assoc($result))
	    {


		$user_building[$row['planet_id']] = $row;
		$user_building[$row['planet_id']][0] = TRUE;
	}

	// calcul des productions
	unset($metal_heure);
	unset($cristal_heure);
	unset($deut_heure);

	for ($i=1; $i<=9; $i++) {
		// si la planète existe, on calcule la prod de ressources
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

	 		// ajout des capacités par défaut
			$HM_capacity = 100;
			$HC_capacity = 100;
			$HD_capacity = 100;
			// calcul des capacités de stockage
			if ($HM > 0)
				$HM_capacity = 100 + 50 * floor(pow(1.6, $HM));
			$user_building[$i]['HM_capacity'] = round($HM_capacity);

			if ($HC > 0)
				$HC_capacity = 100 + 50 * floor(pow(1.6, $HC));
			$user_building[$i]['HC_capacity'] = round($HC_capacity);

			if ($HD > 0)
				$HD_capacity = 100 + 50 * floor(pow(1.6, $HD));
			$user_building[$i]['HD_capacity'] = round($HD_capacity);

		} // fin du test d'existence de la planète
	}
	return $user_building;
}

//*Fin fonctions

?>
<?php
/***************************************************************************
*	filename	: home_cara_vaisseaux.php
*	desc.		:
*	Author		: Kal Nightmare - http://ogs.servebbs.net/
*	created		: 07/07/2006
*	modified	: 07/07/2006 21:57:19
***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

ob_start();

require_once("views/page_header.php");

require_once("includes/ogame.php");
//require_once("parameters/lang_empire.php");


$user_empire = user_get_empire();
$user_technology = $user_empire["technology"];

/**
 * Formatte l'heure pour la retourner en chaine du style J H M S
 *
 * @param int $seconds
 * @return string
 */
function format($seconds) {
	$days = floor($seconds / 86400);
	if ($days > 0) {
		$seconds -= $days * 86400;
	}
	$hours = floor($seconds / 3600);
	if ($days > 0 || $hours > 0) {
		$seconds -= $hours * 3600;
	}
	$minutes = floor($seconds / 60);
	if ($days > 0 || $hours > 0 || $minutes > 0) {
		$seconds -= $minutes * 60;
	}
	if ($hours < 10) $hours = '0'. $hours;
	if ($minutes < 10) $minutes = '0'.$minutes;
	if ($seconds < 10) $seconds = '0'.$seconds;
	if ($days > 0) {
		return sprintf('%sj %sh %sm %ss', (string)$days, (string)$hours, (string)$minutes, (string)$seconds);
	} elseif ($hours > 0) {
		return sprintf('%sh %sm %ss', (string)$hours, (string)$minutes, (string)$seconds);
	} elseif ($minutes > 0) {
		return sprintf('%sm %ss', (string)$minutes, (string)$seconds);
	} else {
		return sprintf('%ss', (string)$seconds);
	}
}


//					 		   [0] Nom			       		      [1] protec	[2]bouc	[3] arm	[4] carg		[5] vit		[6] conso
$vaisseaux[1] = array ("Petit transporteur"			,4000		,10		,5		,5000		,5000		,10		);
$vaisseaux[2] = array ("Grand transporteur"			,12000		,25		,5		,25000		,7500		,50		);
$vaisseaux[3] = array ("Chasseur léger"				,4000		,10		,50		,50			,12500		,20		);
$vaisseaux[4] = array ("Chasseur lourd"				,10000		,25		,150	,100		,10000		,75		);
$vaisseaux[5] = array ("Croiseur"					,27000		,50		,400	,800		,15000		,300	);
$vaisseaux[6] = array ("Vaisseau de bataille"		,60000		,200	,1000	,1500		,10000		,500	);
$vaisseaux[7] = array ("Vaisseau de colonisation"	,30000		,100	,50		,7500		,2500		,1000	);
$vaisseaux[8] = array ("Recycleur"					,16000		,10		,1		,20000		,2000		,300	);
$vaisseaux[9] = array ("Sonde espionnage"			,1000		,0.01	,0.01	,5			,100000000	,1		);
$vaisseaux[10] = array ("Bombardier"				,75000		,500	,1000	,500		,4000		,1000	);
$vaisseaux[11] = array ("Satellite solaire"			,2000		,1		,1		,0			,0			,0		);
$vaisseaux[12] = array ("Destructeur"				,110000		,500	,2000	,2000		,5000		,1000	);
$vaisseaux[13] = array ("Étoile de la mort"			,9000000	,50000	,200000	,1000000	,100		,1		);
$vaisseaux[14] = array ("Traqueur"		        	,70000  	,400	,700	,750    	,10000		,250	);

$Armes = $user_technology["Armes"] != "" ? $user_technology["Armes"] : 0;
$RC = $user_technology["RC"] != "" ? $user_technology["RC"] : 0;
$Bouclier = $user_technology["Bouclier"] != "" ? $user_technology["Bouclier"] : 0;
$RI = $user_technology["RI"] != "" ? $user_technology["RI"] : 0;
$Protection = $user_technology["Protection"] != "" ? $user_technology["Protection"] : 0;
$PH = $user_technology["PH"] != "" ? $user_technology["PH"] : 0;



$want = false;
$maj = array(1 => false, false, false, false, false, false, 'armes' => false, 'bouclier' => false, 'protection' => false, 'combustion' => false, 'impulsion' => false, 'hyperespace' => false);
$link = array( 1 => 3, 2 => 2, 3 => 1);
$propulsions = array(1 => 'combustion', 'combustion', 'combustion', 'impulsion', 'impulsion', 'hyperespace', 'impulsion', 'combustion', 'combustion', 'impulsion', 'hyperespace', 'hyperespace', 'hyperespace', 'hyperespace');

if (isset($pub_tech)) {
	/* Indices :
	*   - [0]: Armes
	*   - [1]: Bouclier
	*   - [2]: Protection
	*   - [3]: Combustion
	*   - [4]: Impulsion
	*   - [5]: Hyperespace
	*/
	$want = explode(':', $pub_tech);
	
	if ($want[0] != $Armes) 		{ 	$maj['armes'] 		= true; $maj[1] = true; }
	if ($want[1] != $Bouclier) 		{	$maj['bouclier'] 	= true;	$maj[2] = true; }
	if ($want[2] != $Protection) 	{ 	$maj['protection'] 	= true;	$maj[3] = true; }
	if ($want[3] != $RC) 			{	$maj['combustion'] 	= true;	$maj[4] = true; }
	if ($want[4] != $RI) 			{	$maj['impulsion'] 	= true; $maj[5] = true; }
	if ($want[5] != $PH) 			{	$maj['hyperespace'] = true;	$maj[6] = true; }

	$vaisseaux3 = $vaisseaux;
	if ($want[4] >= 5 && $maj['impulsion']) {
		$vaisseaux3[1][5] = 10000;
		$vaisseaux3[1][6] = 20;
	}

	if ($want[5] >= 8 && $maj['hyperespace']) {
		$vaisseaux3[10][5] = 5000;
		$propulsions[10] = 'hyperespace';
	}

	// Indice de la protection
	if ($maj['protection']) {
		$TP = ($want[2] * 0.1) + 1;
		for ($i=1; $i <= 14; $i++) {
			$vaisseaux3[$i][1] *= $TP;
		}
	}

	// Indice du bouclier
	if ($maj['bouclier']) {
		$TB = ($want[1] * 0.1) + 1;
		for ($i=1; $i <= 14; $i++) {
			$vaisseaux3[$i][2] *= $TB;
		}
	}

	// Indice de l'attaque
	if ($maj['armes']) {
		$TA = ($want[0] * 0.1) + 1;
		for ($i=1; $i <= 14; $i++) {
			$vaisseaux3[$i][3] *= $TA;
		}
	}

	// Indice de la vitesse
	$TRC = ($want[3] * 0.1) + 1;
	$TRI = ($want[4] * 0.2) + 1;
	$TPH = ($want[5] * 0.3) + 1;
	
	if ($want[4] >= 5) {
		$vaisseaux3[1][5] *= $TRI;
		$propulsions[1] = 'impulsion';
	} elseif ($want[4] < $RI && $RI >= 5) {
		$vaisseaux3[1][5] *= $TRC;
		$propulsions[1] = 'impulsion';
	} else {
		$vaisseaux3[1][5] *= $TRC;
	}
	
	
	// Il faut tricher en changeant la prop des BB si on indique un coef de calcul inferieur
	// a la prop hyper et qu'elle soit sup à 5
	if ($want[5] >= 8) {
		$vaisseaux3[10][5] *= $TPH;
		$propulsions[10] = 'hyperespace';
	} elseif ($want[5] < $RH && $RH >= 8) {
		$vaisseaux3[10][5] *= $TRI;
		$propulsions[10] = 'hyperespace';
	} else {
		$vaisseaux3[10][5] *= $TRI;
	}

	if ($maj['combustion']) {
		$vaisseaux3[2][5] *= $TRC;
		$vaisseaux3[3][5] *= $TRC;
		$vaisseaux3[8][5] *= $TRC;
		// On doit ajouter round() pour un bug PHP. Multipliquant de grands nombre il lui arrive de mettre un decimal en dessous de ce que l'on veut
		$vaisseaux3[9][5] = round( $vaisseaux3[9][5] * $TRC);
	}
	if ($maj['impulsion']) {
		$vaisseaux3[4][5] *= $TRI;
		$vaisseaux3[5][5] *= $TRI;
		$vaisseaux3[7][5] *= $TRI;
	}
	if ($maj['hyperespace']) {
		$vaisseaux3[6][5] *= $TPH;
		$vaisseaux3[11][5] *= $TPH;
		$vaisseaux3[12][5] *= $TPH;
		$vaisseaux3[13][5] *= $TPH;
		$vaisseaux3[14][5] *= $TPH;
	}
}


//choix du reacteur pour le PT et le BD
if ($RI >= 5) {
	$vaisseaux[1][5] = 10000;
	$vaisseaux[1][6] = 20;
}
if ($PH >= 8) {
	$vaisseaux[10][5] = 5000;
}

//calc des valeurs avec les technologies
$vaisseaux2 = $vaisseaux;

// Indice de la protection
$TP = ($Protection * 0.1) + 1;
for ($i=1; $i <= 14; $i++) {
	$vaisseaux2[$i][1] *= $TP;
}

// Indice du bouclier
$TB = ($Bouclier * 0.1) + 1;
for ($i=1; $i <= 14; $i++) {
	$vaisseaux2[$i][2] *= $TB;
}

// Indice de l'attaque
$TA = ($Armes * 0.1) + 1;
for ($i=1; $i <= 14; $i++) {
	$vaisseaux2[$i][3] *= $TA;
}

// Indice de la vitesse
$TRC = ($RC * 0.1) + 1;
$TRI = ($RI * 0.2) + 1;
$TPH = ($PH * 0.3) + 1;

if ($RI >= 5) {
	$vaisseaux2[1][5] *= $TRI;
} else {
	$vaisseaux2[1][5] *= $TRC;
}

if ($PH >= 8) {
	$vaisseaux2[10][5] *= $TPH;
}else {
	$vaisseaux2[10][5] *= $TRI;
}

$vaisseaux2[2][5] *= $TRC;
$vaisseaux2[3][5] *= $TRC;
$vaisseaux2[8][5] *= $TRC;
// On doit ajouter round() pour un bug PHP. Multipliquant de grands nombre il lui arrive de mettre un decimal en dessous de ce que l'on veut
$vaisseaux2[9][5] = round( $vaisseaux2[9][5] * $TRC);

$vaisseaux2[4][5] *= $TRI;
$vaisseaux2[5][5] *= $TRI;
$vaisseaux2[7][5] *= $TRI;

$vaisseaux2[6][5] *= $TPH;
$vaisseaux2[11][5] *= $TPH;
$vaisseaux2[12][5] *= $TPH;
$vaisseaux2[13][5] *= $TPH;
$vaisseaux2[14][5] *= $TPH;

// On met en mémoire les stats courants
// On evite alors 6 conditions
$c1 = ($maj['armes'] ? $want[0] : $Armes);
$c2 = ($maj['bouclier'] ? $want[1] : $Bouclier);
$c3 = ($maj['protection'] ? $want[2] : $Protection);
$c4 = ($maj['combustion'] ? $want[3] : $RC);
$c5 = ($maj['impulsion'] ? $want[4] : $RI);
$c6 = ($maj['hyperespace'] ? $want[5] : $PH);

?>
<style type="text/css">
.vert { color: 55FF00; }
.orange { color:FF9900; }
</style>

<script language="javascript" type="text/javascript">
function toogle (id) {
	if(document.getElementById(id).style.display == 'none') {
		document.getElementById(id).style.display = 'block';
	}
	else {
		document.getElementById(id).style.display = 'none';
	}
}

function print(Id, t) {	if (document.getElementById(Id)) document.getElementById(Id).innerHTML = t; }

function change(type, t) {
	if (t == '+') {
		eval(type+' += 1; print("'+type+'", '+type+');');
	} else {
		eval(type+' = ('+type+' == 0 ? 0 : '+type+' - 1); print("'+type+'", '+type+');');
	}
	
	str = 'if ('+type+' == d_'+type+') document.getElementById("'+type+'").className = "vert"; ';
	str += ' else document.getElementById("'+type+'").className = "orange";';
	eval(str);
}

var d_armes = <?php echo $Armes; ?>;
var d_bouclier = <?php echo $Bouclier; ?>;
var d_protect = <?php echo $Protection; ?>;
var d_combustion = <?php echo $RC; ?>;
var d_impulsion = <?php echo $RI; ?>;
var d_hyper = <?php echo $PH; ?>;

var armes = <?php echo $c1; ?>;
var bouclier = <?php echo $c2; ?>;
var protect = <?php echo $c3; ?>;
var combustion = <?php echo $c4; ?>;
var impulsion = <?php echo $c5; ?>;
var hyper = <?php echo $c6; ?>;

</script>

<a href="javascript:void(0);" onclick="toogle('aide');">Afficher / fermer l'aide</a>
<div id="aide" style="display:none;">
<table width="100%">
	<tr>
		<td class="c">Aide</td>
	</tr>
	<tr>
		<th>Ce mod d'OGSpy permet le calcul des statistiques de vos vaisseaux avec vos technologies. Les chiffres entre crochets <span class="vert">verts</span> sont les gains avec vos technologies par rapport aux statistiques de base.<br />Vous pouvez simuler des niveaux de technologies pour ainsi voir le gain / pertes par rapport à vos technologies, ils sont alors affichés en <span class="orange">orange</span>, et la valeur en blanc est celle de la simulation</th>
	</tr>
</table>
</div>
<br />
<table width="100%">
	<tr>
		<td class="c" colspan="2">Choisissez les technologies à simuler</td>
	</tr>
	<tr>
		<th style="text-align:left;" width="50%"><span style="float:left; width:150px;">Technologie armes:</span>
		<span id="armes" style="float:left; width:60px;" class="<?php if ($want && $Armes != @$want[0]) echo 'orange'; else echo 'vert'; ?>"><?php echo $c1; ?></span>
		<input type="button" value="+" onclick="change('armes', '+');" /> <input type="button" value="-" onclick="change('armes', '-');" /><br />
		<span style="float:left; width:150px;">Technologie bouclier:</span>
		<span id="bouclier" style="float:left; width:60px;" class="<?php if ($want && $Bouclier != @$want[1]) echo 'orange'; else echo 'vert'; ?>"><?php echo $c2; ?></span>
		<input type="button" value="+" onclick="change('bouclier', '+');" /> <input type="button" value="-" onclick="change('bouclier', '-');" /><br />
		<span style="float:left; width:150px;">Technologie protection:</span>
		<span id="protect" style="float:left; width:60px;" class="<?php if ($want && $Protection != @$want[2]) echo 'orange'; else echo 'vert'; ?>"><?php echo $c3; ?></span>
		<input type="button" value="+" onclick="change('protect', '+');" /> <input type="button" value="-" onclick="change('protect', '-');" /><br />
		</th>
		
		<th style="text-align:left;" width="50%">
		<span style="float:left; width:150px;">Reacteur a combustion:</span>
		<span id="combustion" style="float:left; width:60px;" class="<?php if ($want && $RC != @$want[3]) echo 'orange'; else echo 'vert'; ?>"><?php echo $c4; ?></span>
		<input type="button" value="+" onclick="change('combustion', '+');" /> <input type="button" value="-" onclick="change('combustion', '-');" /><br />
		<span style="float:left; width:150px;">Reacteur a impulsion:</span>
		<span id="impulsion" style="float:left; width:60px;" class="<?php if ($want && $RI != @$want[4]) echo 'orange'; else echo 'vert'; ?>"><?php echo $c5; ?></span>
		<input type="button" value="+" onclick="change('impulsion', '+');" /> <input type="button" value="-" onclick="change('impulsion', '-');" /><br />
		<span style="float:left; width:150px;">Propulsion hyperespace:</span>
		<span id="hyper" style="float:left; width:60px;" class="<?php if ($want && $PH != @$want[5]) echo 'orange'; else echo 'vert'; ?>"><?php echo $c6; ?></span>
		<input type="button" value="+" onclick="change('hyper', '+');" /> <input type="button" value="-" onclick="change('hyper', '-');" /><br />
		</th>
	</tr>
	<tr>
		<th colspan="2"><input type="button" value="Charger" onclick="document.location = 'index.php?action=vaisseaux&tech='+armes+':'+bouclier+':'+protect+':'+combustion+':'+impulsion+':'+hyper;" /></th>
	</tr>
</table>

<table width="100%">
<tr>
	<td class="c" colspan="4">Technologies</td>
</tr>
<tr>
	<th width="33%">Technologie Armes </th>
	<th width="16%"><span class="vert"><?php echo $Armes; ?></span><?php if ($maj[1]) echo ' <span class="orange">['.$want[0].']</span>'; ?></th>
	
	<th width="33%">Réacteur à combustion </th>
	<th width="16%"><span class="vert"><?php echo $RC; ?></span><?php if ($maj[4]) echo ' <span class="orange">['.$want[3].']</span>'; ?></th>
</tr>
<tr>
	<th width="33%">Technologie Bouclier </th>
	<th width="16%"><span class="vert"><?php echo $Bouclier; ?></span><?php if ($maj[2]) echo ' <span class="orange">['.$want[1].']</span>'; ?></th>
	
	<th width="33%">Réacteur à impulsion </th>
	<th width="16%"><span class="vert"><?php echo $RI; ?></span><?php if ($maj[5]) echo ' <span class="orange">['.$want[4].']</span>'; ?></th>
</tr>
<tr>
	<th width="33%">Technologie Protection des vaisseaux spatiaux </th>
	<th width="16%"><span class="vert"><?php echo $Protection; ?></span><?php if ($maj[3]) echo ' <span class="orange">['.$want[2].']</span>'; ?></th>
	
	<th width="33%">Propulsion hyperespace</th>
	<th width="16%"><span class="vert"><?php echo $PH; ?></span><?php if ($maj[6]) echo ' <span class="orange">['.$want[5].']</span>'; ?></th>
</tr>
</table>
<br />
<table width="100%">
<tr>
	<td class="c" colspan="7">Vue des caractéristiques avec les technologies des vaisseaux</td>
</tr>
<tr>
	<th><a>Vaisseaux</a></th>
	<th><a>Points de structure</a></th>
	<th><a>Puissance du bouclier</a></th>
	<th><a>Valeur d'attaque</a></th>
	<th><a>Capacité de fret</a></th>
	<th><a>Vitesse réelle</a></th>
	<th><a>Consommation de<br>carburant (Deutérium)</a></th>
</tr>
<?php
// Affichage caractéristiques

for ($b=1; $b <= 14; $b++){
	echo '<tr>';
	echo '<th>'.$vaisseaux[$b][0].'</th>';
	
	for ($i=1; $i <= 6; $i++) {
		// On ne calcule pas pour la consommation et la cargaison
		if ($i != 4 && $i != 6) {
			$alpha = ($maj[$link[$i]]|| ($i == 5 && $maj[$propulsions[$b]]) ? $vaisseaux3[$b][$i] : $vaisseaux2[$b][$i]) . ' <br /><span class="vert" style="cursor:pointer;" title="Au départ: '.$vaisseaux[$b][$i].'">[+'. ($vaisseaux2[$b][$i] - $vaisseaux[$b][$i]) .']</span>';
			
			if ($maj[$link[$i]] || ($i == 5 && $maj[$propulsions[$b]])) {
				$num = $vaisseaux3[$b][$i] - $vaisseaux2[$b][$i];
				$num = ($num < 0 ? $num : '+'.$num);
				$alpha .= ' <span class="orange" style="cursor:pointer;" title="Avec vos techs: '.$vaisseaux2[$b][$i].'">['.$num.']</span>';
			}
	
		} else {
			$alpha = $vaisseaux[$b][$i];
		}
		echo '<th>'.$alpha.'</th>';
	}
	echo '</tr>';
}
?>
</tr>
</table>
<br />
<table width="100%">
<tr>
	<td class="c" colspan="7">Temps de voyage (aller) entre differentes destinations</td>
</tr>
<tr>
	<th><a>Vaisseaux</a></th>
	<th><a>Vers +/- 10 systèmes</a></th>
	<th><a>Vers +/- 20 systèmes</a></th>
	<th><a>Vers +/- 50 systèmes</a></th>
	<th><a>Vers +/- 1 galaxie</a></th>
</tr>
<?php

// Affichage vitesses
for ($b=1; $b <= 14; $b++){
	echo '<tr>';
	echo '<th>'.$vaisseaux[$b][0].'</th>';

	for ($i=1; $i <= 4; $i++) {
		
		// On affiche un - pour les sat sol : ils ne peuvent pas bouger
		if ($b == 11) {
			$alpha = '-';
		} else {
			// Calcul de toutes les vitesses avec toutes les techs
			// Faut savoir dans quelle colonne on est pour trouver la formule
			// pour $i :
			// [1] : 10 systemes	[2] : 20 systemes	[3] : 50 systemes	[4] : 1 galaxie
			$vitesse3 = 0;
			if ($i == 1) {
				$vitesse 	= floor(10 + ( 350 * sqrt((2700000 + 10 * 95000) / $vaisseaux[$b][5]) ));
				$vitesse2 	= floor(10 + ( 350 * sqrt((2700000 + 10 * 95000) / $vaisseaux2[$b][5]) ));
				if ($maj[$propulsions[$b]]) {
					$vitesse3 	= floor(10 + ( 350 * sqrt((2700000 + 10 * 95000) / $vaisseaux3[$b][5]) ));
				}
			} elseif ($i == 2) {
				$vitesse 	= floor(10 + ( 350 * sqrt((2700000 + 20 * 95000) / $vaisseaux[$b][5]) ));
				$vitesse2 	= floor(10 + ( 350 * sqrt((2700000 + 20 * 95000) / $vaisseaux2[$b][5]) ));
				if ($maj[$propulsions[$b]]) {
					$vitesse3 	= floor(10 + ( 350 * sqrt((2700000 + 20 * 95000) / $vaisseaux3[$b][5]) ));
				}
			} elseif ($i == 3) {
				$vitesse 	= floor(10 + ( 350 * sqrt((2700000 + 50 * 95000) / $vaisseaux[$b][5]) ));
				$vitesse2 	= floor(10 + ( 350 * sqrt((2700000 + 50 * 95000) / $vaisseaux2[$b][5]) ));
				if ($maj[$propulsions[$b]]) {
					$vitesse3 	= floor(10 + ( 350 * sqrt((2700000 + 50 * 95000) / $vaisseaux3[$b][5]) ));
				}
			} else {
				$vitesse 	= floor(10 + ( 350 * sqrt(20000000 / $vaisseaux[$b][5]) ));
				$vitesse2 	= floor(10 + ( 350 * sqrt(20000000 / $vaisseaux2[$b][5]) ));
				if ($maj[$propulsions[$b]]) {
					$vitesse3 	= floor(10 + ( 350 * sqrt(20000000 / $vaisseaux3[$b][5]) ));
				}
			}

			$alpha = format( ($maj[$propulsions[$b]] ? $vitesse3 : $vitesse2 ) ) . ' <br /><span class="vert" style="cursor:pointer;" title="Au départ: '.format($vitesse).'">[-'. format($vitesse - $vitesse2) .']</span>';
			if ($maj[$propulsions[$b]]) {
				$vit = $vitesse2 - $vitesse3;
				$vit = ($vit < 0 ? '+'.format(-$vit) : '-'.format($vit));
				$alpha .= ' <span class="orange" style="cursor:pointer;" title="Avec vos techs: '.format($vitesse2).'">['. $vit .']</span>';
			}

		}

		echo '<th>'.$alpha.'</th>';
	}
	echo '</tr>';
}
?>
</tr>
</table>

<div style="text-align:center; font-weight:bold; margin-top:30px; border-top:1px dotted #CCCCCC;" class="vert">:: Mod refait entièrement par Unibozu ::</div>


<?php 
//Récupére le numéro de version du mod
$request = 'SELECT `version` from `'.TABLE_MOD.'` WHERE title=\'vaisseaux\'';
$result = $db->sql_query($request);
list($version) = $db->sql_fetch_row($result);
echo '</tr>
	</table>
	<table border="0" width="100%" cellpadding="0" cellspacing="0" align="center">
		<tr align="center">
			<td>
				<center>
				<font size="2">
					<i>Vaisseaux (v'.$version.') Mise à Jour par Shad</i>
				</font>
				</center>';
require_once('views/page_tail.php'); 
ob_flush();

?>

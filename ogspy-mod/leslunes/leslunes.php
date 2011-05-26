<?php /**
* leslunes.php Page principal du mod
* @package [MOD] Tout sur les lunes
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 0.3b
*	created		: 21/08/2006
*	modified	: /09/2006
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

require_once("views/page_header.php");
// on récupère la vitesse de l'uni
$speed = $server_config['speed_uni'];
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='leslunes' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//Menu de navigation entre les mods
if (!isset($pub_subaction)) {
	$subaction = "dest";
	$pub_subaction = "dest";
} else $subaction = $pub_subaction;

if ($subaction != "dest") {
	$bouton1 = "\t\t\t"."<td class='c' align='center' width='150' onclick=\"window.location = 'index.php?action=leslunes&subaction=dest';\">";
	$bouton1 .= "<a style='cursor:pointer'><font color='lime'>Destruction de lunes</font></a>";
	$bouton1 .= "</td>";
}
else {
	$bouton1 = "\t\t\t"."<th width='150'>";
	$bouton1 .= "<a>Destruction de lunes</a>";
	$bouton1 .= "</th>";
}

if ($subaction != "flotte") {
	$bouton2 = "\t\t\t"."<td class='c' align='center' width='150' onclick=\"window.location = 'index.php?action=leslunes&subaction=flotte';\">";
	$bouton2 .= "<a style='cursor:pointer'><font color='lime'>Retour de flotte</font></a>";
	$bouton2 .= "</td>";
}
else {
	$bouton2 = "\t\t\t"."<th width='150'>";
	$bouton2 .= "<a>Retour de flotte</a>";
	$bouton2 .= "</th>";
}
if ($subaction != "changelog") {
		$bouton3 = "\t\t\t"."<td class='c' align='center' width='150' onclick=\"window.location = 'index.php?action=leslunes&subaction=changelog';\">";
		$bouton3 .= "<a style='cursor:pointer'><font color='lime'>Changelog</font></a>";
		$bouton3 .= "</td>";
	}
	else {
		$bouton3 = "\t\t\t"."<th width='150'>";
		$bouton3 .= "<a>Changelog</a>";
		$bouton3 .= "</th>";
}

echo "<table width=60%>\n";
	echo $bouton1.$bouton2.$bouton3;
	echo "</table>\n";

if(!isset($pub_val)) {
	$pub_val = "";
	$pub_CGA = "";
	$pub_DJ = "";
	$pub_HH = "";
	$pub_HM = "";
	$pub_HS = "";
	$pub_CSA = "";
	$pub_DM = "";
	$pub_DA = "";
	$pub_CPA = "";
	$pub_CSD = "";
	$pub_CPD = "";
	$pub_CGD = "";
	for ($i = 1; $i <= 12; $i++) {
		$pub_vaisseaux[$i] = "0";
	}
}

/**
*Récupération des technologies
*/
if ($pub_val != "post") {
	$req1 = "SELECT * FROM ".TABLE_USER_TECHNOLOGY." WHERE user_id='".$user_data['user_id']."'";
	$result1 = mysql_query($req1);
	$fetch1 = mysql_fetch_array($result1);
	$pub_RC = $fetch1['RC'];
	$pub_RI = $fetch1['RI'];
	$pub_PH = $fetch1['PH'];
}

/**
*Valeurs des vaisseaux
*/
$vaisseaux[1]=array ("Petit transporteur","5000(10000)");
$vaisseaux[2]=array ("Grand transporteur","7500");
$vaisseaux[3]=array ("Chasseur léger","12500");
$vaisseaux[4]=array("Chasseur lourd","10000");
$vaisseaux[5]=array ("Croiseur","15000");
$vaisseaux[6]=array ("Vaisseau de bataille","10000");
$vaisseaux[7]=array ("Vaisseau de colonisation","2500");
$vaisseaux[8]=array ("Recycleur","2000");
$vaisseaux[9]=array ("Sonde espionnage","100000000");
$vaisseaux[10]=array ("Bombardier","4000(5000)");
$vaisseaux[11]=array ("Destructeur","5000");
$vaisseaux[12]=array ("Étoile de la mort","100");

if (isset($pub_subaction)) {
	switch ($pub_subaction) {
		case "flotte" :			
			if (isset($pub_val) AND $pub_val != "") {
				if ($pub_RI>=5) {
					$vaisseaux[1][1]= "10000";
				}
				else {
					$vaisseaux[1][1]="5000";
				}
				if($pub_PH>=8) {
					$vaisseaux[10][1]="5000";
				}
				else {
					$vaisseaux[10][1]="4000";
				}
/**
*Code mod_vaisseaux modifié
*/			
	/**
	*calc des valeurs avec les technologies
	*/
	$TRC=($pub_RC*0.1)+1;
	$TRI=($pub_RI*0.2)+1;
	$TPH=($pub_PH*0.3)+1;
	if ($pub_RI>=5) {
		$vaisseaux[1][1]=$vaisseaux[1][1]*$TRI;
	} else {$vaisseaux[1][1]=$vaisseaux[1][1]*$TRC;}
	if ($pub_PH>=8) {
		$vaisseaux[10][1]=$vaisseaux[10][1]*$TPH;
	}else {$vaisseaux[10][1]=$vaisseaux[10][1]*$TRI;}
	$vaisseaux[2][1]=$vaisseaux[2][1]*$TRC;
	$vaisseaux[3][1]=$vaisseaux[3][1]*$TRC;
	$vaisseaux[4][1]=$vaisseaux[4][1]*$TRI;
	$vaisseaux[5][1]=$vaisseaux[5][1]*$TRI;
	$vaisseaux[6][1]=$vaisseaux[6][1]*$TPH;
	$vaisseaux[7][1]=$vaisseaux[7][1]*$TRI;
	$vaisseaux[8][1]=$vaisseaux[8][1]*$TRC;
	$vaisseaux[9][1]=$vaisseaux[9][1]*$TPH;
	$vaisseaux[11][1]=$vaisseaux[11][1]*$TPH;
	$vaisseaux[12][1]=$vaisseaux[12][1]*$TPH;

				for ($i=1; $i<=12; $i++) {
					if (!empty($pub_vaisseaux[$i])){
						$flotte[$i] = $vaisseaux[$i][1];
					}
				}
			$vitesse = min($flotte);
			}
		echo "<form action='?action=leslunes&subaction=flotte&val=post' method='post'>";
		/**
		*Technologies et Coordonnées
		*/ ?><table width="90%">
					<tr>
						<td class='c' colspan="2" align="center">Technologies</td>
						<td class='c' colspan="2" align="center">Coordonnées</td>
					</tr>
					<tr>
						<th width="23%">Réacteur à combustion</th>
						<th width="23%"><input type="text" name="RC" value="<?php echo $pub_RC; ?>"/></th>
						<th width="22%">Départ</th>
						<th width="22%"><input maxlength="1" type="text" name="CGD" value="<?php echo $pub_CGD; ?>" size="5%"/>:
							<input maxlength="3" type="text" name="CSD" value="<?php echo $pub_CSD; ?>" size="5%"/>:
							<input maxlength="2" type="text" name="CPD" value="<?php echo $pub_CPD; ?>" size="5%"/>
						</th>
					</tr>
					<tr>
						<th width="23%">Réacteur à impulsion</th>
						<th width="23%"><input type="text" name="RI" value="<?php echo $pub_RI; ?>"/></th>
						<th width="22%">Arrivée</th>
						<th width="22%"><input type="text" name="CGA" value="<?php echo $pub_CGA; ?>" size="5%"/>:
							<input type="text" name="CSA" value="<?php echo $pub_CSA; ?>" size="5%"/>:
							<input type="text" name="CPA" value="<?php echo $pub_CPA; ?>" size="5%"/>
						</th>
					</tr>
					<tr>
						<th width="23%">Propulsion hyperespace</th>
						<th width="23%"><input type="text" name="PH" value="<?php echo $pub_PH; ?>"/></th>
						<th width="22%">Date d'arrivée</th>
						<th width="22%"><input maxlength="2" type="text" name="DJ" value="<?php echo $pub_DJ; ?>" size="5%" align="center"/>/
							<input maxlength="2" type="text" name="DM" value="<?php echo $pub_DM; ?>" size="5%"/>/
							<input maxlength="4" type="text" name="DA" value="<?php echo $pub_DA; ?>" size="5%"/>
						</th>
					</tr>
					<tr>
						<th width="23%">&nbsp;</th>
						<th width="23%">&nbsp;</th>
						<th width="22%">Heure d'arrivée</th>
						<th width="22%"><input maxlength="2" type="text" name="HH" value="<?php echo $pub_HH; ?>" size="5%"/>H
							<input maxlength="2" type="text" name="HM" value="<?php echo $pub_HM; ?>" size="5%"/>Min
							<input maxlength="2" type="text" name="HS" value="<?php echo $pub_HS; ?>" size="5%"/></th>
					</tr>
				</table><?php
		/**
		*Vaisseaux
		*/ ?>
			<table width="90%">
					<tr>
						<td class="c" colspan="2" align="center">Vaisseaux</td>
						<td class="c" align="center">Vitesse</td>
						<td class="c" align="center">Départ</td>
						<td class="c" align="center">Arrivée</td>
					</tr><?php
					for ($i=1; $i<=12; $i++) {
					if($i<=10 && $pub_val=='post') {
						$pvitesse = $i*10;
					
						if ($pub_CGD==$pub_CGA){
							if ($pub_CSD==$pub_CSA){
								if ($pub_CPD==$pub_CPA) {
								$temps = round(10 + (35000/($speed * $pvitesse) * sqrt(5000/$vitesse)),0);
								} else {
								$temps = round(10 + (35000/($speed * $pvitesse) * sqrt((1000000 + abs($pub_CPD-$pub_CPA)*5000)/$vitesse)));
								}
							} else {
							$temps = round(10 + (35000/($speed * $pvitesse) * sqrt((2700000+abs($pub_CSD-$pub_CSA)*95000)/$vitesse)));
							}
						}
						else {
						$temps = round(10+(35000/($speed * $pvitesse) * sqrt((abs($pub_CGD-$pub_CGA)*20000000)/$vitesse)));
						}
					}
					else {
						$pvitesse = "";
						$temps = 0;
					}
					/**
					*départ
					*/ ?>
					<tr>
						<th width="23%"><?php echo $vaisseaux[$i][0]; ?></th>
						<th width="23%"><input type="text" name="vaisseaux[<?php echo $i; ?>]" value="<?php echo $pub_vaisseaux[$i]; ?>"/></th>
						<th width="10%"><?php
						if ($i<=10 && $pub_val=='post') {
						echo $pvitesse." %";
						}
						echo "</th>\n"
						."\t\t<th witdh=\"17%\">";
					
						if ($i<=10 && $pub_val=='post') {
						echo date('H:i:s', mktime(0,0,$temps,$pub_DM,$pub_DJ,$pub_DA));
						echo " - ", date('d/m/Y H:i:s', mktime($pub_HH,$pub_HM,$pub_HS - $temps,$pub_DM,$pub_DJ,$pub_DA));
						}
					echo "</th>\n"
					//arrivée
						."\t\t<th witdh=\"17%\">";
					
						if ($i<=10 && $pub_val=='post'){
						echo date('d/m/Y H:i:s', mktime($pub_HH,$pub_HM,$pub_HS + $temps,$pub_DM,$pub_DJ,$pub_DA));
						}
					echo "</th>\n"
						."\t</tr>\n";
					} ?>

			</table>
				
		<table width="90%">
			<tr>
				<td align="center"><input type="submit"></form></td>
			</tr>
		</table><?php ; break;
		case "dest" :
			if ((isset($pub_calcul) AND $pub_calcul == 'Calculer') AND ($pub_tl != '' AND $pub_tl != '0')) {
				$case = ($pub_tl / 1000);
				$case1 = floor($case * $case);
				if (isset($pub_ne)) {
					$dest = round((sqrt($pub_tl) / 2), 3);
					$pourc = round(((100 - sqrt($pub_tl)) * sqrt($pub_ne)), 3);
					$pour_cent1 = 100 / (100 - sqrt($pub_tl));
					$pour_cent = round($pour_cent1 * $pour_cent1);
				} else {
					$dest = "-";
					$pourc = "-";
					$pour_cent = "-";
				}
				if (isset($pub_pdls) AND $pub_pdls <= '100') {
					$nombre = $pub_pdls / (100 - sqrt($pub_tl));
					$don = round(($nombre * $nombre), 0);
				} else $don = "Pas plus de 100%";
			} else {
				$dest = "-";
				$pourc = "-";
				$pour_cent = "-";
				$don = "-";
				$case1 = "-";
				$pub_tl = "";
				$pub_ne = "";
				$pub_pdls = "";
			} ?>
	<div style="text-align : center">
	<form method="post" action="index.php?action=leslunes"><br />
	<table align="center">
		<tbody>
			<tr>
				<td class="c" align="center" colspan="5">[Mod] Tout sur les lunes</td>
			</tr>
			<tr>
				<td class="c">Nom des données</td>
				<td class="c">Données</td>
				<td class="c">Pourcentage de<br />chance de réussite</td>
				<td class="c">Pourcentage de<br />chance de destruction des EDLM</td>
				<td class="c">Nombre d'EDLM<br />pour 100% de réussite</td>
			</tr>
			<tr>
				<td>Nombre d'EDLM</td>
				<td><input type="text" name="ne" value="<?php echo $pub_ne; ?>"/></td>
				<td class="a"><?php echo $pourc; ?></td>
				<td class="a"><?php echo $dest; ?></td>
				<td class="a"><?php echo $pour_cent; ?></td>
			</tr>
			<tr>
				<td>Taille de la lune (Km)</td>
				<td><input type="text" name="tl" maxlength="4" value="<?php echo $pub_tl; ?>"/></td>
				<td class="c">Nombre d'EDLM nécessaire<br />pour le pourcentage demandé</td>
				<td class="c">Nombre potentiel de cases</td>
				<td></td>
			</tr>
			<tr>
				<td>Pourcentage de chance de destruction de lune souhaité</td>
				<td><input type="text" name="pdls" maxlength="6" value="<?php echo $pub_pdls; ?>"/></td>
				<td class="a"><?php echo $don; ?></td>
				<td class="a"><?php echo $case1; ?></td>
				<td></td>
			</tr>
			<tr>
				<td><br /></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="calcul" value="Calculer"/></td>
				<td><a href="index.php?action=leslunes"><input type="reset" name="reset" value="Tout effacer"/></a></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>
	</form>
<?php break;
		case "changelog" :	
?>
		<table style='width:60%'>
		<tr style='line-height : 20px; vertical-align : center;'>
						<td class='c' style='text-align : center; width : 20%; color : #FF00FF;'>Version</td>
						<td class='c' style='text-align : center; color : #FF00FF;'>Modification</td>
					</tr>
					<tr>
						<td style='background-color : #273234; text-align : center;'>0.3b</td>
						<td style='background-color : #273234;'>
							<ul>
								<li>Version initiale avec affichage sur une seule page</li>
							</ul>
						</td>
					</tr>
										<tr>
						<td style='background-color : #273234; text-align : center;'>1.0.0</td>
						<td style='background-color : #273234;'>
							<ul>
								<li>Prise en compte de la vitesse de l'univers</li>
								<li>Changement de la partie Administration en Changelog</li>
								<li>Adaption du mod à OGSpy v3.0.7</li>
							</ul>
						</td>
					</tr>
		</tr>
		</table>
<?php				
	}
} ?>
<br />
Tout sur les lunes version <?php $ver = "SELECT version FROM ".TABLE_MOD." where action = 'leslunes'";
$ver1 = mysql_query($ver);
$donne = mysql_fetch_array($ver1);
echo $donne['version']; ?><br>
Créé par Bartheleway.</div>
<?php
require_once("views/page_tail.php");
?>
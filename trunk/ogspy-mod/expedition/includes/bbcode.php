<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'accès direct
//définition de la page
$pageBBCode = <<<HEREBBCODE

<!-- DEBUT Insertion mod eXpedition : BBCode -->

<br /><br /><br /><br />
HEREBBCODE;

$pageBBCode .= <<<HEREBBCODE
	<strong>
	<a href="index.php?action=eXpedition&module=bbcode&idexp=-1"> Mes stats du mois </a> - 
	<a href="index.php?action=eXpedition&module=bbcode&idexp=-2"> Toutes mes stats</a> -
	<a href="index.php?action=eXpedition&module=bbcode&idexp=-3"> Stats de tout le monde du mois</a> - 
	<a href="index.php?action=eXpedition&module=bbcode&idexp=-4"> Toutes les stats de tout le monde.</a><br />
	Ou choisissez l'identifiant d'eXpedition (allez voir dans les détails perso) :
		<form name='form' method='get' action=''>				
				<input type="hidden" name="action" value="eXpedition">  
				<input type="hidden" name="module" value="bbcode">  
				Id : <input value='1' type='text' name='idexp'>				
				<input value='Valider' type='submit'>
		</form>
		</strong>
	

HEREBBCODE;


if(isset($pub_idexp))
{
		$colText		= "#00FF00";
		$colTitre		= "#FF0000";
		$colDate		= "#00FFFF";
		$colPlayer	= "#00FF00";
		$colPos		= "#FFFF00";
		$colPts	    	= "#FF5500";
		
		$boldDeb		= array("[b]", "<strong>");
		$boldFin		= array("[/b]", "</strong>");
		
		
		$colorVaiss[0] = array ("[color=#FF9900]", "[color=#00FF00]", "[color=#33FF99]", "[color=#FF00FF]", "[color=#00FFFF]", "[color=#FFCC00]", "[color=#EEC273]", "[color=#0099FF]", "[color=#FF0099]", "[color=#00FF99]", "[color=#00B0B0]", "[color=#B000B0]", "[color=#FF9900]");
		$colorVaiss[1] = array ("<font color=#FF9900>", "<font color=#00FF00>", "<font color=#33FF99>", "<font color=#FF00FF>", "<font color=#00FFFF>", "<font color=#FFCC00>", "<font color=#EEC273>", "<font color=#0099FF>", "<font color=#FF0099>", "<font color=#00FF99>", "<font color=#00B0B0>", "<font color=#B000B0>", "<font color=#FF9900>");
		
		$colorText	= array("[color=$colText]", "<font color=$colText>");
		$colorTitre	= array("[color=$colTitre]", "<font color=$colTitre>");
		$colorDate	= array("[color=$colDate]", "<font color=$colDate>");
		$colorPlayer	= array("[color=$colPlayer]", "<font color=$colPlayer>");
		$colorPos		= array("[color=$colPos]", "<font color=$colPos>");
		$colorPts		= array("[color=$colPts]", "<font color=$colPts>");
		$colorFin		= array("[/color]", "</font>");
	
	if($pub_idexp < 0)
	{;
		if($pub_idexp == -1) 
		{
			$stats = readDB($user_data['user_id'], mktime(0, 0, 0, date('m'), 1, date('Y')), mktime(0, 0, 0, date('m')+1, 1, date('Y'))); 
			for($i = 0 ; $i < 2 ; $i++)
			{
				$rapportBBCode[$i]  =  $boldDeb[$i];
					$rapportBBCode[$i] .= 	$colorTitre[$i];				
						$rapportBBCode[$i] .= "Stats de ".getuserNameById($user_data['user_id'])." pour le mois ".date('m/Y');	
					$rapportBBCode[$i] .= 	$colorFin[$i];
				$rapportBBCode[$i] .= 	$boldFin[$i];
			}
		}
		if($pub_idexp == -2) 
		{
			$stats = readDB($user_data['user_id']); 
			for($i = 0 ; $i < 2 ; $i++)
			{
				$rapportBBCode[$i]  = 	$boldDeb[$i];
					$rapportBBCode[$i] .= 	$colorTitre[$i];			
						$rapportBBCode[$i] .= "Stats de ".getuserNameById($user_data['user_id'])." depuis le ".date('d/m/Y', $stats['dateOrigine']);
					$rapportBBCode[$i] .= 	$colorFin[$i];
				$rapportBBCode[$i] .= 	$boldFin[$i];
			}
		}
		if($pub_idexp == -3) 
		{
			$stats = readDB(0, mktime(0, 0, 0, date('m'), 1, date('Y')), mktime(0, 0, 0, date('m')+1, 1, date('Y'))); 
			for($i = 0 ; $i < 2 ; $i++)
			{
				$rapportBBCode[$i]  = 	$boldDeb[$i];
					$rapportBBCode[$i] .= 	$colorTitre[$i];				
						$rapportBBCode[$i] .= "Stats globales pour le mois ".date('m/Y');	
					$rapportBBCode[$i] .= 	$colorFin[$i];
				$rapportBBCode[$i] .= 	$boldFin[$i];
			}
			
		}
		if($pub_idexp == -4)
		{
			$stats = readDB();
			for($i = 0 ; $i < 2 ; $i++)
			{
				$rapportBBCode[$i]  = 	$boldDeb[$i];
					$rapportBBCode[$i] .= 	$colorTitre[$i];				
						$rapportBBCode[$i] .= "Stats globales depuis le ".date('d/m/Y', $stats['dateOrigine']);
					$rapportBBCode[$i] .= 	$colorFin[$i];
				$rapportBBCode[$i] .= 	$boldFin[$i];
			} 
		}
		if($pub_idexp < -4) die('Sucker !');
		for($i = 0 ; $i < 2 ; $i++)
		{
$rapportBBCode[$i] .= <<<HERESTAT
		<br />
		Nombre total d'eXpedition :  											$boldDeb[$i]	$colorTitre[$i]	$stats[nombreExpTot]		$colorFin[$i]		$boldFin[$i] 		<br />
		Nombre d'eXpeditions ayant ramené des ressources : 	$boldDeb[$i]	$colorTitre[$i]	$stats[nombreExpRess]	$colorFin[$i]	 $colorPts[$i]	 ($stats[pourcentExpRess]%)		$colorFin[$i]		$boldFin[$i] 		<br />
		Nombre d'eXpeditions ayant ramené des vaisseaux : 	$boldDeb[$i]	$colorTitre[$i]	$stats[nombreExpVaiss]		$colorFin[$i]	 $colorPts[$i]	 ($stats[pourcentExpVaiss]%)		$colorFin[$i]		$boldFin[$i] 		<br />
		Nombre d'eXpeditions ayant ramené un marchand : 	$boldDeb[$i]	$colorTitre[$i]	$stats[nombreExpMarch] 	$colorFin[$i]	 $colorPts[$i]	 ($stats[pourcentExpMarch]%)	$colorFin[$i]		$boldFin[$i] 		<br />
		Nombre d'eXpeditions n'ayant rien ramené : 					$boldDeb[$i]	$colorTitre[$i]	$stats[nombreExpRate]		 $colorFin[$i]	 $colorPts[$i]	($stats[pourcentExpRate]%)		$colorFin[$i]		$boldFin[$i] 		<br />
		<br />
		Total des ressources récoltées : <br />
			Métal 													$boldDeb[$i]	$colorTitre[$i]	$stats[sumMetal]			$colorFin[$i]		$boldFin[$i] 		<br />
			Cristal 													$boldDeb[$i]	$colorTitre[$i]	$stats[sumCristal]			$colorFin[$i]		$boldFin[$i] 		<br />
			Deutérium 											$boldDeb[$i]	$colorTitre[$i]	$stats[sumDeuterium]	$colorFin[$i]		$boldFin[$i] 		<br />
			Antimatière 											$boldDeb[$i]	$colorTitre[$i]	$stats[sumAntiMat]			$colorFin[$i]		$boldFin[$i] 		<br />
			<br />
			Moyenne par eXp : 								$boldDeb[$i]	$colorTitre[$i]	$stats[moyRess]				$colorFin[$i]		$boldFin[$i] 		<br />
			Total en points : 									$boldDeb[$i]	$colorTitre[$i]	$stats[totPtRess]				$colorFin[$i]		$boldFin[$i] 		<br />
			<br />
		Total des vaisseaux ramenés :<br />
			Petit Transporteur 								$boldDeb[$i]	$colorTitre[$i]	$stats[sumpt] 		$colorFin[$i]	 $colorPts[$i]		($stats[sumUpt] pts)		$colorFin[$i]		$boldFin[$i] 		<br />
			Grand Transporteur 								$boldDeb[$i]	$colorTitre[$i]	$stats[sumgt] 		$colorFin[$i]	 $colorPts[$i]		($stats[sumUgt] pts)		$colorFin[$i]		$boldFin[$i] 		<br />
			Chasseur Léger 									$boldDeb[$i]	$colorTitre[$i]	$stats[sumcle] 	$colorFin[$i]	 $colorPts[$i]		($stats[sumUcle] pts)		$colorFin[$i]		$boldFin[$i] 		<br />
			Chasseur Lourd 									$boldDeb[$i]	$colorTitre[$i]	$stats[sumclo]	$colorFin[$i]	 $colorPts[$i]		($stats[sumUclo] pts)		$colorFin[$i]		$boldFin[$i] 		<br />
			Croiseur 												$boldDeb[$i]	$colorTitre[$i]	$stats[sumcr] 		$colorFin[$i]	 $colorPts[$i]		($stats[sumUcr] pts)		$colorFin[$i]		$boldFin[$i] 		<br />
			Vaisseau de Bataille 							$boldDeb[$i]	$colorTitre[$i]	$stats[sumvb] 	$colorFin[$i]	 $colorPts[$i]		($stats[sumUvb] pts)		$colorFin[$i]		$boldFin[$i] 		<br />
			Vaisseau de Colonisation 					$boldDeb[$i]	$colorTitre[$i]	$stats[sumvc] 	$colorFin[$i]	 $colorPts[$i]		($stats[sumvc] pts)			$colorFin[$i]		$boldFin[$i] 		<br />
			Recycleur												$boldDeb[$i]	$colorTitre[$i]	$stats[sumrec] 	$colorFin[$i]	 $colorPts[$i]		($stats[sumrec] pts)		$colorFin[$i]		$boldFin[$i] 		<br />
			Sonde d'Espionnage 							$boldDeb[$i]	$colorTitre[$i]	$stats[sumse] 	$colorFin[$i]	 $colorPts[$i]		($stats[sumUse] pts)		$colorFin[$i]		$boldFin[$i] 		<br />
			Bombardier 											$boldDeb[$i]	$colorTitre[$i]	$stats[sumbmb]		$colorFin[$i]	 $colorPts[$i]	($stats[sumUbmb] pts)	$colorFin[$i]		$boldFin[$i] 		<br />
			Destructeur									 		$boldDeb[$i]	$colorTitre[$i]	$stats[sumdst] 	$colorFin[$i]	 $colorPts[$i]		($stats[sumUdst] pts)		$colorFin[$i]		$boldFin[$i] 		<br />
			Traqueur 												$boldDeb[$i]	$colorTitre[$i]	$stats[sumtra] 	$colorFin[$i]	 $colorPts[$i]		($stats[sumUtra] pts)		$colorFin[$i]		$boldFin[$i] 		<br />
			Moyenne en nombre par eXp :			$boldDeb[$i]	$colorTitre[$i]	$stats[moyVaiss]			$colorFin[$i]		$boldFin[$i] 		<br />
			Moyenne en points par eXp : 				$boldDeb[$i]	$colorTitre[$i]	$stats[moyUVaiss]		$colorFin[$i]		$boldFin[$i] 		<br />
			Moyenne en nombre par eXp Vaiss. : 	$boldDeb[$i]	$colorTitre[$i]	$stats[moyVVaiss]		$colorFin[$i]		$boldFin[$i] 		<br />
			Moyenne en points par eXp Vaiss. : 	$boldDeb[$i]	$colorTitre[$i]	$stats[moyUVVaiss]	$colorFin[$i]		$boldFin[$i] 		<br />
			Total en nombre : 								$boldDeb[$i]	$colorTitre[$i]	$stats[totVaiss]			$colorFin[$i]		$boldFin[$i] 		<br />
			Total en points : 									$boldDeb[$i]	$colorTitre[$i]	$stats[totUVaiss]			$colorFin[$i]		$boldFin[$i] 		<br />		
HERESTAT;
		}
	}
	else
	{	
		$eXp = geteXpById($pub_idexp);
		if (!isset($eXp['date'])) die('eXpedition inexistante...');
		for($i = 0 ; $i < 2 ; $i++)
		{
			$rapportBBCode[$i]  = 	$boldDeb[$i];
				$rapportBBCode[$i] .= 	$colorText[$i];					$rapportBBCode[$i] .= 	"Lors de l'";																					$rapportBBCode[$i] .= 	$colorFin[$i];			
				$rapportBBCode[$i] .= 	$colorTitre[$i];					$rapportBBCode[$i] .= 	"eXpedition";																				$rapportBBCode[$i] .= 	$colorFin[$i];			
				$rapportBBCode[$i] .= 	$colorText[$i];					$rapportBBCode[$i] .= 	" du ";																							$rapportBBCode[$i] .= 	$colorFin[$i];
				$rapportBBCode[$i] .= 	$colorDate[$i];					$rapportBBCode[$i] .= 	date('d-m-Y H:i:s', $eXp['date']);				 									$rapportBBCode[$i] .= 	$colorFin[$i];
				$rapportBBCode[$i] .= 	$colorText[$i];					$rapportBBCode[$i] .= 	" le joueur ";																					$rapportBBCode[$i] .= 	$colorFin[$i];			
				$rapportBBCode[$i] .= 	$colorPlayer[$i];  				$rapportBBCode[$i] .= 	getuserNameById($eXp['user_id']); 											$rapportBBCode[$i] .= 	$colorFin[$i];	
				$rapportBBCode[$i] .= 	$colorText[$i];					$rapportBBCode[$i] .= 	" a découvert dans l'espace infini ";												$rapportBBCode[$i] .= 	$colorFin[$i];					
				$rapportBBCode[$i] .= 	$colorPos[$i];					$rapportBBCode[$i] .= 	"[$eXp[pos_galaxie]:$eXp[pos_sys]:16]  <br /> <br />"	;		$rapportBBCode[$i] .= 	$colorFin[$i];
			$rapportBBCode[$i] .= $boldFin[$i];
		}	
		
		switch($eXp['type'])
		{
			case "Rien":
				for($i = 0 ; $i < 2 ; $i++)
				{
					$rapportBBCode[$i]  .= 	$boldDeb[$i];
						$rapportBBCode[$i] .= 	$colorText[$i];
							$rapportBBCode[$i] .= " Absoluement rien..."	;
						$rapportBBCode[$i] .= 	$colorFin[$i];
					$rapportBBCode[$i] .= 	$boldFin[$i];
				}
			break;
			
			case "Ressources":
				$colRess 		= "#";
	
				if($eXp['quantite'] < 1000000)
				{
					$factRess 	= 255 * ($eXp['quantite']/1000000);
					if ($factRess < 16)
					{
						$colRess .= "0";
					}
					$colRess .= dechex($factRess);
					$colRess .= "FF00";	
				}
				else
				{
					if($eXp['quantite'] < 2000000)
					{
						$factRess 	= 255 * (2 -  ($eXp['quantite']/1000000)) ;
						$colRess .= "FF";				
						if ($factRess < 16)
						{
							$colRess .= "0";
						}
						$colRess .= dechex($factRess);
						$colRess .= "00";
					}
					else
					{
						$colRess = "#FF00FF";
					}
				}
				$colorRess	= array("[color=$colRess]", "<font color=$colRess>");
				for($i = 0 ; $i < 2 ; $i++)
				{
					$rapportBBCode[$i]  .= 	$boldDeb[$i];
						$rapportBBCode[$i] .= 	$colorText[$i];
							$rapportBBCode[$i] .= " Un amas de ressource s'élevant à ";
						$rapportBBCode[$i] .= 	$colorFin[$i];
						$rapportBBCode[$i] .= 	$colorRess[$i];
							$rapportBBCode[$i] .= format($eXp['quantite']);
						$rapportBBCode[$i] .= 	$colorFin[$i];				
						$rapportBBCode[$i] .= 	$colorText[$i];
							$rapportBBCode[$i] .= " ".$eXp['typeRessource'];
						$rapportBBCode[$i] .= 	$colorFin[$i];
					$rapportBBCode[$i] .= 	$boldFin[$i];
				}		
			break;
			
			case "Vaisseaux":
				for($i = 0 ; $i < 2 ; $i++)
				{
					$rapportBBCode[$i]  .= 	$boldDeb[$i];
						$rapportBBCode[$i] .= 	$colorText[$i];
							$rapportBBCode[$i] .= "  Une flotte composée de : <br /> <br />";			
						$rapportBBCode[$i] .= 	$colorFin[$i];
	if($eXp['pt'] != 0){		$rapportBBCode[$i] .= $colorVaiss[$i][0];			$rapportBBCode[$i] .= "$eXp[pt] Petits Transporteurs <br /> ";				 $rapportBBCode[$i] .= 	$colorFin[$i]; }
	if($eXp['gt'] != 0){ 		$rapportBBCode[$i] .= $colorVaiss[$i][1];			$rapportBBCode[$i] .= "$eXp[gt] Grands Transporteurs <br /> ";				 $rapportBBCode[$i] .= 	$colorFin[$i]; }
	if($eXp['cle'] != 0){		$rapportBBCode[$i] .= $colorVaiss[$i][2];			$rapportBBCode[$i] .= "$eXp[cle] Chasseurs Légers <br /> ";					 $rapportBBCode[$i] .= 	$colorFin[$i]; }
	if($eXp['clo'] != 0){		$rapportBBCode[$i] .= $colorVaiss[$i][3];			$rapportBBCode[$i] .= "$eXp[clo] Chasseurs Lourds <br /> ";					 $rapportBBCode[$i] .= 	$colorFin[$i]; }
	if($eXp['cr'] != 0){ 		$rapportBBCode[$i] .= $colorVaiss[$i][4];			$rapportBBCode[$i] .= "$eXp[cr] Croiseurs <br /> ";					 				 $rapportBBCode[$i] .= 	$colorFin[$i]; }
	if($eXp['vb'] != 0){ 		$rapportBBCode[$i] .= $colorVaiss[$i][5];			$rapportBBCode[$i] .= "$eXp[vb] Vaisseaux de Bataille <br /> ";				 $rapportBBCode[$i] .= 	$colorFin[$i]; }
	if($eXp['vc'] != 0){ 		$rapportBBCode[$i] .= $colorVaiss[$i][6];			$rapportBBCode[$i] .= "$eXp[vc] Vaisseaux de Colonisation <br /> ";		 $rapportBBCode[$i] .= 	$colorFin[$i]; }
	if($eXp['rec'] != 0){ 	$rapportBBCode[$i] .= $colorVaiss[$i][7];			$rapportBBCode[$i] .= "$eXp[rec] Recycleurs <br /> ";								 $rapportBBCode[$i] .= 	$colorFin[$i]; }
	if($eXp['se'] != 0){ 		$rapportBBCode[$i] .= $colorVaiss[$i][8];			$rapportBBCode[$i] .= "$eXp[se] Sondes d'Espionnage <br /> ";				 $rapportBBCode[$i] .= 	$colorFin[$i]; }
	if($eXp['bmb'] != 0){ 	$rapportBBCode[$i] .= $colorVaiss[$i][9];			$rapportBBCode[$i] .= "$eXp[bmb] Bombardiers <br /> ";						 $rapportBBCode[$i] .= 	$colorFin[$i]; }
	if($eXp['dst'] != 0){ 	$rapportBBCode[$i] .= $colorVaiss[$i][10];			$rapportBBCode[$i] .= "$eXp[dst] Destructeurs <br /> ";					 		 $rapportBBCode[$i] .= 	$colorFin[$i]; }
	if($eXp['tra'] != 0){ 		$rapportBBCode[$i] .= $colorVaiss[$i][11];			$rapportBBCode[$i] .= "$eXp[tra] Traqueurs <br /> ";								 $rapportBBCode[$i] .= 	$colorFin[$i]; }
						$rapportBBCode[$i] .= 	$colorText[$i];
							$rapportBBCode[$i] .= " <br />Pour un total de ";
						$rapportBBCode[$i] .= 	$colorFin[$i];
						$rapportBBCode[$i] .= 	$colorTitre[$i];	
							$rapportBBCode[$i] .= $eXp['units'];
						$rapportBBCode[$i] .= 	$colorFin[$i];				
						$rapportBBCode[$i] .= 	$colorText[$i];
							$rapportBBCode[$i] .= " unités.";
						$rapportBBCode[$i] .= 	$colorFin[$i];			
					$rapportBBCode[$i] .= 	$boldFin[$i];
				}
			break;
			default:
				for($i = 0 ; $i < 2 ; $i++)
				{
					$rapportBBCode[$i]  .= 	$boldDeb[$i];
						$rapportBBCode[$i] .= 	$colorText[$i];
							$rapportBBCode[$i] .= "Type eXp retourné inconnu : ".$eXp['type'];
						$rapportBBCode[$i] .= 	$colorFin[$i];
					$rapportBBCode[$i] .= 	$boldFin[$i];				
					
				}
		}
	
	}
	$rapportBBCode[0] .= "<br /><br />[size=8]Rapport généré grace au mod [url=http://ogsteam.fr/forums/viewtopic.php?id=4095][b]eXpedition[/b][/url] pour ogspy by [url=http://paradoxxx.zero.free.fr]parAdOxxx[/url][/size]";
	$pageBBCode .= <<<HEREBBCODE

			<table border="2">
			<tbody>
				<tr>
					<td style="width: 400px;" >
						Prévisualisation :
					</td>
					<td style="width: 350px;">
						Rapport BBCode (à copier - coller) :
					</td>
				</tr>
				<tr>
					<td>	
						$rapportBBCode[1]
					</td>
					<td>	
						$rapportBBCode[0]
					</td>
				</tr>
			</tbody>
		</table>



	<!-- FIN Insertion mod eXpedition : BBCode -->

HEREBBCODE;
}


//affichage de la page
echo($pageBBCode);

?>

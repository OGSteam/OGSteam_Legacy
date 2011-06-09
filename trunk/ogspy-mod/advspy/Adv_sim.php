<?php
/***************************************************************************
*	filename	: Adv_sim.php
*	desc.		: AdvSpy, mod for OGSpy.
*	Author		: kilops - http://ogs.servebbs.net/
*	created		: 16/08/2006
***************************************************************************/

// Déclarations OgSpy
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
if (!defined('IN_MOD_ADVSPY')) die("Hacking attempt");



function AdvSpy_PrintHtml_Tab_Simulateur(){
	global $AdvSpyConfig, $lang,$BlockRecherche;


	if (!AdvSpy_Options_GetValue('HideSimAlert')) {
		print "
<div class='box'><div class='box_background'> </div> <div class='box_contents'>
<fieldset style=\"border:1px solid #FF0000; padding:5px; \">
<legend><font color=\"#FF0000\"><b><u>/!\</u> ATTENTION <u>/!\</u></b></font></legend>
Ce simulateur permet de se faire rapidement une idée de la force d'une flotte en vue d'un raid.<br/>
Le systeme PATATE <font size=\"1\">(Petite Addition de Toutes les Armes avec Technologies en Express)</font> calcule la force d'une flotte.<br/>
Lors d'une 'Simulation' Les flottes sont comparés et le résultat est présenté sous forme de pourcentage représentant un taux de réussite de l'attaque.<br/>
Ce systeme de calcul est loin d'etre le plus précis donc n'oubliez pas que ce score est donné A TITRE INDICATIF et ne représente en aucun cas
 une simulation fiable à  100% d'un combat, il est donc nécessaire d'utiliser un simulateur comme
 <a href=\"http://www.speedsim.net/\" target=\"_blank\">SpeedSim</a>
 avant l'envois de toute flotte attaquante.<br/>
-Vous êtes prévenus-<br/>
</fieldset> </div> </div>";
	}
	
	

print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>
<table border='1' cellpadding='4' cellspacing='2' width='100%' id='AdvSpyTableMyFleet' align='top'>
<tr><td valign=\"top\">
			<table width=\"100%\">
			<tr>
			<td class=\"b\" align=\"center\">
<b><font size=\"3\">Flotte attaquant (ma flotte)</font></b>

<a style=\"cursor:pointer\" onClick=\"AdvSpy_Sim_atk_CLEAR();\" title='Vider tous les vaisseaux'><img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."images/clear.png\" border=\"0\"></a>

			</td>
			</tr>
			</table>
<table><tr><td><table>";

	$AdvSpy_AtkPATATE=AdvSpy_GetPatateFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_atk_'));
	$BlockRecherche['AdvSpy_Current_AtkPatate']=$AdvSpy_AtkPATATE;

	$RessourcesBalance=AdvSpy_GetRessourcesBalanceListFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_atk_'));
	$PatateBalance=AdvSpy_GetPatateBalanceListFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_atk_'));
	
	//print_r($RessourcesBalance);
	
	foreach($lang['DicOgame']['Fleet'] as $num=>$valuesarray){
		if(!isset($RessourcesBalance[$valuesarray['PostVar']])) $RessourcesBalance[$valuesarray['PostVar']] = 0;
		if(!isset($PatateBalance[$valuesarray['PostVar']])) $PatateBalance[$valuesarray['PostVar']] = 0;
		print "
		<tr><th align=\"left\" style=\"text-align:left\">".$valuesarray['Name'].": </th>
		<td><input type=\"text\" name=\"".'AdvSpy_Sim_atk_'.$valuesarray['PostVar']."\" id=\"".'AdvSpy_Sim_atk_'.$valuesarray['PostVar']."\" size=\"8\" value=\"".$BlockRecherche['AdvSpy_Sim_atk_'.$valuesarray['PostVar']]."\" onkeyup=\"AdvSpy_Sim_RefreshAll();\">
		</td><td>

		<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_Sim_atk_".$valuesarray['PostVar']."').value='';AdvSpy_Sim_RefreshAll();\" title='Vider'><img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."images/clear.png\" border=\"0\"></a>
		
		".AdvSpy_GetHtml_OgspyTooltipImage("Info","Ces ".$BlockRecherche['AdvSpy_Sim_atk_'.$valuesarray['PostVar']]." ".$valuesarray['Name']." représentent :<br/><br/>".($RessourcesBalance[$valuesarray['PostVar']]+0)." % des ressources<br/>".($PatateBalance[$valuesarray['PostVar']]+0)." % de la patate<br/><br/>de la flotte totale<br/>")."
		</td></tr>
		";
	}
	
	print "<tr><td></tr></td>";
	
	//$BlockRecherche['AdvSpy_Sim_def_t_armes']
	//$BlockRecherche['AdvSpy_Sim_def_t_bouclier']
	//$BlockRecherche['AdvSpy_Sim_def_t_protect']
		
	print "<tr><th align=\"left\" style=\"text-align:left\">Tech Armes: </td><td><input type=\"text\" name=\"AdvSpy_Sim_atk_t_armes\" id=\"AdvSpy_Sim_atk_t_armes\" size=\"3\" value=\"".$BlockRecherche['AdvSpy_Sim_atk_t_armes']."\" onkeyup=\"AdvSpy_Sim_RefreshAll();\"></th></tr>";
	print "<tr><th align=\"left\" style=\"text-align:left\">Tech Bouclier: </td><td><input type=\"text\" name=\"AdvSpy_Sim_atk_t_bouclier\" id=\"AdvSpy_Sim_atk_t_bouclier\" size=\"3\" value=\"".$BlockRecherche['AdvSpy_Sim_atk_t_bouclier']."\" onkeyup=\"AdvSpy_Sim_RefreshAll();\"></th></tr>";
	print "<tr><th align=\"left\" style=\"text-align:left\">Tech Protection: </td><td><input type=\"text\" name=\"AdvSpy_Sim_atk_t_protect\" id=\"AdvSpy_Sim_atk_t_protect\" size=\"3\" value=\"".$BlockRecherche['AdvSpy_Sim_atk_t_protect']."\" onkeyup=\"AdvSpy_Sim_RefreshAll();\"></th></tr>";


	$AdvSpy_AtkPATATE=AdvSpy_GetPatateFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_atk_'));
	$AdvSpy_AtkRessources=AdvSpy_GetRessourcesFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_atk_'),'Fleet+Def','MC');
	$AdvSpy_AtkRessourcesD=AdvSpy_GetRessourcesFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_atk_'),'Fleet+Def','MCD');
	
	//$AdvSpy_MyVolume=as_CalcVolume($as_MyFleet,array());

	print "</td></tr></table></table>\n";

	print AdvSpy_GetHtml_SubmitBT($lang['UI_Lang']['BT_Sim']);

	print "<hr/><table>\n";

	$TechArray=array();
	
	$TechArray['armes']='Patate Armes :';
	$TechArray['bouclier']='Patate Bouclier :';
	$TechArray['protect']='Patate Protection :';
	
	$TechColorArray['armes']='#FF0000';
	$TechColorArray['bouclier']='#00FF00';
	$TechColorArray['protect']='#0000FF';
	
	
	foreach($TechArray as $key=>$name){
		print "		<tr>
			<th style=\"text-align: left;\">$name</th>
			<td class=\"b\" style=\"text-align: right;\" width=\"50px\">
				<div id=\"AdvSpy_Sim_atk_Patate_$key\"></div>
			</td>
			
			<td>
			<div style=\"width: 0px; height: 7px; background-color: ".$TechColorArray[$key]."\" id=\"AdvSpy_Sim_atk_PatateBarr_$key\"></div>
			</td>
			
		</tr>\n";
	}




	print "\n<tr><td></td><td></td></tr>\n\n";


	$name="Patate Totale :";
	$key="total";
	$patate=AdvSpy_GetPointsFromPatate($AdvSpy_AtkPATATE);
	
	print "		<tr>
			<th style=\"text-align: left;\">$name</th>
			<td class=\"b\" style=\"text-align: right;\">
				<div id=\"AdvSpy_Sim_atk_Patate_$key\" title=\"$patate\">$patate</div>
			</td>
		</tr>\n";



	
	
	print "\n</table>";
	
	/*
	<br/>Score PATATE de cette flotte : <b>".AdvSpy_GetPointsFromPatate($AdvSpy_AtkPATATE)." P</b>
	<br/>
	<br/>Valeure en ressources de cette flotte : <b>".AdvSpy_GetPointsFromRessources($AdvSpy_AtkRessources)."</b> K
	<br/>(Avec Deut: ".AdvSpy_GetPointsFromRessources($AdvSpy_AtkRessourcesD)." K)

	*/

	
	
	print "</td><td valign=\"top\">
			<table width=\"100%\">
			<tr>
			<td class=\"b\" align=\"center\">
<b><font size=\"3\">Flotte défenseur</font></b>

<a style=\"cursor:pointer\" onClick=\"AdvSpy_Sim_def_CLEAR();\" title='Vider tous les vaisseaux et défenses'><img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."images/clear.png\" border=\"0\"></a>

			</td>
			</tr>
			</table>

	<table><tr><td valign=\"top\">";

	//==============================
	print "<table align='top'>";

	
	$RessourcesBalance=AdvSpy_GetRessourcesBalanceListFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_def_'));
	$PatateBalance=AdvSpy_GetPatateBalanceListFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_def_'));
	
	
	foreach($lang['DicOgame']['Fleet'] as $num=>$valuesarray){
		if(!isset($RessourcesBalance[$valuesarray['PostVar']])) $RessourcesBalance[$valuesarray['PostVar']] = 0;
		if(!isset($PatateBalance[$valuesarray['PostVar']])) $PatateBalance[$valuesarray['PostVar']] = 0;
		print "
		<tr><th align=\"left\" style=\"text-align:left\">".$valuesarray['Name'].": </th>
		<td><input type=\"text\" name=\"".'AdvSpy_Sim_def_'.$valuesarray['PostVar']."\" id=\"".'AdvSpy_Sim_def_'.$valuesarray['PostVar']."\" size=\"8\" value=\"".$BlockRecherche['AdvSpy_Sim_def_'.$valuesarray['PostVar']]."\" onkeyup=\"AdvSpy_Sim_RefreshAll();\">
		</td><td>
		
		<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_Sim_def_".$valuesarray['PostVar']."').value='';AdvSpy_Sim_RefreshAll();\" title='Vider'><img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."images/clear.png\" border=\"0\"></a>
		
		".AdvSpy_GetHtml_OgspyTooltipImage("Info","Ces ".$BlockRecherche['AdvSpy_Sim_def_'.$valuesarray['PostVar']]." ".$valuesarray['Name']." représentent :<br/><br/>".($RessourcesBalance[$valuesarray['PostVar']]+0)." % des ressources<br/>".($PatateBalance[$valuesarray['PostVar']]+0)." % de la patate<br/><br/>de la flotte totale<br/>")."
		</td></tr>";
	}

	print "<tr><td></td></tr>";

	print "<tr><th align=\"left\" style=\"text-align:left\">Tech Armes: </td><td><input type=\"text\" name=\"AdvSpy_Sim_def_t_armes\" id=\"AdvSpy_Sim_def_t_armes\" size=\"3\" value=\"".$BlockRecherche['AdvSpy_Sim_def_t_armes']."\" onkeyup=\"AdvSpy_Sim_RefreshAll();\"></th></tr>";
	print "<tr><th align=\"left\" style=\"text-align:left\">Tech Bouclier: </td><td><input type=\"text\" name=\"AdvSpy_Sim_def_t_bouclier\" id=\"AdvSpy_Sim_def_t_bouclier\" size=\"3\" value=\"".$BlockRecherche['AdvSpy_Sim_def_t_bouclier']."\" onkeyup=\"AdvSpy_Sim_RefreshAll();\"></th></tr>";
	print "<tr><th align=\"left\" style=\"text-align:left\">Tech Protection: </td><td><input type=\"text\" name=\"AdvSpy_Sim_def_t_protect\" id=\"AdvSpy_Sim_def_t_protect\" size=\"3\" value=\"".$BlockRecherche['AdvSpy_Sim_def_t_protect']."\" onkeyup=\"AdvSpy_Sim_RefreshAll();\"></th></tr>";

	print "</table>";
	//================================
	print "</td><td valign=\"top\">";
	//================================
	print "<table align='top'>";
	foreach($lang['DicOgame']['Def'] as $num=>$valuesarray){
		if(!isset($RessourcesBalance[$valuesarray['PostVar']])) $RessourcesBalance[$valuesarray['PostVar']] = 0;
		if(!isset($PatateBalance[$valuesarray['PostVar']])) $PatateBalance[$valuesarray['PostVar']] = 0;
		print "
		<tr><th align=\"left\" style=\"text-align:left\">".$valuesarray['Name'].": </th>
		<td><input type=\"text\" name=\"".'AdvSpy_Sim_def_'.$valuesarray['PostVar']."\" id=\"".'AdvSpy_Sim_def_'.$valuesarray['PostVar']."\" size=\"8\" value=\"".$BlockRecherche['AdvSpy_Sim_def_'.$valuesarray['PostVar']]."\" onkeyup=\"AdvSpy_Sim_RefreshAll();\">
		</td><td>
		
		<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_Sim_def_".$valuesarray['PostVar']."').value='';AdvSpy_Sim_RefreshAll();\" title='Vider'><img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."images/clear.png\" border=\"0\"></a>
		
		".AdvSpy_GetHtml_OgspyTooltipImage("Info","Ces ".$BlockRecherche['AdvSpy_Sim_def_'.$valuesarray['PostVar']]." ".$valuesarray['Name']." représentent :<br/><br/>".($RessourcesBalance[$valuesarray['PostVar']]+0)." % des ressources<br/>".($PatateBalance[$valuesarray['PostVar']]+0)." % de la patate<br/><br/>de la flotte totale<br/>")."
		</td></tr>";
	}	
	print "</table>";
	//================================
	print "<br/><br/><br/><br/><br/><br/>
<table width=\"190px\"><tr><td style=\"font-size:9px;\">
Si les Recherches ne sont pas sondées dans le Rapport d'Espionnage alors ces technologies Armes / Bouclier / Protection seront utilisées pour le défenseur.
</td></tr>
</table>";
	
	print "</td></tr></table>";


	$AdvSpy_DefPATATE=AdvSpy_GetPatateFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_def_'));
	$AdvSpy_DefPATATE_f=AdvSpy_GetPatateFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_def_'),'Fleet');
	$AdvSpy_DefPATATE_d=AdvSpy_GetPatateFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_def_'),'Def');
	
	$AdvSpy_DefRessources=AdvSpy_GetRessourcesFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_def_'),'Fleet+Def','MC');
	$AdvSpy_DefRessources_f=AdvSpy_GetRessourcesFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_def_'),'Fleet','MC');
	$AdvSpy_DefRessources_d=AdvSpy_GetRessourcesFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_def_'),'Def','MC');

	$AdvSpy_DefRessourcesD=AdvSpy_GetRessourcesFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_def_'),'Fleet+Def','MCD');
	$AdvSpy_DefRessourcesD_f=AdvSpy_GetRessourcesFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_def_'),'Fleet','MCD');
	$AdvSpy_DefRessourcesD_d=AdvSpy_GetRessourcesFromFlatArmy(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_def_'),'Def','MCD');
	
	//$as_PatatePourcent=as_TauxPATATE($as_MyPATATE,$as_OtherPATATE,$as_MyVolume,$as_OtherVolume);
	//$as_PatatePourcentold=as_TauxPATATEold($as_MyPATATE,$as_OtherPATATE);

	$AdvSpy_PatatePourcent=AdvSpy_GetTauxPatate($AdvSpy_AtkPATATE,$AdvSpy_DefPATATE);
	
	
	
	print AdvSpy_GetHtml_SubmitBT($lang['UI_Lang']['BT_Sim']);
	
	print "<hr/>\n";
	
	print "<table>";
	
	
	$TechArray=array();
	
	$TechArray['armes']='Patate Armes :';
	$TechArray['bouclier']='Patate Bouclier :';
	$TechArray['protect']='Patate Protection :';
	
	$TechColorArray['armes']='#FF0000';
	$TechColorArray['bouclier']='#00FF00';
	$TechColorArray['protect']='#0000FF';
	
	foreach($TechArray as $key=>$name){
		print "		<tr>
			<th style=\"text-align: left;\">$name</th>
			<td class=\"b\" style=\"text-align: right;\" width=\"50px\"><div id=\"AdvSpy_Sim_def_Patate_f_$key\"></div></td>
			<td class=\"b\" style=\"text-align: right;\" width=\"50px\"><div id=\"AdvSpy_Sim_def_Patate_d_$key\"></div></td>
			
			<td>
			<div style=\"width: 0px; height: 7px; background-color: ".$TechColorArray[$key]."\" id=\"AdvSpy_Sim_def_PatateBarr_f_$key\"></div>
			</td>
			
			<td>
			<div style=\"width: 0px; height: 7px; background-color: ".$TechColorArray[$key]."\" id=\"AdvSpy_Sim_def_PatateBarr_d_$key\"></div>
			</td>
			
		</tr>\n";
	}




	print "\n<tr><td></td><td></td><td></td></tr>\n\n";


	$name="Patate Totale :";
	$key="total";
	$patate=AdvSpy_GetPointsFromPatate($AdvSpy_DefPATATE);
	
	print "		<tr>
			<th style=\"text-align: left;\">
			$name
			</th>
			<td class=\"b\" colspan=\"2\" style=\"text-align: right;\">
				<div id=\"AdvSpy_Sim_def_Patate_$key\" title=\"$patate\">$patate</div>
			</td>
		</tr>\n";



	print "</table>";

	
	
	
	
	
	/*
	print "<br/>Score PATATE de cette flotte : <b>".AdvSpy_GetPointsFromPatate($AdvSpy_DefPATATE)." P </b> ( ".AdvSpy_GetPointsFromPatate($AdvSpy_DefPATATE_f)." + ".AdvSpy_GetPointsFromPatate($AdvSpy_DefPATATE_d)." )
	<br/>
	<br/>Valeure en ressources de cette flotte : <b>".AdvSpy_GetPointsFromRessources($AdvSpy_DefRessources)."</b> K ( ".AdvSpy_GetPointsFromRessources($AdvSpy_DefRessources_f)." + ".AdvSpy_GetPointsFromRessources($AdvSpy_DefRessources_d)." )
	<br/>(Avec Deut: ".AdvSpy_GetPointsFromRessources($AdvSpy_DefRessourcesD)." K ( ".AdvSpy_GetPointsFromRessources($AdvSpy_DefRessourcesD_f)." + ".AdvSpy_GetPointsFromRessources($AdvSpy_DefRessourcesD_d)." ) )<br/>";
	*/

	

	print "</td></tr><tr><td colspan=\"2\">
<table align='center' border='10' cellspacing='0' cellpadding='0' style='border: 10px solid ".AdvSpy_PatatePourcentToColor($AdvSpy_PatatePourcent)."' id=\"AdvSpy_Sim_Result_PatateColor\">
<tr><td style=\"padding-left: 3px; padding-right: 3px\"><div align=\"center\" id=\"AdvSpy_Sim_Result_PatatePc\" title=\"$AdvSpy_PatatePourcent\"><b>Taux de PATATE :<br/><font size=\"5\"> $AdvSpy_PatatePourcent %</font></b></div></td>\n";

	print "<td width=\"500\" style=\"padding-left: 5px; padding-right: 1px\">";
	
	
	
	$TechColorArray['armes']='#FF0000';
	$TechColorArray['bouclier']='#00FF00';
	$TechColorArray['protect']='#0000FF';

	$TechNameArray['armes']='Armes';
	$TechNameArray['bouclier']='Bouclier';
	$TechNameArray['protect']='Protection';
	
	foreach($TechColorArray as $key=>$color){
		$name=$TechNameArray[$key];
		print "
		<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=\"13\">
			<tr>
				<td valign=\"bottom\">
					<div id=\"AdvSpy_Sim_atk_PatatePRC_$key\" style=\"width: 0px; height: 7px; background-color: $color\" title=\"Total des $name de l'attaquant (vaisseaux)\"></div>
				</td>
			</tr>
		</table>
		<br/>
		<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=\"13\">
			<tr>
				<td valign=\"top\">
					<div id=\"AdvSpy_Sim_def_PatatePRC_f_$key\" style=\"width: 0px; height: 7px; border: 1px solid #FFFFFF; background-color: $color\" title=\"Total des $name du défenseur (vaisseaux)\"></div>
				</td>
				<td valign=\"top\">
					<div id=\"AdvSpy_Sim_def_PatatePRC_d_$key\" style=\"width: 0px; height: 7px; border: 1px solid #FFFFFF; background-color: $color\" title=\"Total des $name du défenseur (défenses)\"></div>
				</td>
			</tr>
		</table>
		<br/>
		";
	}
	
	
	
	
	
	
	
	
	print "</td>";
	
	print "\n</tr></table>\n\n\n";

	print  "<hr/><div align=\"center\" ><a target=\"_blank\" href=\"".AdvSpy_Get_SpeedSimWebUrlFromFlatArray(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_atk_'),AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_def_'))."\" >Copier ces flottes dans WebSim.Speedsim.Net</a>";
	print  "&nbsp;&nbsp;&nbsp;//&nbsp;&nbsp;&nbsp;<a target=\"_blank\" href=\"".AdvSpy_Get_DragoSimUrlFromFlatArray(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_atk_'),AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_def_'))."\" >Copier ces flottes dans Drago-Sim.Com</a></div>";
	
	print "<hr/>".AdvSpy_GetHtml_PatateLegende();


	print "</td></tr></table> </div></div>";
	
}



function AdvSpy_Get_SpeedSimWebUrlFromFlatArray($atk_FlatArray='',$def_FlatArray=''){

	if ($def_FlatArray=='') { $def_FlatArray=array(); }
	if ($atk_FlatArray=='') { $atk_FlatArray=array(); }

	$FromFlatAtkToWebSimTranslation=array(
										'xx_start_pos'=>'start_pos',
										'f_pt'=>'ship_a0_0_b',
										'f_gt'=>'ship_a0_1_b',
										'f_cle'=>'ship_a0_2_b',
										'f_clo'=>'ship_a0_3_b',
										'f_cro'=>'ship_a0_4_b',
										'f_vb'=>'ship_a0_5_b',
										'f_vc'=>'ship_a0_6_b',
										'f_rec'=>'ship_a0_7_b',
										'f_se'=>'ship_a0_8_b',
										'f_bom'=>'ship_a0_9_b',
										'f_sat'=>'ship_a0_10_b',
										'f_des'=>'ship_a0_11_b',
										'f_edlm'=>'ship_a0_12_b',
										'f_traq'=>'ship_a0_13_b',
										't_armes'=>'tech_a0_0',
										't_bouclier'=>'tech_a0_1',
										't_protect'=>'tech_a0_2');
										
	$FromFlatDefToWebSimTranslation=array(
										'metal'=>'enemy_metal',
										'cristal'=>'enemy_crystal',
										'deut'=>'enemy_deut',
										'planet_name'=>'enemy_name',
										'coord'=>'enemy_pos',

										'f_pt'=>'ship_d0_0_b',
										'f_gt'=>'ship_d0_1_b',
										'f_cle'=>'ship_d0_2_b',
										'f_clo'=>'ship_d0_3_b',
										'f_cro'=>'ship_d0_4_b',
										'f_vb'=>'ship_d0_5_b',
										'f_vc'=>'ship_d0_6_b',
										'f_rec'=>'ship_d0_7_b',
										'f_se'=>'ship_d0_8_b',
										'f_bom'=>'ship_d0_9_b',
										'f_sat'=>'ship_d0_10_b',
										'f_des'=>'ship_d0_11_b',
										'f_edlm'=>'ship_d0_12_b',
										'f_traq'=>'ship_d0_13_b',

										'd_mis'=>'ship_d0_14_b',
										'd_lle'=>'ship_d0_15_b',
										'd_llo'=>'ship_d0_16_b',
										'd_gaus'=>'ship_d0_17_b',
										'd_ion'=>'ship_d0_18_b',
										'd_pla'=>'ship_d0_19_b',
										'd_pb'=>'ship_d0_20_b',
										'd_gb'=>'ship_d0_21_b',

										't_armes'=>'tech_d0_0',
										't_bouclier'=>'tech_d0_1',
										't_protect'=>'tech_d0_2');
										
	$SpeedSimWeb_BaseUrl="http://websim.speedsim.net/?lang=fr&";
	$SpeedSimWeb_OutUrl=$SpeedSimWeb_BaseUrl;
	
	foreach($FromFlatAtkToWebSimTranslation as $AdvVarName=>$SpeedSimVarName){
		$CurrentVarValue='';
		if(isset($atk_FlatArray[$AdvVarName]))
			$CurrentVarValue=$atk_FlatArray[$AdvVarName];
		else
			$CurrentVarValue=0;
		if ($CurrentVarValue) {
		    $SpeedSimWeb_OutUrl.=$SpeedSimVarName."=".$CurrentVarValue."&";
		}
	}
	
	foreach($FromFlatDefToWebSimTranslation as $AdvVarName=>$SpeedSimVarName){
		$CurrentVarValue='';
		if(isset($def_FlatArray[$AdvVarName]))
			$CurrentVarValue=$def_FlatArray[$AdvVarName];
		else
			$CurrentVarValue=0;
		if ($CurrentVarValue) {
		    $SpeedSimWeb_OutUrl.=$SpeedSimVarName."=".$CurrentVarValue."&";
		}
	}
	return $SpeedSimWeb_OutUrl;
}


function AdvSpy_Get_DragoSimUrlFromFlatArray($atk_FlatArray='',$def_FlatArray=''){

	if ($def_FlatArray=='') { $def_FlatArray=array(); }
	if ($atk_FlatArray=='') { $atk_FlatArray=array(); }

	$FromFlatAtkToWebSimTranslation=array(
										'xx_start_pos'=>'start_pos',
										'f_pt'=>'numunits[0][0][k_t]',
										'f_gt'=>'numunits[0][0][g_t]',
										'f_cle'=>'numunits[0][0][l_j]',
										'f_clo'=>'numunits[0][0][s_j]',
										'f_cro'=>'numunits[0][0][kr]',
										'f_vb'=>'numunits[0][0][sc]',
										'f_vc'=>'numunits[0][0][ko]',
										'f_rec'=>'numunits[0][0][re]',
										'f_se'=>'numunits[0][0][sp]',
										'f_bom'=>'numunits[0][0][bo]',
										'f_sat'=>'numunits[0][0][so]',
										'f_des'=>'numunits[0][0][z]',
										'f_edlm'=>'numunits[0][0][t]',
										'f_traq'=>'numunits[0][0][sk]',
										
										't_armes'=>'techs[0][0][w_t]',
										't_bouclier'=>'techs[0][0][s_t]',
										't_protect'=>'techs[0][0][r_p]');
										
	$FromFlatDefToWebSimTranslation=array(
										'metal'=>'v_met',
										'cristal'=>'v_kris',
										'deut'=>'v_deut',
										'xx_planet_name'=>'xxx',
										'coord'=>'v_planet',

										'f_pt'=>'numunits[1][0][k_t]',
										'f_gt'=>'numunits[1][0][g_t]',
										'f_cle'=>'numunits[1][0][l_j]',
										'f_clo'=>'numunits[1][0][s_j]',
										'f_cro'=>'numunits[1][0][kr]',
										'f_vb'=>'numunits[1][0][sc]',
										'f_vc'=>'numunits[1][0][ko]',
										'f_rec'=>'numunits[1][0][re]',
										'f_se'=>'numunits[1][0][sp]',
										'f_bom'=>'numunits[1][0][bo]',
										'f_sat'=>'numunits[1][0][so]',
										'f_des'=>'numunits[1][0][z]',
										'f_edlm'=>'numunits[1][0][t]',
										'f_traq'=>'numunits[1][0][sk]',

										'd_mis'=>'numunits[1][0][ra]',
										'd_lle'=>'numunits[1][0][l_l]',
										'd_llo'=>'numunits[1][0][s_l]',
										'd_gaus'=>'numunits[1][0][g]',
										'd_ion'=>'numunits[1][0][i]',
										'd_pla'=>'numunits[1][0][p]',
										'd_pb'=>'numunits[1][0][k_s]',
										'd_gb'=>'numunits[1][0][g_s]',

										't_armes'=>'techs[1][0][w_t]',
										't_bouclier'=>'techs[1][0][s_t]',
										't_protect'=>'techs[1][0][r_p]');
	
	$DragoSim_BaseUrl="http://drago-sim.com/index.php?lang=french&submit=1&";
	$DragoSim_OutUrl=$DragoSim_BaseUrl;
	
	foreach($FromFlatAtkToWebSimTranslation as $AdvVarName=>$DragoSimVarName){
		$CurrentVarValue='';
		if(isset($atk_FlatArray[$AdvVarName]))
			$CurrentVarValue=$atk_FlatArray[$AdvVarName];
		else
			$CurrentVarValue=0;
		if ($CurrentVarValue) {
		    $DragoSim_OutUrl.=$DragoSimVarName."=".$CurrentVarValue."&";
		}
	}
	
	foreach($FromFlatDefToWebSimTranslation as $AdvVarName=>$DragoSimVarName){
		$CurrentVarValue='';
		if(isset($def_FlatArray[$AdvVarName]))
			$CurrentVarValue=$def_FlatArray[$AdvVarName];
		else
			$CurrentVarValue=0;
		if ($CurrentVarValue) {
		    $DragoSim_OutUrl.=$DragoSimVarName."=".$CurrentVarValue."&";
		}
	}
	return $DragoSim_OutUrl;
}



/**
 *
 * @access public
 * @return void 
 **/
function AdvSpy_PatatePourcentToColor($PatatePourcent){
	global $AdvSpyConfig, $lang;
	if (is_numeric($PatatePourcent)) {
		$PP=round($PatatePourcent,-1);
	} else {
		$PP=$PatatePourcent;
	}
	$str='PatatePourcent'.$PP;
	if (array_key_exists($str,$AdvSpyConfig['color'])) {
		return $AdvSpyConfig['color'][$str];
	} else {
		return '#000000';
	}
}

/**
 * beta test
 * @access public
 * @return void 
 **/
function beta_CalcVolume($as_CurrentFleet,$as_CurrentDef){
	$VOLUME=1; // pourquoi 1 ? Parsque ca evite les divisions par 0 ki font chier à  faire des if pour les eviter.
	foreach($as_CurrentFleet as $as_fleetname=>$as_fleetnum){
		$VOLUME=$VOLUME+$as_fleetnum;
	}
	foreach($as_CurrentDef as $as_Defname=>$as_Defnum){
		if ( ($as_Defname!='mi') && ($as_Defname!='mip') )
    		$VOLUME=$VOLUME+$as_Defnum;
	}
	return $VOLUME;
}


/**
 * beta test
 * @access public
 * @return void 
 **/
function beta_TauxPATATE($as_MyPATATE,$as_OtherPATATE,$as_MyVolume=1,$as_OtherVolume=1){
	$as_PatatePourcent=$as_MyPATATE/($as_MyPATATE+$as_OtherPATATE)*100;
	$as_VolumePourcent=((($as_MyVolume-$as_OtherVolume)/($as_MyVolume+$as_OtherVolume))*$as_PatatePourcent/8);
	// Volume pourcent peut etre negatif ou positif suivant qui a le plus de vaisseaux.
	$as_TauxPATATE=round(($as_VolumePourcent+$as_PatatePourcent),2);
	if ($as_TauxPATATE<0) $as_TauxPATATE=0;
	if ($as_TauxPATATE>100) $as_TauxPATATE=100;
	return $as_TauxPATATE;
}


/**
 *
 * @access public
 * @return void 
 **/
function AdvSpy_GetTauxPatate($P_atk=0,$P_def=0){

	if ($P_atk<=0) {
		if ($P_def<=0) {
			return "!!";
		} else {
			return "??";
		}
	} elseif ( ($P_atk>0) && ($P_def<=0) ) {
		return 100;
	}
	$TauxPatate=round($P_atk/($P_atk+$P_def)*100,2);
	if ($TauxPatate<0) $TauxPatate=0;
	if ($TauxPatate>100) $TauxPatate=100;
	return $TauxPatate;
}







function AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,$Mask='AdvSpy_Sim_atk_') {
	//global $AdvSpyConfig, $lang;
	$FlatArmy=array();
	foreach(AdvSpy_GetBlankFlatARMY() as $PostName=>$value){
		if(isset($BlockRecherche[$Mask.$PostName]))
		    $FlatArmy[$PostName]=$BlockRecherche[$Mask.$PostName];
		else
		    $FlatArmy[$PostName]=0;
	}
	return $FlatArmy;
}



function AdvSpy_GetPatateFromFlatArmy($FlatArmy,$Elements='Fleet+Def') {
	global $AdvSpyConfig, $lang,$BlockRecherche;
	
	$PATATE=0;
	
	if (($FlatArmy['t_armes']>0) && ($FlatArmy['t_bouclier']>0) && ($FlatArmy['t_protect'])>0) {
		$TechArmes=$FlatArmy['t_armes'];
		$TechBouclier=$FlatArmy['t_bouclier'];
		$TechProtect=$FlatArmy['t_protect'];
	} else {
		//technologies par defaut (à  ameliorer)
		$TechArmes=$BlockRecherche['AdvSpy_Sim_def_t_armes'];
		$TechBouclier=$BlockRecherche['AdvSpy_Sim_def_t_bouclier'];
		$TechProtect=$BlockRecherche['AdvSpy_Sim_def_t_protect'];
	}


	if (strpos($Elements,'Fleet') !== FALSE) {
	    foreach($lang['DicOgame']['Fleet'] as $num=>$valuesarray){
			$Points_Armes=$valuesarray['Attaque'];
			$Points_Bouclier=$valuesarray['Bouclier'];
			$Points_Protect=$valuesarray['Structure'];
			
			$PATATE=$PATATE+(
				(0.1*$TechArmes*$Points_Armes*$FlatArmy[$valuesarray['PostVar']])+
				(0.1*$TechBouclier*$Points_Bouclier*$FlatArmy[$valuesarray['PostVar']])+
				(0.1*$TechProtect*$Points_Protect*$FlatArmy[$valuesarray['PostVar']])
			);

		}
	}
	if (strpos($Elements,'Def') !== FALSE) {
	    foreach($lang['DicOgame']['Def'] as $num=>$valuesarray){
			$Points_Armes=$valuesarray['Attaque'];
			$Points_Bouclier=$valuesarray['Bouclier'];
			$Points_Protect=$valuesarray['Structure'];
			
			if (($valuesarray['PostVar']!='d_mi') && ($valuesarray['PostVar']!='d_mip') ) {
				$PATATE=$PATATE+(
					(0.1*$TechArmes*$Points_Armes*$FlatArmy[$valuesarray['PostVar']])+
					(0.1*$TechBouclier*$Points_Bouclier*$FlatArmy[$valuesarray['PostVar']])+
					(0.1*$TechProtect*$Points_Protect*$FlatArmy[$valuesarray['PostVar']])
				);
			}
		}
	}
	
	return round($PATATE);
}





function AdvSpy_GetRessourcesFromFlatArmy($FlatArmy,$Elements='Fleet+Def',$CalcRes='MCD') {
	global $AdvSpyConfig, $lang;
	
	$RESSOURCES=0;
	
	$CalcRes=strtoupper($CalcRes);
	
	if (strpos($Elements,'Fleet') !== FALSE) {
	    foreach($lang['DicOgame']['Fleet'] as $num=>$valuesarray){
			if (strpos($CalcRes,'M') !== FALSE) { $RESSOURCES=$RESSOURCES+( ($valuesarray['Prix'][0]*$FlatArmy[$valuesarray['PostVar']]) ); }
			if (strpos($CalcRes,'C') !== FALSE) { $RESSOURCES=$RESSOURCES+( ($valuesarray['Prix'][1]*$FlatArmy[$valuesarray['PostVar']]) ); }
			if (strpos($CalcRes,'D') !== FALSE) { $RESSOURCES=$RESSOURCES+( ($valuesarray['Prix'][2]*$FlatArmy[$valuesarray['PostVar']]) ); }
		}
	}
	if (strpos($Elements,'Def') !== FALSE) {
	    foreach($lang['DicOgame']['Def'] as $num=>$valuesarray){
			if (strpos($CalcRes,'M') !== FALSE) { $RESSOURCES=$RESSOURCES+( ($valuesarray['Prix'][0]*$FlatArmy[$valuesarray['PostVar']]) ); }
			if (strpos($CalcRes,'C') !== FALSE) { $RESSOURCES=$RESSOURCES+( ($valuesarray['Prix'][1]*$FlatArmy[$valuesarray['PostVar']]) ); }
			if (strpos($CalcRes,'D') !== FALSE) { $RESSOURCES=$RESSOURCES+( ($valuesarray['Prix'][2]*$FlatArmy[$valuesarray['PostVar']]) ); }
		}
	}

	return round($RESSOURCES);
}





function AdvSpy_GetRessourcesBalanceListFromFlatArmy($FlatArmy,$Elements='Fleet+Def',$CalcDeut=1) {
	global $AdvSpyConfig, $lang;
	
	$RESSOURCES=array();
	$total=0;
	
	if (strpos($Elements,'Fleet') !== FALSE) {
	    foreach($lang['DicOgame']['Fleet'] as $num=>$valuesarray){
			$RESSOURCES[$valuesarray['PostVar']]=(
				($valuesarray['Prix'][0]*$FlatArmy[$valuesarray['PostVar']])+
				($valuesarray['Prix'][1]*$FlatArmy[$valuesarray['PostVar']])
			);
			if ($CalcDeut) {
				$RESSOURCES[$valuesarray['PostVar']]=$RESSOURCES[$valuesarray['PostVar']]+(
					($valuesarray['Prix'][2]*$FlatArmy[$valuesarray['PostVar']])
				);
			}
				
		}
	}
	if (strpos($Elements,'Def') !== FALSE) {
	    foreach($lang['DicOgame']['Def'] as $num=>$valuesarray){
			$RESSOURCES[$valuesarray['PostVar']]=(
				($valuesarray['Prix'][0]*$FlatArmy[$valuesarray['PostVar']])+
				($valuesarray['Prix'][1]*$FlatArmy[$valuesarray['PostVar']])
			);
			if ($CalcDeut) {
				$RESSOURCES[$valuesarray['PostVar']]=$RESSOURCES[$valuesarray['PostVar']]+(
					($valuesarray['Prix'][2]*$FlatArmy[$valuesarray['PostVar']])
				);
			}
				
		}
	}

	foreach($RESSOURCES as $name=>$value){
		$total=$total+$value;
	}
	
	if ($total<=0) { $total=1; }

	$RESSOURCESBalance=array();
	foreach($RESSOURCES as $name=>$value){
		$RESSOURCESBalance[$name]=round(($value/$total)*100);
	}
	
	
	
	return $RESSOURCESBalance;
}



function AdvSpy_GetPatateBalanceListFromFlatArmy($FlatArmy,$Elements='Fleet+Def') {
	global $AdvSpyConfig, $lang;
	
	$PATATE=array();
	
	if (($FlatArmy['t_armes']>0) && ($FlatArmy['t_bouclier']>0) && ($FlatArmy['t_protect']>0)) {
		$TechArmes=$FlatArmy['t_armes'];
		$TechBouclier=$FlatArmy['t_bouclier'];
		$TechProtect=$FlatArmy['t_protect'];
	} else {
		if (isset($BlockRecherche)) {
			$TechArmes=$BlockRecherche['AdvSpy_Sim_def_t_armes'];
			$TechBouclier=$BlockRecherche['AdvSpy_Sim_def_t_bouclier'];
			$TechProtect=$BlockRecherche['AdvSpy_Sim_def_t_protect'];
		}
	}

	if (strpos($Elements,'Fleet') !== FALSE) {
	    foreach($lang['DicOgame']['Fleet'] as $num=>$valuesarray){
			$Points_Armes=$valuesarray['Attaque'];
			$Points_Bouclier=$valuesarray['Bouclier'];
			$Points_Protect=$valuesarray['Structure'];
			
			if ( ($valuesarray['PostVar']!='f_sat') ) {
				$PATATE[$valuesarray['PostVar']]=(
					(0.1*$TechArmes*$Points_Armes*$FlatArmy[$valuesarray['PostVar']])+
					(0.1*$TechBouclier*$Points_Bouclier*$FlatArmy[$valuesarray['PostVar']])+
					(0.1*$TechProtect*$Points_Protect*$FlatArmy[$valuesarray['PostVar']])
				);
			}
		}
	}
	if (strpos($Elements,'Def') !== FALSE) {
	    foreach($lang['DicOgame']['Def'] as $num=>$valuesarray){
			$Points_Armes=$valuesarray['Attaque'];
			$Points_Bouclier=$valuesarray['Bouclier'];
			$Points_Protect=$valuesarray['Structure'];
			
			if (($valuesarray['PostVar']!='d_mi') && ($valuesarray['PostVar']!='d_mip') ) {
				$PATATE[$valuesarray['PostVar']]=(
					(0.1*$TechArmes*$Points_Armes*$FlatArmy[$valuesarray['PostVar']])+
					(0.1*$TechBouclier*$Points_Bouclier*$FlatArmy[$valuesarray['PostVar']])+
					(0.1*$TechProtect*$Points_Protect*$FlatArmy[$valuesarray['PostVar']])
				);
			}
		}
	}

	$total=0;
	foreach($PATATE as $name=>$value){
		$total=$total+$value;
	}
	
	if ($total<=0) { $total=1; }

	$PATATEBalance=array();
	foreach($PATATE as $name=>$value){
		$PATATEBalance[$name]=round(($value/$total)*100);
	}
	
	return $PATATEBalance;
}

function AdvSpy_GetPointsFromRessources($Ressources=0) {
	return round($Ressources/1000,3);
}

function AdvSpy_GetPointsFromPatate($Patate=0) {
	return round($Patate/1000000,3);
}

//=======================================================================================
//=======================================================================================
//=======================================================================================

// Raid Alert

function AdvSpy_RaidAlert_START($AdvSpy_RaidAlert_Galaxy,$AdvSpy_RaidAlert_System,$AdvSpy_RaidAlert_Row,$AdvSpy_RaidAlert_Lune) {
	global $AdvSpyConfig, $lang,$user_data,$db;

	$out="";
	
	if ( (!is_numeric($AdvSpy_RaidAlert_Galaxy)) || (!is_numeric($AdvSpy_RaidAlert_System)) || (!is_numeric($AdvSpy_RaidAlert_Row)) || (!is_numeric($AdvSpy_RaidAlert_Lune)) ) {
		AdvSpy_log($lang['UI_Lang']['Raidalert_Error1'],"ERROR"); 
		die($lang['UI_Lang']['Raidalert_Error1']);
	}

	//on charge les variables d'environement Ogspy dans AdvSpy.
	$AdvSpyConfig['User_Empire']=user_get_empire();
	$AdvSpyConfig['User_Data']=$user_data;
	
	$AdvSpyConfig['UserIsAdmin']=0;
	if($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1)
		$AdvSpyConfig['UserIsAdmin']=1;

	$request = "SELECT * FROM ".TABLE_CONFIG." WHERE 1;";
	$result = $db->sql_query($request);
	while ($val=@mysql_fetch_assoc($result)) {
		$AdvSpyConfig['OgspyConfig'][$val['config_name']]=$val['config_value'];
	}
	unset($result);



	$RAtablename=$AdvSpyConfig['Settings']['AdvSpy_TableName_RaidAlert'];
	
	$SqlRequest = "SELECT * FROM ".$RAtablename.",".TABLE_USER."
	WHERE `RaidOwner`=`user_id`";
	$SqlRequest.="\nAND `RaidGalaxy`=".$AdvSpy_RaidAlert_Galaxy;
	$SqlRequest.="\nAND `RaidSystem`=".$AdvSpy_RaidAlert_System;
	$SqlRequest.="\nAND `RaidRow`=".$AdvSpy_RaidAlert_Row;
	$SqlRequest.="\nAND `RaidLune`=".$AdvSpy_RaidAlert_Lune;
	$SqlRequest.=" ORDER BY `RaidDate` DESC";

	
	$out.="<html><head><meta http-equiv=\"Content-Language\" content=\"fr\"></head><body text=\"#FFFFFF\" bgcolor=\"#000040\">
	<form method=\"POST\" action=\"./?action=AdvSpy&RaidAlert_Galaxy=$AdvSpy_RaidAlert_Galaxy&RaidAlert_System=$AdvSpy_RaidAlert_System&RaidAlert_Row=$AdvSpy_RaidAlert_Row&RaidAlert_Lune=$AdvSpy_RaidAlert_Lune\">";

	$out.="<b>";
	if ($AdvSpy_RaidAlert_Lune) {
		$out.=$lang['UI_Lang']['Raidalert_Moon'];
	} else {
		$out.=$lang['UI_Lang']['Raidalert_Planet'];
	}
	$out.="[$AdvSpy_RaidAlert_Galaxy:$AdvSpy_RaidAlert_System:$AdvSpy_RaidAlert_Row]</b><br/>";
	
	if (@$_POST['RaidAlertOK']) {
		AdvSpy_log("RaidAlert: ".$lang['UI_Lang']['Raidalert_LogNewRaid']." [$AdvSpy_RaidAlert_Galaxy:$AdvSpy_RaidAlert_System:$AdvSpy_RaidAlert_Row]");
	    $as_RA_CurrentUserId=$AdvSpyConfig['User_Data']['user_id'];
		$as_time=time();
		$query="INSERT INTO `$RAtablename`
		 (`RaidId`, `RaidOwner`, `RaidGalaxy`, `RaidSystem`, `RaidRow`, `RaidDate`, `RaidLune`)
		  VALUES ('', $as_RA_CurrentUserId, $AdvSpy_RaidAlert_Galaxy, $AdvSpy_RaidAlert_System, $AdvSpy_RaidAlert_Row, $as_time, $AdvSpy_RaidAlert_Lune);";
		$result = $db->sql_query($query);

		$out.="<b><font color=\"#FF5555\"><blink>".$lang['UI_Lang']['Raidalert_Raided']."</blink></font></b>";
	} else {
		$out.="<input type=\"submit\" value=\"".$lang['UI_Lang']['Raidalert_RaidBT']."\" name=\"RaidAlertOK\" style=\"text-align: center; font-weight: bold\">";
		AdvSpy_log("RaidAlert: ".$lang['UI_Lang']['Raidalert_LogShowRaids']." [$AdvSpy_RaidAlert_Galaxy:$AdvSpy_RaidAlert_System:$AdvSpy_RaidAlert_Row]");
	}
	

	$result = $db->sql_query($SqlRequest);
	$AdvSpy_RaidAlert_List=array();
	while ($val=@mysql_fetch_assoc($result)) {
		$AdvSpy_RaidAlert_List[]=$val;
	}
	
	
		$out.="<table border=\"1\" id=\"table1\" style=\"border-collapse: collapse\" cellpadding=\"2\">
	<tr>
		<td><font size=\"2\">".$lang['UI_Lang']['Raidalert_RaidOwner']."</font></td>
		<td align=\"center\"><font size=\"2\">".$lang['UI_Lang']['Raidalert_RaidDate']."</font></td>
		<td align=\"center\"><font size=\"2\">".$lang['UI_Lang']['Raidalert_RaidETime']."</font></td>
	</tr>";
	
	
	foreach($AdvSpy_RaidAlert_List as $AdvSpy_RaidAlert_num=>$AdvSpy_RaidAlert_values){
		//$AdvSpy_RaidAlert_values['RaidDate'];
		//time();
		//$AdvSpy_RaidAlert_values['user_name'];
		
		$AdvSpy_RaidAlert_date_spy=date("d/m/y H:i:s",$AdvSpy_RaidAlert_values['RaidDate']);

		$AdvSpy_RaidAlert_duration_FromRAToNow=AdvSpy_duration(time()-$AdvSpy_RaidAlert_values['RaidDate']);
		
		$out.="
		<tr>
			<td align=\"left\"><font size=\"2\">".$AdvSpy_RaidAlert_values['user_name']."</font></td>
			<td align=\"right\"><font size=\"2\">$AdvSpy_RaidAlert_date_spy</font></td>
			<td align=\"right\"><font size=\"2\">$AdvSpy_RaidAlert_duration_FromRAToNow</font></td>
		</tr>";
	}


	$out.="</table></form></html>";
	
	print $out;

	exit();
}




?>

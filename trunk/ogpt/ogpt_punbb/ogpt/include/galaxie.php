<?php
function color ($statut,$valeur)
{
global $db,$ogpt;

if ($statut == "") {$result=$valeur;}
if ($statut == "i") {$result='<font color="'.$ogpt['i'].'">'.$valeur.'</font>';}
if ($statut == "iI") {$result='<font color="'.$ogpt['iI'].'">'.$valeur.'</font>';}
if ($statut == "d") {$result='<font color="'.$ogpt['d'].'">'.$valeur.'</font>';}
if ($statut == "v") {$result='<font color="'.$ogpt['v'].'">'.$valeur.'</font>';}
if ($statut == "iv") {$result='<font color="'.$ogpt['iv'].'">'.$valeur.'</font>';}
if ($statut == "iIv") {$result='<font color="'.$ogpt['iIv'].'">'.$valeur.'</font>';}	
if ($statut == "b") {$result='<font color="'.$ogpt['b'].'">'.$valeur.'</font>';}
if ($statut == "bv") {$result='<font color="'.$ogpt['bv'].'">'.$valeur.'</font>';}
if ($statut == "bvi") {$result='<font color="'.$ogpt['bvi'].'">'.$valeur.'</font>';}
if ($statut == "bvIi") {$result='<font color="'.$ogpt['bvIi'].'">'.$valeur.'</font>';}	
if ($statut == "f") {$result='<font color="'.$ogpt['bvIi'].'">'.$valeur.'</font>';}	

	
return $result;	
	}


function pre_galaxie ()
{

	global $db;
$pre='
<tr>
	<th align="center" class="c" width="5%"><b>&nbsp;</b></th>
	<th  align="center" class="c" width="20%"><b>Planètes</b></th>
	<th  align="center" class="c" width="20%"><b>Alliances</b></th>
	<th  align="center" class="c" width="20%"><b>Joueurs</b></th>
	<th  align="center" class="c" width="5%"><b>L</b></th>
	<th  align="center" class="c" width="5%"><b>Statut</b></th>
	<th  align="center" class="c" width="5%"><b>RE</b></th>
	<th  align="center" class="c" width="20%"><b>MAJ</b></th>
	<th  align="center" class="c" width="5%"><b>action</b></th>
</tr>';

return $pre;


}

function player ( $player)

{
global $db ,$pun_user ;

	
	$tooltip = "<table width=\"300\" border cellpadding=\"5\">";
	$tooltip .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">Joueur ".$player."</td></tr>";
		$individual_ranking = galaxy_show_ranking_unique_player($player);
		while ($ranking = current($individual_ranking)) {
			$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking));
			$general_rank = isset($ranking["general"]) ?  convNumber($ranking["general"]["rank"]) : "&nbsp;";
			$general_points = isset($ranking["general"]) ? convNumber($ranking["general"]["points"]) : "&nbsp;";
			$fleet_rank = isset($ranking["fleet"]) ?  convNumber($ranking["fleet"]["rank"]) : "&nbsp;";
			$fleet_points = isset($ranking["fleet"]) ?  convNumber($ranking["fleet"]["points"]) : "&nbsp;";
			$research_rank = isset($ranking["research"]) ?  convNumber($ranking["research"]["rank"]) : "&nbsp;";
			$research_points = isset($ranking["research"]) ?  convNumber($ranking["research"]["points"]) : "&nbsp;";

			$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">Classement du ".$datadate."</td></tr>";
			$tooltip .= "<tr><td class=\"c\" width=\"75\">Général</td><th width=\"75\">".$general_rank."</th><th>".$general_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">Flotte</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">Recherche</td><th>".$research_rank."</th><th>".$research_points."</th></tr>";
			break;
		}
	
		$tooltip .= "</table>";
		$tooltip = htmlentities($tooltip);
		
	
	$joueur=  "<a href='rech_joueur.php?joueur=".$player."' onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;Tip('".$tooltip."')\"  onmouseout=\"UnTip()\" >".$player."</a>";	
		
		return $joueur;
	}


function ally ( $ally)

{
global $db ,$pun_user ;

	
	$tooltip = "<table width=\"300\" border cellpadding=\"5\">";
	$tooltip .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">Alliance ".$ally."</td></tr>";
		$individual_ranking = galaxy_show_ranking_unique_ally($ally);
		while ($ranking = current($individual_ranking)) {
			$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking));
			$general_rank = isset($ranking["general"]) ?  convNumber($ranking["general"]["rank"]) : "&nbsp;";
			$general_points = isset($ranking["general"]) ? convNumber($ranking["general"]["points"]) . " <i>( ". convNumber($ranking["general"]["points_per_member"]) ." )</i>" : "&nbsp;";
			$fleet_rank = isset($ranking["fleet"]) ?  convNumber($ranking["fleet"]["rank"]) : "&nbsp;";
			$fleet_points = isset($ranking["fleet"]) ?  convNumber($ranking["fleet"]["points"]) . " <i>( ". convNumber($ranking["fleet"]["points_per_member"]) ." )</i>" : "&nbsp;";
			$research_rank = isset($ranking["research"]) ?  convNumber($ranking["research"]["rank"]) : "&nbsp;";
			$research_points = isset($ranking["research"]) ?  convNumber($ranking["research"]["points"]) . " <i>( ". convNumber($ranking["research"]["points_per_member"]) ." )</i>" : "&nbsp;";

			$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">Classement du ".$datadate."</td></tr>";
			$tooltip .= "<tr><td class=\"c\" width=\"75\">Général</td><th width=\"30\">".$general_rank."</th><th>".$general_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">Flotte</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">Recherche</td><th>".$research_rank."</th><th>".$research_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">".convNumber($ranking["number_member"])." membre(s)</td></tr>";
			break;
		}
	
		$tooltip .= "</table>";
		$tooltip = htmlentities($tooltip);
		

	$alliance=  "<a href='rech_ally.php?ally=".$ally."' onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;Tip('".$tooltip."')\"  onmouseout=\"UnTip()\" >".$ally."</a>";	
		
		return 	$alliance;
	}


function galaxie ($row,$name,$ally,$player,$moon,$status,$galaxy,$system,$last_update,$user_name)
{
global $db ,$pun_user ;

/// planete aleatoire
$j=rand(1,9);

///appel tableau galaxie
$galaxie='<tr>';
///row
$galaxie.='<td  align="center" class="c" ><FONT size=1>';
if ($name !=""){
$galaxie.='<a href="galaxie.php?action=galaxie&galaxie=' . $galaxy . '&systeme=' . $system . '">'.$galaxy.':'.$system.':'.$row.'</a>';}
$galaxie.='</font></td>';
/// planetes
$galaxie.='<td  align="center" class="c" ><FONT size=1>';
if ($name !="")
{$galaxie.= '<img src="ogpt/skin/img/p'.$j.'.jpg" width="20" height="20" title="'.$name.'">&nbsp;'; 
$galaxie.=color ($status,$name);
$galaxie.= '&nbsp;<img src="ogpt/skin/img/p'.$j.'.jpg" width="20" height="20" title="'.$name.'">';
}
$galaxie.='</font></td>';
/// alliance
$galaxie.='<td  align="center" class="c" ><FONT size=1>'.ally ($ally).'</font></td>';
///joueurs
$galaxie.='	<td  align="center" class="c" ><FONT size=1>'.player ($player).'</font></td>';
///lunes
$galaxie.='<td  align="center" class="c" ><FONT size=1>';
if ($moon == 1) 
{$galaxie.='<img src="ogpt/skin/planeten/small/s_mond.jpg" width="20" height="20" title="lune">'; }
else 
{$galaxie.='&nbsp;';} 
$galaxie.='</font></td>';
//statut
$galaxie.=' <td  align="center" class="c" ><FONT size=1>';
$valeur=$status;
$galaxie.=color ($status,$valeur);
$galaxie.='</font></td>';
///re
$galaxie.='<td  align="center" class="c" >';
if ($name !=""){
$galaxie.=RE( $galaxy ,$system  , $row);}
$galaxie.='</td>';
///maj
$galaxie.='<td  align="center" class="c" >';
if ($name !=""){
$valeur='le '.date("d-m" ,$last_update).' ('.$user_name.')';
$galaxie.=color ($status,$valeur);}
$galaxie.='</td>';
///action
$galaxie.='<td  align="center" class="c" ><FONT size=1>';
if ($name !=""){
/// selection des favoris ( si jamais dedans on propose la suppression autrement on propose l' ajout
/// variable globale ogpt
$sql  = 'select * from favorie where sender =\''.$pun_user['id_ogspy'].'\' and galaxy=\''.$galaxy.'\' and system=\''.$system.'\' and row=\''.$row.'\'';
$result = $db->query($sql);



/// si pas de reponse
if (!$db->num_rows($result))
{	$galaxie.='<a  href="favorie.php?action=fav&galaxie='.$galaxy.'&systeme='.$system.'&row='.$row.'"><img src ="ogpt/skin/img/r.gif" width="15" height="15" title="mettre en favori"></a>';}
	/// si reponse
	else{
$galaxie.='<a  href="favorie.php?action=unfav&galaxie='.$galaxy.'&systeme='.$system.'&row='.$row.'"><img src ="ogpt/skin/img/e.gif" width="15" height="15" title="retirer des favoris"></a>';}
}
	
	
	
	
	
	
		
//$galaxie.='<img src ="ogpt/skin/img/r.gif" width="15" height="15" title="mettre en favori">';


$galaxie.='</font></td>';



// the end
$galaxie.='</tr>';

return $galaxie;


}



   
  function post_galaxie ()
{

	global $db,$ogpt, $pun_user;
$post= "</div></table>";

$legend = "<table width=\"225\">";
$legend .= "<tr><td class=\"c\" colspan=\"2\" align=\"center\"e width=\"150\">Légende</td></tr>";
$legend .= "<tr><td class=\"c\">Inactif 7 jours</td><th><font color=\"".$ogpt['i']."\">i</font></th></tr>";
$legend .= "<tr><td class=\"c\">Inactif 28 jours</td><th><font color=\"".$ogpt['iI']."\">I</font></th></tr>";
$legend .= "<tr><td class=\"c\">Mode vacance</td><th><font color=\"".$ogpt['v']."\">v</font></th></tr>";
$legend .= "<tr><td class=\"c\">Joueur faible</td><th><font color=\"".$ogpt['d']."\">d</font></th></tr>";
$legend .= "<tr><td class=\"c\">Joueur fort</td><th><font color=\"".$ogpt['f']."\">f</font></th></tr>";
$legend .= "<tr><td class=\"c\">Joueur bloqué</td><th><font color=\"".$ogpt['b']."\">d</font></th></tr>";
$legend .= "<tr><td class=\"c\">Lune<br><i>phalange 4 avec porte spatial</i></td><th>M - 4P</th></tr>";
$legend .= "<tr><td class=\"c\">Rapport d\'espionnage</td><th>RE</th></tr>";
$legend .= "</table>";
$legend = htmlentities($legend);

$post.="</script><table><tr align='center'><td class='c' colspan='9'><a href=\"\" onmouseover=\"Tip('".$legend."')\" onmouseout=\"UnTip()\">Legend</a></td></tr>";
$post.="</table>";


return $post;
}
 
   
   
  
   
         ?>
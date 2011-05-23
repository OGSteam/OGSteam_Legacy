<?php
/**
* Interpolation.php 
 * @package QuiMobserve
 * @author Santory
 * @link http://www.ogsteam.fr
 * @version : 0.1e
 */

// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='QuiMobserve' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//Définitions
global $db;
global $table_prefix;
define("TABLE_QUIMOBSERVE", $table_prefix."MOD_quimobserve");
define("TABLE_QUIMOBSERVE_ARCHIVE", $table_prefix."MOD_quimobserve_archive");
require_once("mod/QuiMObserve/help.php");

if(!isset($pub_nombre_mini_joueur)){
	$pub_nombre_mini_joueur = 1;
}else{
 	$pub_nombre_mini_joueur = mysql_real_escape_string(intval($pub_nombre_mini_joueur));	
}
if(!isset($pub_nombre_mini_alliance)){
	$pub_nombre_mini_alliance = 1;
}else{
 	$pub_nombre_mini_alliance = mysql_real_escape_string(intval($pub_nombre_mini_alliance));	
}
if(!isset($pub_periodes)){
	$pub_periodes = 20;
}else{
	$pub_periodes = mysql_real_escape_string(intval($pub_periodes));	
}


echo"<fieldset><legend><b><font color='#0080FF'>Analyse d'espionnages par Joueur / Alliance";
echo help("parametre_annalise_planette");
echo"</font></b></legend><form action='index.php' method='post'>
	<table width='60%' align='center'><tr>
	<td><input type='hidden' name='action' value='Quimobserve'><input type='hidden' name='page' value='Interpolation des Joueurs / Alliances'>
	Nombre de rapport minimal par Joueur : </td><td><input type='text' name='nombre_mini_joueur' value=".$pub_nombre_mini_joueur." ></td></tr>
	<tr><td>Nombre de rapport minimal par Alliance : </td><td><input type='text' name='nombre_mini_alliance' value=".$pub_nombre_mini_alliance." ></td></tr>
	<tr><td>Période en jours à analyser : </td><td><input type='text' name='periodes' value=".$pub_periodes." ></td></tr>
	<tr>
	<td colspan='2' align='center'><p><input type='submit' name='recherche' value='Rechercher Joueur'><input type='submit' name='recherche' value='Rechercher Alliance'></p></td>
	</tr></table></form></fieldset><br />";

if(isset($pub_recherche)&&$pub_recherche=="Rechercher Joueur"){
	$timestamp = time()-(24*60*60*$pub_periodes);
	$datadate = mktime (0,0,0,date("m",$timestamp),date("d",$timestamp),date("y",$timestamp));

	$query_limit = "SELECT `spy_planetteEspion` , count(*) as num, SUBSTRING_INDEX( `spy_planetteEspion` , ':', 1 ) AS sagalaxy, SUBSTRING_INDEX(SUBSTRING_INDEX( `spy_planetteEspion` , ':', 2 ),':',-1) AS sasystem, SUBSTRING_INDEX( `spy_planetteEspion` , ':', -1 ) AS saplanette, (SELECT `player` FROM `".TABLE_UNIVERSE."` WHERE `galaxy` = sagalaxy AND `system` = sasystem AND `row` = saplanette ) as player FROM `".TABLE_QUIMOBSERVE."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']." GROUP BY `player` HAVING num >= ".$pub_nombre_mini_joueur." ORDER BY player ASC";
 	$result=$db->sql_query($query_limit);
	if($result=$db->sql_numrows($result)==0){
		echo "<div align='center'>Vous n'avez pas été espionné ces ".$pub_periodes." derniers jours</div>";
	}else{
		unset($lst_planettes);
		$player_vide = "";
 	 	while(list($spy_planetteEspion,$num,$a,$b,$c,$player)=$db->sql_fetch_row($result)){
			if($player != ''){
				$lst_player[]="'".$player."'";
			}else{
				$player_vide = " `player` IS NULL ";
			}
		}
		$result_query_limit = join(",", $lst_player);
		$having = "";
		if($result_query_limit != ""){
			$having = "`player` in (".$result_query_limit.")";
		}
		if($player_vide != ""){
			if($having == ""){
				$having .= " OR ".$player_vide;
			}else{
				$having .= $player_vide;
			}
		}

		$query = "SELECT DISTINCT(`spy_maplanette`) as spy_maplanette FROM `".TABLE_QUIMOBSERVE."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']." ORDER BY `spy_maplanette` asc";
		$result2=$db->sql_query($query);
		$i=0;
		unset($lst_planettes);
		while(list($spy_maplanette)=$db->sql_fetch_row($result2)){
			$lst_planettes[$i++]=$spy_maplanette;
 		}
		
		$query = "SELECT `spy_planetteEspion` , `spy_maplanette` , `datadate`, SUBSTRING_INDEX( `spy_planetteEspion` , ':', 1 )AS sagalaxy, SUBSTRING_INDEX(SUBSTRING_INDEX( `spy_planetteEspion` , ':', 2 ),':',-1) AS sasystem, SUBSTRING_INDEX( `spy_planetteEspion` , ':', -1 ) AS saplanette, (SELECT `player` FROM `".TABLE_UNIVERSE."` WHERE `galaxy` = sagalaxy AND `system` = sasystem AND `row` = saplanette ) as player, `pourcentage`   FROM `".TABLE_QUIMOBSERVE."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']."
							HAVING ".$having." ORDER BY `player` asc, `spy_maplanette` asc, `spy_planetteEspion` asc , `datadate` asc";
		$result=$db->sql_query($query);
		echo "<table width='100%'>";
		echo"<tr>";
		echo"<td class='c' align='center'><b>Joueur</b></td>";
		echo"<td class='c' align='center'><b>Nombre Total</b></td>";
		reset($lst_planettes);
		foreach($lst_planettes as $planette){
 			echo"<td class='c' align='center'><b>".$planette."</b></td>";
		}
		echo "</tr>";
		$lejoueur = "-";
		$planette_es = "";
		$planette_ma = "";

		while(list($spy_planetteEspion, $spy_maplanette, $datadate,$a,$b,$c,$player,$pourcentage)=$db->sql_fetch_row($result)){
			if($player != $lejoueur){
//generation du tableau avec les info du joueur d avant
				if($lejoueur!="-"){
					$total = $info['total'];
					$tab[$total][$lejoueur]=$info;
					unset($info);
				}
				$lejoueur = $player;
				$planette_es=$spy_planetteEspion;
				$planette_ma = $spy_maplanette;
				$info['total']=1;
				$info[$spy_maplanette]['total']=1;
				$info[$spy_maplanette][$spy_planetteEspion]['date']=date("Y-m-d H:i:s", $datadate)." ( ".$pourcentage."% )";
				$info[$spy_maplanette][$spy_planetteEspion]['num']=1;
			}elseif($spy_maplanette!=$planette_ma){
				$planette_ma = $spy_maplanette;
				$planette_es=$spy_planetteEspion;
				$info['total']+=1;
				$info[$spy_maplanette]['total']=1;
				$info[$spy_maplanette][$spy_planetteEspion]['date']=date("Y-m-d H:i:s", $datadate)." ( ".$pourcentage."% )";
				$info[$spy_maplanette][$spy_planetteEspion]['num']=1;
			}elseif($spy_planetteEspion!=$planette_es){
				$planette_es = $spy_planetteEspion;
				$info['total']+=1;
				$info[$spy_maplanette]['total']+=1;
				$info[$spy_maplanette][$spy_planetteEspion]['date']=date("Y-m-d H:i:s", $datadate)." ( ".$pourcentage."% )";
				$info[$spy_maplanette][$spy_planetteEspion]['num']=1;
			}else{
				$info['total']+=1;
				$info[$spy_maplanette]['total']+=1;
				$info[$spy_maplanette][$spy_planetteEspion]['date'].="<br />".date("Y-m-d H:i:s", $datadate)." ( ".$pourcentage."% )";
				$info[$spy_maplanette][$spy_planetteEspion]['num']+=1;
			}
		}
		$total = $info['total'];
		$tab[$total][$lejoueur]=$info;
		krsort($tab);
	
		$flux = "";
		foreach ($tab as $num => $players){
			foreach($players as $player => $planette){
				$flux .= "<tr>\n";
				$flux .= "<td class='c' align='center'><b>".$player."</b></td>\n";
				$flux .= "<th align='center'>".$num."</th>\n";
				reset($lst_planettes);
	 			foreach($lst_planettes as $key){
					if(array_key_exists($key, $planette)){
						$bubule = "";
			 			foreach($planette[$key] as $espion => $info){
							if($espion!="total"){
								$bubule .= "<u>".$espion."</u> : ".$info['num']."scan(s)<br>";
								$bubule .= $info['date']."<br />";
							}
						}
						$text = "<table width=\"200\">";
						$text .= "<tr><td align=\"center\" class=\"c\">Horaires des sondages</td></tr>";
						$text .= "<tr><th align=\"center\">".$bubule."</th></tr>";
						$text .= "</table>";
	
						$text = htmlentities($text);
						$text = "this.T_WIDTH=210;this.T_TEMP=0;return escape('".$text."')";
			 			$flux .= "<th><a style='cursor:pointer' onmouseover=\"".$text."\">".$planette[$key]['total']."</a></th>\n";
					}else{
			 			$flux .= "<th>&nbsp;</th>\n";
					}
				}
				$flux .= "</tr>\n";	 	
	 		}
	 	}
		echo $flux;
		echo "</table>\n";
	}
}
if(isset($pub_recherche)&&$pub_recherche=="Rechercher Alliance"){
	$timestamp = time()-(24*60*60*$pub_periodes);
	$datadate = mktime (0,0,0,date("m",$timestamp),date("d",$timestamp),date("y",$timestamp));

	$query_limit = "SELECT `spy_planetteEspion` , count(*) as num, SUBSTRING_INDEX( `spy_planetteEspion` , ':', 1 ) AS sagalaxy, SUBSTRING_INDEX(SUBSTRING_INDEX( `spy_planetteEspion` , ':', 2 ),':',-1) AS sasystem, SUBSTRING_INDEX( `spy_planetteEspion` , ':', -1 ) AS saplanette, (SELECT `ally` FROM `".TABLE_UNIVERSE."` WHERE `galaxy` = sagalaxy AND `system` = sasystem AND `row` = saplanette ) as ally FROM `".TABLE_QUIMOBSERVE."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']." GROUP BY `ally` HAVING num >= ".$pub_nombre_mini_alliance." ORDER BY ally ASC";

 	$result=$db->sql_query($query_limit);
	if($result=$db->sql_numrows($result)==0){
		echo "<div align='center'>Vous n'avez pas été espionné ces ".$pub_periodes." derniers jours</div>";
	}else{
		unset($lst_planettes);
		while(list($spy_planetteEspion,$num,$a,$b,$c,$alliance)=$db->sql_fetch_row($result)){
			if($alliance != ''){
	 			$lst_alliance[]="'".$alliance."'";
			}else{
				$ally_vide = " OR `ally` IS NULL ";
			}
		}
	 	$result_query_limit = join(",", $lst_alliance);

		$having = "";
		if($result_query_limit != ""){
			$having = "`ally` in (".$result_query_limit.")";
		}
		if($ally_vide != ""){
			if($having == ""){
				$having .= " OR ".$ally_vide;
			}else{
				$having .= $ally_vide;
			}
		}

		$query = "SELECT DISTINCT(`spy_maplanette`) as spy_maplanette FROM `".TABLE_QUIMOBSERVE."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']." ORDER BY `spy_maplanette` asc";
		$result2=$db->sql_query($query);
		$i=0;
		unset($lst_planettes);
		while(list($spy_maplanette)=$db->sql_fetch_row($result2)){
			 $lst_planettes[$i++]=$spy_maplanette;
 		}

		$query = "SELECT `spy_planetteEspion` , `spy_maplanette` , `datadate`, SUBSTRING_INDEX( `spy_planetteEspion` , ':', 1 ) AS sagalaxy, SUBSTRING_INDEX(SUBSTRING_INDEX( `spy_planetteEspion` , ':', 2 ),':',-1) AS sasystem, SUBSTRING_INDEX( `spy_planetteEspion` , ':', -1 ) AS saplanette, (SELECT `ally` FROM `".TABLE_UNIVERSE."` WHERE `galaxy` = sagalaxy AND `system` = sasystem AND `row` = saplanette ) as ally, `pourcentage`	FROM `".TABLE_QUIMOBSERVE."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']."
							HAVING ".$having." ORDER BY `ally` asc, `spy_maplanette` asc, `spy_planetteEspion` asc , `datadate` asc";
		$result=$db->sql_query($query);
		echo "<table width='100%'>";
		echo"<tr>";
		echo"<td class='c' align='center'><b>Aliance</b></td>";
		echo"<td class='c' align='center'><b>Nombre Total</b></td>";
		reset($lst_planettes);
		foreach($lst_planettes as $planette){
 			echo"<td class='c' align='center'><b>".$planette."</b></td>";
		}
		echo "</tr>";
		$lalliance = "-";
		$planette_es = "";
		$planette_ma = "";

		while(list($spy_planetteEspion, $spy_maplanette, $datadate,$a,$b,$c,$alliance,$pourcentage)=$db->sql_fetch_row($result)){
			if($lalliance != $alliance){
//generation du tableau avec les info du joueur d avant
				if($lalliance!="-"){
					$total = $info['total'];
					$tab[$total][$lalliance]=$info;
					unset($info);
				}
				$lalliance = $alliance;
				$planette_es=$spy_planetteEspion;
				$planette_ma = $spy_maplanette;
				$info['total']=1;
				$info[$spy_maplanette]['total']=1;
				$info[$spy_maplanette][$spy_planetteEspion]['date']=date("Y-m-d H:i:s", $datadate)." ( ".$pourcentage."% )";
				$info[$spy_maplanette][$spy_planetteEspion]['num']=1;
			}elseif($spy_maplanette!=$planette_ma){
				$planette_ma = $spy_maplanette;
				$planette_es=$spy_planetteEspion;
				$info['total']+=1;
				$info[$spy_maplanette]['total']=1;
				$info[$spy_maplanette][$spy_planetteEspion]['date']=date("Y-m-d H:i:s", $datadate)." ( ".$pourcentage."% )";
				$info[$spy_maplanette][$spy_planetteEspion]['num']=1;
			}elseif($spy_planetteEspion!=$planette_es){
				$planette_es = $spy_planetteEspion;
				$info['total']+=1;
				$info[$spy_maplanette]['total']+=1;
				$info[$spy_maplanette][$spy_planetteEspion]['date']=date("Y-m-d H:i:s", $datadate)." ( ".$pourcentage."% )";
				$info[$spy_maplanette][$spy_planetteEspion]['num']=1;
			}else{
				$info['total']+=1;
				$info[$spy_maplanette]['total']+=1;
				$info[$spy_maplanette][$spy_planetteEspion]['date'].="<br />".date("Y-m-d H:i:s", $datadate)." ( ".$pourcentage."% )";
				$info[$spy_maplanette][$spy_planetteEspion]['num']+=1;
			}
		}
	}
	$total = $info['total'];
	$tab[$total][$lalliance]=$info;

	@krsort($tab);

	$flux = "";
	foreach ($tab as $num => $alliances){
		foreach($alliances as $alliance => $planette){
			$flux .= "<tr>\n";
			$flux .= "<td class='c' align='center'><b>".$alliance."</b></td>\n";
			$flux .= "<th align='center'>".$num."</th>\n";
			reset($lst_planettes);
 			foreach($lst_planettes as $key){
				if(array_key_exists($key, $planette)){
					$bubule = "";
		 			foreach($planette[$key] as $espion => $info){
						if($espion!="total"){
							$bubule .= "<u>".$espion."</u> : ".$info['num']."scan(s)<br>";
							$bubule .= $info['date']."<br />";
						}
					}

					$text = "<table width=\"200\">";
					$text .= "<tr><td align=\"center\" class=\"c\">Horraire des sondages</td></tr>";
					$text .= "<tr><th align=\"center\">".$bubule."</th></tr>";
					$text .= "</table>";

					$text = htmlentities($text);
					$text = "this.T_WIDTH=210;this.T_TEMP=0;return escape('".$text."')";
		 			$flux .= "<th><a style='cursor:pointer' onmouseover=\"".$text."\">".$planette[$key]['total']."</a></th>\n";
				}else{
		 			$flux .= "<th>&nbsp;</th>\n";
				}
			}
			$flux .= "</tr>\n";	
 		}
 	}
	echo $flux;
	echo "</table>\n";
}
?>
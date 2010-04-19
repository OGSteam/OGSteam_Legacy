<?php
/**
* AnalysePlanettes.php 
 * @package QuiMobserve
 * @author Santory
 * @link http://www.ogsteam.fr
 * @version : 0.1d
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

if(!isset($pub_nombre_mini)){
	$pub_nombre_mini = 1;
}else{
 	$pub_nombre_mini = mysql_real_escape_string(intval($pub_nombre_mini));	
}

if(!isset($pub_periodes)){
	$pub_periodes = 20;
}else{
	$pub_periodes = mysql_real_escape_string(intval($pub_periodes));	
}


echo"<fieldset><legend><b><font color='#0080FF'>Analyse d'espionnages par planète";
echo help("parametre_annalise_planette");
echo"</font></b></legend><form action='index.php' method='post'>
	<table width='60%' align='center'><tr>
	<td><input type='hidden' name='action' value='Quimobserve'><input type='hidden' name='page' value='Analyse des Planètes'>
	Nombre de rapport minimal : </td><td><input type='text' name='nombre_mini' value=".$pub_nombre_mini." ></td></tr>
  <tr><td>Période en jours à analyser :  </td><td><input type='text' name='periodes' value=".$pub_periodes." ></td></tr>
	<tr>
	<td colspan='2' align='center'><p><input type='submit' name='recherche' value='Rechercher'></p></td>
	</tr></table></form></fieldset><br />";
if(isset($pub_recherche)){
  echo"<fieldset><legend><b><font color='#0080FF'>Résultat";
  echo"</font></b></legend>";
  $timestamp = time()-(24*60*60*$pub_periodes);
  $datadate = mktime (0,0,0,date("m",$timestamp),date("d",$timestamp),date("y",$timestamp));
  $query_limit = "SELECT `spy_planetteEspion` , count(*) as num  FROM `".TABLE_QUIMOBSERVE."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']." GROUP BY `spy_planetteEspion` HAVING num >= ".$pub_nombre_mini;
 	$result=$db->sql_query($query_limit);
  if($result=$db->sql_numrows($result)==0){
     echo "<div align='center'>Vous n'avez pas été espionné ces ".$pub_periodes." derniers jours</div>";
  }else{
	  unset($lst_planettes);
 	 	while(list($spy_planetteEspion,$num)=$db->sql_fetch_row($result)){
 	    $lst_planettes[]="'".$spy_planetteEspion."'";
  	}
  	$result_query_limit = join(",", $lst_planettes);
		$query = "SELECT `spy_planetteEspion` , `spy_maplanette` , `datadate`, `pourcentage` FROM `".TABLE_QUIMOBSERVE."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']."
							AND `spy_planetteEspion`in (".$result_query_limit.") ORDER BY `spy_planetteEspion` asc, `spy_maplanette` asc, `datadate` asc ";
		$result=$db->sql_query($query);
	  $query = "SELECT DISTINCT(`spy_maplanette`) as spy_maplanette FROM `".TABLE_QUIMOBSERVE."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']." ORDER BY `spy_maplanette` asc";
		$result2=$db->sql_query($query);
		$i=0;
	  unset($lst_planettes);
  	while(list($spy_maplanette)=$db->sql_fetch_row($result2)){
    	 $lst_planettes[$i++]=$spy_maplanette;
 		}
	  echo "<table width='100%'>";
	  echo"<tr>";
		echo"<td class='c' align='center'><b>Planètes Espion</b></td>";
		echo"<td class='c' align='center'><b>Nombre Total</b></td>";
    reset($lst_planettes);
    foreach($lst_planettes as $planette){
 			echo"<td class='c' align='center'><b>".$planette."</b></td>";
    }
    echo "</tr>";
    $planette_es = "";
    $planette_ma = "";
    while(list($spy_planetteEspion, $spy_maplanette, $datadate, $pourcentage)=$db->sql_fetch_row($result)){
    	if($spy_planetteEspion!=$planette_es){
    		$planette_es=$spy_planetteEspion;
        $planette_ma = $spy_maplanette;
        $info[$spy_planetteEspion]['total']=1;
  			$info[$spy_planetteEspion][$spy_maplanette]['date']=date("Y-m-d H:i:s", $datadate)." ( ".$pourcentage."% )";
        $info[$spy_planetteEspion][$spy_maplanette]['num']=1;      
    	}elseif($spy_maplanette!=$planette_ma){
        $planette_ma = $spy_maplanette;
        $info[$spy_planetteEspion]['total']+=1;
  			$info[$spy_planetteEspion][$spy_maplanette]['date']=date("Y-m-d H:i:s", $datadate)." ( ".$pourcentage."% )";
        $info[$spy_planetteEspion][$spy_maplanette]['num']=1;
      }else{
        $info[$spy_planetteEspion]['total']+=1;
				$info[$spy_planetteEspion][$spy_maplanette]['date'].="<br />".date("Y-m-d H:i:s", $datadate)." ( ".$pourcentage."% )";
        $info[$spy_planetteEspion][$spy_maplanette]['num']+=1;
			}
    }
    $flux = "";
    foreach ($info as $planette => $sub_info){
			$flux .= "<tr>\n";
			$link = "index.php?action=QuiMobserve&page=InfoPlanette&planete=".$planette;
			$flux .= "<td class='c' align='center'><b><a href=# onClick=\"window.open('$link','_blank','width=640, height=480, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0');return(false)\" >".$planette."</b></td>\n";

			$flux .= "<th align='center'>".$sub_info['total']."</th>\n";
      reset($lst_planettes);
	    foreach($lst_planettes as $key){
				if(array_key_exists($key, $sub_info)){
					$text = "<table width=\"200\">";
					$text .= "<tr><td align=\"center\" class=\"c\">Horaires des sondages</td></tr>";
					$text .= "<tr><th align=\"center\">".$sub_info[$key]['date']."</th></tr>";
					$text .= "</table>";

					$text = htmlentities($text);
					$text = "this.T_WIDTH=210;this.T_TEMP=0;return escape('".$text."')";

					$link = "index.php?action=QuiMobserve&page=PlanettesScans&planeteEs=".$planette."&planeteMa=".$key."&periodes=".$pub_periodes;
					$link = "onClick=\"window.open('$link','_blank','width=640, height=480, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0');return(false)\"";
			  	$flux .= "<th><a style='cursor:pointer' $link onmouseover=\"".$text."\">".$sub_info[$key]['num']."</a></th>\n";
			  }else{
			  	$flux .= "<th>&nbsp;</th>\n";
			  }
			}
			$flux .= "</tr>\n";   	
   	}
    echo $flux;
  	echo "</table>\n";
	}
	echo "</fieldset>";
}
?>

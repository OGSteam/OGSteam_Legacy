<?php
/**
 * Archives.php 
 * @package QuiMobserve
 * @author Santory
 * @link http://www.ogsteam.fr
 * @version : 0.1d
 */

 //L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='QuiMobserve' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//Définitions
global $db;
global $table_prefix;
define("TABLE_QUIMOBSERVE_ARCHIVE", $table_prefix."MOD_quimobserve_archive");
require_once("mod/QuiMObserve/help.php");


//Fieldset pour seletionner les dates de vusualisation des gains
echo"<fieldset><legend><b><font color='#0080FF'>Date d'affichage des éspionnages : ";
echo help("changer_affichage");
echo"</font></b></legend>";

echo"<font size=\"2\">Afficher les espionnages antérieurs : </font>";
echo"<form action='index.php' method='post'><input type='hidden' name='action' value='Quimobserve'><input type='hidden' name='page' value='Espace Archives'>";
echo"<font size=\"2\">Debut :<br />";
echo"mois : <input type='text' name='mois_mini' size='2' maxlength='2' value='$pub_mois_mini' /> ";
echo"année : ";
echo"<input type='text' name='annee_mini' size='4' maxlength='4' value='$pub_annee_mini' />";
echo"<br>";
echo"Fin :<br />";
echo"mois : <input type='text' name='mois_maxi' size='2' maxlength='2' value='$pub_mois_maxi' /> ";
echo"année : ";
echo"<input type='text' name='annee_maxi' size='4' maxlength='4' value='$pub_annee_maxi' />";
echo"</font><br />";
echo"<br /><br />";
echo"<input type='submit'	value='Afficher' name='B1'></form>";
echo"</fieldset>";
echo"<br><br>";

if (isset($pub_mois_mini) && isset($pub_annee_mini) && isset($pub_mois_maxi) && isset($pub_annee_maxi) && $pub_mois_mini != "" && $pub_annee_mini != "" && $pub_mois_maxi != "" && $pub_annee_maxi != ""){
	$pub_mois_mini = intval($pub_mois_mini);
	$pub_annee_mini = intval($pub_annee_mini);
	$pub_mois_maxi = intval($pub_mois_maxi);
	$pub_annee_maxi = intval($pub_annee_maxi);

	if($pub_mois_mini < 10){
		$pub_mois_mini="0".$pub_mois_mini;
	}

	if($pub_mois_maxi < 10){
		$pub_mois_maxi="0".$pub_mois_maxi;
	}

  $date_mini = $pub_annee_mini.$pub_mois_mini;
  $date_maxi = $pub_annee_maxi.$pub_mois_maxi;

	$sql = "SELECT `spy_planetteEspion`, `spy_maplanette`, `number`, `datadate` FROM ".TABLE_QUIMOBSERVE_ARCHIVE." WHERE sender_id=".$user_data["user_id"]." AND `datadate` >=".$date_mini." AND `datadate` <= ".$date_maxi." ORDER BY `spy_planetteEspion` ASC, `spy_maplanette` ASC, `datadate` DESC";

	$result = $db->sql_query($sql);
	$nb_result = mysql_num_rows($result);

	$date_mini_aff = substr($date_mini,0,4)."-".substr($date_mini,4,2);
	$date_maxi_aff = substr($date_maxi,0,4)."-".substr($date_maxi,4,2);
	echo"<fieldset><legend><b><font color='#0080FF'>Archives des espionages de ".$date_mini_aff." au ".$date_maxi_aff."</font></b></legend>";
	if($nb_result == 0) 
	{
		echo"<font color='#FF0000' size=\"2\">Vous n'avez pas de resultat pour cette période</font>";
	}else{
    $planette_es = "";
    $planette_ma = "";
    while(list($spy_planetteEspion, $spy_maplanette, $number, $datadate)=$db->sql_fetch_row($result)){
    	$date = substr($datadate,0,4)."-".substr($datadate,4,2);
    	if($spy_planetteEspion!=$planette_es){
    		$planette_es=$spy_planetteEspion;
        $planette_ma = $spy_maplanette;
        $info[$spy_planetteEspion]['total']=$number;
  			$info[$spy_planetteEspion][$spy_maplanette]['info']=$date." : ".$number;
        $info[$spy_planetteEspion][$spy_maplanette]['num']=$number;
    	}elseif($spy_maplanette!=$planette_ma){
        $planette_ma = $spy_maplanette;
        $info[$spy_planetteEspion]['total']+=$number;
  			$info[$spy_planetteEspion][$spy_maplanette]['info']=$date." : ".$number;
        $info[$spy_planetteEspion][$spy_maplanette]['num']=$number;
      }else{
        $info[$spy_planetteEspion]['total']+=$number;
				$info[$spy_planetteEspion][$spy_maplanette]['info'].="<br />".$date." : ".$number;
        $info[$spy_planetteEspion][$spy_maplanette]['num']+=$number;
			}
    }

	  $query = "SELECT DISTINCT(`spy_maplanette`) as spy_maplanette FROM `".TABLE_QUIMOBSERVE_ARCHIVE."` WHERE sender_id=".$user_data["user_id"]." AND `datadate` >=".$date_mini." AND `datadate` <= ".$date_maxi." ORDER BY `spy_maplanette` asc";
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

    $flux = "";
    foreach ($info as $planette => $sub_info){
			$flux .= "<tr>\n";
			$flux .= "<td class='c' align='center'><b>".$planette."</b></td>\n";
			$flux .= "<th align='center'>".$sub_info['total']."</th>\n";
      reset($lst_planettes);
	    foreach($lst_planettes as $key){
				if(array_key_exists($key, $sub_info)){
					$text = "<table width=\"200\">";
					$text .= "<tr><td align=\"center\" class=\"c\">Sondage par mois</td></tr>";
					$text .= "<tr><th align=\"center\">".$sub_info[$key]['info']."</th></tr>";
					$text .= "</table>";

					$text = htmlentities($text);
					$text = "this.T_WIDTH=210;this.T_TEMP=0;return escape('".$text."')";
			  	$flux .= "<th><a style='cursor:pointer' onmouseover=\"".$text."\">".$sub_info[$key]['num']."</a></th>\n";
			  }else{
			  	$flux .= "<th>&nbsp;</th>\n";
			  }
			}
			$flux .= "</tr>\n";   	
   	}
    echo $flux;
  	echo "</table>\n";
	}
	echo"</fieldset><br><br>";
}

?>
<?php
/***************************************************************************
*	filename	: Flotte_graph.php
*	Version 1.03
*	Author	: Conrad des Dragons
***************************************************************************/

/**************************************************************************
*	Ce mod gère les permission d'acces grace aux groupe d'ogpy.
*	Pour cela créé un groupe nomé "recherche_plus" et ajoutez y les utilisateur devants avoir acces a ce mod.
*	SI AUCUN GROUPE N'EST CREE, TOUS LES MEMBRES ONT ACCES.
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}


if (!isset($num_of_galaxies) || !isset($num_of_systems)) { 
	$num_of_galaxies = $server_config['num_of_systems'] ;
	$num_of_systems = $server_config['num_of_galaxies'];
}

if(isset($pub_graph) && $pub_graph == "barre") {
	require_once("./mod/flottes/flottes_gbarre.php");
	exit();
}

// insertion des fonctions flotte

require_once("./mod/flottes/function_flottes.php");
require_once("./mod/flottes/flottes_inc.php");
require_once("./mod/flottes/flottes_lang.php");


buttons_bar($pub_subaction);

echo "<i>Page en construction</i><br>";
if (function_exists('imagecreatetruecolor') !== FALSE) {
	

//	if($request_output!="" && $search_result) {
		$galaxy_up=9;
		$galaxy_down=1;
		$galaxy_nb = $galaxy_up - $galaxy_down + 1;
		
//echo "debug 01<br>Gup:".$galaxy_up."<br>Gdown:".$galaxy_down;
		
		if($galaxy_nb>=1 && $galaxy_nb<=2)
			$div_nb = 10;
		elseif($galaxy_nb>=3 && $galaxy_nb<=4)
			$div_nb = 5;
		elseif($galaxy_nb>=5 && $galaxy_nb<=10)
			$div_nb = 2;
		elseif($galaxy_nb>=11 && $galaxy_nb<=25)
			$div_nb = 1;
		elseif($galaxy_nb>=26)
			$div_nb = 1/2;
		else
			$div_nb = 2;
		
		$repartition = array();
		
		for($i=0; $i<($galaxy_nb*$div_nb); $i++) {
			$repartition[$i] = 0;
		}
		
		$j = 0;
		$coord_prefix =TABLE_MOD_FLOTTES."."; (isset($pub_spy_active) && $pub_spy_active)?TABLE_SPY.".spy_":TABLE_UNIVERSE.".";
		for($i=0; $i<$div_nb; $i++) {
			$s_up = (($num_of_systems+$num_of_systems%2)/$div_nb)*($i+1);
			$s_down = ((($num_of_systems+$num_of_systems%2)/$div_nb)*$i)+1;
			
			$request = "select count(distinct ".$coord_prefix."coordinates), left(".$coord_prefix."coordinates,1) as galaxy FROM ".TABLE_MOD_FLOTTES." GROUP BY left(".$coord_prefix."coordinates,1) ";
			
			$result = $db->sql_query($request);
			while(list($v, $g) = $db->sql_fetch_row($result)) {
				while($j<($g-$galaxy_down+($galaxy_nb*$i))) {
					$j++;
//					echo "J=".$j."<br>";
				}
				$repartition[floor($j*($div_nb<1?$div_nb:1))] += $v;
//				echo "REP=".$repartition[floor($j*($div_nb<1?$div_nb:1))]."<br>";
				$j++;
			}
		}
//		$div_nb=2;
		echo "<br /><img src='index.php?action=flottes&graph=barre&repartition=".implode(":",$repartition)."&div_nb=".($div_nb<1?((-1)/$div_nb):$div_nb)."&galaxy_down=".$galaxy_down."' alt='pas de graphique disponible' />";
//	}
//	echo "<br>debug2<br>".implode(":",$repartition)."<br>".$div_nb."<br>";
} else {
	echo "<br /><span style='font-size:10px;'>Graphique indisponible car une option de php n'est pas disponible.</span>";
//	echo "Debug1b<br>";
}
?>




<?php

$panel['title'] = 'Infos OGSpy'; // title for panel


   /**
* Récupération du nb de planete a jour  pour 15 jours ( attention : valable que si la galaxie est rempli ...)
*/
$now=15;  ///nb de jour
$date=time()-(60*60*24*$now) ;
 $request ="select count(*) from ogspy_universe where (last_update > $date)";
 $result = $forum_db->query($request);
 list($maj1) = $forum_db->fetch_row($result);
 $maj= $maj1;









 /**
* Récupération des statistiques des galaxies
*/
function galaxy_statistic($step = 50) {
	global $forum_db, $user_data, $server_config;

	$nb_planets_total = 0;
	$nb_freeplanets_total = 0;
	for ($galaxy=1 ; $galaxy<=9 ; $galaxy++) {
		for ($system=1 ; $system<=499 ; $system=$system+$step) {
			$request = "select count(*) from ogspy_universe";
			$request .= " where galaxy = ".$galaxy;
			$request .= " and system between ".$system." and ".($system+$step-1);
			$result = $forum_db->query($request);
			list($nb_planet) = $forum_db->fetch_row($result);
			$nb_planets_total += $nb_planet;

			$request = "select count(*) from ogspy_universe";
			$request .= " where player = ''";
			$request .= " and galaxy = ".$galaxy;
			$request .= " and system between ".$system." and ".($system+$step-1);
			$result = $forum_db->query($request);
			list($nb_planet_free) = $forum_db->fetch_row($result);
			$nb_freeplanets_total += $nb_planet_free;

			$new = false;
			$request = "select max(last_update) from ogspy_universe";
			$request .= " where galaxy = ".$galaxy;
			$request .= " and system between ".$system." and ".($system+$step-1);
			$result = $forum_db->query($request);
			list($last_update) = $forum_db->fetch_row($result);
			if ($last_update > $user_data["session_lastvisit"]) $new = true;

			$statictics[$galaxy][$system] = array("planet" => $nb_planet, "free" => $nb_planet_free, "new" => $new);
		}
	}
		return array("map" =>$statictics, "nb_planets" => $nb_planets_total, "nb_planets_free" => $nb_freeplanets_total);

}


$galaxy_statistic = galaxy_statistic();

 echo '<ul class="infosogs">      ';

 echo '<li>planetes : <b>'.$galaxy_statistic["nb_planets"].'</b></li>';
 echo '<li>planetes libres : <b>'.$galaxy_statistic["nb_planets_free"].'</b></li>';
  /// % de mise a jour sur 15 jours
     echo '<li>mise a jour a <a href="extensions/ogame_portail/vue/maj.php"><b>'.round(($maj/$galaxy_statistic["nb_planets"])*100,1).'%</b></a></li>';


 /// cacul nb de rapport d'espionnage dans la base
 $request ="select count(*) from ogspy_parsedspy ";
 $result = $forum_db->query($request);
 list($nb_spy1) = $forum_db->fetch_row($result);
 $nb_spy= $nb_spy1;
 echo '<li>Nombre de RE : <b>'.$nb_spy.'</b></li>';



 
 

  
  

   ?>

   


   
   

</ul>







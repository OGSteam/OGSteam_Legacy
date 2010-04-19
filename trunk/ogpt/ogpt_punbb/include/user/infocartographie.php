<?php
?>
<script type="text/javascript" src="ogpt/js/wz_tooltip.js"></script>

<?php


/// cacul nb de rapport d'espionnage dans la base

$request = 'select count(distinct(player)) from ' . $pun_config["ogspy_prefix"] .
    'universe ';

$result = $db->query($request);

list($nb_player1) = $db->fetch_row($result);

$nb_player = $nb_player1;

?>


<li>portail OGPT V. <b><span style="color:#2C6E04"><a href="http://www.ogsteam.fr/viewforum.php?id=99" onmouseover="Tip('OGSTEAM')" onmouseout="UnTip()"><?php echo '' . $pun_config['OGPT'] .
    ''; ?> </a></font></b></span></li> 


<?php

/// affichage du nb tiotal de juoeur


echo '<p></p><li>Total joueurs :<b><span style="color:#2C6E04">' . $nb_player .
    '</font></b></span></li> ';


$now = 15;


$date = time() - (60 * 60 * 24 * $now);


$request = "select count(*) from " . $pun_config['ogspy_prefix'] .
    "universe where (last_update > $date)";


$result = $db->query($request);


list($maj1) = $db->fetch_row($result);


$maj = $maj1;


function galaxy_statistic($step = 50)
{


    global $db, $user_data, $server_config, $pun_config;


    $nb_planets_total = 0;


    $nb_freeplanets_total = 0;


    for ($galaxy = 1; $galaxy <= 9; $galaxy++) {


        for ($system = 1; $system <= 499; $system = $system + $step) {


            $request = "select count(*) from " . $pun_config['ogspy_prefix'] . "universe";


            $request .= " where galaxy = " . $galaxy;


            $request .= " and system between " . $system . " and " . ($system + $step - 1);


            $result = $db->query($request);


            list($nb_planet) = $db->fetch_row($result);


            $nb_planets_total += $nb_planet;


            $request = "select count(*) from " . $pun_config['ogspy_prefix'] . "universe";


            $request .= " where player = ''";


            $request .= " and galaxy = " . $galaxy;


            $request .= " and system between " . $system . " and " . ($system + $step - 1);


            $result = $db->query($request);


            list($nb_planet_free) = $db->fetch_row($result);


            $nb_freeplanets_total += $nb_planet_free;


            $new = false;


            $request = "select max(last_update) from " . $pun_config['ogspy_prefix'] .
                "universe";


            $request .= " where galaxy = " . $galaxy;


            $request .= " and system between " . $system . " and " . ($system + $step - 1);


            $result = $db->query($request);


            list($last_update) = $db->fetch_row($result);


            if ($last_update > $user_data["session_lastvisit"])
                $new = true;


            $statictics[$galaxy][$system] = array("planet" => $nb_planet, "free" => $nb_planet_free,
                "new" => $new);


        }


    }


    return array("map" => $statictics, "nb_planets" => $nb_planets_total,
        "nb_planets_free" => $nb_freeplanets_total);


}


$galaxy_statistic = galaxy_statistic();


echo '<span class="gensmall">planetes : <b><span style="color:#2C6E04">' . $galaxy_statistic["nb_planets"] .
    '</span></b></span><br>';


echo '<span class="gensmall">planetes libres : <b><span style="color:#2C6E04">' .
    $galaxy_statistic["nb_planets_free"] . '</span></b></span><br>';


if ($galaxy_statistic["nb_planets"]>0){
    echo '<span class="gensmall">mise a jour de <b><span style="color:#2C6E04">'.round(($maj/$galaxy_statistic["nb_planets"])*100,1).'%</span></b> </span><br>';
}
else{
      echo '<span class="gensmall">mise a jour de <b><span style="color:#2C6E04">0%</span></b> </span><br>';
}


$request = "select count(*) from " . $pun_config['ogspy_prefix'] . "parsedspy ";


$result = $db->query($request);


list($nb_spy1) = $db->fetch_row($result);


$nb_spy = $nb_spy1;


echo '<br><span class="gensmall">Nombre de RE : <b><span style="color:#2C6E04">' .
    $nb_spy . '</font></b></span>';



?>



       






<div class="block">
			<div id="slideshow" class="acc_pictures box slideshow">
    <table border="0" cellspacing="0" cellpadding="0">
      <tr> 
        <td><div align="center"><font color="#666666"><strong>Top espionnage</strong></font></div></td>
        <td><div align="center"><font color="#006699"><strong>Infos Cartographie</strong></font></div></td>
        <td><div align="center"><font color="#666666"><strong>Top mise 
            &agrave; Jour</strong></font></div></td>
        <td><div align="center"><font color="#006699"><strong>Qui nous sonde?</strong></font></div></td>
      </tr>
      <tr> 
        <td> 
          <?php
// Récupération espionnage
require_once  PUN_ROOT . 'ogpt/include/ogpt_pan.php';

$request = "select * from " . $pun_config['ogspy_prefix'] . "parsedspy";
$result = $db->query($request);
list($nb_spy1) = $db->fetch_row($result);
$nb_spy = $nb_spy1;


$sql = 'SELECT user_name, count(*) as nb FROM ' . $pun_config["ogspy_prefix"] .
    'parsedspy , ' . $pun_config["ogspy_prefix"] .
    'user WHERE  user_id=sender_id GROUP BY sender_id ORDER BY nb DESC LIMIT 4';
$result = $db->query($sql);

while ($maj = $db->fetch_assoc($result)) {
    echo '<span class="gensmall">' . $maj['user_name'] .
        ' : <b><span style="color:#2C6E04">' . round($maj['nb'] / $nb_spy / 10, 1) .
        '</spans></b>% </span><br>';
}

echo '<br><span class="gensmall">Total espionnage :<b>' . $nb_spy .
    '</b></span> ';

?>
        </td>
        <td> 
          <?php


$now = 15;
$date = time() - (60 * 60 * 24 * $now);
$request = "select count(*) from " . $pun_config['ogspy_prefix'] .
    "universe where (last_update > $date)";
$result = $db->query($request);
list($maj1) = $db->fetch_row($result);
$maj = $maj1;
function galaxy_statistic($step = 50)
{
    global $db, $user_data, $server_config;

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

echo '<span class="gensmall">mise a jour de <b><span style="color:#2C6E04">' .
    round(($maj / $galaxy_statistic["nb_planets"]) * 100, 1) .
    '%</span></b> </span><br>';


$request = "select count(*) from " . $pun_config['ogspy_prefix'] . "parsedspy ";
$result = $db->query($request);
list($nb_spy1) = $db->fetch_row($result);
$nb_spy = $nb_spy1;
echo '<br><span class="gensmall">Nombre de RE : <b><span style="color:#2C6E04">' .
    $nb_spy . '</font></b></span>';
?>
        </td>
        <td>
		<?php
$request = "select count(*) from " . $pun_config['ogspy_prefix'] . "universe ";
$result = $db->query($request);
list($total1) = $db->fetch_row($result);
$total = $total1;

$sql = 'SELECT user_name, count(*) as nb FROM ' . $pun_config["ogspy_prefix"] .
    'universe , ogspy_user WHERE  user_id=last_update_user_id GROUP BY last_update_user_id ORDER BY nb DESC LIMIT 6';
$result = $db->query($sql);

while ($maj = $db->fetch_assoc($result)) {
    echo ' <span class="gensmall">' . $maj['user_name'] .
        ' : <b><span style="color:#2C6E04">' . round($maj['nb'] / $total * 100, 1) .
        '</b>%</font></span><br> ';
}
?>
		
		</td>
        <td>
		<?php

$request = "select count(*) from " . $pun_config['ogspy_prefix'] . "QuiMeSonde ";
$result = $db->query($request);
list($nb_spy1) = $db->fetch_row($result);
$nb_spy = $nb_spy1;

$sql = 'SELECT user_name, count(*) as nb FROM ' . $pun_config["ogspy_prefix"] .
    'QuiMeSonde , ogspy_user WHERE  user_id=sender_id GROUP BY sender_id ORDER BY nb DESC limit 1';
$result = $db->query($sql);
while ($maj = $db->fetch_assoc($result)) {
    echo '<span class="gensmall">Le plus espionné : <span style="color:#083F7E">' .
        $maj['user_name'] . ' </span></font><br>';
}


echo '<b><span class="gensmall"><span style="color:#8B061">joueurs actifs :</span</span></b><br>  ';
$sql = 'SELECT user_name, joueur , count(*) as nb FROM ' . $pun_config["ogspy_prefix"] .
    'QuiMeSonde , ogspy_user WHERE  user_id=sender_id GROUP BY joueur ORDER BY nb desc limit 2';
$result = $db->query($sql);
while ($maj1 = $db->fetch_assoc($result)) {
    echo '<span class="gensmall">' . $maj1['joueur'] . ' ( <b>' . round($maj1['nb'] /
        $nb_spy * 100, 1) . '</b>% )</span><br>
              ';
}
echo '<b><span class="gensmall"><font color="8B061C">alliances actives :</font></span></b><br>  ';
$sql = 'SELECT user_name, alliance , count(*) as nb FROM ' . $pun_config["ogspy_prefix"] .
    'QuiMeSonde , ogspy_user WHERE  user_id=sender_id GROUP BY alliance ORDER BY nb desc limit 1';
$result = $db->query($sql);
while ($maj2 = $db->fetch_assoc($result)) {
    echo '<span class="gensmall">' . $maj2['alliance'] .
        ' ( <b><span style="color:#083F7E">' . round($maj2['nb'] / $nb_spy * 100, 1) .
        '</b>%</span> )</span><br>
              ';
}
?>
</td>
      </tr>
    </table>
</div> </div>

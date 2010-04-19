<?php
require_once  PUN_ROOT . 'ogpt/include/ogpt_pan.php';



$sql = 'SELECT

distinct(P.player) as pplayer, (PF1.POINTS - PF2.POINTS) as PROGRESSION, PF1.POINTS as total 

FROM   ' . $pun_config["ogspy_prefix"] . 'rank_members as P

LEFT JOIN ' . $pun_config["ogspy_prefix"] .
    'rank_members as PF1 on PF1.player = P.player

LEFT JOIN ' . $pun_config["ogspy_prefix"] .
    'rank_members as PF2 on PF2.player = PF1.player

WHERE



PF1.DATADATE = (SELECT MAX(DATADATE) FROM ' . $pun_config["ogspy_prefix"] .
    'rank_members)

AND

PF2.DATADATE = (SELECT MAX(DATADATE) FROM ' . $pun_config["ogspy_prefix"] .
    'rank_members WHERE DATADATE <> PF1.DATADATE)

ORDER BY PROGRESSION DESC ';


$result = $db->query($sql);

while ($maj = $db->fetch_assoc($result)) {


    if ($maj['PROGRESSION'] < -1) {

        $color = 'red';

        echo '<li><b>' . $maj['pplayer'] . '</b> : <font color=\'' . $color . '\'>' . $maj['PROGRESSION'] .
            '</font></li>';

    } elseif ($maj['PROGRESSION'] > 1) {

        $color = 'green';

        echo '<li><b>' . $maj['pplayer'] . '</b> : <font color=\'' . $color . '\'>' . $maj['PROGRESSION'] .
            '</font></li>';

    } else {
        echo '';
    }

}

?>
<?php
require_once  PUN_ROOT . 'ogpt/include/ogpt_pan.php';


/// cacul nb de rapport d'espionnage dans la base

$request = 'select count(*) from ' . $pun_config["ogspy_prefix"] . 'parsedspy ';

$result = $db->query($request);

list($nb_spy1) = $db->fetch_row($result);

$nb_spy = $nb_spy1;


/// les 10 ayant le plus de espionnage

$sql = 'SELECT user_name, count(*) as nb FROM ' . $pun_config["ogspy_prefix"] .
    'parsedspy , ' . $pun_config["ogspy_prefix"] .
    'user WHERE  user_id=sender_id GROUP BY sender_id ORDER BY nb DESC LIMIT 10';

$result = $db->query($sql);

while ($maj = $db->fetch_assoc($result)) {

    echo '<li>' . $maj['user_name'] . ' : <b>' . round($maj['nb'] / $nb_spy * 100, 1) .
        '</b>% <li>';

}


/// affichage du nb tiotal d'espionnage


echo '<p></p><li>Total spy :<b>' . $nb_spy . '</b></li> ';















?>



       


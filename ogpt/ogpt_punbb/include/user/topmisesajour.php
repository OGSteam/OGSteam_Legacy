<?php
require_once  PUN_ROOT . 'ogpt/include/ogpt_pan.php';
$request = "select count(*) from " . $pun_config['ogspy_prefix'] . "universe ";

$result = $db->query($request);

list($total1) = $db->fetch_row($result);

$total = $total1;


$sql = 'SELECT user_name, count(*) as nb FROM ' . $pun_config["ogspy_prefix"] .
    'universe , ' . $pun_config["ogspy_prefix"] .
    'user WHERE  user_id=last_update_user_id GROUP BY last_update_user_id ORDER BY nb DESC LIMIT 9';

$result = $db->query($sql);


while ($maj = $db->fetch_assoc($result)) {

    echo ' <span class="gensmall">' . $maj['user_name'] .
        ' : <b><span style="color:#2C6E04">' . round($maj['nb'] / $total * 100, 1) .
        '</b>%</font></span><br> ';

}

?>


<?php
require_once  PUN_ROOT . 'ogpt/include/ogpt_pan.php';
/// verif de l'existance du mod dans ogspy'
$mod = "QuiMSonde";
$ok = "0";
$sql = 'SELECT count(id) FROM   ' . $pun_config["ogspy_prefix"] .
    'mod WHERE action=\'' . $mod . '\'';
$result = $db->query($sql);
list($nb_mod) = $db->fetch_row($result);
$ok = $nb_mod;

if ($ok == '0' || $ok == '') {
    echo ' le panneau ne peut s afficher<br> le mod n est pas installe sur  <br>ogspy';
} else {


    $request = "select count(*) from " . $pun_config['ogspy_prefix'] . "QuiMeSonde ";


    $result = $db->query($request);


    list($nb_spy1) = $db->fetch_row($result);


    $nb_spy = $nb_spy1;


    $sql = 'SELECT user_name, count(*) as nb FROM ' . $pun_config["ogspy_prefix"] .
        'QuiMeSonde , ' . $pun_config["ogspy_prefix"] .
        'user WHERE  user_id=sender_id GROUP BY sender_id ORDER BY nb DESC limit 1';


    $result = $db->query($sql);


    while ($maj = $db->fetch_assoc($result)) {


        echo '<span class="gensmall">Le plus espionné : <span style="color:#083F7E">' .
            $maj['user_name'] . ' </span></font><br>';


    }


    echo '<b><span class="gensmall"><span style="color:#8B061">joueurs actifs :</span</span></b><br>  ';


    $sql = 'SELECT user_name, joueur , count(*) as nb FROM ' . $pun_config["ogspy_prefix"] .
        'QuiMeSonde , ' . $pun_config["ogspy_prefix"] .
        'user WHERE  user_id=sender_id GROUP BY joueur ORDER BY nb desc limit 4';


    $result = $db->query($sql);


    while ($maj1 = $db->fetch_assoc($result)) {


        echo '<span class="gensmall"><a href="rech_joueur.php?action=rech_joueur&joueur=' .
            $maj1['joueur'] . '">' . $maj1['joueur'] . '</a> ( <b>' . round($maj1['nb'] / $nb_spy *
            100, 1) . '</b>% )</span><br>



              ';


    }


    echo '<b><span class="gensmall"><font color="8B061C">alliances actives :</font></span></b><br>  ';


    $sql = 'SELECT user_name, alliance , count(*) as nb FROM ' . $pun_config["ogspy_prefix"] .
        'QuiMeSonde , ' . $pun_config["ogspy_prefix"] .
        'user WHERE  user_id=sender_id GROUP BY alliance ORDER BY nb desc limit 3';


    $result = $db->query($sql);


    while ($maj2 = $db->fetch_assoc($result)) {


        echo '<span class="gensmall"><a href="rech_ally.php?action=rech_ally&ally=' . $maj2['alliance'] .
            '">' . $maj2['alliance'] . '</a> ( <b><span style="color:#083F7E">' . round($maj2['nb'] /
            $nb_spy * 100, 1) . '</b>%</span> )</span><br>



              ';


    }


    // dernier joueur espionné:

    echo '<br><li><strong>Dernier espionnage :</strong></li> ';

    $request = "select * from " . $pun_config['ogspy_prefix'] .
        "QuiMeSonde ORDER BY datadate desc  LIMIT 1";

    $result = $db->query($request);

    while ($deresp = $db->fetch_assoc($result)) {

        echo '<li><a href="rech_joueur.php?action=rech_joueur&joueur=' . $deresp['joueur'] .
            '">' . $deresp['joueur'] . '</a> &agrave;  ' . date("H:i", $deresp['datadate']) .
            ' </li>';

    }


}
?>

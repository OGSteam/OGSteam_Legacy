<?php
require_once  PUN_ROOT . 'ogpt/include/ogpt_pan.php';

/// verif de l'existance du mod dans ogspy'
$mod = "gameOgame";
$ok = "0";
$sql = 'SELECT count(id) FROM   ' . $pun_config["ogspy_prefix"] .
    'mod WHERE action=\'' . $mod . '\'';
$result = $db->query($sql);
list($nb_mod) = $db->fetch_row($result);
$ok = $nb_mod;

if ($ok == '0' || $ok == '') {
    echo ' le panneau ne peut s afficher<br> le mod n est pas installe sur  <br>ogspy';
} else {


    // fonction a placer en include


    function number($number)
    {

        global $db;


        return (number_format($number, 0, '.', ' '));

    }


    //fn2


    function userNameById($id)
    {

        global $db, $pun_config;


        $sql = 'SELECT user_name FROM   ' . $pun_config["ogspy_prefix"] .
            'user WHERE user_id=\'' . (int)$id . '\'';

        $result = $db->query($sql);

        list($name) = $db->fetch_row($result);

        if ($name == '')
            $name = "??????????";

        return ($name);

    }


    /// gestion de l'affichage aleatoire :

    $j = rand(1, 4);


    ///	fin des fonction a placer en include


?>



<?php

    if ($j == 1) {

?>

<li><b>top joueur :</b></li><br />

      <?php





        $sql = 'SELECT  g.sender,g.id , sum(g.points) AS total, count(g.id) AS nb  FROM ' .
            $pun_config["ogspy_prefix"] . 'game  AS g LEFT JOIN ' . $pun_config["ogspy_prefix"] .
            'game_users AS u ON u.id=g.sender WHERE u.user=\'1\' GROUP BY g.sender ORDER BY total DESC, g.sender ASC limit 10';

        $result = $db->query($sql);


        $i = 1;


        while ($val = $db->fetch_assoc($result)) {

            $name = userNameById($val['sender']);

            echo '<li><b>' . $name . '</b> :' . number($val['total']) . '</li>';

            $i++;

        }

    }



?>

 























<?php

    if ($j == 2) {

?>





<li><b> top rapport :</b></li><br />

 <?php





        ///top 10 rapport


        $sql = 'SELECT g.date, g.sender, g.id, g.points  FROM ' . $pun_config["ogspy_prefix"] .
            'game  AS g LEFT JOIN ' . $pun_config["ogspy_prefix"] .
            'game_users  AS u ON u.id=g.sender WHERE u.user=\'1\' ORDER BY g.points DESC, g.date DESC LIMIT 10';

        $result = $db->query($sql);


        $i = 1;


        while ($val = $db->fetch_assoc($result)) {

            $name = userNameById($val['sender']);

            echo '<li><b>' . $name . '</b> (' . number($val['points']) . ')</li>';

            $i++;

        }


    } ?>













<?php

    if ($j == 3) {

?>



 <li><b> top recyclage :</b></li><br />

 <?php





        ///top 10 recyclage


        $sql = 'SELECT g.date, g.sender, g.id, g.recycleM+g.recycleC AS recyclage FROM ' .
            $pun_config["ogspy_prefix"] . 'game  AS g LEFT JOIN ' . $pun_config["ogspy_prefix"] .
            'game_users AS u ON u.id=g.sender WHERE u.user=\'1\' ORDER BY recyclage DESC LIMIT 10';

        $result = $db->query($sql);


        $i = 1;


        while ($val = $db->fetch_assoc($result)) {

            $name = userNameById($val['sender']);

            echo '<li><b>' . $name . '</b> (' . number($val['recyclage']) . ')</li>';

            $i++;

        }


    } ?>





<?php

    if ($j == 4) {

?>



 <li><b> top pillage :</b></li><br />

 <?php





        ///top 10 pillage


        $sql = 'SELECT g.id, g.sender, g.pillageM+g.pillageC+g.pillageD AS total, g.date FROM ' .
            $pun_config["ogspy_prefix"] . 'game  AS g, ' . $pun_config["ogspy_prefix"] .
            'game_users AS u WHERE g.sender=u.id AND u.user=\'1\' ORDER BY total DESC, g.sender ASC LIMIT 10';

        $result = $db->query($sql);


        $i = 1;


        while ($val = $db->fetch_assoc($result)) {

            $name = userNameById($val['sender']);

            echo '<li> <b>' . $name . '</b> (' . number($val['total']) . ')</li>';

            $i++;

        }


    }


}


?>
<?php
require_once  PUN_ROOT . 'ogpt/include/ogpt_pan.php';
$request = "select count(*) from mod_pandore ";
$result = $db->query($request);
list($nb_1) = $db->fetch_row($result);
$nb = $nb_1;
$nb_spy = $nb;

echo '<span class="gensmall">Nombre de fiches : <span style="color:#083F7E">' .
    $nb . ' </font></span><br>';
echo '<br>';
echo '<span class="gensmall">5 dernieres fiches : </span><br>';


$sql = 'SELECT distinct(nom) FROM mod_pandore  ORDER BY date DESC limit 5';
$result = $db->query($sql);
while ($maj = $db->fetch_assoc($result)) {
    echo '<span class="gensmall"><a href="pandore.php?nom=' . $maj['nom'] .
        '&type=voir">' . $maj['nom'] . '</a></span><br>';

}
echo '<br>';


?>

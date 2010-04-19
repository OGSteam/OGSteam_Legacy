<?php
define('PUN_ROOT', './');
require PUN_ROOT . 'include/common.php';
///ogpt
$lien = "ally.php";
$page_title = "stat";
require_once PUN_ROOT . 'ogpt/include/ogpt.php';
/// fin ogpt

// Load the index.php language file
require PUN_ROOT . 'lang/' . $pun_user['language'] . '/index.php';


define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT . 'header.php';
?>
<div class="blockform"><h2><span> Stat de l'Alliance</span></h2><div class="box">
<?php

$sql = "SELECT `config_value` FROM " . $pun_config['ogspy_prefix'] .
    "CONFIG WHERE `config_name`=\'tblAlly\'";
$result = $db->query($sql);
list($tblSpy) = $db->fetch_row($result);

define(TABLE_VARALLY, '' . $pun_config["ogspy_prefix"] . 'rank_members');

$sql = 'SELECT `config_value` FROM ' . $pun_config["ogspy_prefix"] .
    'CONFIG WHERE `config_name`=\'tblAlly\'';
$result = $db->query($sql);
list($tblSpy) = $db->fetch_row($result);

//$tag = 'alliance';

$sql = 'SELECT config_value	 FROM ' . $pun_config["ogspy_prefix"] .
    'config  where config_name=\'tagAlly\'';
$result = $db->query($sql);

while ($tagg = $db->fetch_assoc($result)) {
    $tag = $tagg['config_value'];


}


check_tag($tag);
$listTag = explode(';', $tag);

$query = 'SELECT DISTINCT `datadate` FROM `' . TABLE_VARALLY .
    '` ORDER BY `datadate` DESC';
$result = $db->query($query);
$dateMin = $dateMax = '';
while ($var = $db->fetch_assoc($result)) {
    $dateMin .= '<option' . ((date('d/m/Y H:i:s', $var['datadate']) == $pub_dateMin) ?
        ' selected' : '') . '>' . date('d/m/Y H:i:s', $var['datadate']) . '</option>';
    $dateMax .= '<option' . ((date('d/m/Y H:i:s', $var['datadate']) == $pub_dateMax) ?
        ' selected' : '') . '>' . date('d/m/Y H:i:s', $var['datadate']) . '</option>';
}
?>
<form method='post' action='?action=varAlly&subaction=ally'>
Date min: <select name='dateMin'><?php echo $dateMin; ?></select>&nbsp;-&nbsp;
Date max: <select name='dateMax'><?php echo $dateMax; ?></select>&nbsp;
<input type='submit' value='Afficher'>
</form>
<?php
if ($tag == '') {
    echo '<table width=\'100%\'><tr><td class=\'c\'>Pas d\'alliance sélectionnée</th></tr></table></br>';
} else {
    $whereDate = '';
    if (isset($_POST['dateMin']) && isset($_POST['dateMax'])) {
        $dateMinStamped = parseDate($_POST['dateMin']);
        $dateMaxStamped = parseDate($_POST['dateMax']);
        if ($dateMinStamped <= $dateMaxStamped) {
            $whereDate = ' AND `datadate`>=\'' . $dateMinStamped . '\' AND `datadate`<=\'' .
                $dateMaxStamped . '\'';
        } else {
            echo 'Dates erronées (min > max)!';
        }
    }
    foreach ($listTag as $tag) {
        $tblecart = array();

        $sql = 'SELECT DISTINCT `datadate` FROM `' . TABLE_VARALLY . '` WHERE `ally`=\'' .
            $tag . '\'' . $whereDate . ' ORDER BY `datadate` DESC LIMIT 2';
        $result = $db->query($sql);
        $nb = $db->num_rows($result);

        switch ($nb) {
            case '0':
                $evolution = 'Classement inconnu';
                $where = '';
                break;
            case '1':
                list($new) = $db->fetch_row($result);
                $evolution = 'Classement du ' . date('d/m/Y H:i:s', $new);
                $where = ' AND `datadate` = \'' . $new . '\' ';
                break;
            case '2':
                list($new) = $db->fetch_row($result);
                list($ex) = $db->fetch_row($result);
                $evolution = 'Evolution entre le ' . (isset($_POST['dateMin']) ? $_POST['dateMin'] :
                    date('d/m/Y H:i:s', $ex)) . ' et le ' . (isset($_POST['dateMax']) ? $_POST['dateMax'] :
                    date('d/m/Y H:i:s', $new));
                $where = ' AND (`datadate` = \'' . $new . '\' OR `datadate` = \'' . $ex . '\') ';
                break;
        }

        $query = 'SELECT DISTINCT `player` FROM `' . TABLE_VARALLY . '` WHERE `ally`=\'' .
            $tag . '\'' . $where . ' ORDER BY `points` DESC';
        $result = $db->query($query);

?>
		<h2>Alliance [<?php echo $tag; ?>]</h2>
		<table width='100%'>
		<tr><td class='c' colspan='7'><?php echo $evolution; ?></td></tr>
		<tr><th class='c'>Joueur</th><th class='c'>Ecart général</th><th class='c'>%</th></tr>		
<?php
        while ($val = $db->fetch_assoc($result)) {
            $player = $val['player'];
            echo '<tr><td>' . $player . '</td>';
            affPoints($player, $whereDate);
            echo '</td>';
        }
?>
		</table><br><br />
<?php


    }
}
?>



</div></div>
  <div class="blockform">
	<h2><span>Propulsé par ogspy/<a href="http://www.ogsteam.fr">ogsteam</a></span></h2>

    </div>



<?php
$footer_style = 'index';
require PUN_ROOT . 'footer.php'
?>
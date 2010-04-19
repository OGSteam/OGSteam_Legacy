<?php

///envoi des include necessaires
require_once PUN_ROOT . 'ogpt/include/fonction.php';
require_once PUN_ROOT . 'ogpt/include/empire.php';
require_once PUN_ROOT . 'ogpt/include/prod.php';
require_once PUN_ROOT . 'ogpt/include/re.php';
require_once PUN_ROOT . 'ogpt/include/rech.php';
require_once PUN_ROOT . 'ogpt/include/records.php';
require_once PUN_ROOT . 'ogpt/include/varally.php';
require_once PUN_ROOT . 'ogpt/include/galaxie.php';
/// fin des includes


/// variable globale ogpt
$request = "select * from ogpt";
$result = $db->query($request);
while (list($name, $value) = $db->fetch_row($result)) {
    $ogpt[$name] = stripslashes($value);
}



?>
<?php

if (file_exists('mod/vaisseaux/version.txt')) {
	$file = file('mod/vaisseaux/version.txt');
	
	$db->sql_query('INSERT INTO '.TABLE_MOD.' (id, title, menu, action, root, link, version, active) VALUES ("", "Vaisseaux", "Vaisseaux", "vaisseaux", "vaisseaux", "vaisseaux.php", "'.trim($file[1]).'", "1")');

}
?>

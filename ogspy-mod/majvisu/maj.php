<?php

if (!defined('IN_SPYOGAME')) {
	exit('Hacking attempt!');
}

// ajout modif inter
define('FOLDER_LANG', 'mod/majvisu/lang');
include_once FOLDER_LANG .'/lang_french.php';

require_once 'views/page_header.php';

?>

<style type="text/css">
	.mv-table, .mv-legend {
		border-collapse: collapse;
	}

	.mv-table td, .mv-legend td {
		color: white;
		font-weight: bold;
	}

	.mv-legend {
		width: 985px;
	}

	.mv-table td {
		width: 2px;
		height: 30px;
		text-align: center;
	}

	.mv-legend tr {
		height: 20px;
	}

	.mv-color {
		width: 50px;
	}

	.mv-legend-cell {
		padding-left: 10px;
	}

	.mv-table-cell {
		padding-right: 15px;
	}

	.mv-space {
		padding: 0px;
		width: 1px;
	}

	.mv-jour-1 { background-color: #00FF00; padding: 0px; }
	.mv-jour-2 { background-color: #00DA00; padding: 0px; }
	.mv-jour-3 { background-color: #00B600; padding: 0px; }
	.mv-jour-4 { background-color: #009100; padding: 0px; }
	.mv-jour-5 { background-color: #006D00; padding: 0px; }
	.mv-jour-6 { background-color: #004800; padding: 0px; }
	.mv-jour-7 { background-color: #002400; padding: 0px; }
	.mv-jour-u { background-color: #FF0000; padding: 0px; }
</style>

<?php

$query = 'SELECT active FROM '. TABLE_MOD .' WHERE action = \'majvisu\' AND active = \'1\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) {
	exit('Mod non activé!');
}

// variable de temps
for ($i = 1; $i < 8; $i++) {
	$t[] = time() - $i * 24 * 3600;
}

// initialisation du tableau univers
for ($i = 1; $i < 10; $i++) {
	for ($j = 1; $j < 500; $j++) {
		$universe[$i][$j] = 'u';
	}
}

// appel des dates de mise a jour dans universe
$result = $db->sql_query('SELECT last_update, galaxy, system
                            FROM '. TABLE_UNIVERSE .'
                           WHERE row = 1
                        ORDER BY galaxy, system');

while (list($last_update, $galaxy, $system) = $db->sql_fetch_row($result))
{
	     if ($last_update > $t[0]) { $universe[$galaxy][$system] = 1; }
	else if ($last_update > $t[1]) { $universe[$galaxy][$system] = 2; }
	else if ($last_update > $t[2]) { $universe[$galaxy][$system] = 3; }
	else if ($last_update > $t[3]) { $universe[$galaxy][$system] = 4; }
	else if ($last_update > $t[4]) { $universe[$galaxy][$system] = 5; }
	else if ($last_update > $t[5]) { $universe[$galaxy][$system] = 6; }
	else if ($last_update > $t[6]) { $universe[$galaxy][$system] = 7; }
}

?>

<table class="mv-table">
	<tr>
		<td></td>
		<td colspan="51">0 - 50</td>
		<td colspan="51">50 - 100</td>
		<td colspan="51">100 - 150</td>
		<td colspan="51">150 - 200</td>
		<td colspan="51">200 - 250</td>
		<td colspan="51">250 - 300</td>
		<td colspan="51">300 - 350</td>
		<td colspan="51">350 - 400</td>
		<td colspan="51">400 - 450</td>
		<td colspan="51">450 - 499</td>
	</tr>

<?php

for ($g = 1; $g < 10; $g++) {
	
	echo '<tr>';
	echo '<td class="mv-table-cell">G'. $g .'</td>';
	
	for ($s = 1; $s < 500; $s++) {
		echo '<td class="mv-jour-'. $universe[$g][$s] .'"></td>';
		
		if ($s % 50 == 0) {
			echo '<td class="mv-space"></td>';
		}
	}
	
	echo '</tr>';

}

?>

</table>

<br />
<br />

<table class="mv-legend">
	
	<?php
	
	for ($i = 1; $i < 9; $i++) {
		
		echo '<tr>';
		echo '<td class="mv-color mv-jour-'. ($i == 8 ? 'u' : $i) .'"></td>';
		echo '<td class="mv-legend-cell">'. ($i == 8 ? 'jamais scanné' : 'moins de '. $i .' jour'. ($i == 1 ? '' : 's')) .'</td>';
		echo '</tr>';
		
	}
	
	?>

</table>

<p>
	<br />
	Module de visualisation des mises à jour de l'univers par <b>Machine</b> tiré du portail OGPT<br />
	Version 1.2.1
</p>

<?php require_once 'views/page_tail.php'; ?>

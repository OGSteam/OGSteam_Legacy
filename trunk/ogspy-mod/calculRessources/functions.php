<?php
if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'accès direct

function Besoin($base,$niv,$coef) {
	if ($coef == 1) return ceil($base*$niv); //defenses ou flottes
	else if ($niv <= 1) return $base;
	else if ($niv == 2) return ceil($base*$coef);
	else {
		$T = 1.0;
		$i = 0;
		for ($i=1; $i<=$niv-1; $i++)
			$T = $T*$coef;
		return ceil($T*$base);}
}
?>
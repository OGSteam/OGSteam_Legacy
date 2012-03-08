<?php

if (!defined('IN_SPYOGAME'))
{
	exit('Hacking attempt');
}

if (!install_mod('densite'))
{
	echo '<script>alert(\'Une erreur est survenue pendant l\'installation du module "Densité".\')</script>';
}

?>

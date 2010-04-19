<?php
/***********************************************************************

  Copyright (C) 2002-2005  Neal Poole (smartys@gmail.com)

  This file is part of PunBB.

  PunBB is free software; you can redistribute it and/or modify it
  under the terms of the GNU General Public License as published
  by the Free Software Foundation; either version 2 of the License,
  or (at your option) any later version.

  PunBB is distributed in the hope that it will be useful, but
  WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston,
  MA  02111-1307  USA

************************************************************************/


// Make sure no one attempts to run this script "directly"
if (!defined('PUN'))
	exit;

// Tell admin_loader.php that this is indeed a plugin and that it is loaded
define('PUN_PLUGIN_LOADED', 1);

require PUN_ROOT.'include/cache.php';

// If the "Regenerate all cache" button was clicked
if (isset($_POST['regen_all_cache']))
{

	// We re-generate it all
	generate_config_cache();
	generate_bans_cache();
	generate_quickjump_cache();
	
	// Display the admin navigation menu
	generate_admin_menu($plugin);

?>
	<div class="block">
		<h2><span>Vider le cache</span></h2>
		<div class="box">
			<div class="inbox">
				<p>Le cache a été régénéré !</p>
				<p><a href="javascript: history.go(-1)">Retour</a></p>
			</div>
		</div>
	</div>
<?php

}

// If the "Regenerate ban cache" button was clicked
else if (isset($_POST['regen_ban_cache']))
{
	// We re-generate it
	generate_bans_cache();
	
	// Display the admin navigation menu
	generate_admin_menu($plugin);

?>
	<div class="block">
		<h2><span>Vider le cache</span></h2>
		<div class="box">
			<div class="inbox">
				<p>Le cache de bannissements a été régénéré !</p>
				<p><a href="javascript: history.go(-1)">Retour</a></p>
			</div>
		</div>
	</div>
<?php

}

// If the "Regenerate ranks cache" button was clicked
else if (isset($_POST['regen_ranks_cache']))
{

	// We re-generate it
	generate_ranks_cache();
	
	// Display the admin navigation menu
	generate_admin_menu($plugin);

?>
	<div class="block">
		<h2><span>Vider le cache</span></h2>
		<div class="box">
			<div class="inbox">
				<p>Le cache des rangs a été régénéré !</p>
				<p><a href="javascript: history.go(-1)">Retour</a></p>
			</div>
		</div>
	</div>
<?php

}

// If the "Regenerate config cache" button was clicked
else if (isset($_POST['regen_config_cache']))
{
	// We re-generate it
	generate_config_cache();
	
	// Display the admin navigation menu
	generate_admin_menu($plugin);

?>
	<div class="block">
		<h2><span>Vider le cache</span></h2>
		<div class="box">
			<div class="inbox">
				<p>Le cache de configuration a été régénéré !</p>
				<p><a href="javascript: history.go(-1)">Retour</a></p>
			</div>
		</div>
	</div>
<?php

}

// If the "Regenerate quickjump cache" button was clicked
else if (isset($_POST['regen_jump_cache']))
{
	// We re-generate it
	generate_quickjump_cache();
	
	// Display the admin navigation menu
	generate_admin_menu($plugin);

?>
	<div class="block">
		<h2><span>Vider le cache</span></h2>
		<div class="box">
			<div class="inbox">
				<p>Le cache de de saut rapide a été régénéré !</p>
				<p><a href="javascript: history.go(-1)">Retour</a></p>
			</div>
		</div>
	</div>
<?php

}
else	// If not, we show the form
{
	// Display the admin navigation menu
	generate_admin_menu($plugin);

?>
	<div id="exampleplugin" class="blockform">
		<h2><span>Régénérer le cache</span></h2>
		<div class="box">
			<div class="inbox">
				<p>Ce plugin vous permet de régénèrer facilement et simplement vos fichiers de cache de PunBB</p>
				
				<form id="regenerate" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>&amp;foo=bar">
					<p><input type="submit" name="regen_all_cache" value="Régénérer tous les fichiers cache" tabindex="2" /></p>
					<p><input type="submit" name="regen_ban_cache" value="Régénérer le cache de bannissements" tabindex="3" /></p>
					<p><input type="submit" name="regen_ranks_cache" value="Régénérer le cache des rangs" tabindex="4" /></p>
					<p><input type="submit" name="regen_config_cache" value="Régénérer le cache de configuration" tabindex="5" /></p>
					<p><input type="submit" name="regen_jump_cache" value="Régénérer le cache de saut rapide" tabindex="6" /></p>
				</form>
				
			</div>
		</div>
</div>
<?php

}

// Note that the script just ends here. The footer will be included by admin_loader.php.

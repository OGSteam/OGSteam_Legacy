<?php
/***********************************************************************/

// Some info about your mod.
$mod_title = 'OGPT';
$mod_version = '2.1';
$release_date = '2009-01-15';
$author = 'machine';
$author_email = '';


// One or more versions of PunBB that this mod works on. The version names must match exactly!
$punbb_versions = array('1.2.17', '1.2.18', '1.2.19', '1.2.20', '1.2.21');

// Set this to false if you haven't implemented the restore function (see below)
$mod_restore = false;


// This following function will be called when the user presses the "Install" button.
function install()
{
    global $db, $db_type, $pun_config;

    /// creation de la table mod fofo ogs

    $db->query("CREATE TABLE mod_fofo_ogs (

		`id` int(11) NOT NULL auto_increment,
 		 `title` varchar(255) NOT NULL,
  		`description` varchar(254) default NULL,
  		`tutos` text,
  		 `actif` INT( 1 ) NOT NULL DEFAULT '1',
  		`lien` varchar(255) NOT NULL,
  		`ordre` int(11) default '1',
  		`version` varchar(5) NOT NULL,
		`developpeur` varchar(30) NOT NULL,
		PRIMARY KEY  (`id`)
			) ENGINE=MyISAM ") or error('Unable to add Table "mod_fofo_ogs" ', __file__,
        __line__, $db->error());


    /// les données a l'interieur de ce mod :


    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
("1", "Galaxie", "visionnez la galaxie via notre forum", "a suivre", "1", "galaxie.php", "2", "0.1", "Machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());
    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
(2, "Profil_ogs", "definissez vos acces et vos parametre ogspy forum", "Pour profitez au maximum des modules du portail ogpt, remplissez les cases demandées ( pm, mod de pass, pseudo ...)\r\n\r\n\r\nenjoy", "1", "profil_ogs.php", "1", "0.1", "Machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());
    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
(3, "Exchange", "lisez vos messages ingame sur le forum via le mod exchange d ogspy", "a suivre", "1", "exchange.php?type=joueur", 3, "0.1", "Machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());
    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
(4, "Aide", "mod regroupant tous les autres", "a suivre", "1", "aide.php", 10, "0.1", "Machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());
    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
(5, "admin Ogs", "module d administration", "pour les admins", "1", "admin_ogs.php", 1, "0.1", "Machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());
    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES
(6, "recherche alliance", "recherche des alliances", "a suivre", "1", "rech_ally.php", 1, "0.1", "Machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());

    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
(7, "recherche joueurs", "rechercher des joueurs dans la base", "a suivre", "1", "rech_joueur.php", 1, "0.1", "Machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());
    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
(8, "empire", "visionner votre empire", "a suivre", "1", "empire.php", 1, "0.1", "Machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());
    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
(9, "production", "combien produisez vous", "a suivre", "1", "prod.php", 2, "0.1", "Machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());
    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
(10, "records", "galerie des records de l alliance", "a suivre", "1", "records.php", 1, "0.1", "Machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());
    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
(11, "stat", "stat de l alliance", "a suivre", "1", "ally.php", 1, "0.1", "coeur noir/machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());
    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
(13, "pandore", "les forces de vos ennemis en fiche", "a suivre", "1", "pandore.php", 8, "0.1", "Machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());
    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
(14, "conv", "convertir et envoyer directement vos rc et re sur fofo", "a suivre", "1", "conv.php", 8, "0.1", "Machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());
    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
(15, "cdr", "cherchez les champs de ruine", "a suivre", "1", "cdr.php", 8, "0.1", "Machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());
    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
(16, "star", "les connections des joueurs", "a suivre", "1", "star.php", 8, "0.1", "Machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());
    $db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
(17, "recherche_spy", "module de recherche", "a suivre", "1", "respy.php", 8, "0.1", "Machine")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());

    //// envoi des donnee config

    $db->query('INSERT INTO ' . $db->prefix . 'config VALUES ("sys", "499")') or
        error('Unable to add "pun_ogpt config" in config table', __file__, __line__, $db->
        error());
    $db->query('INSERT INTO ' . $db->prefix . 'config VALUES ("gal", "9")') or error('Unable to add "pun_ogpt config" in config table',
        __file__, __line__, $db->error());
    $db->query('INSERT INTO ' . $db->prefix . 'config VALUES ("OGPT", "2.1")') or
        error('Unable to add "pun_ogpt config" in config table', __file__, __line__, $db->
        error());
    $db->query('INSERT INTO ' . $db->prefix .
        'config VALUES ("ogspy_prefix", "ogspy_")') or error('Unable to add "pun_ogpt config" in config table',
        __file__, __line__, $db->error());


    /// ajout config user
    $result = $db->query('ALTER TABLE ' . $db->prefix .
        'users ADD COLUMN id_ogspy INT(11) UNSIGNED DEFAULT 0') or error('Unable to add column into table ' .
        $db->prefix . 'users.', __file__, __line__, $db->error());
    $result = $db->query('ALTER TABLE ' . $db->prefix .
        'users ADD COLUMN pm_g INT(11) UNSIGNED DEFAULT 0') or error('Unable to add column into table ' .
        $db->prefix . 'users.', __file__, __line__, $db->error());
    $result = $db->query('ALTER TABLE ' . $db->prefix .
        'users ADD COLUMN pm_s INT(11) UNSIGNED DEFAULT 0') or error('Unable to add column into table ' .
        $db->prefix . 'users.', __file__, __line__, $db->error());


    /// insertion mod fofo record :


    $db->query("CREATE TABLE mod_fofo_records (
			  `nom_record` varchar(20) NOT NULL,
  				`id_user` int(11) NOT NULL ,

		PRIMARY KEY  (`nom_record`)
			) ENGINE=MyISAM ") or error('Unable to add Table "mod_fofo_records" ',
        __file__, __line__, $db->error());


    /// table mod pandore


    $db->query("CREATE TABLE mod_pandore (
		 `id` int(10) NOT NULL auto_increment,
		  `sender` varchar(30) NOT NULL default '-1',
		  `id_sender` int(10) NOT NULL default '-1',
		  `nom` varchar(30) NOT NULL default '-1',
		  `total_point` int(30) NOT NULL default '-1',
		  `date` int(10) NOT NULL default '-1',
		  `points_bat` varchar(30) NOT NULL default '-1',
		  `points_def` varchar(30) NOT NULL default '-1',
		  `points_rech` varchar(30) NOT NULL default '-1',
		  `points_flotte` varchar(30) NOT NULL default '-1',
		  `points_manquant` varchar(30) NOT NULL default '-1',
		  `nb_vaisseaux` int(30) NOT NULL default '-1',
		  `nb_vaisseaux_manquant` int(30) NOT NULL default '-1',
		  `max_edlm` int(30) NOT NULL default '-1',
		  `edlm` int(30) NOT NULL default '-1',
		  `max_dest` int(30) NOT NULL default '-1',
		  `dest` int(30) NOT NULL default '-1',
		  `max_sat` int(30) NOT NULL default '-1',
		  `sat` int(30) NOT NULL default '-1',
		  `max_bb` int(30) NOT NULL default '-1',
		  `bb` int(30) NOT NULL default '-1',
		  `max_se` int(30) NOT NULL default '-1',
		  `se` int(30) NOT NULL default '-1',
		  `max_rc` int(30) NOT NULL default '-1',
		  `rc` int(30) NOT NULL default '-1',
		  `max_vc` int(30) NOT NULL default '-1',
		  `vc` int(30) NOT NULL default '-1',
		  `max_vb` int(30) NOT NULL default '-1',
		  `vb` int(30) NOT NULL default '-1',
		  `max_cr` int(30) NOT NULL default '-1',
		  `cr` int(30) NOT NULL default '-1',
		  `max_clo` int(30) NOT NULL default '-1',
		  `clo` int(30) NOT NULL default '-1',
		  `max_cl` int(30) NOT NULL default '-1',
		  `cl` int(30) NOT NULL default '-1',
		  `max_gt` int(30) NOT NULL default '-1',
		  `gt` int(30) NOT NULL default '-1',
		  `max_pt` int(30) NOT NULL default '-1',
		  `pt` int(30) NOT NULL default '-1',
		  `max_tr` int(30) NOT NULL default '-1',
		  `tr` int(30) NOT NULL default '-1',
		PRIMARY KEY  (`id`)	
	
			) ENGINE=MyISAM ") or error('Unable to add Table "mod_pandore" ', __file__,
        __line__, $db->error());


}

/// a voir pour fonction restor ulterieurement
function restore()
{
    global $db, $db_type, $pun_config;
}

/***********************************************************************/

// DO NOT EDIT ANYTHING BELOW THIS LINE!


// Circumvent maintenance mode
define('PUN_TURN_OFF_MAINT', 1);
define('PUN_ROOT', './');
require PUN_ROOT . 'include/common.php';

// We want the complete error message if the script fails
if (!defined('PUN_DEBUG'))
    define('PUN_DEBUG', 1);

// Make sure we are running a PunBB version that this mod works with
if (!in_array($pun_config['o_cur_version'], $punbb_versions))
    exit('You are running a version of PunBB (' . $pun_config['o_cur_version'] .
        ') that this mod does not support. This mod supports PunBB versions: ' . implode
        (', ', $punbb_versions));

$style = (isset($cur_user)) ? $cur_user['style'] : $pun_config['o_default_style'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $mod_title ?> installation</title>
<link rel="stylesheet" type="text/css" href="style/<?php echo $pun_config['o_default_style'] .
'.css' ?>" />
</head>
<body>

<div id="punwrap">
<div id="puninstall" class="pun" style="margin: 10% 20% auto 20%">

<?php

if (isset($_POST['form_sent'])) {
    if (isset($_POST['install'])) {
        // Run the install function (defined above)
        install();

?>
<div class="block">
	<h2><span>Installation successful</span></h2>
	<div class="box">
		<div class="inbox">
			<p>la base de donnée a ete corresctement préparé pour  <?php echo
        pun_htmlspecialchars($mod_title) ?>. rendez vous sur le forum de l ogsteam pour plus d information</p>
		</div>
	</div>
</div>
<?php

    } else {
        // Run the restore function (defined above)
        restore();

?>
<div class="block">
	<h2><span>Restore successful</span></h2>
	<div class="box">
		<div class="inbox">
			<p>votre base de donnée a ete correctement restauré.</p>
		</div>
	</div>
</div>
<?php

    }
} else {

?>
<div class="blockform">
	<h2><span>Mod installation</span></h2>
	<div class="box">
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?foo=bar">
			<div><input type="hidden" name="form_sent" value="1" /></div>
			<div class="inform">
				<p>le script va mettre a jour votre base de donnée avec :</p>
				<p><strong>Mod title:</strong> <?php echo pun_htmlspecialchars($mod_title) .
    ' ' . $mod_version ?></p>
				<p><strong>Author:</strong> <?php echo pun_htmlspecialchars($author) ?> (<a href="mailto:<?php echo
        pun_htmlspecialchars($author_email) ?>"><?php echo pun_htmlspecialchars($author_email) ?></a>)</p>
				<p><strong>attention:</strong> Ce n'est pas une modification officielle de punbb . faites une sauvegarde de la base de donnée avant de prodeder a son installation</p>
<?php if ($mod_restore): ?>				<p>si vous avez procedez a l installation du mod ogpt et que vous n'en vouliez plus, vous pouvez cliquer sur desinstallation pour ce faire.</p>
<?php endif; ?>			</div>
			<p><input type="submit" name="install" value="Install" /><?php if ($mod_restore): ?><input type="submit" name="restore" value="Restore" /><?php endif; ?></p>
		</form>
	</div>
</div>
<?php

}

?>

</div>
</div>

</body>
</html>
<?php
/***********************************************************************
MACHINE

************************************************************************/


define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';
/// parser pour le texte des tutos...
require PUN_ROOT.'include/parser.php';
// Load the index.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/index.php';

define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';

///ogpt
$lien="admin_ogs.php";
$page_title = "administration ogpt";

/// si utilisateur n'est pas admin redirection
if ($pun_user['g_id'] > PUN_MOD)
	message($lang_common['No permission']);


/// variable globale ogpt
$request = "select * from ogpt";
$result = $db->query($request);
while (list($name, $value) = $db->fetch_row($result)) {
    $ogpt[$name] = stripslashes($value);
}


/// fin ogpt

if (isset($_POST['couleur']))
{


///securisation 
$i=pun_trim($_POST['i']);
$db->query('UPDATE ogpt SET conf_value=\''.$i.'\' WHERE conf_name= \'i\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$iI=pun_trim($_POST['iI']);
$db->query('UPDATE ogpt SET conf_value=\''.$iI.'\' WHERE conf_name= \'iI\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$v=pun_trim($_POST['v']);
$db->query('UPDATE ogpt SET conf_value=\''.$v.'\' WHERE conf_name= \'v\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$d=pun_trim($_POST['d']);
$db->query('UPDATE ogpt SET conf_value=\''.$d.'\' WHERE conf_name= \'d\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$b=pun_trim($_POST['b']);
$db->query('UPDATE ogpt SET conf_value=\''.$b.'\' WHERE conf_name= \'b\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$iv=pun_trim($_POST['iv']);
$db->query('UPDATE ogpt SET conf_value=\''.$iv.'\' WHERE conf_name= \'iv\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$iIv=pun_trim($_POST['iIv']);
$db->query('UPDATE ogpt SET conf_value=\''.$iIv.'\' WHERE conf_name= \'iIv\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$bv=pun_trim($_POST['bv']);
$db->query('UPDATE ogpt SET conf_value=\''.$bv.'\' WHERE conf_name= \'bv\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$bvi=pun_trim($_POST['bvi']);
$db->query('UPDATE ogpt SET conf_value=\''.$bvi.'\' WHERE conf_name= \'bvi\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$bvIi=pun_trim($_POST['bvIi']);
$db->query('UPDATE ogpt SET conf_value=\''.$bvIi.'\' WHERE conf_name= \'bvIi\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$f=pun_trim($_POST['f']);
$db->query('UPDATE ogpt SET conf_value=\''.$f.'\' WHERE conf_name= \'f\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());
/// fin secu


/// fin secu

/// regeeration du cache avant redirection :

	require_once PUN_ROOT.'include/cache.php';
	generate_config_cache();


///redirection pour prise en compte dans la page
$redirection="Modifications prises en compte"; redirect('admin_ogs.php', $redirection);



}





if (isset($_POST['admin_ogs']))
{


///securisation de nom et mdp
$galaxie=pun_trim($_POST['galaxie']);
$systeme=pun_trim($_POST['systeme']);
$prefix=pun_trim($_POST['prefixe']);


// verif numerique

if (!is_numeric($systeme)){$redirection="Nous ne nous comprennons plus 2"; redirect('index.php', $redirection);}
if (!is_numeric($galaxie)){$redirection="Nous ne nous comprennons plus 1"; redirect('index.php', $redirection);}



/// mise a jour du nb de galaxie et systeme
	$db->query('UPDATE '.$db->prefix.'config SET conf_value='.$galaxie.' WHERE conf_name= \'gal\'') or error('Unable to update board config', __FILE__, __LINE__, $db->error());

$db->query('UPDATE '.$db->prefix.'config SET conf_value='.$systeme.' WHERE conf_name=\'sys\'') or error('Unable to update board config', __FILE__, __LINE__, $db->error());

$db->query('UPDATE '.$db->prefix.'config SET conf_value=\''.$prefix.'\' WHERE conf_name=\'ogspy_prefix\'') or error('Unable to update board config', __FILE__, __LINE__, $db->error());

/// regeeration du cache avant redirection :

	require_once PUN_ROOT.'include/cache.php';
	generate_config_cache();


///redirection pour prise en compte dans la page
$redirection="Modifications prises en compte"; redirect('admin_ogs.php', $redirection);


}

/// mise a jour de l'ordre des modules

if (isset($_POST['mod_ogs']))
{
  ///premier filtre :
  $lien=pun_trim($_POST['lien']);
  $nom=pun_trim($_POST['nom']);
  $ordre=pun_trim($_POST['ordre']);
  $actif=pun_trim($_POST['actif']);
  //verif des valeurs numeriques
if (!is_numeric($ordre)){$redirection="Nous ne nous comprennons plus 4"; redirect('index.php', $redirection);}
if (!is_numeric($actif)){$redirection="Nous ne nous comprennons plus 5"; redirect('index.php', $redirection);}

  /// verif valeur null
  if ( $nom =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}
  if ( $lien =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}
  if ( $actif =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}
  if ( $ordre =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}

 //nom
 $sql = 'UPDATE mod_fofo_ogs SET title = \''.$nom.'\'  WHERE lien = \''.$lien.'\' ';
 $query = $db->query($sql) or error("Impossible to update nom", __FILE__, __LINE__, $db->error());
 //ordre
 $sql = 'UPDATE mod_fofo_ogs SET ordre = \''.$ordre.'\'  WHERE lien = \''.$lien.'\' ';
 $query = $db->query($sql) or error("Impossible to update nom", __FILE__, __LINE__, $db->error());

 //actif
 $sql = 'UPDATE mod_fofo_ogs SET actif = \''.$actif.'\'  WHERE lien = \''.$lien.'\' ';
 $query = $db->query($sql) or error("Impossible to update nom", __FILE__, __LINE__, $db->error());


/// regeeration du cache avant redirection :

	require_once PUN_ROOT.'include/cache.php';
	generate_config_cache();


///redirection pour prise en compte dans la page
$redirection="Modifications prises en compte"; redirect('admin_ogs.php', $redirection);



}


if (isset($_POST['pan_ogs']))
{
  ///premier filtre :
  $lien=pun_trim($_POST['lien']);
  $ordre=pun_trim($_POST['ordre']);
  $actif=pun_trim($_POST['actif']);
    $secu=pun_trim($_POST['secu']);
  //verif des valeurs numeriques
if (!is_numeric($ordre)){$redirection="Nous ne nous comprennons plus 4"; redirect('index.php', $redirection);}
if (!is_numeric($actif)){$redirection="Nous ne nous comprennons plus 5"; redirect('index.php', $redirection);}
if (!is_numeric($secu)){$redirection="Nous ne nous comprennons plus 8"; redirect('index.php', $redirection);}

  /// verif valeur null
  if ( $secu =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}
  if ( $lien =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}
  if ( $actif =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}
  if ( $ordre =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}

 //secu
 $sql = 'UPDATE colonne SET secu = \''.$secu.'\'  WHERE lien = \''.$lien.'\' ';
 $query = $db->query($sql) or error("Impossible to update secu", __FILE__, __LINE__, $db->error());
 //ordre
 $sql = 'UPDATE colonne SET ordre = \''.$ordre.'\'  WHERE lien = \''.$lien.'\' ';
 $query = $db->query($sql) or error("Impossible to update ordre", __FILE__, __LINE__, $db->error());

 //actif
 $sql = 'UPDATE colonne SET actif = \''.$actif.'\'  WHERE lien = \''.$lien.'\' ';
 $query = $db->query($sql) or error("Impossible to update actif", __FILE__, __LINE__, $db->error());


/// regeeration du cache avant redirection :

	require_once PUN_ROOT.'include/cache.php';
	generate_config_cache();


///redirection pour prise en compte dans la page
$redirection="Modifications prises en compte"; redirect('admin_ogs.php', $redirection);



}



/// maj 2.1 et 2.11



if ($pun_config['OGPT']=="2.1")

{
echo '<div class="blockform"><h2><span>Mise a jour</span></h2><div class="box"><br>

Mettre a niveau votre version de du portail <a href="admin_ogs.php?maj=on">OGPT</a><br><br>




</div></div>';


if (isset($_GET['maj']))

 {
 	
 	/// creation tableogpt
$db->query("CREATE TABLE ogpt (

			`conf_name` varchar(255) NOT NULL default '',
  `conf_value` text,
  PRIMARY KEY  (`conf_name`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1 ") or error('Unable to add Table "ogpt" ', __file__,
        __line__, $db->error());


//// creation table favorie

$db->query("CREATE TABLE favorie (

		`galaxy` enum('1','2','3','4','5','6','7','8','9') collate latin1_general_ci NOT NULL default '1',
  `system` smallint(3) NOT NULL default '0',
  `row` enum('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15') collate latin1_general_ci NOT NULL default '1',
  `player` varchar(20) collate latin1_general_ci default NULL,
   `sender` int(11) NOT NULL default '0',
  UNIQUE KEY `univers` (`galaxy`,`system`,`row`),
  KEY `player` (`player`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ") or error('Unable to add Table "favoorie" ', __file__,
        __line__, $db->error());



/// envoi des couleurs pour les statuts galaxie


    $db->query('INSERT INTO ogpt (`conf_name`, `conf_value`) VALUES ("i", "#FFFFFF")') or error('Unable to add mod couleur a ogpt ', __file__, __line__, $db->error());
 $db->query('INSERT INTO ogpt (`conf_name`, `conf_value`) VALUES ("iI", "#FFFFFF")') or error('Unable to add mod couleur a ogpt ', __file__, __line__, $db->error());
 $db->query('INSERT INTO ogpt (`conf_name`, `conf_value`) VALUES ("d", "#FFFFFF")') or error('Unable to add mod couleur a ogpt ', __file__, __line__, $db->error());
 $db->query('INSERT INTO ogpt (`conf_name`, `conf_value`) VALUES ("v", "#FFFFFF")') or error('Unable to add mod couleur a ogpt ', __file__, __line__, $db->error());
 $db->query('INSERT INTO ogpt (`conf_name`, `conf_value`) VALUES ("iv", "#FFFFFF")') or error('Unable to add mod couleur a ogpt ', __file__, __line__, $db->error());
 $db->query('INSERT INTO ogpt (`conf_name`, `conf_value`) VALUES ("iIv", "#FFFFFF")') or error('Unable to add mod couleur a ogpt ', __file__, __line__, $db->error());
 $db->query('INSERT INTO ogpt (`conf_name`, `conf_value`) VALUES ("b", "#FFFFFF")') or error('Unable to add mod couleur a ogpt ', __file__, __line__, $db->error());
 $db->query('INSERT INTO ogpt (`conf_name`, `conf_value`) VALUES ("bv", "#FFFFFF")') or error('Unable to add mod couleur a ogpt ', __file__, __line__, $db->error());
 $db->query('INSERT INTO ogpt (`conf_name`, `conf_value`) VALUES ("bvi", "#FFFFFF")') or error('Unable to add mod couleur a ogpt ', __file__, __line__, $db->error());
 $db->query('INSERT INTO ogpt (`conf_name`, `conf_value`) VALUES ("bvIi", "#FFFFFF")') or error('Unable to add mod couleur a ogpt ', __file__, __line__, $db->error());
$db->query('INSERT INTO ogpt (`conf_name`, `conf_value`) VALUES ("f", "#FFFFFF")') or error('Unable to add mod couleur a ogpt ', __file__, __line__, $db->error());
	
/// patch 2.1 => 2.11
$db->query('DELETE FROM mod_fofo_ogs WHERE lien="stat.php"') or error('Unable to delete stats.php from config table', 
	 	    __file__, __line__, $db->error()); 
	 	///effacement muavaise line a corriger dans v2.2 
	 	$db->query('DELETE FROM mod_fofo_ogs WHERE lien="ally.php"') or error('Unable to delete stats.php from config table', 
	 	    __file__, __line__, $db->error()); 
	
///remplacement de la ligne 
	 	$db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES  
	 	("", "stat", "stat de l alliance", "a suivre", "1", "ally.php", 1, "0.1", "coeur noir/machine")') or 
	 	    error('Unable to add patch mod fofoo ogs', __file__, __line__, $db->error()); 
	 	 
	 	// fin patch 2.1 
		 
		 
		 
		 // changement de version 2.1 ou 2.11 vers 2.19	
	$db->query('DELETE FROM ' . $db->prefix . 'config WHERE conf_name="OGPT"') or error('Unable to delete stats.php from config table', 
	 	    __file__, __line__, $db->error()); 
	 	    
	 	    /// en route pour la 2.19
	 	    
	 	    $db->query('INSERT INTO ' . $db->prefix . 'config VALUES ("OGPT", "2.19")') or
        error('Unable to add "pun_ogpt config" in config table', __file__, __line__, $db->
        error());
        
        
        /// regeeration du cache avant redirection :

	require_once PUN_ROOT.'include/cache.php';
	generate_config_cache();

echo("<script> alert('ogpt 2.19') </script>");

///redirection pour prise en compte dans la page
$redirection="Mise a jour  OK"; redirect('admin_ogs.php', $redirection);
	
	
	}





}



if ($pun_config['OGPT']=="2.19")

{
echo '<div class="blockform"><h2><span>Mise a jour</span></h2><div class="box"><br>

Mettre a niveau votre version de du portail <a href="admin_ogs.php?maj=on">OGPT</a><br><br>




</div></div>';


if (isset($_GET['maj']))

 {
 	
 	/// suppression des lignes dans le menu correspondant aux modes non fonctionnelle encore si dans bdd
 	// mod conv
	 $db->query('DELETE FROM mod_fofo_ogs WHERE lien="conv.php"'); 
	 	// mod cdr
	 $db->query('DELETE FROM mod_fofo_ogs WHERE lien="cdr.php"'); 
	 	// mod star
	 $db->query('DELETE FROM mod_fofo_ogs WHERE lien="star.php"'); 
	 	// mod respy.php
	 $db->query('DELETE FROM mod_fofo_ogs WHERE lien="respy.php"'); 
	/// fin de la suppression des mods
	
	// ajout nouveau mod cdr
	/// menu
	$db->query('INSERT INTO mod_fofo_ogs (`id`, `title`, `description`, `tutos`, `actif`, `lien`, `ordre`, `version`, `developpeur`) VALUES 
(15, "cdr", "cherchez les champs de ruine", "a suivre", "1", "cdr.php", 8, "0.2", "Machine/Capi/punkcore")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());
      /// table user :
	    
        	$result = $db->query('ALTER TABLE ' . $db->prefix .
        'users  ADD small INT(11) NOT NULL DEFAULT 10000') or error('Unable to add column into table ' . 
		$db->prefix . 'users.', __file__, __line__, $db->error());
	$result = $db->query('ALTER TABLE ' . $db->prefix .
		'users  ADD small_color VARCHAR(6) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT "FFFF00"') or error('Unable to add column into table ' .
		$db->prefix . 'users.', __file__, __line__, $db->error());
	$result = $db->query('ALTER TABLE ' . $db->prefix .
		'users  ADD medium INT(11) NOT NULL DEFAULT 20000') or error('Unable to add column into table ' .
		$db->prefix . 'users.', __file__, __line__, $db->error());
	$result = $db->query('ALTER TABLE ' . $db->prefix .
		'users  ADD medium_color VARCHAR(6) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT "FFA500"') or error('Unable to add column into table ' .
		$db->prefix . 'users.', __file__, __line__, $db->error());
	$result = $db->query('ALTER TABLE ' . $db->prefix .
		'users ADD big INT(11) NOT NULL DEFAULT 30000') or error('Unable to add column into table ' .
		$db->prefix . 'users.', __file__, __line__, $db->error());
	$result = $db->query('ALTER TABLE ' . $db->prefix .
		'users ADD big_color VARCHAR(6) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT "FF0000"') or error('Unable to add column into table ' .
		$db->prefix . 'users.', __file__, __line__, $db->error());


  /// fin ajout mod cdr
 	
 /// mise a jour du portail 
  // changement de version 2.19 vers 2.20	
			$db->query('DELETE FROM ' . $db->prefix . 'config WHERE conf_name="OGPT"') or error('Unable to delete stats.php from config table', 
	 	    __file__, __line__, $db->error()); 
	 	    
	 	    /// en route pour la 2.19
	 	    
	 	    $db->query('INSERT INTO ' . $db->prefix . 'config VALUES ("OGPT", "2.20")') or
        error('Unable to add "pun_ogpt config" in config table', __file__, __line__, $db->
        error());
     /// regenere le cache   
 

	require_once PUN_ROOT.'include/cache.php';
	generate_config_cache();




echo("<script> alert('ogpt 2.20') </script>");
///redirection pour prise en compte dans la page
$redirection="Mise a jour  OK"; redirect('admin_ogs.php', $redirection);
	
	
	}

	



}
if ($pun_config['OGPT']=="2.2")

{
echo '<div class="blockform"><h2><span>Mise a jour</span></h2><div class="box"><br>

Mettre a niveau votre version de du portail <a href="admin_ogs.php?maj=on">OGPT</a><br><br>




</div></div>';


if (isset($_GET['maj']))

 {

 $result = $db->query(' ALTER TABLE ' . $db->prefix .
		'users CHANGE `small_color` `small_color` VARCHAR( 7 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT "#FFFF00"') or error('Unable to add column into table ' .
		$db->prefix . 'users.', __file__, __line__, $db->error());
	$result = $db->query(' ALTER TABLE ' . $db->prefix .
		'users CHANGE `medium_color` `medium_color` VARCHAR( 7 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT "#FFA500"') or error('Unable to add column into table ' .
		$db->prefix . 'users.', __file__, __line__, $db->error());
	$result = $db->query(' ALTER TABLE ' . $db->prefix .
		'users CHANGE `big_color` `big_color` VARCHAR( 7 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT "#FF0000"') or error('Unable to add column into table ' .
		$db->prefix . 'users.', __file__, __line__, $db->error());
	
	/// fin ajout mod cdr
	
	///Corection bug ajout favorie
	 $result = $db->query('ALTER TABLE favorie DROP INDEX `univers` ') 
			or error('Unable to drop index into table favorie', __file__, __line__, $db->error());
 	 $result = $db->query('ALTER TABLE favorie ADD UNIQUE `univers` ( `galaxy` , `system` , `row` , `sender` ) ') 
			or error('Unable to add unique index into table favorie', __file__, __line__, $db->error());
 
 
 /// mise a jour du portail 
  // changement de version 2.20 vers 2.21	
			$db->query('DELETE FROM ' . $db->prefix . 'config WHERE conf_name="OGPT"') or error('Unable to delete stats.php from config table', 
	 	    __file__, __line__, $db->error()); 
	 	    
	 	    /// en route pour la 2.21
	 	    
	 	    $db->query('INSERT INTO ' . $db->prefix . 'config VALUES ("OGPT", "2.21")') or
        error('Unable to add "pun_ogpt config" in config table', __file__, __line__, $db->
        error());
     /// regenere le cache   
 
	require_once PUN_ROOT.'include/cache.php';
	generate_config_cache();




echo("<script> alert('ogpt 2.21') </script>");
///redirection pour prise en compte dans la page
$redirection="Mise a jour  OK"; redirect('admin_ogs.php', $redirection);
	
	
	}





}




/// maj 2.21



if ($pun_config['OGPT']=="2.21")

{
echo '<div class="blockform"><h2><span>Mise a jour</span></h2><div class="box"><br>

Mettre a niveau votre version de du portail <a href="admin_ogs.php?maj=on">OGPT</a><br><br>




</div></div>';


if (isset($_GET['maj']))

 {
 $db->query('DROP TABLE favorie');	
 
 //// creation table favorie

$db->query("CREATE TABLE favorie (

		`galaxy` enum('1','2','3','4','5','6','7','8','9') collate latin1_general_ci NOT NULL default '1',
  `system` smallint(3) NOT NULL default '0',
  `row` enum('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15') collate latin1_general_ci NOT NULL default '1',
  `player` varchar(20) collate latin1_general_ci default NULL,
   `sender` int(11) NOT NULL default '0',
  KEY `player` (`player`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ") or error('Unable to add Table "favoorie" ', __file__,
        __line__, $db->error());


 /// creation de la table gerant les panneaux
   $db->query("CREATE TABLE colonne (

		`id` int(11) NOT NULL auto_increment,
 		 `title` varchar(255) NOT NULL,
  		 `actif` INT( 1 ) NOT NULL DEFAULT '1',
  		`lien` varchar(255) NOT NULL,
  		 `secu` INT( 1 ) NOT NULL DEFAULT '0',
  		`ordre` int(11) default '1',
		PRIMARY KEY  (`id`)
			) ENGINE=MyISAM ") or error('Unable to add Table "mod_fofo_ogs" ', __file__,
        __line__, $db->error());


    /// les données a l'interieur de ce mod :


    $db->query('INSERT INTO colonne (`id`, `title`, `actif`, `lien`, `secu`, `ordre`) VALUES 
("", "info cartographie", "1", "infocartographie.php", "0", "1")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());

	
  $db->query('INSERT INTO colonne (`id`, `title`, `actif`, `lien`, `secu`, `ordre`) VALUES 
("", "gameogame", "1", "gameogame.php", "0", "2")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());

  $db->query('INSERT INTO colonne (`id`, `title`, `actif`, `lien`, `secu`, `ordre`) VALUES 
("", "menu OGS", "1", "menuogs.php", "0", "3")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());

  $db->query('INSERT INTO colonne (`id`, `title`, `actif`, `lien`, `secu`, `ordre`) VALUES 
("", "Pandore", "1", "pandore.php", "0", "4")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());

  $db->query('INSERT INTO colonne (`id`, `title`, `actif`, `lien`, `secu`, `ordre`) VALUES 
("", "Qui nous sonde", "1", "quinousonde.php", "0", "5")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());

  $db->query('INSERT INTO colonne (`id`, `title`, `actif`, `lien`, `secu`, `ordre`) VALUES 
("", "Top espionnage", "1", "topespionnage.php", "0", "6")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());

 $db->query('INSERT INTO colonne (`id`, `title`, `actif`, `lien`, `secu`, `ordre`) VALUES 
("", "Top flop", "1", "topflop.php", "0", "7")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());

  $db->query('INSERT INTO colonne (`id`, `title`, `actif`, `lien`, `secu`, `ordre`) VALUES 
("", "Top mise a jour", "1", "topmisesajour.php", "0", "8")') or
        error('Unable to add mod fofoo ogs', __file__, __line__, $db->error());


	
	
	// mise a jour du portail 
  // changement de version 2.21 vers 2.22	
			$db->query('DELETE FROM ' . $db->prefix . 'config WHERE conf_name="OGPT"') or error('Unable to delete stats.php from config table', 
	 	    __file__, __line__, $db->error()); 
	 	    
	 	    /// en route pour la 2.19
	 	    
	 	    $db->query('INSERT INTO ' . $db->prefix . 'config VALUES ("OGPT", "2.22")') or
        error('Unable to add "pun_ogpt config" in config table', __file__, __line__, $db->
        error());
     /// regenere le cache   
 

	require_once PUN_ROOT.'include/cache.php';
	generate_config_cache();




echo("<script> alert('ogpt 2.22') </script>");
///redirection pour prise en compte dans la page
$redirection="Mise a jour  OK"; redirect('admin_ogs.php', $redirection);
	
	
	}





}
?>








<div class="blockform"><h2><span> Administration forum / ogspy</span></h2><div class="box">


 <fieldset>
						<legend>paramettrez votre cartographie : </legend>
 <?php
echo'<p align="center">la cartographie est actuellement configuree pour :<br>'.$pun_config['gal'].' Galaxies <br> '.$pun_config['sys'].' systemes <br>';




  ?>

						<div class="infldset">


<form id="admin_ogs" method="post" action="admin_ogs.php">
   <div class="inform">


						<input type="hidden" name="admin_ogs"  accesskey="s" />
						<label class="conl">Nombre de galaxie  <br /><input type="text"  name="galaxie" size="2" maxlength="2" value="<?php echo''.$pun_config['gal'].''; ?>" /><br /></label>
						<label class="conl">Nombre de systeme <br /><input type="text"  name="systeme" size="3" maxlength="3"  value="<?php echo''.$pun_config['sys'].''; ?>" "/> <br /></label>
						<label class="conl">prefixe de votre ogspy  <br /><input type="text"  name="prefixe" size="20" maxlength="20" value="<?php echo''.$pun_config['ogspy_prefix'].''; ?>" /><br /></label>

			</div>







			<p><input type="submit"   /></p>
		</form>
</div>
   </fieldset>















<br />



	</div>
</div>



<div class="blockform"><h2><span> Administration forum / modules</span></h2><div class="box">


 <fieldset>
 <legend>modules actifs : </legend>



<form id="mod_ogs" method="post" action="admin_ogs.php">
                                                <input type="hidden" name="mod_ogs"  accesskey="s" />
                                                <select name="lien" tabindex="3"><?php $sql = 'SELECT *  FROM mod_fofo_ogs   ORDER BY ordre asc ';
   $result = $db->query($sql);
        while($mod = $db->fetch_assoc($result))
   {  echo ' 	<option value="'.$mod['lien'].'">'.$mod['title'].'</option> '; }
   echo ' </select>

						nom :<input type="text"  name="nom" size="20" maxlength="20" value="" />
						actif :<select name="actif" tabindex="3">
                                                <option value="1">oui</option>
                                                <option value="0">non</option>
                                                        </select>
						ordre :<select name="ordre" tabindex="2">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                        </select>
                                                <input type="submit"   />
</form> ';



echo '<table border="0" cellpadding="2" cellspacing="0" align="center"';
echo '<tr><th><b>nom</b></th><th><b>ordre</b></th><th><b>actif</b></th><th><b>lien</b></th><th><b>dev.(version)</b></th>';

   /// ableau recapitulatif des mod/liens
$sql = 'SELECT *  FROM mod_fofo_ogs   ORDER BY ordre asc ';
   $result = $db->query($sql);
        while($mod = $db->fetch_assoc($result))
   {


     echo'<tr>';
     echo'<td><center></center>'.$mod['title'].'</td>';
     echo' <td><center>'.$mod['ordre'].'</center></td>';
     if ( $mod['actif'] == 1 ) { echo ' <td><center>actif</center></td>';} else { echo ' <td><center>non actif</center></td>';}
     echo'<td><center>'.$mod['lien'].'</center></td>';
     echo'<td><center>'.$mod['developpeur'].' ('.$mod['version'].')</center></td>';
     echo '</tr> ';

   }
       echo'</table> ';

?>
 </fieldset>
  <br>




	</div>
</div>



<div class="blockform"><h2><span> Administration Galaxie</span></h2><div class="box">
<script type="text/javascript" src="ogpt/js/CP_Class.js"></script>
<script type="text/javascript">
window.onload = function()
{
 fctLoad();
}
window.onscroll = function()
{
 fctShow();
}
window.onresize = function()
{
 fctShow();
}
</script>

 <fieldset>
						<legend>paramettrez les couleurs du mod galaxie en fonction du statut : </legend>

						<div class="infldset">


<form name="objForm" id="couleur" method="post" action="admin_ogs.php">
   <div class="inform">

<link rel="stylesheet" type="text/css" href="style/ColorPicker.css" />
		<input type="hidden" name="couleur"  accesskey="s" />
				<label class="conl">statut : <font color="<?php echo''.$ogpt['i'].''; ?>">i</font>  <br />
						<input type="text"  name="i" size="7" maxlength="7" value="<?php echo''.$ogpt['i'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.i);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['iI'].''; ?>">iI</font> <br /> 
						<input type="text"  name="iI" size="7" maxlength="7" value="<?php echo''.$ogpt['iI'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.iI);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['d'].''; ?>">d</font>  <br />
						<input type="text"  name="d" size="7" maxlength="7" value="<?php echo''.$ogpt['d'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.d);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['v'].''; ?>">v</font>  <br />
						<input type="text"  name="v" size="7" maxlength="7" value="<?php echo''.$ogpt['v'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.v);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['iv'].''; ?>">iv</font>  <br />
						<input type="text"  name="iv" size="7" maxlength="7" value="<?php echo''.$ogpt['iv'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.iv);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['iIv'].''; ?>">iIv</font>  <br />
						<input type="text"  name="iIv" size="7" maxlength="7" value="<?php echo''.$ogpt['iIv'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.iIv);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['b'].''; ?>">b</font>  <br />
						<input type="text"  name="b" size="7" maxlength="7" value="<?php echo''.$ogpt['b'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.b);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['bv'].''; ?>">bv</font>  <br />
						<input type="text"  name="bv" size="7" maxlength="7" value="<?php echo''.$ogpt['bv'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.bv);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['bvi'].''; ?>">bvi</font>  <br />
						<input type="text"  name="bvi" size="7" maxlength="7" value="<?php echo''.$ogpt['bvi'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.bvi);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['bvIi'].''; ?>">bvIi</font>  <br />
						<input type="text"  name="bvIi" size="7" maxlength="7" value="<?php echo''.$ogpt['bvIi'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.bvIi);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['f'].''; ?>">f</font>  <br />
							<input type="text"  name="f" size="7" maxlength="7" value="<?php echo''.$ogpt['f'].''; ?>" /><br />
							<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.f);" style="cursor:pointer;"><br />
							</label>
						
						
						

			</div>







			<p><input type="submit"   /></p>
		</form>
</div>
   </fieldset>















<br />



	</div>
</div>



<div class="blockform"><h2><span> Administration forum / panneaux</span></h2><div class="box">


 <fieldset>
 <legend>modules actifs : </legend>



<form id="pan_ogs" method="post" action="admin_ogs.php">
                                                <input type="hidden" name="pan_ogs"  accesskey="s" />
                                                <select name="lien" tabindex="3"><?php $sql = 'SELECT *  FROM colonne   ORDER BY ordre asc ';
   $result = $db->query($sql);
        while($mod = $db->fetch_assoc($result))
   {  echo ' 	<option value="'.$mod['lien'].'">'.$mod['title'].'</option> '; }
   echo ' </select>

						
						actif :<select name="actif" tabindex="3">
                                                <option value="1">oui</option>
                                                <option value="0">non</option>
                                                        </select>
                         	vue par :<select name="secu" tabindex="3">
                                                <option value="4">admin uniquement</option>
                                                <option value="3">acces ogspy</option>
												<option value="2">membres</option>
                                                <option value="0">autres</option>
                                                        </select>                               
						ordre :<select name="ordre" tabindex="2">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                        </select>
                                                <input type="submit"   />
</form> ';



echo '<table border="0" cellpadding="2" cellspacing="0" align="center"';
echo '<tr><th><b>nom</b></th><th><b>ordre</b></th><th><b>actif</b></th><th><b>lien</b></th><th><b>niveau de securite</b></th>';

   /// ableau recapitulatif des mod/liens
$sql = 'SELECT *  FROM colonne   ORDER BY ordre asc ';
   $result = $db->query($sql);
        while($mod = $db->fetch_assoc($result))
   {


     echo'<tr>';
     echo'<td><center></center>'.$mod['title'].'</td>';
     echo' <td><center>'.$mod['ordre'].'</center></td>';
     if ( $mod['actif'] == 1 ) { echo ' <td><center>actif</center></td>';} else { echo ' <td><center>non actif</center></td>';}
     echo'<td><center>'.$mod['lien'].'</center></td>';
   /// niveau de securite
	 if ( $mod['secu'] == 4 ) { echo ' <td><center>visible par admin seulement</center></td>';}
	 if ( $mod['secu'] == 3 ) { echo ' <td><center>visible par admin et utilisateur ogpt</center></td>';}
	 if ( $mod['secu'] == 2 ) { echo ' <td><center>visible par les membres du forum</center></td>';}
	 if ( $mod['secu'] == 0 ) { echo ' <td><center>visible par tous</center></td>';}

     echo '</tr> ';

   }
       echo'</table> ';

?>
 </fieldset>
  <br>




	</div>
</div>





  <div class="blockform">
	<h2><span>Propulsé par ogspy/<a href="http://www.ogsteam.fr">ogsteam</a></span></h2>

    </div>





<?php

$footer_style = 'index';
require PUN_ROOT.'footer.php';

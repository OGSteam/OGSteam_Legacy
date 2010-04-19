<?php
//mod pandore sy developpé pour pun_ogpt, adaptable

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db, $table_prefix;
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");
define("TABLE_PANDORE_SPY",	$table_prefix."pandorespy");

$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('', 'pandorespy', 'pandorespy', 'pandorespy', 'pandorespy', 'pandorespy.php', '1.0', '1')";

$db->sql_query($query);


/// creation table pandorespy qui recevra les infos de la bdd

$query = "CREATE TABLE ".TABLE_PANDORE_SPY." ("
	. " id INT NOT NULL AUTO_INCREMENT, "
	. " date INT(11) NOT NULL, "
	. " presence INT(11) NOT NULL, "
	. " la  INT( 1 ) NOT NULL DEFAULT '0' , "
	. " annee int (11) NOT NULL, "
	. " mois int (2) NOT NULL, "
        . " jour_num INT(11) NOT NULL, "
        . " jour TEXT NOT NULL, "
	. " heure INT(2) NOT NULL, "
	. " minute INT(2) NOT NULL, "
        . " gal TEXT NOT NULL, "
	. " pos_galaxie INT NOT NULL, "
	. " pos_sys INT NOT NULL, "
	. " pos_pos INT NOT NULL, "
	. " player TINYTEXT NOT NULL, "
	. " body TEXT NOT NULL, "
	. " user_id INT NOT NULL, "
	. " sender TINYTEXT NOT NULL, "
	. " primary key ( id )"
	. " )TYPE=MyISAM";
$db->sql_query($query);


// Insertion de la liaison entre Xtense v2 et pandorespy
// Quelle est l'ID du mod ?
$mod_id = $db->sql_insertid();

// On regarde si la table xtense_callbacks existe :
$result = $db->sql_query('show tables from '.$db->dbname.' like "'.TABLE_XTENSE_CALLBACKS.'" ');
if($db->sql_numrows($result) != 0){

	//Maintenant on regarde si pandorespy est dedans
    $result = $db->sql_query("Select * From ".TABLE_XTENSE_CALLBACKS." where mod_id = '$mod_id'");
    $nresult = $db->sql_numrows($result);

	// s'il n'y est pas : alors on l'ajoute!
    if($nresult == 0)
        $db->sql_query("INSERT INTO ".TABLE_XTENSE_CALLBACKS." (mod_id, function, type, active) VALUES ('$mod_id', 'pandorespy', 'system', 1)");
echo("<script> alert('xtense ok') </script>");

}
else	    //On averti qu'Xtense 2 n'est pas installé :
    echo("<script> alert('Le mod Xtense 2 n\'est pas installé. \nLa compatibilité du mod pandorespy pour pun_ogpt ne sera donc pas installée !\nPensez à installer Xtense 2 c'est pratique ;)') </script>");
?>















?>
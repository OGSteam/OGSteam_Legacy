<?php
//    © 2006 GEOLOC
//Geoloc se réserve le droit de poursuivre tout acte de contrefaçon de ses droits de propriété intellectuelle.

//////////////////////////////////////////////////
// Entrez ici vos parametres de connexion mysql //
//////////////////////////////////////////////////
include ('../config.php');

$host= $dbhost;   //hebergeur ex:sql.free.fr
$user= $dbuser;  // nom d'utilisateur
$mdp= $dbpasswd;   // mot de passe
$database= $dbname;  // nom de la base

/////////////////////////////////////////////////////////////////////
// Entrez le nombres de minutes ou vous considérez que le visiteur //
// est present sur votre site apres sa derniere page(5 par defaut) //
/////////////////////////////////////////////////////////////////////
mysql_connect($dbhost, $dbuser, $dbpasswd);
mysql_select_db($dbname);
$retour = mysql_query("SELECT * FROM ".$table_prefix."config WHERE config_name='server_name'");
$donnees = mysql_fetch_array($retour);
$url = $donnees['config_value'];
$retour = mysql_query("SELECT * FROM ".$table_prefix."config WHERE config_name='script_path'");
$donnees = mysql_fetch_array($retour);
mysql_close();
$dossier = $donnees['config_value'];
$url_site = $url.$dossier;   //url de votre site sans "http://"

$min=5;
?>

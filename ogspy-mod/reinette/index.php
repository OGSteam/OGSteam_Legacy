<?php 


if (!defined('IN_SPYOGAME')) die("Hacking attempt");
global $server_config ; // histoire d etre sur 



require_once("views/page_header.php");
list($root, $active) = $db->sql_fetch_row($db->sql_query("SELECT root, active FROM " .
    TABLE_MOD . " WHERE action = 'reinette'"));

require_once ("mod/{$root}/includes/db_xml.php");
require_once ("mod/{$root}/includes/functions.php");


if ($pub_type == "complete_uni") {
    $g = (int)$pub_sub_type;
  if ($g >= 1 and $g <= $server_config['num_of_galaxies'])
    {
    create_galaxie($g);
    }
}

if ($pub_type == "destroy") {
    $g = (int)$pub_sub_type;
  
    destroy_galaxie();
  
}


echo ' <br /> ';
echo ' Création d un univers vide<br />';

$nb_by_g = (int)((int)$server_config['num_of_systems'] * 15);
echo ' Nb de galaxie : '.$server_config['num_of_galaxies'].'. Nb de systeme solaire par galaxie  : '.$nb_by_g.' ( <a href="index.php?action=reinette&type=destroy&sub_type=ca_va_faire_tres_mal">Vider l univers </a>)<br />';
for ($i = 1; $i <= $server_config['num_of_galaxies'] ; $i++) {
    $nb_by_g_actuellement = count_ss($i);
    echo 'Total Galaxie '.$i.' : '.$nb_by_g_actuellement.' ';
    if ($nb_by_g_actuellement != $nb_by_g) {echo ' ( <a href="index.php?action=reinette&type=complete_uni&sub_type='.$i.'">Completer l univers </a>)'; }
    else {
        echo ' ( Galaxie compléte )'; 
    }
    echo '<br />';
}





echo ' <br /> <br />';

echo ' Nombre de systeme solaire mis a jour : '.find_config("nb_maj_uni").'<br />';
echo ' Nombre de stat joueur mis a jour : '.find_config("nb_maj_stat").'<br />';
echo ' Derniere mise a jour univers : '.date_fr("l d F Y, H:i:s", find_config("last_maj_uni")).' <br />';
echo ' Derniere mise a jour classement : '.date_fr("l d F Y, H:i:s", find_config("last_maj_stat")).'<br />';
//echo ' <br />';
//echo ' Nombre de systeme solaire par importation : '.find_config("nb_ss_par_envoi").'<br />';
echo ' <br />';
echo ' Version Pomme d\'api compatible : '.find_config("version_pommedapi").'<br />';

echo ' <br /> <br /> ';
echo ' Pour plus d information : <a href="http://forum.ogsteam.fr/index.php/topic,550.0.html">Reinette</a>';
require_once("views/page_tail.php");

?>


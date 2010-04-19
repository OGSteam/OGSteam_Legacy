<?php
/***********************************************************************
MACHINE

************************************************************************/


define('PUN_ROOT', './');
require PUN_ROOT . 'include/common.php';

// Load the index.php language file
require PUN_ROOT . 'lang/' . $pun_user['language'] . '/index.php';

///ogpt
$lien = "galaxie.php"; /// on laisse galaxie puisque dependant cde celle ci et comme ca favorie non ajouter au menu de gauche
$page_title = "galaxie";
require_once PUN_ROOT . 'ogpt/include/ogpt.php';
/// fin ogpt


define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT . 'header.php';
// info bulle 
?>
<script type="text/javascript" src="ogpt/js/wz_tooltip.js"></script>
<?php
///fin infobulle
?>
<?php

echo '<div class="blockform"><h2><span> Favori(s)  </span></h2><div class="box"> ';

    
    if ($_GET['action'] == "fav") {
    	/// verif des variables
    	
    $galaxy=	pun_trim($_GET['galaxie']);
    $system=	pun_trim($_GET['systeme']);
    $row=	pun_trim($_GET['row']);
     /// valeur numerique
    if (is_numeric($galaxy) && is_numeric($system) && is_numeric($row)) {
    } else {
        $redirection = "redirection suite a probleme";
        redirect('galaxie.php', $redirection);
    }
     	 	 	 	
       $db->query('INSERT INTO favorie (galaxy, system, row,sender) VALUES 
(\''.$galaxy.'\', \''.$system.'\', \''.$row.'\',   \''.$pun_user['id_ogspy'].'\')') or
        error('Unable to add favori', __file__, __line__, $db->error());

    	
    	
    	
///redirection pour prise en compte dans la page
$redirection="ajout reussi"; redirect('favorie.php', $redirection);


      
    }

if ($_GET['action'] == "unfav") 
      
 {
 		/// verif des variables
    	
    $galaxy=	pun_trim($_GET['galaxie']);
    $system=	pun_trim($_GET['systeme']);
    $row=	pun_trim($_GET['row']);
     /// valeur numerique
    if (is_numeric($galaxy) && is_numeric($system) && is_numeric($row)) {
    } else {
        $redirection = "redirection suite a probleme";
        redirect('galaxie.php', $redirection);
    }
     	 	 	 	
 	
 $db->query('DELETE FROM favorie WHERE sender= \''.$pun_user['id_ogspy'].'\' and galaxy=\''.$galaxy.'\' and system=\''.$system.'\' and row=\''.$row.'\'
 ') or error('Unable to delete favori', __FILE__, __LINE__, $db->error());	
 	
 	
///redirection pour prise en compte dans la page
$redirection="suppression reussi"; redirect('favorie.php', $redirection);

	

 }
 
 if ($_GET['action'] !== "fav" && $_GET['action'] !== "unfav") 
{ 
///pagination
/// nb de pages
$num_reponse = $db->num_rows($result);

$num_pages = ceil(($num_reponse + 1) / 20);
$p = (!isset($_GET['p']) || $_GET['p'] <= 1 || $_GET['p'] > $num_pages) ? 1 : $_GET['p'];
$start_from = 20  * ($p - 1);
// gernerer les liens
$paging_links = 'Page : '.paginate($num_pages, $p, 'favorie.php');

 echo ' '.$paging_links.' ';

// fin pagination	
	
	
	/// appel du haut du tableau
	echo '<table>';
	$pre_galaxie = pre_galaxie();
echo '' . $pre_galaxie . '';
	
///appel des coordonnés retenues 
	$sql = 'SELECT galaxy, system, row , sender FROM favorie   where sender= \''.$pun_user['id_ogspy'].'\' ORDER BY galaxy , system , row  asc limit '.$start_from.', 20  ';
$result = $db->query($sql);
while ($fav = $db->fetch_assoc($result)) {
$galaxie=$fav['galaxy'];
$systeme=$fav['system'];
$row=	$fav['row'];
	
	

$sqlbis = 'SELECT row , galaxy , system , name , ally , player , moon , status , last_update_user_id , last_update , user_name	 FROM ' .
    $pun_config["ogspy_prefix"] . 'universe  left join  ' . $pun_config["ogspy_prefix"] .
    'user on last_update_user_id = user_id where galaxy=' . $galaxie .
    ' and 	system=' . $systeme . ' and row = ' . $row . ' ';
$resultbis = $db->query($sqlbis);


while ($carto = $db->fetch_assoc($resultbis)) {

    ///appel tableau galaxie
    $galaxie = galaxie($carto['row'], $carto['name'], $carto['ally'], $carto['player'],
        $carto['moon'], $carto['status'], $carto['galaxy'], $carto['system'], $carto['last_update'],
        $carto['user_name']);
    echo '' . $galaxie . '';

}	
}
/// fin du tableau


$post_galaxie = post_galaxie();
echo '' . $post_galaxie . '';	
	

}
?>

    </div>
    </div>



  <div class="blockform">
	<h2><span>Propulsé par ogspy/<a href="http://www.ogsteam.fr">ogsteam</a></span></h2>

    </div>



<?php



require PUN_ROOT . 'footer.php';
?>
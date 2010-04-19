<?php
/***********************************************************************
MACHINE

************************************************************************/


define('PUN_ROOT', './');
require PUN_ROOT . 'include/common.php';

// Load the index.php language file
require PUN_ROOT . 'lang/' . $pun_user['language'] . '/index.php';

///ogpt
$lien = "galaxie.php";
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
/***************************************************************************
modification : machine

***************************************************************************/
///paramettre de la galaxie ( a mettre eb bdd plus tard )
$gal_min = 1;
$gal_max = $pun_config['gal'] + 1;
$sys_min = 1;
$sys_max = $pun_config['sys'] + 1;
//// systeme affiché de base si rien en paramettre ...
$galaxie = $pun_user['pm_g'];
$systeme = $pun_user['pm_s'];

/// verification des paramettre passé dans l'url ( $_get )

if (isset($_GET['action'])) {
    // mauvais paramettre pour action : non egale a galaxie
    if ($_GET['action'] !== "galaxie") {
        $redirection = "redirection suite a probleme";
        redirect('galaxie.php', $redirection);
    }

    /// verification valeur galaxie et systeme
    /// filtre divers :
    pun_trim($_GET["galaxie"]);
    pun_trim($_GET["systeme"]);

    /// valeur numerique
    if (is_numeric($_GET["galaxie"]) && is_numeric($_GET["systeme"])) {
    } else {
        $redirection = "redirection suite a probleme";
        redirect('galaxie.php', $redirection);
    }

    ///verification des valeurs ( comprise dans les bornes des galaxies et systeme ... :p )
    /// si veleur de galaxie inf a 1 => valeur 1 sup a 9 => 1
    if ($_GET["galaxie"] >= $gal_min && $_GET["galaxie"] < $gal_max) {
        $galaxie = $_GET["galaxie"];
    } else {
        $galaxie = 1;
    }

    /// si veleur de systeme inf a 1 => valeur 1 sup a 499 => 499
    if ($_GET["systeme"] >= $sys_min && $_GET["systeme"] < $sys_max) {
        $systeme = $_GET["systeme"];
    } else {
        $systeme = 1;
    }


}

echo '<div class="blockform"><h2><span> galaxie : ' . $galaxie . ' systeme :  ' .
    $systeme . '       ( <a href="favorie.php">favori</a> )      </span></h2><div class="box"> ';
?>

<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse" height="5" id="carto">

 <tr><td colspan="8"><center>

    <form id="universe" method="get" action="galaxie.php">



						<input type="hidden" name="action" value="galaxie" accesskey="s" />
                                                    Galaxie :    |	Systeme :   <br>
					<?php $future_galaxie_min = ($galaxie - 1);
echo ' <a href="galaxie.php?action=galaxie&galaxie=' . $future_galaxie_min .
    '&systeme=' . $systeme . '">'; ?> <<<</a> <input type="text" name="galaxie" size="2" maxlength="2" value="<?php echo
'' . $galaxie . ''; ?>"/><?php $future_galaxie_max = ($galaxie + 1);
echo ' <a href="galaxie.php?action=galaxie&galaxie=' . $future_galaxie_max .
    '&systeme=' . $systeme . '">'; ?> >>></a>  |
					<?php $future_systeme_min = ($systeme - 1);
echo ' <a href="galaxie.php?action=galaxie&galaxie=' . $galaxie . '&systeme=' .
    $future_systeme_min . '">'; ?><<<</a> <input type="text" name="systeme" size="3" maxlength="3"  value="<?php echo
'' . $systeme . ''; ?>"/><?php $future_systeme_max = ($systeme + 1);
echo ' <a href="galaxie.php?action=galaxie&galaxie=' . $galaxie . '&systeme=' .
    $future_systeme_max . '">'; ?> >>></a>






			<br><input type="submit"   />
		</form>





 </center></td></tr>
<?php
/// appel du haut tableau galaxie
$pre_galaxie = pre_galaxie();
echo '' . $pre_galaxie . ''
?>



<?php
///requete
$i = 1;
$sql = 'SELECT row , galaxy , system , name , ally , player , moon , status , last_update_user_id , last_update , user_name	 FROM ' .
    $pun_config["ogspy_prefix"] . 'universe  left join  ' . $pun_config["ogspy_prefix"] .
    'user on last_update_user_id = user_id where galaxy=' . $galaxie .
    ' and 	system=' . $systeme . '  ORDER BY row asc';
$result = $db->query($sql);


while ($carto = $db->fetch_assoc($result)) {

    ///appel tableau galaxie
    $galaxie = galaxie($carto['row'], $carto['name'], $carto['ally'], $carto['player'],
        $carto['moon'], $carto['status'], $carto['galaxy'], $carto['system'], $carto['last_update'],
        $carto['user_name']);
    echo '' . $galaxie . '';

}


$post_galaxie = post_galaxie();
echo '' . $post_galaxie . ''
?>

 









    </div>
    </div>

   <div class="blockform">
	<h2><span>Amis</span></h2>
	<div class="box">
<?php $missil = portee_missiles($galaxie, $systeme); ?>
  <fieldset>
				<legend>Liste des MIPs dans le secteur</legend>

    <?php echo $missil; ?>

    </fieldset>







    </div>
    </div>
    <div class="blockform">
	<h2><span>Ennemis</span></h2>
	<div class="box">

     <fieldset>
				<legend>Liste des phalanges hostiles avec porte de saut dans le secteur</legend>


<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse" height="5" id="carto">

<?php
/// appel du haut tableau galaxie
$pre_galaxie = pre_galaxie();
echo '' . $pre_galaxie . ''
?>



    <?php
$i = 1;
$sql = 'SELECT row ,galaxy, phalanx ,  	 system, name , ally , player , moon , status , last_update_user_id , last_update , user_name	 FROM ' .
    $pun_config["ogspy_prefix"] . 'universe  left join  ' . $pun_config["ogspy_prefix"] .
    'user on last_update_user_id = user_id where galaxy = ' . $galaxie .
    ' and moon = \'1\' and gate = \'1\' and phalanx > 0 and system + (power(phalanx, 2) - 1) >= ' .
    $systeme . ' and system - (power(phalanx, 2) - 1) <= ' . $systeme . '';


$result = $db->query($sql);


while ($carto = $db->fetch_assoc($result)) {
    ///appel tableau galaxie
    $galaxie = galaxie($carto['row'], $carto['name'], $carto['ally'], $carto['player'],
        $carto['moon'], $carto['status'], $carto['galaxy'], $carto['system'], $carto['last_update'],
        $carto['user_name']);
    echo '' . $galaxie . '';


}


$post_galaxie = post_galaxie();
echo '' . $post_galaxie . ''

?>

 </table>


     </fieldset>


   <fieldset>
				<legend>Liste des phalanges hostiles sans porte dans le secteur</legend>


<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse" height="5" id="carto">

<?php
/// appel du haut tableau galaxie
$pre_galaxie = pre_galaxie();
echo '' . $pre_galaxie . ''
?>




    <?php
$i = 1;
$sql = 'SELECT row ,galaxy, phalanx ,  	 system, name , ally , player , moon , status , last_update_user_id , last_update , user_name	 FROM ' .
    $pun_config["ogspy_prefix"] . 'universe  left join  ' . $pun_config["ogspy_prefix"] .
    'user on last_update_user_id = user_id where galaxy = ' . $galaxie .
    ' and moon = \'1\' and gate = \'0\' and phalanx > 0 and system + (power(phalanx, 2) - 1) >= ' .
    $systeme . ' and system - (power(phalanx, 2) - 1) <= ' . $systeme . '';


$result = $db->query($sql);


while ($carto = $db->fetch_assoc($result)) {

    ///appel tableau galaxie
    $galaxie = galaxie($carto['row'], $carto['name'], $carto['ally'], $carto['player'],
        $carto['moon'], $carto['status'], $carto['galaxy'], $carto['system'], $carto['last_update'],
        $carto['user_name']);
    echo '' . $galaxie . '';


}


$post_galaxie = post_galaxie();
echo '' . $post_galaxie . ''

?>

 </table>


     </fieldset>



    </div>
    </div>



  <div class="blockform">
	<h2><span>Propulsé par ogspy/<a href="http://www.ogsteam.fr">ogsteam</a></span></h2>

    </div>



<?php



require PUN_ROOT . 'footer.php';
?>
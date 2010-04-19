<?php
/***********************************************************************
MACHINE

************************************************************************/


define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';
///ogpt 
$lien="rech_joueur.php";
$page_title = "recherche joueur";
require_once  PUN_ROOT . 'ogpt/include/ogpt.php';
/// fin ogpt

// Load the index.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/index.php';

define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';

// info bulle 
?>
<script type="text/javascript" src="ogpt/js/wz_tooltip.js"></script>
<?php
///fin infobulle


   if (isset($_GET['joueur']))
{
  $joueur=pun_htmlspecialchars(pun_trim($_GET['joueur']));

?>

<?php
   echo '<div class="blockform"><h2><span> '.$joueur.'   </span></h2><div class="box"> ';
 ?>

<table width="95%"  border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse" height="5" id="carto">



<?php
/// appel du haut tableau galaxie
$pre_galaxie = pre_galaxie();
echo '' . $pre_galaxie . ''
?>




<?php
$i=1;
$sql = 'SELECT row , galaxy , system , name , ally , player , moon , status , last_update_user_id , last_update , user_name	 FROM '.$pun_config["ogspy_prefix"].'universe  left join  '.$pun_config["ogspy_prefix"].'user on last_update_user_id = user_id where player=\''.$joueur.'\' order by galaxy , system, row';
	    $result = $db->query($sql);



	    while($carto = $db->fetch_assoc($result))
	    {
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
</div></div>
<div class="blockform"><h2><span>Classement de <b><?php echo $joueur;?></b></span></h2><div class="box">
    <table>

		<tr>
			<th class="c">Date</th>
			<th class="c" colspan="2">Pts Général</th>
			<th class="c" colspan="2">Pts Flotte</th>
			<th class="c" colspan="2">Pts Recherche</th>

		</tr>
<?php
$individual_ranking = galaxy_show_ranking_unique_player($joueur);
while ($ranking = current($individual_ranking)) {
	$datadate = strftime("%d %b %Y %H:%M", key($individual_ranking));
	$general_rank = isset($ranking["general"]) ?  convNumber($ranking["general"]["rank"]) : "&nbsp;";
	$general_points = isset($ranking["general"]) ? convNumber($ranking["general"]["points"]) : "&nbsp;";
	$fleet_rank = isset($ranking["fleet"]) ?  convNumber($ranking["fleet"]["rank"]) : "&nbsp;";
	$fleet_points = isset($ranking["fleet"]) ?  convNumber($ranking["fleet"]["points"]) : "&nbsp;";
	$research_rank = isset($ranking["research"]) ?  convNumber($ranking["research"]["rank"]) : "&nbsp;";
	$research_points = isset($ranking["research"]) ?  convNumber($ranking["research"]["points"]) : "&nbsp;";

	echo "\t\t"."<tr>"."\n";
	echo "\t\t\t"."<td width='150'>".$datadate."</td>"."\n";
	echo "\t\t\t"."<td width='70'>".$general_points."</td>"."\n";
	echo "\t\t\t"."<th width='40'><i>".$general_rank."</i></th>"."\n";
	echo "\t\t\t"."<td width='70'>".$fleet_points."</td>"."\n";
	echo "\t\t\t"."<th width='40'><i>".$fleet_rank."</i></th>"."\n";
	echo "\t\t\t"."<td width='70'>".$research_points."</td>"."\n";
	echo "\t\t\t"."<th width='40'><i>".$research_rank."</i></th>"."\n";

	next($individual_ranking);
}
?>
		</table>



</div></div>




  <?php } ?>




<div class="blockform"><h2><span>recherche joueur</span></h2><div class="box">



<form id="rech_joueur" method="get" action="rech_joueur.php">
			<div class="inform">


						<input type="hidden" name="action" value="rech_joueur" accesskey="s" />
						<label class="conl">Nom :    <input type="text" name="joueur" size="20" maxlength="20" ></label>




			<p><input type="submit"   /></p>
		</form>

	</div>
</div>

</div>



  <div class="blockform">
	<h2><span>Propulsé par ogspy/<a href="http://www.ogsteam.fr">ogsteam</a></span></h2>

    </div>

<?php

$footer_style = 'index';
require PUN_ROOT.'footer.php';

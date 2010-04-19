<?php
/***********************************************************************
MACHINE

************************************************************************/


define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';
///ogpt 
$lien="rech_ally.php";
$page_title = "recherche d alliance";
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



   if (isset($_GET['ally']))
{
  $ally=pun_htmlspecialchars(pun_trim($_GET['ally']));


///pagination


$result = $db->query('SELECT player FROM '.$pun_config["ogspy_prefix"].'universe  where ally=\''.$ally.'\' ');

$num_reponse = $db->num_rows($result);







$num_pages = ceil(($num_reponse + 1) / 20);



$p = (!isset($_GET['p']) || $_GET['p'] <= 1 || $_GET['p'] > $num_pages) ? 1 : $_GET['p'];

$start_from = 20  * ($p - 1);

// gernerer les liens

$paging_links = 'Page : '.paginate($num_pages, $p, 'rech_ally.php?action=rech_ally&ally='.urlencode($ally));


// fin pagination






?>

<?php
   echo '<div class="blockform">';
    echo ' '.$paging_links.'   ';
   echo '<h2><span> '.$ally.'   </span></h2><div class="box"> ';



?>
<table width="95%"  border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse" height="5" id="carto">


<?php
/// appel du haut tableau galaxie
$pre_galaxie = pre_galaxie();
echo '' . $pre_galaxie . ''
?>




<?php
$i=1;
$sql = 'SELECT row , galaxy , system , name , ally , player , moon , status , last_update_user_id , last_update , user_name	 FROM '.$pun_config["ogspy_prefix"].'universe  left join  ogspy_user on last_update_user_id = user_id where ally=\''.$ally.'\' order by galaxy , system, row  LIMIT '.$start_from.', 20';
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



</div>
<?php echo ' '.$paging_links.' '; ?>
</div>
<div class="blockform"><h2><span>Classement de <b><?php echo $ally;?></b></span></h2><div class="box">
    <table>

		<tr>
			<th class="c">Date</th>
			<th class="c" colspan="2">Pts Général</th>
			<th class="c" colspan="2">Pts Flotte</th>
			<th class="c" colspan="2">Pts Recherche</th>
			<th class="c">Nb Membre</th>
		</tr>
<?php
$individual_ranking = galaxy_show_ranking_unique_ally($ally);
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
	echo "<th width='70'><b>".$ranking["number_member"]."</b></th>";
	next($individual_ranking);
}
?>
		</table>



</div></div>



<?php
/// info generale

   echo '<div class="blockform"><h2><span>Infos diverses</span></h2><div class="box"> '; ?>
   
 <table>

		<tr>
			<th class="c" >joueur</th>
			<th class="c" >alliance</th>
			<th class="c" >statut</th>
		</tr> <?php
		
		$sql = 'SELECT player , ally ,status 	FROM '.$pun_config["ogspy_prefix"].'universe  where ally=\''.$ally.'\' group by player';
	    $result = $db->query($sql);




	    while($carto = $db->fetch_assoc($result))
	    {
	    $player=$carto['player'];
		    echo '

<tr>
		<td  align="center" class="c" ><FONT size=1>'.player ($player).'</font></td>
		<td  align="center" class="c" ><FONT size=1><a href="rech_ally.php?ally='.$carto['ally'].'">'.$carto['ally'].'<a></font></td>
		<td  align="center" class="c" ><FONT size=1>'.$carto['status'].'</font></td>

	</tr>

              ';
		
		}
		?>
		</table>

<?php

 echo '</div></div>';
   
?>





  <?php } ?>




<div class="blockform"><h2><span>recherche alliance </span></h2><div class="box">



<form id="rech_ally" method="get" action="rech_ally.php">
			<div class="inform">


						<input type="hidden" name="action" value="rech_ally" accesskey="s" />
						<label class="conl">Nom :    <input type="text" name="ally" size="20" maxlength="20" ></label>




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

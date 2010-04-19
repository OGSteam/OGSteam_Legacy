<?php
/***************************************************************************
*	filename	: admin_ratio.php
*	desc.		: maniabilité du ratio
*	Author		: Bousteur - bousteur@ogsteam.fr
*	created		: 22/11/2006
*	modified	: 
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");
require_once("common.php");
$j0ueur = $pub_j0ueur;
$what = $pub_what;

if($what=="boost"){
	$sqlrecup = "SELECT planet_added_web, planet_added_ogs, planet_exported, search, spy_added_web, spy_added_ogs, spy_exported, rank_added_web, rank_added_ogs, rank_exported FROM ".TABLE_USER." WHERE user_id=".$j0ueur;
	$result = $db->sql_query($sqlrecup);
	list($planet_added_web, $planet_added_ogs, $planet_exported, $search, $spy_added_web, $spy_added_ogs, $spy_exported, $rank_added_web, $rank_added_ogs, $rank_exported) = $db->sql_fetch_row($result);
	$planet_added_web = $planet_added_web + 100;
	$planet_added_ogs = $planet_added_ogs + 100;
	
	$spy_added_web = $spy_added_web + 100;
	$spy_added_ogs = $spy_added_ogs + 100;
	
	$rank_added_web = $rank_added_web + 100;
	$rank_added_ogs = $rank_added_ogs + 100;
	
	$sqlboost = "UPDATE ".TABLE_USER." SET planet_added_web=".$planet_added_web.", planet_added_ogs=".$planet_added_ogs.", planet_exported=".$planet_exported.", search=".$search.", spy_added_web=".$spy_added_web.", spy_added_ogs=".$spy_added_ogs.", spy_exported=".$spy_exported.", rank_added_web=".$rank_added_web.", rank_added_ogs=".$rank_added_ogs.", rank_exported=".$rank_exported." WHERE user_id=".$j0ueur;
	$db->sql_query($sqlboost) or die(mysql_error());
}
elseif($what=="reset"){
	$sqlreset = "UPDATE ".TABLE_USER." SET planet_added_web=0, planet_added_ogs=0, planet_exported=0, search=0, spy_added_web=0, spy_added_ogs=0, spy_exported=0, rank_added_web=0, rank_added_ogs=0, rank_exported=0 WHERE user_id=".$j0ueur;
	$db->sql_query($sqlreset) or die(mysql_error());
}
?>

<br>
<?php echo $LANG["ratioalterdone"]; ?>
<br><br>
<a href="index.php?action=statistic"><?php echo $LANG["message_Return"]; ?></a>
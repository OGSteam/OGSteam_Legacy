<?php
/**
* @Page principale du module
* @package rechercheAlly
* @Créateur du script Aeris
* @link http://www.ogsteam.fr
*
* @Modifier par Kazylax
* @Site internet www.kazylax.net
* @Contact kazylax-fr@hotmail.fr
*
 */
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

require_once("views/page_header.php");
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='alliance' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Module compatible avec OGspy");

if ( isset( $pub_ally ) && ( $pub_ally <> '' ) )
{
	if ( $pub_classement == 'joueur' ) { $ordre = 'ASC'; } else { $ordre = 'DESC'; }
	$query  = "SELECT DISTINCT U.player AS joueur, ".TABLE_RANK_PLAYER_POINTS.".points AS pp, ".TABLE_RANK_PLAYER_POINTS.".rank AS pr, ".TABLE_RANK_PLAYER_FLEET.".points AS fp, ".TABLE_RANK_PLAYER_FLEET.".rank AS fr, ".TABLE_RANK_PLAYER_RESEARCH.".points AS rp, ".TABLE_RANK_PLAYER_RESEARCH.".rank AS rr ";
	$query .= "FROM ".TABLE_UNIVERSE." AS U ";
	$query .= "LEFT JOIN ".TABLE_RANK_PLAYER_POINTS." ON ".TABLE_RANK_PLAYER_POINTS.".player=U.player AND ".TABLE_RANK_PLAYER_POINTS.".datadate IN ( ";
	$query .= "		SELECT max(".TABLE_RANK_PLAYER_POINTS.".datadate) ";
	$query .= "		FROM ".TABLE_RANK_PLAYER_POINTS." ";
	$query .= "		WHERE ".TABLE_RANK_PLAYER_POINTS.".player=U.player ) ";
	$query .= "LEFT JOIN ".TABLE_RANK_PLAYER_FLEET." ON ".TABLE_RANK_PLAYER_FLEET.".player=U.player AND ".TABLE_RANK_PLAYER_FLEET.".datadate IN ( ";
	$query .= "		SELECT max(".TABLE_RANK_PLAYER_FLEET.".datadate) ";
	$query .= "		FROM ".TABLE_RANK_PLAYER_FLEET." ";
	$query .= "		WHERE ".TABLE_RANK_PLAYER_FLEET.".player=U.player ) ";
	$query .= "LEFT JOIN ".TABLE_RANK_PLAYER_RESEARCH." ON ".TABLE_RANK_PLAYER_RESEARCH.".player=U.player AND ".TABLE_RANK_PLAYER_RESEARCH.".datadate IN ( ";
	$query .= "		SELECT max(".TABLE_RANK_PLAYER_RESEARCH.".datadate) ";
	$query .= "		FROM ".TABLE_RANK_PLAYER_RESEARCH." ";
	$query .= "		WHERE ".TABLE_RANK_PLAYER_RESEARCH.".player=U.player ) ";
	$query .= "WHERE U.ally='".mysql_real_escape_string($pub_ally)."' ";
	$query .= "ORDER BY ".mysql_real_escape_string($pub_classement)." $ordre";

	$result = $db->sql_query($query);
	
	$query_ally = galaxy_show_ranking_unique_ally($ally, true);
	$key = key($query_ally);

      //variables Point
      $generalp = $query_ally[$key]["general"]["points"]."";
      $flottep = $query_ally[$key]["fleet"]["points"]."";
      $recherchep = $query_ally[$key]["research"]["points"]."";
      
      //variables classement
      $classementally = $query_ally[$key]["general"]["rank"]." ème";
      $generalc = $query_ally[$key]["general"]["rank"]."ème)";
      $flottec = $query_ally[$key]["fleet"]["rank"]." ème";
      $recherchec = $query_ally[$key]["research"]["rank"]." ème";
      $membreb = $query_ally[$key]["number_member"]." ème";
}
?>
<table width="%100">
<?php 
echo "\t\t"."<tr>";
$legend = "<table width=\"225\">";
$legend .= "<tr><td class=\"c\" colspan=\"2\" align=\"center\"e width=\"150\">Le classement de L\'alliance</td></tr>";
$legend .= "<tr><td class=\"c\">Alliance</td><th>$ally</th></tr>";
$legend .= "<tr><td class=\"c\">Classement Général</td><th>$classementally</th></tr>";
$legend .= "<tr><td class=\"c\">Classement Flotte</td><th>$flottec</th></tr>";
$legend .= "<tr><td class=\"c\">Classement Recherche</td><th>$recherchec</th></tr>";
$legend .= "<tr><td class=\"c\">Points Général</td><th>$generalp</th></tr>";
$legend .= "<tr><td class=\"c\">Points Flotte</td><th>$flottep</th></tr>";
$legend .= "<tr><td class=\"c\">Points Recherche</td><th>$recherchep</th></tr>";
$legend .= "</table>";
$legend = htmlentities($legend);
echo "<tr align='center'><td class='c' colspan='7'><a href='' onmouseover=\"this.T_WIDTH=210;this.T_TEMP=0;return escape('".$legend."')\">Le classement de L'alliance</a></td></tr>";

?>
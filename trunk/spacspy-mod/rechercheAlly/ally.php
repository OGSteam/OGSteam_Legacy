<?php
/**
* Page principale du module
* @package rechercheAlly
* @author Aeris
* @link http://www.ogsteam.fr
 */
?>

<script language=javascript>
function affiche(balise)
{
	if (document.getElementById && document.getElementById(balise) != null)
	{
		document.getElementById(balise).style.display='block';
	}
}

function cache(balise)
{
	if (document.getElementById && document.getElementById(balise) != null)
	{
		document.getElementById(balise).style.display='none';
	}
}

function inverse(balise)
{
	if ( document.getElementById(balise).style.display == 'block' ) { cache(balise); } else { affiche(balise); }
}

function afficheVer()
{
	affiche('verticale');
	cache('horizontale');
}

function afficheHor()
{
	affiche('horizontale');
	cache('verticale');
}
	
</script>

<?php
if (!defined('IN_SPACSPY')) die("Hacking attempt");

require_once("views/page_header.php");

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='ally' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

if ( isset( $pub_ally ) && ( $pub_ally <> '' ) )
{
	if ( $pub_classement == 'joueur' ) { $ordre = 'ASC'; } else { $ordre = 'DESC'; }
	$query = "SELECT DISTINCT U.player AS joueur, ";
	$query .= TABLE_RANK_PLAYER_POINTS.".points AS pp, ";
	$query .= TABLE_RANK_PLAYER_POINTS.".rank AS pr, ";
	$query .= TABLE_RANK_PLAYER_FLEET.".points AS fp, ";
	$query .= TABLE_RANK_PLAYER_FLEET.".rank AS fr, ";
	$query .= TABLE_RANK_PLAYER_MINES.".points AS mp, ";
	$query .= TABLE_RANK_PLAYER_MINES.".rank AS mr, ";
	$query .= TABLE_RANK_PLAYER_DEFENSES.".points AS dp, ";
	$query .= TABLE_RANK_PLAYER_DEFENSES.".rank AS dr, ";
	$query .= TABLE_RANK_PLAYER_RESEARCH.".points AS rp, ";
	$query .= TABLE_RANK_PLAYER_RESEARCH.".rank AS rr ";
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
	$query .= "LEFT JOIN ".TABLE_RANK_PLAYER_MINES." ON ".TABLE_RANK_PLAYER_MINES.".player=U.player AND ".TABLE_RANK_PLAYER_MINES.".datadate IN ( ";
	$query .= "		SELECT max(".TABLE_RANK_PLAYER_MINES.".datadate) ";
	$query .= "		FROM ".TABLE_RANK_PLAYER_MINES." ";
	$query .= "		WHERE ".TABLE_RANK_PLAYER_MINES.".player=U.player ) ";
	$query .= "LEFT JOIN ".TABLE_RANK_PLAYER_DEFENSES." ON ".TABLE_RANK_PLAYER_DEFENSES.".player=U.player AND ".TABLE_RANK_PLAYER_DEFENSES.".datadate IN ( ";
	$query .= "		SELECT max(".TABLE_RANK_PLAYER_DEFENSES.".datadate) ";
	$query .= "		FROM ".TABLE_RANK_PLAYER_DEFENSES." ";
	$query .= "		WHERE ".TABLE_RANK_PLAYER_DEFENSES.".player=U.player ) ";
	$query .= "WHERE U.ally='".mysql_real_escape_string($pub_ally)."' ";
	$query .= "ORDER BY ".mysql_real_escape_string($pub_classement)." $ordre";
	$result = $db->sql_query($query);

	
	$query_ally = galaxy_show_ranking_unique_ally($ally, true);
	$key = key($query_ally);
		
	$texte = "<table border=1 cellpadding=5>\n";
	$texte .= "<tr><td colspan=6 align=center class=c><b>Alliance <a href=index.php?action=search&type_search=ally&string_search=$ally>[$ally]</a></b>";
	$texte .= "<br>".$query_ally[$key]["general"]["points"]." points (".$query_ally[$key]["general"]["rank"]."ème) au général";
	$texte .= "<br>".$query_ally[$key]["fleet"]["points"]." points (".$query_ally[$key]["fleet"]["rank"]."ème) en flotte";
	$texte .= "<br>".$query_ally[$key]["mines"]["points"]." points (".$query_ally[$key]["mines"]["rank"]."ème) au mines";
	$texte .= "<br>".$query_ally[$key]["defenses"]["points"]." points (".$query_ally[$key]["defenses"]["rank"]."ème) en défence";
	$texte .= "<br>".$query_ally[$key]["research"]["points"]." points (".$query_ally[$key]["research"]["rank"]."ème) en recherches";
	$texte .= "<br>".$query_ally[$key]["number_member"]." membres<br><a href=javascript:inverse('bbcode');>(BBCode)</a></td></tr>\n";
	$texte .= "<tr><td align=center class=c><b>joueur</b></td>";
	$texte .= "<td align=center class=c><b>points (rang)</b></td>";
	$texte .= "<td align=center class=c><b>flotte (rang)</b></td>";
	$texte .= "<td align=center class=c><b>mines (rang)</b></td>";
	$texte .= "<td align=center class=c><b>defenses (rang)</b></td>";
	$texte .= "<td align=center class=c><b>recherches (rang)</b></td></tr>\n";
	
	$bbcode = "[center]Alliance [$ally]\n";
	$bbcode .= $query_ally[$key]["general"]["points"]." points (".$query_ally[$key]["general"]["rank"]."ème) au général\n".$query_ally[$key]["fleet"]["points"]." points (".$query_ally[$key]["fleet"]["rank"]."ème) en flotte\n".$query_ally[$key]["research"]["points"]." points (".$query_ally[$key]["research"]["rank"]."ème) en recherches\n".$query_ally[$key]["number_member"]." membres\n\n";
	$bbcode .= "[color=cyan]Joueur [/color]";
	$bbcode .= "[color=yellow]points (rang) [/color]";
	$bbcode .= "[color=red]vaisseaux (rang) [/color]";
	$bbcode .= "[color=teal]défenses  (rang) [/color]";
	$bbcode .= "[color=blue]mines (rang) [/color]";
	$bbcode .= "[color=white]recherches (rang) [/color]";
	
	while ( $val = $db->sql_fetch_assoc($result) )
	{
		$joueur = $val['joueur'];
		$pp = $val['pp'];
		$pr = $val['pr'];
		$fp = $val['fp'];
		$fr = $val['fr'];
		$dp = $val['dp'];
		$dr = $val['dr'];
		$mp = $val['mp'];
		$mr = $val['mr'];		
		$rp = $val['rp'];
		$rr = $val['rr'];
		
		if ( $pp <> '' ) { $points = "$pp ($pr)"; } else { $points = '&nbsp;'; }
		if ( $fp <> '' ) { $flotte = "$fp ($fr)"; } else { $flotte = '&nbsp;'; }
		if ( $dp <> '' ) { $mines = "$mp ($mr)"; } else { $mines = '&nbsp;'; }
		if ( $mp <> '' ) { $defenses = "$dp ($dr)"; } else { $defenses = '&nbsp;'; }
		if ( $rp <> '' ) { $recherche = "$rp ($rr)"; } else { $recherche = '&nbsp;'; }
		
		$linkPlayer = str_replace(" ", "%20", $joueur); // On crée une chaine pour faire le liens vers la recherche sur le joueur

		$texte .= "<tr><th><a href=index.php?action=search&type_search=player&string_search=$linkPlayer>$joueur</a></th>";
		$texte .= "<th>$points</th>";
		$texte .= "<th>$flotte</th>";
		$texte .= "<th>$defenses</th>";
		$texte .= "<th>$mines</th>";
		$texte .= "<th>$recherche</th></tr>\n";
		$bbcode .= "\n[color=cyan]".$joueur."[/color]";
		$bbcode .= "[color=yellow]".$points."[/color]";
		$bbcode .= "[color=red]".$flotte."[/color]";
		$bbcode .= "[color=teal]".$defenses."[/color]";
		$bbcode .= "[color=blue]".$mines."[/color]";
		$bbcode .= "[color=white]".$recherche."[/color]";
	}
	
	$texte .= "</table>\n";
	$bbcode .= "[/center]";
	
	$query = "SELECT DISTINCT player ";
	$query .= "FROM ".TABLE_UNIVERSE." ";
	$query .= "WHERE ally='".mysql_real_escape_string($pub_ally)."' ";
	$query .= "ORDER BY player";
		
	$result = $db->sql_query($query);
	
	$coord = "<table border=1 cellpadding=5>\n";
	$coord .= "<tr><td align=center class=c>Joueur</td><td align=center class=c>Coordonnées<br><a href=javascript:inverse('bbcode1');afficheVer();>(BBCode)</a></td></tr>\n";
	
	$bbcode2 = "[center]Alliance [$ally]\n\n";
	$bbcode3 = "[center]Alliance [$ally]\n\n";
	
	$couleur = "white";
	$nb = 0;
	
	while ( $val = $db->sql_fetch_assoc($result) )
	{
		if ( $nb ) {
			if ( $couleur == "orange" ) { $couleur = "white"; } else { $couleur = "orange"; }
			$bbcode2 .= "[/color]\n\n";
			$bbcode3 .= "[/color]\n\n";
		} else {
			$nb = 1;
		}
		
		$joueur = $val['player'];
		
		$coord .= "<tr><th><a href=index.php?action=search&type_search=player&string_search=$joueur>$joueur</a></th><th>";
		$bbcode2 .="[color=$couleur]$joueur";
		$bbcode3 .="[color=$couleur]$joueur\n";
		
		$query1 = "SELECT galaxy, system, row, moon ";
		$query1 .= "FROM ".TABLE_UNIVERSE." ";
		$query1 .= "WHERE player='".mysql_real_escape_string($joueur)."' ";
		$query1 .= "ORDER BY galaxy, system, row ASC";
		
		$result1 = $db->sql_query($query1);
		
		while ( $val1 = $db->sql_fetch_assoc($result1) )
		{
			$galaxie = $val1['galaxy'];
			$systeme = $val1['system'];
			$position = $val1['row'];
			$moon = $val1['moon'] ? ' [lune]' : '';
			
			$coord .= "<a href=index.php?action=galaxy&galaxy=$galaxie&system=$systeme>[$galaxie:$systeme:$position]$moon</a><br>";
			$bbcode2 .= "\n[$galaxie:$systeme:$position]$moon";
			$bbcode3 .= " [$galaxie:$systeme:$position]$moon";
		}
	}
	
	$coord .= "</th></tr>\n";
	$coord .= "</table>";
	$bbcode2 .= "[/color][/center]";
	$bbcode3 .= "[/color][/center]";
		
//	echo $query;
	
} else {
	$texte = '';
	$bbcode = '';
	$bbcode2 ='';
	$bbcode3 = '';
}

?>
<form method=post>
<table>
<tr><td align=right>Tag de l'alliance:</td><td align=left><input name=ally value= <?php echo $ally; ?> ></td></tr>
<tr><td colspan=2>Classer par:<input type=radio name=classement value=joueur <?php if ( $classement == 'joueur' ) { echo "checked"; } ?> >nom<input type=radio name=classement value=pp <?php if ( !isset( $classement ) || ( $classement == 'pp' ) ) { echo "checked"; } ?> >points<input type=radio name=classement value=fp <?php if ( $classement == 'fp' ) { echo "checked"; } ?> >flotte<input type=radio name=classement value=rp <?php if ( $classement == 'rp' ) { echo "checked"; } ?> >recherches</td></tr>
<tr><td colspan=2 align=center><input type=submit value="Rechercher"></td></tr>
</table>
</form>

<?php

if ( isset( $pub_ally ) )
{
	echo "<table>\n";
	echo "<tr><td align=center valign=top>\n$texte</td><td valign=top>\n";
	echo "<div id=bbcode style='display:none;'><textarea cols=50 rows=20 readonly>$bbcode</textarea></div></td>\n";
	echo "<td valign=top>$coord</td><td valign=top>";
	echo "<div id=bbcode1 style='display:none;'><table><tr><td align=center>Disposition</td></tr><tr><td align=center>Verticale<input type=radio name=dispo checked onclick=javascript:afficheVer();>Horizontale<input type=radio name=dispo onclick=javascript:afficheHor();></td></tr><tr><td align=center><div id=horizontale style='display:none;'><textarea name=coords cols=50 rows=20 readonly>$bbcode3</textarea></div><div id=verticale style='display:none;'><textarea name=coords cols=50 rows=20 readonly>$bbcode2</textarea></div></div></td></tr></table></td></tr>\n";
	echo "</table>";
}

?>

<div align=center><font size=2>Recherche d'alliance développée par <a href=mailto:aeris.ogsteam@gmail.com>Aéris</a> &copy;2006</font></div>
<div align=center><font size=2>Adapté pour SpacSpy par Mirtador &copy;2006</font></div>

<?php
require_once("views/page_tail.php");
?>

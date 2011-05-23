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
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

require_once("views/page_header.php");
require_once("menu.php");

$ally = $_POST['ally'];
$univers = $_POST['univers'];
$classement = $_POST['classement'];

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

      //Les bbcodes pour Forum avec quote et code
	$bbcode = "[code]Alliance: [$ally] \n";
      $bbcode .= "Univers: [$univers]\n";
	$bbcode .= $query_ally[$key]["general"]["points"]." points (".$query_ally[$key]["general"]["rank"]."ème) au général\n".$query_ally[$key]["fleet"]["points"]." points (".$query_ally[$key]["fleet"]["rank"]."ème) en flotte\n".$query_ally[$key]["research"]["points"]." points (".$query_ally[$key]["research"]["rank"]."ème) en recherches\n".$query_ally[$key]["number_member"]." membres [/code] \n\n";
	$bbcode .= "[quote][color=cyan][b]Joueur[/b] [/color][color=yellow][b]points (Place)[/b][/color][color=red] [b]vaisseaux (Place)[/b][/color][color=white] [b]recherches (Place)[/b][/color]";
      
      //Les bbcodes pour Forum sans quote et code
      $bbcode8 = "[b]Alliance:[/b][color=red][b] $ally [/b][/color]\n";
      $bbcode8 .= "[b]Univers:[/b][color=red][b] $univers [/b][/color]\n";
	$bbcode8 .= $query_ally[$key]["general"]["points"]." points (".$query_ally[$key]["general"]["rank"]."ème) au général\n".$query_ally[$key]["fleet"]["points"]." points (".$query_ally[$key]["fleet"]["rank"]."ème) en flotte\n".$query_ally[$key]["research"]["points"]." points (".$query_ally[$key]["research"]["rank"]."ème) en recherches\n".$query_ally[$key]["number_member"]." membres \n\n";
	$bbcode8 .= "[color=cyan][b]Joueur[/b] [/color][color=yellow][b]points (Place)[/b][/color][color=red] [b]vaisseaux (Place)[/b][/color][color=white] [b]recherches (Place)[/b][/color]";
      require_once("tooltip.php");
	$coord .= "<tr><th><a href=index.php?action=search&type_search=player&string_search=$joueur>$joueur</a></th><th>";
	$bbcode2 .="[color=$couleur][b] $joueur [/b]";
	$bbcode3 .="[color=$couleur][b] $joueur [/b]\n";
	while ( $val = $db->sql_fetch_assoc($result) )
	{
		$joueur = $val['joueur'];
		$pp = $val['pp'];
		$pr = $val['pr'];
		$fp = $val['fp'];
		$fr = $val['fr'];
		$rp = $val['rp'];
		$rr = $val['rr'];
            
		if ( $pp <> '' ) { $points = "$pp ($pr)"; } else { $points = '&nbsp;'; }
		if ( $fp <> '' ) { $flotte = "$fp ($fr)"; } else { $flotte = '&nbsp;'; }
		if ( $rp <> '' ) { $recherche = "$rp ($rr)"; } else { $recherche = '&nbsp;'; }
		
		$linkPlayer = str_replace(" ", "%20", $joueur); // On crée une chaine pour faire le liens vers la recherche sur le joueur
            if ( $points <> '&nbsp;' || $flotte <> '&nbsp;' || $recherche <> '&nbsp;' )
      {
		$texte .= "<tr><th><a href=index.php?action=search&type_search=player&string_search=$linkPlayer>$joueur</a></th><th>$points</th><th>$flotte</th><th>$recherche</th><th>$univers</th></tr>\n";
            $bbcode .= "\n[color=cyan]".$joueur." [/color][color=yellow]".$points." [/color][color=red]".$flotte." [/color][color=white]".$recherche."[/color]";
		$bbcode8 .= "\n[color=cyan]".$joueur." [/color][color=yellow]".$points." [/color][color=red]".$flotte." [/color][color=white]".$recherche."[/color]";
      }
	}
	
	$texte .= "</table>\n";
	$bbcode .= "[/quote]\n\n BBcode Via le module OGspy Script By [color=red][b]Aéris[/b][/color] Modifier By http://lgc.kazylax.net Par [color=red][b]Kazylax[/b][/color]";
	$bbcode8 .= "\n\nBBcode Via le module OGspy Script By [color=red][b]Aéris[/b][/color] Modifier By http://lgc.kazylax.net Par [color=red][b]Kazylax[/b][/color]";

	$query = "SELECT DISTINCT player ";
	$query .= "FROM ".TABLE_UNIVERSE." ";
	$query .= "WHERE ally='".mysql_real_escape_string($pub_ally)."' ";
	$query .= "ORDER BY player";
		
	$result = $db->sql_query($query);

	$coord = "<table border=1 cellpadding=5>\n";
      $coord .= "<br><br>\n";
      $coord .= "<tr><td colspan=2 align=center class=c><b>BBcode pour Forum</b></td></tr>\n";
      $coord .= "<tr><td colspan=2 align=center class=c><b><a href=javascript:inverse('bbcode1');afficheVer();><b><font color='#FFFFCC'>Code forum</font></b></a></b></td></tr>\n";
	$coord .= "<tr><td align=center class=c>Joueur</td><td align=center class=c>Coordonnées<br></td></tr>";

	$bbcode2 = "Alliance [$ally]\n\n";
	$bbcode3 = "Alliance [$ally]\n\n";
	
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
		$bbcode3 .="[color=$couleur]$joueur";
		
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
			$moon = $val1['moon'] ? ' [Lune]' : '';

			$coord .= "<a href=index.php?action=galaxy&galaxy=$galaxie&system=$systeme>[$galaxie:$systeme:$position]$moon</a><br>";
			$bbcode2 .= "\n[$galaxie:$systeme:$position]$moon";
			$bbcode3 .= "[$galaxie:$systeme:$position]$moon";
		}
	}
	
	$coord .= "</th></tr>\n";
	$coord .= "</table>";
	$bbcode2 .= "[/color]\n\nBBcode Via le module OGspy Script By [color=red][b]Aéris[/b][/color] Modifier By http://lgc.kazylax.net Par [color=red][b]Kazylax[/b][/color]";
	$bbcode3 .= "[/color]\n\nBBcode Via le module OGspy Script By [color=red][b]Aéris[/b][/color] Modifier By http://lgc.kazylax.net Par [color=red][b]Kazylax[/b][/color] ";
		
//	echo $query;
	
} else {
	$texte = '';
	$bbcode = '';
	$bbcode2 ='';
	$bbcode3 = '';
      $bbcode8 = '';
}

?>
<table>
<form method=post>
<tr><td align=right>
                <tr><td colspan=2 align=center class=c><p align="center">Tag de l'alliance:</td><td align=left>
                <tr><td colspan=2 align=center class=c><p align="center"><input name=ally value=<?php echo $ally; ?> ></td></tr>
<tr><td colspan=2>

<tr><td colspan=2 align=center class=c><p>Classer par:<input type=radio name=classement value=joueur <?php if ( $classement == 'joueur' ) { echo "checked"; } ?> >nom<input type=radio name=classement value=pp <?php if ( !isset( $classement ) || ( $classement == 'pp' ) ) { echo "checked"; } ?> >points<input type=radio name=classement value=fp <?php if ( $classement == 'fp' ) { echo "checked"; } ?> >flotte<input type=radio name=classement value=rp <?php if ( $classement == 'rp' ) { echo "checked"; } ?> >recherches</td></tr>
<tr><td colspan=2 align=center>
                <tr><td colspan=2 align=center class=c><p align="center">Choisissez l'univers: <select name="univers" size="1">
                <option value="Choisissez votre Univers">Univers</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
		<option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
		<option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
		<option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
		<option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
		<option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
                <option value="32">32</option>
                <option value="33">33</option>
                <option value="34">34</option>
                <option value="35">35</option>
                <option value="36">36</option>
		<option value="37">37</option>
                <option value="38">38</option>
                <option value="39">39</option>
                <option value="40">40</option>	
		<option value="41">41</option>
                <option value="42">42</option>
                <option value="43">43</option>
                <option value="44">44</option>
		<option value="45">45</option>
                <option value="46" selected>46</option>
                <option value="47">47</option>
                <option value="48">48</option>
                <option value="49">49</option>
                <option value="50">50</option>
                <option value="51">51</option>
                <option value="52">52</option>
		<option value="53">53</option>
                <option value="54">54</option>
                </select></td></tr>
<tr><td colspan=2 align=center>
                <p align="center"><input type=submit value="Rechercher"></td></tr></form>
<?php 
echo "<br>";
?>
</table>
<?php

if ( isset( $pub_ally ) )
{
	echo "<table>\n";
      echo "<td valign=top>$coord</td><td valign=top>";
	echo "<div id=bbcode1 style='display:none;'><table><tr><td align=center>Disposition</td></tr><tr><td align=center>Verticale<input type=radio name=dispo checked onclick=javascript:afficheVer();>Horizontale<input type=radio name=dispo onclick=javascript:afficheHor();></td></tr><tr><td align=center><div id=horizontale style='display:none;'><textarea name=coords cols=50 rows=20 readonly>$bbcode3</textarea></div><div id=verticale style='display:none;'><textarea name=coords cols=50 rows=20 readonly>$bbcode2</textarea></div></div></td></tr></table></td></tr>\n";
	echo "</table>";

}
?>

<?PHP
require_once("copy.php");
?>

<?php
require_once("views/page_tail.php");
?>

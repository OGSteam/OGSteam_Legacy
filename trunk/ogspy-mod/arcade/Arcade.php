<?php
/**
* Module OGSpy reprenant le Pack Games de Neave http://www.neave.com/games/
* @package Arcade
* @author ericalens <ericalens@ogsteam.fr> 
* @link http://www.ogsteam.fr
* @version 2.1
*/

// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Est-ce que le mod est actif ?
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='Arcade' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

require_once("mod/arcade/arcade_functions.php");

$game_title='';

function OutputArcadeCSS(){//{{{ 
?>

<style type="text/css">
<!--
.arcademenu {
	margin-left: auto;
	margin-width: auto;
	width: 90%;
	clear: both;
}
.arcadegame {
}
.arcadegameswf {
	display:inline;
	position:relative;
	left: 1;
	top: 1;
	padding: 0 0 ;
	background: transparent;
	float: left;
}

.arcadeheader {
	padding: 0 0 ;
	background: transparent;
	float: left;
}
.arcadegameheader {
	background: black;
	border: 1 double blue;
	color: #FFCCFF;
	font-size: 1.4em;
	float:left;
	clear:right;
	text-align:left;
}
.arcadegameheader img {
	width: 48;
	height: 48;
	border: none;
}
.headersmall{
	display: inline;
	background: black;
	font-size: 0.6em;
	color: #00FF77;
	text-align:center;
}
.arcadecenter {
	padding: 0 2 ;
	background: transparent;
}
.arcadeadmin {
	display: inline;
	background: #999999;
	color: #BB0000;
	text-align:center;
/*	width: 100%*/
}
.arcadeadmin a {
/*	padding: 2 2 2 2;
	margin: 2 2 2 2;*/
	color: #BB2222;
/*	width:100%;*/

}
.arcadeadmin a:hover {
	color: #FF0000;
	background:#FFCC33;
	border-width: 1px;
	border-style: solid;
	border-color: white blue;
	margin: 0 0 0 0;

}
.logocenter {
	
}
.arcadeannounce {
	font-size : 15px;
	text-align: left;
	color: #FFCC33;
	background: #333399;
	padding: 5 5 5 5 ;
	width: 100%;
}
.warning {
	color: #FF3333;
	background: black;
	border: 1px solid #FFFFFF;
	padding: 3 8 3 8;
}
.left {
	display: inline;
	float: left;
}
.right {
	float: right;
}
img.centered {
float: left;
   display: block;
   margin-left: auto;
   margin-right: auto;
   text-align:center;
}
.arcadeinput input {
	background: #CCFFFF;
	color: black;
}
.arcadeonline {
	float: left;
	text-indent:0;	
	width: 14em;
	padding: 8px 8px 2px 1px;
	margin-right: 15px;
	font-family: 'Trebuchet MS', 'Lucida Grande',
		 Verdana, Lucida, Geneva, Helvetica, 
		 Arial, sans-serif;
	font-size: 9px;
	background-image: url('./mod/arcade/pics/menugauche.jpg');
	color: #5588FF;
	text-align: left;
	border: thin #FFFFFF;
}
.arcadeonline h1,h1 a {
	text-align: left;
	border-bottom: thin  #FF0000 outset;
	padding: 2 2 2 2;
	margin: 2 2 2 2;
	color: #AAAAFF;
	background:#1111AA;
	width:100%;

}
.arcadeonline ul {
	text-align:left;
	list-style: none;
	margin: 0 0 0 0;
	padding: 0 0 0 0;
}
.arcadeonline  a {
	overflow:hidden;
	font-size: 0.8em;
}
.arcadeonline  a:hover {
	background: #FFFFFF;
	color: #000000;
}

.arcadeonline * li {
	overflow: hidden;
/*	display: inline;*/
	margin-left: 0;
	padding: 0;
	margin: 0 0 0 0;
	text-align: left;
	color: #FF7777;
/*	border-bottom: 1px #FF0000;*/
}
-->
</style>
<?php
}//}}}

/**
* ShowArcadeMenu2() : Affiche l'entete/menu du mod Arcade {{{
*/
function ShowArcadeMenu2(){
	global $db,$server_config,$is_guestarcade;
	$div="&nbsp;|&nbsp;";

	$result=$db->sql_query("SELECT count(*) as nbre_jeux ,sum(playcount) as played FROM ogspy_arcade_game");
	$row=$db->sql_fetch_assoc($result);
	$nbre_jeux=$row["nbre_jeux"];
	$scores_soumis=$row["played"];

	$result=$db->sql_query("SELECT count(*) as nbre_scores FROM ogspy_arcade");
	$row=$db->sql_fetch_assoc($result);
	$nbre_scores=$row["nbre_scores"];
	OutputArcadeCSS();
	echo "<table class=arcademenu >\n<tr><td width=92 valign=top>\n";
	echo "\t<div class=left><a href='http://ogsteam.fr'><img  src='mod/arcade/pics/logo90x90.jpg'></a>\n";
	
	echo "\t</div>\n";
	echo "</td><td>\n";
	echo "\t<div class='arcadeheader'>\n";

	echo "\t<table width=100%>\n";
	echo "\t<tr>\n\t\t<th>";
	echo "\n\t\t\t<img class='right' src='mod/arcade/pics/logo.jpg'>\n\t\t\t<p class=left > Stats: $nbre_jeux Jeux, jouées $scores_soumis fois, $nbre_scores Scores\n\t\t</p></th>\n\t</tr>\n";
	global $server_config;
	echo "\t<tr>\n<td class='c'>[&nbsp; \n";
	echo "\t<a href='"._ARCSA_."'>Alphabétique</a>$div\n";
	echo "\t<a href='"._ARCSA_."list&amp;sort=played'>Les + joués</a>$div\n";
	echo "\t<a href='"._ARCSA_."list&amp;sort=score'>Derniers Scores</a>$div\n";
	echo "\t<a href='"._ARCSA_."list&amp;sort=highscore'>Derniers HighScores</a>$div\n";
	echo "\t<a href='"._ARCSA_."list&amp;sort=gameadded'>Jeux récents</a>$div\n";
	echo "\t<a href='"._ARCSA_."list&amp;sort=champions'>Les Champions</a>\n";
	echo "&nbsp;]\n</td></tr>\n";


	global $db;
	if (!empty($server_config["arcade_announce"])){
		echo "<tr><td class=arcadeannounce>\n".$server_config["arcade_announce"]."\n</td></tr>\n";
	}

	if ($server_config["arcade_dontforcename"]=="1") {
		echo "<tr><td>\n";
		ShowCookieNameForm();
		echo "</td></tr>\n";
	}

	echo "</table>\n";
	echo "</div>\n";
	echo "</td></tr></table>\n";

}//}}}

/**
* ShowOnlinePlayers() : Affiche un bloc de joueurs Online {{{
*/
function ShowOnlinePlayers(){

	global $server_config,$db,$is_guestarcade,$user_data;

	$query="SELECT s.*,g.name,g.scorename FROM ogspy_arcade_online s LEFT JOIN ogspy_arcade_game g on g.id=s.gameid  WHERE statustime>".(time()-60*$server_config['arcade_onlinmins'])." ORDER by statustime desc";

	echo "<div class='arcadeonline'>\n";
	if ($server_config['arcade_fullscreen']=='1') {
		echo "<h1>Menu</h1>\n";
		echo "<ul>\n";
			if($user_data["user_admin"] == 1 || ($server_config["arcade_coadminenable"]=="1" && $user_data["user_coadmin"]==1)) {
		echo "<li><a href='index.php?action=Arcade&amp;subaction=Admin'>Panneau Admin</a></li>\n";
		}
	
		if ($is_guestarcade==false  )	echo "\t\t<li><a href='index.php'>Retour OGSpy</a></li>\n";
		echo "\t\t<li><a href='index.php?action=logout'>Logout</a></li>\n";
		echo "</ul>\n";
		echo "<hr align=center width=40%>\n";
	}
	$result=$db->sql_query($query);
	if ($db->sql_numrows()>0) {
		echo "\t<h1>Online (".$db->sql_numrows().")</h1>\n<ul>\n";
		while ($row=$db->sql_fetch_assoc($result)){
			if (!empty($row['scorename'])) {
				echo "\t<li>".$row["playername"]."(<a href='index.php?action=Arcade&amp;subaction=play&amp;gamename=".$row['scorename']."' title=\"".$row["name"]."\">".$row["name"]."</a>)</li>";
			} else {
				echo "\t<li>".$row["playername"]."(ne joue pas)</li>";
			}
		}
	} else {
		echo "\t<li>Personne ne joue actuellement.\n";
	}
	echo "</ul>\n";
	echo "<hr align=center width=40%>\n";

	echo "<h1><a href='index.php?action=Arcade&subaction=list&sort=highscore'>Highscores</a></h1>\n";
	$query="SELECT * FROM ogspy_arcade_game WHERE highscore<>0 ORDER BY highscoredate desc limit 5";
	$result=$db->sql_query($query);
	echo "<ul>\n";
	while ($row=$db->sql_fetch_assoc($result)) {
		echo "\t<li>".$row["highscoreplayer"]." (<a href='index.php?action=Arcade&subaction=play&gamename=".$row["scorename"]."'>".FormatScore($row["highscore"])." sur ".$row["name"]."</a>)</li>\n";
	}
	echo "</ul>\n";

	echo "<hr align=center width=40%>\n";
	echo "<h1><a href='index.php?action=Arcade&subaction=list&sort=champions'>Champions</a></h1>\n";
	
	$query="SELECT count(id) as nb_highscore,highscoreplayer FROM ogspy_arcade_game where highscore<>0 group by highscoreplayer ORDER by nb_highscore desc limit 5" ;
	$result=$db->sql_query($query);
	$place=1;
	echo "<ul>\n";
	while ( $row = $db->sql_fetch_assoc($result) ) {

		echo "\t<li>$place.".PlayerShowGamesLink($row["highscoreplayer"])." <span style='text-align:right'>(".$row["nb_highscore"].")</span></li>\n";
		$place=$place+1;	
	}
	echo "</ul>";

	echo "<hr align=center width=40%>\n";
	echo "<h1><a href='index.php?action=Arcade&subaction=list&sort=score'>Derniers Scores</a></h1>\n";
	$query="SELECT sc.* ,g.name from ogspy_arcade sc "
		."LEFT JOIN ogspy_arcade_game g ON g.scorename=sc.gamename "
		."ORDER by sc.scoredate desc limit 5";
	$result=$db->sql_query($query);
 	echo "<ul>\n";
	while ( $row = $db->sql_fetch_assoc($result) ) {

		echo "\t<li>.".PlayerShowGamesLink($row["playername"])." ( ".FormatScore($row["score"])." sur <a href='index.php?action=Arcade&amp;subaction=play&amp;gamename=".$row["gamename"]."'>".$row["name"]."</a>)</li>";
	}
	echo "</ul>";

	echo "<hr align=center width=40%>\n";
	echo "<h1><a href='index.php?action=Arcade&subaction=list&sort=gameadded'>Derniers Jeux</a></h1>\n";
	$query="SELECT scorename,name FROM  ogspy_arcade_game ORDER by id desc limit 5";
	$result=$db->sql_query($query);
 	echo "<ul>\n";
	while ( $row = $db->sql_fetch_assoc($result) ) {

		echo "\t<li>.<a href='index.php?action=Arcade&amp;subaction=play&amp;gamename=".$row["scorename"]."'>".$row["name"]."</a></li>";
	}
	echo "</ul>";
	echo "\n</div>";

}//}}}
/**
* Affichage du formulaire de saisie du nom par defaut {{{
*/
function ShowCookieNameForm(){
	echo "\n<div class=arcadeheader >\n";
	echo "\t<form action='index.php?action=Arcade&amp;subaction=name' method='post'>Nom Joueur:<input type='text' name=defname value='".$_COOKIE["arcadename"]."'><input type=submit value='ok'>";
	if (empty($_COOKIE["arcadename"])){
		echo "<span class=warning>Attention rempli ce nom avant de jouer</span>\n";
	}
	echo "</form>\n</div>\n";
}//}}}

/**
*
*/
function ShowTournamentInfo() {

}

/**
* ShowArcadeMenu() : Affiche l'entete/menu du mod Arcade {{{
*/
function ShowArcadeMenu(){
	global $db,$server_config;
	$div="&nbsp;|&nbsp;";

	$result=$db->sql_query("SELECT count(*) as nbre_jeux ,sum(playcount) as played FROM ogspy_arcade_game");
	$row=$db->sql_fetch_assoc($result);
	$nbre_jeux=$row["nbre_jeux"];
	$scores_soumis=$row["played"];

	$result=$db->sql_query("SELECT count(*) as nbre_scores FROM ogspy_arcade");
	$row=$db->sql_fetch_assoc($result);
	$nbre_scores=$row["nbre_scores"];
//	OutputArcadeCSS();
	echo "<div class=arcademenu><table>";

	echo "<tr><th class='b'>Salut ".GetUserName()."!! Stats: $nbre_jeux Jeux avec $nbre_scores Scores inscrits, et $scores_soumis scores soumis</th></tr>\n";
	global $server_config;
	if (!empty($server_config["arcade_announce"])){
		echo "<tr><td class='k'>".$server_config["arcade_announce"]."</td></tr>\n";
	}
	echo "<tr><td class='c'>[&nbsp;Voir les jeux :  \n";
	echo "<a href='"._ARCSA_."'>Alphabétique</a>$div\n";
	echo "<a href='"._ARCSA_."list&amp;sort=played'>Joués</a>$div\n";
	echo "<a href='"._ARCSA_."list&amp;sort=score'>Derniers Scores</a>$div\n";
	echo "<a href='"._ARCSA_."list&amp;sort=highscore'>Derniers HighScores</a>$div\n";
	echo "<a href='"._ARCSA_."list&amp;sort=gameadded'>Jeux récents</a>$div\n";
	echo "<a href='"._ARCSA_."list&amp;sort=champions'>Les Champions</a>\n";
	echo "&nbsp;]</td></tr>\n";
	global $db;
	echo "<tr><td class='c'>Joueurs:\n";
	$query="SELECT s.*,g.name,g.scorename FROM ogspy_arcade_online s LEFT JOIN ogspy_arcade_game g on g.id=s.gameid  WHERE statustime>".(time()-60*$server_config['arcade_onlinmins']);
	$result=$db->sql_query($query);
	if ($db->sql_numrows()>0) {
		while ($row=$db->sql_fetch_assoc($result)){
			echo $row["playername"]."(<a href='index.php?action=Arcade&amp;subaction=play&amp;gamename=".$row['scorename']."'>".$row["name"]."</a>)&nbsp;";
		}
	} else {
		echo "Personne ne joue actuellement.\n";
	}
	echo "</td></tr></table>\n";
	echo "</div>";

}//}}}

/**
* ShowList Affichage de listes d'informations sur les joueurs et les jeux {{{
*/
function ShowList(){
global $db,$pub_sort;
$WidthHeight=48;
echo "<div class=arcadecenter>\n";
if ($pub_sort=='champions') {
	ShowChampions();
}else if ($pub_sort=='score') {

	$query="SELECT sc.* ,g.image,g.swfname,g.name from ogspy_arcade sc "
		."LEFT JOIN ogspy_arcade_game g ON g.scorename=sc.gamename "
		."ORDER by sc.scoredate desc limit 30";
	$result=$db->sql_query($query);

	echo "<table>\n"
		."\t<tr><th colspan=4>Derniers scores soumis</th></tr>\n";
	while ($row=$db->sql_fetch_assoc($result)){
		echo "\t<tr>";
		echo "\t\t<td><a href='index.php?action=Arcade&amp;subaction=play&amp;gamename=".$row["gamename"]."'><img src='mod/Arcade/pics/".$row["image"]."' width=".arcWidthHeight." height=".arcWidthHeight." border=0></td>";
		echo "\t\t<td class='c'>".date("d.m H:i:s",$row["scoredate"])."</td>\n";
		echo "\t\t<td class='c'width=300><a href='index.php?action=Arcade&amp;subaction=play&amp;gamename=".$row["gamename"]."'>".$row["name"]."</a><br>".stripslashes($row["comment"])."</td>\n";
		echo "\t\t<td class='l' >".FormatScore($row["score"])."<br/> par ".$row["playername"]."</td>\n";
		echo "\t</tr>\n";
	}
	echo "</table>\n";
}else if ($pub_sort=='highscore') {
	$query="SELECT * FROM ogspy_arcade_game WHERE highscore<>0 ORDER BY highscoredate desc limit 30";

	$result=$db->sql_query($query);
	echo "<table>\n";
	echo "<tr><th colspan=5>Derniers Highscores</th></tr>\n";
	while ($row=$db->sql_fetch_assoc($result)){
		echo ShowGameFromRow($row)."\n";
	}
	echo "</table>\n";
}else if ($pub_sort=='played') {
	$query="SELECT * FROM ogspy_arcade_game WHERE playcount<>0 ORDER BY playcount desc limit 10";

	$result=$db->sql_query($query);
	echo "<table>\n";
	echo "<tr><th colspan=6>Jeux les plus joués</th></tr>\n";
	while ($row=$db->sql_fetch_assoc($result)){
		echo ShowGameFromRow($row)."\n";
	}
	echo "</table>\n";
}else if ($pub_sort=='gameadded') {
	$query="SELECT * FROM ogspy_arcade_game ORDER BY id desc limit 10";

	$result=$db->sql_query($query);
	echo "<table>\n";
	echo "<tr><th colspan=5>Derniers jeux ajoutés</th></tr>\n";
	while ($row=$db->sql_fetch_assoc($result)){

		echo ShowGameFromRow($row)."\n";
	}
	echo "</table>\n";
}else {
	echo "<h1>Liste non implémenté</h1>\n";
}
echo "</div>\n";
}//}}}

/**
* ShowGames: Affichage de la liste des jeux disponible {{{
*/
function ShowGames($order='name') {

	global $db,$pub_start,$pub_limit,$server_config,$user_data,$pub_filter;
	$WidthHeight=48;
	$start=(intval($pub_start)>0 ? intval($pub_start):0);
	$limit=(intval($pub_limit)>0 ? intval($pub_limit):20);

	$query="SELECT * FROM `ogspy_arcade_game`";
	
	if (!empty($pub_filter)) {
		$query .=" WHERE name like '%".mysql_real_escape_string($pub_filter)."%' or description like '%".mysql_real_escape_string($pub_filter)."%'";
	}
	if (!empty($order)) $query .=" ORDER BY $order";
	$query .=" LIMIT $start,$limit";

	$result=$db->sql_query($query);
	$numrows=$db->sql_numrows();
	if ($numrows==0) {
		echo "<h2>Pas de jeux sur cette page...!!</h2>\n";
		return;
	}
	if ( $order == 'name' ) {
		echo "\n<table border=1><tr><td><a href='#'>Tous</a></td><td><a href='#'>ShootEm Up</a></td><td><a href='#'>Réflexion</a></td><td><a href='#'>Sports</a></td></tr></table>";
	}
	echo "<div class='arcadecenter'><table >\n";
	echo "\t<tr><th colspan='4'>\n";
	echo "<table border=0 width=100%><tr>\n";
	echo "\t<th width=30>\n";
	if ($start>0) {
		$prevstart=$start-$limit;
		if ($prevstart<0) $prevstart=0;
	echo "<a href='index.php?action=Arcade&amp;start=$prevstart'>&lt;&lt;</a>";	
	}else echo "&nbsp;";
	echo "\n\t</th>\n";
	echo "\t<td class='a'><img class='centered' src='mod/arcade/pics/logo.jpg'><div class=left><form class=arcadeinput action='index.php?action=Arcade&amp;subaction=filter' method=post>Filtrer sur le nom: <input type='text' name='filter' value='$pub_filter'><input type='submit' value='Filtre'></form></div></td>\n";
	echo "\t<th width=30>\n";
	if ($limit==$numrows) {
		echo "\t\t<a href='index.php?action=Arcade&amp;start=".intval($start+$numrows)."'>&gt;&gt;</a>";

	} else	echo "\t\t&nbsp;";
	echo "\t</th>\n";
	echo "</tr></table>\n";
	echo "</th></tr>\n";

	while ($game=$db->sql_fetch_assoc($result)) {
			echo ShowGameFromRow($game)."\n";
	}
	echo "\t<tr><th colspan='4'><table border=0 width=100%><tr>";
	echo "\t<th width=30>\n";
	if ($start>0) {
		$prevstart=$start-$limit;
		if ($prevstart<0) $prevstart=0;
	echo "<a href='index.php?action=Arcade&amp;start=$prevstart'>&lt;&lt;</a>";	
	}else echo "&nbsp;";
	echo "\t</th>\n";
	echo "\t<td class='a'><form action='index.php?action=Arcade&amp;subaction=filter' method=post><input type='text' name='filter' value='$pub_filter'><input type='submit' value='Filtre'></form></td>\n";
	echo "\t<th width=30>\n";
	if ($limit==$numrows) {
		echo "<a href='index.php?action=Arcade&amp;start=".intval($start+$numrows)."'>&gt;&gt;</a>";

	} else	echo "&nbsp;";
	echo "\t</th></tr></table></th></tr>\n";
	echo "</table></div>\n";
}//}}}

/**
* ShowGameScores Affiche la table des scores d'un jeu donné {{{
*/
function ShowGameScores(){
	global $db,$pub_gamename,$game_title;
	if (empty($game_title))$game_title=$pub_gamename;

	echo "<tr><th colspan=4>Highscores de $game_title</th></tr>";
	
	$query="SELECT * FROM ogspy_arcade WHERE gamename like '".mysql_real_escape_string($pub_gamename)."' ORDER BY score desc,id asc";
	$result=$db->sql_query($query);
	$place=1;

	while ($row=$db->sql_fetch_assoc($result)){
		if ($place==1) {
			echo "<tr><td class='c' colspan=4>".stripslashes($row["comment"])."&nbsp;</td></tr>";
		}
		echo "<tr><th>$place</th><td >".date("d.m H:i:s",$row["scoredate"])."</td><th valign=center>";
		if ($place==1) echo _img_1st_;
		if ($place==2) echo _img_2nd_;
		if ($place==3) echo _img_3rd_;

		echo $row["playername"]."</th><td class='b'>".FormatScore($row["score"])."</td></tr>\n";
		$place=$place+1;
	}
} //}}}

/**
* ShowPlayPage : Affichage de la page de jeu {{{
*/
function ShowPlayPage(){

	global $db,$pub_gamename;
	global $game_title;

	$query="SELECT * FROM `ogspy_arcade_game` WHERE `scorename`='".$pub_gamename."' LIMIT 1";

	$result=$db->sql_query($query);

	if (!$game=$db->sql_fetch_assoc($result)){
		echo "Erreur: Mauvais identificateur de jeu";
		die();
	}
	echo "<div class=arcadeheader>";
	echo "<table><tr><td>";
	echo "<div class=arcadegameheader style='width: ".$game["width"]."px;'>\n";
	echo "<div class=left><img src='./mod/arcade/pics/".$game["image"]."'></div>\n";
	echo $game["name"]."<br>\n";
	echo "\t<span class=headersmall>".stripslashes($game["description"])."</span>\n";
	echo "</div>\n";
	echo "</td></tr><tr><td>";
	echo "<div class=arcadegameswf style='width: ".$game["width"]."px;height: ".$game["height"]."px;'>\n";
?>
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" width="<?php echo $game["width"];?>" height="<?php echo $game["height"];?>">
		<param name="movie" value="mod/arcade/games/<?php echo $game["swfname"];?>">
		<param name="bgcolor" value="<?php echo $game["backcolor"];?>">
		<param name="quality" value="high">
		<param name="menu" value="false">
		 <embed src="mod/arcade/games/<?php echo $game["swfname"];?>" width="<?php echo $game["width"];?>" height="<?php echo $game["height"];?>" bgcolor="<?php echo $game["backcolor"];?>" quality="high" menu="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer/"></embed>
		 <noembed>Sorry, you will need the <a href="http://www.macromedia.com/go/getflashplayer/" target="_blank">Flash Player</a> to play Pac-Man.</noembed>
	</object>
<?php
	echo "</div>";//arcadegameswf
	echo "</td></tr></table>";
	echo "</div>";//arcadegame

	$query="REPLACE INTO ogspy_arcade_online "
		."(playername,statustime,gameid) "
		."VALUES ('".mysql_real_escape_string(GetUserName())."','".time()."','".$game["id"]."');";
	$db->sql_query($query);	
	$game_title=$game["name"];
	$query3="UPDATE ogspy_arcade_game SET playcount=playcount+1 WHERE scorename ='$pub_gamename'";
	$db->sql_query($query3);
}//}}}

/**
* ShowChampions : Affichage des meilleurs joueurs {{{
*/

function ShowChampions() {

	global $db;

	$query="SELECT count(id) as nb_highscore,highscoreplayer FROM ogspy_arcade_game where highscore<>0 group by highscoreplayer ORDER by nb_highscore desc" ;
	$result=$db->sql_query($query);

	echo "<table>\n";
	echo "\t<tr><th colspan='4'>";
	echo "\tListe des meilleurs joueurs</th></tr>\n";
	$place=1;
	while ( $row = $db->sql_fetch_assoc($result) ) {

		echo "\t<tr><th>$place</th><td class='c'>".PlayerShowGamesLink($row["highscoreplayer"])."</td><td class=k>".$row["nb_highscore"]."</td></tr>\n";
		$place=$place+1;	
	}
	echo "</table>";
}//}}}

function ShowGamesFor($player){//{{{ Affichage des jeux menés par un champion
	global $db;

	$query="SELECT * from ogspy_arcade_game where highscoreplayer='".mysql_real_escape_string($player)."'";
	$result=$db->sql_query($query);
	echo "<table class=arcadecenter>\n";
	echo "<tr><th colspan=4>Liste des jeux dont $player est le top 1</th></tr>\n";
	echo "\t<tr><th colspan='4'><table border=0 width=100%>\n";

	while ($game=$db->sql_fetch_assoc($result)) {
		echo ShowGameFromRow($game)."\n";
	}
	echo "</table>\n";
}//}}}
/**
* Insére le commentaire du joueur pour un score d'un jeu
*/
function SetComment() {
	global $pub_message,$pub_gamename,$db;
	$query = " SELECT count(*) FROM "._TABLE_ARCADE_." WHERE gamename='".mysql_real_escape_string($pub_gamename)."' and "
		."playername = '".mysql_real_escape_string(GetPlayerName())."'";
	$result = $db->sql_query($query);
	if (list($scoreexist) = $db->sql_fetch_row($result) and $scoreexist>0){
		$query = "UPDATE "._TABLE_ARCADE_." SET comment='".mysql_real_escape_string($pub_message)."' "
			."WHERE gamename='".mysql_real_escape_string($pub_gamename)."' and "
			."playername = '".mysql_real_escape_string(GetPlayerName())."'";
		$db->sql_query($query);			

	}
	redirection("?action=Arcade&subaction=play&gamename=$pub_gamename");
}
//---------------------------------------------------------------------//
/**
* Cookie pour le nom temporaire du joueur{{{
*/
if ($pub_subaction=="name") {
		setcookie("arcadename",$pub_defname,time()+3600*24*365);
		$_COOKIE["arcadename"]=$pub_defname;
}//}}}

/**
* Initialisation
*/
if (!empty($pub_gamename)){
	$pub_gamename=str_replace("\'","''",urldecode($pub_gamename));
	$pub_gamename = preg_replace(array('#&(?!(\#[0-9]+;))#', '#<#', '#>#'), array('&amp;', '&lt;', '&gt;'),$pub_gamename);
}

// Interception des Actions
// Verification commande admin {{{
if($user_data["user_admin"] == 1 || ($server_config["arcade_coadminenable"]=="1" && $user_data["user_coadmin"]==1)) {
  switch($pub_subaction) {
	case "Admin":
		require_once("views/page_header.php");
		include_once("mod/arcade/arcade_admin.php");
		exit();
		break;

  }
}//}}}
$banner_selected='';
require_once("./mod/arcade/arcade_header.php");


//Interception des subactions utilisateurs {{{
	if ($pub_subaction!=="play"){
		$query="REPLACE INTO ogspy_arcade_online "
			."(playername,statustime,gameid) "
			."VALUES ('".mysql_real_escape_string(GetUserName())."','".time()."','0');";
		$db->sql_query($query);	
	}
switch ($pub_subaction) {
	case "showgamesfor":
		ShowOnlinePlayers();
		ShowGamesFor($pub_player);
		break;
	case "play":
		ShowOnlinePlayers();
		ShowPlayPage();
		echo "<table class=arcadecenter>";
		if($user_data["user_admin"] == 1 || ($server_config["arcade_coadminenable"]=="1" && $user_data["user_coadmin"]==1)) {
		echo "<tr><td colspan=4 class=arcadeadmin><a href='index.php?action=Arcade&amp;subaction=Admin&amp;command=editgame&amp;game=".$pub_gamename."'>Modifier les options de ce jeu</a></td></tr>";
		}
		ShowGameScores();
		echo "</table>";
		break;
	case "play2":
		echo "<table><tr><td valign='top'>";
		ShowPlayPage();
		echo "</td><td>";
		echo "<table width=300>";
		if($user_data["user_admin"] == 1 || ($server_config["arcade_coadminenable"]=="1" && $user_data["user_coadmin"]==1)) {
		echo "<tr><td colspan=4><a href='index.php?action=Arcade&amp;subaction=Admin&amp;command=editgame&amp;game=".$pub_gamename."'>Modifier les options de ce jeu</a></td></tr>";
		}
		echo "<tr><th colspan=4>Highscores de $pub_gamename</th></tr>";
		ShowGameScores();
		echo "</table>";

		echo "</td></tr></table>";
		break;
	case "list":
		ShowOnlinePlayers();
		ShowList();
		break;
	case "comment":
		ShowOnlinePlayers();
		require_once("./mod/arcade/arcade_comment.php");
		break;
	case "setcomment":
		SetComment();
/*		die("$pub_message,$pub_gamename,".GetPlayerName());
		ShowOnlinePlayers();
		require_once("./mod/Arcade/arcade_comment.php");*/
		break;
	default:
		ShowOnlinePlayers();
		ShowTournamentInfo();
		ShowGames();
		break;
}//}}}

// Menu supplémentaire admin {{{
if($user_data["user_admin"] == 1 ) {
	if ($server_config['arcade_fullscreen']!=='1'){//On ne l'affiche que si c'est pas deja affiché dans le menu "Online"
		echo "<table class=arcadecenter style='clear:both;'><tr><th class=arcadeadmin>"
			."<a href='index.php?action=Arcade&amp;subaction=Admin'>Panneau d'Administration du module Arcade</a></th></tr>";
		echo "</table>\n";
	}
}//}}}

require_once("views/page_tail.php");
?>

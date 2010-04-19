<?php
/**
* Interception des scores envoyés par les jeux d'arcades flashs
* @author ericalens <ericalens@ogsteam.fr>
* @package Arcade
* @link http://ogsteam.fr
* @version 2.1
*/
define('_TABLE_ARCADE_','ogspy_arcade');

/**
* Message d'erreur basique
*/
function error_msg($msg){
	die("<h1>Erreur: $msg");
}

/**
* Verification si l'utilisateur est banni de l'utilisation du module arcade
*/
function check_banish(){
	global $db,$user_data;
	$query="SELECT count(*) FROM ogspy_arcade_ban WHERE playername like '".mysql_real_escape_string($user_data["user_name"])."'";
	$result=$db->sql_query($query);
	if (list($banish)=$db->sql_fetch_row($result)){
		if ($banish>0)	error_msg("Vous avez été banni par les administrateurs du serveurs OGSpy du module Arcade>");
	}

}
/**
* Retourne le nom du joueur selon les options du mod Arcade
*/
function GetPlayerName() {
	global $user_data,$server_config;
	if ($server_config["arcade_dontforcename"]=="1") {
		if (isset($_COOKIE["arcadename"]) && $_COOKIE["arcadename"]){
			$player_name=$_COOKIE["arcadename"];
		}
	} 
	
	if (!$player_name) $player_name=$user_data["user_name"];
	return $player_name;

}
/**
* Insertion de Score
*/
function InsertScore($gamename,$player_score){
	global $user_data,$db,$server_config;
	
	if ($server_config["arcade_dontforcename"]=="1") {
		if (isset($_COOKIE["arcadename"]) && $_COOKIE["arcadename"]){
			$player_name=$_COOKIE["arcadename"];
		}
	} 
	
	if (!$player_name) $player_name=$user_data["user_name"];

	if ($server_config["arcade_logdebug"] == "1" ) log_("debug","Arcade: Insertion de score par ".$user_data["user_name"].": nom: $player_name , score: $player_score,jeu:$gamename");

	
	//todo: requète inutile a optimiser.
	$result=$db->sql_query("SELECT playername, score,id FROM "._TABLE_ARCADE_." where gamename='$gamename'")or error_msg('prout');
	$name_found = false;
	while ($row = $db->sql_fetch_row($result)) {
		if ($player_name == $row[0]) {
			$name_found = true;
			break;
		}
	}
	if ($name_found) {
		if (((float)$player_score) > ((float)$row[1])) {
		$db->sql_query("UPDATE "._TABLE_ARCADE_." SET score='$player_score',scoredate='".time()."' WHERE id='".$row[2]."'");
		}
	}
	else {
		$db->sql_query("INSERT INTO "._TABLE_ARCADE_." VALUES ('','$player_name', '$player_score', '$gamename','".time()."','')") or error_msg('Could not saves scores.');
	}

	$query="SELECT * FROM "._TABLE_ARCADE_." WHERE gamename ='$gamename' ORDER BY SCORE DESC,id asc limit 1";
	$result=$db->sql_query($query);
	if ($hs=$db->sql_fetch_assoc($result)) {
				$query3="UPDATE ogspy_arcade_game SET highscore='".$hs['score']."',highscoreplayer='".$hs["playername"]."',"
				       ."highscoredate='".$hs["scoredate"]."' WHERE scorename ='".$hs["gamename"]."'";
//				$query3="UPDATE ogspy_arcade_game SET highscore='".$hs['score']."',highscoreplayer='".$hs["playername"]."',"
//				       ."highscoredate='".$hs["scoredate"]."',playcount=playcount+1 WHERE scorename ='".$hs["gamename"]."'";
				$db->sql_query($query3);
	}
}

/**
* Affichage d'un Array php sous forme de tableau html
* @link http://www.phpcs.com/codes/ARRAY_TO_XHTML_37232.aspx
*/
function array_to_html($tab,$class='',$id='') {

	$table="<table ";
	$table.= $id ? "id=\"$id\" " : "";
	$table.= $class ? "class=\"$class\" " : "";
	$table.= ">\n";

	foreach($tab as $key => $val) {
		if(is_array($val)) {
			$table.= "<tr><th>$key</th><td>";
			$table.= array_to_html($val,$class);
			$table.= "</td></tr>\n";
		}
		else $table.= "<tr><th>$key</th><td>$val</td></tr>\n";
	}
	$table.= "</table>\n";

	return $table;
}

// Récupération des scores des jeux de type IBPro
$arcade='';
$newscore='';
if (isset($HTTP_GET_VARS['act']))
	$arcade = $HTTP_GET_VARS['act'];
if (isset($HTTP_GET_VARS['do']))
	$newscore = $HTTP_GET_VARS['do'];

if (isset($HTTP_GET_VARS["autocom"])){
		echo "<u>\$POSTS</u><br>".array_to_html($_POST)."<br>"
		    ."<u>\$_GETS</u><br>".array_to_html($_GET)."<br>"
		    ."<u>\$_COOKIES</u><br>".array_to_html($_COOKIE)."<br>"
		    ."<a href='?action=Arcade&subaction=play&gamename=$gamename'>Re-Jouer ce jeu</a>";
}
// Si ca ressemble à du IBPro , gerer les scores
if($arcade == 'Arcade' && $newscore='newscore')
{

	if (!($user_data["user_id"]>0)) {
		error_msg("Erreur:Vous n'etes pas connecté... et votre score ne sera pas pris en compte");
	}
	// Pas de nom envoyé , on prend celui du connecté
	$player_name=$user_data["user_name"];

	check_banish();

	// Nom du jeu et score , en securisant les variables utilisateurs
	$gamename = str_replace("\'","''",$HTTP_POST_VARS['gname']);
	$gamename = preg_replace(array('#&(?!(\#[0-9]+;))#', '#<#', '#>#'), array('&amp;', '&lt;', '&gt;'),$gamename);
	$gamescore = floatval($HTTP_POST_VARS['gscore']);

	InsertScore($gamename,$gamescore);	
	$pub_action="Arcade";
	$pub_gamename="$gamename";

	if ($server_config["arcade_admingamedebug"]=="1") {
		echo "<u>\$POSTS</u><br>".array_to_html($_POST)."<br>"
		    ."<u>\$_GETS</u><br>".array_to_html($_GET)."<br>"
		    ."<u>\$_COOKIES</u><br>".array_to_html($_COOKIE)."<br>"
		    ."<a href='?action=Arcade&subaction=play&gamename=$gamename'>Re-Jouer ce jeu</a>";

	} else {
		redirection("?action=Arcade&subaction=comment&gamename=$gamename");
		//redirection("?action=Arcade&subaction=play&gamename=$gamename");
	}
	
}
$is_guestarcade=false;
if (!empty($server_config["arcade_guestuser"])){
	$ArcadeNames=split(';',$server_config["arcade_guestuser"]);
	if (in_array($user_data["user_name"],$ArcadeNames)) {
		if ($pub_action!="logout") {
		$pub_action="Arcade";
		}
		$is_guestarcade=true;
	}
}
?>

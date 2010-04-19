<?php
/**
* Fichier de recupération de scores des jeux Flash du mod Arcade pour OGSpy 3.02+
* @link http://ogs.servebbs.net
* @author ericalens ericalens@ogs.servebbs.net
* @package Arcade
*/

define("IN_SPYOGAME", true);
require_once("common.php");
$name_max = 26; # Maximum player name length allowed
$display_max = 100; # Maximum number of scores to display (multiple of 10)


# Error handler
function error_msg($msg) {
	exit("success=0&errorMsg=$msg");
}

if (!($user_data["user_id"]>0)) {
	error_msg("Erreur:Vous n'etes pas connecté.");
}
$query="SELECT count(*) FROM ogspy_arcade_ban WHERE playername like '".mysql_real_escape_string($user_data["username"])."'";
$result=$db->sql_query($query);
if (list($banish)=$db->sql_fetch_row($result)){
	if ($banish>0)	error_msg("Vous avez été banni par les administrateurs du serveurs OGSpy du module Arcade>");
			}

# Store POSTed info
@$player_name = mysql_real_escape_string($_POST['name']);
@$player_score = $_POST['score'];
@$gamename = strtolower(mysql_real_escape_string($_POST['game']));

if ($server_config["arcade_logdebug"] == "1" && isset($_POST['score'])) log_("debug","Arcade: Insertion de score par ".$user_data["username"].": nom:$player_name,score:$player_score,jeu:$gamename");

if ($server_config["arcade_dontforcename"] != "1") $player_name=$user_data["username"];



# SQL table name 
$table_name = 'ogspy_arcade';

# Need table
if (!isset($gamename)) error_msg('C\'est pas bien de faire ça , nanananana , c\'est pas bien !!');


# Saving new score?
if (isset($player_score) && is_numeric($player_score) && isset($player_name) && strlen($player_name) > 0 && strlen($player_name) <= $name_max) {
	# Is this IP banned?
#$query = mysql_query('SELECT ip FROM nuke_arcade_banned_ip') or error_msg('Could not access database.');
#while ($row = mysql_fetch_row($query)) {
#	if ($player_ip == $row[0]) error_msg('Sorry, high scores have been disabled for your computer.');
#}
	# Has this name played already?
	$result=$db->sql_query("SELECT playername, score,id FROM $table_name where gamename='$gamename'")or error_msg('prout');
	$name_found = false;
	while ($row = $db->sql_fetch_row($result)) {
		if ($player_name == $row[0]) {
			$name_found = true;
			break;
		}
	}
	if ($name_found) {
		if (((int)$player_score) > ((int)$row[1])) {
		$db->sql_query("UPDATE $table_name SET score='$player_score' WHERE id='".$row[2]."'");
		}
	}
	else {
		# If scores table is full, check score and delete lowest entry before inserting
		# Insert new name, score and ip
		$db->sql_query("INSERT INTO $table_name VALUES ('','$player_name', '$player_score', '$gamename')") or error_msg('Could not saves scores.');
	}
}

# Return new scores table
$result = $db->sql_query("SELECT playername, score FROM $table_name where gamename='$gamename' ORDER BY score DESC LIMIT 0, $display_max") or error_msg('Could not retrieve scores.');

$i = 1;
echo 'success=1&errorMsg=OK&maxScore=' . $display_max;
while ($row = $db->sql_fetch_row($result)) {
	echo "&name$i=$row[0]&score$i=$row[1]";
	$i++;
}

?>

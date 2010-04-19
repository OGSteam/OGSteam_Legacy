<?php
/**
* Functions communes pour les différentes parties du mod Arcade
* @package Arcade
* @author ericalens <ericalens@ogsteam.fr>
* @link http://www.ogsteam.fr
* @version 2.1
*/

// L'appel direct est interdit....

if (!defined('IN_SPYOGAME')) die("Hacking attempt");


//Variables et Defines globales au Mod {{{
define("arcWidthHeight",$server_config["arcade_imagesize"]);
define("_ARCSA_","index.php?action=Arcade&amp;subaction=");
//<div style='float: left;vertical-align:top;position: relative;top:-13'>
define("_img_1st_","<img src='mod/Arcade/pics/1st.gif' width=31 height=26 border=0 />");
define("_img_2nd_","<img src='mod/Arcade/pics/2nd.gif' width=31 height=26 border=0 />");
define("_img_3rd_","<img src='mod/Arcade/pics/3rd.gif' width=31 height=26 border=0 />");
//}}}


/**
* ShowGameFromRow: Affiche un jeu à partir d'un fetch_assoc sur ogspy_arcade_game 
* @param $game array le fetch assoc
* @param string option Une option pour plus tard... 
* @return string La chaine formaté
*/
function ShowGameFromRow($game,$option=''){ //{{{

	global $server_config,$user_data,$db;
	$retval='';

	//Image
	$retval .= "\t<tr>\n\t\t<td width=".(arcWidthHeight+2).">\n";
	if (empty($game["image"])) {
		$retval .= "&nbsp;";
	}else
	{
		$retval .= "\t<a href='index.php?action=Arcade&amp;subaction=play&amp;gamename=".$game["scorename"]."'><img src='mod/Arcade/pics/".$game["image"]."' width=".arcWidthHeight." height=".arcWidthHeight." border=0></a>\n";
	}
	$retval .= "</td>\n";

	//Nom
	$retval .= "\t\t<td class='c'><a href='index.php?action=Arcade&amp;subaction=play&amp;gamename=".$game["scorename"]."'>".$game["name"]."</a><br>".$game["playcount"];

	if($user_data["user_admin"] == 1 || ($server_config["arcade_coadminenable"]=="1" && $user_data["user_coadmin"]==1)) {
		$retval .= "&nbsp;<div class=arcadeadmin>[&nbsp;<a href='index.php?action=Arcade&amp;subaction=Admin&amp;command=editgame&amp;game=".$game["scorename"]."'>Options</a>&nbsp;]</div>";
	}
	$retval .= "</td>\n";

	//Description
	$retval .= "\t\t<td class='k'>&nbsp;".stripslashes($game["description"])."<br>\n";

	//Les 5 premiers joueurs du jeu
	$query2="SELECT playername FROM ogspy_arcade where gamename like '".$game["scorename"]."' ORDER by score desc limit 5";
	$result2=$db->sql_query($query2);
	$place=1;
	while ($pl=$db->sql_fetch_assoc($result2)){
		$retval .= "\t<a>$place</a>. ".PlayerShowGamesLink($pl["playername"])." &nbsp;&nbsp;\n";
		$place=$place+1;
	}
	$retval .= "</td>\n";

	//Score
	if (empty($game["highscoreplayer"])) {
		$retval .= "\t\t<td class='m' width='150'>Pas de score</td>\n";
	} else
		$retval .= "\t\t<td class='k' width='150'>".FormatScore($game["highscore"])."<br>par ".PlayerShowGamesLink($game["highscoreplayer"])._img_1st_."<br>".date("d.m H:i:s",$game["highscoredate"])."</td>\n";

	$retval .= "\t</tr>\n";
	
	return $retval;
}//}}}

function GetPosition($playername,$gamename){
// SELECT a.name, 
// (SELECT COUNT(DISTINCT b.score) FROM scores AS b WHERE b.score >= a.score) AS 'position' 
// FROM scores AS a ORDER BY position ASC;
//SELECT a.name, ( COUNT(b.id) + 1 ) as position, a.score FROM scores AS a LEFT JOIN scores AS b ON a.score < b.score GROUP BY a.id ORDER BY position;
	global $db;

	$query="SELECT a.* , (COUNT (b.id)+1) as position FROM ogspy_arcade AS a "
		."LEFT JOIN ogspy_arcade as b on a.score<b.score "
		." WHERE gamename='".mysql_real_escape_string($gamename)."' AND "
		."       playername='".mysql_real_escape_string($playername)."' GROUP BY a.id ORDER BY position";
	$result=$db->sql_query($query);

	while ($row=$db->sql_fetch_assoc($result)) {
		print_r($row);
	}
}
/**
* Creer un lien utilisateur pour recherche des jeux top 1
*/

function PlayerShowGamesLink($player){//{{{
	return "<a href='"._ARCSA_."showgamesfor&amp;player=$player'>$player</a>";
}//}}}

/**
* Recupère le nom du gars en train de jouer
* @return string le nom du joueur
*/
function GetUserName(){//{{{
	global $user_data,$db,$server_config;
	
	if ($server_config["arcade_dontforcename"]=="1") {
		if (isset($_COOKIE["arcadename"]) && $_COOKIE["arcadename"]){
			$player_name=$_COOKIE["arcadename"];
		}
	} 
	
	if (!$player_name) $player_name=$user_data["user_name"];
	return $player_name;
}//}}}

/**
* Tente de récuper un rep racine pour le serveur
* @return string le path ou false
*/
function GuessServerRootPath() {//{{{
	$me = $_SERVER['PHP_SELF'];
	$Apathweb = explode("/", $me);
	$myFileName = array_pop($Apathweb);
	$pathweb = implode("/", $Apathweb);
	$myURL = "http://".$_SERVER['HTTP_HOST'].$pathweb."/".$myFileName;
	$PAGE_BASE['www'] = $myURL;

	// build the file path:
	strstr( PHP_OS, "WIN") ? $strPathSeparator = "\\" : $strPathSeparator = "/";
	$pathfile = getcwd ();
	$PAGE_BASE['physical'] = $pathfile.$strPathSeparator.$myFileName;

	// this is so you can verify the results:
	$www = $PAGE_BASE['www'];
	$physical = $PAGE_BASE['physical'];
        return $physical;	
}//}}}

/**
* SetConfig() Modification d'une valeur de config dans la table de config d'OGSpy 
*/
function SetConfig($key,$value){//{{{

	global $db;

	$query="REPLACE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('$key','$value') ";
		      
	$db->sql_query($query);

}//}}}

function EchoDebug($message) {//{{{
	echo "<br>$message<br>";
}//}}}

function getSWFArray($dir="./games"){//{{{

	$swfdirectory=$dir;
	$result = Array();
	if (is_dir($swfdirectory)) {
		if ($dh = opendir($swfdirectory)) {
			while (($file = readdir($dh)) !== false) {
				if (filetype($swfdirectory . $file) == "file") {
					if ($extpos = strrpos($file, '.')) {
						$ext = substr($file, $extpos + 1);
						if ($ext == "swf") {
							$result[] = $file;
						} 
					} 
				} 
			} 
			// let's get them in alpha natural order
			sort($result, SORT_STRING);
			closedir($dh);
		} else // if ($dh = opendir($swfdirectory))
			die("Cannot open directory '$swfdirectory'");
	} else // if (is_dir($swfdirectory))
		die("'$swfdirectory' is not a directory");
	return $result;
}//}}}

function FindPicForGame($gamebasename){//{{{

	$picdirectory=realpath(dirname(__FILE__))."/pics/";
	$PicExt = array(".gif", ".jpg", ".png", ".jpeg", ".bmp");
	$gamepic="";
	foreach($PicExt as $Ext) {
		if (file_exists($picdirectory . $gamebasename . $Ext)) {
			$gamepic = $gamebasename . $Ext;
			break;
		} 
		if (file_exists($picdirectory . $gamebasename . "1" . $Ext)) {
			$gamepic = $gamebasename . "1" . $Ext;
			break;
		} 
		if (file_exists($picdirectory . $gamebasename . "2" . $Ext)) {
			$gamepic = $gamebasename . "2" . $Ext;
			break;
		} 
	} 
	return $gamepic;
}//}}}

/**
* Affichage d'un tableau formatté
*/
function print_r_string($arr,$first=true,$tab=0)//{{{
{
	$output = "";
	$tabsign = ($tab) ? str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$tab) : '';
	if ($first) $output .= "<pre><br>\n";
	foreach($arr as $key => $val)
	{
		switch (gettype($val))
		{
			case "array":
				$output .= $tabsign."[".htmlspecialchars($key)."] = array(".count($val).")<br>\n".$tabsign."(<br>\n";
			$tab++;
			$output .= print_r_string($val,false,$tab);
			$tab--;
			$output .= $tabsign.")<br>\n";
			break;
			case "boolean":
				$output .= $tabsign."[".htmlspecialchars($key)."] bool = '".($val?"true":"false")."'<br>\n";
			break;
			case "integer":
				$output .= $tabsign."[".htmlspecialchars($key)."] int = '".htmlspecialchars($val)."'<br>\n";
			break;
			case "double":
				$output .= $tabsign."[".htmlspecialchars($key)."] double = '".htmlspecialchars($val)."'<br>\n";
			break;
			case "string":
				$output .= $tabsign."[".htmlspecialchars($key)."] string = '".((stristr($key,'passw')) ? str_repeat('*', strlen($val)) : htmlspecialchars($val))."'<br>\n";
			break;
			default:
			$output .= $tabsign."[".htmlspecialchars($key)."] unknown = '".htmlspecialchars(gettype($val))."'<br>\n";
			break;
		}
	}
	if ($first) $output .= "</pre><br>\n";
	return $output;
}//}}}


/**
* TournamentCreateEditForm
*/
function TournamentCreateEditForm($tourname,$starttime,$endtime,$tourid=null){

	$settourlink="index.php?action=Arcade&amp;subaction=Admin&amp;command=settour";
	$settoutgameslink="index.php?action=Arcade&amp;subaction=Admin&amp;command=settourgames";

	echo "<table>\n";
	echo "\t<tr><th colspan=2>Configuration/Ajout d'un tournoi</th></tr>\n";
	
	echo "\t\t<form action='$settourlink' method='post'>\n";
	if (!empty($tourid)) echo "\t\t<input type=hidden name=tourid value=$tourid>\n";

	echo "\t<tr><th>Nom</th><td><input type=text size=50 name=tourname value='$tourname'></td></tr>\n";
	echo "\t<tr><th>Debut:</th><td><input type=text size=20 name=starttime value='$starttime'></td></tr>\n";
	echo "\t<tr><th>Fin:</th><td><input type=text size=20 name=endtime value='$endtime'></td></tr>\n";
	echo "\t<tr><th colspan=2><input type=submit></th></tr>\n";
	echo "\t</form>\n";
	echo "</table>\n";

	global $db;

	$query="SELECT id,name from ogspy_arcade_game order by name asc";
	$result=$db->sql_query($query);

	echo "<table>\n";
	echo "<tr><th>Selection des jeux pour ce tournoi</th></tr>\n";
	echo "<form action='$settoutgameslink' method=post>\n";
	$impair=true;
	while ($row=$db->sql_fetch_assoc($result)){
		if ($impair) echo "<tr>\n";
		echo "\t<td class=c><input type=checkbox name=tourgame['".$row["id"]."'] > &nbsp;&nbsp;".$row["name"]."</td>\n";
		if (!$impair) echo "</tr>\n";
		$impair= !$impair;
	}
	if (!$impair) echo "\t<td class =c>&nbsp;</td></tr>\n";
	echo "<tr><td><input type=submit></td></tr>\n";
	echo "</form>\n";
	echo "</table>\n";
}

function FormatScore($score){//{{{

	if ( (int)$score == (float)$score) return number_format($score,0,","," ");
	return number_format($score,2,","," ");

}//}}}
?>

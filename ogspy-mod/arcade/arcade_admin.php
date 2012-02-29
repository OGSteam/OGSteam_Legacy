<?php
/**
* Panneau d'Administration du module Arcade 
* @package Arcade
* @author ericalens <ericalens@ogsteam.fr>
* @link http://www.ogsteam.fr
* @version 2.0
*/

// L'appel direct est interdit....

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// a priori pas besoin de verifier si le mod est actif.. vu que la demande ne peut venir que d'arcade.php

require_once("mod/arcade/arcade_functions.php");
$aapc="?action=Arcade&amp;subaction=Admin&amp;command";

/**
* {{{ ShowAdminPanel() : Affichage du panneau d'administration du module Arcade
*
*/
function ShowAdminPanel(){

	global $db,$user_data,$server_config,$aapc;
	echo "<table align='center'>\n";

	// Les options
	echo "<tr><td class='c' colspan='3' align='center'><big>Panneau d'Administration du module <a href='?action=Arcade'>Arcade</a></big></td></tr>\n";
	echo "<tr><td colspan=3>&nbsp;</td></tr>\n";
	echo "<tr><td class='c' colspan='3' align='center'>Options du module Arcade<br><em>Ces options sont stockées dans la table configuration d'OGSpy</em></td></tr>\n";
        echo "<form action='$aapc=saveoptions' method='post'>\n";	
	echo "<tr><td class='c'>arcade_dontforcename</td><td align='center'><input type='checkbox' name='arcade_dontforcename'".($server_config["arcade_dontforcename"]==1?" checked":"")."></td>"
	    ."<th>Prend en compte le nom entré par l'utilisateur<br> lors de la sauvegarde des High-Scores</th></tr>\n";
	echo "<tr><td class='c'>arcade_coadminenable</td><td align='center'><input type='checkbox' name='arcade_coadminenable'".($server_config["arcade_coadminenable"]==1?" checked":"")."></td>"
	    ."<th>Les Co-Admins peuvent acceder au panneau d'administration Arcade</th></tr>\n";
	echo "<tr><td class='c'>arcade_logdebug</td><td align='center'><input type='checkbox' name='arcade_logdebug'".($server_config["arcade_logdebug"]==1?" checked":"")."></td>"
	    ."<th>Ajoute dans le journal toute soummission de score</th></tr>\n";
	echo "<tr><td class='c'>arcade_admingamedebug</td><td align='center'><input type='checkbox' name='arcade_admingamedebug'".($server_config["arcade_admingamedebug"]==1?" checked":"")."></td>"
	    ."<th>Bloque les soumissions de score de l'admin et donne les infos renvoyés par le jeu si elles sont interceptés.</th></tr>\n";
	echo "<tr><td class='c'>arcade_announce</td><td align='center'><textarea rows=4 name='arcade_announce'>".$server_config["arcade_announce"]."</textarea></td>"
	    ."<th>Message affiché sur la page d'accueil du module Arcade.</th></tr>\n";
	echo "<tr><td class='c'>arcade_imagesize</td><td align='center'><input type='text' size=5 name='arcade_imagesize' value=\"".$server_config["arcade_imagesize"]."\"></td>"
	    ."<th>Taille par defaut (largeur=hauteur) des icones dans le module Arcade</th></tr>\n";
	echo "<tr><td class='c'>arcade_serverrootpath</td><td align='center'><input type='text' size=45 name='arcade_serverrootpath' value=\"".$server_config["arcade_serverrootpath"]."\"></td>"
	    ."<th>Path du repertoire arcade/gamedata à la racine du serveur<br>(? ".dirname(GuessServerRootPath())."/arcade/gamedata )<br>doit avoir les droits 777</th></tr>\n";
	echo "<tr><td class='c'>arcade_uploadpath</td><td align='center'><input type='text' size=45 name='arcade_uploadpath' value=\"".$server_config["arcade_uploadpath"]."\"></td>"
	    ."<th>Path du repertoire temporaire lors de la décompression<br>(? ".realpath(dirname(__FILE__))."/tmp )<br>Doit avoir les droits 777</th></tr>\n";
	echo "<tr><td class='c'>arcade_onlinmins</td><td align='center'><input type='text' size=5 name='arcade_onlinmins' value=\"".$server_config["arcade_onlinmins"]."\"></td>"
	    ."<th>Nombres de minutes pendant lesquelles un joueur doit etre considéré online</th></tr>\n";
	echo "<tr><td class='c'>arcade_guestuser</td><td align='center'><input type='text' size=5 name='arcade_guestuser' value=\"".$server_config["arcade_guestuser"]."\"></td>"
	    ."<th>Option: Nom de joueurs Arcade seulement séparés par un ';'<br> ils ne pourront pas acceder au reste du serveur OGSpy</th></tr>\n";
	echo "<tr><td class='c'>arcade_fullscreen</td><td align='center'><input type='checkbox' name='arcade_fullscreen'".($server_config["arcade_fullscreen"]==1?" checked":"")."></td>"
	    ."<th>Mode plein ecran, sans le menu OGSpy</th></tr>\n";

	echo "<tr><td>&nbsp</td><td colspan=2 align='right'><input type='submit'></td></tr>\n";    
	echo "</form>\n";

	//La gestion des Scores
	echo "<tr><td class='c' colspan='3' align='center'>Gestion des Scores</td></tr>\n";
        echo "<tr><td>&nbsp;</td><th colspan=2><a href='$aapc=deleteallscore'>Réinitialisation de toutes les tables de Scores</th></tr>\n";
        echo "<tr><td>&nbsp;</td><th colspan=2><a href='$aapc=fixallscore'>Réparer les Scores</th></tr>\n";
        echo "<tr><td>&nbsp;</td><th colspan=2>Effacer les scores du joueur <form action='$aapc=deleteplayerscore' method='post'><input type='text' name='playername'><input type='submit'></form></th></tr>\n";
	
	// Les bans et Unbans utilisateurs
	echo "<tr><td colspan=3>&nbsp;</td></tr>\n";
	echo "<tr><td class='c' colspan='3' align='center'>Ban et Unban Utilisateur</td></tr>\n";
	echo "<tr><td class='c'>Ban User</td><th valign='center'><form action='$aapc=banplayer' method='post'><input type='text' name='playername'><br><input type='submit'></form></th><th>Ajoute un utilisateur à la liste des bannis<br><em>(Interdiction de jouer)</em></th></tr>\n";
	echo "<tr><td class='c'>Utilisateurs Bannis</td><th valign='top'>Cliquer pour débannir</form></th><th>";
	
	$query="SELECT playername FROM `ogspy_arcade_ban`";
	$result=$db->sql_query($query);
	while (list($playername)=$db->sql_fetch_row($result)){
		echo "<a href='$aapc=unbanplayer&amp;playername=$playername'>$playername</a>&nbsp;|";
	}
	echo "</th></tr>\n";

	// Choix des Jeux deja uploadés
	echo "<tr><td colspan=3>&nbsp;</td></tr>\n";
	echo "<tr><td class='c' colspan='3' align='center'>Installation des jeux deja uploadés sur le serveur</td></tr>\n";

	echo "<tr><td class='c'>Fichier Flash:</td>\n";
	
	echo "<th><form action='$aapc=installswf' method='post'><select name='swffile'>\n";

	$query="SELECT swfname FROM ogspy_arcade_game";
	$result=$db->sql_query($query);
	$swfInBase=Array();
	while ($row=$db->sql_fetch_assoc($result)){
		$swfInBase[]=$row["swfname"];
	}
	$swfarray=getSWFArray(realpath(dirname(__FILE__))."/games/");
	natcasesort($swfarray);
	
	foreach ($swfarray as $filename) {
		if (!in_array($filename,$swfInBase)){
			echo "\t<option>$filename</option>\n";
		}
	}
	echo "</select>";
	echo "<input type='submit'></form>\n";
	echo "</th><th>Liste des fichiers .swf dans le repertoire 'games' non présent en base de donnée.</th></tr>\n";
	// Panneau Upload
	ShowUploadPanel();
	echo "</table>\n";
	TournamentCreateEditForm("Nouveau Tournoi","2006-10-07 20:00","2006-10-07 24:00");
}//}}}

/**
* ShowInstallSwfForm($pub_swffile) : Formulaire de données d'installation d'un jeu swf {{{
*/
function ShowInstallSwfForm($pub_swffile){

	if (empty($pub_swffile)){
		echo "<h2>Erreur : Pas de nom de fichier swf fourni";
		return;
	}
	$basename=basename($pub_swffile,".swf");
	
	echo "<table>\n"
	    ."<tr><th class=c colspan=2>Options d'installation de <a href='./mod/arcade/games/".$pub_swffile."'>$pub_swffile</a></th></tr>";
	echo "<form action='?action=Arcade&amp;subaction=Admin&amp;command=setswfoptions' method='post'>\n";
	echo "<input type=hidden name=swffile value=".$pub_swffile.">\n";
	echo "<tr><td class=c width=100>Nom Affiché:</td><td class=k><input type=text size=40 name=nomjeu value='".$basename."'></td></tr>\n";
	echo "<tr><td class=c>Description:</td><td class=k><textarea rows=5 name=description >$basename</textarea></td></tr>\n";
	echo "<tr><td class=c>Largeur:</td><td class=k><input type=text size=8 name=largeur value='500'></td></tr>\n";
	echo "<tr><td class=c>Hauteur:</td><td class=k><input type=text size=8 name=hauteur value='380'></td></tr>\n";
	echo "<tr><td class=c>Scorename:</td><td class=k><input type=text size=30 name=scorename value='".$basename."'></td></tr>\n";
	echo "<tr><td class=c>Backcolor:</td><td class=k><input type=text size=10 name=backcolor value='#000000'></td></tr>\n";
	echo "<tr><td class=c>image:</td><td class=k>&nbsp;<input type=text size=40 name=image value='".FindPicForGame($basename)."'></td></tr>\n";
	echo "<tr><th colspan=2><input type=submit></th></tr>\n";
	echo "</form>\n";
	echo "</table>\n";

}//}}}
/**
* {{{ ShowUploadPanel: Affiche le formulaire d'insertion de nouveau jeu avec Upload
*/
function ShowUploadPanel() {
	global $server_config;

	if(!empty($server_config["arcade_serverrootpath"])){

?>

<tr><td colspan=3>&nbsp;</td></tr>
<tr><td class=c align=center colspan=3>Upload et Installation d'un nouveau Jeu Flash (*.swf)</td></tr>
<form name="upload" enctype="multipart/form-data" method="post" action="?action=Arcade&amp;subaction=Admin&amp;command=upload">
<tr><td class=c>Titre :</td><th ><input type=text size='40' name="nomjeu"></th><th>Nom du jeu</th></tr>
<tr><td class=c>Description :</td><th ><input type=text size='40' name="description"></th><th>Description du jeu</th></tr>

<tr><td class=c>Jeu SWF:</td><th >  <input type="file" name="file">  </th>
	<th rowspan=2 class=c> <input type="submit" name="bouton_submit" value="Installation du Nouveau Jeu"></th>
</tr>
<tr><td class=c>Image/Icone</td><th > <input type="file" name="image"> </th>
<tr><td class=c>Largeur/Hauteur</td><th ><input type=text name="largeur" value=500><input type=text name="hauteur" value=350></th><th>Largeur et Hauteur Souhaité</th></tr>
<tr><td class=c>Scorename :</td><th ><input type=text name="nomscore"></th><th>Nom du score (si vide , le nom du swf sans extension sera pris</th></tr>
<tr><td class=c>Backcolor :</td><th ><input type=text name="backcolor" value='#000000'> </th><th>Nom du score (si vide , le nom du swf sans extension sera pris</th></tr>
  </form>
</tr>
<tr><td colspan=3>&nbsp;</td></tr>
<?php
}

	if (!empty($server_config["arcade_uploadpath"])){

?>
<tr><th class=c align=center colspan=3>Upload d'un fichier jeu sous forme de tar</th></tr>

<form name="upload" enctype="multipart/form-data" method="post" action="?action=Arcade&amp;subaction=Admin&amp;command=uploadtar">
<tr><td colspan=3>Cette archive doit au moins contenir une image (gif), un fichier de jeu .swf, et un fichier de configuration .php qui definit un tableau de $config </td></tr>
<tr><td class=c>fichier tar:</td><th >  <input type="file" name="file">  </th><td class=m><input type=submit></td></tr>
</form>
<?php
}
}//}}}

/**
* SetSwfOptions() : Enregistre les données du formulaire d'installation swf {{{
*/
function SetSwfOptions() {

	global $db;
	global  $pub_swffile ,$pub_nomjeu ,$pub_description ,$pub_largeur ,$pub_hauteur ,$pub_scorename ,$pub_backcolor ,$pub_image ;
	
	$query="INSERT INTO ogspy_arcade_game (id,name,scorename,width,height,swfname,description,image,backcolor) "
	       ." VALUES( NULL,'".mysql_real_escape_string($pub_nomjeu)."',"
	       ." '";
	$query .=mysql_real_escape_string($pub_scorename)."','" ;
	$query .=$pub_largeur."','".$pub_hauteur."','".$pub_swffile."','"
	       .mysql_real_escape_string($pub_description)."','"
	       .mysql_real_escape_string($pub_image)."','".mysql_real_escape_string($pub_backcolor)."')";
	$db->sql_query($query);
	
	echo "<h2>Jeu Installé</h2>";
	echo "<a href='?action=Arcade&amp;subaction=Admin&amp;command=editgame&amp;game=$pub_scorename'>Retour sur les options de $pub_nomjeu</a>\n";
}//}}}

/**
* {{{ SetGameOptions() : Configure un jeu à parti des données du formulaires de ShowGameOptions
*/

function SetGameOptions(){
	global $db,$pub_id,$pub_nomjeu,$pub_description,$pub_largeur,$pub_hauteur,$pub_backcolor;
	global $pub_scorename,$pub_swfname,$pub_image;

	$query="UPDATE ogspy_arcade_game "
	      ."SET "
	      	."name='$pub_nomjeu', "
	      	."description='$pub_description', "
	      	."width='$pub_largeur', "
	      	."height='$pub_hauteur', "
	      	."scorename='$pub_scorename', "
	      	."swfname='$pub_swfname', "
	      	."backcolor='$pub_backcolor', "
	      	."image='$pub_image' "
	      ."WHERE id='$pub_id'";
	$db->sql_query($query);
	redirection("?action=Arcade&subaction=play&gamename=$pub_scorename");
}//}}}

/**
* {{{ UninstallGame : Suppression d'un jeu base de donnée
*/
function UninstallGame(){
	global $db,$pub_id;
	if (isset($pub_id) && $pub_id) {

		$query="SELECT scorename from ogspy_arcade_game where id=$pub_id limit 1";
		$result=$db->sql_query($query);
		if ($row=$db->sql_fetch_assoc($result)){
			$query="DELETE FROM ogspy_arcade_game WHERE id=$pub_id";
			$db->sql_query($query);
			$query="DELETE FROM ogspy_arcade WHERE gamename='".$row["scorename"]."'";
			$db->sql_query($query);

			echo "<h1>Suppression et desinstallation effectué. Les fichiers n'ont pas été supprimé du serveur</h1>";
		}
		else
		{
			echo "<h1> Jeu '$pub_id' non trouvé. Il n'y a pas eu de deinstallation</h1>";
		}
	}
}//}}}

/**
*{{{ ShowGameOptions($game) Affiche un formulaire de modification d'option du jeu
*/
function ShowGameOptions($game){
	global $db;
	$query="SELECT * FROM `ogspy_arcade_game` where scorename='$game'";
	$result=$db->sql_query($query);
	if ($row=$db->sql_fetch_assoc($result)){
		echo "<table>\n"
		    ."<tr><th class=c colspan=2>Options pour le jeu ".$row["name"]."</th></tr>";
		echo "<form action='?action=Arcade&amp;subaction=Admin&amp;command=setgameoptions' method='post'>\n";
		echo "<input type=hidden name=id value=".$row["id"].">\n";
		echo "<tr><td class=c width=100>Nom Affiché:</td><td class=k><input type=text size=40 name=nomjeu value='".stripslashes($row["name"])."'></td></tr>\n";
		echo "<tr><td class=c>Description:</td><td class=k><textarea rows=5 name=description>".stripslashes($row["description"])."</textarea></td></tr>\n";
		echo "<tr><td class=c>Largeur:</td><td class=k><input type=text size=8 name=largeur value='".$row["width"]."'></td></tr>\n";
		echo "<tr><td class=c>Hauteur:</td><td class=k><input type=text size=8 name=hauteur value='".$row["height"]."'></td></tr>\n";
		echo "<tr><td class=c>Scorename:</td><td class=k><input type=text size=8 name=scorename value='".$row["scorename"]."'></td></tr>\n";
		echo "<tr><td class=c>Backcolor:</td><td class=k><input type=text size=8 name=backcolor value='".$row["backcolor"]."'></td></tr>\n";
		echo "<tr><td class=c>swf:</td><td class=k><input type=text size=40 name=swfname value='".$row["swfname"]."'></td></tr>\n";
		echo "<tr><td align=center colspan=2><a href='mod/arcade/games/".$row["swfname"]."'>".$row["swfname"]."</a>&nbsp;(lire)</td></tr>\n";

		echo "<tr><td class=c>image:</td><td class=k><img width=32 height=32 src='mod/arcade/pics/".$row["image"]."'>&nbsp;<input type=text size=40 name=image value='".$row["image"]."'></td></tr>\n";
		echo "<tr><th colspan=2><input type=submit></th></tr>\n";
		echo "</form>\n";
		echo "<tr><th colspan=2>Commandes</th></tr>\n";
		echo "<tr><td colspan=2 class='m'><a href='?action=Arcade&amp;subaction=Admin&amp;command=uninstall&amp;id=".$row["id"]."'>Desinstaller</a></td></tr>\n";
		echo "</table>\n";
	}else {
		echo "Le jeu '$game' n'a pas été trouvé. Pas d'edition possible";
	}
}//}}}

/**
* KeyValueLine: Simplification d'entrée de tableau html a 2 colonnes
*/
function KeyValueLine($key,$value,$novalue=false){//{{{
	if ($novalue==false) {
		echo "<tr><th>$key</th><td>$value</td></tr>\n";
	}else
	{
		echo "<tr><td colspan=2>$key</td></tr>\n";
	}

}//}}}

/**
* {{{UploadTarFile: Installe un jeu à partir d'un fichier tar avec le config.php adéquat
*/
function UploadTarFile(){
	global $server_config;
	if(empty($_FILES["file"]["name"])){die("Aucun fichier n'a été uploadé");}

	// Nom du fichier choisi:
	$nomFichier = $_FILES["file"]["name"] ;
	// Nom temporaire sur le serveur:
	$nomTemporaire = $_FILES["file"]["tmp_name"] ;
	// Type du fichier choisi:
	$typeFichier = $_FILES["file"]["type"] ;
	// Poids en octets du fichier choisit:
	$poidsFichier = $_FILES["file"]["size"] ;
	// Code de l'erreur si jamais il y en a une:
	$codeErreur = $_FILES["file"]["error"] ;
	// Extension du fichier
	$extension = strrchr($nomFichier, ".");
	
	
	
	
	echo "<table>\n";
	echo "<tr><th colspan=2>Upload d'archive TAR</th></tr>\n";
	if ($poidsFichier<=0) {
		KeyValueLine("Erreur lors de l'upload: ".$codeErreur,"",true);
	} else {
		
		$uploadOK=move_uploaded_file($nomTemporaire,$server_config["arcade_uploadpath"]."/$nomFichier");
		KeyValueLine("Nom original",$nomFichier);
		KeyValueLine("Taille",$poidsFichier." octets");
		KeyValueLine("Type",$typeFichier);
		
		require_once("./mod/arcade/tarlib.php");
		
		$filetar=new CompTar();
		$filetar->_nomf=$server_config["arcade_uploadpath"]."/$nomFichier";
		
		$tarcontent=$filetar->ListContents();
		
		echo "<tr><th colspan=2>Decompression</th></tr>\n";
		
		foreach ($tarcontent as $tarentry) {
			if ($tarentry['typeflag']==0 ){
				//Contenu du rep gamedata
				if (strpos($tarentry["filename"],"gamedata")!==false) {
					$extraction=Array();
					$extraction[]=$tarentry["filename"];
					$extractresult=$filetar->Extract($extraction,$server_config["arcade_serverrootpath"]);
					KeyValueLine("Gamedata:",$tarentry["filename"]);
					

				}else {
					$path_parts=pathinfo($tarentry["filename"]);
					$extraction=Array();
					$extraction[]=$tarentry["filename"];

					//images
					if ($path_parts["extension"]=="gif") {
						$extractresult=$filetar->Extract($extraction,realpath(dirname(__FILE__))."/pics");
						KeyValueLine("Pics:",$tarentry["filename"]);
						//on prend le premier fichier gif comme image par defaut
						if (!isset($giffile)) $giffile=$tarentry["filename"];

					//fichiers swf
					}elseif ($path_parts["extension"]=="swf") {
						$extractresult=$filetar->Extract($extraction,realpath(dirname(__FILE__))."/games");
						KeyValueLine("Games:",$tarentry["filename"]);
						if (isset($swffile)) die("Erreur: Plusieurs fichiers .swf à la racine du fichier tar ?");
						$swffile=$tarentry["filename"];
					}else{
						if (isset($configfile)) {
							die("Erreur: Je trouve des fichiers dans l'archive dont je ne sais que faire : ".$tarentry["filename"]);
						}
							
						$extractresult=$filetar->Extract($extraction,$server_config["arcade_uploadpath"]);
						$configfile=$server_config["arcade_uploadpath"]."/".$tarentry["filename"];
						KeyValueLine("Config:",$configfile);
						echo "<tr><td>&nbsp;</td><td style='background:#BBBBBB;padding:5 5 5 5;'>";
						highlight_file($configfile);
						echo "</td></tr>\n";

					}
				}
			}
		}
		unlink($server_config["arcade_uploadpath"]."/$nomFichier");
		require_once($configfile);
		echo "<tr><th colspan=2>Configuration du jeu</th></tr>\n";
		if (!isset($configfile)) die("</table>Erreur: Je n'ai pas trouvé de fichier config");
		if (count($config) && !empty($giffile) && !empty($swffile)) {
			$query="INSERT INTO ogspy_arcade_game (id,name,scorename,width,height,swfname,description,image,backcolor) "
		       		." VALUES( NULL,'".mysql_real_escape_string($config["gtitle"])."',"
		       		." '";
			$query .=mysql_real_escape_string($config["gname"])."','" ;
			$query .=$config["gwidth"]."','".$config["gheight"]."','".$swffile."','"
		       		.mysql_real_escape_string(empty($config["object"])?$config["gwords"]:$config["object"])."','"
		       		.mysql_real_escape_string($giffile)."','".mysql_real_escape_string($config['bgcolor'])."')";
			global $db;
			$db->sql_query($query);

		echo "<tr><td class=c colspan=2>Installation du jeu effectué</td></tr>";
		global $aapc;
		echo "<tr><th colspan=2><a href='index.php?action=Arcade&amp;subaction=play&amp;gamename=".$config["gname"]."'>Jouer ".$config["gtitle"]."</a></th></tr>\n";
		echo "<tr><th colspan=2><a href='$aapc'>Retour Panneau Admin</a></a>";
		}
		echo "</table>\n";
		unlink($configfile);
		return true;
	}
	return false;
}//}}}

/**
* {{{ function UploadFile
* recupère les données du formulaire d'insertion de nouveau jeu
* et met a jour la base de donnée.
*/
function UploadFile(){
if(!empty($_FILES["file"]["name"])){
	
	// Nom du fichier choisi:
	$nomFichier = $_FILES["file"]["name"] ;
	// Nom temporaire sur le serveur:
	$nomTemporaire = $_FILES["file"]["tmp_name"] ;
	// Type du fichier choisi:
	$typeFichier = $_FILES["file"]["type"] ;
	// Poids en octets du fichier choisit:
	$poidsFichier = $_FILES["file"]["size"] ;
	// Code de l'erreur si jamais il y en a une:
	$codeErreur = $_FILES["file"]["error"] ;
	// Extension du fichier
	$extension = strrchr($nomFichier, ".");
	
	// Si le poids du fichier est de 0 bytes, le fichier est
	// invalide (ou le chemin incorrect) => message d'erreur
	// sinon, le script continue.
		$uploadOK=move_uploaded_file($nomTemporaire,$_SERVER["DOCUMENT_ROOT"]."/mod/arcade/games/$nomFichier");
		if ($uploadOK){
			echo "L'upload fichier s'est bien déroulé<br>";
		}else {
			echo "Erreur lors de l'upload du fichier<br>";
		}
		echo "DOCUMENT_ROOT:".$_SERVER["DOCUMENT_ROOT"]."<br>" ;
		
		echo "Nom fichier: $nomFichier<br>"
		    ."Nom Temporaire $nomTemporaire<br>"
		    ."type: $typeFichier<br>"
		    ."poids: $poidsFichier<br>"
		    ."Erreur: $codeErreur<br>";
}	
if(!empty($_FILES["image"]["name"])){
	
	// Nom du fichier choisi:
	$nomFichier = $_FILES["image"]["name"] ;
	// Nom temporaire sur le serveur:
	$nomTemporaire = $_FILES["image"]["tmp_name"] ;
	// Type du fichier choisi:
	$typeFichier = $_FILES["image"]["type"] ;
	// Poids en octets du fichier choisit:
	$poidsFichier = $_FILES["image"]["size"] ;
	// Code de l'erreur si jamais il y en a une:
	$codeErreur = $_FILES["image"]["error"] ;
	// Extension du fichier
	$extension = strrchr($nomFichier, ".");
	
	// Si le poids du fichier est de 0 bytes, le fichier est
	// invalide (ou le chemin incorrect) => message d'erreur
	// sinon, le script continue.
		$uploadimg=move_uploaded_file($nomTemporaire,$_SERVER["DOCUMENT_ROOT"]."/mod/arcade/pics/$nomFichier");
		if ($uploadimg){
			echo "L'upload fichier image s'est bien déroulé<br>";
		}else {
			echo "Erreur lors de l'upload du fichier image<br>";
		}
	
		echo "DOCUMENT_ROOT:".$_SERVER["DOCUMENT_ROOT"]."<br>" ;
		
		echo "Nom fichier: $nomFichier<br>"
		    ."Nom Temporaire $nomTemporaire<br>"
		    ."type: $typeFichier<br>"
		    ."poids: $poidsFichier<br>"
		    ."Erreur: $codeErreur<br>";
}	

 if ($uploadimg && $uploadOK) {

 	$query="INSERT INTO ogspy_arcade_game (id,name,scorename,width,height,swfname,description,image,backcolor) "
	       ." VALUES( NULL,'".mysql_real_escape_string($_POST["nomjeu"])."',"
	       ." '";
	if (empty($_POST["nomscore"])) $_POST["nomscore"]=basename($_FILES["file"]["name"],".swf");
	$query .=mysql_real_escape_string($_POST["nomscore"])."','" ;
	$query .=$_POST["largeur"]."','".$_POST["hauteur"]."','".$_FILES["file"]["name"]."','"
	       .mysql_real_escape_string($_POST["description"])."','"
	       .mysql_real_escape_string($_FILES["image"]["name"])."','"
	       .mysql_real_escape_string($_POST["backcolor"])."')";
	global $db;
	$db->sql_query($query);
	echo "<br>Installation du jeu effectué";

 }else echo "<br>Le Jeu n'a pas été installé";
}//}}}


function OutputCSS(){
?>
<style type="text/css">
<!--
.verte
{ color: #0000FF ;
background-color: #00FF33 ;
float: center ;
width: 100px ; }
-->
</style>
<?php
}
//{{{ Test Div
function ShowTestDiv() {
	OutputCSS();
	echo "<div class='verte'>Un tes  en vert a droite ?</div>";
}
//}}}

//{{{ Verification du statut admin et execution des commandes
if($user_data["user_admin"] != 1 && !($server_config["arcade_coadminenable"]=="1" && $user_data["user_coadmin"]==1)) {
	echo "<br>Hmmm ... non. Tu n'a pas le droit d'être ici , nous allons quand même informer l'administrateur"
	    ."  de ta tentative pour rentrer ici.";
	log_("debug","Arcade: Tentative d'accés à la page Admin par un non Admin");
	redirection("index.php?action=message&id_message=forbidden&info");
	die();
}else
{
  switch($pub_command) {
  	case "testdiv":
		ShowTestDiv();
		break;
  	case "installswf":
		ShowInstallSwfForm($pub_swffile);
		break;
	case "setswfoptions":
		SetSwfOptions();
		break;
	case "deleteallscore":
		$query="DELETE FROM `ogspy_arcade` WHERE 1";
		$db->sql_query($query);
		log_("debug","Arcade: Effacement de toute la table des scores");
		echo "<br>Effacement de toute la table des scores.<br><a href='$aapc'>Retour</a>";
		break;
	case "fixallscore":
		echo "Réparation des Scores";
		$query="SELECT distinct(gamename) from ogspy_arcade";
		$result=$db->sql_query($query);
		while ($row=$db->sql_fetch_assoc($result)){
			$query2="SELECT * from ogspy_arcade where gamename = '".$row["gamename"]."' order by score desc limit 1";
			$result2=$db->sql_query($query2);
			echo "<br>".$row["gamename"].":";
			if ($hs=$db->sql_fetch_assoc($result2)) {
				$query3="UPDATE ogspy_arcade_game SET highscore='".$hs['score']."',highscoreplayer='".$hs["playername"]."',"
				       ."highscoredate='".$hs["scoredate"]."' WHERE scorename ='".$hs["gamename"]."'";
				$db->sql_query($query3);
				echo " fixé.";
			}
		}
		break;
	case "deleteplayerscore":
		$query="DELETE FROM `ogspy_arcade` WHERE `playername` like '$pub_playername'";
		$db->sql_query($query);
		log_("debug","Arcade: Suppression des scores de $pub_playername");
		echo "<br>Effacement des scores de $pub_playername.<br><a href='$aapc'>Retour</a>";
		break;
	case "deletegamescore":
		$query="DELETE FROM `ogspy_arcade` WHERE gamename='".mysql_real_escape_string($pub_gamename)."'";
		$db->sql_query($query);
		log_("debug","Arcade: Suppression des scores de '".mysql_real_escape_string($pub_gamename)."'");
		echo "<br>Suppression des scores du jeu $pub_gamename<br><a href='$aapc'>Retour</a>";
		break;
	case "banplayer":
		$query="INSERT INTO `ogspy_arcade_ban` (id,playername) VALUES('','$pub_playername')";
		$db->sql_query($query);
		log_("debug","Arcade: Utilisateur $pub_playername banni");
		echo "<br>L'utilisateur $pub_playername est maintenant banni et ne peut plus utiliser le mod Arcade<br><a href='$aapc'>Retour</a>";
		break;
	case "unbanplayer":
		$query="DELETE FROM `ogspy_arcade_ban` WHERE playername like '$pub_playername'";
		$db->sql_query($query);
		log_("debug","Arcade: $pub_playername est debanni");
		echo "<br>L'utilisateur $pub_playername est maintenant autorisé à utiliser le mod Arcade<br><a href='$aapc'>Retour</a>";
		break;
	case "saveoptions":
		echo "<table><tr><th>Configuration du mod Arcade</th><tr>\n";
		echo "<tr><td class='a'>";
		echo "<br>arcade_dontforcename = '$pub_arcade_dontforcename'";
		echo "<br>arcade_coadminenable = '$pub_arcade_coadminenable'";
		echo "<br>arcade_logdebug = '$pub_arcade_logdebug'";
		echo "<br>arcade_admingamedebug = '$pub_arcade_admingamedebug'";
		echo "<br>arcade_announce = '$pub_arcade_announce'";
		echo "<br>arcade_imagesize = '$pub_imagesize'";
		echo "<br>arcade_fullscreen = '$pub_arcade_fullscreen'";
		echo "</td></tr>\n";
		SetConfig("arcade_logdebug",$pub_arcade_logdebug=="on"?"1":"0");
		SetConfig("arcade_coadminenable",$pub_arcade_coadminenable=="on"?"1":"0");
		SetConfig("arcade_dontforcename",$pub_arcade_dontforcename=="on"?"1":"0");
		SetConfig("arcade_admingamedebug",$pub_arcade_admingamedebug=="on"?"1":"0");
		SetConfig("arcade_fullscreen",$pub_arcade_fullscreen=="on"?"1":"0");
		SetConfig("arcade_announce",$pub_arcade_announce);
		SetConfig("arcade_imagesize",$pub_arcade_imagesize);
		SetConfig("arcade_serverrootpath",trim($pub_arcade_serverrootpath));
		SetConfig("arcade_uploadpath",trim($pub_arcade_uploadpath));
		SetConfig("arcade_onlinmins",trim($pub_arcade_onlinmins));
		SetConfig("arcade_guestuser",trim($pub_arcade_guestuser));

		echo "<tr><th><a href='$aapc'>Retour sur le panneau d'administration</a></th></tr>";
		echo "<tr><th><a href='?action=Arcade'>Retour sur le mod Arcade</a></th></tr>";

		echo "</table>";
		break;
	case "upload":
		UploadFile();
		break;
	case "uploadtar":
		UploadtarFile();
		break;
	case "editgame":
		ShowGameOptions($pub_game);
		break;
	case "setgameoptions":
		SetGameOptions();
		break;
	case "uninstall":
		UninstallGame();
		break;
	default:
		ShowAdminPanel();
	generate_config_cache();
 }
}
//}}}//
require_once("views/page_tail.php");
?>

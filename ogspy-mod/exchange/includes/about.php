<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'accès direct


$chemin_fichier = "http://ogsteam.fr/forums/sujet-4226-mod-exchange";

$pageAbout = "<!-- DEBUT Insertion mod eXchange : About -->";

$fp=@fopen($chemin_fichier,"r");

$contenu = "";

if($fp)
{
   while(!feof($fp))
   {
	$contenu .= fgets($fp,1024);
   }
   
   $pageAbout .= "<big><big>MOD eXchange</big></big>";
   preg_match("#<span class=\"bbu\"></span>(.*)<span class=\"bbu\"></span>#", $contenu, $versionCourante);
   $pageAbout .= $versionCourante[1];
   $pageAbout .= "<br /><big><big>Changelog :</big></big>";
   preg_match("#<em></em>(.*)<em></em>#", $contenu, $changeLog);
   $pageAbout .= $changeLog[1];
   ;
}
else
{
	echo "Impossible d'ouvrir la page $chemin_fichier";
} 

$pageAbout .= "<!-- FIN Insertion mod eXchange : About -->";

//affichage de la page
echo($pageAbout);

?>

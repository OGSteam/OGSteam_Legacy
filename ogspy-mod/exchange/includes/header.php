<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'accès direct

$imageFolder = FOLDEREXP."images"; 
$fisheyeFolder = FOLDEREXP."includes/fisheye";
//définition de la page
$menuFixe 	= getOpts($user_data['user_id'], 0);
$eXcDebug	= getOpts($user_data['user_id'], 1);
$nMsgParPage    = getOpts($user_data['user_id'], 2);

$nombreLien = 8;
$title[1] =  "Mes messages de joueurs";
$title[2] =  "Mes messages d'alliance";
$title[3] =  "Recherche de messages";
$title[4] =  "Statistiques sur les messages";
$title[5] =  "Options de eXchange";
$title[6] =  "Export BBCode";
$title[7] =  "Ajouter un message";
$title[8] =  "A propos / Changelog";
$link[1] =  "user";
$link[2] =  "ally";
$link[3] =  "seek";
$link[4] =  "stats";
$link[5] =  "config";
$link[6] =  "bbcode";
$link[7] =  "add";
$link[8] =  "about";
$image[1] =  "2";
$image[2] =  "1";
$image[3] =  "6";
$image[4] =  "3";
$image[5] =  "7";
$image[6] =  "10";
$image[7] =  "9";
$image[8] =  "11";

if ($menuFixe  == 0)
{
	$pageHeader = <<<HEREHEADER

	<!-- DEBUT Script pour la zolie dock :) -->

	<script type="text/javascript" src="$fisheyeFolder/jquery.js"></script>
	<script type="text/javascript" src="$fisheyeFolder/interface.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="$fisheyeFolder/interface.css" />

	<script type="text/javascript">
	$(document).ready(
	function()
	{ $('#dock').Fisheye( {
	maxWidth: 50,
	items: 'a',
	itemsText: 'span',
	container: '.dock-container',
	itemWidth: 75,
	proximity: 90,
	halign : 'center'
	} ) } );
	</script>
	<!-- FIN Script pour la zolie dock :) -->



	<!-- DEBUT Insertion mod eXchange : Header -->



	<img src="$imageFolder/eXchange.png">
	<div class="dock" id="dock">
	  <div class="dock-container">
HEREHEADER;

	for($i = 1 ; $i <= $nombreLien ; $i++)
	{
		$pageHeader .= <<<HEREHEADER
		<a class="dock-item" href="index.php?action=eXchange&module=$link[$i]" title="$title[$i]">
			<img src="$imageFolder/$image[$i].png" title="$title[$i]" />
			<span>$title[$i]</span>
		</a>
HEREHEADER;
	}
	$pageHeader .= <<<HEREHEADER
	  </div> 
	</div>
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />

	<!-- FIN Insertion mod eXchange : Header -->



HEREHEADER;
}

if ($menuFixe  == 1)
{
	$pageHeader = <<<HEREHEADER

	<!-- DEBUT Insertion mod eXchange : Header -->



	<img src="$imageFolder/eXchange.png">
	<br />
HEREHEADER;

	for($i = 1 ; $i <= $nombreLien ; $i++)
	{
		$pageHeader .= <<<HEREHEADER
	<a href="index.php?action=eXchange&module=$link[$i]" title="$title[$i]">
		<img src="$imageFolder/$image[$i].png" style="width: 75px; height: 75px;" title="$title[$i]" />
	</a>
HEREHEADER;
	}
	$pageHeader .= <<<HEREHEADER

	<br />
	<br />
	<br />
	<br />


	<!-- FIN Insertion mod eXchange : Header -->

HEREHEADER;
}

//affichage de la page
 if(!isset($_POST['td']))
 {
 	echo($pageHeader);
 }
 else
 {
 	echo('Modification des options');
 }

?>


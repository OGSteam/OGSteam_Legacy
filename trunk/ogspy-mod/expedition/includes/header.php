<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'accès direct

$imageFolder = FOLDEREXP."images";
$fisheyeFolder = FOLDEREXP."includes/fisheye";
//définition de la page
$menuFixe 	= getOpts($user_data['user_id'], 0);
$eXpDebug	= getOpts($user_data['user_id'], 1);

$nombreLien = 8;
$title[1] =  "Les stats de mes eXpeditions";
$title[2] =  "Les stats des eXpeditions de tous les utilisateurs";
$title[3] =  "Détail de mes eXpeditions";
$title[4] =  "Détail de toutes les eXpeditions";
$title[5] =  "Hall of Fame des eXpeditions";
$title[6] =  "Exporter en BBCode une eXpedition";
$title[7] =  "Options de eXpedition";
$title[8] =  "Ajouter une eXpedition";
$link[1]  =  "stat&sousmodule=user";
$link[2]  =  "stat&sousmodule=global";
$link[3]  =  "detail&sousmodule=user";
$link[4]  =  "detail&sousmodule=global";
$link[5]  =  "hof";
$link[6]  =  "bbcode";
$link[7]  =  "config";
$link[8]  =  "add";
$image[1] =  "2";
$image[2] =  "1";
$image[3] =  "4";
$image[4] =  "3";
$image[5] =  "8";
$image[6] =  "10";
$image[7] =  "7";
$image[8] =  "9";

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



	<!-- DEBUT Insertion	 mod eXpedition : Header -->



	<img src="$imageFolder/eXpedition.png">
	<div class="dock" id="dock">
	  <div class="dock-container">
HEREHEADER;

	for($i = 1 ; $i <= $nombreLien ; $i++)
	{
		$pageHeader .= <<<HEREHEADER
		<a class="dock-item" href="index.php?action=eXpedition&module=$link[$i]" title="$title[$i]">
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

	<!-- FIN Insertion mod eXpedition : Header -->



HEREHEADER;
}

if ($menuFixe  == 1)
{
	$pageHeader = <<<HEREHEADER

	<!-- DEBUT Insertion mod eXpedition : Header -->



	<img src="$imageFolder/eXpedition.png">
	<br />
HEREHEADER;

	for($i = 1 ; $i <= $nombreLien ; $i++)
	{
		$pageHeader .= <<<HEREHEADER
	<a href="index.php?action=eXpedition&module=$link[$i]" title="$title[$i]">
		<img src="$imageFolder/$image[$i].png" style="width: 75px; height: 75px;" title="$title[$i]" />
	</a>
HEREHEADER;
	}
	
	$pageHeader .= <<<HEREHEADER

	<br />
	<br />
	<br />
	<br />


	<!-- FIN Insertion mod eXpedition : Header -->

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


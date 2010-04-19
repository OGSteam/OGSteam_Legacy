<?php
/***************************************************************************
*	filename	: flottes_gbarre.php
*	desc.		:1.03
*	Author		: 
*	created		: 
*	modified	: 
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

//vérification de la version pour compatibilité 
	//$num_of_galaxies = 50;
	//$num_of_systems = 100;
if (!isset($num_of_galaxies) || !isset($num_of_systems)) { 
	$num_of_galaxies = 9;
	$num_of_systems = 499;
}

if(!isset($pub_repartition)) //exit;

function setG($value) {
		global $div_nb, $galaxy_down, $galaxy_nb;
		global $num_of_galaxies, $num_of_systems;
		
		echo $div_nb."-".$galaxy_down."-".$galaxy_nb."-".$num_of_galaxies."-". $num_of_systems;
		
		$space = "  ";
		if($galaxy_nb==2 || $galaxy_nb==8 || $galaxy_nb==4 || $galaxy_nb>=9)
			$space = " ";
		if($galaxy_nb==1)
			$space = "   ";
		$legende = "";
		for($i=0; $i<$div_nb-1; $i++) {
			$s_up = (($num_of_systems+$num_of_systems%2)/$div_nb)*($i+1);
			$s_down = ((($num_of_systems+$num_of_systems%2)/$div_nb)*$i)+1;
			for($j=strlen($s_up);$j<3;$j++) $s_up.=" ";
			for($j=strlen($s_down);$j<3;$j++) $s_down=" ".$s_down;
			$legende .= $space.$s_down."-".$s_up;
		}
		$legende .= $space.(((($num_of_systems+$num_of_systems%2)/$div_nb)*$i)+1)."-".$num_of_systems;
		switch($div_nb) {
			case 1/2:
				$legende = "G".($value*2+$galaxy_down)."\nG".($value*2+$galaxy_down+1);
				break;
			case 1:
				$legende = "G".($value+$galaxy_down);
				break;
			default:
				$l = strlen($legende)/2;
				$legende.= "\n";
				for($j=strlen("G".($value+$galaxy_down));$j<$l;$j++) $legende.=" ";
				$legende .= "G".($value+$galaxy_down);
		}
		return $legende;
	}

$values = explode(":", $pub_repartition);
if(isset($pub_div_nb) && is_numeric($pub_div_nb))
	$div_nb = $pub_div_nb;
else 
	//exit;

if($div_nb<0)
	$div_nb = (-1)/$div_nb;
	
if(isset($pub_galaxy_down) && is_numeric($pub_galaxy_down))
	$galaxy_down = $pub_galaxy_down;
else 
	exit;

$galaxy_nb = intval(sizeof($values)/$div_nb);

for($i=0; $i<sizeof($values); $i++) {
	if($values[$i]=="" || $values[$i]==0) $values[$i]= NULL;
}

require_once "library/artichow/BarPlot.class.php";

$graph = new Graph(750, 250);
//$graph->setTiming(TRUE);
$graph->setAntiAliasing(TRUE);


$graph->setBackgroundColor(new Color(52, 69, 102, 0));
$graph->title->set('Répartition dans l\'univers');
$graph->title->move(0,-5);
$graph->title->setColor(new Color(255, 255, 255, 0));

$group = new PlotGroup;
$group->setPadding(40, 15, 35, 45);

$group->axis->bottom->label->setCallbackFunction('setG');
$group->axis->bottom->label->setColor(new Color(255, 255, 255, 0));
switch($galaxy_nb) {
	case 1:
		$fontSize = 11;
		break;
	case 2:
		$fontSize = 8;
		break;
	case 3:
		$fontSize = 10;
		break;
	case 4:
		$fontSize = 8;
		break;
	case 5:
		$fontSize = 11;
		break;
	case 6:
		$fontSize = 11;
		break;
	case 7:
		$fontSize = 11;
		break;
	case 8:
		$fontSize = 10;
		break;
	case 9:
		$fontSize = 10;
		break;
	case 10:
		$fontSize = 10;
		break;
	default:
		$fontSize = 11;
}
$group->axis->bottom->label->setFont(new TTFFont(dirname(__FILE__).DIRECTORY_SEPARATOR."MONOFONT.TTF", $fontSize));
$group->axis->bottom->title->set("Galaxies");
$group->axis->bottom->title->move(0,12);
$group->axis->bottom->setColor(new Color(150, 150, 150, 0));
$group->axis->left->title->set("Nombre de planetes");
$group->axis->left->title->move(-8,0);
$group->axis->left->setColor(new Color(150, 150, 150, 0));
$group->axis->left->label->setColor(new Color(255, 255, 255, 0));
$group->grid->setColor(new Color(150, 150, 150, 25));
$group->grid->setBackgroundColor(new Color(52, 69, 102, 0));
//$group->setBackgroundImage(new FileImage("../images/OgameSpy_img_fond.jpg"));

for($i=1; $i<=($div_nb<1?1:$div_nb); $i++) {
	$plot = new BarPlot(array_slice($values, $galaxy_nb*($i-1), $galaxy_nb), $i, ($div_nb<1?1:$div_nb));
	$plot->setBarGradient(
	new LinearGradient(
					new Color(100, 70, 150, 50),
					new Color(50, 50, 230, 50),
					0
				)
	);
	$plot->label->set(array_slice($values, $galaxy_nb*($i-1), $galaxy_nb));
	$plot->label->move(0, -8);
	$plot->label->setColor(new Color(255, 255, 255, 0));
	$plot->setBarSpace(5);
	$group->add($plot);
}

$graph->add($group);
$graph->draw();
?>
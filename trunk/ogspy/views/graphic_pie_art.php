<?php
/** $Id: graphic_pie.php 5463 2009-09-23 21:04:26Z scaler $ **/
/**
* Panneau d'affichage: A propos de l'OGsteam et des contributeurs à OGSpy
* @package OGSpy
* @subpackage main
* @author Ben.12
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev: 5463 $)
* @modified $Date: 2009-09-23 23:04:26 +0200 (Wed, 23 Sep 2009) $
* @link $HeadURL: http://svn.ogsteam.fr/OGSpy/trunk/views/graphic_pie.php $
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
/*
* This work is hereby released into the Public Domain.
* To view a copy of the public domain dedication,
* visit http://creativecommons.org/licenses/publicdomain/ or send a letter to
* Creative Commons, 559 Nathan Abbott Way, Stanford, California 94305, USA.
*
*/

if(!isset($pub_values)) exit;

if(!isset($pub_legend)) exit;

if(!isset($pub_title)) exit;

if (!check_var($pub_values, "Special", "#^[0-9(_x_)]+$#") || !check_var($pub_title, "Text") || !check_var($pub_legend, "Text")) {
	exit();
}
$data = explode('_x_', $pub_values);
$legend = explode('_x_', $pub_legend);
$title = $pub_title;


require_once("library/artichow/Pie.class.php");
require_once("library/artichow/Image.class.php");


$graph = new Graph(400, 200);
//$graph->setTiming(TRUE);
$graph->setAntiAliasing(FALSE);
$graph->setBackgroundColor(new Color(52, 69, 102, 0));

$title = new Label($title, new Tuffy(13), new White(), 0);
$graph->title = $title;
$graph->title->move(0, 4);

$plot = new Pie($data);
$plot->setBackgroundImage(new FileImage("images/graphic_background.jpg"));
$plot->setCenter(0.38, 0.50);
$plot->setSize(0.60, 0.70);
$plot->set3D(20);
$plot->setStartAngle(45);
$plot->setBorder(new Blue(50));




$plot->setLegend($legend);
$plot->legend->setPosition(1.50);
$plot->legend->setBackgroundGradient(
new LinearGradient(
new Color(60, 60, 100, 50),
new Color(200, 200, 200, 50),
0
)
);
$plot->legend->setTextColor(new Color(255, 255, 255, 0));
$plot->legend->shadow->show(FALSE);
$plot->legend->setPadding(3, 3, 3, 3);
$plot->legend->setPosition(1.5, 0.57);

$plot->label->setPadding(2, 2, 2, 2);
$plot->label->border->setColor(new Black(60));
$plot->label->setFont(new Tuffy(8));
$plot->label->setColor(new Color(255, 255, 255, 0));
$plot->label->setBackgroundGradient(
new LinearGradient(
new Blue(80),
new White(90),
0
)
);
$plot->setLabelPrecision(1);


$graph->add($plot);
$graph->draw();

?>

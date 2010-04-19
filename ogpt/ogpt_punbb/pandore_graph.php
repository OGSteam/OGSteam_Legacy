<?php
/***************************************************************************
*	filename	: index.php
*	desc.		:
*	Author		: Ben.12 - http://ogsteam.fr/
*	created		:
*	modified	: 22/06/2006 00:13:20
*	modified	: 30/07/2006 00:00:00
***************************************************************************/


/*
* This work is hereby released into the Public Domain.
* To view a copy of the public domain dedication,
* visit http://creativecommons.org/licenses/publicdomain/ or send a letter to
* Creative Commons, 559 Nathan Abbott Way, Stanford, California 94305, USA.
*
*/

$pub_values = trim($_GET['values']);

$pub_legend = trim($_GET['legend']);

$pub_title = trim($_GET['title']);

$hauteur = trim($_GET['hauteur']);
$largeur = trim($_GET['largeur']);

$data = explode('_x_', $pub_values);
$legend = explode('_x_', $pub_legend);
$title = $pub_title;


require_once ("./ogpt/Artichow/Pie.class.php");
require_once ("./ogpt/Artichow/Image.class.php");


$graph = new Graph($largeur, $hauteur);
//$graph->setTiming(TRUE);
$graph->setAntiAliasing(false);
$graph->setBackgroundColor(new Color(52, 69, 102, 0));

$title = new Label($title, new Tuffy(13), new White(), 0);
$graph->title = $title;
$graph->title->move(0, 4);

$plot = new Pie($data);
//$plot->setBackgroundImage(new FileImage("./ogpt/img/graphic_background.jpg"));
$plot->setCenter(0.38, 0.50);
$plot->setSize(0.60, 0.70);
$plot->set3D(20);
$plot->setStartAngle(45);
$plot->setBorder(new Blue(50));


$plot->setLegend($legend);
$plot->legend->setPosition(1.50);
$plot->legend->setBackgroundGradient(new LinearGradient(new Color(60, 60, 100,
    50), new Color(200, 200, 200, 50), 0));
$plot->legend->setTextColor(new Color(255, 255, 255, 0));
$plot->legend->shadow->show(false);
$plot->legend->setPadding(3, 3, 3, 3);
$plot->legend->setPosition(1.5, 0.57);

$plot->label->setPadding(2, 2, 2, 2);
$plot->label->border->setColor(new Black(60));
$plot->label->setFont(new Tuffy(8));
$plot->label->setColor(new Color(255, 255, 255, 0));
$plot->label->setBackgroundGradient(new LinearGradient(new Blue(80), new White(90),
    0));
$plot->setLabelPrecision(1);


$graph->add($plot);
$graph->draw();

?>
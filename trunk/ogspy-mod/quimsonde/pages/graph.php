<?php
/**
 * graph.php 

Permet l'affichage d'une courbe personnalisée.

 * @package QuiMSonde
 * @author Sylar
 * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08

 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

if(!isset($pub_values)) exit; if(!isset($pub_legend)) exit; if(!isset($pub_title)) exit;
if (!check_var($pub_values, "Special", "#^[0-9(_x_)]+$#") || !check_var($pub_title, "Text") || !check_var($pub_legend, "Text"))
	exit();
$data_str_tab = explode('_x_', $pub_values);
foreach($data_str_tab as $data0)
	$data[] = intval($data0);
$legend = explode('_x_', $pub_legend);
$titre = $pub_title;

require_once("library/artichow/LinePlot.class.php");
require_once("library/artichow/Image.class.php");

$graph = new Graph(750,280);
$plot = new LinePlot($data);
$graph->title->set($titre);
$graph->title->move(0, -5);
$graph->title->setFont(new Tuffy(12));
$graph->title->setColor(new Color(255, 255, 255, 0));
$graph->setAntiAliasing(TRUE);
$plot->setColor(new Color(255,0,0));
$plot->setBackgroundColor(new Color(52, 69, 102, 0));
$plot->setSpace(5,5,NULL,NULL);
$plot->setFillColor(new Color(180, 180, 180, 75));
$plot->xAxis->setLabelText($legend);
$plot->grid->setBackgroundColor(new Color(235, 235, 180, 60));
$graph->add($plot);
$graph->draw();

?>
<?php
/***************************************
 * Generate a graphic pie chart with Phplot library (http://phplot.sourceforge.net)
 * @author:		ericc
 * @package:	OGSpy 4.0
 * @copyright:	Copyright © 2010, http://www.ogsteam.fr
 * @version:	1.0
 **************************************/
/*
* This work is hereby released into the Public Domain.
* To view a copy of the public domain dedication,
* visit http://creativecommons.org/licenses/publicdomain/ or send a letter to
* Creative Commons, 559 Nathan Abbott Way, Stanford, California 94305, USA.
*/
/* No direct call */
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
/* Check if we receive all variables */
if(!isset($pub_values)) exit;
if(!isset($pub_legend)) exit;
if(!isset($pub_title)) exit;
/* Check variables content */
if (!check_var($pub_values, "Special", "#^[0-9(_x_)]+$#") || !check_var($pub_title, "Text") || !check_var($pub_legend, "Text"))
{
	exit();
}
/* Explode variables $data & $legend will be array() */
$data = explode('_x_', $pub_values);
$legend = explode('_x_', $pub_legend);
$title = $pub_title;

/* array $legend must have, at least, the same number of elements as $data, if not we add some empty element */
if (count($legend)<count($data))
{
	$legend = array_pad($legend,count($data),"");
}
/* combine both array $legend & $data in 1 array of array - only the number of values is important */
$data_plot = array();
for ($i=0 ; $i<count($data) ; $i++)
{
	$data_plot[] = array($legend[$i],$data[$i]);
}
/****************************************/
/* Load phplot class */
require_once("./library/phplot/Myphplot.php");
/* Create $plot object with size of the picture (x,y) */
$plot = new MyPHPlot(400,200);
/* Define type of plot */
$plot->SetPlotType('pie');
/* Type of data used */
$plot->SetDataType('text-data-single');

$plot->SetImageBorderType('plain');
/* Define background color and picture */
$plot->SetBackgroundColor('#344566');
$plot->SetBgImage("./images/graphic_background.png",'scale');
/* Define different colors used in the order data */
$plot->SetDataColors(array('#bbd597','#dfb197','#6fba84','#c5a0e6','#a5a93f','#dab159','#74cd79','#c8c94e','#7fcdb1'));
/* Define the TTF font to be used. I take the font used by Artichow */
$plot->SetDefaultTTFont('./library/phplot/font/Tuffy.ttf');
/* Color of the Title */
$plot->SetTitleColor('white');
/* Color of the text, in this case in the legend box */
$plot->SetTextColor('white');
/* This is to change the color of the Label (%) ... strange */
$plot->SetGridColor('white');
// Main plot title:
$plot->SetTitle($title);
// Build a legend text from our legend array.
$plot->SetLegend($legend);
/* Alignment of the text and the color box in the legend */
$plot->SetLegendStyle('left','left');
/* Position of the legend box in image coordinates */
$plot->SetLegendPixels(300, 50);
/* position of the Label (%): 0 is the middle of the pie, 1 is completely out of the picture */
$plot->SetLabelScalePosition(0.6);
/* Define the plot area - */
$plot->SetPlotAreaPixels(5,5,350,NULL);
/* Send data array to the plot object */
$plot->SetDataValues($data_plot);
/* 3D effect - O = flat pie */
$plot->SetShading(15);

$plot->SetLegendBorderColor('black');

/* Draw the picture */
$plot->DrawGraph();

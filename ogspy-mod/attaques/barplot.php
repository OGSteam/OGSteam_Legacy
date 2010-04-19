<?php
/*
 * This work is hereby released into the Public Domain.
 * To view a copy of the public domain dedication,
 * visit http://creativecommons.org/licenses/publicdomain/ or send a letter to
 * Creative Commons, 559 Nathan Abbott Way, Stanford, California 94305, USA.
 *
 */
 /**
 * barplot.php génération d'histogramme en barres 3D 
 * @package Attaques
 * @author  ericc
 * @link http://www.ogsteam.fr
 * @version : 0.8d
 */
// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
// Appel de la librairie Artichow pour tracer des histogrammes
require_once "library/artichow/BarPlot.class.php";
global $db, $table_prefix, $prefixe;
// Gestion des dates - récupère le mois et l'année courants 
$mois = date("m");
$annee = date("Y");
$maxy=0;

function color($a = NULL) {
    if($a === NULL) {
        $a = 0;
    }
    return new Color(mt_rand(20, 180), mt_rand(20, 180), mt_rand(20, 180), $a);
}

// Initialisation du graphique
$graph = new Graph(800, 600);
// Active l'AntiAliasing pour avoir un graph plus net
$graph->setAntiAliasing(TRUE);
// cache la bordure du graphe
$graph->border->hide();
// Initialisation d'un group de plot
$group = new PlotGroup;
//setSpace(/* Gauche */,/* Droite */,/* Haut */,/* Bas */);
// paramétrage des espaces autour du graphe 
//$group->setSpace(1, 5, NULL, NULL);
// parametrage des espaces entre barres
$group->setPadding(40, 10, NULL, 20);
//$group->setXAxisZero(FALSE);
$group->axis->bottom->setColor(new White);
$group->axis->bottom->label->setColor(new White);
$group->axis->left->setColor(new White);
$group->axis->left->setLabelPrecision(0);
$group->axis->left->label->setColor(new White);
$group->setBackgroundColor(new Color(0, 0, 20));
$group->grid->setNoBackground();
$group->grid->setType(2);
// Définition des couleurs des barres
$colors = array(
    new Color(187, 213, 151, 20), // Métal
    new Color(223, 177, 151, 20), // Cristal
    new Color(111, 186, 132, 20)  // Deutérium
);
// Définition des labels des jours sur l'axe X
function setday($value) {
    return $value + 1;
}
$group->axis->bottom->label->setCallbackFunction('setday');
// Définition du tableau pour les textes dans le label
$nom_ress[0]="Métal";
$nom_ress[1]="Cristal";
$nom_ress[2]="Deutérium";

switch ($pub_subaction)
{
  case "attaques" :
    $query="SELECT DAY(FROM_UNIXTIME(attack_date)) AS day, SUM(attack_metal) AS metal, SUM(attack_cristal) AS cristal, SUM(attack_deut) AS deut FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data['user_id']." and MONTH(FROM_UNIXTIME(attack_date))=".$mois." and YEAR(FROM_UNIXTIME(attack_date))=".$annee." GROUP BY day"; 
    break;
  case "recyclage" :
    $query2="SELECT DAY(FROM_UNIXTIME(recy_date)) AS day, SUM(recy_metal) AS metal, SUM(recy_cristal) AS cristal FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id=".$user_data['user_id']." and MONTH(FROM_UNIXTIME(recy_date))=".$mois." and YEAR(FROM_UNIXTIME(recy_date))=".$annee." GROUP BY day";
    break;
  case "bilan" :
    $query="SELECT DAY(FROM_UNIXTIME(attack_date)) AS day, SUM(attack_metal) AS metal, SUM(attack_cristal) AS cristal, SUM(attack_deut) AS deut FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data['user_id']." and MONTH(FROM_UNIXTIME(attack_date))=".$mois." and YEAR(FROM_UNIXTIME(attack_date))=".$annee." GROUP BY day";
    $query2="SELECT DAY(FROM_UNIXTIME(recy_date)) AS day, SUM(recy_metal) AS metal, SUM(recy_cristal) AS cristal FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id=".$user_data['user_id']." and MONTH(FROM_UNIXTIME(recy_date))=".$mois." and YEAR(FROM_UNIXTIME(recy_date))=".$annee." GROUP BY day";
    break;
}

// requète SQL pour récupérer le total par ressource par jour
 $result = $db->sql_query($query);

// Initialisation des variables et tableau

$barre = array();
// Lecture de la base de données et stockage des valeurs dans le tableau
if ( $pub_subaction !="recyclage")
{
while (list($jour, $metal, $cristal, $deut) = $db->sql_fetch_row($result))
    {
    $barre[$jour][0]=$metal;
    $barre[$jour][1]=$cristal;
    $barre[$jour][2]=$deut;
    
    // on recherche la valeur la plus grande pour définir la valeur maxi de l'axe Y
    if ($metal>$maxy) {$maxy=$metal;}
    if ($cristal>$maxy) {$maxy=$cristal;}
    if ($deut>$maxy)  {$maxy=$deut;}
  }
}
if (isset($query2))
  {
  $result2 = $db->sql_query($query2);
  while (list($jour, $metal, $cristal) = $db->sql_fetch_row($result2))
    {
    if ( !isset($barre[$jour][0])) {$barre[$jour][0]=0;}
    if ( !isset($barre[$jour][1])) {$barre[$jour][1]=0;}
    $barre[$jour][0] += $metal;
    $barre[$jour][1] += $cristal;
    
    // on recherche la valeur la plus grande pour définir la valeur maxi de l'axe Y
    if ($metal>$maxy) {$maxy=$metal;}
    if ($cristal>$maxy) {$maxy=$cristal;}
    }
  }
for($n = 0; $n < 3; $n++) 
  {   
    $x = array();
    // On récupère les valeurs stockés dans le tableau et on les passe dans celui du graphique 
    for($i = 1; $i < 32; $i++) {
        if ( ! isset($barre[$i][$n])) {$barre[$i][$n]=0;}
        $x[] = $barre[$i][$n];
    }
    // On paramètre la barre
    $plot = new BarPlot($x, 1, 1, (2 - $n) * 7);
    $plot->barBorder->setColor(new White);
    //$plot->setBarSize(0.54);
    $plot->barShadow->setSize(3);
    $plot->barShadow->setPosition(SHADOW_RIGHT_TOP);
    // erreur dans la Class Shadow de Artichow (http://artichow.org/forum/read.php?2,490,505)
    //$plot->barShadow->setColor(new Color(160, 160, 160, 10));
    $plot->barShadow->smooth(TRUE);
    $plot->setBarColor($colors[$n]);
    // et on l'ajoute au graphique
    $group->add($plot);
    $group->legend->add($plot, $nom_ress[$n], LEGEND_BACKGROUND); 
  }

$group->setYMax($maxy);
$group->setXMax(31);
$group->legend->shadow->setSize(0);
$group->legend->setAlign(LEGEND_CENTER);
$group->legend->setSpace(6);
$group->legend->setTextFont(new Tuffy(8));
$group->legend->setPosition(0.50, 0.1);
$group->legend->setBackgroundColor(new Color(255, 255, 255, 25));
$group->legend->setColumns(2);

$graph->add($group);
$graph->draw();
?> 
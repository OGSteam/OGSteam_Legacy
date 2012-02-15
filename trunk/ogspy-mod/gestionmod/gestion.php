<?php

/**
* gestion.php Fichier de gestion des diferentes parties
* @package Gestion MOD
* @author Kal Nightmare
* @Mise à jour par xaviernuma 2012
* @link http://www.ogsteam.fr
*/

/*
	xaviernuma - 2012 :
	
	- Identation du code.
	- Renommage des variables.
	- Déclaration des variables non déclaré.
	- Simplification des fonctions.
	- [Correction] lorsqu'un mod était déplacé en première ou dernière position, il ne bougait pas.
	- [Correction] Contrôle des entrées avec le même nom de mod.
	- [Correction] On ne peut plus créer groupe vide.
*/

if (!defined('IN_SPYOGAME')) 
{
	die("Hacking attempt");
}

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='gestion' AND `active`='1' LIMIT 1";

if (!$db->sql_numrows($db->sql_query($query)))
{
	die("Hacking attempt");
}

define("GESTION_MOD", true);

global $user_data;
$s_html = '';

//récupération du dossier et de la version
$query = "SELECT root, version FROM `" . TABLE_MOD . "` WHERE `action`='gestion'";
$result = $db->sql_fetch_assoc($db->sql_query($query));
$dir = "gestionmod";
$version = $result['version'];

require_once("views/page_header.php");
require_once("mod/".$dir."/function.php");

if ($user_data["user_admin"] != 1  && $user_data["user_coadmin"] != 1)
{
	redirection("index.php?action=message&id_message=forbidden&info");
} 

if (!isset($pub_subaction)) 
{
	$pub_subaction = 'list';
}

$req = "SELECT * FROM `" . TABLE_MOD . "` WHERE `action` = 'autoupdate' and `active`= 1 ";
$res = $db->sql_query($req);

if ($db->sql_numrows($res) > 0) 
{
	$nb_colonnes = 5;
	$row = $db->sql_fetch_assoc($res);
	$lien = 'mod/'.$row['root'].'/'.$row['link'];
} 
else 
{
	$nb_colonnes = 4;
}

$n_taille_colonne = floor(100/$nb_colonnes);

$s_html .= '<table align="center" width="100%" cellpadding="0" cellspacing="1">';
$s_html .= 		'<tr align="center"><td class="c" colspan="'.$nb_colonnes.'">GESTION MOD</td></tr>';
$s_html .= 		'<tr align="center">';


if ($pub_subaction != 'list')
{
	$s_html .= '<td class="c" style="width:'.$n_taille_colonne.'%;"><a href="index.php?action=gestion&subaction=list" style="color: lime;"';
}
else
{
	$s_html .= '<th style="width:'.$n_taille_colonne.'%;"><a';
}
$s_html .= '>Liste MOD</a></td>';

if ($pub_subaction != 'group') 
{
	$s_html .= '<td class="c" style="width:'.$n_taille_colonne.'%;"><a href="index.php?action=gestion&subaction=group" style="color: lime;"';
}
else
{ 
	$s_html .= '<th style="width:'.$n_taille_colonne.'%;"><a';
}

$s_html .= '>Gestion Groupes</a></td>';

if ($pub_subaction != 'mod') 
{
	$s_html .= '<td class="c" style="width:'.$n_taille_colonne.'%;"><a href="index.php?action=gestion&subaction=mod" style="color: lime;"';
}
else 
{
	$s_html .= '<th style="width:'.$n_taille_colonne.'%;"><a';
}
$s_html .= '>Renommeur de MOD</a></td>';


$s_html .= '<td class="c" style="width:'.$n_taille_colonne.'%;"><a href="index.php?action=administration&subaction=mod" style="color: lime;"';
$s_html .= '>Administration des mods</a></td>';

if 	($nb_colonnes == 5) 
{
	if ($pub_subaction != 'modUpdate') 
	{
		$s_html .= '<td class="c" style="width:'.$n_taille_colonne.'%;"><a href="index.php?action=gestion&subaction=modUpdate" style="color: lime;"';
	}
	else 
	{
		$s_html .= '<th style="width:'.$n_taille_colonne.'%;"><a';
	}
	$s_html .= '>AutoUpdate</a></td>';
}

$s_html .= '</tr>';
$s_html .= '</table>';

echo $s_html;

switch ($pub_subaction) 
{
	case 'list':
		require('mod/'.$dir.'/list.php');
		break;

	case 'group':
		require('mod/'.$dir.'/group.php');
		break;

	case 'mod':
		require('mod/'.$dir.'/rename.php');
		break;

	case 'modUpdate':
		require($lien);
		break;
		
	case 'new_group':
		new_group();
		break;

	case 'action_group':
		group();
		break;
	case 'action_mod' :
		mod();
		break;
		
	default:
		require('mod/'.$dir.'/list.php');
}

if($pub_subaction <> 'modUpdate')
{
	$s_html = '';
	$s_html .= '<div style="font-size: 10px;width: 400px;text-align:center;background-image:url(\'skin/OGSpy_skin/tableaux/th.png\');background-repeat:repeat;">Gestion MOD ('.$version.')';
	$s_html .= '<br>Développé par <a href="mailto:kalnightmare@free.fr">Kal Nightmare</a> 2006';
	$s_html .= '<br>Mise à jour par <a href="http://www.ogsteam.fr/">xaviernuma</a> 2012</div>';

	echo $s_html;
}

require_once("views/page_tail.php");

?>
<?php

/**
* list.php Fichier de gestion pour ordonenr les mods
* @package Gestion MOD
* @author Kal Nightmare
* @Mise à jour par xaviernuma 2012
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) 
{
	die("Hacking attempt");
}
$s_html = '';
$list_all = list_all();
$s_html_normal = '';
$s_html_admin = '';

// On parcourt tout les mods
for ($i = 1 ; $i <= count($list_all) ; $i++) 
{
	switch ($list_all[$i]['type']) 
	{
		case 0 : // Mod classique
			if($list_all[$i]['active'] == 1)
			{
				if($list_all[$i]['admin_only'] == 1) // Si c'est un mod de type admin alors...
				{
					$s_html_admin .= "<tr class='lime'><th>".$list_all[$i]['position']."</th>";
					$s_html_admin .= "<th>".$list_all[$i]['menu']."</th>";
				}
				else
				{
					$s_html_normal .= "<tr class='lime'><th>".$list_all[$i]['position']."</th>";
					$s_html_normal .= "<th>".$list_all[$i]['menu']."</th>";
				}
			}
			else 
			{
				if($list_all[$i]['admin_only'] == 1) // Si c'est un mod de type admin alors...
				{
					$s_html_admin .= "<tr class='red'><th>".$list_all[$i]['position']."</th>";
					$s_html_admin .= "<th>".$list_all[$i]['menu']."</th>";
				}
				else
				{
					$s_html_normal .= "<tr class='red'><th>".$list_all[$i]['position']."</th>";
					$s_html_normal .= "<th>".$list_all[$i]['menu']."</th>";
				}
			}
			break;
		case 1 : // Groupe
			$s_html_normal .= "<tr class='blue'><th>".$list_all[$i]['position']."</th>";
			$s_html_normal .= "<th>Groupe : ".name_group($list_all[$i]['menu'])."</th>";
			break;
	}
	
	$s_html_commun = 	'<th>';
	$s_html_commun .= 		'<input type="button" name="ordre" value="Monter" onclick="javscript:f_submit(\''.$pub_subaction.'\', \''.$list_all[$i]['id'].'\', \''.$list_all[$i]['position'].'\', \''.count($list_all).'\', \'place_voulue'.$i.'\', \'Monter\' );" />';
	$s_html_commun .= 		'<input type="button" name="ordre" value="Descendre" onclick="javscript:f_submit(\''.$pub_subaction.'\', \''.$list_all[$i]['id'].'\', \''.$list_all[$i]['position'].'\', \''.count($list_all).'\', \'place_voulue'.$i.'\', \'Descendre\' );" />';
	$s_html_commun .= 	'</th>';
	$s_html_commun .= 	'<th><input type="text" name="place_voulue'.$i.'" id="place_voulue'.$i.'" size="2" maxlength="2" value="'.$list_all[$i]['position'].'" /></th>';
	$s_html_commun .= 	'<th><input type="button" name="ordre" value="Déplacer" onclick="javscript:f_submit(\''.$pub_subaction.'\', \''.$list_all[$i]['id'].'\', \''.$list_all[$i]['position'].'\', \''.count($list_all).'\', \'place_voulue'.$i.'\', \'Deplacer\' );" /></th>';
	$s_html_commun .= '</tr>';
	
	if($list_all[$i]['admin_only'] == 1)
	{
		$s_html_admin .= $s_html_commun;
	}
	else
	{
		$s_html_normal .= $s_html_commun;
	}
}


$s_html .= '<style type="text/css">';
$s_html .= '<!--';
$s_html .= '.lime {color: lime;}';
$s_html .= '.red {color: red;}';
$s_html .= '.blue {color: #5CCCE8;}';
$s_html .= '-->';
$s_html .= '</style>';

$s_html .= 	'<script type="text/javascript">';
$s_html .= 	'function f_submit(page, id, position, place_limite, place_voulue, ordre)';
$s_html .= 	'{';
$s_html .= 		'document.getElementById(\'page\').value = page;';
$s_html .= 		'document.getElementById(\'id\').value = id;';
$s_html .= 		'document.getElementById(\'position\').value = position;';
$s_html .= 		'document.getElementById(\'place_limite\').value = place_limite;';
$s_html .= 		'document.getElementById(\'ordre\').value = ordre;';
$s_html .= 		'document.getElementById(\'place_voulue\').value = document.getElementById(place_voulue).value;';
$s_html .= 		'document.getElementById(\'formulaire_deplacement\').submit();';
$s_html .= 	'}';
$s_html .= 	'</script>';

$s_html .= '<br>';
$s_html .= '<table>';
$s_html .= 	'<tr><td class="c" colspan="5" width="650">Normal</td></tr>';
$s_html .= 	$s_html_normal;
$s_html .= '</table>';

$s_html .= '<br>';
$s_html .= '<table>';
$s_html .= 	'<tr><td class="c" colspan="5" width="650">Admin</td></tr>';
$s_html .= 	$s_html_admin;
$s_html .= '</table>';

$s_html .= '<form id="formulaire_deplacement" method="post" action="index.php?action=gestion&subaction=action_mod">';
$s_html .= 		'<input type="hidden" name="page" id="page" value="" />';
$s_html .= 		'<input type="hidden" name="id" id="id" value="" />';
$s_html .= 		'<input type="hidden" name="position" id="position" value="" />';
$s_html .= 		'<input type="hidden" name="place_limite" id="place_limite" value="" />';
$s_html .= 		'<input type="hidden" name="place_voulue" id="place_voulue" value="" />';
$s_html .= 		'<input type="hidden" name="ordre" id="ordre" value="" />';
$s_html .= '</form>';

echo $s_html;

?>
<?php
/**
* group.php Fichier de gestion des groupes
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

$s_html .= '<form method="post" action="index.php?action=gestion&subaction=new_group">';

$s_html .= '<br>';
$s_html .= '<table>';
$s_html .= 	'<tr>';
$s_html .= 		'<td class="c" colspan="3">Nouveau groupe</td>';
$s_html .= 	'</tr>';
$s_html .= 	'<tr>';
$s_html .= 		'<th class="c" rowspan="2">Nom</th>';
// $s_html .= '<th colspan="2">Afficher un espace '.infobulle("Pour le premier groupe ne pas afficher d'espace","Conseil").'</th></tr>';
$s_html .= 		'<th colspan="2">Afficher un espace</th>';
$s_html .= 	'</tr>';
$s_html .= 	'<tr>';
$s_html .= 		'<th>Oui</th>';
$s_html .=		'<th>Non</th>';
$s_html .= 	'</tr>';
$s_html .= 	'<tr>';
$s_html .= 		'<th><input type="text" name="new_group" size="100" maxlength="250"></th>';
$s_html .= 		'<th><input type="radio" name="espace" value="oui" /></th>';
$s_html .= 		'<th><input type="radio" name="espace" value="non" checked="checked" /></th>';
$s_html .= '</tr>';
$s_html .= '<tr><th class="c" colspan="3"><input type="submit" value="Nouveau Groupe" /></th></tr>';
$s_html .= '</table>';

$s_html .= '</form>';

$list_group = list_group();
// Si il n'y a pas de groupe de créé, on n'affiche pas le tableau des groupes existant
if(count($list_group) != 0)
{
	$s_html .= 	'<script type="text/javascript">';
	$s_html .= 	'function f_submit(num_group, nom_group, espace, ordre)';
	$s_html .= 	'{';
	$s_html .= 		'for (var i=0; i<document.getElementsByName(espace).length;i++)';
	$s_html .= 		'{';
	$s_html .= 			'if (document.getElementsByName(espace)[i].checked)';
	$s_html .= 			'{';
	$s_html .= 				'document.getElementById(\'espace\').value = document.getElementsByName(espace)[i].value;';
	$s_html .= 			'}';
	$s_html .= 		'}';
	$s_html .= 		'document.getElementById(\'num_group\').value = num_group;';
	$s_html .= 		'document.getElementById(\'nom_group\').value = nom_group;';
	$s_html .= 		'document.getElementById(\'ordre\').value = ordre;';
	$s_html .= 		'document.getElementById(\'form_modification_mod\').submit();';
	$s_html .= 	'}';
	$s_html .= 	'</script>';

	$s_html .= '<table>';
	$s_html .= 	'<tr><td class="c" colspan="5" >Groupe existant</td></tr>';
	$s_html .= 	'<tr><th class="c" rowspan="2">Nom</th>';
	// $s_html .= '<th colspan="2">Afficher un espace '.infobulle("Pour le premier groupe ne pas afficher d'espace","Conseil").'</th>';
	$s_html .= 		'<th colspan="2">Afficher un espace</th>';
	$s_html .= 		'<th colspan="2" rowspan="2"></th>';
	$s_html .= 	'</tr>';
	$s_html .= 	'<tr>';
	$s_html .= 		'<th>Oui</th>';
	$s_html .= 		'<th>Non</th>';
	$s_html .= 	'</tr>';
	
	for ($i = 0 ; $i < count($list_group) ; $i++) 
	{
		$s_html .= 	'<tr>';
		$s_html .= 		'<th><input type="text" name="nom_group" size="100" maxlength="250" value="'.name_group($list_group[$i]['Nom']).'" /></th>';
		
		if ($list_group[$i]['Espace'] == 'oui' ) 
		{
			$s_html .= '<th><input type="radio" name="espace_'.$i.'" value="oui" checked="checked" /></th>';
			$s_html .= '<th><input type="radio" name="espace_'.$i.'" value="non" /></th>';
		}
		else 
		{	
			$s_html .= '<th><input type="radio" name="espace_'.$i.'" value="oui" /></th>';
			$s_html .= '<th><input type="radio" name="espace_'.$i.'" value="non" checked="checked" /></th>';
		}
		
		$s_html .= 		'<th class="c"><input type="button" onclick="javascript:f_submit(\''.$list_group[$i]['Num'].'\', \''.name_group($list_group[$i]['Nom']).'\', \'espace_'.$i.'\',\'Renommer Groupe\' );" name="ordre" value="Renommer Groupe" /></th>';
		$s_html .= 		'<th class="c"><input type="button" onclick="javascript:f_submit(\''.$list_group[$i]['Num'].'\', \''.name_group($list_group[$i]['Nom']).'\', \'espace_'.$i.'\',\'Supprimer Groupe\' );" name="ordre" value="Supprimer Groupe" /></th>';
		$s_html .= 	'</tr>';
	}

	$s_html .= '</table>';

	$s_html .= '<form id="form_modification_mod" method="post" action="index.php?action=gestion&subaction=action_group">';
	$s_html .= 		'<input type="hidden" name="num_group" id="num_group" value="" />';
	$s_html .= 		'<input type="hidden" name="ordre" id="ordre" value="" />';
	$s_html .= 		'<input type="hidden" name="espace" id="espace" value="" />';
	$s_html .= 		'<input type="hidden" name="nom_group" id="nom_group" value="" />';
	$s_html .= '</form>';
}

echo $s_html;

?>
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

// Code HTML pour la création de groupe
$s_html .= '<form method="post" action="index.php?action=gestion&subaction=new_group">';

$s_html .= '<br>';
$s_html .= '<table>';
$s_html .= 	'<tr>';
$s_html .= 		'<td class="c" colspan="2">Nouveau groupe</td>';
$s_html .= 	'</tr>';
$s_html .= 	'<tr>';
$s_html .= 		'<th class="c">Nom</th>';
$s_html .= 		'<th>Admin</th>';
$s_html .= 	'</tr>';
$s_html .= 	'<tr>';
$s_html .= 		'<th><input type="text" name="new_group" size="100" maxlength="250"></th>';
$s_html .= 		'<th><input type="checkbox" name="admin" value="" /></th>';
$s_html .= '</tr>';
$s_html .= '<tr><th class="c" colspan="3"><input type="submit" value="Nouveau Groupe" /></th></tr>';
$s_html .= '</table>';

$s_html .= '</form>';

$list_group = list_group();


// Code HTML pour la modification de groupe
if(count($list_group) != 0) // Si il n'y a pas de groupe de créé, on n'affiche pas le tableau des groupes existant
{
	$s_html .= 	'<script type="text/javascript">';
	$s_html .= 	'function f_submit(num_group, nom_group, admin, ordre)';
	$s_html .= 	'{';
	$s_html .= 		'document.getElementById(\'admin\').value = 0;';
	$s_html .= 		'for (var i=0; i<document.getElementsByName(admin).length;i++)';
	$s_html .= 		'{';
	$s_html .= 			'if (document.getElementsByName(admin)[i].checked)';
	$s_html .= 			'{';
	$s_html .= 				'document.getElementById(\'admin\').value = 1;';
	$s_html .= 			'}';
	$s_html .= 		'}';
	$s_html .= 		'document.getElementById(\'num_group\').value = num_group;';
	$s_html .= 		'document.getElementById(\'nom_group\').value = document.getElementById(nom_group).value;';
	$s_html .= 		'document.getElementById(\'ordre\').value = ordre;';
	$s_html .= 		'document.getElementById(\'form_modification_mod\').submit();';
	$s_html .= 	'}';
	$s_html .= 	'</script>';

	$s_html .= '<table>';
	$s_html .= 	'<tr><td class="c" colspan="4" >Groupe existant</td></tr>';
	$s_html .= 	'<tr><th class="c">Nom</th>';
	$s_html .= 		'<th>Admin</th>';
	$s_html .= 		'<th colspan="2"></th>';
	$s_html .= 	'</tr>';
	
	for ($i = 0 ; $i < count($list_group) ; $i++) 
	{
		$s_html .= 	'<tr>';
		$s_html .= 		'<th><input type="text" name="nom_group'.$i.'" id="nom_group'.$i.'" size="100" maxlength="250" value="'.name_group($list_group[$i]['Nom']).'" /></th>';
		
		if ($list_group[$i]['admin'] == '1' ) 
		{
			$s_html .= '<th><input type="checkbox" name="admin'.$i.'" value="" checked="checked" /></th>';
		}
		else 
		{	
			$s_html .= '<th><input type="checkbox" name="admin'.$i.'" value="" /></th>';
		}
		
		$s_html .= 		'<th class="c"><input type="button" onclick="javascript:f_submit(\''.$list_group[$i]['Num'].'\', \'nom_group'.$i.'\', \'admin'.$i.'\',\'Renommer Groupe\');" name="ordre" value="Renommer Groupe" /></th>';
		$s_html .= 		'<th class="c"><input type="button" onclick="javascript:f_submit(\''.$list_group[$i]['Num'].'\', \'nom_group'.$i.'\', \'admin'.$i.'\',\'Supprimer Groupe\');" name="ordre" value="Supprimer Groupe" /></th>';
		$s_html .= 	'</tr>';
	}

	$s_html .= '</table>';

	$s_html .= '<form id="form_modification_mod" method="post" action="index.php?action=gestion&subaction=action_group">';
	$s_html .= 		'<input type="hidden" name="num_group" id="num_group" value="" />';
	$s_html .= 		'<input type="hidden" name="ordre" id="ordre" value="" />';
	$s_html .= 		'<input type="hidden" name="admin" id="admin" value="" />';
	$s_html .= 		'<input type="hidden" name="nom_group" id="nom_group" value="" />';
	$s_html .= '</form>';
}

$s_html .= '<div id="aide" style="display:block;font-size: 12px;width: 800px;text-align:left;background-image:url(\'skin/OGSpy_skin/tableaux/th.png\');background-repeat:repeat;">';
$s_html .= 'Voici quelques exemples de code HTML que vous pouvez utiliser pour changer le style d\'écriture.';
$s_html .= 	'<ul>';
$s_html .=  	'<li>'.htmlentities ('<font color="red">Gestion des attaques</font>').' : <font color="red">Gestion des attaques</font><br>';
$s_html .= 		'<li>'.htmlentities ('<font size="3">Gestion des attaques</font>').' : <font size="3">Gestion des attaques</font><br>';
$s_html .= 		'<li>'.htmlentities ('<br>').' : Aller à la ligne.<br>';
$s_html .= 		'<li>'.htmlentities ('<u>Gestion des attaques</u>').' : <u>Gestion des attaques</u><br>';
$s_html .= 		'<li>'.htmlentities ('<i>Gestion des attaques</i>').' : <i>Gestion des attaques</i><br>';
$s_html .= 		'<li>'.htmlentities ('<b>Gestion des attaques</b>').' : <b>Gestion des attaques</b><br>';
$s_html .= 	'</ul>';
$s_html .= '</div>';

echo $s_html;

?>
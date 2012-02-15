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
					$s_html_admin .= "<tr id=".$list_all[$i]['id']." class='lime'>";
					$s_html_admin .= "<th>".$list_all[$i]['menu']."</th></tr>";
				}
				else
				{
					$s_html_normal .= "<tr id=".$list_all[$i]['id']." class='lime'>";
					$s_html_normal .= "<th>".$list_all[$i]['menu']."</th></tr>";
				}
			}
			else 
			{
				if($list_all[$i]['admin_only'] == 1) // Si c'est un mod de type admin alors...
				{
					$s_html_admin .= "<tr id=".$list_all[$i]['id']." class='red'>";
					$s_html_admin .= "<th>".$list_all[$i]['menu']."</th></tr>";
				}
				else
				{
					$s_html_normal .= "<tr id=".$i." class='red'>";
					$s_html_normal .= "<th>".$list_all[$i]['menu']."</th></tr>";
				}
			}
			break;
		case 1 : // Groupe
			if($list_all[$i]['admin_only'] == 1) // Si c'est un mod de type admin alors...
			{
				$s_html_admin .= "<tr id=".$list_all[$i]['id']." class='blue'>";
				$s_html_admin .= "<th>Groupe : ".name_group($list_all[$i]['menu'])."</th></tr>";
			}
			else
			{
				$s_html_normal .= "<tr id=".$list_all[$i]['id']." class='blue'>";
				$s_html_normal .= "<th>Groupe : ".name_group($list_all[$i]['menu'])."</th></tr>";
			}
			break;
	}
}

$s_html .= '<style type="text/css">';
$s_html .= '<!--';
$s_html .= '.lime {color: lime;}';
$s_html .= '.red {color: red;}';
$s_html .= '.blue {color: #5CCCE8;}';
$s_html .= '-->';
$s_html .= '</style>';
$s_html .= '<script type="text/javascript" src="mod/'.$dir.'/classe.tablednd.js"></script>';

$s_html .= 	'<script type="text/javascript">';
$s_html .= 	'function f_submit(page, id, position, place_limite, place_voulue, ordre)';
$s_html .= 	'{';
$s_html .= 		'var t_id = new Array();';
$s_html .= 		'var n_i_tableau = 0;';

$s_html .= 		'var tablenormal = document.getElementById(\'table-normal\');';
$s_html .= 		'var tableadmin = document.getElementById(\'table-admin\');';

$s_html .= 		'var rows = tablenormal.tBodies[0].rows; ';
$s_html .= 		'for (var i = 0 ; i < rows.length ; i++)';
$s_html .= 		'{';
$s_html .= 			't_id[n_i_tableau] = rows[i].getAttribute("id");';
$s_html .= 			'n_i_tableau++;';
$s_html .= 		'}';
 
$s_html .= 		'var rows = tableadmin.tBodies[0].rows; ';
$s_html .= 		'for (var i = 0 ; i < rows.length ; i++)';
$s_html .= 		'{';
$s_html .= 			't_id[n_i_tableau] = rows[i].getAttribute("id");';
$s_html .= 			'n_i_tableau++;';
$s_html .= 		'}';

$s_html .= 		'document.getElementById(\'module_range\').value = t_id;';
$s_html .= 		'document.getElementById(\'formulaire_deplacement\').submit();';
$s_html .= 	'}';
$s_html .= 	'</script>';

$s_html .= '<br>';

$s_html .= 	'<div style="width:650px;text-align:left;color:white;font-weight:bold;padding-left:3px;font-size:11px;border:1px solid #F0ECED;font-family:Trebuchet MS,Arial,Helvetica,sans-serif;background-image:url(\'skin/OGSpy_skin/tableaux/td_c.png\');background-repeat:repeat-y;">Normal</div>';
$s_html .= '<table id="table-normal" style="width:655px;">';
$s_html .= 	$s_html_normal;
$s_html .= '</table>';

$s_html .= '<br>';
$s_html .= 	'<div style="width:650px;text-align:left;color:white;font-weight:bold;padding-left:3px;font-size:11px;border:1px solid #F0ECED;font-family:Trebuchet MS,Arial,Helvetica,sans-serif;background-image:url(\'skin/OGSpy_skin/tableaux/td_c.png\');background-repeat:repeat-y;">Admin</div>';

$s_html .= '<table id="table-admin" style="width:655px;">';
$s_html .= 	$s_html_admin;
$s_html .= '</table>';
$s_html .= '<br>';

$s_html .= 	'<script type="text/javascript">';
$s_html .= 	'var table = document.getElementById(\'table-normal\');';
$s_html .= 	'var tableDnD = new TableDnD();';
$s_html .= 	'tableDnD.init(table);';
$s_html .= 	'var table2 = document.getElementById(\'table-admin\');';
$s_html .= 	'var tableDnD2 = new TableDnD();';
$s_html .= 	'tableDnD2.init(table2);';
$s_html .= 	'</script>';

$s_html .= '<form id="formulaire_deplacement" method="post" action="index.php?action=gestion&subaction=action_mod">';
$s_html .= 		'<input type="hidden" name="module_range" id="module_range" value="" />';
$s_html .= 		'<input type="hidden" name="ordre" id="ordre" value="maj" />';
$s_html .= 		'<input type="button" onclick="javascript:f_submit();" name="Mettre à jour" value="Mettre à jour" />';
$s_html .= '</form>';

echo $s_html;

?>
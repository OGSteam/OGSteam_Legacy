<?php

/**
* rename.php Magnifique renommeur de MOD
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
$s_html .= '<br/>';
$s_html .= '<table>';
$s_html .= 		'<tr><td class="c" colspan="3">Liste des MODS - Pour aller à la ligne, mettre : &lt;br&gt;</td></tr>';
$s_html .=		 '<tr>';
$s_html .= 				'<th>Nom du MOD (version)</th>';
$s_html .= 				'<th>Nom Menu</th>';
$s_html .= 				'<th>Renommer</th>';
$s_html .= 		'</tr>';

$s_html .= 	'<script type="text/javascript">';
$s_html .= 	'function f_submit(page, id, menu, ordre)';
$s_html .= 	'{';
$s_html .= 		'document.getElementById(\'page\').value = page;';
$s_html .= 		'document.getElementById(\'id\').value = id;';
$s_html .= 		'document.getElementById(\'menu\').value = document.getElementById(menu).value;';
$s_html .= 		'document.getElementById(\'form_renommage_mod\').submit();';
$s_html .= 	'}';
$s_html .= 	'</script>';

$list_all = list_all();
for($i = 1 ; $i <= count($list_all); $i++) 
{
	if ($list_all[$i]['type'] == 0) 
	{
		$s_html .= 	'<tr>';
		$s_html .= 		'<th width="150">'.$list_all[$i]['title'].'<br>('.$list_all[$i]['version'].')</th>';
		$s_html .= 		'<th><textarea name="menu'.$i.'" id="menu'.$i.'" cols="125" rows="2" >'.$list_all[$i]['menu'].'</textarea></th>';
		$s_html .= 		'<th><input type="button" name="ordre" value="Renommer" onclick="javascript:f_submit(\''.$pub_subaction.'\', \''.$list_all[$i]['id'].'\', \'menu'.$i.'\');" /></th>';
		$s_html .= 	'</tr>';		
	}
}

$s_html .= '</table>';

$s_html .= '<form id="form_renommage_mod" method="post" action="index.php?action=gestion&subaction=action_mod">';
$s_html .= 	'<input type="hidden" name="page" id="page" value="" />';
$s_html .= 	'<input type="hidden" name="id" id="id" value="" />';
$s_html .= 	'<input type="hidden" name="menu" id="menu" value="" />';
$s_html .= 	'<input type="hidden" name="ordre" value="Renommer" />';
$s_html .= '</form>';

echo $s_html;

?>
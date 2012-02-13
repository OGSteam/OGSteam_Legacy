<?php
/**
* function.php Fichier avec les fonctions
* @package Gestion MOD
* @author Kal Nightmare
* @Mise à jour par xaviernuma 2012
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) 
{
	die("Hacking attempt");
}

if (!defined('GESTION_MOD')) 
{
	die("Hacking attempt");
}

/**
 * Infobulle par oXid_FoX
 * Optimisé par xaviernuma le 08/02/2012
 * Fonction à revoir la librairie wz_tooltip.js n'est pas top...
 */
function infobulle($s_contenu, $s_titre = 'Aide', $n_largeur = '200') 
{
	// Déclaration des variables
	$s_html = '';
	$s_contenu_infobulle = '';
	
	// On prépare le contenu de l'infobulle
	$s_contenu_infobulle .= '<table>';
	$s_contenu_infobulle .= 	'<tr>';
	$s_contenu_infobulle .= 		'<td class="c" style="text-align:center;">';
	$s_contenu_infobulle .= 			$s_titre;
	$s_contenu_infobulle .= 		'</td>';
	$s_contenu_infobulle .= 	'</tr>';
	$s_contenu_infobulle .= 	'<tr>';
	$s_contenu_infobulle .= 		'<th class="c" style="text-align:center;">';
	$s_contenu_infobulle .= 			$s_contenu;
	$s_contenu_infobulle .= 		'</th>';
	$s_contenu_infobulle .= 	'</tr>';
	$s_contenu_infobulle .= '</table>';
	
	// On transforme le contenu en htmlspecialchars pour la fonction javascript 
	$s_contenu_infobulle = addslashes($s_contenu_infobulle);
	$s_contenu_infobulle = htmlspecialchars($s_contenu_infobulle);
	
	// On vérifie que la largeur est bien un nombre
	if(!is_numeric($n_largeur))
	{
		$n_largeur = 200;
	}

	// Affichage de l'infobulle
	$s_html .= '<img';
	$s_html .= ' style="cursor: pointer;"';
	$s_html .= ' src="images/help_2.png"';
	$s_html .= ' onmouseover="javascript:this.T_WIDTH=210;this.T_TEMP=0;return escape(\''.$s_contenu_infobulle.'\');"';
	// $s_html .= ' onmouseout="javascript:tt_Hide();"';
	$s_html .= ' alt="'.$s_titre.'"';
	$s_html .= ' />';
	
	return $s_html;
}

// Retourne le nombre de groupe créé par gestionmod
function nb_group() 
{
	// Déclaration des variables
	global $db;
	
	// On sélectionne les numéros de groupe dans la table root
	$s_sql = 'SELECT `root` FROM `'.TABLE_MOD.'` WHERE `link` = "group" ORDER BY `root` desc;';
	
	// On récupère le dernier numéro créé
	$r_sql = $db->sql_query($s_sql);
	$ta_dernier_numero_groupe = $db->sql_fetch_assoc($r_sql);
	
	return $ta_dernier_numero_groupe['root'];
}

// Fonction qui liste les groupes créé par gestionmod
function list_group() 
{
	// Déclaration des variables
	global $db;
	$i = 0;
	$group = array();
	
	// On récupère le numéro du groupe et le lien de chaque groupe créé
	$s_sql = 'SELECT `root`, `menu` FROM `'.TABLE_MOD.'` WHERE `link` = "group";';
	$r_sql = $db->sql_query($s_sql);
	
	while($row = $db->sql_fetch_assoc($r_sql)) 
	{
		$espace = 'non';
		
		if(substr($row['menu'], 0, 9) == "</a><img ") 
		{
			$espace = 'oui';
		}
		
		$group[$i] = array('Nom' => $row['menu'] , 'Num' => $row['root'] , 'Espace' => $espace);
		$i++;	
	}
	
	return $group;
}

// Transforme un nom en nom de menu par xaviernuma
function f_traitement_nom_groupe($s_nom, $s_espace)
{
	// Déclaration des variables
	$menu = '';
	
	if($s_nom != '') 
	{
		// Si on affiche un espace
		if ($s_espace == 'oui' ) 
		{
			$menu .= '</a><img src="skin/OGSpy_skin/gfx/user-menu.jpg" style="width:140px;height:19px;position:relative;right:9px;" />';	
			$menu .= '<br><center><b>'.$s_nom.'</b></center><a>';	
		} 
		else 
		{
			$menu .= '</a><div style="';
			$menu .= 'background:#000;';
			$menu .= 'bottom:9px;';
			$menu .= 'position:relative;';
			$menu .= '">';	
			$menu .= '<center><b>'.$s_nom.'</b></center></div><a>';	
		}
		
		// On vérifie si le nom n'existe pas déjà
		$ta_liste_groupes = list_group();
		for($i = 0 ; $i < count($ta_liste_groupes) ; $i++)
		{
			if($ta_liste_groupes[$i]['Nom'] == $menu)
			{
				$menu = ''; // On met à null menu
			}
		}
			
		// Le champ dans la base est de 255 caractère, on regarde si on ne dépasse pas
		if(strlen($menu) > 255)
		{
			$menu = '';
		}
	}
	
	return $menu;
}

// Insertion d'un nouveau groupe
function new_group () 
{
	// Déclaration des variables
	global $db, $dir;
	$s_champs = '';
	$menu = ''; // Attention, limité à 255 caractères...
	$new_group = '';
	
	// On test si des données ont été envoyé
	if(isset($_POST['new_group']) && isset($_POST['espace'])) 
	{
		$menu = f_traitement_nom_groupe($_POST['new_group'], $_POST['espace']);
		
		if(!empty($menu))
		{
			// On génère le nouvel identifiant unique du groupe
			$num_new_group = nb_group();
			$num_new_group++;
			
			// Préparation de la requête
			$s_champs .= "INSERT INTO ";
			$s_champs .= "`".TABLE_MOD."` SET ";
			$s_champs .= "`id` = '', ";
			$s_champs .= "`title` = '%s', ";
			$s_champs .= "`menu` = '%s', ";
			$s_champs .= "`action` = '%s', ";
			$s_champs .= "`root` = '%s', ";
			$s_champs .= "`link` = '%s', ";
			$s_champs .= "`version` = '%s', ";
			$s_champs .= "`active` = '%s' ";

			$s_sql = sprintf($s_champs,
					mysql_real_escape_string("Group.".$num_new_group),
					mysql_real_escape_string($menu),
					mysql_real_escape_string($num_new_group),
					mysql_real_escape_string($num_new_group),
					mysql_real_escape_string('group'),
					mysql_real_escape_string(0),
					mysql_real_escape_string(1)
					);
			
			$db->sql_query($s_sql);
			// On met les groupes dans l'ordre
			list_all();
		}
	}
	redirection("index.php?action=gestion&subaction=group");
}

function group () 
{
	// Déclaration des variables
	global $db,$dir;
	$s_champs = '';
	
	if (isset($_POST['ordre']) && isset($_POST['num_group']) && isset($_POST['nom_group']) && isset($_POST['espace'])) 
	{
		if ($_POST['num_group'] != '') 
		{
			switch ($_POST['ordre']) 
			{
				case "Renommer Groupe" :
					$menu = f_traitement_nom_groupe($_POST['nom_group'], $_POST['espace']);
		
					if(!empty($menu))
					{						
						// Préparation de la requête
						$s_champs .= "UPDATE ";
						$s_champs .= "`".TABLE_MOD."` SET ";
						$s_champs .= "`menu` = '%s' ";
						$s_champs .= "WHERE ";
						$s_champs .= "`title` = '%s';";

						$s_sql = sprintf($s_champs,
								mysql_real_escape_string($menu),
								mysql_real_escape_string('Group.'.$_POST['num_group'])
								);		
						$db->sql_query($s_sql);
					}
					break;
				
				case "Supprimer Groupe" :
					$s_sql = "DELETE FROM ".TABLE_MOD." WHERE title = 'Group.".$_POST['num_group']."' ";
					$db->sql_query($s_sql);
					// On met les groupes dans l'ordre
					list_all();
					break;
			}
		}
	}
	redirection("index.php?action=gestion&subaction=group");
}	
		
function list_all() 
{
	// Déclaration des variables
	global $db,$dir;
	$i = 1;
	
	$s_sql = "SELECT * FROM ".TABLE_MOD." ORDER BY position";
	$r_sql = $db->sql_query($s_sql);
	
	while($mod = $db->sql_fetch_assoc($r_sql)) 
	{
		$type = 0;
		
		if($mod['link'] == 'group') 
		{
			$type = 1;
		}
		
		$list_mod[$i] = array('menu' => $mod['menu'] , 'position' => $i , 'type' => $type , 'id' => $mod['id'] , 'title' => $mod['title'] , 'version' => $mod['version'], 'active' => $mod['active'], 'admin_only' => $mod['admin_only']);
		
		$s_sql = "UPDATE ".TABLE_MOD." SET position='".$i."' WHERE id = '".$mod["id"]."' ";
		$db->sql_query($s_sql);
		
		$i++;	
	}
	return $list_mod;
}

function name_group($menu) 
{
	// Déclaration des variables
	$arr = array();
	$text = '';
	
	// Ancien pattern pour ceux qui ont créé nom de groupe avant la mise à jour du mod
	if(preg_match("#^.*?<a href=\"\"><u>(.*?)<\/u><\/a>.*$#", $menu, $arr)) 
	{
		$text = $arr[1];
	}
	elseif(preg_match("#<center><b>(.*?)</b></center>#", $menu, $arr)) 
	{
		 $text = $arr[1];
	}
	
	return $text;
}	

function mod() 
{
	// Déclaration des variables
	global $db;
	
	if(isset($_POST['ordre']) && isset($_POST['id']) && ( (isset($_POST['position']) && isset($_POST['place_limite'])) || (isset($_POST['menu'])) ) ) 
	{
		switch ($_POST['ordre']) 
		{
			case "Monter":
				if ($_POST['position'] <> 1)
				{
					$place_voulue = $_POST['position'] - 1;
					$s_sql = "SELECT id FROM ".TABLE_MOD." WHERE position = '".$place_voulue."'";
					$r_sql = $db->sql_query($s_sql);
					$val = $db->sql_fetch_assoc($r_sql);
					$query2 = "UPDATE ".TABLE_MOD." SET position='".$_POST['position']."' WHERE id = '".$val['id']."' ";
					$result2 = $db->sql_query($query2);
					$query3 = "UPDATE ".TABLE_MOD." SET position='".$place_voulue."' WHERE id = '".$_POST['id']."' ";
					$result3 = $db->sql_query($query3);
				}
				break;
			case "Descendre":
				if ($_POST['position'] <> $_POST['place_limite'])
				{
					$place_voulue = $_POST['position'] + 1;
					$s_sql = "SELECT id FROM ".TABLE_MOD." WHERE position = '".$place_voulue."'";
					$r_sql = $db->sql_query($s_sql);
					$val = $db->sql_fetch_assoc($r_sql);
					$query2 = "UPDATE ".TABLE_MOD." SET position = '".$_POST['position']."' WHERE id = '".$val['id']."' ";
					$result2 = $db->sql_query($query2);
					$query3 = "UPDATE ".TABLE_MOD." SET position = '".$place_voulue."' WHERE id = '".$_POST['id']."' ";
					$r_sql = $db->sql_query($query3);
				}
				break;
			case "Deplacer":
				if (isset($_POST['place_voulue'])) 
				{
					if (is_numeric($_POST['place_voulue']))
					{
						if ($_POST['place_voulue'] > $_POST['place_limite']) 
						{
							$_POST['place_voulue'] = $_POST['place_limite'];
						}
						if ($_POST['place_voulue'] < 1) 
						{
							$_POST['place_voulue'] = 1;
						}
						if ($_POST['place_voulue'] > $_POST['position']) 
						{
							$pos1 = $_POST['position'] + 1;
							$pos2 = $_POST['place_voulue'];
							while ($pos1 <= $pos2) 
							{
								mod_attrib_place($pos1, 'haut');
								echo $pos1++;
							}
						}
						if ($_POST['place_voulue'] < $_POST['position']) 
						{
							$pos1 = $_POST['position'] - 1; // 1
							$pos2 = $_POST['place_voulue']; //1
							while ($pos1 >= $pos2) 
							{
								mod_attrib_place($pos1, 'bas');
								$pos1--;
							}
						}
						$s_sql = "UPDATE ".TABLE_MOD." SET position = '".$_POST['place_voulue']."' WHERE id = '".$_POST['id']."' ";
						$r_sql = $db->sql_query($s_sql);	
					}
				}
				break;	
			case "Renommer":
				if($_POST['menu'] != '') 
				{
					$s_champs = "UPDATE ";
					$s_champs .= "`".TABLE_MOD."` SET ";
					$s_champs .= "`menu` = '%s' ";
					$s_champs .= "WHERE id = '%s' ";

					$s_sql = sprintf($s_champs,
							mysql_real_escape_string($_POST['menu']),
							mysql_real_escape_string($_POST['id'])
							);
					// $s_sql = "UPDATE ".TABLE_MOD." SET menu='".$_POST['menu']."' WHERE id = '".$_POST['id']."';";
					$r_sql = $db->sql_query($s_sql);
				}
			break;
		}
	}
	
	if(isset($_POST['page']))
	{	
		redirection("index.php?action=gestion&subaction=".$_POST['page']);
	}
	else 
	{
		redirection("index.php?action=gestion");
	}
}

function mod_attrib_place($position, $direction) 
{
	// Déclaration des variables
	global $db;
	
	$s_sql = "SELECT id FROM ".TABLE_MOD." WHERE position = '".$position."'";
	$r_sql = $db->sql_query($s_sql);
	$val = $db->sql_fetch_assoc($r_sql);
	if($direction == 'bas' || $direction == 'haut') 
	{
		if ($direction == 'bas') 
		{
			$position++;
		}
		if ($direction == 'haut')
		{
			$position--;
		}
		$query2 = "UPDATE ".TABLE_MOD." SET position = '".$position."' WHERE id = '".$val['id']."' ";
		$result2 = $db->sql_query($query2);
	}
}

?>
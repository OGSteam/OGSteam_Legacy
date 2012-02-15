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
	$s_sql = 'SELECT * FROM `'.TABLE_MOD.'` WHERE `link` = "group";';
	$r_sql = $db->sql_query($s_sql);
	
	while($row = $db->sql_fetch_assoc($r_sql)) 
	{		
		$group[$i] = array('Nom' => $row['menu'] , 'Num' => $row['root'] , 'admin' => $row['admin_only']);
		$i++;	
	}
	
	return $group;
}

// Transforme un nom en nom de menu par xaviernuma
function f_traitement_nom_groupe($s_nom, $b_nouveau_groupe, $n_admin = 0)
{
	// Déclaration des variables
	$menu = '';
	
	if($s_nom <> '') 
	{
		$menu .= '</a><div style="';
		$menu .= 'background:#000;';
		$menu .= 'bottom:9px;';
		$menu .= 'position:relative;';
		$menu .= '">';	
		$menu .= '<center><b>'.$s_nom.'</b></center></div><a>';	
	
		// On vérifie si le nom n'existe pas déjà
		$ta_liste_groupes = list_group();
		for($i = 0 ; $i < count($ta_liste_groupes) ; $i++)
		{
			if($b_nouveau_groupe)
			{
				if($ta_liste_groupes[$i]['Nom'] == $menu)
				{
					$menu = ''; // On met à null menu
				}
			}
			else
			{
				if(($ta_liste_groupes[$i]['Nom'] == $menu) and ($ta_liste_groupes[$i]['admin'] == $n_admin))
				{
					$menu = ''; // On met à null menu
				}
			}
		}
		
		// On remplace le caractère d'échappement de la futur requête sql
		$menu = str_replace("'", "&#039;", $menu);
		
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
	$n_groupe_admin = 0; // 0 Groupe normal, 1 Groupe admin
	
	// On test si des données ont été envoyé
	if(isset($_POST['new_group'])) 
	{
		if(isset($_POST['admin'])) 
		{
			$n_groupe_admin = 1;
		}
		$menu = f_traitement_nom_groupe($_POST['new_group'], true);
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
			$s_champs .= "`active` = '%s', ";
			$s_champs .= "`admin_only` = '%s' ";

			$s_sql = sprintf($s_champs,
					mysql_real_escape_string("Group.".$num_new_group),
					mysql_real_escape_string($menu),
					mysql_real_escape_string($num_new_group),
					mysql_real_escape_string($num_new_group),
					mysql_real_escape_string('group'),
					mysql_real_escape_string(0),
					mysql_real_escape_string(1),
					mysql_real_escape_string($n_groupe_admin)
					);
			
			// var_dump($s_sql);
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
	
	if (isset($_POST['ordre']) && isset($_POST['num_group']) && isset($_POST['nom_group']) && isset($_POST['admin'])) 
	{
		if(($_POST['num_group'] <> '') and (is_numeric($_POST['admin']))) 
		{
			switch ($_POST['ordre']) 
			{
				case "Renommer Groupe" :
					$menu = f_traitement_nom_groupe($_POST['nom_group'], false, $_POST['admin']);
					if(!empty($menu))
					{	
						// Préparation de la requête
						$s_champs .= "UPDATE ";
						$s_champs .= "`".TABLE_MOD."` SET ";
						$s_champs .= "`menu` = '%s', ";
						$s_champs .= "`admin_only` = '%s' ";
						$s_champs .= "WHERE ";
						$s_champs .= "`title` = '%s';";
	
						$s_sql = sprintf($s_champs,
								mysql_real_escape_string($menu),
								mysql_real_escape_string($_POST['admin']), // 0 Groupe normal, 1 Groupe admin
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
	
	if(isset($_POST['module_range']) && isset($_POST['ordre']) || (isset($_POST['menu'])))
	{
		switch ($_POST['ordre']) 
		{
			case "maj": // On met à jour les id des modules dans le nouvel ordre de rangement
				$t_id_modules = explode( ',' , $_POST['module_range']);
				
				for( $i = 0 ; $i < count($t_id_modules) ; $i++)
				{
					$s_champs = "UPDATE ";
					$s_champs .= "`".TABLE_MOD."` SET ";
					$s_champs .= "`position` = '%s' ";
					$s_champs .= "WHERE id = '%s' ";

					$s_sql = sprintf($s_champs,
							mysql_real_escape_string($i),
							mysql_real_escape_string($t_id_modules[$i])
							);
					$r_sql = $db->sql_query($s_sql);
				}
				break;	
			case "Renommer": // On renomme un module
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

?>
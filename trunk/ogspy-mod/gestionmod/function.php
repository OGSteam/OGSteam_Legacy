<?php
/**
* function.php Fichier avec les fonction
* @package Gestion MOD
* @author Kal Nightmare
* @link http://www.ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
if (!defined('GESTION_MOD')) {
	die("Hacking attempt");
}
/**
 * fait la petite infobulle par oXid_FoX
 */
function infobulle($txt_contenu, $titre = 'Aide', $largeur = '200') {
	// remplace ' par \'
	// puis remplace \\' par \'
	// au cas où le guillemet simple aurait déjà été protégé avant l'appel à la fonction
	$txt_contenu = str_replace('\\\\\'','\\\'',str_replace('\'','\\\'',$txt_contenu));
	// remplace le guillemet double par son code HTML
	$txt_contenu = str_replace('"','&quot;',$txt_contenu);

	// pareil avec $titre
	$titre = str_replace('\\\\\'','\\\'',str_replace('\'','\\\'',$titre));
	$titre = str_replace('"','&quot;',$titre);

	// tant qu'on y est, vérification de $largeur
	if (!is_numeric($largeur))
	  $largeur = 200;

	// affiche l'infobulle
	echo '<img style="cursor: pointer;" src="images/help_2.png" onMouseOver="this.T_WIDTH=210;this.T_TEMP=0;return escape(\'<table width=&quot;',$largeur
	,'&quot;><tr><td align=&quot;center&quot; class=&quot;c&quot;>',$titre,'</td></tr><tr><th align=&quot;center&quot;>',$txt_contenu,'</th></tr></table>\')">';
}

function nb_group() {
global $db;
$query = 'SELECT title FROM '.TABLE_MOD.' WHERE link = "group" ORDER BY action';
$quet = $db->sql_query($query);
while ($row = $db->sql_fetch_assoc($quet)) {
		$num_group = explode('.',$row['title']);
		}
return $num_group[1] ;
}

function list_group() {
global $db;
$query = 'SELECT title, menu FROM '.TABLE_MOD.' WHERE link = "group" ';
$quet = $db->sql_query($query);
$i = 0;
while ($row = $db->sql_fetch_assoc($quet)) {
		if("</a><img "==substr($row['menu'], 0, 9)) $espace = 'oui';
		else $espace = 'non'; 
		$num_group = explode('.',$row['title']);
		$group[$i] = array('Nom' => $row['menu'] , 'Num' => $num_group[1] , 'Espace' => $espace);
		$i = $i + 1;	
		}
return $group ;
}

function new_group () {
global $db,$dir;
if (isset($_POST['new_group']) && isset($_POST['espace'])) {
	if ($_POST['new_group'] == '') {$menu = '</a><img src="skin/OGSpy_skin//gfx/user-menu.jpg" width="110" height="19"><a>';
	} else {
	if ($_POST['espace'] == 'oui' ) {
	$menu = '<img src="skin/OGSpy_skin//gfx/user-menu.jpg" width="110" height="19"></div></td></tr>';
	$menu .='<tr><td><div align="center"><a href=""><u>'.$_POST['new_group'].'</u></a></div></td></tr>';
	$menu .='<tr><td><img src="mod/'.$dir.'/image.gif" width="110" height="5"><div>';
	} else if ($_POST['espace'] == 'non' ) {
	$menu ='<div align="center"><a href=""><u>'.$_POST['new_group'].'</u></a></div></td></tr>';
	$menu .='<tr><td><img src="mod/'.$dir.'/image.gif" width="110" height="5"><div>';
	} }
$num_group = nb_group();
$num_new_group = $num_group + 1;
$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','Group.".$num_new_group."','".$menu."','".$num_new_group."','".$num_new_group."','group','0','1')";
$db->sql_query($query);
}
redirection("index.php?action=gestion&subaction=group");
}

function group () {
global $db,$dir;
if (isset($_POST['ordre']) && isset($_POST['num_group']) && isset($_POST['nom_group']) && isset($_POST['espace'])) {
	if ($_POST['nom_group'] != '') {
	switch ($_POST['ordre']) {
	    case "Renommer Groupe" :
		if ($_POST['espace'] == 'oui' ) {
		$menu = '</a><img src="skin/OGSpy_skin//gfx/user-menu.jpg" width="110" height="19"></div></td></tr>';
		$menu .='<tr><td><div align="center"><a href=\"\"><u>'.$_POST['nom_group'].'</u></a></div></td></tr>';
		$menu .='<tr><td><img src="mod/'.$dir.'/image.gif" width="110" height="5"><div><a>';
		} else {
		$menu .='</a><div align="center"><a href=""><u>'.$_POST['nom_group'].'</u></a></div></td></tr>';
		$menu .='<tr><td><img src="mod/'.$dir.'/image.gif" width="110" height="5"><div><a>';
		} 
		$query = "UPDATE ".TABLE_MOD." SET menu='".$menu."' WHERE title = 'Group.".$_POST['num_group']."' ";
		$result = $db->sql_query($query);
		break;
		
		case "Supprimer Groupe" :
		$query = "DELETE FROM ".TABLE_MOD." WHERE title = 'Group.".$_POST['num_group']."' ";
		$result = $db->sql_query($query);
		break;
	}
	}
}
redirection("index.php?action=gestion&subaction=group");
}	
		
function list_all () {
global $db,$dir;
	$query = "SELECT menu, root, title, version, link, id, active FROM ".TABLE_MOD." ORDER BY position";
$result = $db->sql_query($query);
	$i=1;
	while ($mod = $db->sql_fetch_assoc($result)) {
		if ($mod['link'] == 'group' ) $type = 1;
		else $type = 0;
		if ($mod['menu'] == '</a><img src="skin/OGSpy_skin//gfx/user-menu.jpg" width="110" height="19"><a>') $type = 2;
		$list_mod[$i] = array('menu' => $mod['menu'] , 'position' => $i , 'type' => $type , 'id' => $mod['id'] , 'title' => $mod['title'] , 'version' => $mod['version'], 'active' => $mod['active']);
		$query2 = "UPDATE ".TABLE_MOD." SET position='".$i."' WHERE id = '".$mod["id"]."' ";
		$result2 = $db->sql_query($query2);
		$i = $i + 1;	
		}
return $list_mod;
}

function name_group ($menu) {
$arr = array();
if(preg_match("#^.*?<a href=\"\"><u>(.*?)<\/u><\/a>.*$#", $menu, $arr)) {
     $text = $arr[1];
}
return $text;
}	

function mod () {
global $db;
if (isset($_POST['ordre']) && isset($_POST['id']) && ( (isset($_POST['position']) && isset($_POST['place_limite'])) || (isset($_POST['menu'])) ) ) {
	switch ($_POST['ordre']) {
		case "Monter":
		if ($_POST['position'] <> 1){
			$place_voulue = $_POST['position']-1;
			$query = "SELECT id FROM ".TABLE_MOD." WHERE position = '".$place_voulue."'";
			$result = $db->sql_query($query);
			$val = $db->sql_fetch_assoc($result);
			$query2 = "UPDATE ".TABLE_MOD." SET position='".$_POST['position']."' WHERE id = '".$val['id']."' ";
			$result2 = $db->sql_query($query2);
			$query3 = "UPDATE ".TABLE_MOD." SET position='".$place_voulue."' WHERE id = '".$_POST['id']."' ";
			$result3 = $db->sql_query($query3);
            generate_mod_cache();
		}
		break;
		case "Descendre":
		if ($_POST['position'] <> $_POST['place_limite']){
			$place_voulue = $_POST['position']+1;
			$query = "SELECT id FROM ".TABLE_MOD." WHERE position = '".$place_voulue."'";
			$result = $db->sql_query($query);
			$val = $db->sql_fetch_assoc($result);
			$query2 = "UPDATE ".TABLE_MOD." SET position = '".$_POST['position']."' WHERE id = '".$val['id']."' ";
			$result2 = $db->sql_query($query2);
			$query3 = "UPDATE ".TABLE_MOD." SET position = '".$place_voulue."' WHERE id = '".$_POST['id']."' ";
			$result = $db->sql_query($query3);
             generate_mod_cache();
		}
		break;
		case "Deplacer":
		if (isset($_POST['place_voulue'])) {
			if (is_numeric($_POST['place_voulue'])) {
				if ($_POST['place_voulue'] > $_POST['place_limite']) $_POST['place_voulue'] = $_POST['place_limite'];
				if ($_POST['place_voulue'] < 1) $_POST['place_voulue'] = 1;
				if ($_POST['place_voulue'] > $_POST['position']) {
					$pos1 = $_POST['position'] + 1;
					$pos2 = $_POST['place_voulue'];
					while ($pos1 <= $pos2) {
					mod_attrib_place($pos1,'haut');
					$pos1 = $pos1+1;
					}
				}
				if ($_POST['place_voulue'] < $_POST['position']) {
					$pos1 = $_POST['position'] - 1;
					$pos2 = $_POST['place_voulue'];
					while ($pos1 >= $pos2) {
					mod_attrib_place($pos1,'bas');
					$pos1 = $pos1-1;
					}
				}
			$query = "UPDATE ".TABLE_MOD." SET position = '".$_POST['place_voulue']."' WHERE id = '".$_POST['id']."' ";
			$result = $db->sql_query($query);
             generate_mod_cache();	
			}
		}
		break;	
		case "Renommer":
		if ($_POST['menu'] != '') {
		$query = "UPDATE ".TABLE_MOD." SET menu='".$_POST['menu']."' WHERE id = '".$_POST['id']."' ";
		$result = $db->sql_query($query);}
         generate_mod_cache();
		break;
	}
}
if (isset($_POST['page'])) redirection("index.php?action=gestion&subaction=".$_POST['page']);
else redirection("index.php?action=gestion");
}
function mod_attrib_place ($position,$direction) {
global $db;
$query = "SELECT id FROM ".TABLE_MOD." WHERE position = '".$position."'";
$result = $db->sql_query($query);
$val = $db->sql_fetch_assoc($result);
if ($direction='bas' || $direction='haut') {
if ($direction='bas') $position = $position + 1;
if ($direction='haut') $position = $position - 1;
$query2 = "UPDATE ".TABLE_MOD." SET position = '".$position."' WHERE id = '".$val['id']."' ";
$result2 = $db->sql_query($query2);}
 generate_mod_cache();
}
?>

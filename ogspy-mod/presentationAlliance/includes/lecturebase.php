<?php
/***************************************************************************
*	Filename	: lecturebase.php
*	desc.		: Script d'importation SQL ou fichiers du module "Présentation Alliance"
*	Authors	: Lose - http://ogs.servebbs.net/; Edité par Sylar - sylar@ogsteam.fr
*	created	: 30/11/2007
*	modified	: 25/02/2008
*	version	: 0.1
***************************************************************************/
/***************************************************************************
* function get_pic()
*		Renvoi un tableau contenant les images enregistré.
*		['name'], ['tag_alliance'], ['background'], ['output'], ['user_id']
*
* function get_pic_data($id)
*		Renvoi un tableau contenant les champs de l'image n°$id
*		['id'],['type'],['nom_champ'],['text'],['pos_x'],['pos_y',['pos_ang'],['font_name'],
*		['font_size'],['font_color'],['actif']
*
* function get_background_ltab()
*		Renvoi un tableau contenant la liste des fichiers disponibles comme images de fond.
*
* function get_image_tab()
*		Renvoi un tableau contenant la liste des images disponibles à l'intégration sur les fonds.
*
* function get_table_list($tableau,$selected,$name)
*		Renvoi le code HTML affichant une liste déroulante des occurrences de tableau.
*		$selected est la ligne sur laquelle la liste doit etre selectionné, et $name le nom du la liste.
*
***************************************************************************/
if (!defined('IN_SPYOGAME')) 	die("Hacking attempt");
/**************************************************************************/
function get_pic($user=0)
{
	// Récupére la liste (complète ou pas selon $user) des images enregistrées dans la base
	global $db;
	$query='select `id`,`name`,`tag_alliance`,`background`,`output`,`user_id` from '.TABLE_P_ALLY_PIC.'  order by id asc';
	$result = $db->sql_query($query);
	if($result=$db->sql_numrows($result)==0)
		$return = Array();
	else
		while(list($id,$name, $tag_alliance, $background, $output,$user_id)=$db->sql_fetch_row($result))
			if($user==0||$user_id==0||$user==$user_id)
				$return[$id] = 
					Array ('name'=>$name,'tag_alliance'=>$tag_alliance,'background'=>$background,'output'=>$output,'user_id'=>$user_id);
	return $return;
}
/**************************************************************************/
function get_pic_data($id)
{
	// Récupére les champs enregistrés dans la base pour l'image $id
	global $db;
	$query="select `id`,`type`,`nom_champ`,`text`,`pos_x`,`pos_y`,`pos_ang`,`font_name`,`font_size`,`font_color`,`actif` from ".TABLE_P_ALLY_DATA." ";
	$query .="where `id_pic`='$id' order by id asc";
	$result = $db->sql_query($query);
	if($result=$db->sql_numrows($result)==0)
		$return = Array();
	else
		while(list($id,$type,$nom_champ,$text,$pos_x,$pos_y,$pos_ang,$font_name,$font_size,$font_color,$actif)=$db->sql_fetch_row($result))
			$return[] = Array (
				'id'=>$id,'type'=>$type,'nom_champ'=>$nom_champ,'text'=>$text,'pos_x'=>$pos_x,'pos_y'=>$pos_y,
				'pos_ang'=>$pos_ang,'font_name'=>$font_name,'font_size'=>$font_size,'font_color'=>$font_color,'actif'=>$actif );
	return $return;
}
/**************************************************************************/
function get_background_tab()
{
	// Liste tous les fichiers .jpg du dossier des fonds disponibles	
	$background = array(); 
	$dossier = @opendir (FOLDER_BKGND); 
	while ($fichier = readdir ($dossier))
		if (substr($fichier, -4) == ".jpg" )
			$background[] = $fichier;
	return $background;
}
/**************************************************************************/
function get_image_tab()
{
	// Liste tous les fichier .jpg et .png du dossier des images disponible (fusion avec les polices et les fonds...?)
	$images = array(); 
	$dossier = @opendir (FOLDER_IMG); 
	while ($fichier = readdir ($dossier))
		if ((substr($fichier, -4) == ".jpg")||(substr($fichier, -4) == ".png"))
			$images[] = $fichier;
	return $images;
}
/**************************************************************************/
function get_table_list($tableau,$selected,$name)
{
	// Génére le code HTML d'une liste déroulante du tableau $tableau avec le nom $name et le champ $selected
	$retour = "\t\t\t<SELECT NAME='".$name."'>\n";
	if($selected=="-") $retour .= "\t\t\t\t<OPTION VALUE='-' selected>Selectionnez un fond...</option>\n";
	foreach($tableau as $ligne) 
		$retour .= "\t\t\t\t<OPTION VALUE='".$ligne."' ".($selected==$ligne?"selected":"").">".$ligne."</option>\n";
	if($selected=="") $retour .= "\t\t\t\t<OPTION VALUE='' selected>&nbsp</option>\n";
	$retour .="\t\t\t</SELECT>\n";
	return $retour;
}
/**************************************************************************/
?>
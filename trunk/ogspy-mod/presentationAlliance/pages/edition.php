<?php
/***************************************************************************
*	Filename	: edit.php
*	desc.		: Page de configuration du module "Présentation Alliance"
*	Authors	: Lose - http://ogs.servebbs.net/; Edité par Sylar - sylar@ogsteam.fr
*	created	: 30/11/2007
*	modified	: 25/02/2008
*	version	: 0.1
***************************************************************************/
if (!defined('IN_SPYOGAME')) 	die("Hacking attempt");

// Définitions
global $user_data;

// Si l'id n'est pas défini on prends la 1ere image
if(!isset($pub_id)) $pub_id = key($pictures);

// Liste déroulante de choix des images
if(isset($pub_list_pic)) $pub_id = $pub_list_pic;

// Génération de la liste de image
//$pictures = get_pic();

// Test si on a demandé à ajouter un champ; vérifie que le nom n'est pas vide
if(isset($pub_btn_add_image)&&strlen($pub_add_image)>0) add_data($pub_id,$pub_add_image,'image');
if(isset($pub_btn_add_text)&&strlen($pub_add_text)>0) add_data($pub_id,$pub_add_text,'text');

// Mise à jour SQL
if(isset($pub_update))  update($pub_id);

// Suppression d'un champ
if(isset($pub_deletedata)) delete_data($pub_id,$pub_deletedata);

// Génération de la liste des images du visiteur
$pictures = get_pic($user_data['user_id']);

// S'il n'a aucune image, on le redirige vers l'accueil
if(count($pictures)<1)
{
	echo"<font color='red'><blink>Veuillez créer une image avant !</blink></font>";
	include_once(FOLDER_PAGES."/".$menu[0]['lien'].".php");
	exit();
}

// Récupération des champs associés à cette image
$data = get_pic_data($pub_id);

// Génération du code de la liste des fonds d'écrans
$background_list = get_table_list(get_background_tab(),$pictures[$pub_id]['background'],"background");

// Génération du tableau des images insérables
$image_tab = get_image_tab();
?>
<br/>
<form action='?action=presentation_alliance&page=<?php echo $pub_page?>&id=<?php echo $pub_id; ?>' method='post'> 
<table width='30%'>
	<tr>
		<td class="c">
			Selection de l'image
		</td>
		<td>
			<select name="list_pic" onchange='this.form.submit()'>
			<?php
				foreach($pictures as $key => $image)
					echo"\t\t\t\t<option value='".$key."' ".($key==$pub_id?"selected":"").">".$image['name']."</option>";
			?>
			</select>
		</td>
</table>
<br/>
<table width="100%">
	<tr>
		<td class="b"  colspan="9">
			<center><a>Réglage de l'image "<?php echo $pictures[$pub_id]['name'];?>"</a></center>
		</td>
	</tr>
	<tr> 
		<?php 
		// Quelle est la taille de l'image de fond choisie ?
		$fichier = FOLDER_BKGND."/".$pictures[$pub_id]['background'];
		if($fichier!=FOLDER_BKGND."/"&&file_exists($fichier))
			list($width, $height, $type, $attr) = getimagesize($fichier);
		else
			list($width,$height) = Array (0,0);
		?>
		<td class="b"  colspan="7">
			<a> Nom du fond</a> 
		</td> 
		<th>
			Largeur: <b><?php echo $width; ?></b>px Hauteur: <b><?php echo $height; ?></b>px
		</th>
		<td class="b" >
			<?php echo $background_list; ?>
		</td>
	</tr>
	<tr> 
		<td class="b"  colspan="8">
			<a> Nom de l'image de Sortie</a> 
		</td> 
		<td class="b" >
			<input type="text" name="lien_sortie" size="37" value="<?php echo $pictures[$pub_id]['output']; ?>" style="border-style: solid; border-width: 1; color: #C0C0C0; float:left">
		</td>
	</tr>
	<tr> 
		<td class="b"  colspan="8">
			<a> Nom de l'alliance</a> 
		</td> 
		<td class="b" >
			<input type="text" name="tag_alliance" size="37" value="<?php echo $pictures[$pub_id]['tag_alliance']; ?>" style="border-style: solid; border-width: 1; color: #C0C0C0; float:left">
		</td>
	</tr>
	<tr height="10">&nbsp</tr>
	<tr>
		<td class="b"  colspan="9">
			<center><a>Texte sur l'image</a></center>
		</td>
	</tr>
	<tr>
		<td class="b" colspan="2">
			<a>Nom du Champ</a>
		</td>
		<td class="b">
			 <a>Taille du texte</a> 
		</td>
		<td class="b">
			 <a>Angle</a>
		</td>
		<td class="b">
			 <a>Position X</a>
		</td>
		<td class="b">
			 <a>Position Y</a>
		</td>
		<td class="b">
			 <a href="http://www.computerhope.com/htmcolor.htm" target="_blank">Couleur du texte</a>
		</td>
		<td class="b">
			 <a>Police</a>
		</td>
		</td> 
		<td class="b">
			 <a>Texte</a>
		</td>
	</tr>
<?php
// Pour chaque champ de type Texte
foreach($data as $line)
{
	if($line['type'] == 'text')
	{
		$id = $line['id'];
		echo"\t<tr>\n";
		// Bouton a cocher : Actif ou Pas
		echo"\t\t<td class='b'>\n\t\t\t<input name='actif_".$id."' type='checkbox' ".($line['actif']==1?"checked":"")."> <a>".$line['nom_champ']."</a>\n\t\t</td>\n";
		echo"\t\t<td class='b'>\n";
		// Icone de suppression
		echo"\t\t\t<a href='index.php?action=$mod_name&page=$pub_page&id=$pub_id&deletedata=$id'><img src='".FOLDER_IMG."/delete.png' onclick=\"return confirm('Etes-vous sûr de vouloir l\'effacer ?');\"></a>\n";
		echo"\t\t</td>\n";
		echo"\t\t<td class='b'>\n";
		// Champ de la taille du texte
		echo"\t\t\t<input type='text' name='taille_".$id."' size='4' value='".$line['font_size']."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left'>\n";
		echo"\t\t</td>\n\t\t<td class='b'>\n";
		// Champ de l'angle du texte
		echo"\t\t\t<input type='text' name='angle_".$id."' size='4' value='".$line['pos_ang']."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left'>\n";
		echo"\t\t</td>\n\t\t<td class='b'>\n";
		// Champ de l'abcisse du texte
		echo"\t\t\t<input type='text' name='x_".$id."' size='4' value='".$line['pos_x']."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left'>\n";
		echo"\t\t</td>\n\t\t<td class='b'>\n";
		// Champ de l'ordonnée du texte
		echo"\t\t\t<input type='text' name='y_".$id."' size='4' value='".$line['pos_y']."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left'>\n";
		echo"\t\t</td>\t\t<td class='b'>\n";
		// Champ de la couleur du texte
		echo"\t\t\t<input type='text' name='color_".$id."' size='9' value='".$line['font_color']."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left'>\n";
		echo"\t\t</td>\n\t\t<td class='b'>\n";
		// Affichage de la liste des polices dispo
		echo get_table_list($police,$line['font_name'],"font_".$id);
		echo"\t\t</td>\n\t\t<td class='b'>\n";
		// Champ du contenu
		$text = str_replace("\n","^n",utf8_decode($line['text']));
		echo"\t\t\t<input type='text' name='text_".$id."' size='37' value='".$text."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left'>\n";
		echo"\t\t</td>\n\t</tr>\n";
	}
}
?>
	<tr>
		<td class="d" colspan="1">
			<input type="text" name="add_text" size="37" value="" style="border-style: solid; border-width: 1; color: #C0C0C0; float:left">
		</td>
		<td class="8">
		</td>
	</tr>
	<tr>
		<td class="d" colspan="1">
			<INPUT type='submit' value='Ajouter' name='btn_add_text'>
		</td>
		<td class="8">
		</td>
	</tr>
	<tr height="10">&nbsp</tr>
	<tr>
		<td class="b"  colspan="9">
			<center><a>Images sur l'image</a></center>
		</td>
	</tr>
	<tr>
		<td class="b" colspan="2">
			<a>Nom de l'image</a>
		</td>
		<td class="b">
			 <a>Largeur</a> 
		</td>
		<td class="b">
			 <a>Hauteur</a>
		</td>
		<td class="b">
			 <a>Position X</a>
		</td>
		<td class="b">
			 <a>Position Y</a>
		</td>
		<td class="b" colspan="2">
			 <a>Aperçu</a>
		</td>
		<td class="b">
			 <a>Fichier</a>
		</td>
	</tr>
<?php
// Pour tous les champs de type Images
foreach($data as $line)
{
	if($line['type'] == 'image')
	{
		$id = $line['id'];
		$fichier ="";
		// Si le fichier est bien trouvable, on récupére sa taille
		if(file_exists($line['text']))
			$fichier = $line['text']; 
		elseif(file_exists(FOLDER_IMG."/".$line['text'])&&trim($line['text'])!="")
			$fichier = FOLDER_IMG."/".$line['text'];
		if($fichier!="")
			list($width, $height, $type, $attr) = getimagesize($fichier);
		else
			list($width,$height) = Array (0,0);
		echo"\t<tr>\n";
		// Nom du champ et checkbox Actif/Inactif
		echo"\t\t<td class='b'>\n\t\t\t<input name='actif_".$id."' type='checkbox' ".($line['actif']==1?"checked":"")."> <a>".$line['nom_champ']."</a>\n\t\t</td>\n";
		echo"\t\t<td class='b'>\n";
		// Bouton supprimer
		echo"\t\t\t<a href='index.php?action=$mod_name&page=$pub_page&id=$pub_id&deletedata=$id'><img src='".FOLDER_IMG."/delete.png' onclick=\"return confirm('Etes-vous sûr de vouloir l\'effacer ?');\"></a>\n";
		echo"\t\t</td>\n";
		echo"\t\t<td class='b'>\n";
		// Largeur (non modifiable)
		echo"\t\t\t<input type='text' name='taille_".$id."' size='4' value='".$width."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left' disabled >\n";
		echo"\t\t</td>\n\t\t<td class='b'>\n";
		// Hauteur (non modifiable)
		echo"\t\t\t<input type='text' name='angle_".$id."' size='4' value='".$height."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left' disabled >\n";
		echo"\t\t</td>\n\t\t<td class='b'>\n";
		// Position X
		echo"\t\t\t<input type='text' name='x_".$id."' size='4' value='".$line['pos_x']."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left'>\n";
		echo"\t\t</td>\n\t\t<td class='b'>\n";
		// Position Y
		echo"\t\t\t<input type='text' name='y_".$id."' size='4' value='".$line['pos_y']."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left'>\n";
		echo"\t\t</td>\n\t\t<td class='b' colspan='2'>\n";
		// Si le fichier existe, on affiche l'image
		if($fichier!="")
			echo "\t\t\t<img src='".$fichier."'>\n";
		elseif($line['text']=="")
			echo "\t\t\t<i>Image non définie</i>\n";
		else
			echo "\t\t\t<i>'".$line['text']."' ou '".FOLDER_IMG."/".$line['text']."' introuvable!</i>\n";
		echo"\t\t</td>\n\t\t<td class='b'>\n";
		// Affichage de la liste des images disponible
		echo get_table_list($image_tab,$line['text'],"text_".$id);
		echo"\t\t</td>\n\t</tr>\n";
	}
}
?>
	<tr>
		<td class="d" colspan="1">
			<input type="text" name="add_image" size="37" value="" style="border-style: solid; border-width: 1; color: #C0C0C0; float:left">
		</td>
		<td class="8">
		</td>
	</tr>
	<tr>
		<td class="d" colspan="1">
			<INPUT type='submit' value='Ajouter' name='btn_add_image'>
		</td>
		<td class="8">
		</td>
	</tr>
	<tr height="10">&nbsp</tr>
	<tr>
		<td class="b"  colspan="9">
			<center><a>Les Classements</a></center>
		</td>
	</tr>
	<tr>
		<td class="b" colspan="2">
			<a>Type de classement</a>
		</td>
		<td class="b">
			 <a>Taille du texte</a> 
		</td>
		<td class="b">
			 <a>Angle</a>
		</td>
		<td class="b">
			 <a>Position X</a>
		</td>
		<td class="b">
			 <a>Position Y</a>
		</td>
		<td class="b">
			 <a href="http://www.computerhope.com/htmcolor.htm" target="_blank">Couleur du texte</a>
		</td>
		<td class="b">
			 <a>Police</a>
		</td>
		</td> 
		<td class="b">
			 <a>Texte</a>
		</td>
	</tr>
<?php
//Pour tous les champs de type Stat
foreach($data as $line)
{	
		// IDEM champ type Texte
	if($line['type'] == 'stat')
	{
		$id = $line['id'];
		echo"\t<tr>\n";
		echo"\t\t<td class='b' colspan='2'>\n";
		echo"\t\t\t<input name='actif_".$id."' type='checkbox' ".($line['actif']==1?"checked":"")."> <a> ".$line['nom_champ']." : </a>\n\t\t</td>\n";
		echo"\t\t<td class='b'>\n";
		echo"\t\t\t<input type='text' name='taille_".$id."' size='4' value='".$line['font_size']."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left'>\n";
		echo"\t\t</td>\n\t\t<td class='b'>\n";
		echo"\t\t\t<input type='text' name='angle_".$id."' size='4' value='".$line['pos_ang']."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left'>\n";
		echo"\t\t</td>\n\t\t<td class='b'>\n";
		echo"\t\t\t<input type='text' name='x_".$id."' size='4' value='".$line['pos_x']."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left'>\n";
		echo"\t\t</td>\n\t\t<td class='b'>\n";
		echo"\t\t\t<input type='text' name='y_".$id."' size='4' value='".$line['pos_y']."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left'>\n";
		echo"\t\t</td>\n\t\t<td class='b'>\n";
		echo"\t\t\t<input type='text' name='color_".$id."' size='9' value='".$line['font_color']."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left'>\n";
		echo"\t\t</td>\n\t\t<td class='b'>\n";
		echo get_table_list($police,$line['font_name'],"font_".$id);
		echo"\t\t</td>\n\t\t<td class='b'>\n";
		echo"\t\t\t<input type='text' name='text_".$id."' size='37' value='".utf8_decode($line['text'])."' style='border-style: solid; border-width: 1; color: #C0C0C0; float:left'>\n";
		echo"\t\t</td>\n\t</tr>\n";
	}
}
?>
	<tr>
		<td class="c" colspan="9">
			<center><INPUT type="submit" value="Valider" name='update'></center>
		</td>
	</tr>
</table>
</FORM> 
<center><img src="<?php 
									// Calcul et affichage de l'image
									echo draw_picture($pictures[$pub_id],$data); 
							?>"></center>
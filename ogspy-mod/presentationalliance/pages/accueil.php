<?php
/***************************************************************************
*	Filename	: accueil.php
*	desc.		: Page d'accueil du module "Présentation Alliance"
*	Authors	: Sylar - sylar@ogsteam.fr
*	created	: 23/02/2008
*	modified	: 18/05/2011
*	version	: 1.0
***************************************************************************/
if (!defined('IN_SPYOGAME')) 	die("Hacking attempt");

// Définitions
global $db,$user_data,$mod_name;

// Click sur Modifier: on redirige vers la page edition
if(isset($pub_modify)) redirection("index.php?action=$mod_name&page=edition&id=$pub_id");

// Click sur Créer
if(isset($pub_create_new))
{
	// Si le fichier de destionnation n'est pas en .jpg, on le force
	if(substr($pub_new_output, -4) != ".jpg") $pub_new_output .= ".jpg";

	// Si aucun champs n'est vide et que le fichier de destionnation n'existe pas
	if(($pub_new_name!="")&&($pub_new_ally_name!="")&&$pub_background!="-"
		&&($pub_new_output!="")&&!file_exists(FOLDER_OUTPUT."/".$pub_new_output))
	{
		// On créé l'image et on se redirige vers sa page d'édition
		$pub_id = add_pic($pub_new_name,$pub_new_ally_name,$pub_background,$pub_new_output);
		redirection("index.php?action=$mod_name&page=edition&id=$pub_id");
	}
	// Sinon...
	elseif($pub_new_name=="")
		echo"<font color='red'><blink>Le nom de l'image n'est pas valide!</blink></font>";
	elseif($pub_new_ally_name=="")
		echo"<font color='red'><blink>Le nom de l'alliance n'est pas valide!</blink></font>";
	elseif($pub_background=="-")
		echo"<font color='red'><blink>Vous n'avez pas choisi l'image de fond!</blink></font>";
	elseif($pub_new_output=="")
		echo"<font color='red'><blink>Le nom de l'image de sortie n'est pas valide!</blink></font>";
	elseif(file_exists(FOLDER_OUTPUT."/".$pub_new_output))
		echo"<font color='red'><blink>Le fichier \"".FOLDER_OUTPUT."/".$pub_new_output."\" existe déjà !</blink></font>";
} 
else 
{		
	// On ne demande ni a modifier, ni a créer : il faut définir les valeurs
	$pub_new_output="";
	$pub_new_name="";
	$pub_new_ally_name="";
}
// Click sur Delete
if(isset($pub_delete))
{
	// On récupère la variable id pour suppression et on redirige
		$del_id= $_GET['id'];
		$pub_id = delete_pic($del_id);
		redirection("index.php?action=$mod_name&page=acceuil");
} 
// Génération de la liste des images
$pictures = get_pic();
?>
<br/><br/>
<table>
	<tr>
		<td class="c" colspan="5">
			Liste des images actuelles
		</td>
	</tr>
	<tr>
		<td class="b">
			#ID
		</td>
		<td class="b">
			Nom de l'Image
		</td>
		<td class="b">
			Lien
		</td>
		<td class="b">
			Auteur
		</td>
		<td class="b">
			Action
		</td>
	</tr>
<?php 
// Pour  toutes les images
foreach($pictures as $key => $image)
{ 
	// On créé l'image et on affiche ID, Nom, Lien, Auteur, et les boutons si c'est l'auteur qui visite
	$link = draw_picture($image,get_pic_data($key)); 
?>
	<tr>
		<th>
			#<?php echo $key; ?>
		</th>
		<th>
			<?php echo $image['name']; ?>
		</th>
		<th>
			<a href="<?php echo $link; ?>"><?php echo $link; ?></a>
		</th>
		<th>	
			<?php echo get_user_name_by_id($image['user_id']); ?>
		</th>
		<form action='?action=<?php echo $mod_name; ?>&page=<?php echo $pub_page?>&id=<?php echo $key; ?>' method='post'>
		<th>
				<?php if($image['user_id']==$user_data['user_id']||$image['user_id']==0){ ?>
				<input type='submit' name='modify' value='Modifier'>
				<input type='submit' name='delete' value='Effacer' onclick="return confirm('Etes-vous sûr de vouloir l\'effacer ?');">
				<?php }else{ ?>
				-
				<?php } ?>
		</th>
		</form>
	</tr>
<?php
}
?>
</table>
<?php

// Génération de la liste des fonds disponible
$background = get_background_tab();

// Limite à 5 images/lignes sinon au nombre d'images
$back_per_ligne = ($x=count($background)<$back_per_ligne)?$x:5;
?>
<br/><br/>
<form action='?action=<?php echo $mod_name?>&page=<?php echo $pub_page; ?>' method='post'>
<table>
	<tr>
		<td class="c" colspan="2">
			Créer une nouvelle image
		</td>
	</tr>
		<td class="b">
			Nom de l'Image
		</td>
		<td class="c">
			<input type="text" name="new_name" size="37" value="<?php echo $pub_new_name; ?>" style="border-style: solid; border-width: 1; color: #C0C0C0; float:left">
		</td>
	</tr>
	<tr>
		<td class="b">
			Nom de l'Alliance Associée 
		</td>
		<td class="c">
			<input type="text" name="new_ally_name" size="37" value="<?php echo $pub_new_ally_name; ?>" style="border-style: solid; border-width: 1; color: #C0C0C0; float:left">
		</td>
	</tr>
	<tr>
		<td class="b">
			Nom de l'image de fond
		</td>
		<td class="c">
			<?php echo get_table_list($background,(isset($pub_background)?$pub_background:"-"),"background"); ?>
		</td>
	</tr>
	<tr>
		<td class="b">
			Nom de l'image de sortie
		</td>
		<td class="c">
			<input type="text" name="new_output" size="37" value="<?php echo $pub_new_output; ?>" style="border-style: solid; border-width: 1; color: #C0C0C0; float:left">
		</td>
	</tr>
	<tr>
		<td class="d" colspan="2">
			<input type="submit" name="create_new" value="Envoyer">
		</td>
	</tr>
</table>
<br/><br/>
<table>
	<tr>
		<td class="c" colspan="<?php echo $back_per_ligne; ?>">
			Liste des fonds disponibles
		</td>
	</tr>
<?php 

// Pour tous les fonds
$count=0;
foreach($background as $key => $fichier)
{ 
	// Si c'est la 1ere image de la ligne, on affiche le <tr>
	$count++;
	if($count==1) echo "<tr>";
?>
		<th align="center">
			<a href="<?php echo FOLDER_BKGND."/".$fichier; ?>">
				<img src="<?php echo FOLDER_BKGND."/".$fichier; ?>" width="100" height="100"><br/>
			</a>
			<?php echo $fichier; ?><br/>
			<?php
				// Récupération et affichage des dimensions de l'image
				list($width, $height, $type, $attr) = getimagesize(FOLDER_BKGND."/".$fichier);
				echo "(".$width."x".$height.")";
			?>
		</th>
<?php
	// Si c'est la dernière image de la ligne, on affiche le </tr>
	if($count==$back_per_ligne) 
	{
		echo"</tr>";
		$count = 0;
	}
}

// Combien il restait de case pour finir la ligne? On ne rempli avec du vide
if($count!=0)
{
?>
		<td class="d" colspan="<?php echo $back_per_page-$count; ?>">
			&nbsp
		</td>
	</tr>
<?php
}
?>
</table>
</form>
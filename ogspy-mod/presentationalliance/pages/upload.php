<?php
/***************************************************************************
*	Filename	: upload.php
*	desc.		: Page d'upload du module "Présentation Alliance"
*	Authors	: Shad
*	created	: 30/11/2007
*	modified	: 18/05/2011
*	version	: 1.0
***************************************************************************/
if (!defined('IN_SPYOGAME')) 	die("Hacking attempt");

// Définitions
global $user_data;

$type = $_GET['type'];

if ($_POST)
//Upload de fond
if($type=='fonds') 
{
	$dossier = 'mod/'.$mod_name.'/fonds/';
	$fichier = basename($_FILES['file']['name']);
	$taille_maxi = 300000;
	$taille = filesize($_FILES['file']['tmp_name']);
	$extensions = array('.jpg');
	$extension = strrchr($_FILES['file']['name'], '.'); 

//Vérification du fichiers
	if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans l'array
		{
			$erreur = 'Vous devez uploader un fichier de type jpg';
		}

	if($taille>$taille_maxi)
		{
			$erreur = 'Le fichier est trop gros...';
		}

	if(!isset($erreur)) //Aucune erreur, on upload
		{
			
			//On formate le nom du fichier
			$fichier = strtr($fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
			$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
     
			if(move_uploaded_file($_FILES['file']['tmp_name'], $dossier . $fichier))
				{
					echo 'Upload effectué avec succès !';
				}
			else 
				{
					echo 'Echec de l\'upload !';
				}
		}
	
	else
		{
			echo $erreur;
		}
}

//Upload de police
if($type=='font') 
{
	$dossier = 'mod/'.$mod_name.'/polices/';
	$fichier = basename($_FILES['file']['name']);
	$taille_maxi = 500000;
	$taille = filesize($_FILES['file']['tmp_name']);
	$extensions = array('.ttf');
	$extension = strrchr($_FILES['file']['name'], '.'); 

//Vérification du fichiers
	if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans l'array
		{
			$erreur = 'Vous devez uploader un fichier de type ttf';
		}

	if($taille>$taille_maxi)
		{
			$erreur = 'Le fichier est trop gros...';
		}

	if(!isset($erreur)) //Aucune erreur, on upload
		{
			
			//On formate le nom du fichier
			$fichier = strtr($fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
			$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
     
			if(move_uploaded_file($_FILES['file']['tmp_name'], $dossier . $fichier))
				{
					echo 'Upload effectué avec succès !';
				}
			else 
				{
					echo 'Echec de l\'upload !';
				}
		}
	
	else
		{
			echo $erreur;
		}
}

//Upload de images
if($type=='images') 
{
	$dossier = 'mod/'.$mod_name.'/images/';
	$fichier = basename($_FILES['file']['name']);
	$taille_maxi = 300000;
	$taille = filesize($_FILES['file']['tmp_name']);
	$extensions = array('.png', '.jpg');
	$extension = strrchr($_FILES['file']['name'], '.'); 

//Vérification du fichiers
	if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans l'array
		{
			$erreur = 'Vous devez uploader un fichier de type jpg ou png';
		}

	if($taille>$taille_maxi)
		{
			$erreur = 'Le fichier est trop gros...';
		}

	if(!isset($erreur)) //Aucune erreur, on upload
		{
			
			//On formate le nom du fichier
			$fichier = strtr($fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
			$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
     
			if(move_uploaded_file($_FILES['file']['tmp_name'], $dossier . $fichier))
				{
					echo 'Upload effectué avec succès !';
				}
			else 
				{
					echo 'Echec de l\'upload !';
				}
		}
	
	else
		{
			echo $erreur;
		}
}

?>
<br>
<br>
<!-- Formulaire d'envoie de fond -->
<form method="post" action='?action=<?php echo $mod_name?>&page=<?php echo $pub_page?>&type=fonds' enctype="multipart/form-data">
  <!-- On limite le fichier à 300Ko -->
     <input type="hidden" name="MAX_FILE_SIZE" value="300000">
		<table>
			<tr>
				<td class="c" colspan="3">
					Fichier : 
				</td>
			</tr><tr>
				<td class="b">
					Type
				</td>
				<td class="b">
					Lien
				</td>
				<td class="b">
					Action
				</td>
			</tr><tr>
				<th>
					Fond
				</th>
				<th>
					<input type="file" name="file">
				</th><th>
					<input type="submit" name="envoyer" value="Envoyer le fond"></th>
			</tr>
</form>
<!-- Formulaire d'envoie d'images -->
<form method="post" action='?action=<?php echo $mod_name?>&page=<?php echo $pub_page?>&type=images' enctype="multipart/form-data">
  <!-- On limite le fichier à 300Ko -->
			<tr><th>
					Image
				</th>
				<th>
					<input type="file" name="file">
				</th><th>
					<input type="submit" name="envoyer" value="Envoyer l'image"></th>
			</tr>
</form>
<!-- Formulaire d'envoie de police -->
<form method="post" action='?action=<?php echo $mod_name?>&page=<?php echo $pub_page?>&type=font' enctype="multipart/form-data">
  <!-- On limite le fichier à 300Ko -->
     <input type="hidden" name="MAX_FILE_SIZE" >
			<tr>
				<th>
					Police
				</th>
				<th>
					<input type="file" name="file">
				</th><th>
					<input type="submit" name="envoyer" value="Envoyer la police"></th>
			</tr>
		</table>
</form>

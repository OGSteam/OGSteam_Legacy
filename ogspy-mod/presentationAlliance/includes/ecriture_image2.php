<?php
/***************************************************************************
*	Filename	: ecriture_image2.php
*	desc.		: Script de creation de l'image alliance du module "Présentation Alliance"
*	Authors	: Lose - http://ogs.servebbs.net/; Edité par Sylar - sylar@ogsteam.fr
*	created	: 30/11/2007
*	modified	: 25/02/2008
*	version	: 0.1
***************************************************************************/
/***************************************************************************
* function get_rank($alliance,$data)
*		Remplace dans les champs statistiques de $data, le {rank} par le classement de 
*		l'alliance $alliance trouvé dans la table correspondante.
*		Renvoi le tableau mit à jour.
*
* function draw_picture($pic,$data)
*		Déssine l'image $pic en fonction de ['output'], ['background'] et de la composition du 
*		tableau $data.
*		Renvoi le code HTML <img> correspondant.
*
***************************************************************************/
if (!defined('IN_SPYOGAME')) 	die("Hacking attempt");
/**************************************************************************/
function get_rank($alliance,$data)
{
	//Mets à jour les champs Stat en remplacant le {rank} par le classement le plus récent
	global $db;
	foreach($data as $key=>$line)
	{
		if($line['type']=='stat' && in_array($line['nom_champ'],Array('general','fleet','research')))
		{
			$request = "select datadate, rank, points, number_member, points_per_member";
			switch($line['nom_champ'])
			{
				case 'general' : $request .= " from ".TABLE_RANK_ALLY_POINTS; break;
				case 'fleet' : $request .= " from ".TABLE_RANK_ALLY_FLEET; break;
				case 'research' : $request .= " from ".TABLE_RANK_ALLY_RESEARCH; break;
			}
			$request .= " where ally = '".mysql_real_escape_string($alliance)."'";
			$request .= " order by datadate desc";
			$result = $db->sql_query($request);
			debug_log($request);
			list($datadate, $rank, $points, $number_member, $points_per_member) = $db->sql_fetch_row($result);
			$data[$key]['text'] = str_replace("{rank}",$rank,$line['text']);
		}
	}
	return $data;
}
/**************************************************************************/
function draw_picture($pic,$data)
{
	// Modification de données de stats
	$data = get_rank($pic['tag_alliance'],$data);

	// recherche de l'image de fond
	if(file_exists($pic['background']))
		$source = imagecreatefromjpeg($pic['background']); 
	elseif(file_exists(FOLDER_BKGND."/".$pic['background'])&&trim($pic['background'])!="")
		$source = imagecreatefromjpeg(FOLDER_BKGND."/".$pic['background']);
	else
		debug_log("Fichier '".$pic['background']."' ou '".FOLDER_BKGND."/".$pic['background']."' introuvable!");

	// Si le fond existe
	if(isset($source))
	{
		// on traite chaque ligne
		foreach($data as $line)
		{
			// En fonction du type
			if($line['type'] == 'image'&&$line['actif']==1)
			{
				// Image
				$fichier ="";
				// Elle existe ?
				if(file_exists($line['text']))
					$fichier = $line['text']; 
				elseif(file_exists(FOLDER_IMG."/".$line['text'])&&trim($line['text'])!="")
					$fichier = FOLDER_IMG."/".$line['text'];
				else
					debug_log("Fichier '".$line['text']."' ou '".FOLDER_IMG."/".$line['text']."' introuvable!");
				// Oui ? Alors on prends sa taille
				if($fichier!=""){
					list($width, $height, $type, $attr) = getimagesize($fichier);
					if (substr($fichier, -4) == ".png" )
						// On traite si c'est du PNG
						$image=ImageCreateFromPNG($fichier); 
					elseif (substr($fichier, -4) == ".jpg" || substr($fichier, -4) == ".jpeg" )
						// Différement que si c'est du JPG
						$image=ImageCreateFromjpeg($fichier); 
					else
						// Sinon, on sait pas
						debug_log("Type d'image non supporté pour '".$fichier."'.");
					// L'image est toujours là? Ok, on la copie
					if($image) ImageCopy($source, $image, $line['pos_x'], $line['pos_y'], 0, 0, $width, $height); 
				}
			}
			// Du texte ou des stats, c'est pareil
			if(($line['type'] == 'text'||$line['type'] == 'stat')&&$line['actif']==1)
			{
				// On génére la couleur
				$color = $line['font_color'];
				$color = imagecolorallocate($source, hexdec('0x' . $color{0} . $color{1}), hexdec('0x' . $color{2} . $color{3}), hexdec('0x' . $color{4} . $color{5}));

				// Si la police existe bien, on incruste le texte
				$font = FOLDER_FONT."/" . $line['font_name'];
				if(file_exists($font))
					imagettftext($source, $line['font_size'], $line['pos_ang'], $line['pos_x'], $line['pos_y'], $color, $font, 		$text = str_replace("^n","\n",$line['text']));
			}
		}
	}

	// Si l'image de sortie n'est pas défini (normalement ca arrive jamais)
	if(($pic['output'])=="") $pic['output']="default.jpg";

	// Si l'image n'est pas en .jpg (normalement c'est déjà controlé)
	if (substr($pic['output'], -4) != ".jpg")$pic['output'].=".jpg";

	// On génére l'image
	$output = FOLDER_OUTPUT."/".$pic['output'];
	imagejpeg($source, $output); 

	// Et on echappe son adresse
	return $output;
}
?>
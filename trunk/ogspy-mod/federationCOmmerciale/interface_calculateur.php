<?php
/***********************************************************************
 * filename	:	index.php
 * desc.	:	Fichier principal
 * created	: 	06/11/2006 Mirtador
 *
 * *********************************************************************/
//sécurité

//on récupère les valleurs du premier formulaire
$nb_vendeur=$_POST['nb_vendeur'];
$nb_acheteur=$_POST['nb_acheteur'];
//on les inicialise si ils sont vide
//à venir lol

//on écrit les info bule :p
$infobulle_groupes='Ici vous devez décider la taille des groupes qui participeront à la vente, cette étape est primordiale,';
$infobulle_groupes.='car elle permet de généré le formulaire qui va suivre :p';

$infobulle_pseudo='Le pseudo n\'est pas obligatoire pour que le mod marche, mais il vous permet de généré un BBcode plus explicite';

$infobulle_ressource='Mettez ici, la quantité de ressource que chaque participan souhaite échanger, Mettez l\'unité que vous souhaiter utiliser comme ceci: K,Kilo,M,KK,Million';

$infobulle_total='<p>Facultatif.</p>';
$infobulle_total.='<p>Permet à la barre de vous indiquer combien il vous reste de ressources à ajouter pour avoir le total voulu</p>';

$infobulle_taux='<p>Le taux permet de savoir comment vous valuez les ressources.</p>';
$infobulle_taux.='<p><b><font color="#FF0000">Attention!</font></b></p>';
$infobulle_taux.='<p>Un taux de 0 sera remplacer par un taux de 1, car on ne peut pas avoir de ressources gratuite :p.</p>';

$infobulle_resultat='<p>Voici donc le résultat, mais avent de le lire, il vous faut plusieurs informations.</p>';
$infobulle_resultat.='<p>Premièrement la répartition des ressources est faite sur le principe que tout le monde ce partage de manière égalle ';
$infobulle_resultat.='les différent types de ressources</p>';
$infobulle_resultat.='<p>Deuxièmement c\'est ici que vous allez vraiment comprendre pourquoi je vous ai fait choisir un taux plus tôt,';
$infobulle_resultat.='car j\'ai compare les différents participants selon la valeur de ce qu\'ils ont échanger ce qui fait que si quelqu\'un ';
$infobulle_resultat.='échange 1M de métal il n\'aura pas nécessairement plus de ressources en retour que celui qui a mit 500k de Deutérium</p>';
$infobulle_resultat.='<p>Finalement, Bonne échange</p>';
$infobulle_resultat.='<p>Mirt</p>';

//On s'informe sur le nombre de vendeur, cette étape est essentiel pour pouvoir déterminer le nombre de champ plus loin.
if(!isset($nb_vendeur) or $nb_vendeur<=0 or !estunnombre($nb_vendeur) or !isset($nb_acheteur) or $nb_acheteur<=0 or !estunnombre($nb_acheteur)){
	echo'<table>';
	echo'<form action="index.php" method="post" name="nb_partcipan">';
	echo'<input type="hidden" name="action" value="federation_commerciale">';
	echo'<tr>';
	if($nb_vendeur<=0 and estunnombre($nb_vendeur) and isset($nb_vendeur)){
		echo'<tr>';
		echo'<th colspan="2">Le nombre de vendeur ne peut pas être 0</th>';
		echo'</tr> <tr>';
	}
	if($nb_acheteur<=0 and estunnombre($nb_acheteur) and isset($nb_acheteur)){
		echo'<tr>';
		echo'<th colspan="2"> nombre d\'acheteur ne peut pas être 0</th>';
		echo'</tr> <tr>';
	}
	if(!estunnombre($nb_vendeur) or !estunnombre($nb_acheteur)){
		echo'<tr>';
		echo'<th colspan="2">Vous devez fournir des nombres!!!!</th>';
		echo'</tr> <tr>';
	}
	echo'<td class="c" colspan="2">veuillez indiquer le nombre de vendeur et acheteur qui participeront à la vente';
	infobulle($infobulle_groupes);
	echo'</td>';
	echo'</tr> <tr>';
	echo'<th>Vendeur</th>';
	if(isset($nb_vendeur)){
		echo'<th><input type="text" name="nb_vendeur" value="'.$nb_vendeur.'"></th>';
	}
	else{
		echo'<th><input type="text" name="nb_vendeur" value="0"></th>';
	}
	echo'</tr> <tr>';
	echo'<th>Acheteur</th>';
	if(isset($nb_acheteur)){
		echo'<th><input type="text" name="nb_acheteur" value="'.$nb_acheteur.'"></th>';
	}
	else{
		echo'<th><input type="text" name="nb_acheteur" value="0"></th>';
	}
	echo'</tr> <tr>';
	echo'<th colspan="2"><input type="submit"></th>';
	echo'</tr>';
	echo'</table>';
}
//maintenant qu'on connais le nombre de membre qui participeron a l'échange, 
else{
	//on récupère les valleur du deuxième formulaire
	$pseudo_vendeur=$_POST['pseudo_vendeur'];
	$pseudo_acheteur=$_POST['pseudo_acheteur'];
	$metal_vendeur=$_POST['metal_vendeur'];
	$cristal_vendeur=$_POST['cristal_vendeur'];
	$deuterium_vendeur=$_POST['deuterium_vendeur'];
	$metal_acheteur=$_POST['metal_acheteur'];
	$cristal_acheteur=$_POST['cristal_acheteur'];
	$deuterium_acheteur=$_POST['deuterium_acheteur'];
	$metal_acheteur_total_voulu=$_POST['metal_acheteur_total_voulu'];
	$cristal_acheteur_total_voulu=$_POST['$cristal_acheteur_total_voulu'];
	$deuterium_acheteur_total_voulu=$_POST['deuterium_acheteur_total_voulu'];
	$metal_vendeur_total_voulu=$_POST['metal_vendeur_total_voulu'];
	$cristal_vendeur_total_voulu=$_POST['cristal_vendeur_total_voulu'];
	$deuterium_vendeur_total_voulu=$_POST['deuterium_vendeur_total_voulu'];
	$M_taux=$_POST['M_taux'];
	$C_taux=$_POST['C_taux'];
	$D_taux=$_POST['D_taux'];

	if(isset($_POST['open']))$open=$_POST['open'];
	else $open=false;
	//on s'assure qu'il y a pas des taux négatif
	if (isset($M_taux) and $M_taux==0) $M_taux=1;
	if (isset($C_taux) and $C_taux==0) $C_taux=1;
	if (isset($D_taux) and $D_taux==0) $D_taux=1;
	
	//si elle sont vide on les remplis et on en profite pour traiter les unitées
	for ($i=1 ; $i<=$nb_vendeur ; $i++) {
		//pseudo
		if (!isset($pseudo_vendeur[$i])){
			$pseudo_vendeur[$i]='Vendeur'.$i;
		}
		//métal
		if (!isset($metal_vendeur[$i])){
			$metal_vendeur[$i]=0;
		}
		else{
			$metal_vendeur[$i]=virguleapoint($metal_vendeur[$i]);
			$metal_vendeur[$i]=unitée($metal_vendeur[$i]);
		}
		//cristal
		if (!isset($cristal_vendeur[$i])){
			$cristal_vendeur[$i]=0;
		}
		else{
			$cristal_vendeur[$i]=virguleapoint($cristal_vendeur[$i]);
			$cristal_vendeur[$i]=unitée($cristal_vendeur[$i]);
		}
		//deutérium
		if (!isset($deuterium_vendeur[$i])){
			$deuterium_vendeur[$i]=0;
		}
		else{
			$deuterium_vendeur[$i]=virguleapoint($deuterium_vendeur[$i]);
			$deuterium_vendeur[$i]=unitée($deuterium_vendeur[$i]);
		}
		}
	//total métal
	if (!isset($metal_vendeur_total_voulu)){
		$metal_vendeur_total_voulu=0;
	}
	else{
		$metal_vendeur_total_voulu=virguleapoint($metal_vendeur_total_voulu);
		$metal_vendeur_total_voulu=unitée($metal_vendeur_total_voulu);
	}
	//total cristal
	if (!isset($cristal_vendeur_total_voulu)){
		$cristal_vendeur_total_voulu=0;
	}
	else{
		$cristal_vendeur_total_voulu=virguleapoint($cristal_vendeur_total_voulu);
		$cristal_vendeur_total_voulu=unitée($cristal_vendeur_total_voulu);
	}
	//total deutérium
	if (!isset($deuterium_vendeur_total_voulu)){
		$deuterium_vendeur_total_voulu=0;
	}
	else{
		$deuterium_vendeur_total_voulu=virguleapoint($deuterium_vendeur_total_voulu);
		$deuterium_vendeur_total_voulu=unitée($deuterium_vendeur_total_voulu);
	}
	for ($i=1 ; $i<=$nb_acheteur ; $i++) {
		//pseudo
		if (!isset($pseudo_acheteur[$i])){
			$pseudo_acheteur[$i]='Acheteur'.$i;
		}
		//métal
		if (!isset($metal_acheteur[$i])){
			$metal_acheteur[$i]=0;
		}
		else{
			$metal_acheteur[$i]=virguleapoint($metal_acheteur[$i]);
			$metal_acheteur[$i]=unitée($metal_acheteur[$i]);
		}
		//cristal
		if (!isset($cristal_acheteur[$i])){
			$cristal_acheteur[$i]=0;
		}
		else{
			$cristal_acheteur[$i]=virguleapoint($cristal_acheteur[$i]);
			$cristal_acheteur[$i]=unitée($cristal_acheteur[$i]);
		}
		//deutérium
		if (!isset($deuterium_acheteur[$i])){
			$deuterium_acheteur[$i]=0;
		}
		else{
			$deuterium_acheteur[$i]=virguleapoint($deuterium_acheteur[$i]);
			$deuterium_acheteur[$i]=unitée($deuterium_acheteur[$i]);
		}
	}
	//total métal
	if (!isset($metal_acheteur_total_voulu)){
		$metal_acheteur_total_voulu=0;
	}
	else{
		$metal_acheteur_total_voulu=virguleapoint($metal_acheteur_total_voulu);
		$metal_acheteur_total_voulu=unitée($metal_acheteur_total_voulu);
	}
	//total cristal
	if (!isset($cristal_acheteur_total_voulu)){
		$cristal_acheteur_total_voulu=0;
	}
	else{
		$cristal_acheteur_total_voulu=virguleapoint($cristal_acheteur_total_voulu);
		$cristal_acheteur_total_voulu=unitée($cristal_acheteur_total_voulu);
	}
	//total deutérium
	if (!isset($deuterium_acheteur_total_voulu)){
		$deuterium_acheteur_total_voulu=0;
	}
	else{
		$deuterium_acheteur_total_voulu=virguleapoint($deuterium_acheteur_total_voulu);
		$deuterium_acheteur_total_voulu=unitée($deuterium_acheteur_total_voulu);
	}
	
	echo'<table width="70%" align="center">';
	echo'<tr>';
	echo'<td>';
	echo'<table width="100%">';
	echo'<form action="index.php" method="post" name="ressources">';
	echo'<input type="hidden" name="action" value="federation_commerciale">';
	echo'<input type="hidden" name="nb_vendeur" value="'.$nb_vendeur.'">';
	echo'<input type="hidden" name="nb_acheteur" value="'.$nb_acheteur.'">';
	echo'<input type="hidden" name="open" value="true">';
	echo'<tr>';
	//on s'informe sur la quantitée de ressources
	echo'<th rowspan="2">Pseudo</th><th colspan="3">Quantiter de ressources envoyer';
	infobulle($infobulle_ressource);
	echo'</th>';
	echo'</tr> <tr>';
	echo'<th>métal</th><th>Cristal</th><th>Deutérium</th>';
	echo'</tr> <tr>';
	echo'<td class="c" colspan="4">Vendeur(s)</td>';
	echo'</tr> <tr>';
	//on afiche le tableau pour entré les ressources des vendeur
	for ($i=1 ; $i<=$nb_vendeur ; $i++) {
		//pseudo
		echo'<th>';
		echo'<input type="text" name="pseudo_vendeur['.$i.']" defaultvalue="Vendeur'.$i.'" value="'.$pseudo_vendeur[$i].'" onchange="calcul_bare()">';
		echo'</th>';
		//métal
		echo'<th><input type="text" name="metal_vendeur['.$i.']" defaultvalue="0" value="'.$metal_vendeur[$i].'" onchange="calcul_bare()"></th>';
		//cristal
		echo'<th><input type="text" name="cristal_vendeur['.$i.']" defaultvalue="0" value="'.$cristal_vendeur[$i].'" onchange="calcul_bare()"></th>';
		//deutérium
		echo'<th><input type="text" name="deuterium_vendeur['.$i.']" defaultvalue="0" value="'.$deuterium_vendeur[$i].'" onchange="calcul_bare()"></th>';
		echo'</tr> <tr>';
	}
	echo'<th>total';
	infobulle($infobulle_total);
	echo'</th>';
	//métal
	echo'<th><input type="text" name="metal_vendeur_total_voulu" defaultvalue="0" value="'.$metal_vendeur_total_voulu.'" onchange="calcul_bare()"></th>';
	//cristal
	echo'<th><input type="text" name="cristal_vendeur_total_voulu" defaultvalue="0" value="'.$cristal_vendeur_total_voulu.'" onchange="calcul_bare()"></th>';
	//deutérium
	echo'<th><input type="text" name="deuterium_vendeur_total_voulu" defaultvalue="0" value="'.$deuterium_vendeur_total_voulu.'" onchange="calcul_bare()"></th>';
	//on affiche la bare qui indique quel est la différence avec le total
	echo'<tr>';
	echo'<th></th>';
	echo'<th>';
	echo' <div id="metal_vendeur"></div>';
	echo'</th>';
	echo'<th>';
	echo'<div id="cristal_vendeur"></div>';
	echo'</th>';
	echo'<th>';
	echo'<div id="deuterium_vendeur"></div>';
	echo'</th>';
	echo'</tr>';
	
	echo'</tr> <tr>';
	echo'<td colspan="4" class="c">Acheteur(s)</td>';
	echo'</tr> <tr>';
	for ($i=1 ; $i<=$nb_acheteur ; $i++) {
		//pseudo
		echo'<th><input type="text" name="pseudo_acheteur['.$i.']" defaultvalue="Acheteur'.$i.'" value="'.$pseudo_acheteur[$i].'" onchange="calcul_bare()"></th>';
		//métal
		echo'<th><input type="text" name="metal_acheteur['.$i.']" defaultvalue="0" value="'.$metal_acheteur[$i].'" onchange="calcul_bare()"></th>';
		//cristal
		echo'<th><input type="text" name="cristal_acheteur['.$i.']" defaultvalue="0" value="'.$cristal_acheteur[$i].'" onchange="calcul_bare()"></th>';
		//deutérium
		echo'<th><input type="text" name="deuterium_acheteur['.$i.']" defaultvalue="0" value="'.$deuterium_acheteur[$i].'" onchange="calcul_bare()"></th>';
		echo'</tr> <tr>';
	}
		echo'<th>total';
	infobulle($infobulle_total);
	echo'</th>';
	//métal
	echo'<th><input type="text" name="metal_acheteur_total_voulu" defaultvalue="0" value="'.$metal_acheteur_total_voulu.'" onchange="calcul_bare()"></th>';
	//cristal
	echo'<th><input type="text" name="cristal_acheteur_total_voulu" defaultvalue="0" value="'.$cristal_acheteur_total_voulu.'" onchange="calcul_bare()"></th>';
	//deutérium
	echo'<th><input type="text" name="deuterium_acheteur_total_voulu" defaultvalue="0" value="'.$deuterium_acheteur_total_voulu.'" onchange="calcul_bare()"></th>';
	//on affiche la bare qui indique quel est la différence avec le total
	echo'<tr>';
	echo'<th></th>';
	echo'<th>';
	echo'<div id="metal_acheteur"></div>';
	echo'</th>';
	echo'<th>';
	echo'<div id="cristal_acheteur"></div>';
	echo'</th>';
	echo'<th>';
	echo'<div id="deuterium_acheteur"></div>';
	echo'</th>';
	echo'</tr>';
	
	echo'</tr> <tr>';
	//autre settings
	echo'<td colspan="4" class="c">Autre</td>';
	echo'</tr> <tr>';
	//les taux maintenant
	echo'<th>taux';
	infobulle($infobulle_taux);
	echo'</th>';
	//métal
	if (isset($M_taux)){
		echo'<th><input type="text" name="M_taux" value="'.$M_taux.'"></th>';
	}
	else{
		echo'<th><input type="text" name="M_taux" value="3"></th>';
	}
	//cristal
	if (isset($C_taux)){
		echo'<th><input type="text" name="C_taux" value="'.$C_taux.'"></th>';
	}
	else{
		echo'<th><input type="text" name="C_taux" value="2"></th>';
	}
	//deutérium
	if (isset($D_taux)){
		echo'<th><input type="text" name="D_taux" value="'.$D_taux.'"></th>';
	}
	else{
		echo'<th><input type="text" name="D_taux" value="1"></th>';
	}
	echo'</tr> <tr>';
	echo'<th colspan="4"><input type="submit">';
	echo'   ';
	echo'<input type="reset">';
	echo'</th>';
	echo'</form>';
	echo'</tr> <tr>';
	//on ajoute un bouton qui réinicialisera tout le formulaire
	echo'<form action="index.php" method="post">';
	echo'<th>';
	echo'<input type="hidden" name="action" value="federation_commerciale">';
	echo'<input type="hidden" name="nb_vendeur" value="">';
	echo'<input type="hidden" name="nb_acheteur" value="">';
	echo'<input type="hidden" name="pseudo_vendeur" value="">';
	echo'<input type="hidden" name="pseudo_acheteur" value="">';
	echo'<input type="hidden" name="metal_vendeur" value="">';
	echo'<input type="hidden" name="cristal_vendeur" value="">';
	echo'<input type="hidden" name="deuterium_vendeur" value="">';
	echo'<input type="hidden" name="metal_acheteur" value="">';
	echo'<input type="hidden" name="cristal_acheteur" value="">';
	echo'<input type="hidden" name="deuterium_acheteur" value="">';
	echo'<input type="hidden" name="M_taux" value="">';
	echo'<input type="hidden" name="C_taux" value="">';
	echo'<input type="hidden" name="D_taux" value="">';
	echo'<input type="submit" value="réinitialiser le formulaire">';
	echo'</th>';
	echo'</form>';
	echo'</tr>';
	echo'</table>';
	?>
	<SCRIPT language="JavaScript">
	//on va chercher les résultat à mettre dans la bare
	calcul_bare();
	</SCRIPT>
	<?php
	//on Vérifi qu'il a bien une valleur partout dans le formulaire donc que l'utilisateur a cliquer sur envoyer
	if($open==True){
		//on calcule les résultat grace a la fonction aproprier
		$valeur_vendeur=qt_ressource1_merge($metal_vendeur,$cristal_vendeur,$deuterium_vendeur,$M_taux,$C_taux,$D_taux,$nb_vendeur);
		$valeur_acheteur=qt_ressource1_merge($metal_acheteur,$cristal_acheteur,$deuterium_acheteur,$M_taux,$C_taux,$D_taux,$nb_acheteur);

	
		$qt_ressource_vendeur=qt_ressource1($nb_vendeur,$nb_acheteur,$valeur_vendeur,$valeur_acheteur);
		$qt_ressource_acheteur=qt_ressource1($nb_acheteur,$nb_vendeur,$valeur_acheteur, $valeur_vendeur);
	
		$M_vendeur=qt_ressource1_devide($metal_acheteur,$cristal_acheteur,$deuterium_acheteur,$qt_ressource_vendeur,$M_taux,$C_taux,$D_taux,$nb_vendeur,$nb_acheteur);
		$C_vendeur=qt_ressource1_devide($cristal_acheteur,$metal_acheteur,$deuterium_acheteur,$qt_ressource_vendeur,$C_taux,$M_taux,$D_taux,$nb_vendeur,$nb_acheteur);
		$D_vendeur=qt_ressource1_devide($deuterium_acheteur,$cristal_acheteur,$metal_acheteur,$qt_ressource_vendeur,$D_taux,$C_taux,$M_taux,$nb_vendeur,$nb_acheteur);
		
		$M_acheteur=qt_ressource1_devide($metal_vendeur,$cristal_vendeur,$deuterium_vendeur,$qt_ressource_acheteur,$M_taux,$C_taux,$D_taux,$nb_acheteur,$nb_vendeur);
		$C_acheteur=qt_ressource1_devide($cristal_vendeur,$metal_vendeur,$deuterium_vendeur,$qt_ressource_acheteur,$C_taux,$M_taux,$D_taux,$nb_acheteur,$nb_vendeur);
		$D_acheteur=qt_ressource1_devide($deuterium_vendeur,$cristal_vendeur,$metal_vendeur,$qt_ressource_acheteur,$D_taux,$C_taux,$M_taux,$nb_acheteur,$nb_vendeur);
		//on affiche les résultat sous forme de tableau
		echo'</td>';
		echo'</tr>';
		echo'<tr>';
		echo'<td>';
		echo'<table width="100%">';
		echo'<tr>';
		echo'<td class="c" colspan="7">Résultat';
		infobulle($infobulle_resultat);
		echo'</td>';
		echo'</tr> <tr>';
		echo'<th rowspan="2">Pseudo</th>';
		echo'<th colspan="3">Quantiter de ressources envoyer</th>';
		echo'<th colspan="3">Quantiter de ressources à recevoir</th>';
		echo'</tr> <tr>';
		echo'<th>métal</th><th>Cristal</th><th>deutérium</th><th>métal</th><th>Cristal</th><th>deutérium</th>';
		echo'</tr> <tr>';
		for ($i=1 ; $i<=$nb_vendeur ; $i++) {
			echo'<th><font color="#00FF00">'.$pseudo_vendeur[$i].'</font></th>';
			echo'<th><font color="#00FF00">'.$metal_vendeur[$i].'</font></th>';
			echo'<th><font color="#00FF00">'.$cristal_vendeur[$i].'</font></th>';
			echo'<th><font color="#00FF00">'.$deuterium_vendeur[$i].'</font></th>';
			echo'<th><font color="#00FF00">'.round($M_vendeur[$i]).'</font></th>';
			echo'<th><font color="#00FF00">'.round($C_vendeur[$i]).'</font></th>';
			echo'<th><font color="#00FF00">'.round($D_vendeur[$i]).'</font></th>';
			echo'</tr> <tr>';
		}
		for ($i=1 ; $i<=$nb_acheteur ; $i++) {
			echo'<th><font color="#0000FF">'.$pseudo_acheteur[$i].'</font></th>';
			echo'<th><font color="#0000FF">'.$metal_acheteur[$i].'</font></th>';
			echo'<th><font color="#0000FF">'.$cristal_acheteur[$i].'</font></th>';
			echo'<th><font color="#0000FF">'.$deuterium_acheteur[$i].'</font></th>';
			echo'<th><font color="#0000FF">'.round($M_acheteur[$i]).'</font></th>';
			echo'<th><font color="#0000FF">'.round($C_acheteur[$i]).'</font></th>';
			echo'<th><font color="#0000FF">'.round($D_acheteur[$i]).'</font></th>';
			echo'</tr> <tr>';
		}
		echo'</table>';
		//un peut de BBcode? :p
		include("BBcode.php");
		echo'<tr>';
		echo'<td>';
		echo'<table width="100%" height="100%">';
		echo'<td class="c">Offre en BBcode pour les forums</td>';
		echo'<tr>';
		echo'<th>';
		echo'<form method="post"><textarea rows="5" width="100%" id="bbcode">'.$BBcode.'</textarea></form>';
		echo'</th>';
		echo'</tr>';
		echo'<tr>';
		echo'<th>';
		echo'<a href="#haut" onclick="selectionner()">"Selectionner"</a>';
		echo'</th>';
		echo'</tr>';
		echo'</table>';
		echo'</td>';
		echo'</tr>';
		echo'<tr>';
		echo'<td>';
		echo'<table width="100%" height="100%">';
		echo'<form action="index.php" method="post">';
		echo'<tr>';
		echo'<th>';
		//on indique les donner à transmettre pour sauvegarder
		echo'<input type="hidden" name="action" value="federation_commerciale">';
		echo'<input type="hidden" name="page" value="sauvegarder">';
		echo'<input type="hidden" name="nb_vendeur" value="'.$nb_vendeur.'">';
		echo'<input type="hidden" name="nb_acheteur" value="'.$nb_acheteur.'">';
		for ($i=1 ; $i<=$nb_vendeur ; $i++) {
			echo'<input type="hidden" name="pseudo_vendeur['.$i.']"value="'.$pseudo_vendeur[$i].'">';
			echo'<input type="hidden" name="metal_vendeur['.$i.']"value="'.$metal_vendeur[$i].'">';
			echo'<input type="hidden" name="cristal_vendeur['.$i.']"value="'.$cristal_vendeur[$i].'">';
			echo'<input type="hidden" name="deuterium_vendeur['.$i.']"value="'.$deuterium_vendeur[$i].'">';
		}
		for ($i=1 ; $i<=$nb_acheteur ; $i++) {
			echo'<input type="hidden" name="pseudo_acheteur['.$i.']" value="'.$pseudo_acheteur[$i].'">';
			echo'<input type="hidden" name="metal_acheteur['.$i.']" value="'.$metal_acheteur[$i].'">';
			echo'<input type="hidden" name="cristal_acheteur['.$i.']" value="'.$cristal_acheteur[$i].'">';
			echo'<input type="hidden" name="deuterium_acheteur['.$i.']" value="'.$deuterium_acheteur[$i].'">';
		}
		
		echo'<input type="hidden" name="M_taux" value="'.$M_taux.'">';
		echo'<input type="hidden" name="C_taux" value="'.$C_taux.'">';
		echo'<input type="hidden" name="D_taux" value="'.$D_taux.'">';
		echo'<input align="center" type="submit" value="sauvgarder">';
		echo'</th>';
		echo'</tr>';
		echo'</form>';
		echo'</table>';
		echo'</td>';
		echo'</tr>';
		echo'</table>';
	}
	else{
		echo'</td>';
		echo'</tr>';
		echo'</table>';
	}
}

require_once("pieddepage.php");
?>
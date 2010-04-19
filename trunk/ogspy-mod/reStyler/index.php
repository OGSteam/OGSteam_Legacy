<?php
/**
* index.php page de traitement de modREstyler
* @package modREstyler
* @author oXid_FoX
* @link http://www.ogsteam.fr
*	created		: 03/10/2006 22:46:43
*/

if (!defined('IN_SPYOGAME')) die('Hacking attempt');

// lit automatiquement la dernière version dans le changelog
$fd = fopen(DOSSIER_INCLUDE.'/changelog.txt', 'r');
fgets($fd); // pour virer la première ligne
$restyler_version = trim(fgets($fd)); // et la seconde ligne contient la dernière version ! (avec un trim() pour enlever le EOL)
fclose($fd);

// valeurs de différentes constantes (couleurs, seuils, champs de lecture du RE...)
require DOSSIER_INCLUDE.'/constants.php';

// découpe le rapport d'espionnage en tableaux
// (un tableau par partie : Techno / Batiments / Defense / Flotte)
// les ressources sont faites en dehors, car toujours présentes.
function decoupe_re($a_explode,$nom_partie,&$explode_recup,&$tab) {
	// on explode "$a_explode" autour du $nom_partie
	$explode_recup = explode($nom_partie,$a_explode);
	// si il y a "$explode_recup[1]", c'est que cette partie existe
	if (isset($explode_recup[1])) {
		// donc on la conserve dans "$tab"
		// preg_split : avec ces arguments, scinde la phrase grâce aux virgules et espacements (vient direct du manuel PHP...)
		$tab = preg_split("/[\s,]+/",trim($explode_recup[1]));
	}
}

// mise en forme des parties du RE
// $tab : tableau de la partie du RE
// $seuil : seuil de mise en évidence de cette partie
// $nom_partie : nom développé de la partie (pour l'afficher, mais c'est le même que pour la lecture du RE)
// $nom_style : nom du style à appliquer
function mise_en_forme($tab,$seuil,$nom_partie,$nom_style) {
	// mise en global pour y accéder plus facilement
//	global $style[$_POST['choixforum']];
//	global $graviton;
	// mais pas de global chez lycos...
	$restyler_version=''; // pour une erreur de notice...
	require DOSSIER_INCLUDE.'/constants.php';

	if (isset($tab)) {
		// le type de séparateur de milliers
		$typesepamilliers = NULL;
		if (isset($_POST['sepamilliers']) && isset($_POST['typesepamilliers']) && $_POST['typesepamilliers'] == 'point') $typesepamilliers = '.';
		if (isset($_POST['sepamilliers']) && isset($_POST['typesepamilliers']) && $_POST['typesepamilliers'] == 'espace') $typesepamilliers = ' ';

		echo $style[$_POST['choixforum']]['new_line'],$style[$_POST['choixforum']]['titre'][0],$nom_partie,$style[$_POST['choixforum']]['titre'][1],$style[$_POST['choixforum']]['new_line'];
		$i = 0;
		$cpt_elts = 1;
		while ($i<count($tab)-1) {
			echo $tab[$i];
			$i++;
			while (!is_numeric($tab[$i])) {
				echo ' ',$tab[$i];
				$i++;
			}
			// on vérifie la nécessité d'ajouter les ':' (car pour les ressources, c'est déjà fait)
			if (substr(trim($tab[$i-1]),-1) <> ':' )
				echo ':';

			// mais dans les 2 cas, on affiche un espace après
			echo ' ';

			// on regarde si c'est supérieur au seuil, ou si c'est la techno graviton, ou les EDLM
			if (($tab[$i] > $seuil) || (eregi($graviton,$tab[$i-1]) ) || (eregi($edlm,$tab[$i-1]) )) {
				echo $style[$_POST['choixforum']][$nom_style][0];
				if (isset($typesepamilliers))
			 				echo number_format($tab[$i], 0, ',', $typesepamilliers);
								else
									echo $tab[$i];
								echo $style[$_POST['choixforum']][$nom_style][1];
			}
			else {
				echo $style[$_POST['choixforum']]['defaut'][0];
				if (isset($typesepamilliers))
			 				echo number_format($tab[$i], 0, ',', $typesepamilliers);
								else
									echo $tab[$i];
								echo $style[$_POST['choixforum']]['defaut'][1];
			}
			$i++;
			
			// compactage (alternance des tirets et du retour à la ligne)
			if (isset($_POST['compact'])) {
				if ($cpt_elts > 0 && $i<count($tab)-1) {
					echo ' --- ';
				}
				else {
					echo $style[$_POST['choixforum']]['new_line'];
				}
				$cpt_elts=-$cpt_elts;
			}
			else {
				echo $style[$_POST['choixforum']]['new_line'];
			}
		}
	}
}

// affiche la date en FR
function affich_date($timestamp) {
// note : avec AthlonXP, Apache/1.3.33 (Win32) PHP/5.0.4 : fonction date() plus rapide
//        avec CeleronM, Apache/2.0.58 (Win32) PHP/5.1.4 : fonction strftime() plus rapide
// conclusion ?

	// numéro du jour de la semaine, avec Dimanche = 0
	$njour = strftime("%w",$timestamp);
//	$njour = date('w',$timestamp);
	// mois en numérique (intervalle 1 à 12)
	$nmois = strftime("%m",$timestamp);
//	$nmois = date('m',$timestamp);

	switch ($njour) {
	case 1:
		$jour = 'lundi'; break;
	case 2:
		$jour = 'mardi'; break;
	case 3:
		$jour = 'mercredi'; break;
	case 4:
		$jour = 'jeudi'; break;
	case 5:
		$jour = 'vendredi'; break;
	case 6:
		$jour = 'samedi'; break;
	case 0:
		$jour = 'dimanche'; break;
	default:
		$jour = '';
	}
	switch ($nmois) {
	case 1:
		$mois = 'janvier'; break;
	case 2:
		$mois = 'février'; break;
	case 3:
		$mois = 'mars'; break;
	case 4:
		$mois = 'avril'; break;
	case 5:
		$mois = 'mai'; break;
	case 6:
		$mois = 'juin'; break;
	case 7:
		$mois = 'juillet'; break;
	case 8:
		$mois = 'août'; break;
	case 9:
		$mois = 'septembre'; break;
	case 10:
		$mois = 'octobre'; break;
	case 11:
		$mois = 'novembre'; break;
	case 12:
		$mois = 'décembre'; break;
	default:
		$mois = '';
	}
	
	// on construit la date
	return $jour.' '.strftime("%d",$timestamp).' '.$mois.' à '.strftime("%H:%M:%S",$timestamp);
}

?>

<script type="text/javascript" language="javascript" src="<?php echo DOSSIER_INCLUDE; ?>/fonctions_restyler.js"></script>
<script type="text/javascript" src="<?php echo DOSSIER_INCLUDE; ?>/ColorPicker/CP_Class.js"></script>
<script type="text/javascript">
window.onload = function()
{
	fctLoad();
}
window.onscroll = function()
{
	fctShow();
}
window.onresize = function()
{
	fctShow();
}
</script>

<center>
	<h2 title="Mise en forme des rapports d'espionnage">REstyler <?php echo $restyler_version; ?></h2>
	<h3>Mise en forme des rapports d'espionnage.</h3>
	<h5>by <a href="http://restyler-ogame.ovh.org/contact/" title="contactez-moi">oXid_FoX</a></h5>
</center>
<p style="font-size: 13px; text-align: left;">Petite astuce : tout est expliqu&eacute; avec des <span title="comme cela !">infobulles (tooltips)</span>. <span title="voil&agrave;, vous avez trouv&eacute; !">Laissez le curseur sur le texte ou le champ que vous voulez, vous aurez plus d'infos.</span></p>
<div style="margin: 0; padding: 0; font-size: 13px;">
<form name="restyler" action="" method="post">

	<div style="background-color : transparent; float: left; width: 50%; margin: 1em 0; text-align:left;">
	<div>Collez le rapport d'espionnage ici :</div>
	<textarea name="spyreport" title="Rapport d'espionnage brut" rows="5" cols="10" style="width: 100%;"><?php
	if (isset($_POST['spyreport']) && !empty($_POST['spyreport']))
	echo stripslashes($_POST['spyreport']);
	?></textarea>
	<br>

	<div style="background-color : transparent; width: 49%; text-align : center; float: left;">
		<input type="button" name="efface" onClick="effacer()" title="Efface le rapport d'espionnage" value="Efface le RE">
	</div>
	<div style="background-color : transparent; width: 50%; text-align : center; float: left;">
		<input type="submit" name="envoi" title="&Agrave; appliquer apr&egrave;s chaque changement d'options !" value="Mettre en forme">
	</div>

	<br><br>

	<div>Rapport d'espionnage format&eacute; :</div>
	<textarea name="result" title="Rapport d'espionnage format&eacute;" rows="24" cols="10" style="width: 100%;" readonly="readonly" onClick="this.focus(); this.select();"><?php
	if (isset($_POST['spyreport']) && !empty($_POST['spyreport']))
	{
		// valeur minimum pour que ces éléments soient mis en évidence
		$seuil_ressources = $_POST['seuilressources'];
		$seuil_flotte = $_POST['seuilflotte'];
		$seuil_defense = $_POST['seuildefense'];
		$seuil_batiments = $_POST['seuilbatiments'];
		$seuil_recherche = $_POST['seuilrecherche'];

		// le rapport
		// suppression des points/espaces dans les nombres pour pouvoir travailler avec
		$rapport=preg_replace('/(\d)(\s|\.)(\d)/', '$1$3', $_POST['spyreport']);

		// MISE EN FORME

		// citation & centrage
		if (isset($_POST['citation'])) {
			echo $style[$_POST['choixforum']]['quote'][0];
		}
		if (isset($_POST['centrage'])) {
			echo $style[$_POST['choixforum']]['center'][0];
		}

		// nettoyage du RE

		// explode autour de "MP sur ..."
		$travail1 = explode($spio1,$rapport);
		$num_rapport = 1;

		// et tant qu'il existe une partie contenant "MP sur ...", c'est qu'il y a un RE
		while (isset($travail1[$num_rapport])) {
			// suppression de la phrase concernant l'activité sur la planète
			$no_activite = 'Le scanner des sondes n\'a pas détecté d\'anomalies atmosphériques sur cette planète. Une activité sur cette planète dans la dernière heure peut quasiment être exclue.';
			$travail1[$num_rapport]=str_replace($no_activite, '', stripslashes($travail1[$num_rapport])); // si PHP5, rajouter le paramètre $count pour tester si remplacement il y a eu.
			$activite = '/Le scanner des sondes a détecté des anomalies dans l\'atmosphère de cette planète, indiquant qu\'il y a eu une activité sur cette planète dans les (\d{2}) dernières minutes./';
			$travail1[$num_rapport] = preg_replace($activite, 'Dernière activité détectée (minutes) : \1', stripslashes($travail1[$num_rapport]));

			// explode le résultat autour de la probabilité de destruction
			$travail2 = explode($txt_proba_destruc,$travail1[$num_rapport]);
			// et donc ce qui est au milieu, c'est notre RE nettoyé !
			$re_nettoye = $travail2[0];
			// au passage, on récupère la proba de destruction
			if (isset($travail2[1])) {
				// elle est entre ':' et '%'
				// rappel : substr ( string string, int start [, int length] )
				// donc on coupe à partir de ':'+1, puis on s'arrête X caractères plus loin (distance_départ - distance_arrivée, et -1)
				$proba_destruc = trim(substr($travail2[1],strpos($travail2[1],':')+1,strpos($travail2[1],'%')-strpos($travail2[1],':')-1));
			}


			// découpage du RE

			// la partie recherche
			decoupe_re($re_nettoye,$nom_partie_recherche,$recherche_recup,$tab_recherche);
			// la partie bâtiments
			decoupe_re($recherche_recup[0],$nom_partie_batiments,$batiments_recup,$tab_batiments);
			// la partie défense
			decoupe_re($batiments_recup[0],$nom_partie_defense,$defense_recup,$tab_defense);
			// la partie flotte
			decoupe_re($defense_recup[0],$nom_partie_flotte,$flotte_recup,$tab_flotte);

			// la partie ressources (ce qui reste)
			// découpe spéciale, car dedans, il y a les coords et la date
			list($info,$travail) = split("\n".$nom_metal,trim($flotte_recup[0]));
			$tab_ressources = preg_split("/[\s,]+/",$nom_metal.$travail);

			// FIN DES RECUPERATIONS DE CHAQUE PARTIE

			// pour le compactage
			$cpt_elts = 1;

			// lorsqu'il y a plusieurs RE
			if ($num_rapport > 1) {
				// si pas de regroupement (par défaut)
				if (!isset($_POST['grouper'])) {
					// on affiche l'adresse de REstyler
					echo $style[$_POST['choixforum']]['new_line'],$style[$_POST['choixforum']]['url_restyler'];

					// et la fin de la mise en forme du RE
					if (isset($_POST['citation'])) {
						if (isset($_POST['centrage']))
							echo $style[$_POST['choixforum']]['center'][1],$style[$_POST['choixforum']]['quote'][1],$style[$_POST['choixforum']]['new_line'],$style[$_POST['choixforum']]['quote'][0],$style[$_POST['choixforum']]['center'][0]; // citation + centrage
						else
							echo $style[$_POST['choixforum']]['quote'][1],$style[$_POST['choixforum']]['new_line'],$style[$_POST['choixforum']]['quote'][0]; // citation seulement
					} else
						// sinon, pas de séparation entre les RE (il faut faire un peu d'espacement)
						echo $style[$_POST['choixforum']]['new_line'],$style[$_POST['choixforum']]['new_line'],$style[$_POST['choixforum']]['new_line'];

				} else {
					// ligne de séparation si groupement
					echo $style[$_POST['choixforum']]['new_line'],$style[$_POST['choixforum']]['defaut'][0],'~ ~ ~ ~ ~',$style[$_POST['choixforum']]['defaut'][1],$style[$_POST['choixforum']]['new_line'],$style[$_POST['choixforum']]['new_line'];
				}
			}

			// titre
			echo $espionnage_sur,$style[$_POST['choixforum']]['nom_planete'][0] ;
			$nomplanete = explode($spio2,$info);
			if (isset($_POST['coords'])) {
				$nomplanete[0] .= '\')';
			}
			else {
				$nomplanete[0] = '****';
			}

			echo $nomplanete[0],$style[$_POST['choixforum']]['nom_planete'][1],$le_date;
			// formatage de la date (plus joli)
			$nomplanete[1] = str_replace("\nle ","",$nomplanete[1]);
			$date_re = preg_split("/[- :]/",trim($nomplanete[1]));
			// vérification du format de la date
			if (!is_numeric($date_re[0]))
				echo trim($nomplanete[1]),$style[$_POST['choixforum']]['new_line'];
			else {
				// on met un @ pour pas générer d'erreur avec des mauvais rapports (mais rien ne sera gardé de ce rapport)
				// int mktime ( [int hour [, int minute [, int second [, int month [, int day [, int year [, int is_dst]]]]]]] )
				$timestamp_re = @mktime(substr($date_re[1],2,2),$date_re[2],$date_re[3],$date_re[0],substr($date_re[1],0,2));
				echo affich_date($timestamp_re),$style[$_POST['choixforum']]['new_line'];
			}

			// ressources
			mise_en_forme($tab_ressources,$seuil_ressources,$nom_partie_ressources,'ressources');

			// flotte
			mise_en_forme($tab_flotte,$seuil_flotte,$nom_partie_flotte,'flotte');

			// defense
			mise_en_forme($tab_defense,$seuil_defense,$nom_partie_defense,'defense');

			// batiments
			mise_en_forme($tab_batiments,$seuil_batiments,$nom_partie_batiments,'batiments');

			// technologies
			mise_en_forme($tab_recherche,$seuil_recherche,$nom_partie_recherche,'recherche');

			// la proba de destruction
			if ( isset($proba_destruc) && isset($_POST['probadestruc']) ) {
				echo $style[$_POST['choixforum']]['new_line'],$style[$_POST['choixforum']]['defaut'][0],$proba_destruc,'%',$style[$_POST['choixforum']]['defaut'][1];
				switch ($proba_destruc) {
					case '0':
						echo $txt_proba_destruc_rp_0[rand(0,count($txt_proba_destruc_rp_0)-1)],$style[$_POST['choixforum']]['new_line'];
						break;
					case '100':
						echo $txt_proba_destruc_rp_100[rand(0,count($txt_proba_destruc_rp_100)-1)],$style[$_POST['choixforum']]['new_line'];
						break;
					default:
						echo $txt_proba_destruc_rp,$style[$_POST['choixforum']]['new_line'];
				}
			}

			// on passe au RE suivant
			$num_rapport++;
			echo $style[$_POST['choixforum']]['new_line'];
		}

		// on affiche l'adresse de REstyler
		echo $style[$_POST['choixforum']]['new_line'],$style[$_POST['choixforum']]['url_restyler'];

		if (isset($_POST['centrage'])) {
			echo $style[$_POST['choixforum']]['center'][1];
		}
		if (isset($_POST['citation'])) {
			echo $style[$_POST['choixforum']]['quote'][1];
		}
		// FIN DE LA MISE EN FORME
	}
	?></textarea>
	<br>

<?php
	if (isset($_POST['spyreport']) && !empty($_POST['spyreport'])) {
		echo '<div style="background-color : transparent; width: 50%; text-align : center; float: left;">',"\n"
		,'<input type="button" name="copie" title="Cliquez pour tout s&eacute;lectionner et copiez (CTRL-C)" value="S&eacute;lectionne le r&eacute;sultat" onClick="copier(document.restyler.result)"></div>'
		,'<div style="background-color : transparent; width: 49%; text-align : center; float: left;">',"\n"
		,'<input type="button" name="apercu" onClick="preview()" title="Aper&ccedil;u (ne fonctionne pas bien avec LDU)" value="Aper&ccedil;u"></div>';
	}
	?>

	<br>
	<div style="margin: 30px auto auto">
		<span title="pour tester REstyler ! (jouez avec les param&egrave;tres)">Voir un rapport d'espionnage complet :</span>
		<input type="button" onClick="showREtest()" value="plan&egrave;te" title="avec beaucoup de ressources, de chasseurs légers et de lance-missiles, une EDLM, une grosse mine de métal, graviton">
		<div style="border: 1px ridge white; padding: 5px; overflow: auto; visibility: hidden; position: absolute; width: 470px; height: 450px; top: 225px; left: 50%; margin-left: -235px; background-color: #000000; text-align: right;" id="montrerREtest">
		<input type="button" name="fermer" onClick="closeMessage()" value="Fermer">
		<br>
		<textarea style="width: 95%; height: 90%; text-align: left;" onClick="copier(this)"><?php readfile(DOSSIER_INCLUDE.'/RE_test.txt'); ?></textarea>
		<br>
		<input type="button" name="fermer" onClick="closeMessage()" value="Fermer">
		</div>
	</div>
	</div>

	<div style="background-color : transparent; float: left; width: 50%; margin: 1em 0; text-align:left;">

	<div style="padding-left: 15px;">
		<div style="border-bottom: 1px solid #040e1e;">
		<p title="Tr&egrave;s important, le BBCode diff&egrave;re d'un forum &agrave; l'autre !">Choix du code d'export : <select name="choixforum">
<?php
		$i = 0;
		while($i<count($liste_forum))
		{
		if ((isset($_POST['choixforum'])) && ($_POST['choixforum'] == $i))
			echo "\t\t",'<option value="',$i,'" selected="selected">',$liste_forum[$i],"</option>\n";
		else
			echo "\t\t",'<option value="',$i,'">',$liste_forum[$i],"</option>\n";

		$i++;
		}
		?>
		</select></p>

		<span title="affiche les coordonn&eacute;es de la cible"><input type="checkbox" name="coords" id="coords" <?php
		if (isset($_POST['coords'])) { echo 'checked="checked"'; } ?>> <label for="coords">Afficher les coordonn&eacute;es</label></span>
		<br>
		<span title="avec [center] - conseil : activ&eacute; (si votre forum le permet)"><input type="checkbox" name="centrage" id="centrage" <?php
		if (isset($_POST['centrage'])) { echo 'checked="checked"'; } ?>> <label for="centrage">Centrer le r&eacute;sultat</label></span>
		<br>
		<span title="avec [quote] - conseil : activ&eacute;"><input type="checkbox" name="citation" id="citation" <?php
		if (isset($_POST['citation'])) { echo 'checked="checked"'; } ?>> <label for="citation">Mettre le r&eacute;sultat en citation</label></span>
		<br>
		<span title="style OGame : deux &eacute;l&eacute;ments par ligne - conseil : activ&eacute;"><input type="checkbox" name="compact" id="compact" <?php
		if (isset($_POST['compact'])) { echo 'checked="checked"'; } ?>> <label for="compact">Compacter le r&eacute;sultat</label></span>
		<br>
		<span title="d&eacute;sactiv&eacute; : chaque RE sera dans un bloc [quote] ind&eacute;pendant - conseil : d&eacute;sactiv&eacute;"><input type="checkbox" name="grouper" id="grouper" <?php
		if (isset($_POST['grouper'])) { echo 'checked="checked"'; } ?>> <label for="grouper">Grouper les rapports (utile pour plusieurs rapports d'une m&ecirc;me cible)</label></span>
		<br>
		<span title="affiche la probabilité de destruction des sondes d'espionnage"><input type="checkbox" name="probadestruc" id="probadestruc" <?php
		if (isset($_POST['probadestruc'])) { echo 'checked="checked"'; } ?>> <label for="probadestruc">Afficher la probabilité de destruction</label></span>
		<br>
		<span title="s&eacute;parateur de milliers d&eacute;sactiv&eacute; ou avec les points : le rapport format&eacute; reste compatible avec Speedsim"><input type="checkbox" name="sepamilliers" id="sepamilliers" <?php
		if (isset($_POST['sepamilliers'])) { echo 'checked="checked"'; } ?>> <label for="sepamilliers">Ins&eacute;rer un s&eacute;parateurs de milliers :</label>
			<label for="typesepamilliers_espace"><input type="radio" name="typesepamilliers" id="typesepamilliers_espace" value="espace" <?php
		if (isset($_POST['sepamilliers']) && isset($_POST['typesepamilliers']) && $_POST['typesepamilliers'] == 'espace' ) { echo 'checked="checked"'; } ?>>espace</label>
			<label for="typesepamilliers_point"><input type="radio" name="typesepamilliers" id="typesepamilliers_point" value="point" <?php
		if (isset($_POST['sepamilliers']) && isset($_POST['typesepamilliers']) && $_POST['typesepamilliers'] == 'point' ) { echo 'checked="checked"'; } ?>>point</label>
			</span>
		<br>
		</div>

		<div style="border-bottom: 1px solid #040e1e;">
		<p style="margin: 7px;"><b>Seuils minimums pour que ces &eacute;l&eacute;ments soient mis en &eacute;vidence :</b></p>
		<span title="Seuil pour les ressources"><input type="text" name="seuilressources" size="8" maxlength="10" value="<?php
		if (isset($_POST['seuilressources'])) { echo $_POST['seuilressources']; }
		else { echo $s_ressources; } ?>"> Ressources</span>
		<br>
		<span title="Seuil pour chaque vaisseau"><input type="text" name="seuilflotte" size="8" maxlength="9" value="<?php
		if (isset($_POST['seuilflotte'])) { echo $_POST['seuilflotte']; }
		else { echo $s_flotte; } ?>"> Vaisseaux</span>
		<br>
		<span title="Seuil pour les d&eacute;fenses"><input type="text" name="seuildefense" size="8" maxlength="9" value="<?php
		if (isset($_POST['seuildefense'])) { echo $_POST['seuildefense']; }
		else { echo $s_defense; } ?>"> D&eacute;fenses</span>
		<br>
		<span title="Seuil pour les b&acirc;timents (le niveau des mines est le plus int&eacute;ressant)"><input type="text" name="seuilbatiments" size="8" maxlength="3" value="<?php
		if (isset($_POST['seuilbatiments'])) { echo $_POST['seuilbatiments']; }
		else { echo $s_batiments; } ?>"> B&acirc;timents&nbsp;(mines)</span>
		<br>
		<span title="Seuil pour les technologies"><input type="text" name="seuilrecherche" size="8" maxlength="3" value="<?php
		if (isset($_POST['seuilrecherche'])) { echo $_POST['seuilrecherche']; }
		else { echo $s_recherche; } ?>"> Technologies</span>
		<p style="margin: 7px;"><input type="button" name="seuilszero" onClick="seuilAZero()" title="Mettre tous les seuils &agrave; z&eacute;ro" value="Mettre tous les seuils &agrave; z&eacute;ro"></p>
		</div>

		<div style="border-bottom: 1px solid #040e1e;">
		<p style="margin: 7px;"><b>Couleurs (pour les forums utilisant le code hexad&eacute;cimal) :</b></p>
		<span title="Couleur pour les ressources"><img src="<?php echo DOSSIER_INCLUDE; ?>/ColorPicker/color.gif" width="18" height="18" align="middle" alt="choix de la couleur" onClick="fctShow(document.restyler.couleurressources);">
		<input type="text" name="couleurressources" size="7" maxlength="7" value="<?php
		if (isset($_POST['couleurressources'])) { echo $_POST['couleurressources']; }
		else { echo $c_ressources; } ?>"> Ressources</span>
		<br>
		<span title="Couleur pour la flotte"><img src="<?php echo DOSSIER_INCLUDE; ?>/ColorPicker/color.gif" width="18" height="18" align="middle" alt="choix de la couleur" onClick="fctShow(document.restyler.couleurflotte);">
		<input type="text" name="couleurflotte" size="7" maxlength="7" value="<?php
		if (isset($_POST['couleurflotte'])) { echo $_POST['couleurflotte']; }
		else { echo $c_flotte; } ?>"> Vaisseaux</span>
		<br>
		<span title="Couleur pour les d&eacute;fenses"><img src="<?php echo DOSSIER_INCLUDE; ?>/ColorPicker/color.gif" width="18" height="18" align="middle" alt="choix de la couleur" onClick="fctShow(document.restyler.couleurdefense);">
		<input type="text" name="couleurdefense" size="7" maxlength="7" value="<?php
		if (isset($_POST['couleurdefense'])) { echo $_POST['couleurdefense']; }
		else { echo $c_defense; } ?>"> D&eacute;fenses</span>
		<br>
		<span title="Couleur pour les b&acirc;timents"><img src="<?php echo DOSSIER_INCLUDE; ?>/ColorPicker/color.gif" width="18" height="18" align="middle" alt="choix de la couleur" onClick="fctShow(document.restyler.couleurbatiments);">
		<input type="text" name="couleurbatiments" size="7" maxlength="7" value="<?php
		if (isset($_POST['couleurbatiments'])) { echo $_POST['couleurbatiments']; }
		else { echo $c_batiments; } ?>"> B&acirc;timents</span>
		<br>
		<span title="Couleur pour les technologies"><img src="<?php echo DOSSIER_INCLUDE; ?>/ColorPicker/color.gif" width="18" height="18" align="middle" alt="choix de la couleur" onClick="fctShow(document.restyler.couleurrecherche);">
		<input type="text" name="couleurrecherche" size="7" maxlength="7" value="<?php
		if (isset($_POST['couleurrecherche'])) { echo $_POST['couleurrecherche']; }
		else { echo $c_recherche; } ?>"> Technologies</span>
		<br>
		<span title="Couleur par d&eacute;faut"><img src="<?php echo DOSSIER_INCLUDE; ?>/ColorPicker/color.gif" width="18" height="18" align="middle" alt="choix de la couleur" onClick="fctShow(document.restyler.couleurdefaut);">
		<input type="text" name="couleurdefaut" size="7" maxlength="7" value="<?php
		if (isset($_POST['couleurdefaut'])) { echo $_POST['couleurdefaut']; }
		else { echo $c_defaut; } ?>"> D&eacute;faut</span>
		<br>
		<span title="Couleur pour les titres de parties"><img src="<?php echo DOSSIER_INCLUDE; ?>/ColorPicker/color.gif" width="18" height="18" align="middle" alt="choix de la couleur" onClick="fctShow(document.restyler.couleurtitre);">
		<input type="text" name="couleurtitre" size="7" maxlength="7" value="<?php
		if (isset($_POST['couleurtitre'])) { echo $_POST['couleurtitre']; }
		else { echo $c_titre; } ?>"> Titres</span>
		<br>
		<span title="Couleur pour le nom de la plan&egrave;te et des coordonn&eacute;es"><img src="<?php echo DOSSIER_INCLUDE; ?>/ColorPicker/color.gif" width="18" height="18" align="middle" alt="choix de la couleur" onClick="fctShow(document.restyler.couleurplanete);">
		<input type="text" name="couleurplanete" size="7" maxlength="7" value="<?php
		if (isset($_POST['couleurplanete'])) { echo $_POST['couleurplanete']; }
		else { echo $c_nom_planete; } ?>"> Plan&egrave;te et coordonn&eacute;es</span>
		<p style="margin: 7px;"><input type="button" name="couleursdefaut" onClick="couleurParDefaut()" title="Remettre les couleurs d'origine" value="Remettre les couleurs par d&eacute;faut"></p>
		</div>

		<p style="margin: 7px;">
		<input type="button" name="savoptions" onClick="cookieForms('save', 'restyler')" title="Sauvegarder les options (avec un cookie)" value="Sauvegarder les options">
		<input type="button" name="chargoptions" onClick="cookieForms('open', 'restyler')" title="Charger les options" value="Charger les options">
		</p>
	</div>
	</div>

</form>
<script type="text/javascript">
cookieForms('open', 'restyler');
</script>
</div>

<div style="border: 1px ridge white; padding: 5px; overflow: auto; visibility: hidden; position: absolute; width: 470px; height: 450px; top: 225px; left: 50%; margin-left: -235px; background-color: #000000;" id="message">
	<table width="100%">
	<tbody>
		<tr>
		<td><b id="note0">Aper&ccedil;u</b></td>
		<td align="right"><input type="button" name="fermer" onClick="closeMessage()" value="Fermer"></td>
		</tr>
	</tbody>
	</table>
	<div id="preview" style="background-color: #2e2e2e; padding: 10px; font-size : 12px; text-align: left;"> </div>
	<table width="100%">
	<tbody>
		<tr>
		<td align="left">Thanks to <a href="http://www.takanacity.com/" title="website of Takana's OGame Tools">Takana's Team</a> for this preview !</td>
		<td align="right"><input type="button" name="fermer" onClick="closeMessage()" value="Fermer"></td>
		</tr>
	</tbody>
	</table>
</div>

<div style="width: 100%; clear: both;">
	<fieldset title="Changelog"><legend><b> Changelog </b></legend><br>
	<div style="font-family:Courier;">
	<?php
	$read_first = 1;
	require_once DOSSIER_INCLUDE.'/readchangelog.php';
	?>

	</div>
	</fieldset>
</div>
<p>Pour tout probl&egrave;me ou m&ecirc;me juste une suggestion, <a href="http://restyler-ogame.ovh.org/contact/" title="contactez-moi">postez votre message sur le forum</a> (pas d'inscription requise).</p>
<?php
require_once DOSSIER_INCLUDE.'/footer.php';
?>

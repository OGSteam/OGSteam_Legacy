<?php
/**
* reqsql.php panneau de requ�tage SQL
* @package modSQL
* @author oXid_FoX
* @link http://www.ogsteam.fr
* created : 11/03/2007 22:30:43
*/

if (!defined('IN_SPYOGAME')) die('Hacking attempt');


/**
 * suppression des �ventuels guillemets ajout�s
 *
 * @param string $value valeur � nettoyer
 * @return string
 */
function unquote_smart($value)
{
	// Stripslashes
	if (get_magic_quotes_gpc())
		return stripslashes($value);
	else
		return stripslashes($value);
}

/**
 * protection des variables pour MySQL (gestion des guillemets)
 * provient du manuel PHP
 *
 * @param string $value valeur � prot�ger
 * @param bool $addquote ajouter ou non les quotes autour de la valeur
 * @return string chaine prot�g�e
 */
function quote_smart($value,$addquote = TRUE) {
	// Stripslashes
	if (get_magic_quotes_gpc())
		$value = stripslashes($value);

	// Protection si ce n'est pas un entier ou pas une chaine � prot�ger
	if (!is_numeric($value) && $addquote)
		$value = "'" . mysql_real_escape_string($value) . "'";

	return $value;
}

// traitements

// affichage du contenu de la table cliqu�e
if (!empty($pub_table))
	$pub_requete = 'SELECT * FROM `'.quote_smart($pub_table, FALSE).'` LIMIT 30';

// on s'occupe de la/les requ�te(s) envoy�e(s)
// multi requetes (merci tsyr2ko pour la regex et son utilisation)
if (!empty($pub_requete)) {
	$pub_requete = unquote_smart($pub_requete);

	// la regex : coupe les "points-virgule suivis (ou pas) d'espace(s) puis d'un ordre SQL", multiligne & insensible � la casse
	// les 2 options sont pour inclure les d�limiteurs dans l'output et �liminer les sous-chaines vides

	$tmp_requete = ';'.$pub_requete;

	$pat[0] = "/^\s+/";
	$pat[1] = "/\s{2,}/";
	$pat[2] = "/\s+\$/";
	$pat[3] = "/;\$/";
	$rep[0] = "";
	$rep[1] = " ";
	$rep[2] = "";
	$rep[3] = "";
	$tmp_requete = preg_replace($pat, $rep, $tmp_requete);

	// les 2 options sont pour inclure les d�limiteurs dans l'output et �liminer les sous-chaines vides
	$requetes = preg_split('#;\s*(select|explain|alter|delete|drop|insert|replace|update|load|show|check|analyze|repair|optimize)#mi',$tmp_requete,-1,PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
	for ($i = 0; $i < count($requetes); $i += 2) {
		array_splice($requetes, $i, 2, array($requetes[$i].$requetes[1+$i--]));
	}
}

// le traitement des requ�tes
if (isset($requetes)) {
	foreach($requetes as $requete) {

		// suppression des caract�res inutiles
		$requete = trim($requete);
		// ex�cution de la requete
		$ress = $db->sql_query($requete);
		// affichage de la requete en haut de la page
		echo '<table width="100%" cellspacing="1"><tr class="style"><td style="text-align: left;">',$requete,'</td></tr>';

		$premiere_ligne = TRUE;
		$class_css = 'f';
		// requete de type modification (DELETE, INSERT, REPLACE, UPDATE...)
		if (strpos(strtolower($requete),'alter') !== FALSE) {
			echo '<tr><td class="f">Table modifi�e.</td></tr>';
		} elseif (strpos(strtolower($requete),'delete') !== FALSE) {
			echo '<tr><td class="f"><b>',$db->sql_affectedrows(),'</b> lignes <b>supprim�es</b>.</td></tr>';
		} elseif (strpos(strtolower($requete),'insert') !== FALSE) {
			echo '<tr><td class="f"><b>',$db->sql_affectedrows(),'</b> lignes <b>ins�r�es</b>.</td></tr>';
		} elseif (strpos(strtolower($requete),'replace') !== FALSE) {
			echo '<tr><td class="f"><b>',$db->sql_affectedrows(),'</b> lignes <b>remplac�es</b>.</td></tr>';
		} elseif (strpos(strtolower($requete),'update') !== FALSE) {
			echo '<tr><td class="f"><b>',$db->sql_affectedrows(),'</b> lignes <b>mises � jour</b>.</td></tr>';
		} elseif (strpos(strtolower($requete),'drop') !== FALSE) {
			echo '<tr><td class="f"><b>Drop</b> effectu�.</td></tr>';
		} elseif (strpos(strtolower($requete),'load') !== FALSE) {
			echo '<tr><td class="f"><b>',$db->sql_affectedrows(),'</b> lignes <b>affect�es</b>.</td></tr>';
		} else {
			// � faire uniquement si requete de type affichage (SELECT, SHOW, DESCRIBE, EXPLAIN...)
			echo '<tr class="style"><td style="text-align: left;">Affichage des enregistrements : <b>',$db->sql_affectedrows(),'</b> au total.</td></tr></table>';
		echo '<table cellpadding="0" cellspacing="1" align="center">';
			while ($row = $db->sql_fetch_assoc($ress)) {
				// la ligne d'entete, avec le nom des champs
				if ($premiere_ligne) {
					$titre = array_keys($row);
					echo '<tr>';
					foreach ($titre as $cell)
						echo '<td class="c">',$cell,'</td>'; // pas n�cessaire de prot�ger les noms des champs (impossible d'avoir des caract�res HTML dans cette partie l�)
					echo "</tr>\n";
				}
				$premiere_ligne = FALSE;

				// les r�sultats
				echo '<tr>';
				foreach ($row as $cell){
					echo '<td style="text-align:left;" class="',$class_css,'">';
					if (!isset($cell) || $cell == '' ) echo '&nbsp;','</td>'; // pour les champs vides. empty() n'est pas � utiliser ici surtout pour les valeurs z�ro
					else echo htmlentities($cell,ENT_QUOTES),'</td>'; // htmlentities() ou htmlspecialchars() ? convertir tous les caract�res, ou juste les balises HTML ?
				}
				echo "</tr>\n";
				// alternance des styles
				if ($class_css == 'f') $class_css = 'k'; else $class_css = 'f';
			}

			// lib�ration des ressources
			$db->sql_free_result($ress);
		}
		echo '</table>';

	}
} else {
	// pas de requete. on en donne une pour exemple
	$pub_requete = 'SELECT * FROM ogspy_config LIMIT 10';

	// avertissement (pr�sent uniquement lorsqu'il n'y a pas eu de requ�te � ex�cuter)
	echo '<div style="color: #ff1111; background-color: #111111; font-weight: bolder; font-size: larger; text-align: center;">
Attention ! L\'acc�s � la base de donn�es est total ! Ne faites pas n\'importe quoi, vous risquez de tout perdre !<br />
Faites attention notamment aux mots "DELETE", "DROP".<br />
Et ne donnez pas le r�sultat � des personnes inconnues !</div>
';
}
// fin du traitement des requ�tes

// listage des tables de la base (avec un @ pour les serveurs o� �a ne fonctionne pas)
//$liste_tables = @mysql_list_tables($db_database);
$liste_tables = $db->sql_query('SHOW TABLES FROM '.$db_database);
if ($liste_tables !== FALSE) {
	// style CSS pour la liste
	echo '<style type="text/css">div ul .listetable:hover {text-decoration: none; color: lime; text-decoration: underline overline;}</style>',"\n",
	'<div style="width: 260px; float: left; text-align: left;">Liste des tables pr�sentes dans la base :',"\n",
	'<div class="style" style="width: 240px;"><ul style="list-style-type: square; text-align: left; margin-left: -0px;">',"\n";
	// le listage des tables
	while ($row = mysql_fetch_row($liste_tables)) {
		echo '<li><a href="index.php?action=modSQL&table=',$row[0],'" class="listetable">',$row[0],"</a></li>\n";
	}
	echo '</ul></div></div>',"\n",'<div style="margin-left: 260px;">',"\n";
} else
	echo "<div>\n";
// fin du listage

?>
<form action="index.php?action=modSQL" method="post">
<textarea rows="14" cols="30" style="width: 100%;" name="requete"><?php echo $pub_requete; ?></textarea>
<input type="submit" name="envoi" style="width: 100%;" value="Ex�cuter">
</form>
</div>

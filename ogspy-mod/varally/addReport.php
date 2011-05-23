<?php
/** $Id$ **/
/**
* Ajout de rapports
* @package varAlly
* @author Aeris
* @link http://ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) die('Hacking attempt');

/**
 * @var string $data le copie paste de la page alliance
 * @var $ally l'alliance ou la wing concerné 
 */
function addReport( $data, $ally )
{
	global $db, $user_data;
	
	$time = time();
	if ($time > mktime(0,0,0) && $time <= mktime(8,0,0)) $timestamp = mktime(0,0,0);
	if ($time > mktime(8,0,0) && $time <= mktime(16,0,0)) $timestamp = mktime(8,0,0);
	if ($time > mktime(16,0,0) && $time <= (mktime(0,0,0)+60*60*24)) $timestamp = mktime(16,0,0);
	
	$ally = mysql_real_escape_string($ally);
	//Compatibilité UNIX/Windows
	$data = str_replace("\r\n","\n",$data);
	
	//Compatibilité IE/Firefox
	$data = str_replace("\t"," ",$data);
	$data = str_replace("Écrire un message","",$data);
	
	/* On rationnalise les espaces. */
	preg_replace("#\s+#", " ", $data);
	
	/* Eclatement de la chaine. */
	$dataArray = explode("\n", $data);
	
	/* Vérification de l'entête des données. */
	if (preg_match("#Nr\.\s+Nom\s+Statut\s+Points\s+Coord\s+Adhésion\s+Online#", $dataArray[0]) == 0):
		return 'error';
	endif;
	
	/*
	 * Elaboration des requêtes.
	 *
	 * ATTENTION !!
	 * Le parseur est tout ce qu'il y a de plus basique.
	 * Il n'y a pas de vérification de noms dans la base.
	 * Le rang ne doit pas contenir d'espace.
	 */
	$queries = array();
	$pattern = "#\d+\s+(.*)\s+.*\s+(\d*\.*\d+)\s+\[.*\]\s+\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2}.*#";
	for ($i = 1; isset($dataArray[$i]); $i++) {
		if (preg_match($pattern, $dataArray[$i], $reg) == 0):
			continue;
		else:
			$q = "INSERT INTO " . TABLE_VARALLY . " (datadate,player, ally, points, sender_id) ";
			$q .= "VALUES ('$timestamp', ";
			$q .= "'" . mysql_real_escape_string($reg[1]) . "', ";
			$q .= "'" . mysql_real_escape_string($ally) . "', ";
			$q .= "'" . mysql_real_escape_string(str_replace(".", "", $reg[2])) . "', ";
			$q .= "'" . mysql_real_escape_string($user_data["user_id"]) . "'";
			$q .= ")";
			$queries[] = $q;
		endif;
	}
	
	/* Exécution des requêtes. */
	foreach ($queries as $q)
		$db->sql_query($q);
	
	return sizeof($queries);
}

if (isset($pub_ally) && $pub_data != '')
{
	$nb = addReport($pub_data,$pub_ally);
	if ($nb != 'error')
	{
		echo 'Importation effectuée avec succès<br>'.$nb.' membres trouvés';
	} else {
		echo 'Données erronées, l\'importation a échoué';
	}
	echo '<br><a href=\'?action=varAlly&subaction=display\'>Retour</a>';
} else {
	$listTag = explode(';',$server_config['tagAllySpy']);
?>
<form action='?action=varAlly&subaction=report' method='post'>
<select name='ally'>
<?php
	foreach ($listTag as $tag)
	{
		echo '<option>'.$tag.'</option>';
	}
?>
</select>
<textarea width='100%' name='data'></textarea>
<input type='submit' value='Soumettre les données'>
</form>
<?php
}
?>

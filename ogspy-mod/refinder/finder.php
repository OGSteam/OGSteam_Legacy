<?php
	/***************************************************************************
	*	fichier		: finder.php
	*	description.		: permet de faire des recherches dans les rapports d'espionnages
	*	Auteur		:  Chr0nos
	*	créé			: 21/08/2006
	*	modifié		: 5/04/2008
	*	version		: 0.4
	
	Changelog:
		0.2	Amélioration de l'aspect graphique (moins moche)
			Suppression des fonctions inutiles
		0.3	Ajout de balises de position pour avoir accès et transmettre les rapports d'espionnages plus facilement (les balises c'est les #xxxx )
			Possibilité de choisir de qui on veux voir les rapports
			Stats selon qui a envoyé combien de rapports dans un tableau
		    Ajout de sécurité pour la variable P (une vérification est faite pour déterminer s'il s'agit bien d'un nombre)
		0.4	Conversion du mod pour exploiter la version 3.05 d'ogspy et ses RE parsés
		    Compatibilité conservée avec OGSpy 3.04
		    Corrections orthographiques ;)
			
	***************************************************************************/

	//partie obligatoire (sécurité)
	if (!defined('IN_SPYOGAME')) die("Hacking attempt"); //si l'utilisateur ne passe pas par la page index.php
	require_once("views/page_header.php"); //on inclus le logo de ogspy dans le mod (l'entete)
	
	//configuration du script
	$config['action'] = 'refinder';//laissez par défaut si vous ne savez pas de quoi il s'agis: c'est ce que index.php?action=X vaut (par défaut: refinder)
	$config['max'] = 5; //nombre maximal de RE a afficher
	$config['show_nevers'] = 1; //afficher les utilisateurs qui n'ont jamais mis de RE sur la carte
	
	//couleurs des parties des rapports d'espionnages
	$skin['sections'] = 'red'; //couleurs des sections (défense, flottes, bâtiments)
	$skin['titre'] = 'purple'; //titre du RE (matières premières sur... )
	$skin['prob'] = 'orange'; //taux de probabilité de perte des sondes d'espionnages
	$skin['recherche'] = 'cyan'; //recherche
	$skin['def'] = 'pink'; //défense
	$skin['flotte'] = '#00FF00'; //flotte
	$skin['builds'] = 'grey'; //bâtiments
	
	$skin['coords'] = '#00FF00'; //affichage des coordonnées
	
	// Les tableaux de correspondance code=>nom réel
	$flotte = array ( 'PT' => 'Petit transporteur', 'GT' => 'Grand transporteur', 'CLE' => 'Chasseur l&eacute;ger', 'CLO' => 'Chasseur lourd', 
    'CR' => 'Croiseur', 'VB' => 'Vaisseau de bataille', 'VC' => 'Vaisseau de colonisation', 'REC' => 'Recycleur', 
    'SE' => 'Sonde espionnage', 'BMD' => 'Bombardier', 'DST' => 'Destructeur', 'EDLM' => 'Etoile de la mort', 
    'SAT' => 'Satellite solaire', 'TRA' => 'Traqueur' );
     $defs = array ( 'LM' => 'Lanceur de missile', 'LLE' => 'Artillerie laser l&eacute;g&egrave;re', 'LLO' => 'Artillerie laser lourde', 
    'CG' => 'Canon de Gauss', 'AI' => 'Artillerie &agrave; ions', 'LP' => 'Lanceur de plasma', 'PB' => 'Petit bouclier', 
    'GB' => 'Grand bouclier', 'MIC' => 'Missile interception', 'MIP' => 'Missile interplan&eacute;taire' );
     $bats = array ( 'M' => 'Mine de m&eacute;tal', 'C' => 'Mine de cristal', 'D' => 'Synth&eacute;tiseur de deut&eacute;rium', 
    'CES' => 'Centrale &eacute;lectrique solaire', 'CEF' => 'Centrale &eacute;lectrique de fusion', 'UdR' => 'Usine de robots', 
    'UdN' => 'Usine de nanites', 'CSp' => 'Chantier spatial', 'HM' => 'Hangar de m&eacute;tal', 'HC' => 'Hangar de cristal', 
    'HD' => 'R&eacute;servoir de deut&eacute;rium', 'Lab' => 'Laboratoire de recherche', 'Ter' => 'Terraformeur', 
    'DdR' => 'D&eacute;p&ocirc;t de ravitaillement', 'Silo' => 'Silo de missiles', 'BaLu' => 'Base lunaire', 'Pha' => 'Phalange de capteur', 
    'PoSa' => 'Porte de saut spatial' );
     $techs = array ( 'Esp' => 'Technologie Espionnage', 'Ordi' => 'Technologie Ordinateur', 'Armes' => 'Technologie Armes', 
    'Bouclier' => 'Technologie Bouclier', 'Protection' => 'Technologie Protection des vaisseaux spatiaux', 
    'NRJ' => 'Technologie Energie', 'Hyp' => 'Technologie Hyperespace', 'RC' => 'Technologie R&eacute;acteur &agrave; combustion', 
    'RI' => 'Technologie R&eacute;acteur &agrave; impulsion', 'PH' => 'Technologie Propulsion hyperespace', 'Laser' => 'Technologie Laser', 
    'Ions' => 'Technologie Ions', 'Plasma' => 'Technologie Plasma', 'RRI' => 'R&eacute;seau de recherche intergalactique', 
    'Graviton' => 'Technologie Graviton', 'Expeditions' => 'Technologie Exp&eacute;ditions' );
    
    // Compteur pour la représentation des RE
    $count = 0;
    
    // Test pour savoir si ogspy >= 3.05
    $result = $db->sql_query("SELECT config_value FROM ".TABLE_CONFIG." WHERE config_name = 'version'");
    list($ogsversion) = $db->sql_fetch_row($result);
    
	//fonction de filtrage des caractères 'sensibles' pour les requêtes mysql
	function sql_filter($in) {
		return mysql_real_escape_string(str_replace(array(';','(',')',chr(39),'"','`','|'),'',$in));
	}
	
	
	echo '<div style="float:left;">
	<br/>
	<table borders=2>
	<tr>
		<th>Nom</th>
		<th>Rapports d\'espionnages</th>
		<th>%</th>
	</tr>';

	$ids = $db->sql_query("SELECT user_id,user_name,spy_added_web,spy_added_ogs FROM ".TABLE_USER."");
	
	
	if(version_compare($ogsversion, "3.05", ">=") === TRUE) { // Si version 3.05 et plus, on utilise les RE parsés
	
	$stats = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM ".TABLE_PARSEDSPY)); //nombre de RE
	while ($tmp = $db->sql_fetch_assoc($ids)) {
		//on remplis un tableau avec les noms d'utilisateurs et leurs id de forme $id[ID] = NOM
		$id[$tmp['user_id']] = $tmp['user_name'];
		echo '<tr>';
			$spys = mysql_fetch_array(mysql_query("SELECT COUNT(*) as nb FROM ".TABLE_PARSEDSPY." WHERE sender_id = '".intval($tmp['user_id'])."'")); //nombre de RE
			if ($spys['nb'] > 0) {
				echo '<th><a href="./index.php?action='.$config['action'].'&sender='.$tmp['user_name'].'">'.$tmp['user_name'].'</a></th>
				<th>'.$spys['nb'].'</th>
				<th>'.round($spys['nb'] / $stats['total'] * 100,2).'%</th>';
			}
			elseif ($config['show_nevers']) echo '<th>'.$tmp['user_name'].'</th><th>0</th><th>0%</th>';
			echo '</tr>';
		//on remplis un tableau avec les noms d'utilisateurs et leurs id de forme $id[NOM = ID
		$idn[$tmp['user_name']] = $tmp['user_id'];
	}
	echo '<tr>
				<th><a href="./index.php?action='.$config['action'].'">Tous</a></th>
				<th>'.$stats['total'].'</th>
				<th>100%</th>
			</tr>
		</table>
	</div>';
	//sert a choisir de qui on veut voir les rapports: si une personne en particulier est demandée
	if ((isset($_GET['sender'])) && (isset($idn[sql_filter($_GET['sender'])]))) {
		//préparation de l'ajout dans la requête mysql
		$sender = "WHERE sender_id = '".$idn[sql_filter($_GET['sender'])]."'";
		$slink = '&sender='.sql_filter($_GET['sender']);
	}
	//sinon on met le tout a NULL pour ne pas déclencher d'erreur comme un bouseux
	else {
		$sender = NULL;
		$slink = NULL;
	}
	//assigne a $stats['nb'] le nombre total de RE
	$stats = mysql_fetch_array(mysql_query("SELECT COUNT(*) as nb FROM ".TABLE_PARSEDSPY." $sender")); //nombre de RE
	//déclaration de la variable $p (page N°) a 1 par défaut
	$p = 1;
	//si p est définis en GET alors il est égal a sa valeur
	if (isset($_GET['p'])) $p = sql_filter($_GET['p']);
	//sinon on vérifie que P existe en post et on lui attribue sa valeur si c'est le cas
	elseif (isset($_POST['p'])) $p = sql_filter($_POST['p']);
	//Si $p n'est pas un nombre on le met = a 1 pour des raisons de sécurité
	if (!is_numeric($p)) $p = 1;
	//calcul du nombre total de pages possibles a afficher (arrondi au supérieur)
	$tot = round($stats['nb'] / $config['max'],0);
	//si la page demandée n'est pas dans la tranche de pages existantes alors on règle la page a 1
	if (($p > $tot) || ($p < 1)) $p = 1;
	//on stocke dans une variable la position du premier RE a afficher
	$start = $p * $config['max'] - $config['max'];
	echo '<div style="float:top;">';
	//si la page demandée est supérieure a 1 alors on affiche un bouton "précédent" avec un lien
	if ($p > 1) echo '<a href="./index.php?action='.$config['action'].'&p='.($p - 1).$slink.'">Pr&eacute;c&eacute;dente </a>';
	//sinon juste le nom du bouton pour garder la mise en forme
	else echo 'Pr&eacute;c&eacute;dente ';
	//on affiche la page actuelle et le nombre de pages totale pour que l'utilisateur sache a quelle page il se trouve
	echo "$p / $tot";
	//si la page demandée est inférieure au nombre de la dernière page possible alors on affiche un bouton suivant
	if ($p < $tot) echo '<a href="./index.php?action='.$config['action'].'&p='.($p + 1).$slink.'"> Suivante</a>';
	//sinon juste le nom du bouton pour garder la mise en forme
	else echo 'Suivante ';
	echo '</div>';
	//requête mysql à transmettre au serveur (elle est mise dans une variable pour faciliter le debugage)
	$req = "SELECT * FROM ".TABLE_PARSEDSPY." $sender ORDER BY dateRE DESC LIMIT $start,{$config['max']}";
	//result contient le retour de la commande mysql
	$result = $db->sql_query($req);
	//Création du tableau et des balises de titre
	echo '<div align=right><table borders=2>
		<tr>
			<th>Coordon&eacute;es</th>
			<th>Date</th>
			<th>Rapport</th>
		</tr>';
	//boucle d'affichage des RE ( dois effectuer X itération(s) ou X = $config['max'] )
	while ($data = $db->sql_fetch_assoc($result)) {
    	//on prépare la case dans le tableau ID dans le cas ou le compte aurais été supprimé
		if (!isset($id[$data['sender_id']])) $id[$data['sender_id']] = 'Inconnu';
		echo '<tr id="'.$data['id_spy'].'">
			<th><a href="./index.php?action='.$config['action'].'&p='.$p.'#'.$data['id_spy'].'"><font color='.$skin['coords'].'>'.$data['coordinates'].'</font></a></th>
			<th>'.date('d/m/y',$data['dateRE']).'<br/>'.date('H:i:s',$data['dateRE']).'<br/>Par '.$id[$data['sender_id']].'</th><th>';
			
		echo '<b><font color="'.$skin['titre'].'">Mati&egrave;res premi&egrave;res sur '.$data['planet_name'].' ['.$data['coordinates'].'] le '.date('d/m/Y à H:i:s', $data['dateRE']).'</font></b><br/>';
		echo 'M&eacute;tal : '.$data['metal'].' Cristal : '.$data['cristal'].'<br/>';
		echo 'Deut&eacute;rium : '.$data['deuterium'].' Energie : '.$data['energie'].'<br/><br/>';
		
		// On affiche l'activité récente
		if($data['activite'] > -1)
		    echo 'Le scanner des sondes a d&eacute;tect&eacute; des anomalies dans l\'atmosph&egrave;re de cette plan&egrave;te, indiquant qu\'il y a eu une activit&eacute; sur cette plan&egrave;te dans les ' . $data['activite'] . ' derni&egrave;res minutes.<br/>';
		else
		    echo 'Le scanner des sondes n\'a pas d&eacute;tect&eacute; d\'anomalies atmosph&eacute;riques sur cette plan&egrave;te. Une activit&eacute; sur cette plan&egrave;te dans la derni&egrave;re heure peut quasiment &ecirc;tre exclue.<br/>';
		
		if($data['PT'] > -1) {
    		echo "<br/><b><font color=\"{$skin['sections']}\">Flotte</font></b><br/>";
    		echo "<font color=\"{$skin['flotte']}\">";
	    	foreach ( $flotte as $key=>$value ) {
                if ( $data[$key] > 0 ) {
                    echo $flotte[$key].' : '.$data[$key].' ';
                    if($count % 2) {
                        echo '<br />';
                    }
                    $count++;
                }
            }
	    	
	    	echo "</font>";
	    	$count = 0;
	    }
		if($data['LM'] > -1) {
    		echo "<br/><b><font color=\"{$skin['sections']}\">D&eacute;fenses</font></b><br/>";
		    echo "<font color=\"{$skin['def']}\">";
	    	foreach ( $defs as $key=>$value ) {
                if ( $data[$key] > 0 ) {
                    echo $defs[$key].' : '.$data[$key].' ';
                    if($count % 2) {
                        echo '<br />';
                    }
                    $count++;
                }
            }
	    			    
    		echo "</font>";
	    	$count = 0;
    	}
		if($data['M'] > -1) {
    		echo "<br/><b><font color=\"{$skin['sections']}\">B&acirc;timents</font></b><br/>";
    		echo "<font color=\"{$skin['builds']}\">";
	    	foreach ( $bats as $key=>$value ) {
                if ( $data[$key] > 0 ) {
                    echo $bats[$key].' : '.$data[$key].' ';
                    if($count % 2) {
                        echo '<br />';
                    }
                    $count++;
                }
            }
	    	
	    	echo "</font>";
	    	$count = 0;
	    }
		if($data['Esp'] > -1) {
    		echo "<br/><b><font color=\"{$skin['sections']}\">Recherches</font></b><br/>";
    		echo "<font color=\"{$skin['recherche']}\">";
	    	foreach ( $techs as $key=>$value ) {
                if ( $data[$key] > 0 ) {
                    echo $techs[$key].' : '.$data[$key].' ';
                    if($count % 2) {
                        echo '<br />';
                    }
                    $count++;
                }
            }
	    	
	    	echo "</font>";
	    	$count = 0;
	    }
		echo "<br/><font color=\"{$skin['prob']}\">Probabilit&eacute; de destruction de la flotte d'espionnage :".$data['proba']."%</font><br/>";
				
		echo '</th></tr>';
	}
	
	} else { // Si ogspy 3.04 on utilise les RE bruts
	
	$stats = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM ".TABLE_SPY)); //nombre de RE
	while ($tmp = $db->sql_fetch_assoc($ids)) {
		//on remplis un tableau avec les noms d'utilisateurs et leurs id de forme $id[ID] = NOM
		$id[$tmp['user_id']] = $tmp['user_name'];
		echo '<tr>';
			$spys = mysql_fetch_array(mysql_query("SELECT COUNT(*) as nb FROM ".TABLE_SPY." WHERE sender_id = '".intval($tmp['user_id'])."'")); //nombre de RE
			if ($spys['nb'] > 0) {
				echo '<th><a href="./index.php?action='.$config['action'].'&sender='.$tmp['user_name'].'">'.$tmp['user_name'].'</a></th>
				<th>'.$spys['nb'].'</th>
				<th>'.round($spys['nb'] / $stats['total'] * 100,2).'%</th>';
			}
			elseif ($config['show_nevers']) echo '<th>'.$tmp['user_name'].'</th><th>0</th><th>0%</th>';
			echo '</tr>';
		//on remplis un tableau avec les noms d'utilisateurs et leurs id de forme $id[NOM = ID
		$idn[$tmp['user_name']] = $tmp['user_id'];
	}
	echo '<tr>
				<th><a href="./index.php?action='.$config['action'].'">Tous</a></th>
				<th>'.$stats['total'].'</th>
				<th>100%</th>
			</tr>
		</table>
	</div>';
	//sert a choisir de qui on veut voir les raports: si une persone en particulier est demandée
	if ((isset($_GET['sender'])) && (isset($idn[sql_filter($_GET['sender'])]))) {
		//prepararation de l'ajout dans la requete mysql
		$sender = "WHERE sender_id = '".$idn[sql_filter($_GET['sender'])]."'";
		$slink = '&sender='.sql_filter($_GET['sender']);
	}
	//sinon on met le tout a NULL pour ne pas declencher d'erreur comme un bouseux
	else {
		$sender = NULL;
		$slink = NULL;
	}
	//asigne a $stats['nb'] le nombre total de RE
	$stats = mysql_fetch_array(mysql_query("SELECT COUNT(*) as nb FROM ".TABLE_SPY." $sender")); //nombre de RE
	//declaration de la variable $p (page N°) a 1 par defaut
	$p = 1;
	//si p est definis en GET alors il est egal a sa valeure
	if (isset($_GET['p'])) $p = sql_filter($_GET['p']);
	//sinon on vérifie que P existe en post et on lui atribue sa valeur si c'est le cas
	elseif (isset($_POST['p'])) $p = sql_filter($_POST['p']);
	//Si $p n'est pas un nombre on le met = a 1 pour des raisons de securitée
	if (!is_numeric($p)) $p = 1;
	//calcul du nombre total de pages possibles a afficher (arondi au superieur)
	$tot = round($stats['nb'] / $config['max'],0);
	//si la page demandéé n'est pas dans la tranche de pages existantes alors on regle la page a 1
	if (($p > $tot) || ($p < 1)) $p = 1;
	//on stoque dans une variable la position du premier RE a afficher
	$start = $p * $config['max'] - $config['max'];
	echo '<div style="float:top;">';
	//si la page demandée est superieure a 1 alors on affiche un bouton "precedent" avec un lien
	if ($p > 1) echo '<a href="./index.php?action='.$config['action'].'&p='.($p - 1).$slink.'">Precedente </a>';
	//sinon juste le nom du bouton pour garder la mise en forme
	else echo 'Precedente ';
	//on affiche la page actuele et le nombre de pages totale pour que l'utilisateur sache a quelle page il se trouve
	echo "$p / $tot";
	//si la page demandée est inferieure au nombre de la derniere page possible alors on affiche un bouton suivant
	if ($p < $tot) echo '<a href="./index.php?action='.$config['action'].'&p='.($p + 1).$slink.'"> Suivante</a>';
	//sinon juste le nom du bouton pour garder la mise en forme
	else echo 'Suivante ';
	echo '</div>';
	//requete mysql à transmetre au serveur (elle est mise dans une variable pour fasciliter le debugage)
	$req = "SELECT * FROM ".TABLE_SPY." $sender ORDER BY datadate DESC LIMIT $start,{$config['max']}";
	//result contien le retour de la commande mysql
	$result = $db->sql_query($req);
	//Creation du tableau et des balises de titre
	echo '<div align=right><table borders=2>
		<tr>
			<th>Coordonées</th>
			<th>Date</th>
			<th>Raport</th>
		</tr>';
	//on configure les noms des sections
	$sections = explode(';',";Flotte;Recherche;Défense;Bâtiments");
	//boucle d'affichage des RE ( dois effectuer X iteration ou X = $config['max'] )
	while ($data = $db->sql_fetch_assoc($result)) {
		$coords = $data['spy_galaxy'].':'.$data['spy_system'].':'.$data['spy_row'];
		if (isset($verif[$coords])) {
			if ($data['datadate'] < $verif[$coords]) continue;
		}
		$verif[$coords] = $data['datadate'];
		//on decoupe le raport d'espionage brut a chaque saut de ligne et on met le tout dans un tableau (contenu dans $spy)
		$spy = explode("\n",$data['rawdata']);
		//on stoque le nombre total de lignes dans N
		$n = count($spy);
		//act contiendra par la suite le nom de la section courante pour le moment on la declare a NULL pour dire qu'on est encore dans aucune section
		$act = NULL;
		//on prepare la case dans le tableau ID dans le cas ou le compte aurais été supprimé
		if (!isset($id[$data['sender_id']])) $id[$data['sender_id']] = 'Inconnu';
		echo '<tr id="'.$data['spy_id'].'">
			<th><a href="./index.php?action='.$config['action'].'&p='.$p.'#'.$data['spy_id'].'"><font color='.$skin['coords'].'>'.$data['spy_galaxy'].':'.$data['spy_system'].':'.$data['spy_row'].'</font></a></th>
			<th>'.date('d/m/y',$data['datadate']).'<br/>'.date('H:i:s',$data['datadate']).'<br/>Par '.$id[$data['sender_id']].'</th><th>';
			
			//on affiche toutes les lignes via une boucle ou  I est la variable tournante (tant que celle ci est inferieure a N)
			for ($i = 0;$i < $n;$i++) {
				//tmp contien la valeure actuele de la ligne courante du tableau spy
				$tmp = str_replace(array(chr(13),chr(10),chr(160)),array('','',''),$spy[$i]);
				if (substr($tmp,-1) == chr(32)) $tmp = substr($tmp,0,-1);
				if (substr($tmp,-1) == chr(32)) $tmp = substr($tmp,0,-1);
				//si on trouve la ligne dans $sections alors on colore la ligne
				if ($i == 0) echo '<b><font color="'.$skin['titre'].'">'.$tmp.'</font></b>';
				elseif (array_search($tmp,$sections)) {
					//on donne a act la valeure de la section actuele (recherche, flotte...)
					$act = $tmp;
					echo "<br/><b><font color=\"{$skin['sections']}\">$tmp</font></b>";
				}
				//si on a atteind la derniere ligne du raport (le taux de prob de destruction des sondes) alors on colore en consequence
				elseif ($i == ($n -1)) echo "<font color=\"{$skin['prob']}\">$tmp</font>\n";
				//cas de la section recherche
				elseif ($act == 'Recherche') echo "<font color=\"{$skin['recherche']}\">$tmp</font>\n";
				//cas de la section Défense
				elseif ($act == 'Défense') echo "<font color=\"{$skin['def']}\">$tmp</font>\n";
				//Cas de la section Flotte
				elseif ($act == 'Flotte') echo "<font color=\"{$skin['flotte']}\">$tmp</font>\n";
				//Cas de la section Bâtiments
				elseif ($act == 'Bâtiments') echo "<font color=\"{$skin['builds']}\">$tmp</font>\n";
				//Cas échant (par defaut)
				else echo $tmp;
				//on saute une ligne a la fin pour que ca reste lisible :)
				echo '<br/>';
			}
			echo '<br/></th></tr>';
	}
	
	} // Fin choix selon la version d'ogspy
	
	//fermeture du tableau
	echo '</table></div>';
	//affichage du nombre total de RE disponible dans la bdd
	echo "Il y a actuellement {$stats['nb']} rapports d'espionnages enregistr&eacute;s.<br/>";
	
	require_once("views/page_tail.php");
?>

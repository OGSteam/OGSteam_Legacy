<?php
	/***************************************************************************
	*	fichier		: lite.php
	*	description.		: permet de faire des recherches rapides pour les boards et pages html
	*	Auteur		:  Chr0nos
	*	créé			: 10/08/2006
	*	modifié		: 05/09/2006
	*	version		: 1.2
	
	Changelog:
		0.5 : 	Conversion en mod pour OgsSpy 302b
		0.6 : 	Utilisation des noms de table via DEFINE de ogsspy
		0.7 :	Gestion de la coloration sous {
				BB code [code] (mise en forme
				BB code [quote] (coloration)
				Texte brute
				Html (coloration)
			}
			Possibilitée de rechercher a partir de coodoneés
		0.8 : 	Les alliances protegées ne sonts plus affichées car inclues par defaut dans $forbiden
			Les variables de config sonts maintenan toutes dans un tableau pour plus de claretée
			Gestion des modes spéciaux (inactif, vacances, bloqué...)
			Changement de la syntaxe des connexion au serveur mysql pour fasciliter le debugage
		0.9 :	Auto remplisage des champs de recherche en fonction de la derniere recherche effectuée
		1.0	Correction de failles de securitées importantes en utilisant les variables $pub pour le retour de formualaire et amélioration du filtre sql
		1.1	Correction d'un bug lors des recherches (faute de frappe lors de la mise a jours pour lutilisation de $pub_
		1.2	Correction d'une faille dans les limites pour les recherches ainsi que pour les recherches par coordonées
			Grand remaniment de l'apect graphique apres suggestion d'ericalens pour se rapprocher davantage du disign d'ogspy
			Correction de bugs mineurs divers et variés...
	***************************************************************************/

	//partie obligatoire (securitée)
	if (!defined('IN_SPYOGAME')) die("Hacking attempt"); //si l'utilisateur n'est pas logué alors on stope tout
	require_once("views/page_header.php"); //on inclus le logo de ogspy dans le mod (l'entete)
	
	//config generale (vous pouvez aussis remplacer les 0 par FALSE et les 1 par TRUE)
	$config['largeur'] = 120; //largeur du tableau
	$config['hauteur'] = 10; //hauteur du tableau en temp normal
	$config['hauteur_for_ally'] = 10; //hauteur du tableau en cas de recherche pour une alliance
	$config['max'] = 1000; //nombre max de resultats par page
	$config['protect'] = 1; //pour utiliser les interdiction des alliances/joueurs
	//print_r();
	//si le joueur acutel est un admin ou un co-admin alors on lui autorise toutes les recherches
	if (($user_data['user_admin'] == 1) || ($user_data['user_coadmin'] == 1)) $config['protect'] = 0;

	//Liste des recherches non permises
	$forbiden['Chr0nos'] = TRUE;
		
	$stats = mysql_fetch_array(mysql_query("SELECT COUNT(*) as nb FROM ".TABLE_UNIVERSE."")); //nombre de planetes

	//declaration des variables en false (sécuritée)
	$search = FALSE; $result = FALSE; $data = FALSE; $req = FALSE;
	
	//fonction de filtrage des caracteres 'senssibles' pour les requetes mysql
	function sql_filter($in) {
		return mysql_real_escape_string(str_replace(array(';','(',')',chr(39),'"','`','|'),'',$in));
	}
	//on met une recherche a 'player' par defaut pour ne pas se retrouver avec une variable vide
	$target = 'player';
	if (isset($pub_target)) $target = sql_filter($pub_target);
	if (isset($pub_search)) $search = str_replace('*','%',sql_filter($pub_search));
	if (isset($pub_galaxie)) $galaxie = sql_filter($pub_galaxie); //filtrage des paramatres d'entrée
	if (isset($pub_mode)) $mode = intval($pub_mode);
	if (isset($pub_inactif)) $inactif = sql_filter($pub_inactif);
	else $inactif = NULL;
	if (strlen($search)) echo '<div style="float:left;">';
	echo "\t<table>
			<form action='./index.php?action=litesearch' method='post'>
			<tr>
				<th>Action</th>
				<th>Valeur</th>
			</tr>
			<tr>
				<th>Recherche (type):</th>
				<th><input type='text' name='search' value='".str_replace('%','*',$search)."'/></th>
			</tr>
			<tr>
				<th>Cible</th>
				<th><select name='target'>";
					//dans le cas ou une recherche précédente a été faite on re selectione le fait que la recherche soi un joueur/une alliance/des coordonées/une planete
					if (isset($target)) {
						if ($target == 'ally') echo "<option value='ally'>Alliance</option>";
						elseif ($target == 'name') echo "<option value='name'>planete</option>";
						elseif ($target == 'coord') echo "<option value='coord'>Coordonées</option>";
					}
					echo "
						<option value='player'>Joueur</option>
						<option value='ally'>Alliance</option>
						<option value='name'>Planete</option>
						<option value='coord'>Coordonées</option>
					</select></th>
				</tr>
					<th>Lieux</th>
					<th><select name='galaxie'>";
						if ($galaxie && $galaxie != '%') echo "<option value='".$galaxie."'>G".$galaxie."</option>";
						echo "<option value='%'>Partout</option>
						<option value='1'>G1</option>
						<option value='2'>G2</option>
						<option value='3'>G3</option>
						<option value='4'>G4</option>
						<option value='5'>G5</option>
						<option value='6'>G6</option>
						<option value='7'>G7</option>
						<option value='8'>G8</option>
						<option value='9'>G9</option>
					</select>
					<tr>
						<th>Limites</th>
						<th><select name='limit'>";
						$npages = 0; //on debute la page actuele en partant de 0
						while ($npages < $stats['nb']) { //nombre de pages selon la taille de la bdd
							echo "<option value='$npages'>$npages à ".($npages + $config['max'])."</option>\n";
							$npages = $npages + $config['max']; //on ajoute le nombre max de pages au nombre de la page actuel
						}
						echo "</select></th>
					</tr>
					<tr>
						<th>Mode de sortie</th>
						<th><select name='mode'>";
					 //se rappeler de l'ancien mode de sortie demandé
					 if (isset($mode)) {
						 if ($mode == 0) echo "<option value='0'>Texte</option>";
						 elseif ($mode == 2) echo "<option value='2'>Html</option>";
						 elseif ($mode == 1) echo "<option value='0'>BBCode [code]</option>";
					 }
					 echo "<option value='3'>BBCode [Quote]</option>
						<option value='1'>BBCode [code]</option>
						<option value='0'>Texte</option>
						<option value='2'>Html</option>
					</select></th>
					</tr>
					<tr>
						<th>Uniquement les inactifs</th>
						<th><INPUT TYPE=checkbox NAME='inactif'>Activer</th>
					</tr>
				</table>
				<input type=submit name='go' title='Rechercher' value='Rechercher'/>
			</form>";
		if (strlen($search)) echo '</div>';
	
			if (!isset($_POST['search']))require_once('views/page_tail.php');
				
	if (!isset($_POST['search'])) return;
	//si la protection des alliances est activée (par defaut c'est le cas (voir debut du fichier pour la config))
	if ($config['protect']) {
		$bads = explode(",",$server_config['ally_protection']); //on separe la liste des alliances interdites sous forme de tableau
		$i = 0;
		while (isset($bads[$i])) { //tant que qqch est trouvé a la position $i du tableau "bads"
			$forbiden[$bads[$i]] = TRUE; //on créé la liste de ce qui est interdit
			$i++; //incrementation de $i (on lui ajoute 1 a lui meme)
		}
	}
	if (isset($forbiden[$search])) { //pour toute recherche interdute on stope l'execution du mod
		echo "Recherche non permise"; //on affiche le message d'erreur
		return; //on stope l'execution du mod
	}
	if ($inactif) $inactif = "AND `status` LIKE '%i%'";
	if ($target == 'coord') { //si la recherche est basé sur des coordonées
		$coords = explode(":",$search); //on decoupe la recherche a chaque :
		if (!count($coords)) { //si il n'y a pas au moin un parametre alors on stope le tout
			echo "Parametres de recherche invalides"; //message d'erreur
			return; //arret du code du mod
		}
		$Ands_galaxy = NULL; $Ands_system = NULL; $Ands_row = NULL;
		if (isset($coords[0])) $Ands_galaxy = "WHERE galaxy = '".intval($coords[0])."'";
		if (isset($coords[1])) $Ands_system = "AND `system` = '".intval($coords[1])."'";
		if (isset($coords[2])) $Ands_row = "AND `row` = '".intval($coords[2])."'";
		$req = "SELECT * FROM ".TABLE_UNIVERSE." $Ands_galaxy  $Ands_system $Ands_row ORDER BY player,galaxy,system,row LIMIT ".sql_filter($pub_limit).",{$config['max']}";
	}
	else $req = "SELECT * FROM ".TABLE_UNIVERSE." WHERE $target LIKE '$search' AND `galaxy` LIKE '$galaxie' $inactif ORDER BY player,galaxy,system,row LIMIT ".sql_filter($pub_limit).",{$config['max']}";
	//echo $req;
	$result = $db->sql_query($req);
	if (!strlen($result)) echo "<br/>Erreur mysql: C<br/>";
	else { //Si tout se passe bien au niveau de mysql alors
		if ($target == 'ally') $config['hauteur'] = $config['hauteur_for_ally']; //dans le cas ou on recherche une alliance le tableau prend une taille en consequences
		echo '<div style="fixed:right;">
		<table>
			<tr>
				<th>
		<textarea rows='.$config['hauteur'].' COLS='.$config['largeur'].' readonly>';
		$n = 0; //contien le nombre de planetes affiché
		$n_p = 0; //contien le nombre de joueurs affiché
		$cplayer = NULL;
		if ($mode == 1) echo "[code]";
		elseif ($mode == 3) echo '[quote]';
		//si on recherche une alliance alors on écris le nom de l'alliance en titre
		if ($target == 'ally') {
			if ($mode == 3) echo '[i][color=red][size=18]'.$search.'[/size][/color][/i]'."\n";
			elseif ($mode == 1) echo "$search \n";
			elseif ($mode == 2) echo "<font color='red'><h1>$search</h1></font><br/>";
		}
		if ($mode != 3) echo "\n";
		while ($data = $db->sql_fetch_assoc($result)) {
			//on vérifi que le joueur ne sois pas protegé contre les recherches et que son ally ne le soi pas non plus, pour finir on vérifie qu'il s'agise d'une planete existante et non une vide
			if (!isset($forbiden[$data['name']]) && !isset($forbiden[$data['ally']]) && strlen($data['name'])) {
			//la variable $player_spy sert a determiner si on posede un raport d'espionage sur le joueur courant
			$player_spy = $db->sql_fetch_assoc($db->sql_query("SELECT spy_galaxy,spy_system,spy_row,rawdata FROM ".TABLE_SPY." WHERE '{$data['galaxy']}' = spy_galaxy AND '{$data['system']}' = spy_system AND '{$data['row']}' = spy_row ORDER BY spy_galaxy,spy_system,spy_row LIMIT 0,1"));
				if (!$cplayer || $cplayer != $data['player']) {
					$cplayer = $data['player']; //equal au nom du joueur en traitement actuel dans la boucle
					$player_info = $db->sql_fetch_assoc($db->sql_query("SELECT * FROM ".TABLE_RANK_PLAYER_POINTS." WHERE '$cplayer' = player ORDER BY datadate DESC LIMIT 0,1"));
					if ($mode == 3) echo '[b][color=#00FF00]';
					elseif ($mode == 2) echo '<b><font color="#00FF00">';
					echo $data['player']; //affichage du nom du joueur
					//si il y a une information d'alliance dans les stats et que celle ci est plus recente que celle dans la base universe alors on utilisera la plus recente
					if (($player_info['ally']) && ($player_info['datadate'] > $data['last_update'])) $data['ally'] = $player_info['ally'];
					if (strlen($data['ally'])) echo " ({$data['ally']})";
					if (strlen($player_info['rank'])) echo " [".round($player_info['points'] / 1000,0)." kpts] ({$player_info['rank']}eme)";
					//si le joueur a un status spécial l'affiche
					if (strlen($data['status'])) echo ' - ['.$data['status'].']';
					if ($mode == 2) echo '</font></b><br/>';
					elseif ($mode == 3) echo '[/color][/b]';
					echo "\n"; //on saute une ligne dans la textarea
					$n_p++; //on ajoute un joueur suplémentaire au compteur
				}
				//Affichage des coordonées de chaque planete en fonction de leurs mode
				if (!$mode) echo "".chr(9)."{$data['galaxy']}:{$data['system']}:{$data['row']} - {$data['name']}";
				elseif ($mode == 1) echo "".chr(9)."{$data['galaxy']}:{$data['system']}:{$data['row']} - {$data['name']}";
				elseif ($mode == 2) echo "<i><font color=orange>{$data['galaxy']}:{$data['system']}:{$data['row']}</font></i> - <font color=blue>{$data['name']}</font>";
				elseif ($mode == 3) echo "[i][color=orange]{$data['galaxy']}:{$data['system']}:{$data['row']}[/color][/i] - [color=cyan]{$data['name']}[/color]";
				//modes spéciaux (lune, raport d'espionages....)
				if ($data['moon']) { //si une lune est trouvé dans la bdd elle est signalée via [lune]
					if ($mode == 3) echo ' - [color=red][lune][/color]';
					elseif ($mode == 2) echo ' - <font color="red">[lune]</font>';
					else echo ' - [lune]'; //en cas de mode non listé ci dessus il est affiché en mode brut
				}
				if (strlen($player_spy['rawdata'])) { // si un raport d'espionage est present dans la base de donnée
					if ($mode == 3) echo ' - [b][color=purple]+[/color][/b]';
					elseif ($mode == 2) echo ' - <b><font color="#FF00FF">+</font></b>';
					else echo ' - +'; //en cas de mode non listé ci dessus il est affiché en mode brut
				}
				if ($mode == 2) echo '<br/>'; //si le mode est html alors on affiche la balise <br/> pour sauter une ligne
				echo "\n"; //on saute une ligne dans la textarea
				$n++; //on ajoute un au nombre de planetes total
			}
		}
		//on affiche la balise [/code] si le mode d'afichage est bb code code
		if ($mode == 1) echo '[/code]';
		//on affiche la balise [/quote] si le mode d'afichage est bb code quote
		elseif ($mode == 3) echo '[/quote]';
		echo '</textarea>
					</th>
				</tr>
			</table>
		</div>
		<br/>
		<div style="float:left;">
		<table>
			<tr>
				<th>Info</th>
				<th>Valeure</th>
			</tr>';
		//si N est plus grand que 0 alors (N = nombre de resulats)
		echo "\n<tr><th>Planetes affichées</th><th>$n</th></tr>\n";
		if ($n == $config['max']) echo '<span color="red">Attention: il n\'y à pas tout, la limite est à '.$config['max'].' réponces par recherche.</span><br/>';
		echo "<tr><th>Joueurs trouvé(s)</th><th>$n_p</th></tr>\n"; //$N_P = Nombre de joueurs diferents trouvés
		if (($target == 'ally') && ($n) && ($n_p)) echo '<tr><th>Moyene de planete par joueurs</th><th>'.round($n / $n_p,2).'</th></tr>';
	}
	echo '<tr><th>Limite max</th><th>'.$config['max'].'</th><tr/>
		<tr><th>Faits</th><th>de '.$pub_limit.' à '.($pub_limit + $config['max']).'</th></tr>
	</table>
	</div>';
	
		require_once('views/page_tail.php');
?>

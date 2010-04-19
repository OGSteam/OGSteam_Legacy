<?php
/**
* attaques.php 
 * @package Attaques
 * @author Verité modifié par ericc
 * @link http://www.ogsteam.fr
 * @version : 0.8a
 */


// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='attaques' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");
// Appel des Javascripts
echo"<script type='text/javascript' language='javascript' src='".FOLDER_ATTCK."/attack.js'></script>";

//Définitions
global $db, $table_prefix, $prefixe;

//Gestion des dates
$date = date("j");
$mois = date("m");
$annee = date("Y");
$septjours = $date-7;
$yesterday = $date-1;

if($septjours < 1) $septjours = 1;
if($yesterday < 1) $yesterday = 1;

//Fonction d'ajout d'un rapport de combat
if (isset($pub_rapport))
{
	$pub_rapport = mysql_real_escape_string($pub_rapport);

  $pub_rapport = str_replace(".","",$pub_rapport);  
	//Compatibilité UNIX/Windows
	$pub_rapport = str_replace("\r\n","\n",$pub_rapport);
	//Compatibilité IE/Firefox
	$pub_rapport = str_replace("\t",' ',$pub_rapport);
	
	//On regarde si le rapport soumis est un RC
	if (!preg_match('#Les\sflottes\ssuivantes\sse\ssont\saffrontées\sle\s(\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2})#',$pub_rapport,$date))
	{
		$nonvalid = "Le texte inséré n'est pas un RC valide. Enregistrement de l'attaque non effectué !!!";
	} 
	else
	{
		preg_match('#(\d*)\sunités\sde\smétal,\s(\d*)\sunités\sde\scristal\set\s(\d*)\sunités\sde\sdeutérium#',$pub_rapport,$ressources);
    preg_match('#attaquant\sa\sperdu\sau\stotal\s(\d*)\sunités#',$pub_rapport,$pertesA);
    $pertes = $pertesA[1];

		$timestamp = mktime($date[3],$date[4],$date[5],$date[1],$date[2],date('Y'));
		
		//Puis les informations pour les coordonnées
		preg_match('#Défenseur\s.+\[(.+)]#',$pub_rapport,$pre_coord);
		$coord_attaque = $pre_coord[1];
		
    //On vérifie que vous êtes bien l'attaquant
		preg_match('#Attaquant\s.{3,70}\[(.{5,8})]#',$pub_rapport,$pre_coord);
		$coord_attaquant = $pre_coord[1];
		//On regarde dans les coordonnées de l'espace personnel du joueur qui insère les données via le plugin si les coordonnées de l'attaquant correspondent à une de ses planètes
    $query = "SELECT coordinates FROM ".TABLE_USER_BUILDING." WHERE user_id='$user_data[user_id]'";
    $result = $db->sql_query($query);
    $attaquant = 0;
    $defenseur = 0;
   	while(list($coordinates) = $db->sql_fetch_row($result))
	{
		if($coordinates == $coord_attaquant) $attaquant = 1;
		if($coordinates == $coord_attaque) $defenseur = 1;
	}
	if ($attaquant != 1 && $config[defenseur] != 1) {
  $nonvalid = "Vous n'êtes pas l'attanquant. Enregistrement de l'attaque non effectué !!!";
    } 
    else 
    {
    if ($defenseur == 1 && $config[defenseur] == 1)
      {
      // récupération des pertes défenseurs
      preg_match('#défenseur\sa\sperdu\sau\stotal\s(\d*)\sunités#',$rapport,$pertesD);
      $pertes = $pertesD[1];
      //les coordonnées de l'attaque deviennent celle de l'attaquant
      $coord_attaque = $coord_attaquant;
      //on soustrait les ressources volées
      $ressources[1] = -$ressources[1];
      $ressources[2] = -$ressources[2];
      $ressources[3] = -$ressources[3];
      }
      
		//On vérifie que cette attaque n'a pas déja été enregistrée
		$query = "SELECT attack_id FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id='$user_data[user_id]' AND attack_date='$timestamp' AND attack_coord='$coord_attaque' ";
		$result = $db->sql_query($query);
		$nb = mysql_num_rows($result);
		
		if ($nb == 0)
		{
			//On insere ces données dans la base de données
			$query = "INSERT INTO ".TABLE_ATTAQUES_ATTAQUES." ( `attack_id` , `attack_user_id` , `attack_coord` , `attack_date` , `attack_metal` , `attack_cristal` , `attack_deut` , `attack_pertes` )
				VALUES (
					NULL , '$user_data[user_id]', '$coord_attaque', '$timestamp', '$ressources[1]', '$ressources[2]', '$ressources[3]', '$pertes')";
			$db->sql_query($query);
			
			//On met le message de validation
			$valid="Enregistrement de l'attaque effectué.";
			
			//On ajoute l'action dans le log
			$line = $user_data['user_name']." ajoute une attaque dans le module de gestion des attaques";
			$fichier = "log_".date("ymd").'.log';
			$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
			write_file(PATH_LOG_TODAY.$fichier, "a", $line);
		}
		else
		{
			//On met le message de non validation
			$nonvalid="Vous avez déja enregistrée cette attaques.";
		}
	 }
  }
}

//On verifie si il y a des attaques qui ne sont pas du mois actuel
$query = "SELECT MONTH(FROM_UNIXTIME(attack_date)) AS month, YEAR(FROM_UNIXTIME(attack_date)) AS year, SUM(attack_metal) AS metal, SUM(attack_cristal) AS cristal, SUM(attack_deut) AS deut, SUM(attack_pertes) as pertes FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data['user_id']." AND MONTH(FROM_UNIXTIME(attack_date)) <> $mois GROUP BY month"; 
$result = $db->sql_query($query);

$nb_result = mysql_num_rows($result);

//Si le nombre d'attaques n'appartenant pas au mois actuel est different de 0, on entre alors dans la partie sauvegarde des résultats anterieurs
if ($nb_result != 0)
{
	echo "<font color='#FF0000'>Vos attaques du ou des mois précédent(s) ont été supprimé(s). Seuls les gains restent accessibles dans la partie Espace Archives<br>La liste de vos attaques qui viennent d'être supprimées est consultable une dernière fois. Pensez à la sauvegarder !!!</font>";
// On récupère les paramètres bbcolors
$query2 = "SELECT value FROM `".TABLE_MOD_CFG."` WHERE `mod`='Attaques' and `config`='bbcodes'";
$result2 = $db->sql_query($query2);
$bbcolor = $db->sql_fetch_row($result2);
$bbcolor=unserialize($bbcolor[0]);

	while (list($month, $year, $metal, $cristal, $deut, $pertes) = $db->sql_fetch_row($result))
	{
		//On recupère la liste complète des attaques de la période afin de pouvoir les compter
		$query = "SELECT attack_coord, attack_date, attack_metal, attack_cristal, attack_deut, attack_pertes FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data["user_id"]." AND MONTH(FROM_UNIXTIME(attack_date))=".$month." AND YEAR(FROM_UNIXTIME(attack_date))=".$year."";
		$list = $db->sql_query($query);
		
		$nb_ancattack = mysql_num_rows($list);
		
		//On recupere les gains des recyclages
		$query = "SELECT SUM(recy_metal) as metal_recy, SUM(recy_cristal) as cristal_recy FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id=".$user_data["user_id"]." AND MONTH(FROM_UNIXTIME(recy_date))=".$month." AND YEAR(FROM_UNIXTIME(recy_date))=".$year." GROUP BY recy_user_id"; 
		$resultrecy = $db->sql_query($query);
		
		//On definit le timestamp
		$timestamp = mktime(0, 0, 0, $month, 01, $year);
		
		list($metal_recy, $cristal_recy) = $db->sql_fetch_row($resultrecy);
		
		//On sauvegarde les résultats
		$query = "INSERT INTO ".TABLE_ATTAQUES_ARCHIVES." ( `archives_id` , `archives_user_id` , `archives_nb_attaques` , `archives_date` , `archives_metal` , `archives_cristal` , `archives_deut` , `archives_pertes`, `archives_recy_metal`, `archives_recy_cristal` )
				VALUES (
					NULL , '$user_data[user_id]', '$nb_ancattack', '$timestamp', '$metal', '$cristal', '$deut' , '$pertes', '$metal_recy', '$cristal_recy'
				)";
			$db->sql_query($query);
		
		//On supprime les attaques qui viennent d'être sauvegardées
		$query = "DELETE FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id='$user_data[user_id]' AND MONTH(FROM_UNIXTIME(attack_date))=".$month." AND YEAR(FROM_UNIXTIME(attack_date))=".$year."";
		$db->sql_query($query);
		
		//On supprime les recyclages qui viennent d'être sauvegardés
		$query = "DELETE FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id='$user_data[user_id]' AND MONTH(FROM_UNIXTIME(recy_date))=".$month." AND YEAR(FROM_UNIXTIME(recy_date))=".$year."";
		$db->sql_query($query);
		
		//On prépare la liste des attaques en BBCode
		$bbcode = "[color=".$bbcolor[title]."][b]Liste des attaques de ".$user_data[user_name]."[/b] [/color]\n";
		$bbcode .="du 01/".$month."/".$year." au 31/".$month."/".$year."\n\n";
		
		while (list($attack_coord, $attack_date, $attack_metal, $attack_cristal, $attack_deut, $attack_pertes) = $db->sql_fetch_row($list))
		{
			$attack_date = strftime("%d %b %Y %Hh%M", $attack_date);
			$bbcode .="Le ".$attack_date." victoire en ".$attack_coord.".\n";
			$bbcode .="[color=".$bbcolor[m_g]."]".$attack_metal."[/color] de métal, [color=".$bbcolor[c_g]."]".$attack_cristal."[/color] de cristal et [color=".$bbcolor[d_g]."]".$attack_deut."[/color] de deut&eacute;rium ont &eacute;t&eacute; rapport&eacute;s.\n";
			$bbcode .="Les pertes s'&eacute;lèvent à [color=".$bbcolor[perte]."]".$attack_pertes."[/color].\n\n";
		}
		
		$bbcode .="[url=http://www.ogsteam.fr/forums/sujet-1358-mod-gestion-attaques]G&eacute;n&eacute;r&eacute; par le module de gestion des attaques[/url]";
		
		echo"<br><br>";
		echo"<fieldset><legend><b><font color='#0080FF'>Liste de vos attaques du 01/".$month."/".$year." au 31/".$month."/".$year."</font></legend>";
		echo"<br>";
		echo"<form method='post'><textarea rows='10' cols='15' id='$bbcode'>$bbcode</textarea></form></fieldset>";
	}
	
  require_once("footer.php");
	
	//Insertion du bas de page d'OGSpy
	require_once("views/page_tail.php");
	
	//On ajoute l'action dans le log
	$line = "La listes des attaques de ".$user_data[user_name]." a &eacute;t&eacute; supprimée. Les gains ont été archivés dans le module de gestion des attaques";
	$fichier = "log_".date("ymd").'.log';
	$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
	write_file(PATH_LOG_TODAY.$fichier, "a", $line);	
	
	exit;
}

//Fonction de suppression d'un rapport d'attaque
if (isset($pub_attack_id))
{
	$pub_attack_id = intval($pub_attack_id);

	//On récupère l'id de l'utilisateur qui a enregistré cette attaque
	$query = "SELECT attack_user_id FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_id='$pub_attack_id'";
	$result = $db->sql_query($query);
	list($user) = $db->sql_fetch_row($result);
	
	if($user == $user_data['user_id'])
	{
		$query = "DELETE FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_id='$pub_attack_id'";
		$db->sql_query($query);
		echo"<blink><font color='FF0000'>L'attaque a bien été supprimée.</font></blink>";
		
		//On ajoute l'action dans le log
		$line = $user_data['user_name']." supprime l'une de ses attaque dans le module de gestion des attaques";
		$fichier = "log_".date("ymd").'.log';
		$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
		write_file(PATH_LOG_TODAY.$fichier, "a", $line);
	}
	else
	{
		echo"<blink><font color='FF0000'>Vous n'avez pas le droit d'effacer cette attaque !!!</font></blink>";
		
		//On ajoute l'action dans le log
		$line = $user_data[user_name]." a tenté de supprimer une attaque qui appartient à un autre utilisateurs dans le module de gestion des attaques";
		$fichier = "log_".date("ymd").'.log';
		$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
		write_file(PATH_LOG_TODAY.$fichier, "a", $line);
	}
}

//Si les dates d'affichage ne sont pas définies, on affiche par défaut les attaques du jour,
if(!isset($pub_date_from)) $pub_date_from = mktime(0, 0, 0, $mois, $date, $annee);
else $pub_date_from = mktime(0, 0, 0, $mois, $pub_date_from, $annee);

if(!isset($pub_date_to)) $pub_date_to = mktime(23, 59, 59, $mois, $date, $annee);
else $pub_date_to = mktime(23, 59, 59, $mois, $pub_date_to, $annee);

$pub_date_from = intval($pub_date_from);
$pub_date_to = intval($pub_date_to);

//Si le choix de l'ordre n'est pas définis on met celui par defaut
if(!isset($pub_order_by)) $pub_order_by ="attack_date";
else $pub_order_by = mysql_real_escape_string($pub_order_by);

if(!isset($pub_sens)) $pub_sens = "DESC";
elseif($pub_sens == 2) $pub_sens = "DESC";
elseif($pub_sens == 1) $pub_sens = "ASC";

//Requete pour afficher la liste des attaques 
$query = "SELECT attack_coord, attack_date, attack_metal, attack_cristal, attack_deut, attack_pertes, attack_id FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data["user_id"]." AND attack_date BETWEEN ".$pub_date_from." and ".$pub_date_to."  ORDER BY ".$pub_order_by." ".$pub_sens."";
$result = $db->sql_query($query);

//On recupère le nombre d'attaques
$nb_attack = mysql_num_rows($result);

//Cacul pour obtenir les gains
$query = "SELECT SUM(attack_metal), SUM(attack_cristal), SUM(attack_deut), SUM(attack_pertes) FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data["user_id"]." AND attack_date BETWEEN ".$pub_date_from." and ".$pub_date_to." GROUP BY attack_user_id"; 
$resultgains = $db->sql_query($query);

//On récupère la date au bon format
$pub_date_from = strftime("%d %b %Y", $pub_date_from);
$pub_date_to = strftime("%d %b %Y", $pub_date_to);

//Création du field pour Ajouter une nouvelles attaque
echo"<fieldset><legend><b><font color='#0080FF'>Ajouter une nouvelle attaque ";
echo help("ajouter_attaque");
echo"</font></b></legend>
	<table width='60%' align='center'>
	<tr>
	<td align='center'><font color='FFFFFF'><big><big>Pour ajouter une nouvelle attaque, copiez un rapport de combat, puis collez le ci-dessous :
	</big></big></font></td>
	</tr>
	<tr>
	<td><p><form action='index.php?action=attaques&page=attaques' method='post'><input type='hidden' name='date_from' value='$pub_date_from'><input type='hidden' name='date_to' value='$pub_date_to'><textarea rows='6' name='rapport' cols='25'></textarea></p></td>
	</tr>
	<tr>
	<td align='center'><p><input type='submit' value='Ajouter'></form></td>
	</tr>";

//Insertion du message de validation si défini
if (isset($valid))
{
	echo"<tr><td align='center'><blink><font color='00FF40'>";
	echo $valid;
	echo"</font></blink>";
	echo"</td></tr>";
}
//Insertion du message de non validation si défini
if (isset($nonvalid))
{
	echo"<tr><td align='center'><blink><font color='FF0000'>".$nonvalid."</td></tr>";
	echo"</font></blink>";
}
echo"</table></fieldset><br><br>";

//Création du field pour choisir l'affichage (attaque du jour, de la semaine ou du mois
echo"<fieldset><legend><b><font color='#0080FF'>Date d'affichage des attaques ";
echo help("changer_affichage");
echo"</font></b></legend>";

echo"Afficher mes attaques : ";
echo"<form action='index.php?action=attaques&page=attaques' method='post' name='date'>";
echo"du : <input type='text' name='date_from' id='date_from' size='2' maxlength='2' value='$pub_date_from' /> ";
echo"au : ";
echo"<input type='text' name='date_to' id='date_to' size='2' maxlength='2' value='$pub_date_to' />";
echo"<br>";
?>		
<a href="#haut" onclick="javascript: setDateFrom('<?php echo $date; ?>'); setDateTo('<?php echo $date; ?>'); valid();">du jour</a> |
<a href="#haut" onclick="javascript: setDateFrom('<?php echo $yesterday; ?>'); setDateTo('<?php echo $yesterday; ?>'); valid();">de la veille</a> | 
<a href="#haut" onclick="javascript: setDateFrom('<?php echo $septjours ; ?>'); setDateTo('<?php echo $date; ?>'); valid();">des 7 derniers jours</a> |
<a href="#haut" onclick="javascript: setDateFrom('01'); setDateTo('<?php echo $date; ?>'); valid();">du mois</a>
<?php
echo"<br><br>";
echo"<input type='submit' value='Afficher' name='B1'></form>";
echo"</fieldset>";
echo"<br><br>";

//Création du field pour voir les gains des attaques
echo"<fieldset><legend><b><font color='#0080FF'>Résultats des attaques du ".$pub_date_from." au ".$pub_date_to." ";
echo help("resultats");
echo"</font></b></legend>";

//Résultat requete
list($attack_metal, $attack_cristal, $attack_deut, $attack_pertes) = $db->sql_fetch_row($resultgains);	


//Calcul des gains totaux
$totalgains=$attack_metal+$attack_cristal+$attack_deut;

//Calcul de la rentabilité
$renta = $totalgains-$attack_pertes;

echo"<table width='100%'><tr align='left'>";

// Afficher l'image du graphique
echo"<td width='410px' align='center'>";

if ((!isset($attack_metal)) && (!isset($attack_cristal)) && (!isset($attack_deut)) && (!isset($attack_pertes)))
   {
   echo "Pas de graphique disponible";
   }else{
   echo "<img src='index.php?action=graphic_pie&values=".$attack_metal."_x_".$attack_cristal."_x_".$attack_deut."&legend=Metal_x_Cristal_x_Deutérium&title=Proportion%20des%20gains%20des%20attaques%20affichées' alt='Pas de graphique disponible'>";
   }
echo"</td>";

//Affichage des gains en métal, en cristal et en deut
$attack_metal = number_format($attack_metal, 0, ',', ' ');
$attack_cristal = number_format($attack_cristal, 0, ',', ' ');
$attack_deut = number_format($attack_deut, 0, ',', ' ');
echo "<td><p align='left'><font color='#FFFFFF'><big><big><big>Métal gagné : ".$attack_metal."<br>Cristal gagné : ".$attack_cristal."<br>Deut&eacute;rium gagné : ".$attack_deut."<br>";

//Affichage du total des gains
$totalgains = number_format($totalgains, 0, ',', ' ');
echo "<b>Soit un total de : ".$totalgains."</b><br><br>";

//Affichage du total des pertes
$attack_pertes = number_format($attack_pertes, 0, ',', ' ');
echo"<b>Total des pertes attaquant : ".$attack_pertes."</b>";

//Affichage de la rentabilité des attaques
$renta = number_format($renta, 0, ',', ' ');

echo"<br><br><b>Rentabilité : ".$renta."</b>";
echo"</big></big>";
echo"</big></big></font></td></tr></table>";
echo"</p></fieldset><br><br>";

//Création du field pour voir la liste des attaques
echo"<fieldset><legend><b><font color='#0080FF'>Liste des attaques du ".$pub_date_from." au ".$pub_date_to." ";
echo" : ".$nb_attack." attaque(s) ";
echo help("liste_attaques");
echo"</font></b></legend>";

//Debut du lien pour le changement de l'ordre d'affichage
$link ="index.php?action=attaques&date_from=".$pub_date_from."&date_to=".$pub_date_to."";

//Tableau donnant la liste des attaques
echo"<table width='100%'>";
echo"<tr>";
echo"<td class=".'c'." align=".'center'."><a href='".$link."&order_by=attack_coord&sens=1'><img src='".$prefixe."images/asc.png'></a> <b>Coordonnées</b> <a href='".$link."&order_by=attack_coord&sens=2'><img src='".$prefixe."images/desc.png'></a></td>";
echo"<td class=".'c'." align=".'center'."><a href='".$link."&order_by=attack_date&sens=1'><img src='".$prefixe."images/asc.png'></a> <b>Date de l'Attaque</b> <a href='".$link."&order_by=attack_date&sens=2'><img src='".$prefixe."images/desc.png'></a></td>";
echo"<td class=".'c'." align=".'center'."><a href='".$link."&order_by=attack_metal&sens=1'><img src='".$prefixe."images/asc.png'></a> <b>Métal Gagné</b> <a href='".$link."&order_by=attack_metal&sens=2'><img src='".$prefixe."images/desc.png'></a></td>";
echo"<td class=".'c'." align=".'center'."><a href='".$link."&order_by=attack_cristal&sens=1'><img src='".$prefixe."images/asc.png'></a> <b>Cristal Gagné</b> <a href='".$link."&order_by=attack_cristal&sens=2'><img src='".$prefixe."images/desc.png'></a></td>";
echo"<td class=".'c'." align=".'center'."><a href='".$link."&order_by=attack_deut&sens=1'><img src='".$prefixe."images/asc.png'></a> <b>Deut&eacute;rium Gagné</b> <a href='".$link."&order_by=attack_deut&sens=2'><img src='".$prefixe."images/desc.png'></a></td>";
echo"<td class=".'c'." align=".'center'."><a href='".$link."&order_by=attack_pertes&sens=1'><img src='".$prefixe."images/asc.png'></a> <b>Pertes Attaquant</b> <a href='".$link."&order_by=attack_pertes&sens=2'><img src='".$prefixe."images/desc.png'></a></td>";
echo"<td class=".'c'." align=".'center'."><b><font color='#FF0000'>Supprimer</font></b></td>";

echo"</tr>";
echo"<tr>";

while( list($attack_coord, $attack_date, $attack_metal, $attack_cristal, $attack_deut, $attack_pertes, $attack_id) = $db->sql_fetch_row($result) )
{
	$attack_date = strftime("%d %b %Y %Hh%M", $attack_date);
	$attack_metal = number_format($attack_metal, 0, ',', ' ');
	$attack_cristal = number_format($attack_cristal, 0, ',', ' ');
	$attack_deut = number_format($attack_deut, 0, ',', ' ');
	$attack_pertes = number_format($attack_pertes, 0, ',', ' ');
	$coord = explode(":", $attack_coord);
    echo"<th align='center'><a href='index.php?action=galaxy&galaxy=".$coord[0]."&system=".$coord[1]."'>".$attack_coord."</th>";
	echo"<th align='center'>".$attack_date."</th>";
	echo"<th align='center'>".$attack_metal."</th>";
	echo"<th align='center'>".$attack_cristal."</th>";
	echo"<th align='center'>".$attack_deut."</th>";
	echo"<th align='center'>".$attack_pertes."</th>";
	echo"<th align='center' valign='middle'><form action='index.php?action=attaques&page=attaques' method='post'><input type='hidden' name='date_from' value='$pub_date_from'><input type='hidden' name='date_to' value='$pub_date_to'><input type='hidden' name='attack_id' value='$attack_id'><input type='submit'	value='Supprimer' name='B1' style='color: #FF0000'></form></th>";
	echo"</tr>";
	echo"<tr>";
}
echo"</tr>";
echo"</table>";
echo"</fieldset>";

if ($config['histo']==1)
{
echo"<fieldset><legend><b><font color='#0080FF'>Historique mensuel</font></b></legend>";
echo "<img src='index.php?action=attaques&subaction=attaques' alt='pas de graphique disponible' />";
echo"</fieldset>";
}
echo"<br>";
echo"<br>";

?>

<?
/**
 * mpc_functions.php 

Fonctions

 * @package MP_Logger
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 0.1
 * dernière modification : 16.10.07
 * Module de capture des messages entre joueurs
 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

include("mpl_includes.php");
// ---------------------------------------------------------------------------------------
// Renvoi les message d'un joueur $userID
function get_messages_by_user($userID){
	global $db;       // Requete de capture de tous les messages de userID
	$query = "SELECT `id`,`datadate`,`titre`,`contenu`,`expediteur` FROM `".TABLE_MPC."` WHERE `sender_id`=".$userID." ORDER by datadate DESC";
	$result=$db->sql_query($query);
	if($result=$db->sql_numrows($result)==0) $retour=0; // Si aucun resultat, on renvoi un beau 0
	else{
		$retour=1;
		$i=0;
		while(list($id,$datadate,$titre,$contenu,$expediteur)=$db->sql_fetch_row($result)){ // Remplissage du tableau de sorti
			$liste[$i]['id'] = $id;
			$liste[$i]['datadate'] = $datadate;
			$liste[$i]['titre'] = $titre;
			$liste[$i]['contenu'] = $contenu;
			$liste[$i]['expediteur'] = $expediteur;
			$i++;
		}
	}
	if($retour!=0) $retour=$liste;	// Si il y a des resultats, on les retourne
	return $retour;
}// ---------------------------------------------------------------------------------------
// Création du menu
function do_menu($pub_page,$pub_action){
	global $user_data,$t_menu;
	if(!isset($pub_page)||!file_exists("mod/$pub_action/$pub_page.php")) $pub_page=$t_menu['fichier'][0];		// Si pas de menu ou page inconnu, on affiche la 1ere
	if($user_data["user_admin"]==1||$user_data["user_coadmin"]==1||$user_data["management_user"]==1)
		$got_power=true; else $got_power=false;																// Si l'utilisateur est admin ou gestionnaire
	echo '	<table><tr align="center">';									
	for($i=0;$i<count($t_menu['fichier']);$i++){
		if ( ($t_menu['admin'][$i] &&$got_power)||(!$t_menu['admin'][$i]) ){		// Si il a le droit de voir le menu
			if ($pub_page != $t_menu['fichier'][$i]){		// Si ce n'est pas la page en cours
					echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=$pub_action&page=".$t_menu['fichier'][$i]."';\">";
					echo "<a style='cursor:pointer'><font color='lime'>".$t_menu['texte'][$i]."</font></a>";
					echo "</td>";
				} else {		// Sinon, si c'est la page : pas de lien
					echo "\t\t\t"."<th width='150'>";
					echo "<a>".$t_menu['texte'][$i]."</a>";
					echo "</th>";
				}
		}
	} 
	echo "\t\t</tr>\n\t\t</table><br/><hr width='33%' /><br/>";
	return $pub_page;  //On renvoi la page qui peut avoir ete modifie
}// ---------------------------------------------------------------------------------------
// Ajout des balises HTML sur le $texte
function get_txtHtml($texte,$isname=false){
	$test = preg_match_all('`(.*) \[\d+\:\d+\:\d+\]`',$texte,$pseudo);
	if((strlen($pseudo[1][0])>=1)&&$isname==true)						// si c'est la chaine de l'expediteur, on devine le pseudo
		foreach($pseudo[1] as $name){										// On leur donne un lien
			$texte = str_replace($name,"<a href='index.php?action=search&type_search=player&string_search=$name&strict=on'>$name</a>",$texte);	
		}
	$test = preg_match_all('`\[(\d+\:\d+\:\d+)\]`',$texte,$position);
	if(strlen($position[1][0])>=1)											// si on a bien trouve une ou plusieurs positions
		foreach($position[1] as $pos){										// On leur donne un lien
			$coord=get_coord($pos);
			$link=" href='index.php?action=galaxy&galaxy=".$coord[0]."&system=".$coord[1]."'";
			if($isname==true){
				$userinfo=get_user_id($coord[0].":".$coord[1].":".$coord[2]);
				$bonus="[<a href='index.php?action=search&type_search=ally&string_search=".$userinfo[1]."&strict=on'>".$userinfo[1]."</a>] ";
			}else $bonus="";
			$pos="[$pos]";
			$texte = str_replace($pos,"$bonus<a$link>$pos</a>",$texte);	
		}
	$test = preg_match_all('`[aA]lliance \[(.*)\]`',$texte,$alliance);
	if(strlen($alliance[1][0])>=1)											// si on trouve "Alliance [blabla]"
		foreach($alliance[1] as $ally)										// On leur donne un lien
			$texte = str_replace($ally,"<a href='index.php?action=search&type_search=ally&string_search=$ally&strict=on'>$ally</a>",$texte);	
	$test = preg_match_all('`Le joueur (.*) vous envoie ce message:`',$texte,$pseudo);
	if(strlen($pseudo[1][0])>=1)											// si on trouve "Le joueur blabla vous envoie"
		foreach($pseudo[1] as $name)										// On leur donne un lien
			$texte = str_replace($name,"<a href='index.php?action=search&type_search=player&string_search=$name&strict=on'>$name</a>",$texte);	
	$texte = ereg_replace("[a-zA-Z]+://([.]?[a-zA-Z0-9_/-\?\#=])*", "<a href=\"\\0\" target=\"_blank\">\\0</a>", $texte);	// Lien web
	return $texte;
}// ---------------------------------------------------------------------------------------
// Renvoi la date $datadate sous forme HTML
function get_dateHtml($datadate){
	$now = time();
	$tps_ecoule = $now-$datadate;
	$jours = date('z',$now)-date('z',$datadate);
	if($jours==0)
		$day = "	Aujourd'hui";
	else if($jours==1)
		$day = "	Hier";
	else if($jours<4){
		$day = date("D",$datadate);
		switch($day){
			case"Mon": $day="Lundi"; break;
			case"Tue": $day="Mardi"; break;
			case"Wed": $day="Mercredi"; break;
			case"Thu": $day="Jeudi"; break;
			case"Fri": $day="Vendredi"; break;
			case"Sat": $day="Samedi"; break;
			case"Sun": $day="Dimanche"; break;
		}
	}else
		$day = "le ".date("d M y",$datadate);
	$retour="$day à ".date("H:i:s", $datadate);
	return $retour;
}// ---------------------------------------------------------------------------------------
// recupére le nom du joueur et l'alliance d'une certaine position
function get_user_id($position){	
	global $db;	
	$coord=get_coord($position);
	$player = "?";	
	$ally = "";	
	if($coord[0]&&$coord[1]&&$coord[2]){
		$query_limit = "SELECT  `player` , `ally`  FROM `".TABLE_UNIVERSE."` WHERE `galaxy` = ".$coord[0]." and `system` = ".$coord[1]." and `row` = ".$coord[2];		
		$result=$db->sql_query($query_limit);		
		list($player,$ally)=$db->sql_fetch_row($result);	
	}	
	return array($player,$ally);
}// ---------------------------------------------------------------------------------------
// Renvoi le rang de la planète par rapport à une position formatée GG:SS:RR
function get_coord($position){	
	$dPoint = strpos($position,":");	
	$galaxy = substr ($position,0,$dPoint);
	$tmp = substr ($position,$dPoint+1);	
	$dPoint2 = strpos($tmp,":");	
	$system = substr($tmp,0,$dPoint2); 	
	$row = substr ($tmp,$dPoint2+1);	
	return array($galaxy,$system,$row); 
}
 ?>
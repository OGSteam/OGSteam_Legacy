<?php
/***************************************************************************
*	fichier		: index.php
*	description.		: frames ^^
*	Auteur		:  Naruto kun
*	créé			: 09/072007
*	modifié		: 09/07/2007
*	version		: 0.1

Changelog:
	0.1 Permet d'accéder aux frames
	0.3 Modif d'affichage et début d'internatinnalisation
		
***************************************************************************/

//partie obligatoire (securitée)
if (!defined('IN_SPYOGAME')) die("Hacking attempt"); //si l'utilisateur ne passe pas par la page index.php
if (isset($pub_full)) require_once("views/page_header_2.php"); //on inclus le logo de ogspy dans le mod (l'entete)
else require_once("views/page_header.php");

//on inclut les langues
include "lang/lang_FR/index.php";

//configuration du script
$config['action'] = 'ModFrame&subaction=1';//laissez par defaut si vous ne savez pas de quoi il s'agis: c'est ce que index.php?action=X vaut (par defaut: Forum)
// Version du Mod
$mod_version = 0;
$query = "SELECT version FROM ".TABLE_MOD." WHERE `action`='ModFrame'";
$result = $db->sql_query($query);
list($mod_version) = $db->sql_fetch_row($result);

define("TABLE_FRAME", $table_prefix."mod_frames");

$frames = array();
$retour = $db->sql_query('SELECT * FROM '.TABLE_FRAME.' ORDER BY frame_id');
while ($donnees = $db->sql_fetch_assoc($retour)) // On fait une boucle pour lister les news
	$frames[] = $donnees;

//fin des préparations
echo "<center><input type='submit' value='".$lang["frame_full"]."' onclick=\"window.location='index.php?action=ModFrame".(isset($pub_full)?'':'&full=on').(isset($pub_subaction)?'&subaction='.$pub_subaction:'')."'\"></center>";
echo "<table align='center'>";
echo "<tr>";

//default
if(!isset($pub_subaction)){
		$donnes = $db->sql_fetch_assoc($db->sql_query("SELECT * FROM ".TABLE_FRAME." WHERE frame_id = '1'"));
		$url = $donnes['url'];
		$hauteur = $donnes['hauteur'];
		$id = $donnes['frame_id'];
		$pub_subaction = $donnes['id'];
} 
//switch
elseif ($pub_subaction != "admin"){
		$donnes = $db->sql_fetch_assoc($db->sql_query("SELECT * FROM ".TABLE_FRAME." WHERE id = '".$pub_subaction."'"));
		$url = $donnes['url'];
		$hauteur = $donnes['hauteur'];
		$id = $donnes['frame_id'];
}

foreach ($frames as $donnees){
//boucle
	
	if (!isset($pub_subaction) || $pub_subaction != $donnees['id']) {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=ModFrame".(isset($pub_full)?'&full=on':'')."&subaction=".$donnees['id']."';\">";
		echo "<a style='cursor:pointer'><font color='lime'>".$donnees['name']."</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<font color='lime'>".$donnees['name']."</font>";
		echo "</th>"."\n";
	}
//fin de la boucle	
}
//Affichage de la case: administration:
if($user_data["user_admin"]==1 || $user_data["user_coadmin"]==1) {
	
	if ($pub_subaction != "admin") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=ModFrame".(isset($pub_full)?'&full=on':'')."&subaction=admin';\">";
		echo "<a style='cursor:pointer'><font color='lime'>".$lang["frame_ongl_admin"]."</font></a>";
		echo "</td>"."\n";
	} else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>".$lang["frame_ongl_admin"]."</a>";
		echo "</th>"."\n";
	}

if($pub_subaction == "admin") {

//cerification de post
if (isset($pub_name) && isset($pub_url) && isset($pub_id) && isset($pub_hauteur) && is_numeric($pub_id) && is_numeric($pub_hauteur)){
	$name = mysql_real_escape_string($pub_name);
    $lien = mysql_real_escape_string($pub_url);
	$hauteur = $pub_hauteur;
	
	
	// On vérifie si c'est une modification  ou pas
    if ($pub_id == 0)
    {
        // Ce n'est pas une modification, on crée une nouvelle entrée dans la table
        $db->sql_query("INSERT INTO ".TABLE_FRAME." VALUES('', '" . $name . "', '" . $lien . "', '0', '" . $hauteur . "')");
		$requette = $db->sql_fetch_assoc($db->sql_query("SELECT max(frame_id) FROM ".TABLE_FRAME));
		$frame_id = $requette['max(frame_id)'];
		$db->sql_query("UPDATE ".TABLE_FRAME." set frame_id = ".($frame_id+1)." where url = '".$lien."'");
		redirection('index.php?action=ModFrame&subaction=admin');
    }
    else
    {
        // C'est une modification
		$db->sql_query("UPDATE ".TABLE_FRAME." SET  name='" . $name . "', url='" . $lien . "', hauteur='" . $hauteur . "' WHERE id=" . $pub_id);
		redirection('index.php?action=ModFrame&subaction=admin');
	}
}

//si on demande de monter un lien
if (isset($pub_up_lien)){
	$monter = $db->sql_query("SELECT * FROM ".TABLE_FRAME." WHERE id='".$pub_up_lien."'");
	$donnees1 = $db->sql_fetch_assoc($monter);
	$position_haut = $donnees1['frame_id']-1;
	$position_bas = $donnees1['frame_id'];
	$id_bas = $pub_up_lien;
	
	$descendre = $db->sql_query("SELECT * FROM ".TABLE_FRAME." WHERE frame_id='".$position_haut."'");
	$donnees2 = $db->sql_fetch_assoc($descendre);
	$id_haut = $donnees2['id'];
	
	$db->sql_query("UPDATE ".TABLE_FRAME." SET frame_id='". $position_bas ."' WHERE id = '".$id_haut."'");
	$db->sql_query("UPDATE ".TABLE_FRAME." SET frame_id='". $position_haut ."' WHERE id = '".$id_bas."'");
	redirection('index.php?action=ModFrame&subaction=admin');
}

//si on demande de descendre un lien
if (isset($pub_down_lien)){
	$monter = $db->sql_query("SELECT * FROM ".TABLE_FRAME." WHERE id='".$pub_down_lien."'");
	$donnees1 = $db->sql_fetch_assoc($monter);
	$position_haut = $donnees1['frame_id'];
	$position_bas = $donnees1['frame_id']+1;
	$id_haut = $pub_down_lien;
	
	$descendre = $db->sql_query("SELECT * FROM ".TABLE_FRAME." WHERE frame_id='".$position_bas."'");
	$donnees2 =$db->sql_fetch_assoc($descendre);
	$id_bas = $donnees2['id'];
	
	$db->sql_query("UPDATE ".TABLE_FRAME." SET frame_id='". $position_bas ."' WHERE id = '".$id_haut."'");
	$db->sql_query("UPDATE ".TABLE_FRAME." SET frame_id='". $position_haut ."' WHERE id = '".$id_bas."'");
	redirection('index.php?action=ModFrame&subaction=admin');
}

//si on demande de supprimer un lien
if (isset($pub_supprimer_lien)){
    $db->sql_query('DELETE FROM '.TABLE_FRAME.' WHERE id=' . $pub_supprimer_lien);
	redirection('index.php?action=ModFrame&subaction=admin');
}



//on affiche le tableau d'amin
echo "</tr></table>";
echo "<table align='center'><tr><td>";
echo "<h2>".$lang["frame_url_list"]."</h2>";
echo "<table align='center' border='1'><tr>";
echo "</tr><tr>";
echo "<th>".$lang["frame_url_name"]."</th>";
echo "<th>".$lang["frame_url_urls"]."</th>";
echo "<th>".$lang["frame_url_height"]."</th>";
echo "<th colspan='3'>&nbsp;</th>";
echo "</tr>";

//et on affiche ce qu'y a dedans
foreach ($frames as $donnees){
	echo "<tr>";
	echo "<td>".$donnees['name']."</td>";
	echo "<td>".$donnees['url']."</td>";
	echo "<td>".$donnees['hauteur']."</td>";
	echo "<td><a href='index.php?action=ModFrame&subaction=admin&up_lien=".$donnees['id']."'><img src='./images/asc.png'></a>";
	echo "<a href='index.php?action=ModFrame&subaction=admin&down_lien=".$donnees['id']."'><img src='./images/desc.png'></a>";
	echo "</td>";
	echo "<td><a href='index.php?action=ModFrame&subaction=admin&modifier_lien=".$donnees['id']."'><img src='./images/usercheck.png'></a></td>";
	echo "<td><a href='index.php?action=ModFrame&subaction=admin&supprimer_lien=".$donnees['id']."'><img src='./images/userdrop.png'></a>";
	echo "</td>";
	echo "</tr>";
} // Fin de la boucle qui liste les news
echo "</table>";

//si on veut en ajouter ou en modifier
echo "<h2>".$lang["frame_add_title"]."</h2>";

//si on demande a modifier
if (isset($pub_modifier_lien)){
    // On récupère les infos de la correspondante
    $retour = $db->sql_query('SELECT * FROM '.TABLE_FRAME.' WHERE id=' . $pub_modifier_lien);
    $donnees = $db->sql_fetch_assoc($retour);
   
    // On place le titre et le contenu dans des variables simples
	$name = $donnees['name'];
    $lien = $donnees['url'];
    $id = $donnees['id']; // Cette variable va servir pour se souvenir que c'est une modification
	$hauteur = $donnees['hauteur'];
//sinon on met par default
} else {
    // Les variables $titre et $contenu sont vides, puisque c'est une nouvelle news
	$name = '';
    $lien = 'http://';
	$hauteur = 50;
    $id = 0;
}

//partie post
echo "<form action='index.php?action=ModFrame&subaction=admin' method='post'>";
echo "<table border='0' cellpadding='3' cellspacing='1'>";
echo "<tr>";
echo "<th><b>".$lang["frame_add_name"]."</b></th>";
echo "<th><input type='text' name='name' size='45' maxlength='60' style='width:450px' tabindex='2' value='".$name."'/></th>";
echo "</tr><tr>";
echo "<th><b>".$lang["frame_add_url"]."</b></th>";
echo "<th><input type='text' name='url' size='45' style='width:450px' value='".$lien."'/></th>";
echo "</tr><tr>";
echo "<th><b>".$lang["frame_add_height"]."</b></th>";
echo "<th><input  type='text' size='8' name='hauteur' value='".$hauteur."'/>px</th>";
echo "</tr><tr>";
echo "<th colspan='2'>&nbsp;</th>";
echo "</tr><tr>";
echo "<th colspan='2'><input type='hidden' name='id' value='".$id."'/>";
if(isset($pub_modifier_lien))
	echo "<input type='submit' value='".$lang["frame_add_modify"]."'/>&nbsp;&nbsp;<input type='button' value='".$lang["frame_add_add"]."' onclick=\"window.location='index.php?action=ModFrame&subaction=admin';\"/>";
else
	echo "<input type='submit' value='".$lang["frame_add_create"]."'/>";
echo "</th></tr>";
echo "</table></form></td></table>";
	} // fin d'affichage de l'administration
} // fin d'admin	

if($pub_subaction != "admin") {
	echo '</tr></table>';
	echo "<br>";
	echo "<iframe style='width:100%;height:".$hauteur."px' src='".$url."'></iframe>";
	echo "<p align='center'>Mod Frames | Version ".$mod_version." | <a href='http://ogsteam.fr/forums/misc.php?email=5290'>Naruto kun</a> | © 2009</p>";
}

if (isset($pub_full)) require_once("views/page_tail_2.php"); //on inclus le logo de ogspy dans le mod (l'entete)
else require_once("views/page_tail.php");
?>
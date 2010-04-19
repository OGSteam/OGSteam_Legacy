<?php
/**
* Administration du module de News pour ogspy 
* @package News
* @author ericalens <ericalens@ogsteam.fr>
* @Update by Itori <itori@ogsteam.fr>
* @link http://www.ogsteam.fr
*
*/

// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Si pas Admin , on dégage
if(!$droit['admin']) {
	redirection("index.php?action=message&id_message=forbidden&info");
	die();
}
/*** Raccourci sur Commandes dans Options ***/
$naoc="?action=News&amp;subaction=Options&amp;command";

/*** Affichage du panneau d'administration du module News ***/
function ShowAdminPanel(){

	global $db,$user_data,$server_config,$naoc, $table_prefix, $pub_groupes, $pub_sscat;
	echo "<table align='center' width='90%'>\n"
		."\t<tr>\n"
		."\t\t<td class='c' colspan='4' align='center'><big>Panneau d'Administration du module <a href='?action=News'>News</a></big></td>\n"
		."\t</tr>\n"
		."\t<tr>\n"
		."\t\t<td class='k' colspan='4' align='center'>Options du module News<br><em>Ces options sont stockés dans la table configuration d'OGSpy</em></td>\n"
		."\t</tr>\n"
        ."\t<form action='$naoc=saveoptions' method='post'>\n"
		."\t<tr>\n"
		."\t\t<td class='c'width='30%'>Durée de clignotement</td>\n"
		."\t\t<td align='center' width='15%'><input type='text' name='news_BlinkHourDuration' value='".$server_config["news_BlinkHourDuration"]."'></td>\n"
		."\t\t<td>&nbsp;</td>"
		."\t\t<th>Affiche dans le menu des mods les News clignotantes <br>lorsqu'elles sont plus récentes que ce nombre d'heures.<br>0 pour ignorer</th>\n"
		."\t</tr>\n"
		."\t<tr>\n\t\t<td colspan=4 align='center' class='c'><input type='submit' value='Envoyer'></td>\n\t</tr>\n"
		."\t</form>\n"
		."\t<tr>\n"
		."\t\t<td class='k' colspan=4 align='center'>Gestion des catégories</td>\n"
		."\t</tr>\n"
		."\t\t<form action='$naoc=post' method='post'>\n"
		."\t<tr>\n"
/******************Menu Ajout option ****************/
		."\t\t<td class='c' width='30%'>Ajouter une option</td>\n"
		."\t\t<td width='15%' align='center'><select name='addcat'>\n";
		if ($pub_categorie == "Tutoriels") {
			echo "\t\t\t<option value='Tutoriels'SELECTED>Tutoriels</option>";
			echo "\t\t\t<option value='Divers'>Divers</option>";
		} else {
			echo "\t\t\t<option value='Tutoriels'>Tutoriels</option>";
			echo "\t\t\t<option value='Divers'SELECTED >Divers</option>";
		}
	echo "</select></td>\n"
		."\t\t<td width='15%' align='center'><input type='text' name='nomcat' /></td>\n"
		."\t\t<th>Sélectionner dans la liste déroulante le menu dans laquelle vous souhaitez la voir apparaitre,"
		."et écrivez le nom que vous souhaitez</th>\n"
		."\t</tr>\n"
		."\t<tr>\n\t\t<td colspan=4 align='center' class='c'><input type='submit' name='submit' value='Ajouter'></td>\n\t</tr>\n"
/****************** Menu Renommé  intitulé ************/		
		."\t\t<td class='c' width='30%'>Renommer un intitulé</td>\n"
		."\t\t<td width='15%' align='center'><select name='sscat'>\n";
		$query = "SELECT `id`,`souscat` FROM `".$table_prefix."news_cat` ORDER BY `souscat`";
		$result = $db->sql_query($query);
		while ($row=$db->sql_fetch_assoc($result)){
			if (!isset($pub_sscat)) $pub_ss=$row["id"];
			if ($pub_sscat == $row["id"]) {
			echo "\t\t\t<option value=".$row["id"]." SELECTED >".$row["souscat"]."</option>\n";
			} else {
			echo "\t\t\t<option value=".$row["id"].">".$row["souscat"]."</option>\n";
			}
		}
	echo "</select></td>\n"
		."\t\t<td width='15%' align='center'><input type='text' name='newsscat' /></td>\n"
		."\t\t<th>Sélectionner dans la liste déroulante l'intitulé que vous souhaitez modifier,"
		."et écrivez le nom que vous souhaitez</th>\n\t</tr>\n"
		."\t<tr>\n\t\t<td colspan=4 align='center' class='c'><input type='submit' name='submit' value='Renommer'></td>\n\t</tr>\n"
/****************** Menu Supprimer  option ************/		
		."\t\t<td class='c' width='30%'>Supprimer une option</td>\n"
		."\t\t<td width='15%' align='center'><select name='delcat' width='90%'>\n";
		$query = "SELECT `id`,`souscat` FROM `".$table_prefix."news_cat` ORDER BY `souscat`";
		$result = $db->sql_query($query);
		while ($row=$db->sql_fetch_assoc($result)){
			echo "\t\t\t<option value=".$row["id"].">".$row["souscat"]."</option>\n";
		}
	echo "</select></td>\n"
		."\t\t<td width='15%' align='center'>&nbsp;</td>\n"
		."\t\t<th>Sélectionner dans la liste déroulante l'option que vous souhaitez supprimer</th>\n"
		."\t</tr>\n"
		."\t<tr>\n\t\t<td colspan=4 align='center' class='c'><input type='submit' name='submit' value='Supprimer'></td>\n\t</tr>\n";
/*****************Menu Gestion des droits ***********/
if(($user_data['user_admin']==1) || ($user_data['user_coadmin']==1)) {
		echo "<tr><td class='k' colspan='4' align='center'>Gestion des droits</td></tr>"
		."<tr><td class='c' width='30%'>Permissions</td>
			<td width='15%' align='center'><select name='groupes'>\n";
			$query = "SELECT `group_id`, `group_name` FROM `".TABLE_GROUP."` ORDER BY `group_name`";
			$result = $db->sql_query($query);
			while ($row=$db->sql_fetch_assoc($result)){
				if (!isset($pub_groupes)) $pub_groupes=$row["group_id"];
				if ($pub_groupes == $row["group_id"]) {
					echo "\t\t\t<option value=".$row["group_id"]." SELECTED >".$row["group_name"]."</option>\n";
				} else {
				echo "\t\t\t<option value=".$row["group_id"].">".$row["group_name"]."</option>\n";
				}
			}			
	echo "</td>"
		."<td><input type='submit' name='permissions' value='Afficher les permissions'></td><th>&nbsp;</th></tr>";
			$query = "SELECT `news_post`, `news_edit`, `news_del`, `news_admin` FROM `".TABLE_GROUP."` WHERE `group_id`='$pub_groupes'";
			$result = $db->sql_query($query);
			$row=$db->sql_fetch_assoc($result);
		echo "<tr><td class='c' align='right'>Post</td><td align='center'><select name='droit_post'>";
					echo "\t\t\t<option value='1' ";
						if($row['news_post'] == 1) echo "SELECTED";
					echo ">Oui</option>\n";
					echo "\t\t\t<option value='0' ";
						if($row['news_post'] == 0) echo "SELECTED";
					echo ">Non</option>\n";
		echo "</select><td>&nbsp;</td><th>&nbsp;</th></tr>";
		echo "<tr><td class='c' align='right'>Edit</td><td align='center'><select name='droit_edit'>";
					echo "\t\t\t<option value='1' ";
						if($row['news_edit'] == 1) echo "SELECTED";
					echo ">Oui</option>\n";
					echo "\t\t\t<option value='0' ";
						if($row['news_edit'] == 0) echo "SELECTED";
					echo ">Non</option>\n";
		echo "</select><td>&nbsp;</td><th>&nbsp;</th></tr>";
		echo "<tr><td class='c' align='right'>Suppression</td><td align='center'><select name='droit_del'>";
					echo "\t\t\t<option value='1' ";
						if($row['news_del'] == 1) echo "SELECTED";
					echo ">Oui</option>\n";
					echo "\t\t\t<option value='0' ";
						if($row['news_del'] == 0) echo "SELECTED";
					echo ">Non</option>\n";
		echo "</select><td>&nbsp;</td><th>&nbsp;</th></tr>";
		echo "<tr><td class='c' align='right'>Admin</td><td align='center'><select name='droit_admin'>";
					echo "\t\t\t<option value='1' ";
						if($row['news_admin'] == 1) echo "SELECTED";
					echo ">Oui</option>\n";
					echo "\t\t\t<option value='0' ";
						if($row['news_admin'] == 0) echo "SELECTED";
					echo ">Non</option>\n";
		echo "</select><td>&nbsp;</td><th>&nbsp;</th></tr>"
				."\t<tr>\n\t\t<td colspan=4 align='center' class='c'><input type='submit' name='submit' value='Changer les droits'></td>\n\t</tr>\n";
	}
	echo "</table>";
}


// Verification du statut admin et execution des commandes
if(!$droit['admin']) {
	echo "<br>Hmmm ... non. Tu n'a pas le droit d'être ici , nous allons quand même informer l'administrateur"
	    ."  de ta tentative pour rentrer ici.";
	log_("debug","News: Tentative d'accés à la page Admin par un non Admin");
	redirection("index.php?action=message&id_message=forbidden&info");
	die();
}else
{
	if (!isset($pub_command)) $pub_command = '';
  switch($pub_command) {
	case "saveoptions":
		SetConfig("news_BlinkHourDuration","$pub_news_BlinkHourDuration");
		echo "<br>Sauvegarde des options du module News<br><a href='$naoc'>Retour</a>";
		break;
	case "post":
		switch($pub_submit) {
			case "Ajouter":
				$query="INSERT INTO `".$table_prefix."news_cat` (`categorie`, `souscat`) VALUES ('".mysql_real_escape_string($pub_addcat)."','".mysql_real_escape_string($pub_nomcat)."')";
				break;
			case "Renommer":
				$query="UPDATE `".$table_prefix."news_cat`SET `souscat`='".mysql_real_escape_string($pub_newsscat)."' WHERE `id`='".mysql_real_escape_string($pub_sscat)."'";
				break;
			case "Supprimer":
				$query="DELETE FROM ".$table_prefix."news_cat WHERE id='".mysql_real_escape_string($pub_delcat)."'";
				break;
			case "Changer les droits":
				$query="UPDATE `".TABLE_GROUP."` SET `news_post`='".$pub_droit_post."', `news_edit`='".$pub_droit_edit."', `news_del`='".$pub_droit_del."', `news_admin`='".$pub_droit_admin."' WHERE `group_id`=$pub_groupes";
				break;
			default:
				showAdminPanel();
				exit();
				break;
		}
		$result = $db->sql_query($query);
		echo "Opération effectuée";
		ShowAdminPanel();
		break;
	default:
		ShowAdminPanel();
 }
}

require_once("views/page_tail.php");
?>

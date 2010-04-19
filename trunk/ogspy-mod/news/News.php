<?php
/**
* Module OGSpy de page de News
* @package News
* @author ericalens <ericalens@ogs.servebbs.net>
* @Update by Itori <itori@ogsteam.fr>
* @link http://www.ogsteam.fr
*
*/

// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db;

// Est-ce que le mod est actif ?
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='News' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//Raccourci vers le subaction
$nac="?action=News&amp;subaction";

// Header OGSpy
require_once("views/page_header.php");
require_once("mod/News/bbcode.php");
require_once("mod/News/function.php");

//teste les droits
$droit = news_rights();
//récupére les tags bbcode => pour la fonction de parsing bbcode
getBBTags('mod/News/bbcode.xml');

/*** Clignotement du menu ***/
if ($server_config["news_BlinkHourDuration"]>0) {
	$query = "SELECT MAX(news_time) FROM ".$table_prefix."news";
	$result = $db->sql_query($query);

	//récupère le nom du mod
	$query = "SELECT `menu` FROM `".$table_prefix."mod` where `action`='News'";
	$res = $db->sql_query($query);
	$nom = strip_tags(mysql_result($res,0));
	
	if (list($timestamp) = $db->sql_fetch_row($result)) {
			$diff_date = (int)((time() - $timestamp) / (60*60)); //différence en heures
			$days_max = $server_config["news_BlinkHourDuration"];
			if ($diff_date < $days_max) {
				$query = "UPDATE ".TABLE_MOD." SET `menu`='<blink>".$nom."</blink>' WHERE `action`='News'";
			}
			else {
				$query = "UPDATE ".TABLE_MOD." SET `menu`='".$nom."' WHERE `action`='News'";
			}
			$db->sql_query($query);
	}
}

/*** Barre de menu ***/
echo "<table width=90%>\n"
		."\t<tr>\n"
		."\t\t<td class='k' width=30%><a href='?action=News'>News</a></td>\n"
		."\t\t<td class='k' width=30%><a href='$nac=Tutoriels'>Tutoriels</a></td>\n"
		."\t\t<td class='k' width=30%><a href='$nac=Divers'>Divers</a></td>\n";
if ($droit['admin']) {
	echo	"\t\t<td class='k' width=30%><a href='$nac=Options'>Administration</a></td>\n";
}
echo "\t</tr>\n</table>\n";
/*** Fin barre de menu ***/

if (!isset($pub_subaction)) $pub_subaction = '';
//switch sur les sous-menus
switch($pub_subaction) {
	case "post":
		if($droit['post']) {
			//Dans le cas d'un nouveau message
			if (!isset($pub_nid)){
				$query="INSERT INTO ".$table_prefix."news (`news_time`, `title`,`body`)"
					." VALUES(".time().", '".mysql_real_escape_string($pub_title)."','".mysql_real_escape_string($pub_body)."')";
			//Dans le cas d'un édit
			} else {
				$query="UPDATE ".$table_prefix."news set "
					."`news_time`=".time().",`title`='".mysql_real_escape_string($pub_title)."',`body`='".mysql_real_escape_string($pub_body)."' where id=$pub_nid";
			}
			$db->sql_query($query);
			redirection("?action=News");
		}
		break;
	//Suppression d'une news
	case "delete":
		//Vérification des droits
		if($droit['del']) {
			$query="DELETE FROM ".$table_prefix."news WHERE id='$pub_nid'";
			$db->sql_query($query);
			redirection("?action=News");
		}
		break;
	//cas d'un édit
	case "edit":
		if ($droit['edit']){
			$query="SELECT * FROM ".$table_prefix."news WHERE ID=$pub_nid";
			$result=$db->sql_query($query);
			$row=$db->sql_fetch_assoc($result);
			
			echo "<table width=90%>
					<tr>\n
						\t<td class='c' colspan='2' align='center'>Editer une News</td>\n
					</tr>\n";
					if (!isset($pub_title)){
						$pub_title = $row["title"];
						$pub_body = $row["body"];
					}
					echo "<tr>\n
						\t<td class='l' align='center'  width='100'>".date("d/m/y, G:i",$row["news_time"])."</td>\n
						\t<td class='l'>".render($pub_title,"")."</td>\n
					</tr>\n
					<tr>\n
						\t<td class='f' colspan='2'>".parsesmiley(render($pub_body,''))."</td>\n
					</tr>\n
					<tr>\n
						\t<td colspan='2'>&nbsp;</td>
					</tr>\n
					<tr>\n
						<td valign='top' class='c'>Titre</td>
						<td class='g'><form method='post' id='form1'>
						<input type='hidden' name='mod' value='".$pub_mod."'>
						<input type='hidden' name='nid' value='".$pub_nid."'>
						<div align='center'><input type=text size='60%' name='title' value='".stripslashes($pub_title)."'></div>
						</td>\n
					</tr>
					<tr>
						<td class='l'>&nbsp;</td>
						<td class='l' align='center'>";
						btbbcode($bbcode_form);
						echo "</td>
					</tr>
					<tr>
						<td valign='top' class='c'>Texte</td>
						<td class='c'><textarea rows='20' cols='120' name=body>"
						.stripslashes($pub_body)
						."</textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align=center>
							<input type='submit' name='submit' value='Modifier' onclick=valider('$nac=post')>
							<input type='submit' name='preview' value='Prévisualiser' onclick=valider('$nac=edit')>
							</form>
						</td>
					</tr>
				</table>";
			require_once("views/page_tail.php");
		}
		exit();
		break;
	//Preview
	case "preview" :
		if ($droit['post']){
			echo "<table width=90%>
					<tr>\n
						\t<td class='c' colspan='2' align='center'>Poster une News</td>\n
					</tr>\n";
					echo "<tr>\n
						\t<td class='l' align='center'  width='100'>&nbsp;</td>\n
						\t<td class='l'>".render($pub_title,"")."</td>\n
					</tr>\n
					<tr>\n
						\t<td class='f' colspan='2'>".parsesmiley(render($pub_body,''))."</td>\n
					</tr>\n
					<tr>\n
						\t<td colspan='2'>&nbsp;</td>
					</tr>\n
					<tr>\n
						<td valign='top' class='c'>Titre</td>
						<td class='g'><form method='post' id='form1'>
						<input type='hidden' name='mod' value='".$pub_mod."'>
						<div align='center'><input type=text size='60%' name='title' value='".stripslashes($pub_title)."'></div>
						</td>\n
					</tr>
					<tr>
						<td class='l'>&nbsp;</td>
						<td class='l' align='center'>";
						btbbcode($bbcode_form);
						echo "</td>
					</tr>
					<tr>
						<td valign='top' class='c'>Texte</td>
						<td class='c'><textarea rows='20' cols='120' name=body>"
						.stripslashes($pub_body)
						."</textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align=center>
							<input type='submit' name='submit' value='Poster' onclick=valider('$nac=post')>
							<input type='submit' name='preview' value='Prévisualiser' onclick=valider('$nac=preview')>
							</form>
						</td>
					</tr>
				</table>";
			require_once("views/page_tail.php");
		}
		exit();
		break;
	case "Options":
		if($droit['admin']) {
			require_once("mod/News/news_admin.php");
		}
		exit();
		break;
	case "Tutoriels":
		require_once("mod/News/news_aide.php");
		exit();
		break;
	case "Divers":
		require_once("mod/News/news_divers.php");
		exit();
		break;
}

/**** Affichage des news ***/
echo "<table width=90%>\n"
		."<tr>\n"
		."\t<td class=c colspan=3 align=center>Les News</td>\n"
		."</tr>\n";
		
//Selectionne les news qui sont à afficher
if(empty($pub_top)) { $pub_top='0'; }
$query="SELECT * FROM ".$table_prefix."news WHERE `idcat`=0 ORDER BY id DESC limit $pub_top, 5";
$result=$db->sql_query($query);
while ($row=$db->sql_fetch_assoc($result)){
	echo "<tr>\n"
		."\t<td class='l' align='center'  width='100'>".date("d/m/y, G:i",$row["news_time"])."</td>\n"
		."\t<td class='l'  colspan=2>".render($row["title"],"")."</td>\n"
		."</tr>\n"
		."<tr>\n"
		."\t<td class='f' colspan=3 >".parsesmiley(render($row["body"],''))."</td>\n"
		."</tr>\n";
		
	// Si l'user à les droits, affichage des boutons d'édit et de suppression
    echo "<tr>\n"
		."\t<td class=c colspan=3 align=right>";
	if($droit['edit']) {
		echo "&nbsp;<a href='$nac=edit&amp;nid=".$row["id"]."'>Edit</a>&nbsp;";
	}
		echo "|";
	if($droit['del']){
		echo "&nbsp;<a href='$nac=delete&amp;nid=".$row["id"]."'>Effacer</a>";
	}
	echo "</td>\n"
		."</tr>";
	
}
echo "<tr>\n"
	."\t<td colspan=3 align='right'>";

//trouve le nombre de news
$query = "SELECT count(`id`) FROM `".$table_prefix."news` where `idcat`=0";
$result=$db->sql_query($query);
$res = $db->sql_fetch_assoc($result);
$res=$res['count(`id`)'];

if ($pub_top==0) {
	echo "<<- ";
} else {
	$moins=$pub_top-5;
	echo "<a href='?action=News&amp;top=$moins'><<- </a>";
}
$plus=$pub_top+5;
if ($res > $plus) {
	echo "<a href='?action=News&amp;top=$plus'> +>></a>";
} else {
	echo " +>>";
}
echo "</td>\n</tr>\n"
	."</table>\n";
/*** Fin de l'affichage des news ***/
	
/*** Formulaire d'ajout de News ***/
if($droit['post'] == 1) {
	echo "<table width=90%>\n"
		."<tr>\n"
			."\t<td class='l' colspan=2>Ajouter une News</td>\n"
		."</tr>\n"
		."<tr>\n"
			."\t<td class='c' valign=top>Titre</td>\n"
			."<form method='post' id='form1'>\n"
			."\t<td align='center'class='g'><div align='center'>"
			."<input type=text size='60%' name='title'></div></td>\n"
		."</tr>\n"
		."<tr>\n"
			."\t<td  class='l'>&nbsp;</td>\n"
			."\t<td align='center' class='l'>";
	     btbbcode();
		 echo "</td>\n"
		."</tr>\n"
		."<tr>\n"
		."<td class='c' valign=top>Texte</td>\n"
			."<td><textarea rows='15' name='body'></textarea></td>\n"
		."</tr>\n"
		."<tr>\n"
			."\t<td colspan=2 align=center>
			<input type='submit' name='submit' value='Poster' onclick=valider('$nac=post')>
			<input type='submit' name='preview' value='Prévisualiser' onclick=valider('$nac=preview')>			
			</form></td>\n"
		."</tr>"
		."</table>";

}
/*** Fin formulaire d'ajout ***/

//Récupére le numéro de version du mod
$request = "SELECT `version` from `".TABLE_MOD."` WHERE title='News'";
$result = $db->sql_query($request);
list($version) = $db->sql_fetch_row($result);
echo '<div>News (v'.$version.')</div>';
require_once("views/page_tail.php");
?>

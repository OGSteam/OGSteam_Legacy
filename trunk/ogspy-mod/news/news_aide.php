<?php
/**
* Page Tutoriels pour ogspy 
* @package News
* @author ericalens <ericalens@ogsteam.fr>
* @Update by Itori <itori@ogsteam.fr>
* @link http://www.ogsteam.fr
*
*/

// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Raccourci sur Commandes dans Tutoriels
$naoc="?action=News&amp;subaction=Tutoriels&amp;command";

/*** Présentation des news ***/
echo "<table width=90%>\n
		<tr>\n
			\t<td class=c colspan=3 align='center'>Présentation des mods et tutoriels</td>\n
		</tr>\n
		<tr>\n
			\t<td class=c colspan=3 align='center'>
				<form action='?action=News&amp;subaction=Tutoriels' method='POST'>Tutoriels sur :\n
					<select name='mod'>";
/*** Selection de la rubrique ***/
$query = "SELECT DISTINCT `idcat`, `SousCat`
			FROM `".$table_prefix."news`, `".$table_prefix."news_cat`
			WHERE `idcat` in (SELECT `id` FROM `".$table_prefix."news_cat` WHERE `categorie`='Tutoriels')
			AND `idcat` = ".$table_prefix."news_cat.`id`
			ORDER BY `souscat`";
$result=$db->sql_query($query);
while ($row=$db->sql_fetch_assoc($result)){
	//Si aucune catégorie, selectionne le premier de la liste
	if (!isset($pub_mod)) $pub_mod=$row["idcat"];
	if ($pub_mod == strtr($row["idcat"], " ", "_")) {
		echo "\t\t\t<option value=".strtr($row["idcat"]," ","_")." SELECTED >".$row["SousCat"]."</option>\n";
	} else {
		echo "\t\t\t<option value=".strtr($row["idcat"]," ","_").">".$row["SousCat"]."</option>\n";
	}
}
			echo "\t\t\t</select>\n
			\t\t\t<input type='submit' value='envoyer'>\n
		\t\t</form>
		</td>\n
	</tr>\n";
/*** Fin selection rubrique ***/

	if (!isset($pub_command)) $pub_command = '';
	switch($pub_command) {
		//Cas d'un post
		case "post":
			if($droit['post']) {
				if (!isset($pub_nid)){
					$query="INSERT INTO ".$table_prefix."news (`news_time`, `title`,`body`, `idcat`)"
						." VALUES(".time().", '".mysql_real_escape_string($pub_title)."','".mysql_real_escape_string($pub_body)."', '".mysql_real_escape_string($pub_mod)."')";
				} else {
					$query="UPDATE ".$table_prefix."news set "
						."`news_time`=".time().",`idcat`='".mysql_real_escape_string($pub_mod)."', `title`='".mysql_real_escape_string($pub_title)."',`body`='".mysql_real_escape_string($pub_body)."' where id=$pub_nid";
				}

				$db->sql_query($query);
			}
			redirection("?action=News&amp;subaction=Tutoriels&amp;mod=".$pub_mod);
			break;
		//Cas d'une suppression
		case "delete":
			if ($droit['del']){
				$query="DELETE FROM ".$table_prefix."news WHERE id='$pub_nid'";
				$db->sql_query($query);
			}
			redirection("?action=News&amp;subaction=Tutoriels&amp;mod=$pub_mod");
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
								<input type='submit' name='submit' value='Modifier' onclick=valider('$naoc=post')>
								<input type='submit' name='preview' value='Prévisualiser' onclick=valider('$naoc=edit')>
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
								<input type='submit' name='submit' value='Poster' onclick=valider('$naoc=post')>
								<input type='submit' name='preview' value='Prévisualiser' onclick=valider('$naoc=preview')>
								</form>
							</td>
						</tr>
					</table>";
				require_once("views/page_tail.php");
			}
			exit();
			break;
	}

/*** Affichage des news ***/
if (!empty($pub_mod)){
		$query = "SELECT * FROM ".$table_prefix."news WHERE `idcat`='$pub_mod' ORDER BY `id`";
		$result=$db->sql_query($query);
		while ($row=$db->sql_fetch_assoc($result)){
			echo "\t<tr>\n
				\t<td class='l' align='center'  width='100'>".date("d/m/y, G:i",$row["news_time"])."</td>\n
				\t<td class='l'  colspan=2>".render($row["title"],"")."</td>\n
			</tr>\n
			<tr>\n
				\t<td class='f' colspan=3 >".parsesmiley(render($row["body"],''))."</td>\n
			\t</tr>\n
			\t<tr>\n
				\t\t<td class=c colspan=3 align=right>";
			if($droit['edit']) {
				echo "<a href='$naoc=edit&amp;mod=$pub_mod&amp;nid=".$row["id"]."'>Edit</a>&nbsp;";
			}
				echo "|";
			if($droit['del']){
				echo "&nbsp;<a href='$naoc=delete&amp;mod=$pub_mod&amp;nid=".$row["id"]."'>Effacer</a>";
			}
			echo "</td>\n
				\t</tr>\n";
		}
	echo "<tr><td>&nbsp;</td><td align='right'>";
	//trouve le nombre de news
	$query = "SELECT count(`id`) FROM `".$table_prefix."news` where `idcat`=$pub_mod";
	$result=$db->sql_query($query);
	$res = $db->sql_fetch_assoc($result);
	$res=$res['count(`id`)'];

	if(empty($pub_top)) $pub_top='0';
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
}
/*** Fin de l'affichage des news ***/
// Affichage menu ajout
if($droit['post']) {
	echo "<table width=90%>\n
			<tr>\n
				\t\t<td class='l' colspan=3>Ajouter une News</td>\n
			\t</tr>\n
			\t<tr>\n
				\t\t<td class='c' valign=top width='10%'>Titre</td>\n
				\t\t<td class='c' width='50%'>
				<form method='post' id='form1'>
				<div align='center'><input type=text size=60% name='title'></div>
				</td>\n
				\t\t<td class='c' width='30%' align='center'><select name='mod'>";
		
		//Remplissage Liste déroulante select
		$query = "SELECT `id`, `SousCat` FROM `".$table_prefix."news_cat` WHERE `categorie`='Tutoriels' ORDER BY `SousCat`";
		$result=$db->sql_query($query);
		while ($row=$db->sql_fetch_assoc($result)){
			if ($pub_mod == $row["id"]) {
				echo "\t\t\t<option value=".$row["id"]." SELECTED >".$row["SousCat"]."</option>\n";
			} else {
				echo "\t\t\t<option value=".$row["id"].">".$row["SousCat"]."</option>\n";
			}
		}
		echo "\t\t\t</select></td>\n
			\t</tr>\n
			\t<tr><td  class='l'>&nbsp;</td><td align='center' colspan='3'  class='l'>";
			btbbcode($bbcode_form);
	    echo "</td>
		</tr>\n
		<tr>\n
			\t\t<td class='c' valign=top >Texte</td>\n
			\t\t<td colspan=2><textarea rows='15' name=body></textarea></td>\n
		</tr>\n
	    <tr>\n
			\t\t<td colspan=4 align=center>
			<input type='submit' name='submit' value='Poster' onclick=valider('$naoc=post')>
			<input type='submit' name='preview' value='Prévisualiser' onclick=valider('$naoc=preview')></form></td>\n
		</tr>\n
	 </table>";
}

require_once("views/page_tail.php");
?>

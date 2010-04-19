<?php
/**
* function.php
* @package News
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

function news_rights() {
	global $db,$table_prefix,$user_data;
	if($user_data["user_admin"] == 1 || $user_data["user_coadmin"]==1) {
		$res['post']=1;
		$res['edit']=1;
		$res['del']=1;
		$res['admin']=1;
	} else {
	$query = "SELECT `user_id`, max(news_post) as post, max(news_edit) as edit, max(news_del) as del, max(news_admin) as admin
			FROM `".TABLE_GROUP."` g, `".$table_prefix."user_group` ug
			WHERE g.group_id=ug.group_id and `user_id` = '".$user_data['user_id']."'
			GROUP BY `user_id`";
	$result = $db->sql_query($query);
	$res = $db->sql_fetch_assoc($result);
	}
	return $res;
}

/*** Modification d'une valeur de config dans la table de config d'OGSpy *****/
function SetConfig($key,$value){
	global $db;
	$query="REPLACE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('$key','$value') ";
	$db->sql_query($query);
}

//Fonction tooltip by Oxid
function infobulle($txt_contenu, $titre = 'Aide', $largeur = '300') {
	// remplace ' par \'
	// puis remplace \\' par \'
	// au cas où le guillemet simple aurait déjà été protégé avant l'appel à la fonction
	$txt_contenu = str_replace('\\\\\'','\\\'',str_replace('\'','\\\'',$txt_contenu));
	// remplace le guillemet double par son code HTML
	$txt_contenu = str_replace('"','&quot;',$txt_contenu);

	// pareil avec $titre
	$titre = str_replace('\\\\\'','\\\'',str_replace('\'','\\\'',$titre));
	$titre = str_replace('"','&quot;',$titre);

	// tant qu'on y est, vérification de $largeur
	if (!is_numeric($largeur))
	  $largeur = 300;

	// affiche l'infobulle
	echo '"this.T_WIDTH=300;this.T_TEMP=0;return escape(\'<table width=&quot;',$largeur
	,'&quot;><tr><td align=&quot;center&quot; class=&quot;c&quot;>',$titre,'</td></tr><tr><th align=&quot;center&quot;>',$txt_contenu,'</th></tr></table>\')"';
}

function smiley() {
	$folder = "./mod/News/smilies/";
	$dossier = opendir($folder);
	$res = "";
	$count = 1;
	while ($Fichier = readdir($dossier))
	{
		if ($Fichier != "." && $Fichier != "..") {
			if (substr($Fichier,-3,3) == "gif" || substr($Fichier,-3,3)== "jpg" || substr($Fichier,-3,3) == "png") {
				
				$nomFichier = $folder.$Fichier;
				$Send = str_replace(" ", "%20", $Fichier);
				$nomSend = $folder.$Send;
				$res = $res."<img src='".$nomSend."' border='0' alt='' onclick=insert_text(':".substr($Send, 0, -4).":','','true') />";
				if ($count == 5) {
					$res= $res."<br>";
					$count = 1;
				}
				$count = $count+1;
				
			}
		}
	}
	closedir($dossier);

	return($res);
}

/**Fonction de parsing de smiley ***
Récupère le nom des images dans un tableau, puis boucle pour remplacer les tags smiley par le smiley correspondant */
function parsesmiley($text) {
	$folder = "./mod/News/smilies/";
	$dossier = opendir($folder);
	$res = array();
	$i = 0;
	while ($Fichier = readdir($dossier))
	{
		if ($Fichier != "." && $Fichier != "..") {
			if (substr($Fichier,-3,3) == "gif" || substr($Fichier,-3,3)== "jpg" || substr($Fichier,-3,3) == "png") {
				$nomFichier = $folder.$Fichier;
				$Send = str_replace(" ", "%20", $Fichier);
				$nomSend = $folder.$Send;
				
				$res[$i][0] = substr($Send,0,-4);
				$res[$i][1] = $nomSend;
				
				$i++;
				
			}
		}
	}
	closedir($dossier);
	
	foreach($res as $smiley) {
	$text = str_replace(":".$smiley[0].":", "<img src='".$smiley[1]."'/>", $text);
	}
	return($text);
}
/*** Fonction Ajout bouton bbcode prise sur mod punbb***/

?>
<script type="text/javascript">
	function valider(act){
	document.forms['form1'].action=act;
	document.forms['form1'].submit();
	}
		<!--
	function insert_text(open, close)
	{
		msgfield = (document.all) ? document.all.body : document.forms['form1']['body'];

		// IE support
		if (document.selection && document.selection.createRange)
		{
			msgfield.focus();
			sel = document.selection.createRange();
			sel.text = open + sel.text + close;
			msgfield.focus();
		}

		// Moz support
		else if (msgfield.selectionStart || msgfield.selectionStart == '0')
			{
			var startPos = msgfield.selectionStart;
			var endPos = msgfield.selectionEnd;
			msgfield.value = msgfield.value.substring(0, startPos) + open + msgfield.value.substring(startPos, endPos) + close + msgfield.value.substring(endPos, msgfield.value.length);
			msgfield.focus();
			}

		// Fallback support for other browsers
		else
			{
			msgfield.value += open + close;
			msgfield.focus();
			}
		return;
	}
		-->
	</script>
<?php
function btbbcode() {
?>
		<div style="padding-top: 4px">
		<input type="button" value=" B " name="B" onClick="insert_text('[b]','[/b]')" onmouseover=<?php infobulle("[b]votre texte[/b]","Gras") ?>/>							
		<input type="button" value=" I " name="I" onClick="insert_text('[i]','[/i]')" onmouseover=<?php infobulle("[i]votre texte[/i]","Italique") ?>/>
		<input type="button" value=" U " name="U" onClick="insert_text('[u]','[/u]')" onmouseover=<?php infobulle("[u]votre texte[/u]","Souligné") ?>/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" value="http://" name="Url" onClick="insert_text('[url]','[/url]')" onmouseover=<?php infobulle("[url]votrelien[/url]<br>[url=votrelien]votre texte[/url]","Lien hypertexte") ?>/>
		<input type="button" value="Img" name="Img" onClick="insert_text('[img]','[/img]')" onmouseover=<?php infobulle("[img]votre img[/img]","Image") ?>/>
		<input type="button" value="Quote" name="Quote" onClick="insert_text('[quote]','[/quote]')"onmouseover=<?php infobulle("[quote]votre texte[/quote]","Citation") ?> />
		<input type="button" value="NoBBcode" name="NoBBcode" onClick="insert_text('[nobbcode]','[/nobbcode]', 'false')" onmouseover=<?php infobulle("[nobbcode]votre texte[/nobbcode]","Affiche BBcode") ?>/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" value="Gauche" name="Gauche" onClick="insert_text('[left]','[/left]', 'false')" onmouseover=<?php infobulle("[left]votre texte[/left]","Alignement gauche") ?>/>
		<input type="button" value="Centrer" name="Centrer" onClick="insert_text('[center]','[/center]', 'false')" onmouseover=<?php infobulle("[center]votre texte[/center]","Alignement centre") ?>/>
		<input type="button" value="Droite" name="Droite" onClick="insert_text('[right]','[/right]', 'false')" onmouseover=<?php infobulle("[right]votre texte[/right]","Alignement droit") ?>/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<select name="Couleur" onChange="insert_text('[color=' + this.form.Couleur.options[this.form.Couleur.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;" onmouseover=<?php infobulle('[color=couleur]votre texte[/color]', 'Couleurs')?>>
			<option name="color" value="defaut">Défaut</option>
			<option style="color:darkred;" name="color" value="darkred">Rouge foncé</option>
			<option style="color:red;" name="color" value="rouge">Rouge</option>
			<option style="color:orange;" name="color" value="orange">Orange</option>
			<option style="color:brown;" name="color" value="brown">Marron</option>
			<option style="color:yellow;" name="color" value="yellow">Jaune</option>
			<option style="color:green;" name="color" value="green">Vert</option>
			<option style="color:olive;" name="color" value="olive">Olive</option>
			<option style="color:cyan;" name="color" value="cyan">Cyan</option>
			<option style="color:blue;" name="color" value="blue">Bleu</option>
			<option style="color:darkblue;" name="color" value="darkblue">Bleu foncé</option>
			<option style="color:indigo;" name="color" value="indigo">Indigo</option>
			<option style="color:purple;" name="color" value="purple">Violet</option>
			<option style="color:white;" name="color" value="white">Blanc</option>
			<option style="color:black;" name="color" value="black">Noir</option>
		</select>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" value="Smiley" name="Smiley" onmouseover=<?php infobulle(smiley(),"Smileys") ?>/>
	</div>
<?php
}
?>

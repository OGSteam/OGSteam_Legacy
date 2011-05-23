<?php
/***************************************************************************
*	filename	: RC_Save_Add.php
*	Author	: ben.12
*         Mod OGSpy: RC Save
***************************************************************************/
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$help["RC_save_copy"] = "Editer les sources du RC et copiez les ci-dessous<br><br><font color='orange'>Firefox:</font><br>\t-Click droit-<br>\t-\"Code source de la page\"-<br><br><font color='orange'>Internet Exploreur:</font><br>\t-Click droit-<br>\t-\"Afficher la source\"-";
$help["RC_save_com"] = "Sera en titre de page de votre RC.";

$flock = function_exists("flock");
?>
<script language="JavaScript" type="text/javascript" src="./mod/RC_save/fonction.js" ></script>
<?php
// Ajout ou modification
if(isset($pub_RC_sources) && isset($pub_RC_sources_comment) && isset($pub_comment) && isset($pub_style) && isset($pub_coord) && isset($pub_name)) {
	$rapport = stripcslashes($pub_RC_sources);
	$commentaire = stripcslashes($pub_comment);
	$coord = htmlentities(stripcslashes($pub_coord));
	$name_att = htmlentities(stripcslashes($pub_name));
	$name_def = htmlentities(stripcslashes($pub_name));
	
	$sources_comment = trim(preg_replace('@<script[^>]*?>(.*?</script>)?@si', "", stripcslashes($pub_RC_sources_comment)));
	$sources_comment = trim(preg_replace('@<iframe[^>]*?>(.*?</iframe>)?@si', "", $sources_comment));
	$sources_comment = trim(preg_replace('@<object[^>]*?>(.*?</object>)?@si', "", stripcslashes($sources_comment)));
	$sources_comment = trim(preg_replace('@<vbscript[^>]*?>(.*?</vbscript>)?@si', "", stripcslashes($sources_comment)));
	$sources_comment = nl2br($sources_comment);
	
	if(!check_var($pub_style, "URL")) redirection("index.php?action=message&id_message=errordata&info");
	if(isset($pub_mod) && !is_numeric($pub_mod)) redirection("index.php?action=message&id_message=errordata&info");
	
	// gération de l'id ou ouverture du RC pour modification:
	if(!isset($pub_mod)) {
		$r_id = rand(1000, 1000000);
		while(file_exists("./mod/RC_save/datas/" . $r_id . ".html")) {
			$r_id = rand(1000, 1000000);
		}
	} elseif(file_exists("./mod/RC_save/datas/" . $pub_mod . ".html")) {
		$r_id = $pub_mod;
		$filename = "./mod/RC_save/datas/" . $r_id . ".html";
		if (!$handle = fopen($filename, 'r')) {
			echo "Impossible d'ouvrir le fichier ($filename)";
			exit;
		}
		if($flock) flock($handle, LOCK_EX);
		$rapport = "";
		while (!feof($handle)) {
			$rapport .= fgets($handle);
		}
		if($flock) flock($handle, LOCK_UN);
		fclose($handle);
	}
	
	// mise en forme du commentaire:
	if($sources_comment != "") $sources_comment = "<br><br><table border=1 width=80%><tr><td align='left'><a href='post.php?skin=".$pub_style."&rc_id=".$r_id."' target='_blank'>Laisser un message.</a></td></tr><tr><!-- comment --><td class='c'>Commentaires de l'auteur:</td></tr><tr><th>".$sources_comment."</th><!-- fin de comment --></tr>";
	
	$filename = "./mod/RC_save/datas/" . $r_id . ".html";
	
	// vérif, ce RC est bien un RC (code sources)
	if(preg_match("/.*Les flottes suivantes se sont affrontées le.*<br>.*Attaquant.*Type.*Nombre.*Défenseur.*/i", $rapport)) {
		if(isset($pub_name_att_active) && $pub_name_att_active) $name_att = "$2"; //nom d'attaquant
		if(isset($pub_name_def_active) && $pub_name_def_active) $name_def = "$2"; //nom de defenceurs
		if(isset($pub_coord_active) && $pub_coord_active) $coord = "$3"; // coordonnées
		
		$rapport = trim(preg_replace('@<script[^>]*?>(.*?</script>)?\s*@si', '', $rapport));
		$rapport = trim(preg_replace('@<object[^>]*?>(.*?</object>)?\s*@si', '', $rapport));
		$rapport = trim(preg_replace('@<vbscript[^>]*?>(.*?</vbscript>)?\s*@si', '', $rapport));
		$rapport = trim(preg_replace('@<iframe[^>]*?>(.*?</iframe>)?\s*@si', '', $rapport));
		$rapport = trim(preg_replace('@<link[^>]*?>(.*?</link>)?\s*@si', '', $rapport));
		$rapport = trim(preg_replace('@<a href="#" onclick="showGalaxy\([0-9,\s]*?\);">\[([0-9:]{5,9})\]</a>@si', '$1', $rapport));
		
		$rapport = preg_replace("/(Attaquant)\s+([^<]+)\s+\((\d{1,2}:\d{1,3}:\d{1,2})\)/i", "$1 ".$name_att." (".$coord.")", $rapport); // remplacement du nom et coodonnées de l'attaquant
		$rapport = preg_replace("/(Défenseur)\s+([^<]+)\s+\((\d{1,2}:\d{1,3}:\d{1,2})\)/i", "$1 ".$name_def." (".$coord.")", $rapport); // remplacement du nom et coodonnées du defenseur
		
		if(isset($pub_techno_active) && $pub_techno_active) ;
		else $rapport = preg_replace("/<br>\s*Armes\:\s+\d+%\s+Bouclier:\s+\d+%\s+Coque:\s+\d+%\s*/i", "", $rapport); // remplacement des techno
		$rapport = preg_replace("/<head>/i", "<head>\n\t<link rel=\"stylesheet\" type=\"text/css\" href=\"".$pub_style."formate.css\">", $rapport); // changement du skin
		$rapport = preg_replace("/(<title>.*<\/title>\s*)*<\/head>/i", "<title>".$commentaire."</title></head>", $rapport); // titre du RC
		if(!preg_match("/<\/body>/i", $rapport))
			$rapport .= "</body>\n</html>";
		if(!preg_match("/<html>/i", $rapport))
			$rapport = "<html>\n".$rapport;
		// Mise en place du commentaire de l'auteur
		if($sources_comment != "") {
			if(preg_match("/<br><br><table border=1 width=\d+%><tr><td align='left'><a href='post.php?\S+' target='_blank'>Laisser un message.<\/a><\/td><\/tr><tr><\!-- comment --><td class='c'>Commentaires de l'auteur:<\/td><\/tr><tr><th>(.|\n|\r)+<\/th><\!-- fin de comment --><\/tr>/i",$rapport)) $rapport = preg_replace("/<br><br><table border=1 width=\d+%><tr><td align='left'><a href='post.php?\S+' target='_blank'>Laisser un message.<\/a><\/td><\/tr><tr><\!-- comment --><td class='c'>Commentaires de l'auteur:<\/td><\/tr><tr><th>(.|\n|\r)+<\/th><\!-- fin de comment --><\/tr>/Ui", $sources_comment, $rapport);
			else $rapport = preg_replace("/\s*<\/body>/i", "\n<center>".$sources_comment."</table></center>\n\t</body>", $rapport);
		} elseif(!isset($pub_mod)) $rapport = preg_replace("/(<script language=\"JavaScript\" type=\"text\/javascript\" src=\"js\/wz_tooltip.js\"><\/script>\s*)?<\/body>/i", "<center>".$sources_comment."</table></center>\n\t</body>", $rapport);
		else $rapport = preg_replace("/<center>\s*<br><br><table border=1 width=\d+%><tr><td align='left'><a href='post.php?\S+' target='_blank'>Laisser un message.<\/a><\/td><\/tr><tr><\!-- comment -->(.|\n|\r)+<\/center>\s*<\/body>/i", "\n\t</body>", $rapport);
	} else redirection("index.php?action=message&id_message=errordata&info");
	
	// suppression de la reponse si selectionné
	if(isset($pub_sup_reponse) && $pub_sup_reponse && isset($pub_reponse)) {
		$out = array();
		$out = split("<\|>", $pub_reponse);
		if(count($out)!=2) redirection("index.php?action=message&id_message=errordata&info");
		$rapport = str_replace("<tr><!-- reponse --><td class='c'>Réponse de <font size='2'><font color='lime'>".trim($out[0])."</font></font> le ".trim($out[1])."</td>", "<tr><!-- reponse --><td class='c'>supprimer ici</td>", $rapport);
		$rapport = preg_replace("/<tr><\!-- reponse --><td class='c'>supprimer ici<\/td>(.|\n|\r)+<\/th><\!-- fin de reponse --><\/tr>/Ui", "", $rapport);
	}
	
	// suppression du RC si modif
	if(file_exists($filename) && isset($pub_mod)) {
		unlink($filename);
	}
	
	if(file_exists($filename)) redirection("index.php?action=message&id_message=errorfatal&info");
	
	if (!$handle = fopen($filename, 'a')) {
         echo "Impossible d'ouvrir le fichier ($filename)";
         exit;
   	}
	
	if($flock) flock($handle, LOCK_EX);
	
	// Chmod du fichier:
	chmod ($filename, 0644);
	
	// Ecriture du RC
	if (fwrite($handle, $rapport) === FALSE) {
       	echo "Impossible d'écrire dans le fichier ($filename)";
       	exit;
   	}
	if($flock) flock($handle, LOCK_UN);
	fclose($handle);
	
	// sauvegarde dans la base de donnée
	if(!isset($pub_mod)) 
		$request = "INSERT INTO " . TABLE_RC_SAVE . "(user_id, rc_id, rc_comment, time) VALUES (" . $user_data["user_id"] . " , " . $r_id . ", '" . mysql_escape_string($commentaire) . "', " . time() . ")";
	else {
		$request = "UPDATE " . TABLE_RC_SAVE . " SET rc_comment='" . mysql_escape_string($commentaire) . "' WHERE user_id=".$user_data["user_id"]." AND rc_id=".$r_id;
		unset($pub_mod);
	}
		$db->sql_query($request);
}

// Suppression
if(isset($pub_delete) && is_numeric($pub_delete)) {

	$sql = "SELECT count(*) FROM ".TABLE_RC_SAVE." WHERE user_id=".$user_data["user_id"]." AND rc_id=".$pub_delete;
	$result = $db->sql_query($sql, false, true);
	list($row) = $db->sql_fetch_row($result);
	
	if($row!=0) {
		$sql = "DELETE FROM ".TABLE_RC_SAVE." WHERE user_id=".$user_data["user_id"]." AND rc_id=".$pub_delete;
		$db->sql_query($sql);
		
		if(file_exists("./mod/RC_save/datas/".$pub_delete.".html")) 
			unlink("./mod/RC_save/datas/".$pub_delete.".html");
	}
}

// Publier
if(isset($pub_publier) && is_numeric($pub_publier)) {

	$sql = "SELECT count(*) FROM ".TABLE_RC_SAVE." WHERE user_id=".$user_data["user_id"]." AND rc_id=".$pub_publier;
	$result = $db->sql_query($sql, false, true);
	list($row) = $db->sql_fetch_row($result);
	
	if($row!=0) {
		$sql = "UPDATE ".TABLE_RC_SAVE." SET public='1' WHERE user_id=".$user_data["user_id"]." AND rc_id=".$pub_publier;
		$db->sql_query($sql);
	}
}

// Dé-publier
if(isset($pub_de_publier) && is_numeric($pub_de_publier)) {

	$sql = "SELECT count(*) FROM ".TABLE_RC_SAVE." WHERE user_id=".$user_data["user_id"]." AND rc_id=".$pub_de_publier;
	$result = $db->sql_query($sql, false, true);
	list($row) = $db->sql_fetch_row($result);
	
	if($row!=0) {
		$sql = "UPDATE ".TABLE_RC_SAVE." SET public='0' WHERE user_id=".$user_data["user_id"]." AND rc_id=".$pub_de_publier;
		$db->sql_query($sql);
	}
}


// récup des données pour modification
if(isset($pub_mod) && is_numeric($pub_mod)) {
	
	$sql = "SELECT count(*) FROM ".TABLE_RC_SAVE." WHERE user_id=".$user_data["user_id"]." AND rc_id=".$pub_mod;
	$result = $db->sql_query($sql, false, true);
	list($row) = $db->sql_fetch_row($result);
	
	if($row==0) redirection("index.php?action=message&id_message=errordata&info");
	
	if(!file_exists("./mod/RC_save/datas/" . $pub_mod . ".html")) redirection("index.php?action=message&id_message=errordata&info");
	else {
		$filename = "./mod/RC_save/datas/" . $pub_mod . ".html";
		if (!$handle = fopen($filename, 'r')) {
			echo "Impossible d'ouvrir le fichier ($filename)";
			exit;
		}
		$RC_sources = "";
		while (!feof($handle)) {
			$RC_sources .= fgets($handle);
		}
		fclose($handle);
	}
	
	if(!preg_match("/<br><br><table border=1 width=100%><tr><td class='c'>Commentaires de l'auteur:/i" ,$RC_sources)) {
	
	if(preg_match("/<link\s+rel=\"stylesheet\"\s+type=\"text\/css\"\s+href=\"(\S*)formate.css\"\s*>/i", $RC_sources, $row)) 
		$skin = $row[1];
	
	if(preg_match("/<tr><\!-- comment --><td class='c'>Commentaires de l'auteur:<\/td><\/tr><tr><th>((?:.|\n|\r)+)<\/th><\!-- fin de comment --><\/tr>/i", $RC_sources, $row)) {
		$RC_sources_comment = $row[1];
		$RC_sources_comment = preg_replace("/<br( \/)?>/", "", $RC_sources_comment);
	}
	
	$sql = "SELECT rc_id, rc_comment FROM ".TABLE_RC_SAVE." WHERE user_id=".$user_data["user_id"]." AND rc_id=".$pub_mod;
	$result = $db->sql_query($sql);
	if(!(list($rc_id, $rc_comment) = $db->sql_fetch_row($result))) redirection("index.php?action=message&id_message=errordata&info");
	
	} else {
		echo "<script language='JavaScript' type='text/javascript'>alert(\"RC d'une ancienne version de RC Save, il n'est pas modifiable.\");</script>";
		unset($pub_mod);
	}
}
?>

<table width="90%">
<tr>
	<td class="c" align="center" colspan="7">Vos batailles sauvegardées:</td>
</tr>
<tr>
	<form action="index.php" method="post" name="form">
	<input type="hidden" name="action" value="rc_save">
	<?php if(isset($pub_mod) && is_numeric($pub_mod)) echo "<input type='hidden' name='mod' value='".$rc_id."'>"; ?>
	<th colspan="7">
		<table width="100%">
		<tr>
			<th width="50%">Edition des sources du RC:&nbsp;<?php echo help("RC_save_copy");?><br><textarea name="RC_sources" onBlur="javascript:del_script (this.form)"></textarea></th>
			<th rowspan='2'>
				<table>
					<tr>
						<th>Commentaire:&nbsp;<?php echo help("RC_save_com");?></th>
						<th><input type="text" name="comment" value='<?php echo (isset($rc_comment) ? $rc_comment : ""); ?>' size="50"></th>
					</tr>
					<tr>
						<th><input name="coord_active" type="checkbox" checked>&nbsp;Coordonnées.</th>
						<th>Remplacement si non coché: <input type="text" name="coord" value='x:XXX:x' size="19"></th>
					</tr>
					<tr>
						<th><input name="name_att_active" type="checkbox" checked>&nbsp;&nbsp;PSeudo attaquant.<br><input name="name_def_active" type="checkbox" checked>&nbsp;PSeudo defenseur.</th>
						<th>Remplacement si non coché: <input type="text" name="name" value='Xxxx' size="19"></th>
					</tr>
					<tr>
						<th><input name="techno_active" type="checkbox" checked>&nbsp;Technologies.</th>
						<th>&nbsp;</th>
					</tr>
					<tr>
						<th>Skin: </th>
						<th><input type="text" name="style" value='<?php echo (isset($skin) ? $skin : $link_css); ?>' size="50"></th>
					</tr>
				</table>
			</th>
		</tr>
		<tr>
			<th width="50%">Commentaire en fin de RC (html sans &lt;srcipt&gt; ni &lt;iframe&gt; autorisé):<br><textarea name="RC_sources_comment"><?php echo (isset($RC_sources_comment) ? $RC_sources_comment : ""); ?></textarea></th>
		</tr>
<?php
	if(isset($pub_mod) && isset($RC_sources)) {
		preg_match_all("|<\!-- reponse --><td class='c'>Réponse de <font size='[\-\d]+'><font color='\w+'>([^<]+)<\/font><\/font> le (\d{1,2}\/\d{1,2}\/\d{4}\sà\s\d{1,2}:\d{1,2}:\d{1,2})<\/td><\/tr>|U",
                 $RC_sources,
                 $out,
                 PREG_SET_ORDER);

		if(count($out)>0) {
			echo "<tr>\n\t\t\t<th><input type='checkbox' name='sup_reponse' /> &nbsp; Supprimer une reponse: &nbsp; ";
			echo "<select name='reponse'>";
			for($i=0; $i<count($out); $i++) {
				echo "<option value='".$out[$i][1]."<|>".$out[$i][2]."'>Réponse de ".$out[$i][1]." le ".$out[$i][2]."</option>";
			}
			echo "</select>";
			echo "\n\t\t\t</th>\n</tr>";
		}
	}
?>
		<tr>
			<th colspan="2"><input type='submit' value="<?php echo (isset($pub_mod) ? "Modifier le rapport" : "Ajouter un nouveau rapport"); ?>"></th>
		</tr>
		</table>
	</th>
	</form>
</tr>
<tr>
	<td colspan="6">&nbsp;</td>
</tr>
<?php
	if(isset($HTTP_SERVER_VARS)) $_SERVEUR = $HTTP_SERVER_VARS;
	
	if(empty($_SERVEUR)) $javascript = true;
	else $javascript = false;
	
	$sql = "SELECT rc_id, rc_comment, time, public FROM ".TABLE_RC_SAVE." WHERE user_id=".$user_data["user_id"]." ORDER BY time DESC";
		
	$result = $db->sql_query($sql);
	
	echo "<tr><td class='c'>public</td><td class='c'>id</td>";
	echo "<td class='c'>URL vers votre RC</td><td class='c'>Commentaire</td>";
	echo "<td class='c'>&nbsp;</td><td class='c'>&nbsp;</td><td class='c'>date</td></tr>";
		
	while( list($rc_id, $comment, $time, $public) = $db->sql_fetch_row($result) )
	{		
		echo "<tr><th><input type='checkbox' OnClick='javascript:publier($rc_id)' id='".$rc_id."_checkbox' ".($public==1?"checked":"")."></th><th>$rc_id</th>";
		if($javascript) {
			echo "<th><a id='".$rc_id."_link' href='mod/RC_save/datas/".$rc_id.".html' target='_blank'><div id='$rc_id'></div></a></th><th>".$comment."</th>";
			echo "<script language='JavaScript' type='text/javascript'>document.getElementById($rc_id).innerHTML=document.getElementById($rc_id+'_link').href;</script>";
		} else {
			echo "<th><a href='mod/RC_save/datas/".$rc_id.".html' target='_blank'>http://".$_SERVEUR['SERVER_NAME'].preg_replace("/index\.php\??\S*$/", "", $_SERVEUR['PHP_SELF'])."mod/RC_save/datas/".$rc_id.".html</a></th><th>".$comment."</th>";
		}

		echo "<th><a href='index.php?action=rc_save&mod=".$rc_id."'>Modifier</a></th><th><a href='javascript:validate_suppression(".$rc_id.")'>Supprimer</a></th><th>".date("d/m/Y H:i:s", $time)."</th></tr>";
	}
?>
</table>
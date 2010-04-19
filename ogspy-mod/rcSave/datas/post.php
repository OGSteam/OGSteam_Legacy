<?php
	@import_request_variables('GP', "pub_");
	if(!isset($pub_skin) || (isset($pub_skin) && !preg_match("/^http:\/\/[^\s<>]+\/$/", urldecode($pub_skin)))) $pub_skin = "http://80.237.203.201/download/use/epicblue/";
	
	if(!isset($pub_rc_id) || !is_numeric($pub_rc_id)) die("Pas de RC correspondent.");
	if(!file_exists($pub_rc_id.".html")) die("Pas de RC correspondent à cette id.");
	
	$flock = function_exists("flock");
	
	if(isset($pub_rc_id) && isset($pub_pseudo) && isset($pub_msg)) {
		$pub_msg = htmlentities(trim($pub_msg));
		$pub_msg = nl2br($pub_msg);
		$pub_pseudo = htmlentities(trim($pub_pseudo));
		$filename = $pub_rc_id . ".html";
		
		if($pub_pseudo!="" && $pub_msg!="" && file_exists($filename)) {
			
			if (!$handle = fopen($filename, 'r+')) {
				echo "Impossible d'ouvrir le fichier ($filename)";
				exit;
			}
			
			if($flock) flock($handle, LOCK_EX);
			
			$RC_sources = "";
			while (!feof($handle)) {
				$RC_sources .= fgets($handle);
			}
			
			$RC_sources = preg_replace("/<\/table>\s*<\/center>\s*<\/body>/i" , "<tr><!-- reponse --><td class='c'>Réponse de <font size='2'><font color='lime'>".$pub_pseudo."</font></font> le ".date ("j/n/Y à G:i:s", time())."</td></tr><tr><th>".$pub_msg."</th><!-- fin de reponse --></tr></table></center>\n\t</body>" , $RC_sources);
			
			// Chmod du fichier au cas où:
			chmod ($filename, 0644);
			
			if(rewind($handle)) {
				if (fwrite($handle, $RC_sources) === FALSE) {
					if($flock) flock($handle, LOCK_UN);
					fclose($handle);
					echo "Impossible d'écrire dans le fichier ($filename)";
					exit;
				}
			} else {
				if($flock) flock($handle, LOCK_UN);
				fclose($handle);
				
				$error = "Problème à la réécriture du fichier.";
				exit;
			}
			
			if($flock) flock($handle, LOCK_UN);
			fclose($handle);
			
			$error = "Message bien enregistré.";
		} else $error = "Données incorrectes ou manquantes.";
	}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo $pub_skin;?>formate.css" />
<title>Poster un commentaire</title>
</head>
<body><center>
<br><?php echo (isset($error) ? $error : ""); ?><br>
<form action="" method="POST">
<input type="hidden" name="rc_id" value="<?php echo $pub_rc_id;?>" />
	<table width="60%">
	<tr>
		<td class='c'>Poster un commentaire.<br><font size='-2'>Ni HTML, ni BBCode, ni smiley autorisé.</font></td>
	</tr>
	<tr>
		<th>
			Pseudo: &nbsp; <input type="text" name="pseudo" value='' />
		</th>
	</tr>
	<tr>
		<th>
			Message:<br>
			<textarea name="msg" rows="10"></textarea>
		</th>
	</tr>
	<tr>
		<th><input type="submit" value="Envoyer" /></th>
	</tr>
	</table>
</form>
</center></body>
</html>
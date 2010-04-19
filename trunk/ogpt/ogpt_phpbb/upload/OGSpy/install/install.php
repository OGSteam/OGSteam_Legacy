<?php
/***************************************************************************
*	filename	: install.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 26/12/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/
?>
<html>
<head>
<title>Installation OGSpy</title>
<link rel="stylesheet" type="text/css" href="../skin/OGSpy_skin/formate.css" />
</head>
<body>

<?php
define("IN_SPYOGAME", true);
define("INSTALL_IN_PROGRESS", true);

$error = "";
if (!is_writable("../parameters/id.php")) {
	$error .= "- Le fichier \"parameters/id.php\" n'est pas autorisé en écriture<br />";
}
if (!is_writable("../journal")) {
	$error .= "- Le répertoire \"journal\" n'est pas autorisé en écriture";
}
if ($error <> "") {
	echo "<b><font color='red'>Installation impossible :</font></b><br />";
	echo $error;
	echo "<br /><br />";
	echo "<i>Veuillez suivre la procédure d'installation dans son intégralité !!!</i>";
	exit();
}

require_once("../common.php");

function error_sql($message) {
	echo "<h3 align='center'><font color='red'>Erreur durant la procédure d'installation du serveur OGSpy</font></h3>";
	echo "<center><b>- ".$message."</b></center>";
	exit();
}

function installation_db($sgbd_server, $sgbd_dbname, $sgbd_username, $sgbd_password, $sgbd_tableprefix, $phpbb) {
	$db = new sql_db($sgbd_server, $sgbd_username, $sgbd_password, $sgbd_dbname);
	if (!$db->db_connect_id) error_sql("Impossible de se connecter à la base de données");

	//Création de la structure de la base de données
	$sql_query = @fread(@fopen("schemas/ogspy_structure.sql", 'r'), @filesize("schemas/ogspy_structure.sql")) or die("<h1>Le script sql d'installation est introuvable</h1>");

	$sql_query = preg_replace("#ogspy_#", $sgbd_tableprefix, $sql_query);

// plus nécessaire puisque les URLs relatives sont acceptées
//	$skin_link = "http://" . $_SERVER['HTTP_HOST'] . str_replace("install/install.php", "skin/OGSpy_skin/", $_SERVER['PHP_SELF']);
//	$sql_query = preg_replace("#skin\/OGSpy_skin\/#", $skin_link, $sql_query);

	$sql_query = explode(";", $sql_query);


	foreach ($sql_query as $request) {
		if (trim($request) != "") {
			if (!($result = $db->sql_query($request, false, false))) {
				$error = $db->sql_error($result);
				error_sql($error['message']);
			}
		}
	}

	generate_id($sgbd_server, $sgbd_dbname, $sgbd_username, $sgbd_password, $sgbd_tableprefix, $phpbb);
}

function generate_id($sgbd_server, $sgbd_dbname, $sgbd_username, $sgbd_password, $sgbd_tableprefix, $phpbb) {
	$id_php[] = '<?php';
	$id_php[] = '/***************************************************************************';
	$id_php[] = '*	filename	: id.php';
	$id_php[] = '*	generated	: '.date("d/M/Y H:i:s");
	$id_php[] = '***************************************************************************/';
	$id_php[] = '';
	$id_php[] = 'if (!defined("IN_SPYOGAME")) die("Hacking attempt");';
	$id_php[] = '';
	$id_php[] = '$table_prefix = "'.$sgbd_tableprefix.'";';
	$id_php[] = '$phpbb_table_prefix = "'.$phpbb.'";';
	$id_php[] = '';
	$id_php[] = '//Paramètres de connexion à la base de données';
	$id_php[] = '$db_host = "'.$sgbd_server.'";';
	$id_php[] = '$db_user = "'.$sgbd_username.'";';
	$id_php[] = '$db_password = "'.$sgbd_password.'";';
	$id_php[] = '$db_database = "'.$sgbd_dbname.'";';
	$id_php[] = '';
	$id_php[] = 'define("OGSPY_INSTALLED", TRUE);';
	$id_php[] = '?>';
	if (!write_file("../parameters/id.php", "w", $id_php)) {
		die("Echec installation, impossible de générer le fichier 'parameters/id.php'");
	}

	echo "<h3 align='center'><font color='yellow'>Installation du serveur OGSpy Beta 0.01 effectuée avec succès</font></h3>";
	echo "<center>";
	echo "<b>Pensez à supprimer le dossier 'install'</b><br />";
	echo "<a href='../../OGSMarket/install/'>Installer OGSMarket</a>";
	echo "</center>";
	exit();
}

if (isset($pub_sgbd_server) && isset($pub_sgbd_dbname) && isset($pub_sgbd_username) && isset($pub_sgbd_password) && isset($pub_sgbd_tableprefix) && isset($pub_phpbb)) {

	if (isset($pub_complete)) {
		if (!check_var($pub_admin_username, "Pseudo_Groupname", "", true) || !check_var($pub_admin_password, "Password", "", true)) {
			$pub_error = "Des caractères utilisés pour le nom d'utilisateur ou le mot de passe ne sont pas corrects";
		}
		else {
			if ($pub_sgbd_server != "" && $pub_sgbd_dbname != "" && $pub_sgbd_username != "") {
				installation_db($pub_sgbd_server, $pub_sgbd_dbname, $pub_sgbd_username, $pub_sgbd_password, $pub_sgbd_tableprefix, $pub_phpbb);
			}
			else {
				$pub_error = "Saisissez correctement les champs de connexion à la base de données et du compte administrateur";
			}
		}
	}
	elseif (isset($pub_file)) {
		if ($pub_sgbd_server != "" && $pub_sgbd_dbname != "" && $pub_sgbd_username != "") {
			generate_id($pub_sgbd_server, $pub_sgbd_dbname, $pub_sgbd_username, $pub_sgbd_password, $pub_sgbd_tableprefix, $pub_phpbb);
		}
		else {
			$pub_error = "Saisissez correctement les champs de connexion à la base de données";
		}
	}

	$sgbd_server = $pub_sgbd_server;
	$sgbd_dbname = $pub_sgbd_dbname;
	$sgbd_username = $pub_sgbd_username;
	$sgbd_password = $pub_sgbd_password;
	$sgbd_tableprefix = $pub_sgbd_tableprefix;
	$phpbb = $pub_phpbb;
}
?>
<table width="100%" align="center" cellpadding="20">
<tr>
	<td height="70"><div align="center"><img src="../images/OgameSpy2.jpg"></div></td>
</tr>
<tr>
	<td align="center">
		<table width="800">
		<tr>
			<td colspan="2" align="center"><font size="3"><b>Bienvenue à l'installation d'OGSpy version Beta 0.01</b></font></td>
		</tr>
		<tr>
			<td colspan="2" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><font color="Red"><b><?php echo isset($pub_error) ? $pub_error : "";?></b></font></td>
		</tr>
		<form method="POST" action="install.php">
		<tr>
			<td class="c" colspan="2">Configuration de la base de données</td>
		</tr>
		<tr>
			<th>Nom du Serveur de Base de données / SGBD</th>
			<th><input name="sgbd_server" type="text" value="<?php echo isset($pub_sgbd_server) ? $pub_sgbd_server : "";?>"></th>
		</tr>
		<tr>
			<th>Nom de votre base de données</th>
			<th><input name="sgbd_dbname" type="text" value="<?php echo isset($pub_sgbd_dbname) ? $pub_sgbd_dbname : "";?>"></th>
		</tr>
		<tr>
			<th>Nom d'utilisateur</th>
			<th><input name="sgbd_username" type="text" value="<?php echo isset($pub_sgbd_username) ? $pub_sgbd_username : "";?>"></th>
		</tr>
		<tr>
			<th>Mot de passe</th>
			<th><input name="sgbd_password" type="password"></th>
		</tr>
		<tr>
			<th>Préfixe des tables de OGSpy</th>
			<th><input name="sgbd_tableprefix" type="text" value="<?php echo isset($pub_sgbd_tableprefix) ? $pub_sgbd_tableprefix : "phpbb_ogspy_";?>"></th>
		</tr>
				<tr>
			<th>Préfixe des tables de phpBB</th>
			<th><input name="phpbb" type="text" value="<?php echo isset($pub_phpbb) ? $pub_phpbb : "phpbb_";?>"></th>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<th colspan="2"><input name="complete" type="submit" value="Démarrer l'installation complète">&nbsp;ou&nbsp;<input name="file" type="submit" value="Générer le fichier 'id.php'"></th>
		</tr>
		</form>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td colspan="2" align="center"><a target="_blank" href="http://www.ogsteam.fr/OGSpynstall/"><i><font color="orange">Besoin d'assistance ?</font></i></a></td>
		</tr>
		</table>
	</td>
</tr>
<tr align="center">
	<td>
		<center><font size="2"><i><b>OGSpy</b> is a <b>Kyser Software</b> (c) 2005-2006</i><br />v Beta 0.01</font></center>
	</td>
</tr>
</table>
</body>
<script language="JavaScript" src="../js/wz_tooltip.js"></script>
</html>
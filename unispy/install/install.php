<?php
/**
 * Script d'installation d'UniSpy
 * @author Kyser 
 * @link http://www.ogsteam.fr
 * @version 1.0 Beta
* @package UniSpy
 */

define("IN_SPYOGAME", true);
define("INSTALL_IN_PROGRESS", true);

// Retrieve installation language , french by default , cocorico.

$lang_install = "french";

if (!empty($_GET["lang"])) {
	$lang_install = $_GET["lang"];
}elseif (!empty($_POST["lang"])){
	$lang_install = $_POST["lang"];
}

$installation_version="1.0beta";
require_once("language/lang_$lang_install/lang_install.php");

?>
<html>
<head>
<title><?php echo $LANG["install_installtitle"];?></title>
<link rel="stylesheet" type="text/css" href="http://80.237.203.201/download/use/epicblue/formate.css" />
</head>
<body>

<?php
$error = "";
if (!is_writable("../parameters/id.php")) {
	$error .= $LANG["install_paramnotwritable"];
}
if (!is_writable("../journal")) {
	$error .= $LANG["install_journalnotwritable"];
}
if ($error <> "") {
	echo "<b><font color='red'>".$LANG["install_installnotpossible"]."</font></b><br />";
	echo $error;
	echo "<br /><br />";
	echo "<i>".$LANG["install_followinstructions"]."</i>";
	exit();
}

require_once("../common.php");

function error_sql($message,$query='') {
	global $LANG;
	echo "<h3 align='center'><font color='red'>".$LANG["install_installerror"]."</font></h3>";
	echo "<center><b>- ".$message."</b></center>";
	if (!empty($query)) {
		echo "<br><center>Query:<a>$query</a>";
	}
	exit();
}

function installation_db($sgbd_server, $sgbd_dbname, $sgbd_username, $sgbd_password, $sgbd_tableprefix, $admin_username, $admin_password, $admin_password2) {
	global $LANG;
	$db = new sql_db($sgbd_server, $sgbd_username, $sgbd_password, $sgbd_dbname);
	if (!$db->db_connect_id) error_sql($LANG["install_cantconnect"]);

	//Création de la structure de la base de données
	$sql_query = @fread(@fopen("schemas/unispy_structure.sql", 'r'), @filesize("schemas/unispy_structure.sql")) or die("<h1>".$LANG["install_noinstallscript"]."</h1>");

	$sql_query = preg_replace("#unispy_#", $sgbd_tableprefix, $sql_query);

	$skin_link = "http://" . $_SERVER['HTTP_HOST'] . str_replace("install/install.php", "skin/", $_SERVER['PHP_SELF']);
	$sql_query = preg_replace("#skin\/#", $skin_link, $sql_query);

	$sql_query = explode(";", $sql_query);


	foreach ($sql_query as $request) {
		if (trim($request) != "") {
			if (!($result = $db->sql_query($request, false, false))) {
				$error = $db->sql_error($result);
				error_sql($error['message'],$request);
			}
		}
	}

/*	if (isset($pub_lang)) {
		$interfacelang=$pub_lang;
	} else {
		$interfacelang="english";
	}

  $request="UPDATE ".$sgbd_tableprefix."config SET config_value = '$interfacelang' where config_name = 'language';";
  if (!($result = $db->sql_query($request, true, false))) {
    	$request="insert into ".$sgbd_tableprefix."config VALUES ('language', '$interfacelang')";
    	if (!($result = $db->sql_query($request, true, false))) {
    		$error = $db->sql_error($result);
    		error_sql($error['message']);
    	}
	}
*/
	$request = "insert into ".$sgbd_tableprefix."user (user_id, user_name, user_password, user_regdate, user_active, user_admin)".
	" values (1, '".mysql_real_escape_string($admin_username)."', '".md5(sha1($admin_password))."', ".time().", '1', '1')";
	if (!($result = $db->sql_query($request, false, false))) {
		$error = $db->sql_error($result);
		error_sql($error['message']);
	}

	$request = "insert into ".$sgbd_tableprefix."user_group (group_id, user_id) values (2, 1)";
	$db->sql_query($request);

	generate_id($sgbd_server, $sgbd_dbname, $sgbd_username, $sgbd_password, $sgbd_tableprefix);
}

function generate_id($sgbd_server, $sgbd_dbname, $sgbd_username, $sgbd_password, $sgbd_tableprefix) {
	global $LANG;

	$id_php[] = '<?php';
	$id_php[] = '/***************************************************************************';
	$id_php[] = '*	filename	: id.php';
	$id_php[] = '*	generated	: '.date("d/M/Y H:i:s");
	$id_php[] = '***************************************************************************/';
	$id_php[] = '';
	$id_php[] = 'if (!defined("IN_SPYOGAME")) die("Hacking attempt");';
	$id_php[] = '';
	$id_php[] = '$table_prefix = "'.$sgbd_tableprefix.'";';
	$id_php[] = '';
	$id_php[] = '//Paramètres connexion à la base de donnée';
	$id_php[] = '$db_host = "'.$sgbd_server.'";';
	$id_php[] = '$db_user = "'.$sgbd_username.'";';
	$id_php[] = '$db_password = "'.$sgbd_password.'";';
	$id_php[] = '$db_database = "'.$sgbd_dbname.'";';
	$id_php[] = '';
	$id_php[] = 'define("UNISPY_INSTALLED", TRUE);';
	$id_php[] = '?>';
	if (!write_file("../parameters/id.php", "w", $id_php)) {
		die($LANG["install_installfail"]);
	}

	echo "<h3 align='center'><font color='yellow'>".$LANG["install_installsuccess"]."</font></h3>";
	echo "<center>";
	echo "<b>".$LANG["install_deleteinstall"]."</b><br />";
	echo "<a href='../index.php'>".$LANG["install_back"]."</a>";
	echo "</center>";
	exit();
}

if (isset($pub_sgbd_server) && isset($pub_sgbd_dbname) && isset($pub_sgbd_username) && isset($pub_sgbd_password) && isset($pub_sgbd_tableprefix) &&
isset($pub_admin_username) && isset($pub_admin_password) && isset($pub_admin_password2)) {

	if (isset($pub_complete)) {
		if (!check_var($pub_admin_username, "Pseudo_Groupname", "", true) || !check_var($pub_admin_password, "Password", "", true)) {
			$pub_error = $LANG["install_badcharacters"];
		}
		else {
			if ($pub_sgbd_server != "" && $pub_sgbd_dbname != "" && $pub_sgbd_username != "" && $pub_admin_username != "" && $pub_admin_password != "" && $pub_admin_password == $pub_admin_password2) {
				installation_db($pub_sgbd_server, $pub_sgbd_dbname, $pub_sgbd_username, $pub_sgbd_password, $pub_sgbd_tableprefix, $pub_admin_username, $pub_admin_password, $pub_admin_password2);
			}
			else {
				$pub_error = $LANG["install_incompletedbform"];
			}
		}
	}
	elseif (isset($pub_file)) {
		if ($pub_sgbd_server != "" && $pub_sgbd_dbname != "" && $pub_sgbd_username != "") {
			generate_id($pub_sgbd_server, $pub_sgbd_dbname, $pub_sgbd_username, $pub_sgbd_password, $pub_sgbd_tableprefix);
		}
		else {
			$pub_error = $LANG["install_incompletedbform"];
		}
	}

	$sgbd_server = $pub_sgbd_server;
	$sgbd_dbname = $pub_sgbd_dbname;
	$sgbd_username = $pub_sgbd_username;
	$sgbd_password = $pub_sgbd_password;
	$sgbd_tableprefix = $pub_sgbd_tableprefix;
	$admin_username = $pub_admin_username;
	$admin_password = $pub_admin_password;
	$admin_password2 = $pub_admin_password2;
}
?>
<table width="100%" align="center" cellpadding="20">
<tr>
	<td height="70"><div align="center"><img src="../images/logo.png"></div></td>
</tr>
<tr>
	<td align="center">
		<table width="800">
		<tr>
		<td colspan="2" align="center"><font size="3"><b><?php echo $LANG["install_installtitle"]." ".$installation_version;?></b></font></td>
		</tr>
		<tr>
			<td colspan="2" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><font color="Red"><b><?php echo isset($pub_error) ? $pub_error : "";?></b></font></td>
		</tr>
		<form method="POST" action="install.php">
		<input type="hidden" name="lang" value="<?php echo $lang_install;?>">
		<tr>
			<td class="c" colspan="2"><?php $LANG["install_dbconfig"];?></td>
		</tr>
		<tr>
		<th><?php echo $LANG["install_dbhostname"];?></th>
			<th><input name="sgbd_server" type="text" value="<?php echo isset($pub_sgbd_server) ? $pub_sgbd_server : "";?>"></th>
		</tr>
		<tr>
		<th><?php echo $LANG["install_dbname"];?></th>
			<th><input name="sgbd_dbname" type="text" value="<?php echo isset($pub_sgbd_dbname) ? $pub_sgbd_dbname : "";?>"></th>
		</tr>
		<tr>
			<th><?php echo $LANG["install_dbusername"];?></th>
			<th><input name="sgbd_username" type="text" value="<?php echo isset($pub_sgbd_username) ? $pub_sgbd_username : "";?>"></th>
		</tr>
		<tr>
			<th><?php echo $LANG["install_dbpassword"];?></th>
			<th><input name="sgbd_password" type="password"></th>
		</tr>
		<tr>
			<th><?php echo $LANG["install_dbtableprefix"];?></th>
			<th><input name="sgbd_tableprefix" type="text" value="<?php echo isset($pub_sgbd_tableprefix) ? $pub_sgbd_tableprefix : "unispy_";?>"></th>
		</tr>
		<tr>
			<td class="c" colspan="2"><?php echo $LANG["install_adminconfigtitle"];?></td>
		</tr>
		<tr>
			<th><?php echo $LANG["install_adminloginname"];?>&nbsp;<?php echo help("profile_login", "", "../");?></th>
			<th><input name="admin_username" type="text" value="<?php echo isset($pub_admin_username) ? $pub_admin_username : "";?>"></th>
		</tr>
		<tr>
			<th><?php echo $LANG["install_adminpassword"];?>&nbsp;<?php echo help("profile_password", "", "../");?></th>
			<th><input name="admin_password" type="password"></th>
		</tr>
		<tr>
			<th><?php echo $LANG["install_adminpasswordconfirm"];?></th>
			<th><input name="admin_password2" type="password"></th>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
		<th colspan="2"><input name="complete" type="submit" value="<?php echo $LANG["install_startfullinstall"];?>">&nbsp;/ &nbsp;<input name="file" type="submit" value="<?php echo $LANG["install_generateidphp"];?>"></th>
		</tr>
		</form>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
		<td colspan="2" align="center"><a target="_blank" href="http://www.ogsteam.fr/"><i><font color="orange"><?echo $LANG["install_needhelp"];?></font></i></a></td>
		</tr>
		</table>
	</td>
</tr>
<tr align="center">
	<td>
	<center><font size="2"><i><b>UniSpy</b> is a <b>Kyser Software</b> (c) 2005-2006</i><br />v <?php echo $installation_version;?></font></center>
	</td>
</tr>
</table>
</body>
<script language="JavaScript" src="../js/wz_tooltip.js"></script>
</html>

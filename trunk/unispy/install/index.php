<?php
/***************************************************************************
*	filename	: index.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 07/01/2006
*	modified	: 06/08/2006 12:11:09
*	modified	: 13/11/2006 ericalens
***************************************************************************/

define("IN_SPYOGAME", true);
define("INSTALL_IN_PROGRESS", true);

require_once("../common.php");

// Retrieve installation language , french by default , cocorico.

$lang_install = "french";

if (!empty($_GET["lang"])) {
	$lang_install = $_GET["lang"];
}elseif (!empty($_POST["lang"])){
	$lang_install = $_POST["lang"];
}

require_once("language/lang_$lang_install/lang_install.php");


if (isset($pub_redirection)) {
	switch ($pub_redirection) {
		case "install";
		redirection("install.php?lang=$lang_install");
		break;
		
		case "upgrade";
		redirection("upgrade_to_latest.php?lang=$lang_install");
		break;
	}
}

?>
<html>
<head>
<title>UniSpy</title>
<link rel="stylesheet" type="text/css" href="http://80.237.203.201/download/use/epicblue/formate.css" />
</head>
<body>

<table width="100%" align="center" cellpadding="20">
<tr>
	<td height="70"><div align="center"><img src="../images/logo.png"></div></td>
</tr>
<tr>
	<td><div align="center">
<?php
$langfiles=languages_info();
foreach ($langfiles as $langfile){
        echo "\n<a href='?lang=".$langfile["name"]."' title='".$langfile["name"]."'>";
        if (empty($langfile["flag"])){
                echo $langfile["name"];
        } else {
                echo "<img src='".$langfile["flag"]."' alt='".$langfile["name"]."'>";
        }
        echo "</a>&nbsp;";
}
?>
	</div></td>
</tr>
<tr>
	<td align="center">
		<table>
		<tr>
		<td align="center"><font size="3"><b><?php echo $LANG["install_welcome"];?></b></font></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>	
			<td>
<font size="2">
<ul><li type="square"><?php echo $LANG["install_unispydesc1"];?><br />
<li type="square"><?php echo $LANG["install_unispydesc2"];?><br />
<ul><li type="disc"><?php echo $LANG["install_unispydesc3"];?><br />
<li type="disc"><?php echo $LANG["install_unispydesc4"];?><br>
<li type="disc"><?php echo $LANG["install_unispydesc5"];?>
</ul></ul>
	<center><?php echo $LANG["install_moreinfo"];?> <a href="http://www.ogsteam.fr/" target="_blank">http://www.ogsteam.fr/</a></center>
</font>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<form action="index.php" method="POST">
		<input type="hidden" name="lang" value="<?php echo $lang_install;?>">
		<tr>
			<td align="center"><font color="orange"><b><?php echo $LANG["install_chooseaction"];?> </b></font>
				<select name="redirection" onchange="this.form.submit();" onkeyup="this.form.submit();">
					<option></option>
					<option value="install"><?php echo $LANG["install_fullinstall"];?></option>
					<option value="upgrade"><?php echo $LANG["install_update"];?></option>
				</select>
			</td>
		</tr>
		</form>
		</table>
	</td>
</tr>
<tr align="center">
	<td>
		<center><font size="2"><i><b>UniSpy</b> is a <b>Kyser Software</b> (c) 2005-2006</i><br />v 1.1</font></center>
	</td>
</tr>
</table>
</body>
</html>

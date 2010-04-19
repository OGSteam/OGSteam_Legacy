<?php
/***************************************************************************
*	filename	: index.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 07/01/2006
*	modified	: 06/08/2006 12:11:09
***************************************************************************/

define("IN_OGSMARKET", true);
define("INSTALL_IN_PROGRESS", true);

require_once("../common.php");
if (isset($pub_redirection)) {
	switch ($pub_redirection) {
		case "install";
		redirection("install.php");
		break;
		
		case "upgrade";
		redirection("upgrade_to_latest.php");
		break;
	}
}

?>
<html>
<head>
<title>OGSMarket</title>
<link rel="stylesheet" type="text/css" href="http://80.237.203.201/download/use/epicblue/formate.css" />
</head>
<body>

<table width="100%" align="center" cellpadding="20">
<tr>
	<td height="70"><div align="center"><img src="../images/OgameSpy2.jpg"></div></td>
</tr>
<tr>
	<td align="center">
		<table>
		<tr>
			<td align="center"><font size="3"><b>Bienvenue sur le projet OGSMarket</b></font></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>	
			<td>
<font size="2">
<center>Si vous souhaitez plus d'information, rendez vous sur ce forum : <a href="http://ogs.servebbs.net/" target="_blank">http://ogs.servebbs.net/</a></center>
</font>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<form action="index.php" method="POST">
		<tr>
			<td align="center"><font color="orange"><b>Choisissez quel action vous désirez effectuer : </b></font>
				<select name="redirection" onchange="this.form.submit();" onkeyup="this.form.submit();">
					<option></option>
					<option value="install">Installation complète</option>
					<option value="upgrade">Mise à jour</option>
				</select>
			</td>
		</tr>
		</form>
		</table>
	</td>
</tr>
<tr align="center">
	<td>
		<center><font size="2"><i><b>OGSMarket</b> is a <b>OGSTeam Software</b> (c) 2005-2006</i><br />v 0.5</font></center>
	</td>
</tr>
</table>
</body>
</html>
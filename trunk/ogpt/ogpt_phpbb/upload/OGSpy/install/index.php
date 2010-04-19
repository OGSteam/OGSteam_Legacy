<?php
/***************************************************************************
*	filename	: index.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 07/01/2006
*	modified	: 06/08/2006 12:11:09
***************************************************************************/

define("IN_SPYOGAME", true);
define("INSTALL_IN_PROGRESS", true);

require_once("../common.php");
if (isset($pub_redirection)) {
	switch ($pub_redirection) {
		case "Installer";
		redirection("install.php");
		break;
	}
}

?>
<html>
<head>
<title>OGSpy</title>
<link rel="stylesheet" type="text/css" href="../skin/OGSpy_skin/formate.css" />
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
			<td align="center"><font size="3"><b>Bienvenue sur le projet OGSpy</b></font></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>	
			<td>
<font size="2">
<ul><li type="square">OGSPy est un projet qui a pour but d'enregistrer dans une base de données les coordonnées de tous les joueurs d'un univers.
<li type="square">Disposer d'un tel outil offre de multiples avantages pour une alliance ou un collectif :
<ul><li type="disc">Recensement de toutes les coordonnées libres selon plusieurs critères (galaxie, système solaire et rang)
<li type="disc">Recensement de toutes les planètes d'un joueur ou d'une ally. Information vitale durant les périodes de guerre
<li type="disc">Possibilités d'extensions quasi illimitées grâce aux mods
<li type="disc">Etc ...
</ul></ul>
<center>Si vous souhaitez plus d'informations, rendez-vous sur ce forum : <a href="http://www.ogsteam.fr/" target="_blank">http://www.ogsteam.fr/</a></center>
</font>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<form action="index.php" method="POST">
		<tr>
			<td align="center">
					<input name="redirection" type="submit" value="Installer">
				</select>
			</td>
		</tr>
		</form>
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
</html>

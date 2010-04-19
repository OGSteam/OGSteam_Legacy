<?php
/**
 * Fichier d'installation d'SpacSpy : ROOT/install/index.php 
 * @package SpacSpy
 * @subpackage install
 * @author Kyser
 * @copyright Copyright &copy; 2007, http://ogsteam.fr/
 * @version 0.1b
 * @since 0.1 - 26 sept. 07
 */

define("IN_SPACSPY", true);
define("INSTALL_IN_PROGRESS", true);

require_once("../common.php");
require_once("version.php");
if (isset($pub_redirection)) {
	switch ($pub_redirection) {
		case "install";
		redirection("install.php");
		break;
	
		case "upgrade";
		redirection("upgrade_to_latest.php?lang=$lang_install");
		break;
	}
}

?>
<html>
<head>
<title>SpacSpy</title>
<link rel="stylesheet" type="text/css" href="../skin/spacspy_skin/formate.css" />
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
			<td align="center"><font size="3"><b>Bienvenue sur le projet SpacSpy</b></font></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>	
			<td>
<font size="2">
<ul><li type="square">SpacSpy est un projet qui a pour but d'enregistrer dans une base de donn�es les coordonn�es de tous les joueurs d'un univers.
<li type="square">Disposer d'un tel outil offre de multiples avantages pour une alliance ou un collectif :
<ul><li type="disc">Recensement de toutes les coordonn�es libres selon plusieurs crit�res (galaxie, syst�me solaire et rang).
<li type="disc">Recensement de toutes les plan�tes d'un joueur ou d'une ally. Information vitale durant les p�riodes de guerre.
<li type="disc">Possibilit�s d'extensions quasi illimit�es gr�ce aux mods.
<li type="disc">Etc ...
</ul></ul>
<center>Si vous souhaitez plus d'informations, rendez-vous sur ce forum : <a href="www.spacsteam.fr/" target="_blank">http://ogsteam.fr/</a></center>
</font>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<form action="index.php" method="POST">
		<tr>
			<td align="center"><font color="orange"><b>Choisissez quelle action vous d�sirez effectuer : </b></font>
				<select name="redirection" onchange="this.form.submit();" onkeyup="this.form.submit();">
					<option></option>
					<option value="install">Installation compl�te</option>
					<option value="upgrade">Mise � jour</option>
				</select>
			</td>
		</tr>
		</form>
		</table>
	</td>
</tr>
<tr align="center">
	<td>
		<center><font size="2"><i><b>SpacSpy</b> is a <b>Kyser Software</b> (c) 2005-2007</i><br />v <?php echo $install_version ;?></font></center>
	</td>
</tr>
</table>
</body>
</html>

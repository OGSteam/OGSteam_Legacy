<?php
/***************************************************************************
*	filename	: about_changelog.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 17/01/2006
*	modified	: 06/08/2006 12:11:09
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
?>

<table width="70%" align="center">
<tr>
	<td align="center" class="c" colspan="2"><font color="Yellow">Site internet :</font> <a href="http://ogs.servebbs.net" target="_blank">http://ogs.servebbs.net</a><br /><font color="Yellow">Channel IRC : </font><a href='irc://irc.ogamenet.net:6667/ogstratege'>irc://irc.ogamenet.net:6667/ogstratege</a></td>
</tr>
<tr>
	<td class="c" width="50">Version</td>
	<td class="c">Description</td>
</tr>
<tr>
	<th>3.02b</th>
	<th style="text-align:left">
		- Correction de bugs mineurs<br />
	</th>
</tr>
<tr>
	<th>3.02</th>
	<th style="text-align:left">
		- Gestion des utilisateurs par groupe<br />
		- Cartographie alliance<br />
		- Am�lioration de l'interface par l'utilisation de tooltips<br />
		- Prise en compte des phalanges et portes spatiales<br />
		- Affichage des syst�mes solaires et lunes obsol�tes<br />
		- M�morisation de rapport d'espionnage dans l'espace personnel<br />
		- Optimisation du code pour de meilleurs d�lais de r�ponse<br />
		- Espace personnel enrichi avec affichage de graphique<br />
		- Calcul de la participation des membres dans la section statistiques<br />
		- Gestionnaire d'int�gration de mods<br />
		- Correction de bugs mineurs<br />
		<i>- Incompatibilit� avec les versions d'OGS ant�rieures � la 2.0</i><br />
	</th>
</tr>
<tr>
	<th>0.301b</th>
	<th style="text-align:left">
		- Correction mauvais affichage des joueurs absents<br />
		- Correction du bug emp�chant de rentrer le classement dans la p�riode 16h-24h<br />
		- Bug javascript emp�chant de faire des simulations avec Internet Explorer corrig�<br />
		- Correction de bugs mineurs<br />
	</th>
</tr>
<tr>
	<th>0.301</th>
	<th style="text-align:left">
		- Disponibilit� du script de migration des bases de donn�es OGSS -> OGSpy<br />
		- Nombre de satellites pass� � 5 chiffres dans l'espace personnel<br />
		- Ajout d'un nouveau crit�re de recherche selon les rapports d'espionnage (Merci ben.12)<br />
		- Possibilit� de visualiser plusieurs syst�mes sur une m�me page par l'interm�diaire de la page statistiques<br />
		- Optimisation de l'affichage du classement joueur<br />
		- Affichage des syst�mes mis � jour dans la section statistiques par secteur<br />
		- Correction bug exportation des rapports d'espionnage par syst�me qui envoyait tous les rapports connus vers OGS au lieu du syst�me demand�s<br />
		- Purge automatique des classements et des rapports d'espionnage selon l'anciennet� ou le nombre maximal autoris�. (Param�trable dans l'administration)<br />
		- Possibilit� de supprimer les classements au cas par cas<br />
		- Importation du classement directement sur le serveur<br />
		- Possibilit� d'avoir de nombreuses statistiques par le biais de BBClone<br />
		- Faille de s�curit� concernant les sessions corrig�es
	</th>
</tr>
<tr>
	<th>0.300f</th>
	<th style="text-align:left">
		- Les rapports d'espionnage sont affich�s du plus r�cent au plus ancien<br />
		- Message dans le journal lorsque l'on envoie le classement<br />
		- Exportation de rapports d'espionnage selon une date<br />
		- Correction du bug d'affichage classement<br />
		- R�sum� apr�s envoi de rapports d'espionnage<br />
		- Correction du bug de recherche qui emp�chait les pages suivantes avec comme un crit�re diff�rent des coordonn�es<br />
		- Correction bug dans l'espace personnel, calcul de la production d'�nergie et de deut�rium fauss�e
	</th>
</tr>
<tr>
	<th>0.300e</th>
	<th style="text-align:left">
		- Correction du bug de recherche qui n'affichait pas les pages avec IE<br />
		- Correction du bug de non compatibilit� de requetes SQL avec certains serveurs MySQL<br />
		- Affichage PHPInfo - Module PHP dans l'administration<br />
		- Correction bug gestion empire (apparition des plan�tes d'autres joueurs apr�s modification)<br />
		- Possibilit� de param�trer le lien du forum affich� sur le menu par l'administration<br />
		- Correction du bug d'importation de certains rapports d'espionnage<br />
		- Possibilit� de contr�ler que le serveur soit � jour dans l'administration
	</th>
</tr>
<tr>
	<th>0.300d</th>
	<th style="text-align:left">
		- Correction du bug du panneau d'administration et de connexion avec OGS li� � un champ manquant dans la base de donn�es<br />
		- Correction bug de recherche des joueurs sans ally<br />
		- Correction du bug dans l'espace personnel au sujet du nombre de cases utilis�es par plan�te
	</th>
</tr>
<tr>
	<th>0.300c</th>
	<th style="text-align:left">
		- Correction du bug d'importation des rapports d'espionnage<br />
		- Correction bug emp�chant de modifier les param�tres serveur selon la configuration d'installation employ�e pour OGSpy<br />
		- Correction de bugs mineurs
	</th>
</tr>
<tr>
	<th>0.300b</th>
	<th style="text-align:left">
		- Modification des requ�tes incompatibles avec MySQL 4.0
	</th>
</tr>
<tr>
	<th>0.300</th>
	<th style="text-align:left">
		- Restructuration int�grale du code<br />
		- Nouvelle interface utilisateur<br />
	</th>
</tr>
</table>
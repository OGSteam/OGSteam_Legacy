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
		- Amélioration de l'interface par l'utilisation de tooltips<br />
		- Prise en compte des phalanges et portes spatiales<br />
		- Affichage des systèmes solaires et lunes obsolètes<br />
		- Mémorisation de rapport d'espionnage dans l'espace personnel<br />
		- Optimisation du code pour de meilleurs délais de réponse<br />
		- Espace personnel enrichi avec affichage de graphique<br />
		- Calcul de la participation des membres dans la section statistiques<br />
		- Gestionnaire d'intégration de mods<br />
		- Correction de bugs mineurs<br />
		<i>- Incompatibilité avec les versions d'OGS antérieures à la 2.0</i><br />
	</th>
</tr>
<tr>
	<th>0.301b</th>
	<th style="text-align:left">
		- Correction mauvais affichage des joueurs absents<br />
		- Correction du bug empêchant de rentrer le classement dans la période 16h-24h<br />
		- Bug javascript empêchant de faire des simulations avec Internet Explorer corrigé<br />
		- Correction de bugs mineurs<br />
	</th>
</tr>
<tr>
	<th>0.301</th>
	<th style="text-align:left">
		- Disponibilité du script de migration des bases de données OGSS -> OGSpy<br />
		- Nombre de satellites passé à 5 chiffres dans l'espace personnel<br />
		- Ajout d'un nouveau critère de recherche selon les rapports d'espionnage (Merci ben.12)<br />
		- Possibilité de visualiser plusieurs systèmes sur une même page par l'intermédiaire de la page statistiques<br />
		- Optimisation de l'affichage du classement joueur<br />
		- Affichage des systèmes mis à jour dans la section statistiques par secteur<br />
		- Correction bug exportation des rapports d'espionnage par système qui envoyait tous les rapports connus vers OGS au lieu du système demandés<br />
		- Purge automatique des classements et des rapports d'espionnage selon l'ancienneté ou le nombre maximal autorisé. (Paramétrable dans l'administration)<br />
		- Possibilité de supprimer les classements au cas par cas<br />
		- Importation du classement directement sur le serveur<br />
		- Possibilité d'avoir de nombreuses statistiques par le biais de BBClone<br />
		- Faille de sécurité concernant les sessions corrigées
	</th>
</tr>
<tr>
	<th>0.300f</th>
	<th style="text-align:left">
		- Les rapports d'espionnage sont affichés du plus récent au plus ancien<br />
		- Message dans le journal lorsque l'on envoie le classement<br />
		- Exportation de rapports d'espionnage selon une date<br />
		- Correction du bug d'affichage classement<br />
		- Résumé après envoi de rapports d'espionnage<br />
		- Correction du bug de recherche qui empêchait les pages suivantes avec comme un critère différent des coordonnées<br />
		- Correction bug dans l'espace personnel, calcul de la production d'énergie et de deutérium faussée
	</th>
</tr>
<tr>
	<th>0.300e</th>
	<th style="text-align:left">
		- Correction du bug de recherche qui n'affichait pas les pages avec IE<br />
		- Correction du bug de non compatibilité de requetes SQL avec certains serveurs MySQL<br />
		- Affichage PHPInfo - Module PHP dans l'administration<br />
		- Correction bug gestion empire (apparition des planètes d'autres joueurs après modification)<br />
		- Possibilité de paramétrer le lien du forum affiché sur le menu par l'administration<br />
		- Correction du bug d'importation de certains rapports d'espionnage<br />
		- Possibilité de contrôler que le serveur soit à jour dans l'administration
	</th>
</tr>
<tr>
	<th>0.300d</th>
	<th style="text-align:left">
		- Correction du bug du panneau d'administration et de connexion avec OGS lié à un champ manquant dans la base de données<br />
		- Correction bug de recherche des joueurs sans ally<br />
		- Correction du bug dans l'espace personnel au sujet du nombre de cases utilisées par planète
	</th>
</tr>
<tr>
	<th>0.300c</th>
	<th style="text-align:left">
		- Correction du bug d'importation des rapports d'espionnage<br />
		- Correction bug empêchant de modifier les paramètres serveur selon la configuration d'installation employée pour OGSpy<br />
		- Correction de bugs mineurs
	</th>
</tr>
<tr>
	<th>0.300b</th>
	<th style="text-align:left">
		- Modification des requêtes incompatibles avec MySQL 4.0
	</th>
</tr>
<tr>
	<th>0.300</th>
	<th style="text-align:left">
		- Restructuration intégrale du code<br />
		- Nouvelle interface utilisateur<br />
	</th>
</tr>
</table>
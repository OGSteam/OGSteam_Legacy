<?php
/** $Id$ **/
/**
* Affichage du Changelog d'OGSpy : Changements version après version
* @package OGSpy
* @version 3.04b ($Rev$)
* @subpackage views
* @author Kyser
* @created 17/01/2006
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @modified $Date$
* @link $HeadURL$
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
?>

<table width="70%" align="center">
<tr>
	<td align="center" class="c" colspan="2"><font color="Yellow">Notes de version</font></td>
</tr>
<tr>
	<td class="c" width="50">Version</td>
	<td class="c">Description</td>
</tr>
<tr>
	<th>3.07</th>
	<th style="text-align:left">
    - Remplacement de la technologie Expéditions par Astrophysique<br />
	  - Support d'un nombre de planètes supérieur à 9(Désormais lié à la Technologie Astrophysique)<br />
    - Désactivation de l'import par copier - coller<br />
	  - Remise à jour des Liens vers les sites de l'OGSteam<br />
	  - Nouvelle Gestion des Id Planètes <br />
        - Mise a jour des diverses formules de calcul <br />
        - Mise en conformité réglement ogame v1 <br />
  </th>
</tr>
<tr>
	<th>3.06</th>
	<th style="text-align:left">
    - Non Publiée<br />
	</th>
</tr>
<tr>
	<th>3.05</th>
	<th style="text-align:left">
    - Compatibilité avec OGame 0.78c<br />
    - Depots de ravitaillement (optionnel)<br />
    - Vitesse de l'univers paramètrable<br />
    - Ajout des expéditions<br />
    - RC directement parsé dans OGSpy<br />
    - Changement de la structure de la base de donnée (optimisation ++++)<br />
    - Affichage des RC enregistrés directement sur la vue galaxie<br />
	</th>
</tr>
<tr>
	<th>3.04b</th>
	<th style="text-align:left">
		- Suppression du fond transparent pour l'ajout des membres (admin)<br />
		- Ajout de flag admin paramétrables sur les mods <br />
		- Ajout d'une option de journalisation des erreurs php<br />
		- autoupdate: descriptions des mods, plus d'infos sur les droits d'ecritures<br />
		- Ajout d'une table de configuration pour les mods avec les fonctions appropriés<br />
		- Correction bug sur recherche "stricte" <br />
		- Correction du bug de droits insuffisants pour copier/coller les infos<br />
		- Amélioration securité<br />
		- Correction bug "Illegal mix of collations" <br />
		- Correction bug d'ajout de membres <br />
	</th>
</tr>
<tr>
	<th>3.04</th>
	<th style="text-align:left">
		- Ajout du mod_Xtense à la base d'OGSpy<br />
		- Ajout du mod_autoupdate à la base d'OGSpy<br />
		- Ajout d'une fonction "Ajouter tout les membres" pour les groupes<br />
		- Correction de bugs lié au passage d'Ogame en version 0.77b<br />
	</th>
</th>
<tr> 
	<th>3.03</th> 
	<th style="text-align:left"> 
		- Mise en place du choix de galaxies et de sytèmes par galaxies<br/>
	</th>
</tr>
<tr> 
	<th>3.02c</th> 
	<th style="text-align:left"> 
		- Ordonnancement des mods dans l'administration<br /> 
		- Assouplissement des contrôles sur l'injection de systèmes solaires et rapport d'espionnage<br /> 
		- Modifications mineures de l'interface de l'administration<br /> 
		- Possibilité de désactiver le contrôle des adresses IP provoquant des déconnexions intempestives (AOL, Proxy, etc)<br /> 
		- Correction d'anomalies diverses<br /> 
	</th>
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
		- Espace personnel enrichi avec affichage de graphiques<br />
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
		- Correction bug exportation des rapports d'espionnage par système qui envoyait tous les rapports connus vers OGS au lieu du système demandé<br />
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
		- Affichage PHPInfo - Modules PHP dans l'administration<br />
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

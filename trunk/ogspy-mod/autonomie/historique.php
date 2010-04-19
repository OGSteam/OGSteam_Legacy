<?php
/***********************************************************************
 * filename	:	historique.php
 * desc.	:	historique
 * created	: 	06/11/2006 Mirtador
 * @package autonomie
 * @author Mirtador
* @author oXid_FoX
 * @link http://www.ogsteam.fr
 *
 * *********************************************************************/
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
require_once("views/page_header.php");
echo "<table width='100%'>";
?>
<th colspan="2">Historique</th>
</table>
<table width="100%">
<th>Version</th><th>Modifications</th>
<tr>
<th><font color="#FF0000">1</font></th>
<td><ul>
<li>Sortie du mod Autonomie.</li>
</ul></td>
</tr>
<tr>
<th><font color="#FF0000">1.0a</font></th>
<td><ul>
<li>Réglage du bug lors du calcul du hangar a augmenter.</li>
</ul></td>
</tr>
<tr>
<th><font color="#FF0000">1.0b</font></th>
<td><ul>
<li>Réglage du bug du menu, il n'apparait plus en tant que "convertisseur".</li>
</ul></td>
</tr>
<tr>
<th><font color="#FF0000">1.1</font></th>
<td><ul>
<li>Ajout du code de couleur qui indique le risque de perte de ressources.</li>
<li>Ajout du calcul des transporteurs.</li>
<li>Ajout de la vue d'ensemble de l'empire côté hangars.</li>
<li>Amélioration de la page historique.</li>
</ul></td>
</tr>
<tr>
<th><font color="#FF0000">1.1b</font></th>
<td><ul>
<li>Correction de l'orthographe.</li>
<li>Correction du numéro de version et du nom du mod (dans le bas de page).</li>
<li>Correction de la désinstallation.</li>
<li>Quelques améliorations du code.</li>
</ul></td>
</tr>
<tr>
<th><font color="#FF0000">1.2</font></th>
<td><ul>
<li>Correction de l'orthographe dans le code</li>
<li>MAJ des champs PHPDoc ( @package, @author, @link )</li>
<li>Suppression des liens javascripts</li>
<li>Petite correction de la production (en rapport avec la production de base par planète)</li>
<li>Prise en compte de la température</li>
<li>Grosse correction des tableaux HTML</li>
<li>Tentative d'aération du code html généré...</li>
<li>Changement des temps : jours à la place des heures pour les durées >= 72h</li>
<li>MAJ du numéro de version automatique (pour install.php et update.php)</li>
</ul></td>
</tr>
<tr>
<th><font color="#FF0000">1.3</font></th>
<td><ul>
<li>Correction d'erreurs de type notice.</li>
<li>Détection du mod actif automatique.</li>
<li>Prise en compte de l'absence de synthétiseur de deutérium.</li>
<li>Correction des totaux des PT/GT (changement de la méthode de calcul).</li>
<li>Ajout des "title" contenant le temps en heures (lorsque le temps est affiché en jours) pour la colonne "Temps d'autonomie de la planète".</li>
<li>Arrondi supérieur pour le calcul des transporteurs.</li>
<li>Correction des transporteurs minimum lorsqu'un synthétiseur n'existe pas (niveau zéro).</li>
<li>Changement du seuil de "longue autonomie" (48h au lieu de 36h).</li>
</ul></td>
</tr>
<th><font color="#FF0000">1.4</font></th>
<td><ul>
<li>Refonte totale des calculs de production (repris du mod OGSign & du mod Production) : prise en compte des pourcentages de production, des centrales à fusion qui consomment le deut, des ratios lorsqu'il y a un manque d'énergie...</li>
</ul></td>
</tr>
<tr>
<th><font color="#FF0000">1.5</font></th>
<td><ul>
<li>Mise en place d'une fonction pour multiplier la production pour l'univers 50.</li>
note: Il faut modifier dans le code à la 18ème ligne le chiffre pour le faire. Dans la prochaine version on pourra le paramétrer dans l'administration
<li>Ajout du contenu du fichier info dans la signature (essentiellement pour nommer oXid_FoX qui a refait totalement les calculs)</li>
</ul></td>
</tr>
<tr>
<th><font color="#FF0000">1.5b</font></th>
<td><ul>
<li>Correction du bug qui faisait que l'autonomie globale de la planète est recopiée depuis la planète précédente.</li>
</ul></td>
</tr>
</table>

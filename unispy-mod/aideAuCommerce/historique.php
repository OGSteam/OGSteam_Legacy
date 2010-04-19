<?php
/***********************************************************************
 * filename	:	Convertisseur.php
 * desc.	:	Fichier principal
 * created	: 	06/11/2006 Mirtador
 *
 * *********************************************************************/
if (!defined('IN_SPYOGAME') && !defined('IN_UNISPY2')) {
	die("Hacking attempt");
}
if(!defined('IN_UNISPY2'))
	require_once("views/page_header.php");
echo "<table width='100%'>";
?>
<th colspan="2">Historique</th>
</table>
<table>
<th>Version</th><th>Modification</th>
<?php //version 1.6e?>
<tr><th><font color="#FF0000">1.6e</font></th>
<th>-Adaptation du module pour e-univers, d'ou la version 1.6e
<p style="margin-top: 0; margin-bottom: 0">-Modification de l'ordre d'affichage de l'historique des versions, afin de voir tout de suite les dernières modifs apportés</p>
<p style="margin-top: 0; margin-bottom: 0">-Adaptation des capacités des transporteurs PT-5 et GT-50 d'e-univers, différents d'oGame</p>
<p style="margin-top: 0; margin-bottom: 0">-Modification des unités : Unitée, Kilo, Million devient Kilo, Million, Giga</p>
<p style="margin-top: 0; margin-bottom: 0">-Cette version date du 12/08/2008 et c'est la première version pour UniSpy testé sur la v1.1</p>
</th>
</tr>
<?php //version 1.6 ?>
<tr><th><font color="#FF0000">1.6</font></th>
<th>-Ajout d'un sélectioneur automatique pour le BBcode
<p style="margin-top: 0; margin-bottom: 0">-Correction du calcul des petits Transporteurs pour qu'il donne un nombre entier</p>
<p style="margin-top: 0; margin-bottom: 0">-Correction des dernières erreurs d'orthographe</p>
</th>
</tr>
<?php //version 1.5 ?>
<tr><th><font color="#FF0000">1.5</font></th>
<th>-Amélioration de la sécurité: maintenant les utilisateurs ne peuvent plus mettre autre chose que des chiffres et les unités
<p style="margin-top: 0; margin-bottom: 0">-Maintenant, vous pouvez mettre votre unité dans votre demande sous forme de mot, exemple: million, kilo, K, KK, M</p>
<p style="margin-top: 0; margin-bottom: 0">-Le convertisseur BBcode affiche maintenant l'unité</p>
<p style="margin-top: 0; margin-bottom: 0">-Vous pouvez à nouveau mettre l'unité de votre choix pour le résultat</p>
<p style="margin-top: 0; margin-bottom: 0">-Ajout de l'option de choix de la couleur du forum pour le BBcode</p>
</th>
</tr>
<?php //version 1.4 ?>
<tr><th><font color="#FF0000">1.4</font></th>
<th>-Corection du bug des transporteurs
<p style="margin-top: 0; margin-bottom: 0">-Correction des taux: ils marchent comme ceux de Ogame en général maintenant, merci à Ouranos ;)</p>
<p style="margin-top: 0; margin-bottom: 0">-Ajout d'un convertisseur BBcode qui fait une mise en forme de vos offres.</p>
<p style="margin-top: 0; margin-bottom: 0">-Maintenant le résultat n'apparaît que si vous avez fait un calcul.</p>
<p style="margin-top: 0; margin-bottom: 0">-Mise en page du code de la page historique refaite, il est maintenant beaucoup plus lisible...</p>
<p style="margin-top: 0; margin-bottom: 0">-Optimisation du code de l'historique</p>
</th>
</tr>
<?php //version 1.3 ?>
<tr><th><font color="#FF0000">1.3</font></th>
<th>
<p style="margin-top: 0; margin-bottom: 0">-Correction du update</p>
<p style="margin-top: 0; margin-bottom: 0">-Correction d'une erreur d'orthographe</p>
<p style="margin-top: 0; margin-bottom: 0">-Correction de l'historique</p>
<p style="margin-top: 0; margin-bottom: 0">-Correction du bug du menu: maintenant il noircit la page sur la quel vous êtes même si vous venez de rentré sur le simulateur</p>
<p style="margin-top: 0; margin-bottom: 0">-Ajout des info-bulles</p>
</th>
</tr>
<?php //version 1.2 ?>
<tr><th><font color="#FF0000">1.2</font></th>
<th>
<p style="margin-top: 0; margin-bottom: 0">-Le mod marche maintenant sur Wamp</p>
<p style="margin-top: 0; margin-bottom: 0">-Ajout du choix de l'unité des ressources</p>
<p style="margin-top: 0; margin-bottom: 0">-Ajout du simulateur de nombre de transporteurs</p>
<p style="margin-top: 0; margin-bottom: 0">-Maintenant, les champs remplis restent remplis</p>
<p style="margin-top: 0; margin-bottom: 0">-Maintenant, les résultats sont arrondis</p>
</th>
</tr>
<?php //version 1.1 ?>
<tr><th><font color="#FF0000">1.1</font></th>
<th>
<p style="margin-top: 0; margin-bottom: 0">-Correction des erreurs d'orthographe </p>
<p style="margin-top: 0; margin-bottom: 0">-Suppression d'un fichier inutile</p>
<p style="margin-top: 0; margin-bottom: 0">-Ajout des messages d'erreur</p>
<p style="margin-top: 0; margin-bottom: 0">-Amélioration de la mise en page</p>
</th>
</tr>
<?php //version 1 ?>
<tr><th><font color="#FF0000">1</font></th>
<th>
<p style="margin-top: 0; margin-bottom: 0">-Sortie du mod Aide au commerce</p>
</th>
</tr>
<?php //version 0.2 ?>
<tr><th><font color="#FF0000">0.2</font></th>
<th>
<p style="margin-top: 0; margin-bottom: 0">-Intégration du convertisseur au market</p>
</th>
</tr>
<?php //version 0.1 ?>
<tr><th><font color="#FF0000">0.1</font></th>
<th>
<p style="margin-top: 0; margin-bottom: 0">-Sortie du Convertisseur de ressources</p>
</th>
</tr>
<?php
require_once("pieddepage.php");
?>
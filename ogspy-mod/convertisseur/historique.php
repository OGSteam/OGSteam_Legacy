<?php
/**
* historique.php
* @package convertisseur
* @author Mirtador
* @link http://www.ogsteam.fr
* created : 06/11/2006
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

echo "<table width='100%'>";
?>
<th colspan="2">Historique</th>
</table>
<table>
<th>Version</th><th>Modification</th>
<!-- version 0.1 -->
<tr><th><font color="#FF0000">0.1</font></th>
<th>
<p style="margin-top: 0; margin-bottom: 0">-Sortie du Convertisseur de ressources</p>
</th>
</tr>
<!-- version 0.2 -->
<tr><th><font color="#FF0000">0.2</font></th>
<th>
<p style="margin-top: 0; margin-bottom: 0">-Int�gration du convertisseur au market</p>
</th>
</tr>
<!-- version 1 -->
<tr><th><font color="#FF0000">1</font></th>
<th>
<p style="margin-top: 0; margin-bottom: 0">-Sortie du mod Aide au commerce</p>
</th>
</tr>
<!-- version 1.1 -->
<tr><th><font color="#FF0000">1.1</font></th>
<th>
<p style="margin-top: 0; margin-bottom: 0">-Correction des erreurs d'orthographe</p>
<p style="margin-top: 0; margin-bottom: 0">-Suppression d'un fichier inutile</p>
<p style="margin-top: 0; margin-bottom: 0">-Ajout des messages d'erreur</p>
<p style="margin-top: 0; margin-bottom: 0">-Am�lioration de la mise en page</p>
</th>
</tr>
<!-- version 1.2 -->
<tr><th><font color="#FF0000">1.2</font></th>
<th>
<p style="margin-top: 0; margin-bottom: 0">-Le mod marche maintenant sur Wamp</p>
<p style="margin-top: 0; margin-bottom: 0">-Ajout du choix de l'unit� des ressources</p>
<p style="margin-top: 0; margin-bottom: 0">-Ajout du simulateur du nombre de transporteurs</p>
<p style="margin-top: 0; margin-bottom: 0">-Les champs remplis restent maintenant remplis</p>
<p style="margin-top: 0; margin-bottom: 0">-Les r�sultats sont maintenant arrondis</p>
</th>
</tr>
<!-- version 1.3 -->
<tr><th><font color="#FF0000">1.3</font></th>
<th>
<p style="margin-top: 0; margin-bottom: 0">-Correction du update</p>
<p style="margin-top: 0; margin-bottom: 0">-Correction d'une erreur d'orthographe</p>
<p style="margin-top: 0; margin-bottom: 0">-Correction de l'historique</p>
<p style="margin-top: 0; margin-bottom: 0">-Correction du bug du menu: maintenant il noircit la page sur laquelle vous �tes m�me si vous venez de rentrer sur le simulateur</p>
<p style="margin-top: 0; margin-bottom: 0">-Ajout des info-bulles</p>
</th>
</tr>
<!-- version 1.4 -->
<tr><th><font color="#FF0000">1.4</font></th>
<th>
<p style="margin-top: 0; margin-bottom: 0">-Corection du bug des transporteurs</p>
<p style="margin-top: 0; margin-bottom: 0">-Correction des taux: ils marchent comme ceux de OGame en g�n�ral maintenant, merci � Ouranos ;)</p>
<p style="margin-top: 0; margin-bottom: 0">-Ajout d'un convertisseur BBcode qui fait une mise en forme de vos offres.</p>
<p style="margin-top: 0; margin-bottom: 0">-Maintenant le r�sultat n'appara�t que si vous avez fait un calcul.</p>
<p style="margin-top: 0; margin-bottom: 0">-Mise en page du code de la page historique refaite, il est maintenant beaucoup plus lisible...</p>
<p style="margin-top: 0; margin-bottom: 0">-Optimisation du code de l'historique</p>
</th>
</tr>
<!-- version 1.5 -->
<tr><th><font color="#FF0000">1.5</font></th>
<th>
<p style="margin-top: 0; margin-bottom: 0">-Am�lioration de la s�curit�: maintenant les utilisateurs ne peuvent plus mettre autre chose que des chiffres et les unit�s</p>
<p style="margin-top: 0; margin-bottom: 0">-Maintenant, vous pouvez mettre votre unit� dans votre demande sous forme de mot, exemple: million, kilo, K, KK, M</p>
<p style="margin-top: 0; margin-bottom: 0">-Le convertisseur BBcode affiche maintenant l'unit�</p>
<p style="margin-top: 0; margin-bottom: 0">-Vous pouvez � nouveau mettre l'unit� de votre choix pour le r�sultat</p>
<p style="margin-top: 0; margin-bottom: 0">-Ajout de l'option de choix de la couleur du forum pour le BBcode</p>
</th>
</tr>
<!-- version 1.6 -->
<tr><th><font color="#FF0000">1.6</font></th>
<th>
<p style="margin-top: 0; margin-bottom: 0">-Ajout d'un s�lectionneur automatique pour le BBcode</p>
<p style="margin-top: 0; margin-bottom: 0">-Correction du calcul des petits transporteurs pour qu'il donne un nombre entier</p>
<p style="margin-top: 0; margin-bottom: 0">-Correction des derni�res erreurs d'orthographe</p>
</th>
</tr>
<?php
require_once("pieddepage.php");
?>

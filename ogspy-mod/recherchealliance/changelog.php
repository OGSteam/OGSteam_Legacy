<?php
/**
* @Page principale du module
* @package rechercheAlly
* @Créateur du script Aeris
* @link http://www.ogsteam.fr
*
* @Modifier par Kazylax
* @Site internet www.kazylax.net
* @Contact kazylax-fr@hotmail.fr
*
 */
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

require_once("views/page_header.php");
require_once("menu.php");
?>
<table width="%100">
<th width="104">Version</th><th width="476">Modification</th>
<?php //version 1.0 ?>
</tr>

<?php //version 1.1 ?>
<tr><th width="104" height="8"><font color="#FF0000">1.5 by Shad</font></th>
<th width="476" height="8">
        <p align="left">- Mise à niveau pour OGSpy 3.0.7.</p>
		<p style="margin-top: 0; margin-bottom: 0" align="left">- Mise à jour des univers.</p>

</th>

</tr>

<?php //version 1.1 ?>
<tr><th width="104" height="8"><font color="#FF0000">1.4</font></th>
<th width="476" height="8">
        <p align="left">- Module compatible avec le Register_Globals OFF.<p style="margin-top: 0; margin-bottom: 0" align="left">- Correction de l'affichage
        des BBcodes.</p>

</th>

</tr>
<?php //version 1.1 ?>
<tr><th width="104" height="8"><font color="#FF0000">1.3</font></th>
<th width="476" height="8">
        <p align="left">- Modification de la page info.txt.<p style="margin-top: 0; margin-bottom: 0" align="left">- Problème 
        des pseudos en double Résolu.</p>

</th>
</tr>
<?php //version 1.1 ?>
<tr><th width="104" height="8"><font color="#FF0000">1.2</font></th>
<th width="476" height="8">
        <p align="left">- Nouvelle page de recherche pour les joueurs.</p>
</th>
</tr>
<?php //version 1.1 ?>
<tr><th width="104" height="96"><font color="#FF0000">1.1</font></th>
<th width="476" height="96">
        <p align="left">- Bug dans le formulaire Résolu.<p style="margin-top: 0; margin-bottom: 0" align="left">- Correction de l'affichage du 
        tableau de la page. &quot;alliance&quot;</p>

<p style="margin-top: 0; margin-bottom: 0" align="left">- Couleur ajouter sur 
        les titres des Variables.</p>
<p style="margin-top: 0; margin-bottom: 0" align="left">- Bug dans la génération 
        du code Résolu.</p>

<p style="margin-top: 0; margin-bottom: 0" align="left">- Changement de page 
        pour les coordonnées.</p>

<p style="margin-top: 0; margin-bottom: 0" align="left">- Correction de l'affichage du 
        tableau de la page. &quot;coord&quot;</p>

<p style="margin-top: 0; margin-bottom: 0" align="left">- Menu ajouter sur toute 
        les pages.</p>

<p style="margin-top: 0; margin-bottom: 0" align="left">- Classement en Tool-tip 
        dans le menu.</p>

</th>
</tr>
<?php //version 1.6 ?>
<tr><th width="104"><font color="#FF0000">1.0</font></th>
<th width="476">
        <p align="left">- Lien ajouter sur le 
        Tag de l'alliance.<p style="margin-top: 0; margin-bottom: 0" align="left">- BBcode modifier.</p>

<p style="margin-top: 0; margin-bottom: 0" align="left">- Formulaire Modifier 
        possible d'ajouter votre Univer pour l'avoir dans le BBcode.</p>
<p style="margin-top: 0; margin-bottom: 0" align="left">- Modification du tableau.</p>

</th>
</tr>
<?php 
echo "<br>";
?>
</table>
<?PHP
require_once("copy.php");
?>

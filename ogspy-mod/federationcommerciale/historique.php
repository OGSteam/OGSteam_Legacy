<?php
/***********************************************************************
 * filename	:	historique.php
 * desc.	:	Historique des versions
 * created	: 	06/11/2006 Mirtador
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
<table>
<th>Version</th><th>Modification</th>
<?php //version 0.1 ?>
<tr><th><font color="#FF0000">0.1</font></th>
	<th>
		<p style="margin-top: 0; margin-bottom: 0">-Premi�re �bauches du mod</p>
	</th>
</tr>
<?php //version 1?>
<tr><th><font color="#FF0000">1</font></th>
	<th>
		<p style="margin-top: 0; margin-bottom: 0">-Ajouts du support des 3 ressources</p>
		<p style="margin-top: 0; margin-bottom: 0">-Ajouts du support de 2 �quipes et non plus 1 �quipe avec un particulier</p>
		<p style="margin-top: 0; margin-bottom: 0">-Ajout du support de la virgule</p>
		<p style="margin-top: 0; margin-bottom: 0">-Ajout du support des unit�s</p>
		<p style="margin-top: 0; margin-bottom: 0">-Ajout du convertisseur en BBcode</p>
		<p style="margin-top: 0; margin-bottom: 0">-Ajout des infos bulles</p>
		<p style="margin-top: 0; margin-bottom: 0">-Les chiffres sont maintenant arrondis</p>
		<p style="margin-top: 0; margin-bottom: 0">-Un bouton r�initialise le formulaire maintenant</p>
		<p style="margin-top: 0; margin-bottom: 0">-R�glage du bug du num�ro de version</p>
		<p style="margin-top: 0; margin-bottom: 0">-R�glage du bug de l'installation</p>
		<p style="margin-top: 0; margin-bottom: 0">-R�glage du bug du menu</p>
		<p style="margin-top: 0; margin-bottom: 0">-Premi�re publication du mod</p>
	</th>
</tr>
<?php //version 1.1?>
<tr><th><font color="#FF0000">1.1</font></th>
	<th>
		<p style="margin-top: 0; margin-bottom: 0">-R�glage de la compatibilit� avec Internet explorer</p>
		<p style="margin-top: 0; margin-bottom: 0">-Ajout d'une barre qui indique en temps r�el la diff�rence entre le total des ressources et le total voulu</p>
		<p style="margin-top: 0; margin-bottom: 0">-Ajout du support des unit�s pour la barre</p>
		<p style="margin-top: 0; margin-bottom: 0">-Ajout du support des virgules pour la barre</p>
		<p style="margin-top: 0; margin-bottom: 0">-Ajout d'une infos bulles sur le total voulu</p>
	</th>
</tr>

<tr><th><font color="#FF0000">1.2</font></th>
	<th>
		<p style="margin-top: 0; margin-bottom: 0">-Ajout de l'enregistrement dans la BD des �changes</p>
		<p style="margin-top: 0; margin-bottom: 0">-Ajout de couleur pour distainguer les vendeurs des acheteurs plus facillement</p>
	</th>
</tr>

<tr>
	<td class="c" colspan="2")<p style="margin-top: 0; margin-bottom: 0">� venir</p></td>
</tr>
<tr>
	<th colspan="2">
		<p style="margin-top: 0; margin-bottom: 0">-Am�lioration du BBcode</p>
		<p style="margin-top: 0; margin-bottom: 0">-Correction des fautes d'orthographe ;P</p>
		<p style="margin-top: 0; margin-bottom: 0">-Enregistrement des transactions dans la BD</p>
		<p style="margin-top: 0; margin-bottom: 0">
			<a href="http://www.ogsteam.fr/forums/viewtopic.php?pid=35316#p35316">Vous avez des id�es?</a>
		</p>
	</th>
</tr>
<?php
require_once("pieddepage.php");
?>
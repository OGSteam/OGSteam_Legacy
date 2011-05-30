<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'accès direct


$chemin_fichier = "http://ogsteam.fr/forums/sujet-4226-mod-exchange";

$pageAbout = "<!-- DEBUT Insertion mod eXchange : About -->";

$fp=@fopen($chemin_fichier,"r");

$contenu = "";

if($fp)
{
	?>
   <table style='width:60%'>
					<tr style='line-height : 20px; vertical-align : center;'>
						<td class='c' style='text-align : center; width : 20%; color : #FF00FF;'>Version</td>
						<td class='c' style='text-align : center; color : #FF00FF;'>Modification</td>
					</tr>
					<tr>
						<td style='background-color : #273234; text-align : center;'>1.0.0</td>
						<td style='background-color : #273234;'>
							<ul>
								<li>Mise en conformité des functions l'install, uninstall et update avec OGSpy 3.0.7</li>
								<li>Mise a jour du mod avec Xtense</li>
							</ul>
						</td>
					</tr>
										
	</table>
  <?php
}
else
{
	echo "Impossible d'ouvrir la page $chemin_fichier";
} 

$pageAbout .= "<!-- FIN Insertion mod eXchange : About -->";

//affichage de la page
echo($pageAbout);

?>

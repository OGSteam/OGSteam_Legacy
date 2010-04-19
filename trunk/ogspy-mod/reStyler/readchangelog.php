<?php
// Lit un fichier, et le place dans une chaîne
$filename = DOSSIER_INCLUDE.'/changelog.txt';
$handle = fopen($filename, 'r');
$contents = fread($handle, filesize ($filename));
fclose($handle);

// on récupère chaque ligne
$changelog = preg_split("/\n/",trim($contents));

// juste pour éviter de fermer des balises UL dès le début
$liste_version_en_cours = 0;
$liste_chgt_en_cours = 0;

$derniere_version_lue = 0;

foreach ($changelog as $ligne) {

  // DATE
  if (is_numeric($ligne[0])) {
    // on ferme la liste de changements
    if ($liste_chgt_en_cours)
      echo "\t</ul>\n";
  
    // on ferme la liste de version
    if ($liste_version_en_cours)
      echo "</ol>\n";

    // pour ne lire que les derniers changements
    if ($read_first && $derniere_version_lue) {
      echo '...<p><a href="index.php?action=modREstyler&subaction=changelog" title="voir le changelog complet">&rarr; changelog complet</a><p>';
      // on sort de la boucle
      break;
    }

    echo '<b>',trim($ligne),"</b>\n";
    $liste_version_en_cours=0;
  }

  // VERSION
  if ($ligne[0] == 'v') {
    // on ferme la liste de changements
    if ($liste_version_en_cours)
      echo "\t</ul>\n\t</li>\n</ol>\n";

    echo '<ol style="list-style-type: none;" title="',trim($ligne),"\">\n\t<li>",trim($ligne),"\n\t<ul type=\"disc\">\n";
    $liste_version_en_cours = 1;
  }
    
  // CHANGEMENTS
  if ($ligne[0] == '*') {
    // on supprime l'étoile "*" qui marque une ligne de changement (c'est le premier caractère)
    echo "\t\t<li>",trim(substr($ligne,1)),"</li>\n";
    $liste_chgt_en_cours = 1;
  }
  
  $derniere_version_lue = 1;
}

// il n'y a rien à fermer si c'est juste les dernières modifs d'affichées (pas le changelog complet)
if (!$read_first)
	echo "\t</ul>\n</ol>"; // on ferme la dernière liste ouverte.
?>

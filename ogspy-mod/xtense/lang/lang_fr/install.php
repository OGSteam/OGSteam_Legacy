<?php




$lang['install title'] = 'Installation';
$lang['install subtitle'] = 'Installation de Xtense v%s';
$lang['install required config'] = 'Configuration requise';
$lang['install actual version'] = 'Version actuelle %s';
$lang['install log write access'] = 'Journaux Xtense accessibles en &eacute;criture';
$lang['install old folder detected'] = 'La nouvelle version de Xtense (v2) a detect&eacute; les fichiers de l&#039;ancienne version (v1)';
$lang['install old folder detected warn'] = 'Vous avez upload&eacute; la nouvelle version de Xtense dans le m&ecirc;me dossier que l&#039;ancienne version. Cependant, les modifications &eacute;tant trop importantes, il est conseill&eacute; de supprimer l&#039;ancien dossier mod/xtense/ avant d&#039;uploader le nouveau. <br /> Il n&#039;y a pas de risque de conflit mais il est pr&eacute;f&eacute;rable de supprimer l&#039;ancien mod pour ne pas avoir un m&eacute;lange de fichiers entre les deux.';
$lang['install old version detected'] = 'Une ancienne version (%s) du module Xtense2 a &eacute;t&eacute; detect&eacute;.';
$lang['install old version detected warn'] = 'Le dossier de stockage a chang&eacute; entre cette ancienne version et la nouvelle version que vous &ecirc;tes en train d&#039;installer. C&#039;est la raison pour laquelle vous devez faire une nouvelle installation et non pas une simple mise &agrave; jour.<br /> Afin d&#039;&eacute;viter tout conflit, il est largement recommand&eacute; de d&eacute;sinstaller cet ancien module et, puisqu&#039;ils sont devenus obsol&egrave;tes, de supprimer les fichiers de cette ancienne version.<br />';
$lang['install old version deteted warn 2'] = 'Bien que cette version ne soit pas actuellement install&eacute;e sur votre OGSpy, il est recommand&eacute; de supprimer le dossier obsol&egrave;te.<br /> Cela &eacute;vitera d&#039;installer par erreur cet ancien module, et donc de cr&eacute;er un conflit entre cet ancienne version beta, et la version que vous &ecirc;tes actuellement en train d&#039;installer.';
$lang['install uninstall old module'] = 'D&eacute;sintaller l&#039;ancien module. (recommand&eacute;)';
$lang['install delete old module files'] = 'Effacer les fichiers de l&#039;ancien module. (recommand&eacute;)';
$lang['install delete old folder'] = 'Supprimer le dossier de l&#039;ancien module. (recommand&eacute;)';
$lang['install checksum title'] = 'Int&eacute;grit&eacute; des fichiers du mod';
$lang['install checksum ok'] = 'Tous les fichiers sont valides';
$lang['install checksum error'] = 'Certains fichiers sont invalides. Tentez de les r&eacute;uploader via votre client FTP en mode Binaire, puis retentez l&#039;installation.';
$lang['install plugin verif'] = 'Verification de la connexion au plugin';
$lang['install plugin ok'] = 'Aucun erreur d&eacute;tect&eacute;e lors de la connexion au plugin. Vous pouvez utiliser le plugin directement depuis le r&eacute;pertoire du mod Xtense.';
$lang['install plugin unable to connect'] = 'Impossible de se connecter au plugin. Ce type d&#039;erreur est principalement d&ucirc; &agrave; l&#039;h&eacute;bergeur (anciennes version de logiciels, etc...).';
$lang['install plugin can copy to root'] = 'Vous pouvez cependant copier le plugin a la racine de votre ogpsy et l&#039;utiliser &agrave; cet endroit. Cette action permet la plupart du temps de r&eacute;soudre les probl&egrave;mes li&eacute;s &agrave; l&#039;h&eacute;bergeur.';
$lang['install can make copy'] = 'L&#039;installation poss&egrave;de les droits suffisants (CHMOD) pour pouvoir effectuer cette action.';
$lang['install copy to root button'] = 'Copier le plugin a la racine et l&#039;utiliser par d&eacute;faut';
$lang['install cannot make copy'] = 'L&#039;installation ne poss&egrave;de pas les droits suffisants pour pouvoir effectuer automatiquement cette action.';
$lang['install you can'] = 'Vous pouvez (au choix) :';
$lang['install try to move manually'] = 'Tenter de d&eacute;placer le plugin (fichier xtense.php) apr&egrave;s l&#039;installation &agrave; la racine de votre ogspy et param&eacute;trer son emplacement depuis l&#039;administration de Xtense';
$lang['install update permissions'] = 'Modifier le CHMOD du repertoire racine de votre OGSpy (si il existe d&eacute;j&agrave; un fichier xtense.php &agrave; la racine, vous devez aussi modifier ce CHMOD) pour que le script d&#039;installation puisse copier le plugin. Un CHMOD &agrave; 0777 permet une copie sans encombre. Cependant, il est conseill&eacute; de mettre de côt&eacute; l&#039;ancien CHMOD (du dossier racine mais aussi du fichier xtense.php si il existe - les deux &eacute;tant souvent diff&eacute;rents) pour le remettre a la suite du d&eacute;placement. Il suffit alors de recharger l&#039;installation de Xtense (F5) pour v&eacute;rifier que la copie est possible.';
$lang['install errors occur'] = 'Une ou plusieurs erreurs sont apparues';
$lang['install errors abort'] = 'L&#039;installation ne peut pas continuer &agrave; cause des erreurs pr&eacute;c&eacute;dentes. Vous devez les corriger avant de pouvoir continuer l&#039;installation.';
$lang['install optionnal param'] = 'Param&egrave;tres optionnels';
$lang['install fill these infos'] = 'Vous devez remplir ces param&egrave;tres pour compl&eacute;ter l&#039;installation';
$lang['install server domaine name OGSpy'] = 'Nom de domaine du serveur OGame (ex: http://uni23.ogame.fr)';
$lang['install server domaine name UniSpy'] = 'Nom de domaine du serveur E-Univers (ex: http://beta1.e-univers.org)';
$lang['install server pattern OGSpy'] = 'http://uniX.ogame.fr';
$lang['install server pattern UniSpy'] = 'http://betaX.e-univers.org';
$lang['install choose loging destination'] = 'Logger les actions des utilisateurs dans les journaux OGSpy au lieu de ceux Xtense';
$lang['install run'] = 'Lancer l&#039;installation';
$lang['install cancel'] = 'Annuler';
$lang['install success'] = 'Installation finie';
$lang['install all is ok'] = 'L&#039;installation de Xtense s&#039;est correctement d&eacute;roul&eacute;e.';
$lang['install callback list'] = 'Liste des liens';
$lang['install callbacks succesfully installed'] = 'Voici la liste des liens correctement install&eacute;s';
$lang['install some callbacks not installed'] = 'Certains liens n&#039;ont pas p&ucirc; &ecirc;tre automatiquement install&eacute;s';
$lang['install back to OGSpy'] = '>Vous pouvez d&egrave;s maintenant revenir &agrave; OGSpy en cliquant sur ce lien';
$lang['install back to UniSpy'] = '>Vous pouvez d&egrave;s maintenant revenir &agrave; UniSpy en cliquant sur ce lien';
?>
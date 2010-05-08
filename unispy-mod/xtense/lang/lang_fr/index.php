<?php

$lang['admin h1'] = 'Administration de Xtense';
$lang['tab infos'] = 'Informations';
$lang['tab group'] = 'Autorisations';
$lang['tab config'] = 'Configuration';
$lang['tab about'] = 'A propos';
$lang['tab log'] = 'Journal';
$lang['tab mods'] = 'Mods';

// Page Information
$lang['tb download'] = 'T&eacute;l&eacute;chargement de la barre';
$lang['tb download link'] = 'Cliquez ici pour r&eacute;cup&eacute;rer les informations sur la derni&egrave;re barre d&#039;outils Xtense disponible.';
$lang['tb download accept'] = 'Derni&egrave;re version disponible : ';
$lang['tb download error'] = 'Impossible de r&eacute;cup&eacute;rer l&#039;url de la derni&egrave;re barre Xtense';
$lang['add xtense to firefox'] = 'Ajouter Xtense &agrave; Firefox';
$lang['here are infos needed'] = 'Voici les informations que vous devez rentrer dans le plugin Xtense pour vous connecter &agrave; ce serveur :';
$lang['URL universe'] = 'URL de l&#039;univers';
$lang['URL module'] = 'URL plugin OGSpy';
$lang['info enter login'] = 'Vous devez &eacute;galement mettre votre pseudo et votre mot de passe de connexion &agrave; OGSpy';

// Page configuration
$lang['xtense.php readonly'] = 'Le fichier <em>xtense.php</em> d&eacute;j&agrave; pr&eacute;sent &agrave; la racine de votre ogspy n&#039;est pas disponible en &eacute;criture, veuillez v&eacute;rifier son CHMOD.';
$lang['xtense.php undeleted'] = 'Impossible de supprimer le fichier <em>xtense.php</em> d&eacute;j&agrave; pr&eacute;sent &agrave; la racine de votre OGSpy.';
$lang['folder readonly'] = 'Le dossier racine de votre ogspy n&#039;est pas disponible en &eacute;criture. Il est impossible de copier le plugin.';
$lang['critical error'] = 'Une erreur critique est survenue lors de la copie du plugin !';
$lang['xtense.php move success'] = 'Le d&eacute;placement c&#039;est correctement pass&eacute;. L&#039;URL du plugin a &eacute;t&eacute; modifi&eacute;e pour correspondre &agrave; son nouvel emplacement.';
$lang['user home repair success'] = 'L&#039;espace personnel a &eacute;t&eacute; correctement r&eacute;par&eacute;';
$lang['callbacks installed'] = 'Les appels ont &eacute;t&eacute; install&eacute;s.';
$lang['callbacks installed summary'] = '%1$s appel(s) install&eacute;(s) pour un total de %2$s appels disponibles';
$lang['callbacks errors detail'] = 'D&eacute;tails des erreurs';
$lang['callbacks list'] = 'Liste des liens';
$lang['callbacks installed success'] = 'Voici la liste des liens correctement install&eacute;s';
$lang['callbacks installed errors'] = 'Certains liens n&#039;ont pas p&ucirc; &ecirc;tre automatiquement install&eacute;s';
$lang['allow connexions'] = 'Autoriser les connexions au plugin';
$lang['coadmin alert'] = 'Vous &ecirc;tes co-admin, si vous cochez cette option vous ne pourrez plus acceder &agrave; l&#039;administration de Xtense';
$lang['strict admin'] = 'Limiter l&#039;administration &agrave; l&#039;admin (et non aux co-admins)';
$lang['keep log duration'] = 'Dur&eacute;e de conservation des fichiers logs de Xtense (en jours, 0 pour aucune suppression).';
$lang['log reverse'] = 'Afficher les actions les plus r&eacute;centes en haut dans le journal.';
$lang['plugin at root'] = 'Plugin &agrave; la racine de votre OGSpy.';
$lang['spy autodelete'] = 'Effacement automatique des RE trop vieux (configurable depuis l&#039;admin de OGSpy).';
$lang['request logging'] = 'Journaliser les requ&ecirc;tes';
$lang['log empire alert'] = 'Attention ! La journalisation des pages des empires des joueurs n&#039;est pas forcement necessaire. Elle prend rapidement beaucoup de place dans les logs !<br>Etes-vous s&ucirc;r de vouloir l&#039;activer ?';
$lang['user OGSpy log'] = 'Utiliser le journal OGSpy';
$lang['actions'] = 'Actions';
$lang['do action'] = 'Effectuer cette action';
$lang['try to move xtense.php auto'] = 'Tenter de d&eacute;placer automatiquement le fichier xtense.php &agrave; la racine de votre OGSpy';
$lang['try to repair empire auto'] = 'R&eacute;parer les espaces personnels (en cas de probl&egrave;mes avec un espace personnel plein)';
$lang['try to reinit callbacks'] = 'Installer les appels de tous les mods install&eacute;s et activ&eacute;s';

// page Group
$lang['group help permissions'] = 'Vous pouvez d&eacute;finir pour chaque groupe de OGSpy les acc&egrave;s qu&#039;ont les utilisateurs &agrave; Xtense.';
$lang['group name'] = 'Nom';
$lang['group system'] = 'Syst&egrave;mes';
$lang['group rank'] = 'Classement';
$lang['group empire'] = 'Empire';
$lang['group empire help'] = 'Pages Batiments, Recherches, Defenses.. et Empire';
$lang['group messages'] = 'Messages';

// Page Module
$lang['mods primary info'] = 'Liste des mods li&eacute;s au plugin Xtense. Ces liens permettent aux mods de r&eacute;cuperer les donn&eacute;es envoy&eacute;es par Xtense 2. Vous pouvez ici activer ou desactiver ces liaisons.';
$lang['mods name version'] = 'Nom/version du Mod';
$lang['mods data type'] = 'Type de donn&eacute;es';
$lang['mods status'] = 'Status du mod';
$lang['mods link status'] = 'Status du lien';
$lang['no callbacks found'] = 'Aucun lien enregistr&eacute; dans la base de donn&eacute;es';


// Page Log
$lang['log write error'] = 'Le dossier log/ du plugin Xtense n&#039;est pas accessible en &eacute;criture ! Les journaux ne seront pas sauvegard&eacute;s';
$lang['log purge error'] = 'Une erreur a eu lieue lors de la suppression des fichiers. Impossible de continuer.';
$lang['log delete file success'] = 'Fichiers supprim&eacute;s';
$lang['log sumary'] = 'Taille actuellement occup&eacute;e par les fichiers de journalisation : <strong>%1$s</strong> <em>(%2$s pour %3$s fichiers)</em>';
$lang['log delete all confirm'] = 'Etes-vous s&ucirc;r de vouloir supprimer tous les journaux ?';
$lang['log delete all'] = 'Tout supprimer';
$lang['log date to display'] = 'Date du journal &agrave; visionner';
$lang['log show'] = 'Voir';
$lang['log unable to read file'] = 'Impossible de lire le fichier du journal : %s';
$lang['log of'] = 'Historique du %s';
$lang['log empty'] = 'Historique vide';
$lang['use OGSpy log'] = 'Utiliser le journal d\'OGSpy';
$lang['log date to diplay'] = 'Date du journal';


?>
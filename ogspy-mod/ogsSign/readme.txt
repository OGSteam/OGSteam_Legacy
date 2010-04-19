
 -= OGSign =-



*************
 PRE-REQUIS:
*************

Il vous faut évidemment disposer d'un serveur OGSpy. Mais pas seulement,
la librairie GD doit être activée (dans le php.ini) ; pour le vérifier, affichez
votre phpinfo, et cherchez "GD" : si vous trouvez quelque chose du genre
"GD Support enabled", c'est bon !
Votre hébergeur doit également vous autoriser l'utilisation des fichiers
".htaccess". Comme pour la librairie GD, cela est obligatoire !
Optionnel : s'il s'agit de votre propre serveur (physique), vous pouvez activer
le mod_rewrite d'Apache (dans le httpd.conf).
De plus, avec PHP >= 4.3.2 et Apache, la détection du mod_rewrite se fait
automatiquement ! L'étape 3#1 et 3#2 sont donc à ignorer dans ce cas
(il faut néanmoins absolument vérifier la présence du .htaccess, et son contenu)



***********************
 NOTES D'INSTALLATION:
***********************

1# décompressez le zip dans le dossier des mod d'OGSpy et vérifiez le nom :
"OGSign".

2# installez le mod via Administration > Mods

ensuite, deux cas : soit un fichier ".htaccess" a été créé dans le dossier
d'OGSign, et dans ce cas, l'installation est réussie, soit il n'y en a pas...
dans ce cas, on continue :

	(dans le doute, utilisez la solution 3#2 avec le mod_rewrite désactivé) :

	3#1 mod_rewrite actif :
	----------------------

		3#1.1 copiez le fichier ".htaccess_mod_rewrite_ON" en ".htaccess"
		(il y a bien 2 'c' et 2 's')

	3#2 mod_rewrite désactivé :
	--------------------------

		3#2.1 copiez le fichier ".htaccess_mod_rewrite_OFF" en ".htaccess"
		(il y a bien 2 'c' et 2 's')

		3#2.2 personnalisez maitenant ce ".htaccess" : la ligne "ErrorDocument 404"
		doit pointer vers "urlrewriting.php", en partant de la racine de votre
		serveur. Ce qui donnerais avec l'exemple ci-dessous :
		ErrorDocument 404 /mon_alliance/serveur_ogspy/mod/OGSign/urlrewriting.php
		(puisque la racine de votre serveur web est http://serveur.fr/toto/ ).
		Mais cela peut aussi être :
		ErrorDocument 404 /toto/mon_alliance/serveur_ogspy/mod/OGSign/urlrewriting.php

4# personnalisez le numéro d'univers via le panneau d'administration d'OGSign.


L'installation est terminée !

REMARQUE : pour ceux jouant dans des univers à vitesse rapide (exemple : uni 50 français qui est en vitesse *2), il faut mettre la vitesse dans le fichier sign_include.php, tout à la fin : define('VITESSE_UNI', 2); (pour l'uni 50 FR).
Sinon, pour les univers classiques, laissez la valeur à 1.


***********************
 NOTES D'UTILISATION :
***********************

pour que vos utilisateurs aient accès à leur signature :

	1. ils doivent avoir un compte OGSpy (peu importe les droits),

	2. pour que la signature avec les stats fonctionne, le joueur doit évidemment
	être classé... et le classement entré dans OGSpy
	(on doit le voir dans la partie "Classement" )

	3. pour que la signature avec les ressources soit correcte, TOUTES les
	planètes doivent être saisies dans sa partie "Espace personnel > Empire"

	4. TOUS les systèmes où ils entrent les coordonnées de ces planètes doivent
	être saisis.

	5. enfin, chaque utilisateur doit aller valider ses paramètres.

Voilà, c'est tout. Vous pouvez vous servir de votre signature. N'oubliez pas de
mettre à jour le classement dans OGSpy, ainsi que la page Empire !


Pour la signature d'alliance, c'est aux (co)administrateurs de la configurer.
Vous pouvez faire autant de signatures d'alliances que vous le désirez...
Cependant, n'oubliez pas qu'elles sont toutes visibles par les utilisateurs dans
leur panneau "Alliance" (ils ne peuvent que les voir, pas les modifier).



*************************
 EXEMPLE D'UTILISATION :
*************************

votre serveur est à l'adresse http://serveur.fr/toto/mon_alliance/serveur_ogspy/

vous devriez avoir maintenant le dossier "mod" d'OGSpy, un nouveau dossier nommé
"OGSign".

les signatures seront disponibles ici :
http://serveur.fr/toto/mon_alliance/serveur_ogspy/mod/OGSign/pseudo_ingame.png

ATTENTION : si le nom comporte des espaces, il faut les remplacer par le code
"%20" (sans les guillemets, évidemment) dans l'adresse.



*************
 PROBLEMES :
*************

Tout d'abord, je rappelle que l'utilisation des fichiers ".htaccess" et la
librairie GD sont nécessaires pour le fonctionnement d'OGSign !!!

Si la signature refuse de s'afficher, et que tout semble correct, essayez
d'y accéder par cette adresse :
http://serveur.fr/toto/mon_alliance/serveur_ogspy/mod/OGSign/sign.php?player=pseudo_ingame
Si cela fonctionne, le problème vient du fichier .htaccess , mal configuré.
La procédure d'installation devrait le générer correctement,
mais cela ne fonctionne pas partout !



*********
 NOTES :
*********

Votre serveur OGSpy se trouve à l'adresse
http://serveur.fr/toto/mon_alliance/serveur_ogspy/
Les signatures seront donc ici
http://serveur.fr/toto/mon_alliance/serveur_ogspy/mod/OGSign/pseudo_ingame.type_de_sign.png
"pseudo_ingame" est le pseudo dans OGame.
"type_de_sign" correspond au type de signature voulue :
soit "S" (ou rien) pour les stats, soit "P" pour la production.
Pour la signature alliance, c'est un peu plus particulier : c'est un numéro
à la place du pseudo (on dirait plutôt "tag"), et "A" comme type de sign.

Les signatures sont au format PNG, générées à la première demande puis stockées
dans le dossier /mod/OGSign/cache/ 
Elles sont mises à jour à la prochaine demande si un nouveau classement a été
détecté dans OGSpy.
Elles sont également supprimées (pour être immédiatement recrées) lorsqu'on
en change les paramètres.
Cette mise en cache permet d'économiser des ressources processeur, car
le processus de création d'image est assez lourd...
Remarque : le contenu du dossier cache peut être supprimé sans crainte,
les signatures se régénèreront au besoin.



***********
 CREDITS :
***********

réalisé par oXid_FoX, basé sur le script de CC30, et en collaboration avec lui ;)
remerciements également à :
Unibozu pour la forme de l'interface de configuration,
	largement reprise de son travail d'intégration dans OGSpy 0.301,
Kal Nightmare pour les calculs de la production, la signature d'alliance, ses suggestions...
Aeris pour toute son aide, principalement en SQL (je serai ton padawan pour toujours),
tous ceux qui ont participé à ce mod de près ou de loin,
vous-même qui lisez ce fichier !
	(chouette, au moins 1 lecteur, je ne l'ai pas écrit pour rien)


forum de support pour OGSign, dernières versions :
http://www.ogsteam.fr/forums/sujet-1506-mod-ogsign
http://www.ogsteam.fr/forums/forum-18-ogsign


script original (OGStats) :
http://ogstats.cc30.free.fr
http://board.ogame.fr/thread.php?postid=1820563


 -= OGSign =-



*************
 PRE-REQUIS:
*************

Il vous faut �videmment disposer d'un serveur OGSpy. Mais pas seulement,
la librairie GD doit �tre activ�e (dans le php.ini) ; pour le v�rifier, affichez
votre phpinfo, et cherchez "GD" : si vous trouvez quelque chose du genre
"GD Support enabled", c'est bon !
Votre h�bergeur doit �galement vous autoriser l'utilisation des fichiers
".htaccess". Comme pour la librairie GD, cela est obligatoire !
Optionnel : s'il s'agit de votre propre serveur (physique), vous pouvez activer
le mod_rewrite d'Apache (dans le httpd.conf).
De plus, avec PHP >= 4.3.2 et Apache, la d�tection du mod_rewrite se fait
automatiquement ! L'�tape 3#1 et 3#2 sont donc � ignorer dans ce cas
(il faut n�anmoins absolument v�rifier la pr�sence du .htaccess, et son contenu)



***********************
 NOTES D'INSTALLATION:
***********************

1# d�compressez le zip dans le dossier des mod d'OGSpy et v�rifiez le nom :
"OGSign".

2# installez le mod via Administration > Mods

ensuite, deux cas : soit un fichier ".htaccess" a �t� cr�� dans le dossier
d'OGSign, et dans ce cas, l'installation est r�ussie, soit il n'y en a pas...
dans ce cas, on continue :

	(dans le doute, utilisez la solution 3#2 avec le mod_rewrite d�sactiv�) :

	3#1 mod_rewrite actif :
	----------------------

		3#1.1 copiez le fichier ".htaccess_mod_rewrite_ON" en ".htaccess"
		(il y a bien 2 'c' et 2 's')

	3#2 mod_rewrite d�sactiv� :
	--------------------------

		3#2.1 copiez le fichier ".htaccess_mod_rewrite_OFF" en ".htaccess"
		(il y a bien 2 'c' et 2 's')

		3#2.2 personnalisez maitenant ce ".htaccess" : la ligne "ErrorDocument 404"
		doit pointer vers "urlrewriting.php", en partant de la racine de votre
		serveur. Ce qui donnerais avec l'exemple ci-dessous :
		ErrorDocument 404 /mon_alliance/serveur_ogspy/mod/OGSign/urlrewriting.php
		(puisque la racine de votre serveur web est http://serveur.fr/toto/ ).
		Mais cela peut aussi �tre :
		ErrorDocument 404 /toto/mon_alliance/serveur_ogspy/mod/OGSign/urlrewriting.php

4# personnalisez le num�ro d'univers via le panneau d'administration d'OGSign.


L'installation est termin�e !

REMARQUE : pour ceux jouant dans des univers � vitesse rapide (exemple : uni 50 fran�ais qui est en vitesse *2), il faut mettre la vitesse dans le fichier sign_include.php, tout � la fin : define('VITESSE_UNI', 2); (pour l'uni 50 FR).
Sinon, pour les univers classiques, laissez la valeur � 1.


***********************
 NOTES D'UTILISATION :
***********************

pour que vos utilisateurs aient acc�s � leur signature :

	1. ils doivent avoir un compte OGSpy (peu importe les droits),

	2. pour que la signature avec les stats fonctionne, le joueur doit �videmment
	�tre class�... et le classement entr� dans OGSpy
	(on doit le voir dans la partie "Classement" )

	3. pour que la signature avec les ressources soit correcte, TOUTES les
	plan�tes doivent �tre saisies dans sa partie "Espace personnel > Empire"

	4. TOUS les syst�mes o� ils entrent les coordonn�es de ces plan�tes doivent
	�tre saisis.

	5. enfin, chaque utilisateur doit aller valider ses param�tres.

Voil�, c'est tout. Vous pouvez vous servir de votre signature. N'oubliez pas de
mettre � jour le classement dans OGSpy, ainsi que la page Empire !


Pour la signature d'alliance, c'est aux (co)administrateurs de la configurer.
Vous pouvez faire autant de signatures d'alliances que vous le d�sirez...
Cependant, n'oubliez pas qu'elles sont toutes visibles par les utilisateurs dans
leur panneau "Alliance" (ils ne peuvent que les voir, pas les modifier).



*************************
 EXEMPLE D'UTILISATION :
*************************

votre serveur est � l'adresse http://serveur.fr/toto/mon_alliance/serveur_ogspy/

vous devriez avoir maintenant le dossier "mod" d'OGSpy, un nouveau dossier nomm�
"OGSign".

les signatures seront disponibles ici :
http://serveur.fr/toto/mon_alliance/serveur_ogspy/mod/OGSign/pseudo_ingame.png

ATTENTION : si le nom comporte des espaces, il faut les remplacer par le code
"%20" (sans les guillemets, �videmment) dans l'adresse.



*************
 PROBLEMES :
*************

Tout d'abord, je rappelle que l'utilisation des fichiers ".htaccess" et la
librairie GD sont n�cessaires pour le fonctionnement d'OGSign !!!

Si la signature refuse de s'afficher, et que tout semble correct, essayez
d'y acc�der par cette adresse :
http://serveur.fr/toto/mon_alliance/serveur_ogspy/mod/OGSign/sign.php?player=pseudo_ingame
Si cela fonctionne, le probl�me vient du fichier .htaccess , mal configur�.
La proc�dure d'installation devrait le g�n�rer correctement,
mais cela ne fonctionne pas partout !



*********
 NOTES :
*********

Votre serveur OGSpy se trouve � l'adresse
http://serveur.fr/toto/mon_alliance/serveur_ogspy/
Les signatures seront donc ici
http://serveur.fr/toto/mon_alliance/serveur_ogspy/mod/OGSign/pseudo_ingame.type_de_sign.png
"pseudo_ingame" est le pseudo dans OGame.
"type_de_sign" correspond au type de signature voulue :
soit "S" (ou rien) pour les stats, soit "P" pour la production.
Pour la signature alliance, c'est un peu plus particulier : c'est un num�ro
� la place du pseudo (on dirait plut�t "tag"), et "A" comme type de sign.

Les signatures sont au format PNG, g�n�r�es � la premi�re demande puis stock�es
dans le dossier /mod/OGSign/cache/ 
Elles sont mises � jour � la prochaine demande si un nouveau classement a �t�
d�tect� dans OGSpy.
Elles sont �galement supprim�es (pour �tre imm�diatement recr�es) lorsqu'on
en change les param�tres.
Cette mise en cache permet d'�conomiser des ressources processeur, car
le processus de cr�ation d'image est assez lourd...
Remarque : le contenu du dossier cache peut �tre supprim� sans crainte,
les signatures se r�g�n�reront au besoin.



***********
 CREDITS :
***********

r�alis� par oXid_FoX, bas� sur le script de CC30, et en collaboration avec lui ;)
remerciements �galement � :
Unibozu pour la forme de l'interface de configuration,
	largement reprise de son travail d'int�gration dans OGSpy 0.301,
Kal Nightmare pour les calculs de la production, la signature d'alliance, ses suggestions...
Aeris pour toute son aide, principalement en SQL (je serai ton padawan pour toujours),
tous ceux qui ont particip� � ce mod de pr�s ou de loin,
vous-m�me qui lisez ce fichier !
	(chouette, au moins 1 lecteur, je ne l'ai pas �crit pour rien)


forum de support pour OGSign, derni�res versions :
http://www.ogsteam.fr/forums/sujet-1506-mod-ogsign
http://www.ogsteam.fr/forums/forum-18-ogsign


script original (OGStats) :
http://ogstats.cc30.free.fr
http://board.ogame.fr/thread.php?postid=1820563

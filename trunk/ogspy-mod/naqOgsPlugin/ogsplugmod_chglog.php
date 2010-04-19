<?php
/**
* ogsplugmod_chglog.php 
* @package OGS Plugin
* @author Naqdazar
* @link http://
* @version 1.2.n
*/

/*
Module de laison pour la Barre d'Outils OGSPY, extension firefox d'aide aux mise � jour de serveurs OGSPY

Linking MOD for OGSPY Toolbar, a firefox plugin for helping players in updating OGSPY servers game datas

Copyright (C) 2006 Naqdazar (ajdr@free.fr)

Ce programme est un logiciel libre ; vous pouvez le redistribuer et/ou le modifier
au titre des clauses de la Licence Publique G�n�rale GNU, telle que publi�e par la
Free Software Foundation ; soit la version 2 de la Licence.
Ce programme est distribu� dans l'espoir qu'il sera utile, mais SANS AUCUNE GARANTIE ;
 sans m�me une garantie implicite de COMMERCIABILITE ou DE CONFORMITE A UNE UTILISATION PARTICULIERE. 
 
 Voir la Licence Publique G�n�rale GNU pour plus de d�tails. 
 
 Vous devriez avoir re�u un exemplaire de la Licence Publique G�n�rale GNU avec ce programme ;
  si ce n'est pas le cas, �crivez � la Free Software Foundation Inc.,
  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.

This program is free software; you can redistribute it and/or modify it under the
terms of the GNU General Public licence as published by the Free Software Foundation;
either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 See the GNU General Public License for more details.

You should have received a copy of the GNU General Public licence along with this program;
 if not, write to the Free Software Foundation, Inc., 
 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if (!defined('IN_SPYOGAME')) die("Appel direct non autoris�!");

require_once("mod/naq_ogsplugin/ogsplugincl.php");

//D�finitions
global $db;

//On v�rifie que le mod est activ�
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='naq_ogsplugin' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Appel direct non autoris�!");

//Version 2.2.9
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.2.9 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_correction de l'envoi des pages empires.<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";



//Version 2.2.8
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.2.8 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_correction du bug d'envoi des rapports de sondages).<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";


//Version 2.2.6
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.2.6 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_correction du bug d'envoi des pages empires (par Syrus).<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 2.2.5
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.2.5 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_correction du fichier update (par verite).<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 2.2.3
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.2.3 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_correction de la pge empire (par Syrus).<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 2.2.1-2.2.2
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.2.1-2.2.2 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_rien.<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 2.2.0b
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.2.0b :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_correction 2 par Sylar.<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 2.2.0
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.2.0 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_correction d'un bug pour les RE pour qui MSonde et QuiM'Observe (merci Sylar ^^)<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 2.1.9
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.1.9 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_correction d'un bug pour les RE E-Univers (merci LoloThib)<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 2.1.8
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.1.8 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ Ajout de la version automatique de la barre<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 2.1.7
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.1.7 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ Reprise des modifications apport� par Naruto<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";


//Version 2.1.6
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.1.6 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ mise a jour de ogsplugin_fonction (ajout du module qui me sonde)<br>\n";
echo "_ modification des adresses des univers (ex :passage de ogame200.de � uni6.ogame.fr<br>\n";
echo "_ List des univers jusqu'� 56 <br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 2.1.5
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.1.5 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ modification de l'appel des mises � jour par Naruto.<br>\n";
echo "_ passage sur le SVN de l'Ogsteam<br>\n";
echo "_ reprise de diff�rents bug d'installation<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 2.0.2
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.0.2 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ correction du code de copie du script ogsplugin.php: les permissions seront adapt�es automatiquement<br>\n";
echo "_ correction du formulaire de la page du module OGS Plugin<br>\n";
echo "_ correction mineure de la page `Autres modules`<br>\n";
echo "_ correction de la d�tection de version pour UniSpy 1.0beta<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 2.0.1
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.0.1 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ correction dans l'insertion des classements alliance<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 2.0
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 2.0 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ correction du module pour la prise en charge de donn�es E-Univers<br>\n";
echo "  sur OGSPY 3.02c, 3.03, 3.1 et UniSpy 3.1<br>\n";
echo " (galaxies, rapports d'espionnage, classements)<br>\n";
echo "_ r�agencement des options de la page administration du module et<br>\n";
echo "  ajout d'options pour le jeu E-Univers<br>\n";
echo "_ mise � jour des cha�nes pour l'interface anglaise<br>\n";
echo "_ ajout de code pour la v�rification du dossier /debug et de ses droits lors de l'appel depuis l'extension.<br>\n";
echo "_ ajout de l'univers 52 � la liste des univers Ogame fran�ais.<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 1.6.1
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 1.6.1 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ correction du code de s�paration des rapports re�us<br>\n";
echo "_ correction du code de retour de traitement des rapports de recyclage<br>\n";
echo "_ mise � jour des TAGS alliances et status pour les joueurs(vue galaxie)<br>\n";
echo "_ ajout de la purge automatique des classements<br>\n";
echo "_ am�lioration du traitement pour les lunes renomm�es<br>\n";
echo "_ traitement du nombre de satellites, nombre de cases et temp�rature pour l'espace personnel<br>\n";
echo "_ affichage des infos de configuraiton pour l'utilisateur<br>\n";
echo "_ ajout d'une option de recopie du script de liaison en cas de diff�rence<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 1.6
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 1.6 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ ajout de commandes pour la barre d'outils<br>\n";
echo "_ ajout d'avertissement en cas de probl�mes � l'installation<br>\n";
echo "_ ajout d'avertissement � la suppression du module<br>\n";
echo "_ correction de code pour l'importation de modules tiers<br>\n";
echo "_ correction de la reconnaissance de la page empire: les noms de plan�te<br>\n";
echo "  � mots multiples sont reconnus quelque soit le nombre de plan�tes<br>\n";
echo "_ corrections suite � la restructuration:<br>\n";
echo "  -> r�tablissement de la journalisation<br>\n";
echo "  -> mise � jour des stats de mise � jour<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 1.5.1
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 1.5.1 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ correction de bug dans la gestion des droits suite � la restructuration<br>\n";
echo "_ correction de bug dans la prise en compte des champs de ruine<br>\n";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 1.5
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 1.5 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo " _ correction des messages de journaux pour l'espace personnel<br>";
echo " _ les rapports envoy�s avec la barre firefox sont d�sormais comptabilis� en rapports OGS<br>";
echo " _ correction de la v�rification de version de la barre cliente<br>";
echo "_ ajout de code pour la mise � jour des champs de ruine(Module Champ de Ruine)<br>";
echo "_ restructuration du module<br>";
echo "</p>";
echo "</fieldset>";
echo "<br>";


//Version 1.4
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 1.4 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ version du module d�velopp�e en parall�le de la barre d'outils v1.1<br>";
echo "_ mise en option du blocage de version de la barre d'outils si obsol�te!<br>";
echo "  (attention � l'absence de mise � jour r�ciproque barre/module->disfonctions �ventuelles)<br>";
echo "_ ajout de code pour demander une mise � jour le barre malgr� un traitement de la barre(recommandation)<br>";  
echo "_ ajout d'une option pour la g�n�ration d'un journal de d�bogage (infos choisies<br>";
echo "  par l'auteur lors du d�veloppement, n'a pas la pr�tention de convenir � tout le monde)<br>";
echo "_ v�rification de l'�tat activ� du module ou pas, sinon abandon<br>";
echo "_ correction du code de gestion des rapports(mode commandant) pour  mise � jour avec la barre d'outils 1.1 <br>";
echo "_ ajout d'un sous menu pour l'acc�s rapide � la page administration de gestion des groupes(droits)<br>";
echo "</p>";
echo "</fieldset>";
echo "<br>";


//Version 1.3.1
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 1.3.1 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ restructuration du module pour l'internationalisation du module OGS Plugin.<br>";
echo "_ prise en charge du module flotte si install� sur le serveur.<br>";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 1.3.0
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 1.3.0 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ ajout d'un lien d'acc�s rapide au journal OGSPY.<br>";
echo "_ externalisation xml locale de la liste des univers.<br>";
echo "</p>";
echo "</fieldset>";
echo "<br>";


//Version 1.2.9
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 1.2.9 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ prise en charge des rapports de combat avec le module Attaques install�.<br>";
echo "_ ajout d'une option de message de redirection dans le cas d'une migration de serveur<br>";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 1.2.8
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 1.2.8 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ bug de premier rapport d'espionnage non trait� - corrig�.<br>";
echo "_ seul les rapports d'espionnages sont re�us sur le serveur(faille corrig�e)<br>";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 1.2.7
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 1.2.7 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ correction de delimiteur manquant dans UN appel de fonction de recherche<br>";
echo "</p>";
echo "</fieldset>";
echo "<br>";


//Version 1.2.6.1
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 1.2.6.1 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ correction de structure du module(mineur)<br>";
echo "</p>";
echo "</fieldset>";
echo "<br>";
echo "</font>";

//Version 1.2.6
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 1.2.6 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ modification de l'interface(modulaire, ajout de liens)<br>";
echo "_ ajout de lentr�e pour l'univers 47(fr)<br>";
echo "_ correction d'un bug d'insertion des plan�tes et lunes (nom de plan�te ne devrait pas �tre lune cependant)<br>";
echo "_ correction d'un bug effa�ant les temp�ratures, nombre de cases et nombre de satellites<br>";
echo "</p>";
echo "</fieldset>";
echo "<br>";

//Version 1.2.5
echo "<fieldset><legend><b><font color='#0080FF'><u>Version 1.2.5 :</u></font></b></legend>";
echo "<p align='left'><font color='white'>";
echo "_ modification de l'interface(modulaire, ajout de liens)<br>";
echo "_ ajout de lentr�e pour l'univers 46(fr)<br>";
echo "_ blocage de la version en de�a 1.0.966 du plugin firefox<br>";
echo "_ derni�re version du module compatible 0.301<br>"; 
echo "</p>";
echo "</fieldset>";


echo "<br>";
echo "</font></table>";



?>

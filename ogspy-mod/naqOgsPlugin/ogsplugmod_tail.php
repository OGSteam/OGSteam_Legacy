<?php
/**
* ogsplugmod_tail.php
* @package OGS Plugin
* @author Naqdazar
* @link http://
* @version 1.6.1
*/

/*
Module de laison pour la Barre d'Outils OGSPY, extension firefox d'aide aux mise à jour de serveurs OGSPY

Linking MOD for OGSPY Toolbar, a firefox plugin for helping players in updating OGSPY servers game datas

Copyright (C) 2006 Naqdazar (ajdr@free.fr)

Ce programme est un logiciel libre ; vous pouvez le redistribuer et/ou le modifier
au titre des clauses de la Licence Publique Générale GNU, telle que publiée par la
Free Software Foundation ; soit la version 2 de la Licence.
Ce programme est distribué dans l'espoir qu'il sera utile, mais SANS AUCUNE GARANTIE ;
 sans même une garantie implicite de COMMERCIABILITE ou DE CONFORMITE A UNE UTILISATION PARTICULIERE. 
 
 Voir la Licence Publique Générale GNU pour plus de détails. 
 
 Vous devriez avoir reçu un exemplaire de la Licence Publique Générale GNU avec ce programme ;
  si ce n'est pas le cas, écrivez à la Free Software Foundation Inc.,
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

if (!defined('IN_SPYOGAME')) die("Appel direct non autorisé!");

global $ogp_lang;

if (defined("SERVER_IS_UNISPY")) $servertype_caption = "UniSpy";
elseif (defined("SERVER_IS_OGSPY")) $servertype_caption = "OGSpy";

echo "\t"."<br>\n";
echo "\t"."<div align=center><font size=2>MOD OGS Plugin v".OGP_MODULE_VERSION."(".$servertype_caption.") ".$ogp_lang["developpedby_tail"]." <a href=mailto:lexa.gg@free.fr>Naqdazar</a> (P) 2006-2007</font></div>\n";
//echo "\t"."</td>\n";

require_once("views/page_tail.php");
exit();

?>

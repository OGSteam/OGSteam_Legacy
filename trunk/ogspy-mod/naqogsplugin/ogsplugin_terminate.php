<?php

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

global $db, $fp, $fp_plgcmds, $sqlcodefile;
if (defined("OGS_PLUGIN_DEBUG"))  fclose($fp); // ligne d�bug , commentaire si pas utile
if (defined("OGS_PLUGIN_DEBUG"))  fclose($fp_plgcmds); // ligne d�bug , commentaire si pas utile
//mysql_close($db);
if (defined("OGS_PLUGIN_DEBUG"))  $sqlcodefile= fopen("mod/naq_ogsplugin/debug/sqlerrorcodes.txt","w"); // ligne d�bug , commentaire si pas utile
if (defined("OGS_PLUGIN_DEBUG")) fwrite($sqlcodefile,"code erreur slq(fin script): ".mysql_errno($db->$dbselect)."-".mysql_error($db->$dbselect)."\n");
if (defined("OGS_PLUGIN_DEBUG"))  fclose($sqlcodefile); // ligne d�bug , commentaire si pas utile
//session_close(); // force d�connection ogspy si logu� :s
@ob_end_clean(); // vidage tampon;


?>

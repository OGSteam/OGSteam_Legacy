<?php
/***************************************************************************
*	filename	: index.php
*   package     : Copy_local
*	desc.		: Page principale du module
*	Author		: ericc - http://www.ogsteam.fr/
*	created		: 10/03/2008
*	modified	: 03/04/2008
***************************************************************************/

// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='copylocal' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");
?>
<style type="text/css">
/*This is where the magic happens!*/
div.copy_box {
     border: 1px solid #000000;
     position: relative;
     width: 100%;
}
div.copy_box_contents {
     background-color:transparent;
     height: 100%;
     position: relative;
     width: 100%;
     z-index: 101;
}
div.copy_box_background {
     background-color: black;
     height: 100%;
     filter:alpha(opacity=60); /* IE's opacity*/
     left: 0px;
     opacity: 0.60;
     position: absolute;
     top: 0px;
     width: 100%;
     z-index: 99;
}
</style>
<?php

//Définitions
//global $db, $table_prefix, $prefixe;
// Fonctions du module
require_once("mod/copylocal/function.php");
// Vérifie si l'utilisateur est Administrateur
if (IsUserAdmin() == 0)
{
    die("Module r&eacute;serv&eacute; &agrave; l'administrateur du serveur");
}

// Entête du site
require_once("views/page_header.php");

if (!isset($pub_page))
{
    $pub_page = "transfert";
}
menu($pub_page);
// Affichage du layer transparent
echo"<div class='copy_box'><div class='copy_box_background'> </div> <div class='copy_box_contents'>";
if (!file_exists("mod/copylocal/config.php"))
{
   require_once("mod/copylocal/admin.php");
   exit;
}
//On affiche de la page demandée
if ($pub_page == "transfert") include("transfert.php");
elseif ($pub_page == "compare") include("compare.php");
elseif ($pub_page == "restore") include("restore.php");
elseif ($pub_page == "copy") include("copy.php");
elseif ($pub_page == "copyr") include("copyr.php");
elseif ($pub_page == "admin") include("admin.php");
elseif ($pub_page == "changelog") include("changelog.php");
//Si la page a afficher n'est pas définie, on affiche la première
else include("transfert.php");
// Fin du layer transparent
echo "</div></div>";
// Version number at the bottom of the page
require_once ("mod/copylocal/footer.php");
echo "<br/>";
//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");
?>
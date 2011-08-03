<?php
/***************************************************************************
*	filename	: restore.php
*   package     : Copy_local
*	desc.		: affiche les tables locales pour restoration vers la DB distante
*	Author		: ericc - http://www.ogsteam.fr/
*	created		: 10/03/2008
*	modified	: 05/04/2008
***************************************************************************/

// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='copylocal' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");
// initialisation des variables
initvar('link_dist','link_local','query','query2','result' );

//start buffering
ob_start();
?>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function checkAll()
{
var x=document.getElementById("tablelist");
for (var i=0;i<x.length;i++)
  {
  if (x.elements[i].type == "checkbox")
     {
         x.elements[i].checked = true;
     }
  }
}

function uncheckAll()
{
var x=document.getElementById("tablelist");
for (var i=0;i<x.length;i++)
  {
  if (x.elements[i].type == "checkbox")
     {
         x.elements[i].checked = false;
     }
  }
}
//  End -->
</script>
<?php
if (file_exists("mod/copylocal/config.php"))
   {
       require_once("mod/copylocal/config.php");
   } else {
       die ("Vous devez entrer les paramètres de connexions avant !!");
   }
//ouverture de la connexion distante
$link_local = connectSQL($distant['host'] ,$distant['user']  , $distant['password'] , $distant['database'] );
//ouverture de la connexion locale
$link_dist = connectSQL($local['host'] ,$local['user']  , $local['password'] , $local['database'] );

$query = "SHOW TABLES";
$result = mysql_query($query,$link_dist);
//$count = mysql_num_rows($result);
$column = 6;
$i = $column/2;

echo "<form id='tablelist' style='margin:0px;padding:0px;' action='index.php?action=copylocal&page=copyr' method='POST'>";
echo "<table>\n";
echo "<tr><td class='c' colspan='".$column."'>Liste des tables distantes</td></tr>";
echo "<tr><td class='c'>&nbsp;</td><td class='c'>Table</td><td class='c'>Taille locale</td><td class='c'>Taille distante</td><td class='c'>Nb de ligne locale</td><td class='c'>Nb de ligne distante</td></tr>";

echo "<tr>\n";
while ($row = mysql_fetch_assoc($result))
{
    foreach($row as $key=>$value)
    {
        echo "<th><input type='checkbox' value='".$value."' name='tablelist[]' id='".$value."'></th>";
        echo "<th style='text-align: left;'>".$value."</th>";
        $local_table = str_replace($local['prefix'],$distant['prefix'],$value);
        $query2 = "SHOW TABLE STATUS LIKE '".$value."'";
        $query3 = "SHOW TABLE STATUS LIKE '".$local_table."'";
        $result2 = mysql_query($query2,$link_dist);
        $row2 = mysql_fetch_assoc($result2);
        $dbsize = size_info($row2['Data_length'] + $row2['Index_length']);
        echo "<th>".$dbsize."</th>";
        $result2 = mysql_query($query3,$link_local);
        $row3 = mysql_fetch_assoc($result2);
        $dbsize = size_info($row3['Data_length'] + $row3['Index_length']);
        echo "<th>".$dbsize."</th>";
        echo "<th>".$row2['Rows']."</th>";
        echo "<th>".$row3['Rows']."</th>";
    }
    echo "\n</tr>\n<tr>\n";
}
echo "\n</tr>\n";
// Bouton CheckAll et UnCheckAll
echo "\t<tr>\n";
echo "\t\t<th colspan=".$i."><input type='button' name='CheckAll' value='Toutes' onClick='checkAll()'>\n";
echo "\t\t</th>\n";
echo "\t\t<th colspan=".$i."><input type='button' name='UnCheckAll' value='Aucune' onClick='uncheckAll()'>\n";
echo "\t\t</th>\n";
echo "\t</tr>\n";
// ----------------------------
echo "<tr><th colspan='".$column."'><input type='submit' value='Appliquer'></th></tr>";
echo "</table>";
echo "</form>";
// release the buffer
ob_end_flush();
?>
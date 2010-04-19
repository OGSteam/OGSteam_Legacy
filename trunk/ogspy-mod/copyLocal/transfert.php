<?php
/***************************************************************************
*	filename	: transfert.php
*   package     : Copy_local
*	desc.		: Affiche la liste des tables distantes
*	Author		: ericc - http://www.ogsteam.fr/
*	created		: 10/03/2008
*	modified	: 03/04/2008
***************************************************************************/

// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='copylocal' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//Définitions
global $db, $table_prefix, $prefixe;
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
if (file_exists("mod/copy_local/config.php"))
   {
       require_once("mod/copy_local/config.php");
   } else {
       die ("Vous devez entrer les paramètres de connexions avant !!");
   }
//ouverture de la connexion distante
$link_dist = connectSQL($distant['host'] ,$distant['user']  , $distant['password'] , $distant['database'] );

$query = "SHOW TABLES";
$result = mysql_query($query);
//$count = mysql_num_rows($result);
$column = 3;
$i = $column;
$j = $column * 3;

echo "<form id='tablelist' style='margin:0px;padding:0px;' action='index.php?action=copylocal&page=copy' method='POST'>";
echo "<table>\n";
echo "<tr><td class='c' colspan='".$j."'>Liste des tables distantes</td></tr>";
echo "<tr>\n";
while ($row = mysql_fetch_assoc($result))
{
    foreach($row as $key=>$value)
    {
        echo "<th><input type='checkbox' value='".$value."' name='tablelist[]' id='".$value."'></th>";
        echo "<th style='text-align: left;'>".$value."</th>";
        $query2 = "SHOW TABLE STATUS LIKE '".$value."'";
        $result2 = mysql_query($query2);
        $row2 = mysql_fetch_assoc($result2);
        $dbsize = size_info($row2['Data_length'] + $row2['Index_length']);
        echo "<th>".$dbsize."</th>";
        $i--;
    }
    if ($i==0)
    {
        $i = $column;
        echo "\n</tr>\n<tr>\n";
    }
}
while ($i>0)
{
    echo "<th>&nbsp;</th><th>&nbsp</th><th>&nbsp</th>";
    $i--;
}
echo "\n</tr>\n";
// Bouton CheckAll et UnCheckAll
$i = ceil($j/2);
echo "\t<tr>\n";
echo "\t\t<th colspan=".$i."><input type='button' name='CheckAll' value='Toutes' onClick='checkAll()'>\n";
echo "\t\t</th>\n";
echo "\t\t<th colspan=".$i."><input type='button' name='UnCheckAll' value='Aucune' onClick='uncheckAll()'>\n";
echo "\t\t</th>\n";
echo "\t</tr>\n";
// ----------------------------
echo "<tr><th colspan='".$j."'><input type='submit' value='Appliquer'></th></tr>";
echo "</table>";
echo "</form>";
// release the buffer
ob_end_flush();
?>
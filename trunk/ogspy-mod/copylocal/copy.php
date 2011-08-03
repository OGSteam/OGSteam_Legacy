<?php
/***************************************************************************
*	filename	: copy.php
*   package     : Copy_local
*	desc.		: copie le contenu des tables distantes dans la DB locale
*	Author		: ericc - http://www.ogsteam.fr/
*	created		: 10/03/2008
*	modified	: 03/04/2008
***************************************************************************/

// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='copylocal' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//initialisation des variables
initvar('dist_link' , 'loc_link' , 'distant_table' , 'local_table');

//lire les paramètres de connexions
if (file_exists("mod/copylocal/config.php"))
   {
       require_once("mod/copylocal/config.php");
   } else {
       die ("Vous devez entrer les paramètres de connexions avant !!");
   }

//var_dump($pub_tablelist);
// on ouvre les connexions
if (isset($pub_tablelist))
{
    $dist_link = connectSQL($distant['host'] ,$distant['user']  , $distant['password'] , $distant['database']);
    $loc_link = connectSQL($local['host'] ,$local['user']  , $local['password'] , $local['database'] );
}

for ($i=0;$i<count($pub_tablelist);$i++)
{
    $distant_table = $pub_tablelist[$i];
    echo "<br>Traitement de la table distante =>".$distant_table."<br>";
    $local_table = str_replace($distant['prefix'],$local['prefix'],$distant_table);
    echo "Table locale => ".$local_table."<br>";
    // vérif si la table locale existe
    if(!mysql_num_rows( mysql_query("SHOW TABLES LIKE '".$local_table."'",$loc_link)))
    {
        echo "La table n'existe pas, cr&eacute;ation de la table<br>";
        createSQLtable($local_table,$distant_table);
    }
    //Vidage de la table locale
    $query = "TRUNCATE `".$local_table."`";
    $result = mysql_query($query, $loc_link);
    // récupération de tout les lignes de la table
    $table_query = mysql_query("SELECT * FROM `".$distant_table."`",$dist_link);
    // Récupération des champs de la table
    $num_fields = mysql_num_fields($table_query);
    // Nombre de ligne dans la table
    $num_records = mysql_num_rows($table_query);
    echo " Il y a ".$num_records." lignes dans la table distante<br>";
    // compteur d'insert
    $j = 0;
    while($fetch_row = mysql_fetch_array($table_query))
    {
        $insert_sql = "INSERT INTO `".$local_table."` VALUES (";
        for ($n=1;$n<=$num_fields;$n++)
        {
            $m = $n - 1;
            $insert_sql .= "'".mysql_real_escape_string($fetch_row[$m])."', ";
        }
        $insert_sql = substr($insert_sql,0,-2);
        $insert_sql .= ");\n";
        //echo $insert_sql."<br>";
        if (!$result = mysql_query($insert_sql,$loc_link))
        {
            echo "<font color='red'>".mysql_error()."</font>";
        }else
        {
            $j++;
            //echo "Import n°".$j." effectu&eacute; <br>";
        }
    }
    echo $j." ligne(s) import&eacute;e(s)<br>";
}

?>
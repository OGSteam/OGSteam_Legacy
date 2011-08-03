<?php
/***************************************************************************
*	filename	: function.php
*   package     : Copy_local
*	desc.		: Fonctions du module
*	Author		: ericc - http://www.ogsteam.fr/
*	created		: 10/03/2008
*	modified	: 03/04/2008
***************************************************************************/

//-------------------------------------------------------------------------------------------------------------------
// Création du menu
function menu($pub_page){
	global $pages;
	// Definition des pages du module
	$i=-1;
  $pages['fichier'][++$i] = 'transfert';
  $pages['texte'][$i] = '&nbsp;Transfert&nbsp;';
  $pages['admin'][$i] = 1;
  
  $pages['fichier'][++$i] = 'compare';
  $pages['texte'][$i] = '&nbsp;Compare&nbsp;';
  $pages['admin'][$i] = 1;
  
  $pages['fichier'][++$i] = 'restore';
  $pages['texte'][$i] = '&nbsp;Restore&nbsp;';
  $pages['admin'][$i] = 1;

  $pages['fichier'][++$i] = 'admin';
  $pages['texte'][$i] = '&nbsp;Admin&nbsp;';
  $pages['admin'][$i] = 1;

  $pages['fichier'][++$i] = 'changelog';
  $pages['texte'][$i] = '&nbsp;Changelog&nbsp;';
  $pages['admin'][$i] = 1;

  //Construction du menu
	echo "	<table><tr align='center'>";
	for($i=0;$i<count($pages['fichier']);$i++)
		if ( ($pages['admin'][$i] && IsUserAdmin())||(!$pages['admin'][$i]) )
			if ($pub_page != $pages['fichier'][$i])
			{
				echo "\t<td class='c' width='150' onclick=\"window.location = 'index.php?action=copylocal&page=".$pages['fichier'][$i]."';\">";
				echo "<a style='cursor:pointer'><font color='lime'>".$pages['texte'][$i]."</font></a></td>";
			} else
				echo "\t<th width='150'><a>".$pages['texte'][$i]."</a></th>";
	echo "\t\t</tr>\n\t\t</table>";
}
//-------------------------------------------------------------------------------------------------------------------


//-------------------------------------------------------------------------------------------------------------------
// Renvoi 1 si l'utilisateur est admin, coadmin ou manager
function IsUserAdmin(){
	global $user_data;
	if($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1) return 1;
	else return 0;
}
//-------------------------------------------------------------------------------------------------------------------
// Fonction de generation du fichier de config - basé sur la fonction de genaration du ip.php de OGSpy
function generate_config($localhost, $localuser, $localpwd, $localdb, $localprefix, $remotehost, $remoteuser, $remotepwd, $remotedb, $remoteprefix)
{
	$id_php[] = '<?php';
	$id_php[] = '/***************************************************************************';
	$id_php[] = '*	filename	: config.php';
	$id_php[] = '*	generated	: '.date("d/M/Y H:i:s");
	$id_php[] = '***************************************************************************/';
	$id_php[] = '';
	$id_php[] = 'if (!defined("IN_SPYOGAME")) die("Hacking attempt");';
	$id_php[] = '';
	$id_php[] = '//Paramètres de connexion à la base de données locale';
	$id_php[] = '$local["host"] = "'.$localhost.'";';
	$id_php[] = '$local["user"] = "'.$localuser.'";';
	$id_php[] = '$local["password"] = "'.$localpwd.'";';
	$id_php[] = '$local["database"] = "'.$localdb.'";';
	$id_php[] = '$local["prefix"] = "'.$localprefix.'";';
	$id_php[] = '';
	$id_php[] = '//Paramètres de connexion à la base de données distante';
	$id_php[] = '$distant["host"] = "'.$remotehost.'";';
	$id_php[] = '$distant["user"] = "'.$remoteuser.'";';
	$id_php[] = '$distant["password"] = "'.$remotepwd.'";';
	$id_php[] = '$distant["database"] = "'.$remotedb.'";';
	$id_php[] = '$distant["prefix"] = "'.$remoteprefix.'";';
	$id_php[] = '';
	$id_php[] = '?>';
	if (!write_file("mod/copylocal/config.php", "w", $id_php)) {
		die("Impossible de générer le fichier 'config.php', V&eacute;rifiez les droits en &eacute;criture sur le r&eacute;pertoire");
	}
	echo "<font color='lime'>Sauvegarde effectu&eacute;e</font>";
	return;
}
//-------------------------------------------------------------------------------------------------------------------
// connection MySQL
function connectSQL($dbhost,$dbuser,$dbpass,$dbname)
{
    // Try to connect
    $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql '. mysql_error());

    // Select the database
    $db_selected = mysql_select_db($dbname, $conn);
    if (!$db_selected) {die ('Can\'t use foo : ' . mysql_error());}
    return $conn;
}
//------------------------------------------------------------------------------------------------------------------------
// Retourne la taille en KB,MB,GB ...
function size_info($size)
{
 // bytes
        if( $size < 1024 ) {
            return $size . " bytes";
        }
        // kilobytes
        else if( $size < 1024000 ) {
            return round(($size/1024),1). " KB";
        }
        // megabytes
        else {
            return "<font color='red'>".round(($size / 1024000),1) . " MB</font>";
        }
}
//------------------------------------------------------------------------------------------------------------------------
/* initvar() * Initialize variables
* Amit Arora <digitalamit dot com>
* Permission give to use this code for Non-Commericial, Commericial use
* It would be appreciated if you could provide a link to the site */
function initvar()
{
    foreach( func_get_args() as $v )
    {
        if( is_array( $v ) )
        {
            while( list( $key, $value ) = each( $v ) )
            {
                $GLOBALS[$key] = ( !isset($GLOBALS[$key]) ? $value : $GLOBALS[$key] );
            }
        }
        else
        {
            $GLOBALS[$v] = ( !isset($GLOBALS[$v]) ? '' : $GLOBALS[$v] );
        }
    }
}
//------------------------------------------------------------------------------------------------------------------------
// Crée une table MySQL local en fonction des paramètres de la table distante
function createSQLtable($local_table,$distant_table)
{
    global $loc_link,$dist_link,$distant,$local;
    $query = "SHOW CREATE TABLE `".$distant_table."`";
    $result = mysql_query($query,$dist_link);
    $row = mysql_fetch_array($result);
    $createTable = $row[1].";";
    $createTable = str_replace($distant['prefix'],$local['prefix'],$createTable);
    $result2 = mysql_query($createTable,$loc_link);
}
?>
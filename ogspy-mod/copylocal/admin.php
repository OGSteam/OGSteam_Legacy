<?php
/***************************************************************************
*	filename	: admin.php
*   package     : Copy_local
*	desc.		: Page d'administration du module - permet de rentré les données de connexion et de les tester
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
//-------------------------------------------------------------------------------------------------------------------
// Paramètres de configurations transmis par le form
if (isset($pub_submit))
{
    if (($pub_localhost!="") && ($pub_localuser!="") && ($pub_localpwd!="") && ($pub_localdb!="") && ($pub_localprfx!="") && ($pub_remotehost!="") && ($pub_remoteuser!="") && ($pub_remotepwd!="") && ($pub_remotedb!="") && ($pub_remoteprfx!=""))
    {
        generate_config($pub_localhost, $pub_localuser, $pub_localpwd, $pub_localdb, $pub_localprfx, $pub_remotehost, $pub_remoteuser, $pub_remotepwd, $pub_remotedb, $pub_remoteprfx);
    }
}

if (file_exists("mod/copylocal/config.php"))
   {
       require_once("mod/copylocal/config.php");
   }

if (!isset($distant))
{
    $distant=array();
    $distant['host'] = "";
    $distant['user'] = "";
    $distant['password'] = "";
    $distant['database'] = "";
    $distant['prefix'] = "";
}
if (!isset($local))
{
    $local=array();
    require_once("parameters/id.php");
    $local['host'] = $db_host;
    $local['user'] = $db_user;
    $local['password'] = $db_password;
    $local['database'] = $db_database;
    $local['prefix'] = $table_prefix;
}

//-------------------------------------------------------------------------------------------------------------------
// cadre autour des paramètres
echo"<fieldset><legend><b><font color='#0080FF'>Administration&nbsp;";
echo "</font></b></legend>\n";
// Formulaire des paramètres locaux du module
echo "<form name='param_local' style='margin:0px;padding:0px;' action='index.php?action=copylocal&page=admin' enctype='multipart/form-data' method='post'>\n<center>\n";
echo "<table width='60%' border='0'>\n\t<tr>\n";
echo "\t\t<td class='c' colspan='2'>Param&egrave;tres locaux</td>\n";
echo "\t</tr>\n\t<tr>\n";
echo "\t\t<th>Serveur Local&nbsp;:</th><th><input type='text' name='localhost' value='".$local['host']."'></th>\n";
echo "\t</tr>\n\t<tr>\n";
echo "\t\t<th>Username Local&nbsp;:</th><th><input type='text' name='localuser' value='".$local['user']."'></th>\n";
echo "\t</tr>\n\t<tr>\n";
echo "\t\t<th>Password Local&nbsp;:</th><th><input type='text' name='localpwd' value='".$local['password']."'></th>\n";
echo "\t</tr>\n\t<tr>\n";
echo "\t\t<th>Database Locale&nbsp;:</th><th><input type='text' name='localdb' value='".$local['database']."'></th>\n";
echo "\t</tr>\n\t<tr>\n";
echo "\t\t<th>Pr&eacute;fixe Tables Local&nbsp;:</th><th><input type='text' name='localprfx' value='".$local['prefix']."'></th>\n";
echo "\t</tr>\n";
echo "</table>\n";
// Formulaire des paramètres distant du module
echo "<table width='60%' border='0'>\n\t<tr>\n";
echo "\t\t<td class='c' colspan='2'>Param&egrave;tres distant</td>\n";
echo "\t</tr>\n\t<tr>\n";
echo "\t\t<th>Serveur Distant&nbsp;:</th><th><input type='text' name='remotehost' value='".$distant['host']."'></th>\n";
echo "\t</tr>\n\t<tr>\n";
echo "\t\t<th>Username Distant&nbsp;:</th><th><input type='text' name='remoteuser' value='".$distant['user']."'></th>\n";
echo "\t</tr>\n\t<tr>\n";
echo "\t\t<th>Password Distant&nbsp;:</th><th><input type='text' name='remotepwd' value='".$distant['password']."'></th>\n";
echo "\t</tr>\n\t<tr>\n";
echo "\t\t<th>Database Distant&nbsp;:</th><th><input type='text' name='remotedb' value='".$distant['database']."'></th>\n";
echo "\t</tr>\n\t<tr>\n";
echo "\t\t<th>Pr&eacute;fixe Tables Distant&nbsp;:</th><th><input type='text' name='remoteprfx' value='".$distant['prefix']."'></th>\n";
echo "\t</tr>\n";
echo "\t<tr><td class='c' align='center' colspan='2'><input name='submit' type='submit' value='Enregistrer'></td></tr>\n";
echo "</table>\n";
echo "</form>\n";
echo "</fieldset>\n";
// Controle de la connection locale
if (($local['host']!="") && ($local['user']!="") && ($local['password']!="") && ($local['database']!=""))
{
    echo "<fieldset><legend><b><font color='#0080FF'>Test connection locale&nbsp;";
    echo "</font></b></legend>\n";
    @$link = mysql_connect($local['host'] ,$local['user']  , $local['password']);
    if (!$link)
    {
      echo "<p align='center' style='background-color:#232425;'><font size='-1' color='red'>Impossible de se connecter au serveur local<br>";
      echo mysql_error()."</font></p>";
    } else
    {
      echo "<p align='center' style='background-color:#232425;'><font size='-1' color='lime'>Connexion au serveur local r&eacute;ussie<br>";
      if (mysql_select_db($local['database']))
      {
          echo "Connexion &agrave; la base de donn&eacute;es r&eacute;ussie</font></p>";
      } else
      {
          echo "<font color='red'>Impossible de se connecter &agrave; la base de donn&eacute;es ". mysql_error()." </font</p>";
      }
      mysql_close($link);
    }
    echo "</fieldset>\n";
}
// Controle de la connection distante
if (($distant['host']!="") && ($distant['user']!="") && ($distant['password']!="") && ($distant['database']!=""))
{
    echo "<fieldset><legend><b><font color='#0080FF'>Test connection distante&nbsp;";
    echo "</font></b></legend>\n";
    @$link = mysql_connect($distant['host'] ,$distant['user']  , $distant['password']);
    if (!$link)
    {
      echo "<p align='center' style='background-color:#232425;'><font size='-1' color='red'>Impossible de se connecter au serveur distant<br>";
      echo mysql_error()."</font></p>";
    } else
    {
      echo "<p align='center' style='background-color:#232425;'><font size='-1' color='lime'>Connexion au serveur distant r&eacute;ussie<br>";
      if (mysql_select_db($distant['database']))
      {
          echo "Connexion &agrave; la base de donn&eacute;es r&eacute;ussie</font></p>";
      } else
      {
          echo "<font color='red'>Impossible de se connecter &agrave; la base de donn&eacute;es ". mysql_error() ."</font></p>";
      }
      mysql_close($link);
    }
    echo "</fieldset>\n";
}

?>
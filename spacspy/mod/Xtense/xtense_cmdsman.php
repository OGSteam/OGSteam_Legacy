<?php
/**
* xtense_cdmsman.php
* @package Xtense
*  @author Naqdazar, then modified by OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

global $pub_getcommand, $server_config;


if (defined("XTENSE_PLUGIN_DEBUG"))  $fp_plgcmds = fopen("xtense_debug/xtense_commands.txt","a"); // fichier log commande plugin

///////////////////////////////////////////////////////
// COMMANDES SPÉCIALES, récupération version serveur //
///////////////////////////////////////////////////////

if (isset($pub_getcommand)) 
{
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "Réception commande plugin: ".$pub_getcommand."\n");
    if ($pub_getcommand=="ogspyversion") 
	{
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "Version serveur: ".$server_config["version"]."\n");
		if (defined("XTENSE_PLUGIN_DEBUG")) fclose($fp_plgcmds);
		SendHttpStatusCode("771", true, true, $server_config["version"]) ;
    }
    elseif ($pub_getcommand=="getservername") 
	{
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "Nom serveur: ".$server_config["servername"]."\n");
        if (defined("XTENSE_PLUGIN_DEBUG")) fclose($fp_plgcmds);
        SendHttpStatusCode("771", true, true, $server_config["servername"]) ;
    }
    elseif ($pub_getcommand=="probenotifymode") 
	{
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "demande recherche du mode de notification...\n");
        if (defined("XTENSE_PLUGIN_DEBUG")) fclose($fp_plgcmds);
        SendHttpStatusCode("771") ;
    }
    elseif ($pub_getcommand=="getscriptversion") 
	{
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "demande version script...\n");
        if (defined("XTENSE_PLUGIN_DEBUG")) fclose($fp_plgcmds);
        SendHttpStatusCode("771", true, true, OGSPY_scriptversion) ;
    }
    //elseif ($pub_getcommand=="getfriendlyallys") 
	//{
        //if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "demande liste alliance amies...\n");
        //if (defined("XTENSE_PLUGIN_DEBUG")) fclose($fp_plgcmds);
        //SendHttpStatusCode("771", true, true, $server_config['allied']) ;
    //}
    //elseif ($pub_getcommand=="getcatallieslists") 
	//{
        //if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "demande liste alliance amies, enemies, commerciales...\n");
        //if (defined("XTENSE_PLUGIN_DEBUG")) fclose($fp_plgcmds);
        //SendHttpStatusCode("771", true, true, $server_config['allied']."<|>".$server_config['xtense_ogspnaalliesnames']."<|>".$server_config['xtense_ogsenemyallies']."<|>".$server_config['xtense_ogstradingallies']) ;
    //}
    //elseif ($pub_getcommand=="gettop100playerslist") 
	//{
		//if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "demande liste top 100 joueurs...\n");
        //$tmpgc_timerankdata = To_Std_Update_Time(time()) ; 
        //$request = "select player from ".TABLE_RANK_PLAYER_POINTS." where rank<101 and datadate='".$tmpgc_timerankdata."'";
        //$result = $db->sql_query($request);
        //$topplayerslist="";
        //$tpllst_sep="";
        //while (list($player) = $db->sql_fetch_row($result)) 
		//{
            //$toppalyerslist.=$tpllst_sep.$player;
            //$tpllst_sep=",";
        //}
        //if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "liste top 100 joueurs:".$toppalyerslist."\n");
        //if (defined("XTENSE_PLUGIN_DEBUG")) fclose($fp_plgcmds);                   
        //SendHttpStatusCode("771", true, true, $toppalyerslist) ;
    //}                         
    else 
	{
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "Commande plugin non reconnue\n");
        if (defined("XTENSE_PLUGIN_DEBUG")) fclose($fp_plgcmds);
        SendHttpStatusCode("779");
    }
}
if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "---------------------------------------------------------\n");
?>
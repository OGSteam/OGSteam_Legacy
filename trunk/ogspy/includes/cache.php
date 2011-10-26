<?php
/** $Id: galaxy.php 7194 2011-09-27 07:42:42Z superbox $ **/
/**
* Fonctions relatives aux données galaxies/planètes
* @package OGSpy
* @subpackage main
* @author Machine ( inspiré du syteme fluxbb )
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 3.07 
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}


/**
 * Genere le fichier cache
 */
function generate_config_cache()
{
	global $db , $table_prefix ,$server_config;
    
    $request = "select * from " . TABLE_CONFIG;
    $result = mysql_query($request);
    
    // Output config as PHP code
    while ($cur_config_item = $db->sql_fetch_row($result))
	$output[$cur_config_item[0]] = stripslashes($cur_config_item[1]);
    	
     $fh = @fopen('cache/cache_config.php', 'wb');
	if (!$fh) { 
	           if (!defined('UPGRADE_IN_PROGRESS'))
                    {
                    	echo '<p>Impossible d écrire sur le fichier cache. Vérifier les droits d acces au dossier  \'cache\' </p>';  
                        log_("erreur_config_cache"); 
                    }

	               }
	else
    {
     	fwrite($fh, '<?php'."\n\n".'define(\'OGSPY_CONFIG_LOADED\', 1);'."\n\n".'$server_config = '.var_export($output, true).';'."\n\n".'?>');

	fclose($fh);   
        
    }	
     
     // on recupere quand meme les infos 
     // droit au dossier non-bloquant
while (list($name, $value) = mysql_fetch_row($result)) {
       $server_config[$name] = stripslashes($value);
   return $server_config ;
  }
     


}


/**
 * Genere tous les fichiers caches 
 */
function generate_all_cache()
{
        generate_config_cache();
        
}




?>
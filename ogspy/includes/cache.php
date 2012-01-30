<?php
/** $Id: galaxy.php 7194 2011-09-27 07:42:42Z superbox $ **/
/**
* Fonctions relatives aux donn�es galaxies/plan�tes
* @package OGSpy
* @subpackage main
* @author Machine ( inspir� du syteme fluxbb )
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
    $result = $db->sql_query($request);
    
    // Output config as PHP code
    while ($cur_config_item = $db->sql_fetch_row($result))
	$output[$cur_config_item[0]] = stripslashes($cur_config_item[1]);
    	
    $fh = @fopen('cache/cache_config.php', 'wb');
	if (!$fh) { 
	           if (!defined('UPGRADE_IN_PROGRESS'))
                    {
                    	echo '<p>Impossible d �crire sur le fichier cache. V�rifier les droits d acces au dossier  \'cache\' </p>';  
                        log_("erreur_config_cache"); 
                    }

	               }
	else
    {
     	fwrite($fh, '<?php'."\n\n".'define(\'OGSPY_CONFIG_LOADED\', 1);'."\n\n".'$server_config = '.var_export($output, true).';'."\n\n".'?>');

	fclose($fh);   
        
    }	
     
    }
    
    
/**
 * Genere le fichier mod
 * 
 */
function generate_mod_cache()
{
	global $db , $table_prefix ,$server_config;
    
   $query = "SELECT action ,  menu ,  root, link, admin_only FROM ".TABLE_MOD." WHERE active = '1' order by position, title";
   $result = $db->sql_query($query);
   
    while ($row = $db->sql_fetch_assoc($result)) {
    $mod[$row['action']] = $row;
    }
  
    $fh = @fopen('cache/cache_mod.php', 'wb');
	if (!$fh) { 
	           if (!defined('UPGRADE_IN_PROGRESS'))
                    {
                    	echo '<p>Impossible d �crire sur le fichier cache. V�rifier les droits d acces au dossier  \'cache\' </p>';  
                        log_("erreur_mod_cache"); 
                    }

	               }
	else
    {
     	fwrite($fh, '<?php'."\n\n".'define(\'OGSPY_MOD_LOADED\', 1);'."\n\n".'$cache_mod = '.var_export($mod, true).';'."\n\n".'?>');

	fclose($fh);   
        
    }	
     
    }
  
  
  
   
    
    


/**
 * Genere tous les fichiers caches 
 */
function generate_all_cache()
{
        //'on supprime tous les fichier php du dossier cache'
        $files = glob('cache/*.php');
        foreach ($files as $filename){unlink($filename);}  
        
        // on les g�n�re a nouveau
        generate_config_cache();
        generate_mod_cache;
        
}

?>
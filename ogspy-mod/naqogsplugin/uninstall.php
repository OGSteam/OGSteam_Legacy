<?php
define("IN_SPYOGAME", true);
require_once("common.php");
require_once("ogsplugmod_func.php");

global $_SERVER, $pub_modaction, $pub_mod_id, $server_config, $banner_selected, $user_data;

if ($user_data['user_skin'] == "") { // $user_skin
	$link_css = $server_config["default_skin"];
} else $link_css = $user_data['user_skin'];

//global $table_prefix;


$ogspy_rootscript = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
$modman_page = $ogspy_rootscript.'?action=administration&subaction=mod';
$thismid_uninstall = $ogspy_rootscript."?action=mod_uninstall&mod_id=$pub_mod_id";
$path_to_header = preg_replace('/index.php/', '', $ogspy_rootscript);
//echo $path_to_header;

if ($pub_modaction!='douninstall') {
    require_once('views/page_header.php');
    ?>

        
          <div style="width:400px" align="center">
          <fieldset ><legend>Avertissement : Désinstallation du module OGS Plugin</legend>
            <div align="center" >
            
              <table>
              
                <thead >
                Désinstaller le module va effacer ses paramètres. Souhaitez-vous vraiment désinstaller le module?<br><br>
                </thead>
                <tbody>
                  <tr align="center">
                    <td>
                      <form method='POST' action='<?php echo $thismid_uninstall."&modaction=douninstall"; ?>' >

                      <input type="submit" value="Oui">
                      </form>
                      </td><td width="25">&nbsp;</td> <td>
                      <form method='POST' action='<?php echo $modman_page; ?>' >

                      <input type="submit" value="Annuler">
                      </form>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </fieldset>
        </div>

    <?php
    require_once('views/page_tail.php');
    exit();
}

if (file_exists("ogsplugin.php")) unlink("ogsplugin.php");


$query = "DELETE FROM ".TABLE_MOD." WHERE action='naq_ogsplugin'";
$db->sql_query($query);

//----------------------------- -> regexpr set config_value = '"\.\$pub_.*?\."'  -> ""

  $request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_logogslogon'";
	$db->sql_query($request);

        //
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_logogsspyadd'";
	$db->sql_query($request);

        //
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_logogsgalview'";
	$db->sql_query($request);

        //
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_logogsplayerstats'";
	$db->sql_query($request);  //naq_logogsplayerstats - naq_logogsallystats -  naq_logogsallyhistory - naq_logogssqlfailure

        //
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_logogsallystats'";
	$db->sql_query($request);

        //
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_logogsallyhistory'";
	$db->sql_query($request);
	
	//Pages bâtiments, technos, etc
	
	
  //logogsuserbuildings
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_logogsuserbuildings'";
	$db->sql_query($request);  

  //logogsusertechnos
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_logogsusertechnos'";
	$db->sql_query($request);  

  //logogsuserdefence
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_logogsuserdefence'";
	$db->sql_query($request);  	
	
	
	//Pages empires
	//logogsuserplanetempire
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_logogsuserplanetempire'";
	$db->sql_query($request);
	
  //logogsuserplanetmoon
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_logogsusermoonempire'";
	$db->sql_query($request);
	
  //logunallowconnattempt
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_logunallowedconnattempt'";
	$db->sql_query($request);
	
	
	//gest pages
	
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_handlegalaxyviews'";
	$db->sql_query($request);
	
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_handleplayerstats'";
	$db->sql_query($request);
	
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_handleallystats'";
	$db->sql_query($request);
	
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_handleespioreports'";
	$db->sql_query($request);
	
	

  // forcestricnameuniv - bloquer les données provenant de serveur ogame non associé
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_forcestricnameuniv'";
	$db->sql_query($request);

  //
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_logogssqlfailure'";
	$db->sql_query($request);
	
	//
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_ogsplugin_numuniv'";
	$db->sql_query($request);


  //
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_ogsplugin_nameuniv'";
	$db->sql_query($request);
	
	// version http - 
	  
	//$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_ogshttp_headerver'";
	//$db->sql_query($request);
	
	// diplomatie
	
  //
  $request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_ogspnaalliesnames'";
	$db->sql_query($request);
	//
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_ogsenemyallies'";
	$db->sql_query($request);
	// 
	$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'naq_ogstradingallies'";
	$db->sql_query($request);	

?>



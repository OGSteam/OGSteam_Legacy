<?php
/***********************************************************************

************************************************************************/


if (!defined('FORUM_ROOT'))
	define('FORUM_ROOT', '../../../');
require FORUM_ROOT.'include/common.php';
require FORUM_ROOT.'include/common_admin.php';

if (!$forum_user['is_admmod'])
	message($lang_common['No permission']);

// Load the admin.php language file
require FORUM_ROOT.'lang/'.$forum_user['language'].'/admin.php';


 // Change details
if (isset($_POST['general']))
{

                 $o_ogameportail_systeme = trim($_POST['o_ogameportail_systeme']);
                  $o_ogameportail_galaxie = trim($_POST['o_ogameportail_galaxie']);
                  $o_ogameportail_ogspy_prefixe  = trim($_POST['o_ogameportail_ogspy_prefixe']);
                   
                   
                             ///valeur numerique ?
                            
                // systeme
                             if (is_numeric($o_ogameportail_systeme))
                             {
                             
                             	$query_o_ogameportail_systeme = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_systeme).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_systeme\''
	);

             	$forum_db->query_build($query_o_ogameportail_systeme) or error(__FILE__, __LINE__);




                             }
                             else
                             {
                             echo "Qu'est-ce que tu fais, petit malin ? ;)";
                             }

        
                      ///galaxie
                            if (is_numeric($o_ogameportail_galaxie))
                             {
                             
                             	$query_o_ogameportail_galaxie = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_galaxie).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_galaxie\''
	);

             	$forum_db->query_build($query_o_ogameportail_galaxie) or error(__FILE__, __LINE__);




                             }
                             else
                             {
                             echo "Qu'est-ce que tu fais, petit malin ? ;)";
                             }

                       	$query_o_ogameportail_ogspy_prefixe = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_ogspy_prefixe).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_ogspy_prefixe\''
	);

             	$forum_db->query_build($query_o_ogameportail_ogspy_prefixe) or error(__FILE__, __LINE__);










       	require_once FORUM_ROOT.'include/cache.php';
	generate_config_cache();



	redirect(forum_link('extensions/ogame_portail/admin/ogame_portail.php'), $lang_admin['Redirect']);
}

      ///maj

  if (isset($_POST['topmaj']))
{

                 $o_ogameportail_pan_top_maj = trim($_POST['o_ogameportail_pan_top_maj']);


                   
                             ///valeur numerique ?
                            
                // topmaj


                             	$query_o_ogameportail_pan_top_maj = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_pan_top_maj).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_pan_top_maj\''
	);

             	$forum_db->query_build($query_o_ogameportail_pan_top_maj) or error(__FILE__, __LINE__);












       	require_once FORUM_ROOT.'include/cache.php';
	generate_config_cache();



	redirect(forum_link('extensions/ogame_portail/admin/ogame_portail.php'), $lang_admin['Redirect']);
}




     ///top espionnage

  if (isset($_POST['topspy']))
{

                 $o_ogameportail_pan_top_spy = trim($_POST['o_ogameportail_pan_top_spy']);
                 $o_ogameportail_pan_top_spy_total = trim($_POST['o_ogameportail_pan_top_spy_total']);


                   
                             ///valeur numerique ?
                            
                // topmaj


                             	$query_o_ogameportail_pan_top_spy = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_pan_top_spy).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_pan_top_spy\''
	);

             	$forum_db->query_build($query_o_ogameportail_pan_top_spy) or error(__FILE__, __LINE__);


                 	$query_o_ogameportail_pan_top_spy_total = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_pan_top_spy_total).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_pan_top_spy_total\''
	);

             	$forum_db->query_build($query_o_ogameportail_pan_top_spy_total) or error(__FILE__, __LINE__);










       	require_once FORUM_ROOT.'include/cache.php';
	generate_config_cache();



	redirect(forum_link('extensions/ogame_portail/admin/ogame_portail.php'), $lang_admin['Redirect']);
}





  if (isset($_POST['topflop']))
{

                 $o_ogameportail_pan_topflop = trim($_POST['o_ogameportail_pan_topflop']);
                 $o_ogameportail_pan_topflop_order = trim($_POST['o_ogameportail_pan_topflop_order']);


                   

                            
                // topmaj


                             	$query_o_ogameportail_pan_topflop = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_pan_topflop).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_pan_topflop\''
	);

             	$forum_db->query_build($query_o_ogameportail_pan_topflop) or error(__FILE__, __LINE__);


                 	$query_o_ogameportail_pan_topflop_order = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_pan_topflop_order).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_pan_topflop_order\''
	);

             	$forum_db->query_build($query_o_ogameportail_pan_topflop_order) or error(__FILE__, __LINE__);










       	require_once FORUM_ROOT.'include/cache.php';
	generate_config_cache();



	redirect(forum_link('extensions/ogame_portail/admin/ogame_portail.php'), $lang_admin['Redirect']);
}




   /// panneau qui nous sonde ( alerte.php )
  if (isset($_POST['alerte']))
{

                 $o_ogameportail_pan_qns_pspy = trim($_POST['o_ogameportail_pan_qns_pspy']);
                  $o_ogameportail_pan_qns_mspy  = trim($_POST['o_ogameportail_pan_qns_mspy']);
                  $o_ogameportail_pan_qns_topally  = trim($_POST['o_ogameportail_pan_qns_topally']);
                  $o_ogameportail_pan_qns_topjoueur = trim($_POST['o_ogameportail_pan_qns_topjoueur']);
                  $o_ogameportail_pan_qns_lastspy   = trim($_POST['o_ogameportail_pan_qns_lastspy']);
                  $o_ogameportail_pan_qns_day   = trim($_POST['o_ogameportail_pan_qns_day']);

                   

                            


                             	$query_o_ogameportail_pan_qns_pspy = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_pan_qns_pspy).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_pan_qns_pspy\''
	);

             	$forum_db->query_build($query_o_ogameportail_pan_qns_pspy) or error(__FILE__, __LINE__);

                                $query_o_ogameportail_pan_qns_mspy = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_pan_qns_mspy).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_pan_qns_mspy\''
	);

             	$forum_db->query_build($query_o_ogameportail_pan_qns_mspy) or error(__FILE__, __LINE__);


                                 $query_o_ogameportail_pan_qns_topally = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_pan_qns_topally).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_pan_qns_topally\''
	);

             	$forum_db->query_build($query_o_ogameportail_pan_qns_topally) or error(__FILE__, __LINE__);


                                 $query_o_ogameportail_pan_qns_topjoueur = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_pan_qns_topjoueur).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_pan_qns_topjoueur\''
	);

             	$forum_db->query_build($query_o_ogameportail_pan_qns_topjoueur) or error(__FILE__, __LINE__);


                                 $query_o_ogameportail_pan_qns_lastspy = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_pan_qns_lastspy).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_pan_qns_lastspy\''
	);

             	$forum_db->query_build($query_o_ogameportail_pan_qns_lastspy) or error(__FILE__, __LINE__);


                                  $query_o_ogameportail_pan_qns_day = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_pan_qns_day).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_pan_qns_day\''
	);

             	$forum_db->query_build($query_o_ogameportail_pan_qns_day) or error(__FILE__, __LINE__);





       	require_once FORUM_ROOT.'include/cache.php';
	generate_config_cache();



	redirect(forum_link('extensions/ogame_portail/admin/ogame_portail.php'), $lang_admin['Redirect']);
}













   /// panneau gameogame
  if (isset($_POST['gog']))
{

                 $o_ogameportail_pan_gog = trim($_POST['o_ogameportail_pan_gog']);


                   

                            
                


                             	$query_o_ogameportail_pan_gog = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_pan_gog).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_pan_gog\''
	);

             	$forum_db->query_build($query_o_ogameportail_pan_gog) or error(__FILE__, __LINE__);












       	require_once FORUM_ROOT.'include/cache.php';
	generate_config_cache();



	redirect(forum_link('extensions/ogame_portail/admin/ogame_portail.php'), $lang_admin['Redirect']);
}





 /// ratio
  if (isset($_POST['ratio']))
{

                 $o_ogameportail_ratio = trim($_POST['o_ogameportail_ratio']);


                   

                            
                


                             	$query_o_ogameportail_ratio = array(
		'UPDATE'	=> 'config',
		'SET'		=> 'conf_value=\''.$forum_db->escape($o_ogameportail_ratio).'\'',
		'WHERE'		=> 'conf_name=\'o_ogameportail_ratio\''
	);

             	$forum_db->query_build($query_o_ogameportail_ratio) or error(__FILE__, __LINE__);












       	require_once FORUM_ROOT.'include/cache.php';
	generate_config_cache();



	redirect(forum_link('extensions/ogame_portail/admin/ogame_portail.php'), $lang_admin['Redirect']);
}













// Setup breadcrumbs
$forum_page['crumbs'] = array(
	array($forum_config['o_board_title'], forum_link($forum_url['index'])),
	array($lang_admin['Forum administration'], forum_link($forum_url['admin_index'])),
	$lang_admin['Settings'],

);

define('FORUM_PAGE_SECTION', 'options');
define('FORUM_PAGE', 'ogame_portail');
require FORUM_ROOT.'header.php';

// START SUBST - <!-- forum_main -->
ob_start();

?>
<div id="brd-main" class="main sectioned admin">

<?php echo generate_admin_menu(); ?>

	<div class="main-head">
		<h1><span>{ ogame portail  }</span></h1>
	</div>
	


	<div class="main-content frm">
		<div class="frm-head">
			<h2><span>infos ogs</span></h2>
		</div>




        	<form class="frm-form" method="post" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/admin/ogame_portail.php') ?>?general=foo">
			<div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link('extensions/ogame_portail/admin/ogame_portail.php').'?general=foo') ?>" />
			</div>
			<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
				<div class="frm-fld text">
                                     <label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label">nb de Galaxie ?</span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_galaxie" size="3" maxlength="3" value="<?php echo forum_htmlencode($forum_config['o_ogameportail_galaxie']) ?>" /></span>
					</label>


				</div>
				
				  <div class="frm-fld text">
				 <label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label">nb de systeme ?</span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_systeme" size="3" maxlength="3" value="<?php echo forum_htmlencode($forum_config['o_ogameportail_systeme']) ?>" /></span>
					</label>

				 </div>
					  <div class="frm-fld text">
				 <label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label">Prefixe des tables Ogspy </span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_ogspy_prefixe" size="20" maxlength="20" value="<?php echo forum_htmlencode($forum_config['o_ogameportail_ogspy_prefixe']) ?>" /></span>
					</label>

				 </div>
				
				

			</fieldset>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" class="button" name="general" value="submit" /></span>
			</div>
		</form>
        
        
        
        


        
        
        

        </div>


	<div class="main-content frm">
		<div class="frm-head">
			<h2><span>panneau top mise a jour</span></h2>
		</div>


	
	 <form class="frm-form" method="post" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/admin/ogame_portail.php') ?>?topmaj=foo">
			<div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link('extensions/ogame_portail/admin/ogame_portail.php').'?topmaj=foo') ?>" />
			</div>
			<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
				<div class="frm-fld text">
                                     <label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label">nb joueur </span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_pan_top_maj" size="3" maxlength="3" value="<?php echo forum_htmlencode($forum_config['o_ogameportail_pan_top_maj']) ?>" /></span>
					</label>


				</div>
				

				
				

			</fieldset>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" class="button" name="topmaj" value="submit" /></span>
			</div>
		</form>
        

	
	

	</div>
	
	

	<div class="main-content frm">
		<div class="frm-head">
			<h2><span>Panneau top espionnage </span></h2>
		</div>
	
	
	  	 <form class="frm-form" method="post" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/admin/ogame_portail.php') ?>?topspy=foo">
			<div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link('extensions/ogame_portail/admin/ogame_portail.php').'?topspy=foo') ?>" />
			</div>
			<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
				<div class="frm-fld text">
                                     <label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label">nb joueur </span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_pan_top_spy" size="3" maxlength="3" value="<?php echo forum_htmlencode($forum_config['o_ogameportail_pan_top_spy']) ?>" /></span>
					</label>
	</div>
				
                             <fieldset class="frm-group">
					<legend><span>nombre d espionnage</span></legend>
					<div class="radbox"><label for="fld<?php echo ++$forum_page['fld_count'] ?>"><input type="radio" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_pan_top_spy_total" value="0"<?php if ($forum_config['o_ogameportail_pan_top_spy_total'] == '0') echo ' checked="checked"' ?> /> sans</label></div>
					<div class="radbox"><label for="fld<?php echo ++$forum_page['fld_count'] ?>"><input type="radio" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_pan_top_spy_total" value="1"<?php if ($forum_config['o_ogameportail_pan_top_spy_total'] == '1') echo ' checked="checked"' ?> /> avec </label></div>

				</fieldset>

			</fieldset>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" class="button" name="topspy" value="submit" /></span>
			</div>
		</form>
	
	
	

	</div>
        
        
        

	<div class="main-content frm">
		<div class="frm-head">
			<h2><span>paneau top flop</span></h2>
		</div>

                
                
                
                

                
                   <form class="frm-form" method="post" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/admin/ogame_portail.php') ?>?topflop=foo">
			<div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link('extensions/ogame_portail/admin/ogame_portail.php').'?topflop=foo') ?>" />
			</div>
			<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
				<div class="frm-fld text">
                                     <label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label">nb joueur </span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_pan_topflop" size="3" maxlength="3" value="<?php echo forum_htmlencode($forum_config['o_ogameportail_pan_topflop']) ?>" />fonction desactive</span>
					</label>
	</div>
				
                             <fieldset class="frm-group">
					<legend><span>ordre</span></legend>
					<div class="radbox"><label for="fld<?php echo ++$forum_page['fld_count'] ?>"><input type="radio" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_pan_topflop_order" value="0"<?php if ($forum_config['o_ogameportail_pan_topflop_order'] == '0') echo ' checked="checked"' ?> /> descendant</label></div>
					<div class="radbox"><label for="fld<?php echo ++$forum_page['fld_count'] ?>"><input type="radio" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_pan_topflop_order" value="1"<?php if ($forum_config['o_ogameportail_pan_topflop_order'] == '1') echo ' checked="checked"' ?> /> ascendant </label></div>

				</fieldset>

			</fieldset>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" class="button" name="topflop" value="submit" /></span>
			</div>
		</form>
                
                
                
                
                
                
                
                
                
                
                
                
                

	</div>
        
        
        
        

	<div class="main-content frm">
		<div class="frm-head">
			<h2><span>panneau qui nous sondes</span></h2>
		</div>

	 <form class="frm-form" method="post" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/admin/ogame_portail.php') ?>?alerte=foo">
			<div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link('extensions/ogame_portail/admin/ogame_portail.php').'?alerte=foo') ?>" />
			</div>
			<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
				<div class="frm-fld text">
                                     <label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label">nb de jour  </span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_pan_qns_day" size="3" maxlength="3" value="<?php echo forum_htmlencode($forum_config['o_ogameportail_pan_qns_day']) ?>" /> Nomre de jours avec lesquels sont calcules les stats</span>
					</label>


				</div>

			</fieldset>
			
			
				<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
				<div class="frm-fld text">
                                     <label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label">le plus espionne  </span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_pan_qns_pspy" size="3" maxlength="3" value="<?php echo forum_htmlencode($forum_config['o_ogameportail_pan_qns_pspy']) ?>" /> Nomre de personne figurant dans les plus espionné</span>
					</label>


				</div>


				<div class="frm-fld text">
                                     <label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label">le moins espionne  </span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_pan_qns_mspy" size="3" maxlength="3" value="<?php echo forum_htmlencode($forum_config['o_ogameportail_pan_qns_mspy']) ?>" /> Nomre de personne figurant dans les moins espionné</span>
					</label>


				</div>


				<div class="frm-fld text">
                                     <label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label">top alliances actives  </span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_pan_qns_topally" size="3" maxlength="3" value="<?php echo forum_htmlencode($forum_config['o_ogameportail_pan_qns_topally']) ?>" /> </span>
					</label>


				</div>

				<div class="frm-fld text">
                                     <label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label">top joueurs actifs  </span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_pan_qns_topjoueur" size="3" maxlength="3" value="<?php echo forum_htmlencode($forum_config['o_ogameportail_pan_qns_topjoueur']) ?>" /> </span>
					</label>


				</div>


				<div class="frm-fld text">
                                     <label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label">dernier espionnage </span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_pan_qns_lastspy" size="3" maxlength="3" value="<?php echo forum_htmlencode($forum_config['o_ogameportail_pan_qns_lastspy']) ?>" /> </span>
					</label>


				</div>

			</fieldset>
			
			


			<div class="frm-buttons">
				<span class="submit"><input type="submit" class="button" name="alerte" value="submit" /></span>
			</div>
		</form>

		
		
		
		
		
		
		
		

	</div>




	<div class="main-content frm">
		<div class="frm-head">
			<h2><span>panneau gameogame</span></h2>
		</div>
	
	
	 <form class="frm-form" method="post" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/admin/ogame_portail.php') ?>?gog=foo">
			<div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link('extensions/ogame_portail/admin/ogame_portail.php').'?gog=foo') ?>" />
			</div>
			<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
				<div class="frm-fld text">
                                     <label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label">nb joueur </span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_pan_gog" size="3" maxlength="3" value="<?php echo forum_htmlencode($forum_config['o_ogameportail_pan_gog']) ?>" /></span>
					</label>


				</div>
				

				
				

			</fieldset>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" class="button" name="gog" value="submit" /></span>
			</div>
		</form>
        

	
	

	</div>


	
	
<?php	
/// ratio

?>

	<div class="main-content frm">
		<div class="frm-head">
			<h2><span>Ratio ( nb de post par mois pour y acceder )</span></h2>
		</div>
	
	
	 <form class="frm-form" method="post" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/admin/ogame_portail.php') ?>?ratio=foo">
			<div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link('extensions/ogame_portail/admin/ogame_portail.php').'?ratio=foo') ?>" />
			</div>
			<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
				<div class="frm-fld text">
                                     <label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label">ratio </span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="o_ogameportail_ratio" size="3" maxlength="3" value="<?php echo forum_htmlencode($forum_config['o_ogameportail_ratio']) ?>" /></span>
					</label>


				</div>
				

				
				

			</fieldset>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" class="button" name="ratio" value="submit" /></span>
			</div>
		</form>
        

	
	

	</div>

	

	

</div>
<?php

$tpl_temp = trim(ob_get_contents());
$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
ob_end_clean();
// END SUBST - <!-- forum_main -->

require FORUM_ROOT.'footer.php';

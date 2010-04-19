<?php

/***************************************************************************
 *                                Block_Ip_Host_portal.php
 *                            -------------------
 *   
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   Block à intégrer dans le Portail phpBB3
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
// language
	$user->add_lang('portal/block_ip_host_portal_lang');
	
// ip et host
 
$ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : $REMOTE_ADDR ); 
ob_start(); 
echo $host=gethostbyaddr($ip); 
$afficher_host = ob_get_contents(); 
ob_end_clean();  
 
// template
	$template->assign_vars(array(	
         'HOST' => $afficher_host, 
         'IP' => $ip)
		 ); 		 
		 
?>
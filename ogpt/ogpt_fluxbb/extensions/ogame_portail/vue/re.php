<?php


/***********************************************************************


************************************************************************/


if (!defined('FORUM_ROOT'))
	define('FORUM_ROOT', '../../../');
require FORUM_ROOT.'include/common.php';

/// appel du fichier fonction du portail :
require FORUM_ROOT.'extensions/ogame_portail/include/fonction.php';


// Load the viewforum.php language file
require FORUM_ROOT.'lang/'.$forum_user['language'].'/forum.php';



// Setup breadcrumbs
$forum_page['crumbs'] = array(
	array($forum_config['o_board_title'], forum_link($forum_url['index'])),
	forum_htmlencode($forum_url['index'])
);


define('FORUM_PAGE', 'recherche OGS');
define('FORUM_PAGE_TYPE', 'forum');
require FORUM_ROOT.'header.php';

// START SUBST - <!-- forum_main -->
ob_start();




/// filtre joueur non inscrit :



if ($forum_user['is_guest']) 
{
echo '<script> alert("Vous devez vous logguer et etre inscrit pour acceder a la page de coommerce !") </script>';

message($lang_common['No view']);



}



/// appel du filtre ratio +incrementation  la bdd utilisateur ( stat  possible ulterieurement)
// nombre de mois depuis l'inscription
$time=time();
/// 1 journée en seconde
$j=(60*60*24);
$jj=($time-$j);
/// il faut avoir poster dans la journée qui precede pour aceder aux mods ...
if (  $jj > $forum_user['last_post'] )

{ 
echo '<script> alert("Vous devez poster pour acceder a cette section") </script>';
message($lang_common['No view']);
}





// incrementation du ratio utilisateur ( pour statisqtique utlerieur
$forum_user['ratio']++;
$forum_db->query('UPDATE '.$forum_db->prefix.'users SET ratio='.$forum_user['ratio'].' WHERE id='.$forum_user['id']) or error('Unable to update users ratio', __FILE__, __LINE__, $db->error());



	
	
	
	
?>





<?php

		
		
		
		
		
		




($hook = get_hook('vf_end')) ? eval($hook) : null;

$tpl_temp = trim(ob_get_contents());
$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
ob_end_clean();
// END SUBST - <!-- forum_main -->



require FORUM_ROOT.'footer.php';




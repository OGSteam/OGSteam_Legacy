<?php
/***************************************************************************
* block_whos_on_line_lang (Additional variables used by portal)
* @package language français
* @copyright (c) 2007 sjpphpbb http://sjpphpbb.net/phpbb3/portal.php
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
 ***************************************************************************/
 
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

/***************************************************************************
* DEVELOPERS PLEASE NOTE
*
* All language files should use UTF-8 as their encoding and the files must not contain a BOM.
*
* Placeholders can now contain order information, e.g. instead of
* 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
* translators to re-order the output of data while ensuring it remains correct
*
* You do not need this where single placeholders are used, e.g. 'Message %d' is fine
* equally where a string contains only two placeholders which are used to wrap text
* in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 ***************************************************************************/

$lang = array_merge($lang, array(

		'COOPYRIGHT'		=> 'copyright - By - sjpphppbb http://sjpphpbb.net/phpbb3/',		
		'FILES_ATTACHMENTS'			=> 'Statistique des fichiers joints',
		'FILES_PER_DAY'				=> 'Fichiers joints par jour',
		'FILES_PER_POST'			=> 'Fichiers joints par reponse',
		'FILES_PER_TOPIC'			=> 'Fichiers joints par message',
		'FILES_PER_USER'			=> 'Fichiers joints par membre',
		'POSTS_PER_DAY'				=> 'Reponses par jour',
		'POSTS_PER_TOPIC'			=> 'Reponses par message',
		'POSTS_PER_USER'			=> 'Reponses par membre',
		'STATISTICS2'				=> 'Nous avons',		
		'STATISTICS3'				=> 'Le forum contient',
		'STATISTICS4'				=> 'Dans',
		'STAT_DISABLE'				=> 'Cacher les Statistiques',
		'STAT_ENABLE'				=> 'Voir les Statistiques',
		'STAT_MEMBRE'				=> 'Statistique des Membres',
		'STAT_NEW_POSTS'			=> 'Nouveau post',
		'STAT_NEW_TOPICS'			=> 'Nouveau sujet',		
		'STAT_POSTE'				=> 'Statistique des Messages',
		'TOPICS_PER_DAY'			=> 'Messages par jour',
		'TOPICS_PER_USER'			=> 'Messages par membre',
		'TOTAL_ATTACHMENTS_OTHER'	=> 'Total fichiers joints <strong>%d</strong>',
		'TOTAL_ATTACHMENTS_ZERO'	=> 'Total fichier joint <strong>0</strong>',
		'TOTAL_FILES_OTHER'			=> 'Total files other',
		'TOTAL_FILES_ZERO'			=> 'Total files 0',		
		'TOTAL_POSTERS_OTHER'		=> 'Total posters <strong>%d</strong>',
		'TOTAL_POSTERS_ZERO'		=> 'Total poster <strong>0</strong>',    
		'USERS_PER_DAY'				=> 'Membres par jour',
   ));


?>
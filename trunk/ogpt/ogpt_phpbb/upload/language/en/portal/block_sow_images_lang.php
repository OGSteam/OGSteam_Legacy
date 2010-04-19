<?php
/***************************************************************************
* block_sow_images_lang (Additional variables used by portal)
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

	'SOW_ADDED'					=> 'Sow successfully added',
	'SOW_REMOVED'				=> 'Sow successfully removed',
	'SOW_UPDATED'				=> 'Sow successfully updated',
	'MUST_SELECT_SOW'			=> 'Sow selected',
	'MUST_SELECT_QUOTE'			=> 'Add, edit quotation',
	'ACP_SOW_EXPLAIN'			=> 'Sow images Management.',
	'ACP_MANAGE_SOW_IMAGES'		=> 'Sow Images.',
	'ID'						=> 'Id',
	'NO'						=> 'N°:',
	'TITRE'						=> 'Title',
	'INFO'						=> 'Link',
	'INFO3'						=> 'Comment',
	'WIDTH'						=> 'Image width',
	'HEIGHT'					=> 'Image height',
	'IMAGE_EXPLAIN'					=> 'Write image link as follows :<br>
 http://sjpphpbb.net/sjpphpbb_logo.gif',
	'INFO_EXPLAIN'					=> 'You can add a link to another site by writing it as follows :
 http://sjpphpbb.net/index.net',
 	'INFO3_EXPLAIN'					=> 'You can add a comment that will be displayed under images.',
	'NO_EXPLAIN'					=> 'For a new Sow image make an increment of 1.<br> Example : if he latest sow image is n° 5, <br> make an increment to 6.',
 	'TITRE_EXPLAIN'					=> 'You can add a name that will be displayed under images. ',	
 	'WIDTH_EXPLAIN'					=> 'Image width displayed in Index.',
 	'HEIGHT_EXPLAIN'					=> 'Image height displayed in Index. ',	
	'ACP_SOW2__EXPLAIN'			=> 'You can add Sow images. You can remove Sow images.',
	'ADD_SOW'					=> 'Add',
	'INFO_LIEN'					=> 'View site link',
	'ACP_SOW_EXPLAIN_TITRE_BLOC' => 'Edit block name',
	'SOW_TITRE' 				=> '<strong>Block title</strong>',
	'SOW_TITRE_EXPLAIN_BLOC' 	=> 'Allows you to insert a title in the block header <br> that will be displayed in the Forum index',
	'SOW_TITRE_BLOC_UPDATED' 				=> 'Title successfully edited',
	'SOW_TITRE_BLOC_ADDED' 				=> 'Sow title  successfully added',
	'SOW_TITRE_INFOS' 				=> 'Title information',
	'SOW_TITRE_EDITER' 				=> 'Edit',
	'SOW_TITRE_EXPLAIN' 				=> 'You can edit the Block title that will be displayed 
in the sow images Block header in the Forum index.',
	'SOW_DISABLE'				=> '<b>Enable</b>',
	'ENABLE'					=> '<b>Block disabled</b>',
	'DISABLE'					=> '<b>Block enabled</b>',
	'DISABLE_BLOC'				=> 'Enable',
	'ENABLE_BLOC'				=> 'Desable',
	'RESET_SOW' 				=> 'Reset',
	'SOW_DISABLE_EXPLAIN'		=> '<b>Enable :</b><br>Block display on forum.',
	'SOW_DISABLE_EXPLAIN2'		=> 'You can enable or disable block display on Forum : ',
	'COOPYRIGHT'				=> 'copyright - By - sjpphppbb http://sjpphpbb.net/phpbb3/',

));

?>

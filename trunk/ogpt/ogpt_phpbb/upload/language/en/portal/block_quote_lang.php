<?php
/***************************************************************************
* block_quote_lang (Additional variables used by portal)
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

	'ACP_MANAGE_QUOTE'			=> 'Add or edit quotation.',
	'ACP_QUOTE_EXPLAIN'			=> 'Management quotes.',
	'ACP_QUOTE__EXPLAIN'		=> 'You can add, delete, edit quotations.',
	'ADD_QUOTE'					=> 'Add',
	'AUTHOR'					=> 'Author :',
	'COOPYRIGHT'				=> 'copyright - By - sjpphppbb http://sjpphpbb.net/phpbb3/',
	'DISABLE'					=> '<b>Block enabled</b>',
	'DISABLE_BLOC'				=> 'Enable',
	'ENABLE'					=> '<b>Block disabled</b>',
	'ENABLE_BLOC'				=> 'Disable',
	'MUST_SELECT_QUOTE'			=> 'Selected quotation',
	'QUOTE'						=> 'Quotations :',
	'QUOTE_ADDED'				=> 'Quotation successfully added',
	'QUOTE_DISABLE'				=> '<b>Enable</b>',
	'QUOTE_DISABLE_EXPLAIN'		=> '<b>Enable :</b><br>Block display on the forum.',
	'QUOTE_DISABLE_EXPLAIN2'	=> 'You can enable or disable the Block display on the forum : ',
	'QUOTE_REMOVED'				=> 'Quotation successfully removed',
	'QUOTE_TITRE' 				=> '<strong>Block title</strong>',
	'QUOTE_TITRE_BLOC_ADDED' 	=> 'Block title successfully added',
	'QUOTE_TITRE_BLOC_UPDATED' 	=> 'Title successfully edited',
	'QUOTE_TITRE_EDITER' 		=> 'Edit',
	'QUOTE_TITRE_EXPLAIN' 		=> 'You can change the block title displayed in the Quotation block header in the Forum index.',
	'QUOTE_TITRE_EXPLAIN_BLOC' 	=> 'Allows you to insert a title in the Block header <br> which will be displayed in the Forum index',
	'QUOTE_TITRE_INFOS' 		=> 'Title information',
	'QUOTE_UPDATED'				=> 'Quotation successfully edited',
	'RESET_QUOTE' 				=> 'Reset',

));

?>
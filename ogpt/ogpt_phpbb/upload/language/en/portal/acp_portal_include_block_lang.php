<?php
/***************************************************************************
* block_acp_portal_include_block_lang (Additional variables used by portal)
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
	'ADD_BLOCK'							=> 'Add Block ',
	'ADMIN'								=> 'Administrator',
	'ALL'								=> 'All',
	'ANNUL'								=> 'Cancel',	
	'BLOCK_ACTIV'						=> 'Block Activation',
	'BLOCK_ACTIVE'						=> 'Activate',
	'BLOCK_ACTIV_LAXCISTE'				=> 'Allow to activate or deactivate a block on the portal.',	
	'BLOCK_CENTRE'						=> 'Indisponible',
	'BLOCK_CENTRES'						=> 'Center Blocks',
	'BLOCK_HTML'						=> 'Html file',
	'BLOCK_HTML_LAXCISTE'				=> 'Select the *.html file for your block.',		
	'BLOCK_NAME'						=> 'Name of block',
	'BLOCK_NAME_LAXCISTE'				=> 'Name of block displyed in the admin.',	
	'BLOCK_ORD'							=> 'Order:',	
	'BLOCK_ORDER'						=> 'Ord',
	'BLOCK_POS'							=> 'Colomn',
	'BLOCK_REMOVED'						=> 'Block sucessfully cancelled',
	'BLOCK_UPDATED'						=> 'Successfully updated',
	'BLOC_BAS'							=> 'Bottom Blocks',
	'BLOC_DISABLE_EX'					=> 'Block deactivated',	
	'BLOC_DROIT'						=> 'right Blocks',
	'BLOC_GAUCHE'						=> 'Left Blocks',
	'BLOC_HAUT'							=> 'Top Blocks',
	'BLOC_NAME_EDIT'					=> 'Edit block :',
	'BLOC_ORD'							=> 'Ord :',	
	'BLOC_ORD_LAXCISTE'					=> 'Allow to define in which column will be displayed the block on the portal.',	
	'BLOC_POSITION'						=> 'Last position',	
	'BLOC_POSITION_LAXCISTE'			=> 'Select as for here above column',	
	'COOPYRIGHT'						=> 'copyright - By - sjpphppbb - gigi_online  http://sjpphpbb.net/phpbb3/',
	'CURRENT_VERSION'					=> 'Actual installed version.',	
	'DISABLE_BLOC'						=> 'Enable',
	'ENABLE_BLOC'						=> 'Disable',
	'ICON_DELETE'						=> 'Allow to delete blocks that you have added, original blocks cannot be deleted.',
	'ICON_EDIT'							=> 'Allow to edit blocks that you have added, original blocks cannot be edited.',
	'ICON_MOVE_BOTOM'					=> 'Allow to move down the block in the lower column',
	'ICON_MOVE_BOTON_DIRECT'			=> 'Allow to move down the block directly in the bottom column',	
	'ICON_MOVE_DOWN'					=> 'Allow to move down the block from one row',
	'ICON_MOVE_LEFT'					=> 'Allow to move the block directly in the column on its left',	
	'ICON_MOVE_LEFT_DIRECT'				=> 'Allow to move the block directly in the left column',	
	'ICON_MOVE_RIGHT'					=> 'Allow to move the block directly in the column on its right',
	'ICON_MOVE_RIGHT_DIRECT'			=> 'Allow to move the block directly in the right column',	
	'ICON_MOVE_TOP'						=> 'Allow to move up the block in the upper column',
	'ICON_MOVE_TOP_DIRECT'				=> 'Allow to move up the block directly in the top column',
	'ICON_MOVE_UP'						=> 'Allow to move up the block from one row',
	'LATEST_VERSION'					=> 'Latest available version.',
	'LAXCISTE_ACP_PORTAL'				=> 'SjpPortal-phpBB3',	
	'LAXCISTE_ACP_PORTAL_INCLUDE_BLOCK'	=> 'Management of block display',
	'LAXCISTE_ACP_PORTAL_INCLUDE_BLOCK2'=> 'Here you can select blocks you want to be displayed or not on the portal.',
	'LAXCISTE_ACP_PORTAL_INCLUDE_BLOCK2'=> 'You can select here blocks which should be displayed or not on the portal.',
	'LEGENDE_ICON'						=> 'view icons Legend',	
	'LEGENDE_PORTAL'					=> 'Close icons legend',
	'MOD'								=> 'Moderator',	
	'MUST_SELECT_BLOCK'					=> 'Selection error',
	'OFFLIGNE'							=> 'Shows this block as deactivated and allow to activate it by click ',
	'ONLIGNE'							=> 'Shows this block as activated and allow to deactivate it by click ',
	'PERM' 								=> 'Block permissions:',
	'PERMS' 							=> 'Block permissions &nbsp;<i>(All)</i>.&nbsp;You can change permissions by clicking on the image:',
	'PERM_ADM' 							=> 'Block permissions &nbsp;<i>(Administrators(s))</i>.&nbsp;You can change permissions by clicking on the image:',
	'PERM_EXPLAIN' 						=> 'Set who can qee the block :',
	'PERM_MOD' 							=> 'Block permissions &nbsp;<i>(Moderators(s))</i>.&nbsp;You can change permissions by clicking on the image:',
	'PERM_REG' 							=> 'Block permissions &nbsp;<i>(Registered)</i>.&nbsp;You can change permissions by clicking on the image:',
	'REG'								=> 'Registered',
	'RESET_INCLUDE_BLOCK'				=> 'Delete',
	'SUBMIT_INCLUDE_BLOCK'				=> 'Save',
	'VERSION_CHECK'						=> 'Latest actual release of SjpPortal-PhpBB3.',
	'VERSION_CHECK_EXPLAIN'				=> 'Your SjpPortal-PhpBB3 version is not up to date.You should find hereunder a link to the announce of latest release for the issue of the latest version, and instructions for updating..',		
	'VERSION_DONLOAD'					=> 'Download and intall instructions on  sjpphpbb.net.',	
	'VERSION_NOT_UP_TO_DATE_ACP'		=> 'Your version is not up to date.',
));

?>
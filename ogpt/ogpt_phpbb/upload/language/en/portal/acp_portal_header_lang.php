<?php
/***************************************************************************
* header_portal_lang (Additional variables used by portal)
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
	
		'ACP_HEADER'				=> 'Portal header management.',	
		'ACP_HEADER_EXPLAIN' 		=> 'portal header preview as it shall be displayed.<br>Image displayed in the admin is the one from prosilver theme.',	
		'ACP_HEADER_EXPLAIN' => 'portal header preview as it shall be displayed.<br>Image displayed in the admin is the one from prosilver theme.',
		'ACTION'					=> 'Action',
		'ACT_HEA'					=> 'Activation : ',	
		'ADD_LINK'					=> 'Add',	
		'ADMIN'						=> 'Webmaster',			
		'ALL'						=> 'All',
		'BUL'						=> 'Link Name : ',	
		'BUL_EXPLAIN'				=> 'Name of the link which shall be displayed in the bubble with the overflight of the link with the mouse.',	
		'COOPYRIGHT'				=> 'copyright - By - sjpphppbb http://sjpphpbb.net/phpbb3/',
		'DIM_EXPLAIN'				=> 'Set your image width and height ',	
		'DIM_HEIGHT'				=> 'Height :',	
		'DIM_IMG'					=> 'Dimmensions ',		
		'DIM_WIDTH'					=> 'Width :',
		'EDIT_EXPLAIN'				=> 'Portal header links management : ',	
		'GUESTS'					=> 'Guests',
		'HEADER_EDITER' 			=> 'Edit :',
		'HEADER_IMG_ADDED'			=> 'Link added successfully',
		'HEADER_IMG_REMOVED'		=> 'Link cancelled successfully',
		'HEADER_IMG_UPDATED'		=> 'Link updated successfully',	
		'HEADER_LOGO_IMG' 			=> 'Portal Header',	
		'HEADER_LOGO_IMG_EXPLAIN' => 'Portal header links setting.<br>Images displayed in the admin are those from prosilver theme',
		'HEADER_LOGO_UPDATED'		=> 'Logo updated successfully',	
		'IMAGE'						=> 'Image : ',
		'IMAGES'					=> 'Image',	
		'IMAGE_EXPLAIN'				=> 'Select an image for this link<br>Images shall have to be uploaded in /styles/VOTRE THEME/thême/images/icon_header/ directory and shall have a prefix: header_   Ex: header_mon_image.gif .jpg ou png And should have the same name for all your themes.<br>You can have different images for your different themes.',	
		'IMG_PERM_FORUM'			=> 'Forum : ',
		'IMG_PERM_PORTAL'			=> 'Portal : ',		
		'LOG_IMG'					=> '<b>Logo which shall be displayed in your portal header :</b>',
		'LOG_IMG_EXPLAIN'			=> 'Your logo image shall have to be uploaded in /styles/VOTRE THEME/thême/images/icon_header/ directory <br> You have only to give the image name. Ex : logo.gif and it should have the same name for all your themes.',
		'MOD'						=> 'Moderator',
		'MUST_SELECT_HEADER_IM'		=> 'Selected Link',
		'NOM_NAM'					=> 'Link Name',
		'NONE'						=> 'Do not display',
		'PERM'						=> 'Permission ',	
		'REG'						=> 'Registered',
		'RESET'						=> 'Reset',		
		'SIT_DESC'					=> 'Site Description : ',	
		'SIT_DESC_EXPLAIN'			=> 'Site description which shall be displayed on your portal header ',	
		'SIT_NAM'					=> 'Site Name : ',
		'SIT_NAM_EXPLAIN'			=> 'Site Name which shall be displayed on your portal header ',	
		'STAFF'						=> 'Team',
		'URL'						=> 'Link Url',
		'URL_EXPLAIN'				=> 'Link Url to be opened. For internal links you can set a relative url Ex : index.php',		
		'VIEW_BY'					=> 'Permissions',	
		'VIEW_BY_EXPLAIN'			=> 'You can define who can see the link on the portal header',	

));

?>

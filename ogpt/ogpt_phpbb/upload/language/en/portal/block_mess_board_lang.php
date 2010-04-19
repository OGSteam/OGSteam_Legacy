<?php
/***************************************************************************
* block_mess_board_lang (Additional variables used by portal)
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

	'ACP_MESS_BOARD_EXPLAIN'			=> 'Message board Management.',
	'ACP_MESS_BOARD_EXPLAIN_BIS'		=> 'Management of message to be displayed on forum.',
	'ACP_MESS_BOARD_MANAGE'				=> 'Add, edit Message Board .',
	'BBCODE_A_HELP'                 	=> 'Close all BBcode tags',
	'BBCODE_B_HELP'						=> 'Bold : [b]text [/b]  (b-option)',
	'BBCODE_CO_HELP'					=> 'Colour : [color=] coloured text  [/color]',
	'BBCODE_C_HELP'						=> 'Code : [code]code[/code]  (c-option)',
	'BBCODE_D_HELP'						=> 'Flash : [flash=height,width]http://url[/flash]  (+d-option)',
	'BBCODE_E_HELP'						=> 'List : Add list element',
	'BBCODE_F_HELP'						=> 'Size : [size=x-small]small text[/size]',
	'BBCODE_IS_OFF'						=> '%sBBCode%s is <u>disabled</u>',
	'BBCODE_IS_ON'						=> '%sBBCode%s is <u>enabled</u>',
	'BBCODE_I_HELP'						=> 'Italics : [i]text[/i]  (i-option)',
	'BBCODE_L_HELP'						=> 'List : [list]text[/list]  (l-option)',
	'BBCODE_O_HELP'						=> 'Ordered list : [list=]text[/list]  (o-option)',
	'BBCODE_P_HELP'						=> 'Image : [img]http://url_image[/img]  (p-option)',
	'BBCODE_Q_HELP'						=> 'Quotation : [quote]text[/quote]  (q-option)',
	'BBCODE_S_HELP'						=> 'Colour: [color=red]text[/color]  Tip : you can also use =#FF0000',
	'BBCODE_U_HELP'						=> 'Underline : [u]text[/u]  (u-option)',
	'BBCODE_W_HELP'						=> 'URL : [url]http://url[/url] or [url=http://url] Title URL [/url]  (w-option)',
	'BOARD_DISABLE_EXPLAIN'				=> 'Block display on forum is :',
	'COLOR_BLACK'						=> 'Black',
	'COLOR_BLACK'						=> 'Black',
	'COLOR_BLUE'						=> 'Blue',
	'COLOR_BROWN'						=> 'Brown',
	'COLOR_CYAN'						=> 'Cyan',
	'COLOR_DARK_BLUE'					=> 'Dark blue',
	'COLOR_GREEN'						=> 'Green',
	'COLOR_INDIGO'						=> 'Indigo',
	'COLOR_OLIVE'						=> 'Olive',
	'COLOR_ORANGE'						=> 'Orange',
	'COLOR_RED'							=> 'Red',
	'COLOR_VIOLET'						=> 'Violet',
	'COLOR_WHITE'						=> 'White',
	'COLOR_YELLOW'						=> 'Yellow',
	'COOPYRIGHT'						=> 'copyright - By - sjpphppbb  http://sjpphpbb.net/phpbb3/',
	'COULEUR'							=> 'Colour',
	'DISABLE'							=> 'Enable',
	'ENABLE'							=> 'Disable',
	'FONT_COLOR'						=> 'Colour',
	'FONT_HUGE'							=> 'Huge',
	'FONT_LARGE'						=> 'Large',
	'FONT_NORMAL'						=> 'Normal',
	'FONT_SMALL'						=> 'Small',
	'FONT_TINY'							=> 'Tiny',
	'MESS_BOARD'						=> 'Message Board :',
	'MESS_BOARD_ADDED'					=> 'Message Board successfully added',
	'MESS_BOARD_DISABLE'				=> 'Display on forum',
	'MESS_BOARD_DISABLE_EXPLAIN'		=> 'Message board Block on forum enabled : ',
	'MESS_BOARD_MESSAGE'				=> 'Edit message',
	'MESS_BOARD_TITRE'					=> 'Edit block title',
	'MESS_BOARD_TITRE_EXPLAIN'			=> 'Block title to be displayed on forum :',
	'MESS_BOARD_UPDATED'				=> 'Message Board successfully edited',
	'MESS_V_BOARD_MESSAGE'				=> 'Message',
	'MUST_SELECT_MESS_BOARD'			=> 'Add, edit Message Board',
	'RESET'								=> 'Delete',
	'SAVE'								=> 'Save',
	'STYLES_TIP'						=> 'Tip: styles can be applied to text selection',
	'TAILLE'							=> 'Size',
    'CLOSE_TAGS'                    	=> 'Close tags',

));

?>
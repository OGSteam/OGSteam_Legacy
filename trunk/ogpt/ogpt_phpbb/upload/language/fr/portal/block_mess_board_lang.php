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

	'ACP_MESS_BOARD_EXPLAIN'			=> 'Gestion des Messages Board .',
	'ACP_MESS_BOARD_EXPLAIN_BIS'		=> 'Gestion du message qui sera affiché sur le forum .',
	'ACP_MESS_BOARD_MANAGE'				=> 'Ajouter, editer un Message Board .',
	'BBCODE_A_HELP'                 	=> 'Fermer toutes les balises BBcode',
	'BBCODE_B_HELP'						=> 'Gras : [b]texte[/b]  (option-b)',
	'BBCODE_CO_HELP'					=> 'Couleur : [color=]Color le text[/color]',
	'BBCODE_C_HELP'						=> 'Code : [code]code[/code]  (option-c)',
	'BBCODE_D_HELP'						=> 'Flash : [flash=hauteur,largeur]http://url[/flash]  (option+d)',
	'BBCODE_E_HELP'						=> 'Liste : Ajoute un élément de liste',
	'BBCODE_F_HELP'						=> 'Taille : [size=x-small]petit texte[/size]',
	'BBCODE_IS_OFF'						=> '%sBBCode%s est <u>inactif</u>',
	'BBCODE_IS_ON'						=> '%sBBCode%s est <u>actif</u>',
	'BBCODE_I_HELP'						=> 'Italique : [i]texte[/i]  (option-i)',
	'BBCODE_L_HELP'						=> 'Liste : [list]texte[/list]  (option-l)',
	'BBCODE_O_HELP'						=> 'Liste ordonnée : [list=]texte[/list]  (option-o)',
	'BBCODE_P_HELP'						=> 'Image : [img]http://url_image[/img]  (option-p)',
	'BBCODE_Q_HELP'						=> 'Citation : [quote]texte[/quote]  (option-q)',
	'BBCODE_S_HELP'						=> 'Couleur: [color=red]texte[/color]  Astuce : vous pouvez également utiliser=#FF0000',
	'BBCODE_U_HELP'						=> 'Soulignement : [u]texte[/u]  (option-u)',
	'BBCODE_W_HELP'						=> 'URL : [url]http://url[/url] ou [url=http://url]Titre URL[/url]  (option-w)',
	'BOARD_DISABLE_EXPLAIN'				=> 'L\'affichage du bloc sur le forum est :',
    'CLOSE_TAGS'                    	=> 'Fermer les balises',	
	'COLOR_BLACK'						=> 'Noir',
	'COLOR_BLACK'						=> 'Noir',
	'COLOR_BLUE'						=> 'Bleu',
	'COLOR_BROWN'						=> 'Marron',
	'COLOR_CYAN'						=> 'Cyan',
	'COLOR_DARK_BLUE'					=> 'Bleu foncé',
	'COLOR_GREEN'						=> 'Vert',
	'COLOR_INDIGO'						=> 'Indigo',
	'COLOR_OLIVE'						=> 'Olive',
	'COLOR_ORANGE'						=> 'Orange',
	'COLOR_RED'							=> 'Rouge',
	'COLOR_VIOLET'						=> 'Violet',
	'COLOR_WHITE'						=> 'Blanc',
	'COLOR_YELLOW'						=> 'Jaune',
	'COOPYRIGHT'						=> 'copyright - By - sjpphppbb  http://sjpphpbb.net/phpbb3/',
	'COULEUR'							=> 'Couleur',
	'DISABLE'							=> 'Activer',
	'ENABLE'							=> 'Desactiver',
	'FONT_COLOR'						=> 'Couleur',
	'FONT_HUGE'							=> 'Très Grande',
	'FONT_LARGE'						=> 'Grande',
	'FONT_NORMAL'						=> 'Normale',
	'FONT_SMALL'						=> 'Petite',
	'FONT_TINY'							=> 'Minuscule',
	'MESS_BOARD'						=> 'Message Board :',
	'MESS_BOARD_ADDED'					=> 'Message Board ajouté avec Succès',
	'MESS_BOARD_DISABLE'				=> 'Affichage sur le forum',
	'MESS_BOARD_DISABLE_EXPLAIN'		=> 'Activation du bloc message board sur le forum : ',
	'MESS_BOARD_MESSAGE'				=> 'Modifier votre message',
	'MESS_BOARD_TITRE'					=> 'Modifier le titre du bloc',
	'MESS_BOARD_TITRE_EXPLAIN'			=> 'Titre du bloc qui sera affiché sur le forum :',
	'MESS_BOARD_UPDATED'				=> 'Message Board modifié avec Succès',
	'MESS_V_BOARD_MESSAGE'				=> 'Message',
	'MUST_SELECT_MESS_BOARD'			=> 'Ajouter, editer un Message Board',
	'RESET'								=> 'Annuler',
	'SAVE'								=> 'Sauvegarder',
	'STYLES_TIP'						=> 'Astuce : Les styles peuvent être appliqués à une sélection de texte',
	'TAILLE'							=> 'Taille',

));

?>
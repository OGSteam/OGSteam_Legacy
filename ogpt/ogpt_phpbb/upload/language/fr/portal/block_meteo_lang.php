<?php
/***************************************************************************
* block_meteo_lang (Additional variables used by portal)
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

	'ACP_METEO_EXPLAIN'			=> 'Météo',
	'LAXCISTE_METEO_ADMIN'		=> 'Administration du bloc Météo',
	'LAXCISTE_METEO_ADMIN2'		=> 'Vous pouvez donner dans ce formulaire les informations de titre, couleur de fond et de texte de votre bloc météo.<br>Ceci vous permettant d’adapter le bloc a votre template.',
	'LAXCISTE_METEO_ADMIN3'		=> 'Renseignez les champs',
	'LAXCISTE_METEO_COPYRIGHT'	=> 'copyright - By - sjpphppbb  http://sjpphpbb.net/phpbb3/',
	'METEO'						=> 'Météo :',	
	'METEO_FOND'				=> 'Entrez ici le code couleur de fond de votre bloc météo.<br>Ce code doit être sous le forme 000000 sans le #.',
	'METEO_TEXTE'				=> 'Entrez ici le code couleur de texte de votre bloc météo. <br>Ce code doit être sous le forme 000000 sans le #.',
	'METEO_TITRE'				=> 'Entrez ici le titre de votre bloc météo.<br>Ce titre apparaîtra en entête de votre bloc météo.',
	'METEO_UPDATED'				=> 'Mise a jour effectuée',
	'METEO_USER_EXPLAIN'		=> 'Vous pouvez indiquer ici le nom de votre ville, ce qui permettre d\'afficher la météo de votre ville dans le bloc météo sur le portal.',
	'METEO_USER_EXPLAIN1'		=> 'Météo',
	'RESET'						=> 'Annuler',
	'SAVE'						=> 'Sauvegarder',

));

?>
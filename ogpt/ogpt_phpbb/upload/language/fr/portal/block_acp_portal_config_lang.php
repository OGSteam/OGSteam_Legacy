<?php
/***************************************************************************
* block_acp_portal_config_lang (Additional variables used by portal)
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


//Menu portal
$lang = array_merge($lang, array(    
	
	'ACP_PORTAL_CONFIG_EXPLAIN'	=> 'Gestion des blocks',
	'ACP_PORTAL_CONFIG_EXPLAIN2' => 'Vous pouver déterminer ici le nombre d\'affichage de donnés dans les blocks suivant :',
	'ACP_PORTAL_CONFIG_PACING3' => 'Vous pouvez déterminer ici l’espacement entre les colonnes ,<br> et la largeur des colonnes de droite et de gauche. ',
	'ACTION' 				=> 'Action.',
	'CONFIG_ADDED' 			=> 'Mise a jour effectuée avec succès ',	
	'CONFIG_UPDATED' 		=> 'Mise a jour effectuée avec succès ',
	'COOPYRIGHT'			=> 'copyright - By - sjpphppbb  http://sjpphpbb.net/phpbb3/',
	'DROITE' 				=> 'Largeur droite',
	'FORUM_EXCEPT'           	=> 'Forum exclus',
	'FORUM_EXCEPT_EXPLAIN'      => 'mettre 0 <B>(ne jamais laisser ce champ vide)</b>pour tout  afficher.<br>Vous pouvez exclure des forum de l\'affichage dans le block récent topic.<br>Vous devez indiquer un ID ou plusieurs , séparer les id par une virgule si plus d\'un Ex : 1,2,3 ',
	'GAUCHE' 				=> 'Largeur gauche',	
	'NAME_BLOC' 			=> 'Nom du Bloc ',	
	'NOM_BLOC' 				=> 'Nom du block',
	'NOM_BLOC_EXPLAIN' 		=> 'Nom qui sera affiché en en tête du block',
	'NOM_DROITE_EXPLAIN' 	=> 'Détermine la largeur de la colonne de droite. Une valeur entre 180 et 200 est raisonnable. La valeur doit être en pixels.',
	'NOM_GAUCHE_EXPLAIN' 	=> 'Détermine la largeur de la colonne de gauche. Une valeur entre 180 et 200 est raisonnable. La valeur doit être en pixels.',	
	'NOM_VALUE' 			=> 'Nombres de données affichées',
	'NOM_VALUE_EXPLAIN' 	=> 'Détermine le nombre de lignes affichées.<br>Exemple : les 5 derniers membres enregistrés.',
	'NONE' 					=> 'Non',
	'NOT_AVAILABLE' 		=> 'Indisponible ',
	'N_AFF' 				=> 'Nombre d\'affichages', 
	'PACING' 				=> 'Espacement entre les colonnes',	
	'PACING_BLOC_EXPLAIN' 	=> 'Détermine l\'espacement entre chaque colonne. Un espacement de 2 est raisonnable.',
	'RESET_CONFIG' 			=> 'Annuler',
	'SCROLL_BLOC' 			=> 'Scroll',
	'SCROLL_BLOC_EXPLAIN' 	=> 'Affiche les données dans le block avec une barre de scroll si besoin.',	
	'SCROOL' 				=> 'Scroll',
	'YES' 					=> 'Oui',	

	
	

	
));
?>
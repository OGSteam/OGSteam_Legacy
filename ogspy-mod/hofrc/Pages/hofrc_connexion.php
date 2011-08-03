<?php
/**
 * hofrc_connexion.php 
 * @package HofRC
 * @author Shad
 * @link http://www.ogsteam.fr
 * @version : 0.0.1
 */

// vérification de sécurité
//if (!defined('HOFRC')) die('Hacking attempt');

// variable de sécurité
define('IN_SPYOGAME', true);
// et on restaure le niveau d'erreur
error_reporting($old_error_report);
// identifiants
require_once('../../../parameters/id.php');
// pour les noms de tables
require_once('../../../includes/config.php');
// Connexion et sélection de la base
$bdd = mysql_connect($db_host, $db_user, $db_password) or die('Impossible de se connecter');
mysql_select_db($db_database,$bdd) or die('Base inexistante.');
define('TABLE_HOFRC_TITLE',$table_prefix.'hofrc_title');
define('TABLE_HOFRC_CONFIG',$table_prefix.'hofrc_config');
// On récupère les dimensions de l'image
$query_largeur = mysql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'largeur_historique'");
list($largeur_picture) = mysql_fetch_row($query_largeur); 
$query_hauteur = mysql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'hauteur_historique'");
list($hauteur_picture) = mysql_fetch_row($query_hauteur);
$historique="../Output/historique.png";
$size=0;
$query_title = mysql_query("SELECT `id`, `id_rc`, `board_url`, `title` FROM ".TABLE_HOFRC_TITLE." ORDER BY id_rc");
while ($title = mysql_fetch_assoc($query_title))
	{
		$size = $size + $hauteur_picture;
		$area .= 	'<area shape="rect" coords="0px,0px,'.$largeur_picture.','.$size.'px" href="'.$title['BOARD_URL'].'">';
		
	}
?>
	<map name="testmap"> 
	<?php echo $area?>
	</map>
	<?php
	
	echo'<br><img src="'.$historique.'" usemap="#testmap" alt="'.$historique.'" /><br>';
// ne pas oublier ça...
mysql_close($bdd);
?>

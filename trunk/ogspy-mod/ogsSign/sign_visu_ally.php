<?php
/**
* sign_visu_ally.php Visualisation des signatures alliance
* @package OGSign
* @author oXid_FoX
* @link http://www.ogsteam.fr
* created 22/09/2006 21:13:41
*/


// vérification de sécurité
if (!defined('IN_SPYOGAME')) die('Hacking attempt');

// sélection des paramètres des sign ally
$query = 'SELECT `ally_id`, `TAG` FROM `'.TABLE_ALLY_SIGN.'` ORDER BY `TAG` ASC';
$result_ally = $db->sql_query($query);

// début de l'adresse des signatures
$debut_full_url_sign = str_replace(' ','%20','http://'.substr($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],0, strlen($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'])-9));

?>
<table align="center" width="100%" cellpadding="0" cellspacing="1">
<form name="visu">

<!-- APERCU & ADRESSE DES SIGNATURES ALLIANCE -->
<?php
// Tant qu'une ligne existe, il y a une signature configurée
while ($param_sign_ally = $db->sql_fetch_assoc($result_ally)) {
	// création de l'adresse de la sign
	$url_sign = 'mod/OGSign/'.$param_sign_ally['ally_id'].'.A.png';

	// affichage de l'image
	$img_size = @getimagesize($debut_full_url_sign.$url_sign); // avec un '@' car des hébergeurs ont du mal avec...
	echo "\n\t",'<tr><td class="c">Signature de l\'alliance <span style="color: lime;">',$param_sign_ally['TAG'],'</span></td></tr>'
	,"\n\t",'<tr><th style="-moz-opacity: 1; filter: alpha(opacity=100); /*suppression de la transparence éventuelle*/">'
	,"\n\t",'<img src="',$url_sign,'" alt="signature de l\'alliance ',$param_sign_ally['TAG'],'" title="signature de l\'alliance ',$param_sign_ally['TAG'],'" '
	,$img_size[3],'></th></tr>'

	// affichage de l'adresse
	,"\n\t",'<tr><th><input type="text" value="',$debut_full_url_sign,$url_sign,'" size="70" readonly="readonly" onClick="this.focus(); this.select();" style="text-align: center;"><br />'
	,"\n\t",'<input type="text" value="[img]',$debut_full_url_sign,$url_sign,'[/img]" size="80" readonly="readonly" onClick="this.focus(); this.select();" style="text-align: center;">'
	,"\n\t</th></tr>";
}
?>


</form>
</table>

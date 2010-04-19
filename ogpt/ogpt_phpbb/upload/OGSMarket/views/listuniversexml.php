<?php
/***************************************************************************
*	filename	: listuniversexml.php
*	desc.		: Affiche un message xml présentant les univers disponibles sur le serveur
*	Author		: Jey2k - http://ogs.servebbs.net/
*	created		: 18/08/2006
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
require_once("views/page_header_xml.php");
?>
<market>
	<universes_list>
<?php
foreach($Universes->universes_array() as $universe){
		echo "\n\t\t".$Universes->get_universe_xml($universe);
	}
?>
	</universes_list>
</market>
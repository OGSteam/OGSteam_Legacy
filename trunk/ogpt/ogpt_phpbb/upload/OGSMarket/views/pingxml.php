<?php
/***************************************************************************
*	filename	: pingxml.php
*	desc.		: Affiche un message xml sans requête
*	Author		: Jey2k - http://ogs.servebbs.net/
*	created		: 18/08/2006
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
require_once("views/page_header_xml.php");
?>
<market>
	<ping>ok</ping>
</market>
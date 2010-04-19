<?php
/***************************************************************************
*	filename	: page_header_xml.php
*	desc.		:
*	Author		:	ericalens 
*	created		: 	04/06/2006
***************************************************************************/
if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
header("Content-type: application/rss+xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>\n";
?>
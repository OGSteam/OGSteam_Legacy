<?php
/***************************************************************************
*	filename	: ajax_test.php
*	desc.		:
*	Author		: ericalens - http://ogs.servebbs.net/
*	created		: 17/12/2005
*	modified	: 28/12/2005 23:56:40
*	modified	: dimanche 11 juin 2006, 01:05:08 (UTC+0200)
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");
?>
<div id="accordionDiv">
<div id="overviewPanel">
<div id="overviewHeader">
Panneau Overview
</div>
<div id="panel1Content">
Contenu d'Overview..
</div>
</div>
<div id="testPanel">
<div id="testHeader">
Panneau de Test
</div>
<div id="panel1Content">
Contenu de Test
</div>
</div>

</div>
<script> onloads.push( accord ); function accord() { new Rico.Accordion( 'accordionDiv', {panelHeight:227} ); } </script>
<?php
require_once("views/page_tail.php");
?>

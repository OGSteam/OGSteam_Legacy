<?php
/***********************************************************************
MACHINE

************************************************************************/


define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';
/// parser pour le texte des tutos...
require PUN_ROOT.'include/parser.php';
// Load the index.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/index.php';


///ogpt
$lien="aide.php";
$page_title = "aide ogame";
require_once PUN_ROOT.'ogpt/include/ogpt.php';
/// fin ogpt


define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';

?>
<?php
$result = $db->query('SELECT *  FROM mod_fofo_ogs where actif =\'1\' order by ordre');
while ($aide = $db->fetch_assoc($result))
{




echo'
<div id="p114" class="blockpost rowodd">
	<h2><span>OGPT</span></h2>
	<div class="box">
		<div class="inbox">
			<div class="postleft">

				<dl>
					<dt><strong><a href="'.$aide['lien'].'">'.$aide['title'].'</a></strong></dt>
					<dd class="usertitle">par <strong>'.$aide['developpeur'].'</strong></dd>
					<dd class="postavatar"></dd>
					
					<dd>Version : '.$aide['version'].'</dd>
					<dd class="postavatar"></dd>
					<dd>Descriptif : </dd>
					<dd>'.$aide['description'].'</dd>
					
				</dl>
			</div>
			<div class="postright">
				
				<div class="postmsg">
				'.parse_message($aide['tutos'] , '0').'
					

				</div>
				
			</div>
			<div class="clearer"></div>
			<div class="postfootleft"></div>

			<div class="postfootright"><ul><li><a href="http://www.ogsteam.fr">OGPT @'.$aide['developpeur'].'</a> </li></ul></div>
		</div>
	</div>
</div>

';



}





?>




  <div class="blockform">
	<h2><span>Propulsé par ogspy/<a href="http://www.ogsteam.fr">ogsteam</a></span></h2>

    </div>




<?php

$footer_style = 'index';
require PUN_ROOT.'footer.php';

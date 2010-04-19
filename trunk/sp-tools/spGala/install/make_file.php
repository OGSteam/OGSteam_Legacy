<?php
	header('Content-Type: text/x-delimtext; name="config.php"');
	header('Content-disposition: attachment; filename="config.php"');
	echo stripslashes($_POST['config_data']);
	exit;
?>
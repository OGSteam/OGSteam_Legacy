<?php
require_once '../common.php';
define('REPO', BASE_TAGS);
$ogspy = new Project(REPO, 'ogspy');
header('Content-type: text/plain');
echo $ogspy->getLatest()->getVersion();
?>
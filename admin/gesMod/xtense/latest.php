<?php
require_once '../common.php';
define('REPO', BASE_SVN);
header('Content-type: application/rdf+xml');
echo SVN::cat(REPO . 'trunk/updateXtense.rdf');
?>
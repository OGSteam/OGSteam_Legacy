<?php
require_once '../common.php';
define('REPO', BASE_TAGS . 'ogspy-mod/');
$latest = array();
$mods = new MultiProject(REPO);
foreach ( $mods->getProjects() as $project ) {
	$mod = $mods->getProject($project)->getLatest();
	$latest[$mod->project] = $mod->getVersion();
}
header('Content-type: text/plain');
echo json_encode($latest);
?>
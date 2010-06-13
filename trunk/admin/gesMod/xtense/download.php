<?php
require_once '../common.php';
define('REPO', BASE_TAGS);
define('DOWNLOAD', BASE_DOWNLOAD . 'xtense/');
define('TMP', BASE_TMP);

if ( isset($_GET['download']) ) {
	$dl = $_GET['download'];
	$xpi = $dl . '.xpi';
	$remote = REPO . $dl;
	$local = DOWNLOAD . $xpi;
	$tmp = TMP . $dl;

	if ( !is_file($local) ) {
		if ( !SVN::export($remote, $tmp) ) {
			header('Content-type: text/plain');
			die('Module introuvable');
		}

		Folder::xpi($tmp, $local);
		FOlder::rm($tmp);
	}

	header('Content-type: application/x-xpinstall');
	header('Content-Disposition: attachment; filename="' . $xpi . '"');
	readfile($local);

	die;
}

$project = new Project(REPO, 'xtense');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>T&eacute;l&eacute;chargement du plugin XTense</title>
	</head>
	<body>
		<div>XTense</div>
		<ul>
			<?php
			foreach ( $project->getVersions() as $version ):
			?>
			<li><a href="?download=<?php echo $version->name; ?>"><?php echo $version->getVersion(); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</body>
</html>

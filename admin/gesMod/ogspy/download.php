<?php
require_once '../common.php';
define('REPO', BASE_TAGS);
define('DOWNLOAD', BASE_DOWNLOAD . 'ogspy/');
define('TMP', BASE_TMP);

if ( isset($_GET['download']) ) {
	$dl = $_GET['download'];
	$zip = $dl . '.zip';
	$remote = REPO . $dl;
	$local = DOWNLOAD . $zip;
	$tmp = TMP . $dl;

	if ( !is_file($local) ) {
		if ( !SVN::export($remote, $tmp) ) {
			header('Content-type: text/plain');
			die('Module introuvable');
		}

		Folder::zip($tmp, $local);
		Folder::rm($tmp);
	}

	header('Content-type: application/zip');
	header('Content-Disposition: attachment; filename="' . $zip . '"');
	readfile($local);

	die;
}

$ogspy = new Project(REPO, 'ogspy', false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>T&eacute;l&eacute;chargement d'OGSPy</title>
		<link href="/style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<ul>
			<li><?php echo $ogspy->name; ?>
				<ul>
					<?php
					foreach ( $ogspy->getVersions() as $version ):
						$class = '';
						if ( $version->isStable() ) {
							$class = ' class="stable"';
						} elseif ( $version->isRC() ) {
							$class = ' class="rc"';
						} elseif ( $version->isBeta() ) {
							$class = ' class="beta"';
						} elseif ( $version->isAlpha() ) {
							$class = ' class="alpha"';
						} elseif ( $version->isRev() ) {
							$class = ' class="rev"';
						}
					?>
					<li<?php echo $class; ?>><a href="?download=<?php echo $version->name; ?>"><?php echo $version->getVersion(); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</li>
		</ul>
		<table class="bordered">
			<tr>
				<td class="stable">
					Version stable
				</td>
				<td class="rc">
					Release Candidate (RC)
				</td>
				<td class="beta">
					Version beta
				</td>
				<td class="alpha">
					Version alpha
				</td>
				<td class="rev">
					Version de d&eacute;veloppement
				</td>
			</tr>
		</table>
	</body>
</html>

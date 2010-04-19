<?php

ob_start();

// Variables
$dir = 'addon_GroupAdmin';
$files = array('index.php', 'includes/user.php', 'views/admin_members_group.php', 'js/admin_group.js', 'images/ajax.gif');
$installed = false;		// Si l'add-on est deja installé
$install_ok = true;		// Si on peut l'installer
$in_ogspy = false;

// Verification des fichiers d'installation || Mod deja installé
foreach ($files as $name) {
	if (!file_exists($dir.'/'.$name)) {
		$install_ok = false;
		break;
	}
}
if (file_exists($files[3]) && file_exists($files[4])) $installed = true;
if (file_exists('common.php') && file_exists('includes/user.php') && file_exists('views/admin_members_group.php')) $in_ogspy = true;


$install = false;
$uninstall = false;
$end_install = true;
$end_uninstall = true;

// Installation
if (isset($_GET['install']) && $install_ok && !$installed && $in_ogspy) {
	$install = true;
	if (!rename($files[0], 'backup_index.php')) $end_install = false;
	if (!rename($files[1], 'includes/backup_user.php')) $end_install = false;
	if (!rename($files[2], 'views/backup_admin_members_group.php')) $end_install = false;
	
	foreach ($files as $name) {
		if (!copy($dir.'/'.$name, $name)) $end_install = false;
		chmod($name, 0777);
	}
	if ($end_install) $installed = true;
}

// Mise a jour depuis une autre version anterieure
if (isset($_GET['install']) && $install_ok && $installed && $in_ogspy) {
	$install = true;
	
	foreach($files as $name) {
		unlink($name);
		if (!copy($dir.'/'.$name, $name)) $end_install = false;
	}
}

// Desinstallation
elseif (isset($_GET['uninstall']) && $installed && $in_ogspy) {
	$uninstall = true;
	foreach ($files as $name) {
		if (!unlink($name)) $end_uninstall = false;
	}
	
	if (!rename('backup_index.php', $files[0])) $end_uninstall = false;
	if (!rename('includes/backup_user.php', $files[1])) $end_uninstall = false;
	if (!rename('views/backup_admin_members_group.php', $files[2])) $end_uninstall = false;
	
	if ($end_uninstall) $installed = false;
}

$errors = trim(ob_get_contents());
ob_end_clean();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="language" content="fr" />
<title>[Installation] add-on GroupAdmin by Unibozu</title>

<style type="text/css" lang="fr">
body {
	margin:20px;
	color:#666666;
	font-family:Tahoma,Arial,serif;
	font-size:11px;
	letter-spacing:1.5px;
}

li {
	font-weight:bold;
}

a:link, a:visited, a:hover, a:active, a {
	color:#009999;
	text-decoration:none;
	cursor:pointer;
	font-weight:bold;
}


h1 {
	color:#00AAAA;
	font-weight:bold;
	font-size:14px;
	letter-spacing:2px;
	padding-bottom:3px;
	margin:0px 5px 3px 5px;
	border-bottom:1px dotted #CCCCCC;
}

h2 {
	color:#00AAAA;
	font-weight:bold;
	font-size:11px;
	letter-spacing:2px;
	padding-bottom:3px;
	margin:0px 0px 3px 0px;
	border-bottom:1px dotted #CCCCCC;
}

.green {
	color:#00CC00;
}

.red {
	color:#FF0000;
}

div.alert {
	margin:20px;
	padding:3px;
	border:1px solid #AAAAAA;
}

div.alert p {
	margin:5px;
}

div.alert div {
	padding-bottom:3px;
	margin-bottom:3px;
	color:#FF9900;
	font-weight:bold;
	font-size:12px;
	border-bottom:1px dotted #CCCCCC;
}

div.alert div.red {
	color:#FF0000;
}

div.alert div.green {
	color:#00CC00;
}

</style>
<script type="text/javascript">
function display() {	
	var len = display.arguments.length, args = display.arguments;
	for (i = 0; i < len; i ++)
		if (document.getElementById(args[i])) document.getElementById(args[i]).style.display = 'block'; 
}
function hide() {	
	var len = hide.arguments.length, args = hide.arguments;
	for (i = 0; i < len; i ++)
		if (document.getElementById(args[i])) document.getElementById(args[i]).style.display = 'none'; 
}

function redir(url) { document.location.href = url; }

function install() {
	if (!install_ok) {
		hide(last);
		display('install');
		last = 'install';
	} else if (!in_ogspy) {
		hide(last);
		display('in_ogspy');
		last = 'in_ogspy';
	} else {
		redir('?install'+(install.arguments.length == 1 ? '&stay' : '' ));
	}
}

function uninstall() {
	if (!installed) {
		hide(last);
		display('uninstall');
		last = 'uninstall';
	} else if (!in_ogspy) {
		hide(last);
		display('in_ogspy');
		last = 'in_ogspy';
	} else {
		redir('?uninstall');
	}
}

var last = '';
var installed = <?php echo $installed ? 'true' : 'false' ; ?>;
var install_ok = <?php echo $install_ok ? 'true' : 'false' ; ?>;
var in_ogspy = <?php echo $in_ogspy ? 'true' : 'false' ; ?>;
</script>
</head>
<body>

<h1>Add-on d'administration des groupes : GroupAdmin</h1>

<p>Cet add-on permet de remplacer le systeme de modification des groupes standard de OGSpy par une nouvelle interface plus intuitive, plus simple. Elle requiert l'utilisation du Javascript ainsi que de l'AJAX.
Les fichiers suivants sont modifiés :</p>

<ul>
	<li>index.php</li>
	<li>includes/user.php</li>
	<li>views/admin_members_group.php</li>
</ul>

<p>Une copie des fichiers modifiés est automatiquement créée pour vous permettre de pouvoir facilement enlever cet add-on de votre serveur OGSpy. Il y est rajouté le suffix "backup_" devant leur noms avant la copie des fichiers de l'add-on.</p>
<h2>Status</h2>
<p>
<?php 
	echo '<strong>Add-on</strong>: ';
	if ($installed) echo '<span class="green">installé</span>';
	else echo '<span class="red">non installé</span>';
	
	echo '<br /><strong>Fichiers d\'installation</strong>: ';
	
	if ($install_ok) echo '<span class="green">existants</span>';
	else echo '<span class="red">manquants</span>';
	
	echo '<br /><strong>Fichiers d\'installation a la racine d\'un OGSpy</strong> :';
	
	if ($in_ogspy) echo '<span class="green">oui</span>';
	else echo '<span class="red">non</span>';
?></p>


<?php if ($install && $end_install) { ?>
	<div class="alert">
		<div class="green">Installation</div>
		<p>L'installation du mod à été effectuée avec succès. Vous pouvez desormais utiliser votre OGSpy normalement. <a href="index.php?action=administration&subaction=group">[Ouvrir l'administration des groupes]</a></p>
	</div>
<?php } elseif ($install && !$end_install) { ?>
	<div class="alert">
		<div class="red">Installation</div>
		<p>Une erreur est survenue pendant l'installation. Veuillez contacter <a href="mailto:unibozu@gmail.com?subject=Probleme à l'installation de l'addong OGSpy GroupAdmin">Unibozu</a> en lui fournissant le texte ci dessous: </p>
		<pre><?php echo $errors; ?></pre>
	</div>
<?php } ?>

<?php if ($uninstall && $end_uninstall) { ?>
	<div class="alert">
		<div class="green">Desinstallation</div>
		<p>La desinstallation du mod a été effectuée avec succès. Vous pouvez desormais utiliser votre OGSpy normalement. <a href="index.php?action=administration&subaction=group">[Ouvrir l'administration des groupes]</a></p>
	</div>
<?php } elseif ($uninstall && !$end_uninstall) { ?>
	<div class="alert">
		<div class="red">Desinstallation</div>
		<p>Une erreur est survenue pendant la deinstallation. Veuillez contacter <a href="mailto:unibozu@gmail.com?subject=Probleme à l'installation de l'addong OGSpy GroupAdmin">Unibozu</a> en lui fournissant le texte ci dessous: </p>
		<pre><?php echo $errors; ?></pre>
	</div>
<?php } ?>

	<div class="alert" style="display:none;" id="in_ogspy">
		<div>Avertissement</div>
		<p>L'installation de l'addon ne se trouve pas dans le dossier d'un OGSpy. Verifiez que vous avez placés les fichiers au bon endroit (A la racine de votre OGSpy, avec votre fichier <strong>index.php</strong> et <strong>common.php</strong>)</p>
	</div>
	<div class="alert" style="display:none;" id="install">
		<div>Avertissement</div>
		<p>Un ou des fichiers d'installation de l'Add-on sont manquants, verifiez qu'ils sont bien présents dans le dossier <strong>Ajax/</strong> et qu'ils portent le même nom que dans l'archive WinZip.</p>
	</div>
	<div class="alert" style="display:none;" id="uninstall">
		<div>Avertissement</div>
		<p>L'add-on n'est pas installé sur votre serveur.</p>
	</div>
	<noscript>
		<div class="alert">
			<div class="red">Avertissement</div>
			<p>Vous devez activer Javascript pour installer l'add-on</p>
		</div>
	</noscript>
<div style="text-align:center;">
	<a title="Lancer l'installation" onclick="install();">Installer</a> - <a title="Supprimer l'add-on" onclick="uninstall();">Desinstaller</a><br /><a href="index.php">Accueil OGSpy</a> - <a href="install.php">Index installation</a><br />Version 0.1
</div>

</body>
</html>
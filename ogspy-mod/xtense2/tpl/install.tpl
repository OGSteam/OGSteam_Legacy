<?php if (!defined('IN')) exit; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" >
<head>
	<title>Xtense <?php echo $version; ?> - Installation</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<style type="text/css">

body {
	font-family: Arial, Tahoma, sans-serif;
	font-size: 12px;
	color: #333;
	background: #FFF;
}

a {
	font-weight:bold;
	color: #666;
	text-decoration: underline;
}

a:hover {
	text-decoration: none;
}

#wrapper {
	width: 600px;
	margin: 5% auto 0px auto;
	border: 1px solid #AAA;
	padding: 10px;
}

h1 {
	color: #93B300;
	font-weight: bold;
	font-size: 18px;
	margin: 3px;
}

h2 {
	padding-top: 0px;
	margin-top: 0px;
	font-size: 13px;
	margin-left: -28px;
	padding-left: 28px;
	min-height: 16px;
	background: no-repeat 2px center url(mod/Xtense/tpl/icons/go.png);
	color: #000;
}

h2.error {
	color: #900;
	background-image: url(mod/Xtense/tpl/icons/alert.png);
}

h2.info {
	color: #05A;
	background-image: url(mod/Xtense/tpl/icons/infos.png);
}

h2.warn {
	color: #F90;
}

h2.success {
	color: crimson;
	background-image: url(mod/Xtense/tpl/icons/valid.png);
}

input {
	padding: 2px;
	margin: 2px 0px;
	border: 1px solid #666;
}

input.error {
	color: #A00;
	padding-left: 20px;
	background: no-repeat 2px center url(mod/Xtense/tpl/icons/alert.png);
}

#requirements .ok {
	color: #93B300;
	font-weight: bold;
}

#requirements .warn {
	color: orange;
	font-weight: bold;
}

#requirements .nok {
	color: red;
	font-weight: bold;
}

.block {
	margin-top: 15px;
	padding: 0px 28px;
	padding-top: 15px;
	border-top: 3px solid #DDD;
}

.install {
	margin-top: 25px;
	text-align: center;
}

.install button {
	color: #909;
	background: #FFF;
	font-weight: bold;
	border: 1px solid #888;
	padding: 3px;
}

#universe {
	margin-left: 30px;
}

#ogspy_log {
	margin-right: 30px;
}

#copy_plugin {
	margin-right: 30px;
}

#checksum li {
	font-family: monospace;
}

#backlink {
	text-align: center;
}

#backlink a {
	color: #9B3;
	font-size: 1.25em;
}

</style>
<body>

<div id="wrapper">
	<h1>Installation de Xtense</h1>
	
	<?php if (!isset($install)) { ?>
	<form action="" method="get">
	<input type="hidden" name="action" value="mod_install" />
	<input type="hidden" name="directory" value="Xtense" />
	
	<div id="requirements" class="block">
		<h2 class="<?php if (!$ogspyVersionOk || !$mysqlVersionOk) echo 'error'; ?>">Configuration requise</h2>
		<ul>
			<li>Ogspy 3.05 - <span class="<?php echo !$ogspyVersionOk?'n':''; ?>ok">Version actuelle <?php echo $ogspyVersion; ?></span></li>
			<li>PHP 5 - <span class="ok">Version actuelle <?php echo $phpVersion; ?></span></li>
			<li>MySQL 4.1 - <span class="<?php echo !$mysqlVersionOk?'n':''; ?>ok">Version actuelle <?php echo $mysqlVersion; ?></span></li>
			<li>Journaux Xtense accessibles en écriture - <?php echo $logWritable ? '<span class="ok">Oui</span>' : '<span class="warn">Non</span>'; ?></li>
		</ul>
	</div>
	
	<?php if ($directoryOld) { ?>
		<div id="old" class="block">
			<h2 class="warn">La nouvelle version de Xtense (v2) a detecté les fichiers de l'ancienne version (v1)</h2>
			<p>
				Vous avez uploadé la nouvelle version de Xtense dans le même dossier que l'ancienne version. Cependant, les modifications étant
				trop importantes, il est conseillé de supprimer l'ancien dossier mod/Xtense/ avant d'uploader le nouveau. <br />
				Il n'y a pas de risque de conflit mais il est préférable de supprimer l'ancien mod pour ne pas avoir un mélange de fichiers
				entre les deux.
			</p>
		</div>
	<?php } ?>
	
	<div id="checksum" class="block">
		<h2 class="<?php if (!$checksumOk) echo 'error'; ?>">Intégrité des fichiers du mod</h2>
		<?php if ($checksumOk) { ?>
			<p>Tous les fichiers sont valides</p>
		<?php } else { ?>
			<p>Certains fichiers sont invalides. Tentez de les réuploader via votre client FTP puis retentez l'installation.</p>
			<ul>	
			<?php foreach ($checksumFiles as $file) { ?>
				<li>mod/Xtensek/<?php echo $file; ?></li>
			<?php } ?>
			</ul>
		<?php } ?>
	</div>
	
	<div id="plugin" class="block">
		<h2 class="<?php if (!$pluginOk) echo 'warn'; ?>">Verification de la connexion au plugin</h2>
		
		<?php if ($pluginOk) { ?>
			<p>Aucun erreur détectée lors de la conneXion au plugin. Vous pouvez utiliser le plugin directement depuis le répertoire du mod Xtense.</p>
		<?php } else { ?>
			<p>
				Impossible de se connecter au plugin. Ce type d'erreur est principalement dû à l'hébergeur (anciennes version de logiciels, etc...).
			</p>
			<p>
				Vous pouvez cependant copier le plugin a la racine de votre ogpsy et l'utiliser à cet endroit. 
				Cette action permet la plupart du temps de résoudre les problèmes liés à l'hébergeur.
			</p>
				<?php if ($pluginMoveable) { ?>
					<p>L'installation possède les droits suffisants (CHMOD) pour pouvoir effectuer cette action.</p>
					<p>
						<input type="checkbox" name="copy_plugin" id="copy_plugin" checked="checked" />
						<label for="copy_plugin">Copier le plugin a la racine et l'utiliser par défaut</label>
					</p>
				<?php } else { ?>
					<p>L'installation ne possède pas les droits suffisants pour pouvoir effectuer automatiquement cette action.</p>
					<p><strong>Vous pouvez (au choix) :</strong></p>
					<ul>
						<li>
							Tenter de déplacer le plugin (fichier xtense.php) après l'installation à la racine de votre ogspy et paramétrer son 
							emplacement depuis l'administration de Xtense
						</li>
						<li>
							Modifier le CHMOD du repertoire racine de votre OGSpy (si il existe déjà un fichier
							xtense.php à la racine, vous devez aussi modifier ce CHMOD) pour que le script d'installation puisse copier le plugin.
							Un CHMOD à 0777 permet une copie sans encombre. Cependant, il est conseillé de mettre de côté l'ancien CHMOD (du dossier racine
							mais aussi du fichier xtense.php si il existe - les deux étant souvent différents) pour le remettre a la suite du déplacement.
							Il suffit alors de recharger l'installation de Xtense (F5) pour vérifier que la copie est possible.
						</li>
					</ul>
				<?php } ?>
		<?php } ?>
	</div>
	
	<?php if (!$ogspyVersionOk || !$mysqlVersionOk || !$checksumOk) { ?>
		<div id="error" class="block">
			<h2 class="error">Une ou plusieurs erreurs sont apparues</h2>
			<p>
				L'installation ne peut pas continuer à cause des erreurs précédentes.
				Vous devez les corriger avant de pouvoir continuer l'installation.
			</p>
		</div>
	<?php } else { ?>
		<div id="form" class="block">
			<h2 class="info">Paramètres optionnels</h2>
			<p>Vous devez remplir ces paramètres pour compléter l'installation</p>
			
			<div>
				<label for="universe">Nom de domaine du serveur ogame (ex: http://uni23.ogame.fr)</label> <br />
				<input type="text" name="universe" id="universe" maxlength="25" size="25" value="<?php echo (isset($_POST['universe']) ? htmlentities($_POST['universe']).'" class="error' : 'http://uniXX.ogame.fr'); ?>" />
			</div>
			<div>
				<input type="checkbox" name="ogspy_log" id="ogspy_log" checked="checked" />
				<label for="ogspy_log">Logger les actions des utilisateurs dans les journaux OGSpy au lieu de ceux Xtense</label>
			</div>
			
			<p class="install">
				<button type="submit" onclick="if (!document.getElementById('universe').value.match(/^http:\/\/uni[0-9]+\.ogame\.[a-z.]+$/gi)) {alert('Nom de domaine invalide !'); return false;}">Lancer l'installation</button>
			</p>
			
			<input type="hidden" name="install" value="1" />
		</div>
	<?php } ?>
	
	</form>
	<?php } else { // Installation ?>
	
	<div id="end_install" class="block">
		<h2 class="success">Installation finie</h2>
		<p>L'installation de Xtense s'est correctement déroulée.</p>
	</div>
		
		<?php if (!empty($callInstall['success']) && !empty($callInstall['errors'])) { ?>
		<div id="calls" class="block">
			<h2>Liste des liens</h2>
			
			<?php if (!empty($callInstall['success'])) { ?>
				<p><em>Voici la liste des liens correctement installés</em></p>
				<ul>
					<?php foreach ($callInstall['success'] as $reason) { ?>
						<li><?php echo $reason; ?></li>
					<?php } ?>
				</ul>
			<?php } ?>
			
			<?php if (!empty($callInstall['errors'])) { ?>
				<p><em>Certains liens n'ont pas pû être automatiquement installés</em></p>
				<ul>
					<?php foreach ($callInstall['errors'] as $reason) { ?>
						<li><?php echo $reason; ?></li>
					<?php } ?>
				</ul>
			<?php } ?>
			</div>
		<?php } // liens ?>
	
	<div id="backlink" class="block">
		<p><a href="?action=administration&subaction=mod">Vous pouvez dès maintenant revenir à OGSpy en cliquant sur ce lien</a></p>
	</div>
	<?php } // End: Install ?>
</div>
</body>
</html>
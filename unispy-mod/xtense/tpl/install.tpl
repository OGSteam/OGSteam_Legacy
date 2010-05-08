<?php if (!defined('CARTO')) exit; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>" >
<head>
	<title>Xtense <?php echo $version.' - '.__('install title'); ?></title>
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

#uninstall_old_xtense2 {
	margin-right: 30px;
}

#delete_old_xtense2 {
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
	<h1><?php echo __('install subtitle',$version); ?></h1>
	
	<?php if (!isset($install)) { ?>
	<form action="" method="get">
	<input type="hidden" name="action" value="<?php echo $action_parameter;?>" />
	<input type="hidden" name="<?php echo $mod_parameter;?>" value="Xtense" />
	
	<div id="requirements" class="block">
		<h2 class="<?php if (!$ogspyVersionOk || !$mysqlVersionOk) echo 'error'; ?>"><?php echo __('install required config'); ?></h2>
		<ul>
			<li><?php echo CARTO.' '.$carto_min_version;?> - <span class="<?php echo !$ogspyVersionOk?'n':''; ?>ok"><?php echo __('install actual version',$ogspyVersion); ?></span></li>
			<li>PHP 5 - <span class="ok"><?php echo __('install actual version',$phpVersion); ?></span></li>
			<li>MySQL 4.1 - <span class="<?php echo !$mysqlVersionOk?'n':''; ?>ok"><?php echo __('install actual version',$mysqlVersion); ?></span></li>
			<li><?php echo __('install log write access').' '.($logWritable?'<span class="ok">'.__('common yes').'</span>':'<span class="warn">'.__('common no').'</span>'); ?></li>
		</ul>
	</div>
	
	<?php if ($directoryOld) { ?>
		<div id="old" class="block">
			<h2 class="warn"><?php echo __('install old folder detected'); ?></h2>
			<p>
				<?php echo __('install old folder detected warn'); ?>
			</p>
		</div>
	<?php } ?>

	<?php if ($OldXtenseFolder && $OldXtenseID) { ?>
		<div id="old" class="block">
			<h2 class="warn"><?php echo __('install old version detected',$OldXtenseVersion); ?></h2>
			<p>
				<?php echo __('install old version detected warn'); ?>
			</p>
			<p>
				<input type="checkbox" name="uninstall_old_xtense2" id="uninstall_old_xtense2" checked="checked" />
				<label for="uninstall_old_xtense2"><?php __('install unistall old module'); ?></label><br />		
				<input type="checkbox" name="delete_old_xtense2" id="delete_old_xtense2" checked="checked" />
				<label for="delete_old_xtense2"><?php __('install delete old module files'); ?></label>				
			</p>			
		</div>
	<?php } elseif($OldXtenseFolder) { ?>
		<div id="old" class="block">
			<h2 class="warn"><?php echo __('install old version detected',$OldXtenseVersion); ?></h2>
			<p>
				<?php echo _('install old version deteted warn 2'); ?>
			</p>
			<p>
				<input type="checkbox" name="delete_old_xtense2" id="delete_old_xtense2" checked="checked" />
				<label for="delete_old_xtense2"><?php echo __('install delete old folder'); ?></label>				
			</p>
		</div>
	<?php } ?>
	
	<div id="checksum" class="block">
		<h2 class="<?php if (!$checksumOk) echo 'error'; ?>"><?php echo __('install checksum title'); ?></h2>
		<?php if ($checksumOk) { ?>
			<p><?php echo __('install checksum ok'); ?></p>
		<?php } else { ?>
			<p><?php echo __('install checksum error'); ?></p>
			<ul>	
			<?php foreach ($checksumFiles as $file) { ?>
				<li>mod/Xtense/<?php echo $file; ?></li>
			<?php } ?>
			</ul>
		<?php } ?>
	</div>
	
	<div id="plugin" class="block">
		<h2 class="<?php if (!$pluginOk) echo 'warn'; ?>"><?php echo __('install plugin verif'); ?></h2>
		
		<?php if ($pluginOk) { ?>
			<p><?php echo __('install plugin ok'); ?></p>
		<?php } else { ?>
			<p>
				<?php echo __('install plugin unable to connect'); ?>
			</p>
			<p>
				<?php echo __('install plugin can copy to root'); ?>
			</p>
				<?php if ($pluginMoveable) { ?>
					<p><?php echo __('install can make copy'); ?></p>
					<p>
						<input type="checkbox" name="copy_plugin" id="copy_plugin" checked="checked" />
						<label for="copy_plugin"><?php echo __('install copy to root button'); ?></label>
					</p>
				<?php } else { ?>
					<p><?php echo __('install cannot make copy'); ?></p>
					<p><strong><?php echo __('install you can'); ?></strong></p>
					<ul>
						<li>
							<?php echo __('install try to move manually'); ?>
						</li>
						<li>
							<?php echo __('install update permissions'); ?>
						</li>
					</ul>
				<?php } ?>
		<?php } ?>
	</div>
	
	<?php if (!$ogspyVersionOk || !$mysqlVersionOk || !$checksumOk) { ?>
		<div id="error" class="block">
			<h2 class="error"><?php echo __('install errors occur'); ?></h2>
			<p>
				<?php echo __('install errors abort'); ?>
			</p>
		</div>
	<?php } else { ?>
		<div id="form" class="block">
			<h2 class="info"><?php echo __('install optionnal param'); ?></h2>
			<p><?php echo __('install fill these infos'); ?></p>
			
			<div>
				<label for="universe"><?php echo __('install server domaine name '.CARTO);?></label> <br />
				<input type="text" name="universe" id="universe" maxlength="30" size="30" value="<?php echo (isset($_POST['universe']) ? htmlentities($_POST['universe']).'" class="error' : ___('install server pattern '.CARTO)); ?>" />
			</div>
			<div>
				<input type="checkbox" name="ogspy_log" id="ogspy_log" checked="checked" />
				<label for="ogspy_log"><?php echo __('install choose loging destination'); ?></label>
			</div>
			
			<p class="install">
				<button type="submit" onclick="if (!document.getElementById('universe').value.match(<?php echo $universe_regexp;?>)) {alert('Nom de domaine invalide !'); return false;}"><?php echo __('install run'); ?></button>
				<button type="button" onclick="window.location='index.php?action=administration&subaction=mod';"><?php echo __('install cancel'); ?></button>
			</p>
			
			<input type="hidden" name="install" value="1" />
		</div>
	<?php } ?>
	
	</form>
	<?php } else { // Installation ?>
	
	<div id="end_install" class="block">
		<h2 class="success"><?php echo __('install success'); ?></h2>
		<p><?php echo __('install all is ok'); ?></p>
	</div>
		
		<?php if (!empty($callInstall['success']) || !empty($callInstall['errors'])) { ?>
		<div id="calls" class="block">
			<h2><?php echo __('install callback list'); ?></h2>
			
			<?php if (!empty($callInstall['success'])) { ?>
				<p><em><?php echo __('install callbacks succesfully installed'); ?></em></p>
				<ul>
					<?php foreach ($callInstall['success'] as $reason) { ?>
						<li><?php echo $reason; ?></li>
					<?php } ?>
				</ul>
			<?php } ?>
			
			<?php if (!empty($callInstall['errors'])) { ?>
				<p><em><?php echo __('install some callbacks not installed'); ?></em></p>
				<ul>
					<?php foreach ($callInstall['errors'] as $reason) { ?>
						<li><?php echo $reason; ?></li>
					<?php } ?>
				</ul>
			<?php } ?>
			</div>
		<?php } // liens ?>
	
	<div id="backlink" class="block">
		<p><a href="<?php echo $returnLink;?>"><?php echo __('install back to '.CARTO); ?></a></p>
	</div>
	<?php } // End: Install ?>
</div>
</body>
</html>
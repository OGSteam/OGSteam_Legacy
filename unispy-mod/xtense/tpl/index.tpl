<?php if (!defined('CARTO')) exit; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2002/REC-xhtml1-20020801/DTD/xhtml1-transitional.dtd">
<script type="application/x-javascript">
<!--
function install (aEvent)
{
  var params = {
    "Xtense": { URL: aEvent.target.href,
             IconURL: aEvent.target.getAttribute("iconURL"),
             Hash: aEvent.target.getAttribute("hash"),
             toString: function () { return this.URL; }
    }
  };
  InstallTrigger.install(params);

  return false;
}

function toggle_callback_info() {
	block = document.getElementById('callback_info');
	if(block.style.display == 'block')
		block.style.display = 'none';
	else
		block.style.display = 'block';
}
-->
</script>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>" >
<head>
	<title>Xtense <?php echo $version; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" media="all" type="text/css" href="mod/Xtense/tpl/style.css" />
</head>
<body>
<h1><?php ___('admin h1'); ?></h1>
<script language="Javascript" type="text/javascript" src="mod/Xtense/js/config.js"></script>

<div id="wrapper">
	<ul id="menu">
		<li class="infos<?php if ($page == 'infos') echo ' active'; ?>">
			<div>
				<a href="index.php?action=xtense&amp;page=infos"><?php ___('tab infos'); ?></a>
			</div>
		</li>
		
	<?php if ($user['user_admin'] == 1 || ($user['user_coadmin'] == 1 && $config['xtense_strict_admin'] == 0)) { ?>
		<li class="config<?php if ($page == 'config') echo ' active'; ?>">
			<div>
				<a href="index.php?action=xtense&amp;page=config"><?php ___('tab config'); ?></a>
			</div>
		</li>
		<li class="user<?php if ($page == 'group') echo ' active'; ?>">
			<div>
				<a href="index.php?action=xtense&amp;page=group"><?php ___('tab group'); ?></a>
			</div>
		</li>
		<li class="mods<?php if ($page == 'mods') echo ' active'; ?>">
			<div>
				<a href="index.php?action=xtense&amp;page=mods"><?php ___('tab mods'); ?></a>
			</div>
		</li>
		<li class="log<?php if ($page == 'log') echo ' active'; ?>">
			<div>
				<a href="index.php?action=xtense&amp;page=log"><?php ___('tab log'); ?></a>
			</div>
		</li>
	<?php } ?>
		<li class="about<?php if ($page == 'about') echo ' active'; ?>">
			<div>
				<a href="index.php?action=xtense&amp;page=about"><?php ___('tab about'); ?></a>
			</div>
		</li>
	</ul>

	<div id="content">
	
<?php if ($page == 'infos') { ?>
	<h2><?php echo __('tb download'); ?></h2>
	<?php if (!isset($toolbar)) { ?>
		<p><a href="?action=xtense&toolbar"><?php ___('tb download link') ?></a></p>
	<?php } else { ?>
	<?php if ($toolbar_data !== false) { ?>
		<p><?php ___('tb download accept'); ?> <a href="<?php echo $toolbar_data['url']; ?>" title="<?php ___('add xtense to firefox'); ?>" hash="<?php echo $toolbar_data['hash']; ?>" onclick="return install(event);" iconURL="http://svn.ogsteam.fr/xtense/trunk/chrome/skin/classic/icon.png" target="_blank"><?php echo $toolbar_data['version']; ?></a> (<?php echo $toolbar_data['date']; ?>)</p>
	<?php } else { ?>
		<p class="error"><?php ___('tb download error'); ?></p>
	<?php } ?>
	<?php } ?>
	
	<h2><?php ___('tab infos'); ?></h2>
	
	<p><?php ___('here are infos needed'); ?></p>
	<p><label for="url"><strong><?php ___('URL universe'); ?></strong></label></p>
	<p class="c">
		<input type="text" class="infos" id="url" name="url" value="<?php echo $universe; ?>" onfocus="this.select();" onclick="this.select();" readonly/>
	</p>
	<p><label for="plugin"><strong><?php ___('URL module'); ?></strong></label></p>
	<p class="c">
		<input type="text" class="infos" id="plugin" name="plugin" value="<?php echo $url; ?>" onfocus="this.select();" onclick="this.select();" readonly />
	</p>
	<p><?php ___('info enter login'); ?></p>
	
<?php } elseif ($page == 'config') { ?>
	
	<?php if (isset($update)) { ?>
		<p class="success"><?php ___('update success'); ?></p>
	<?php } ?>
	
	<?php if (isset($action)) { ?>
			<?php if ($action == 'move') { ?>
				<?php if (isset($move_error)) { ?>
					<p class="error">
						<?php if ($move_error == 'file_access') { 
							___('xtense.php readonly');
						} elseif ($move_error == 'file_unlink') { 
							___('xtense.php undeleted');
						} elseif ($move_error == 'dir_access') { 
							___('folder readonly');
						} else { 
							___('critical error');
						}  ?>
					</p>
				<?php } else { ?>
					<p class="success"><?php ___('xtense.php move success'); ?></p>
				<?php } ?>
			<?php } elseif ($action == 'repair') { ?>
				<p class="success"><?php ___('user home repair success'); ?></p>
			<?php } elseif ($action == 'install_callbacks') { ?>
				<p class="success" name="callback_sumary"><?php echo __('callbacks installed').'&nbsp;'.__('callbacks installed summary',$installed_callbacks, $total_callbacks);
				if(!empty($callInstall['errors'])) { ?>
				<label for="callback_sumary">
					<button type="button" onclick="toggle_callback_info();" id="callback_button"><?php ___('callbacks errors detail'); ?></button>
				</label>
				<span id="callback_info">
					<h2><?php ___('callbacks lists'); ?></h2>
					<?php if (!empty($callInstall['success'])) { ?>
						<p><em><?php ___('callbacks installed success'); ?></em></p>
						<ul>
							<?php foreach ($callInstall['success'] as $reason) { ?>
								<li><?php echo $reason; ?></li>
							<?php } ?>
						</ul>
					<?php } ?>
					<?php if (!empty($callInstall['errors'])) { ?>
						<p><em><?php ___('callbacks installed errors'); ?></em></p>
						<ul>
						<?php foreach ($callInstall['errors'] as $reason) { ?>
							<li><?php echo $reason; ?></li>
						<?php } ?>
						</ul>
					<?php } ?>
				</span>
				<?php } ?>
				</p>
			<?php } ?>
	<?php } ?>

	<form action="?action=xtense&amp;page=config" method="post" name="form" id="form">
		<div class="col">
			<p>
				<span class="chk"><input type="checkbox" id="allow_connections" name="allow_connections"<?php echo ($config['xtense_allow_connections'] == 1 ? ' checked="checked"' : '');?> /></span>
				<label for="allow_connections"><?php ___('allow connexions'); ?></label>
			</p>
			<p>
				<span class="chk"><input type="checkbox" id="strict_admin" name="strict_admin"<?php echo ($config['xtense_strict_admin'] == 1 ? ' checked="checked"' : '');?> onclick="if (this.checked && <?php echo (int)($user['user_coadmin'] && !$user['user_admin']);?>) alert('<?php ___('coadmin alert'); ?>');" /></span>
				<label for="strict_admin"><?php ___('strict admin'); ?></label>
			</p>
			<p>
				<span class="chk"><input type="text" size="2" maxlength="2" id="keep_log" name="keep_log" value="<?php echo $config['xtense_keep_log']; ?>" /></span>
				<label for="keep_log"><?php ___('keep log duration'); ?></label>
			</p>
			<p>
				<span class="chk"><input type="checkbox" id="log_reverse" name="log_reverse"<?php echo ($config['xtense_log_reverse'] == 1 ? ' checked="checked"' : '');?> /></span>
				<label for="log_reverse"><?php ___('log reverse'); ?></label>
			</p>
			
			<p>
				<span class="chk"><input type="checkbox" id="plugin_root" name="plugin_root"<?php echo ($config['xtense_plugin_root'] == 1 ? ' checked="checked"' : '');?> /></span>
				<label for="plugin_root"><?php ___('plugin at root'); ?></label>
			</p>
			<p>
				<span class="chk"><input type="checkbox" id="spy_autodelete" name="spy_autodelete"<?php echo ($config['xtense_spy_autodelete'] == 1 ? ' checked="checked"' : '');?> /></span>
				<label for="spy_autodelete"><?php ___('spy autodelete'); ?></label>
			</p>
			<p>
				<span class="chk"><input type="text" size="30" maxlength="30" id="universe" name="universe" value="<?php echo $config['xtense_universe']; ?>" /></span>
				<label for="universe"><?php ___('game universe'); ?></label>
			</p>
		</div>
		
		<div>
			<fieldset>
				<legend><?php ___('request logging'); ?></legend>
				
				<p>
					<span class="chk"><input type="checkbox" id="log_system" name="log_system"<?php echo ($config['xtense_log_system'] == 1 ? ' checked="checked"' : '');?> /></span>
					<label for="log_system"><?php ___('system'); ?></label>
				</p>
				<p>
					<span class="chk"><input type="checkbox" id="log_spy" name="log_spy"<?php echo ($config['xtense_log_spy'] == 1 ? ' checked="checked"' : '');?> /></span>
					<label for="log_spy"><?php ___('spy'); ?></label>
				</p>
				<p>
					<span class="chk"><input type="checkbox" id="log_empire" name="log_empire"<?php echo ($config['xtense_log_empire'] == 1 ? ' checked="checked"' : '');?> onclick='if (this.checked) {if (!confirm("<?php echo js_compatibility(__('log empire alert')); ?>")) this.checked = false;}' /></span>
					<label for="log_empire"><?php ___('empire'); ?></label>
				</p>
				<p>
					<span class="chk"><input type="checkbox" id="log_ranking" name="log_ranking"<?php echo ($config['xtense_log_ranking'] == 1 ? ' checked="checked"' : '');?> /></span>
					<label for="log_ranking"><?php ___('ranking'); ?></label>
				</p>
				<p>
					<span class="chk"><input type="checkbox" id="log_ally_list" name="log_ally_list"<?php echo ($config['xtense_log_ally_list'] == 1 ? ' checked="checked"' : '');?> /></span>
					<label for="log_ally_list"><?php ___('ally_list'); ?></label>
				</p>
				<p>
					<span class="chk"><input type="checkbox" id="log_messages" name="log_messages"<?php echo ($config['xtense_log_messages'] == 1 ? ' checked="checked"' : '');?> /></span>
					<label for="log_messages"><?php ___('messages'); ?></label>
				</p>
				<hr size="1" />
				<p>
					<span class="chk"><input type="checkbox" id="log_ogspy" name="log_ogspy"<?php echo ($config['xtense_log_ogspy'] == 1 ? ' checked="checked"' : '');?> /></span>
					<label for="log_ogspy"><?php ___('use OGSpy log'); ?></label>
				</p>
			</fieldset>
		</div>
		<div class="clear sep"></div>
		<div id="actions">
			<h2><?php ___('actions'); ?></h2>
			<p>
				<a href="?action=xtense&amp;page=config&amp;do=move" class="action" title="<?php ___('do action'); ?>">&nbsp;</a>
				<?php ___('try to move xtense.php auto'); ?>
			</p>
			<p>
				<a href="?action=xtense&amp;page=config&amp;do=repair" class="action" title="<?php ___('do action'); ?>">&nbsp;</a>
				<?php ___('try to repair empire auto'); ?>
			</p>
			
			<p>
				<a href="?action=xtense&amp;page=config&amp;do=install_callbacks" class="action" title="<?php ___('do action'); ?>">&nbsp;</a>
				<?php ___('try to reinit callbacks'); ?>
			</p>
		</div>
		<div class="sep"></div>
		
		<p class="center"><button type="submit" class="submit"><?php ___('send'); ?></button> <button type="reset" class="reset"><?php ___('cancel'); ?></button></p>
		
		</form>
		
<?php } elseif ($page == 'group') { ?>


<script language="Javascript" type="text/javascript">
	var groups_id = [<?php echo implode(', ', $groups_id); ?>];
</script>

	<p><?php ___('group help permissions'); ?></p>
	
	<?php if (isset($update)) { ?>
		<p class="success"><?php ___('update success'); ?></p>
	<?php } ?>
	
	<p style="text-align:right;" class="p10"><span onclick="set_all(true);" style="cursor:pointer;"><?php ___('check all'); ?></span> / <span onclick="set_all(false);" style="cursor:pointer;"><?php ___('uncheck all'); ?></span></p>
	
	<form action="?action=xtense&amp;page=group" method="post" name="form" id="form">
	<input type="hidden" name="groups_id" id="groups_id" value="<?php echo implode('-', $groups_id); ?>" />
	<table width="100%">
		<tr>
			<th><?php ___('group name');?></th>
			<th width="12%" class="c"><?php ___('group system'); ?></th>
			<th width="12%" class="c"><?php ___('group rank'); ?></th>
			<th width="12%" class="c"><acronym title="<?php ___('group empire help'); ?>"><?php ___('group empire'); ?></acronym></th>
			<th width="12%" class="c"><?php ___('group messages'); ?></th>
			<th width="20" class="c"></th>
		</tr>
	<?php foreach ($group as $l) { ?>
		<tr>
			<td><?php echo $l['group_name']; ?></td>
			
			<td class="c"><input type="checkbox" name="system_<?php echo $l['group_id']; ?>" id="system_<?php echo $l['group_id']; ?>" <?php if ($l['system'] == 1) echo 'checked="checked"'; ?> /></td>
			<td class="c"><input type="checkbox" name="ranking_<?php echo $l['group_id']; ?>" id="ranking_<?php echo $l['group_id']; ?>" <?php if ($l['ranking'] == 1) echo 'checked="checked"'; ?> /></td>
			<td class="c"><input type="checkbox" name="empire_<?php echo $l['group_id']; ?>" id="empire_<?php echo $l['group_id']; ?>" <?php if ($l['empire'] == 1) echo 'checked="checked"'; ?> /></td>
			<td class="c"><input type="checkbox" name="messages_<?php echo $l['group_id']; ?>" id="messages_<?php echo $l['group_id']; ?>" <?php if ($l['messages'] == 1) echo 'checked="checked"'; ?> /></td>
			<td><input type="checkbox" onclick="check_row(<?php echo $l['group_id']; ?>, this);" /></td>
		</tr>
	<?php } ?>
	
		<tr class="bottom">
			<th></th>
			<th class="c"><input type="checkbox" onclick="check_col('system', this);" /></th>
			<th class="c"><input type="checkbox" onclick="check_col('ranking', this);" /></th>
			<th class="c"><input type="checkbox" onclick="check_col('empire', this);" /></th>
			<th class="c"><input type="checkbox" onclick="check_col('messages', this);" /></th>
			<th></th>
		</tr>
	</table>
	
	<div class="sep"></div>
	<p class="center"><button class="submit" type="submit"><?php ___('send'); ?></button> <button class="reset" type="reset"><?php ___('cancel');?></button></p>
	</form>
	
<?php } elseif ($page == 'mods') { ?>

	<p><?php ___('mods primary info'); ?></p><br/>
	<?php if (isset($update)) { ?>
		<p class="success"><?php ___('update success'); ?></p>
	<?php } ?>
	
	<form action="?action=xtense&amp;page=mods" method="post" name="form" id="form">
	<input type="hidden" name="calls_id" id="calls_id" value="<?php echo implode('-', $calls_id); ?>" />
	<table width="100%">
		<tr>
			<th class="c">#</th>
			<th><?php ___('mods name version'); ?></th>
			<th width="40%"><?php ___('mods data type'); ?></th>
			<th width="17%" class="c"><?php ___('mods status'); ?></th>
			<th width="17%" class="c"><?php ___('mods link status'); ?></th>
			<th class="c" width="10"></th>
		</tr>
	<?php if (empty($callbacks)) { ?>
		<tr>
			<td class="c" colspan="5"><em><?php ___('no callbacks found'); ?></em></td>
		</tr>
	<?php } ?>
	
	<?php foreach ($callbacks as $l) { ?>
		<tr>
			<td><?php echo $l['id']; ?></td>
			<td><?php echo $l['title']; ?> (<?php echo $l['version']; ?>)</td>
			<td><?php echo $l['type']; ?></td>
			<td class="c"><?php echo ($l['active'] == 1 ? 'Activ&eacute;' : 'D&eacute;sactiv&eacute;'); ?></td>
			<td class="c"><?php echo ($l['callback_active'] == 1 ? 'Activ&eacute;' : 'D&eacute;sactiv&eacute;'); ?></td>
			<td><a href="index.php?action=xtense&amp;page=mods&amp;toggle=<?php echo $l['id']; ?>&amp;state=<?php echo $l['callback_active']==1?0:1; ?>" title="<?php echo ($l['callback_active'] == 1 ? 'D&eacute;sactiver' : 'Activer'); ?> l'appel"><?php icon($l['callback_active'] == 1 ? 'reset' : 'valid'); ?></a></td>
		</tr>
	<?php } ?>
	</table>
	<br/>
	
<?php } elseif ($page == 'log') { ?>
<style type="text/css">@import url(mod/Xtense/js/calendar/theme.css);</style>
<script type="text/javascript" src="mod/Xtense/js/calendar/calendar.js" /></script>
<script type="text/javascript" src="mod/Xtense/js/calendar/calendar-fr.js" /></script>
<script type="text/javascript" src="mod/Xtense/js/calendar/calendar-setup.js" /></script>
	
	<?php if (isset($unwritable)) { ?>
		<p class="error"><?php ___('log write error'); ?></p>
	<?php } ?>

	<?php if (isset($purge)) { ?>
		<?php if ($purge == 0) { ?>
			<p class="error"><?php ___('log purge error'); ?></p>
		<?php } else { ?>
			<p class="success"><?php ___('log delete file success'); ?></p>
		<?php } ?>
	<?php } ?>
	
	<p>
		<?php echo __('log sumary',$log_size,$log_size_moy,$log_nb);?> -
		<a href="?action=xtense&amp;page=log&amp;purge" onclick="return confirm('<?php ___('log delete all confirm'); ?>');"><?php ___('log delete all'); ?></a>
	</p>
	
	<div class="sep"></div>
	<form action="?action=xtense&amp;page=log" method="post" name="form" id="form">
		<label><?php ___('log date to diplay'); ?> : <input type="text" id="date" name="date" size="10" maxlength="10" readonly value="<?php echo $date; ?>" /></label>
		<button class="submit" type="submit"><?php ___('log show'); ?></button>
	</form>
	
<script type="text/javascript">
var availableLogs = [<?php if (!empty($availableLogs)) echo "'".implode(',', $availableLogs)."'"; ?>];

Calendar.setup({
	inputField  : 'date',
	ifFormat    : '%d/%m/%Y',
	button      : 'date',
	showOthers  : true,
	range		: [2007, 2099],
	weekNumbers : false
});
</script>
<?php if (isset($error)) { ?>
	<p class="error"><?php echo __('unable to read file',$file); ?></p>
<?php } ?>

	<div class="sep"></div>
	<p><strong><?php echo __('log of',$date); ?> :</strong></p>
	<p id="log">
		<?php if (isset($no_log)) { 
			___('log empty');
		} else { 
			echo $content; 
		} ?>
	</p>
<?php } elseif ($page == 'about') { ?>
	<p>Xtense a &eacute;t&eacute; enti&egrave;rement r&eacute;-&eacute;crit par <a href="http://www.unibozu.fr/" onclick="return winOpen(this);" target="_blank">Unibozu</a></p>
	<p>Forum de support de l'OGSteam : <a href="http://ogsteam.fr/forum-59-xtense" onclick="return winOpen(this);" target="_blank">Xtense</a></p>
	<p>Set d'ic&ocirc;nes "Silk icons" par <a href="http://www.famfamfam.com/lab/icons/silk/">FamFamFam</a></p>
	
	<div class="sep"></div>
	<h2>Changelog</h2>
	
	<dl class="changelog">
		<dt>14 janvier 2009</dt>
			<dd>			
				<div class="version">Module OGSpy 2.2</div>
				<p>
					<em>Fix : </em><br />
					&nbsp;*  L'id de l'utilisateur ayant transmis un RE est d&eacute;sormais enregistr&eacute;e correctement.
				</p>
				<p>
					<em>Ajouts : </em><br />
					&nbsp;* Compatibilit&eacute; UniSpy et E-Univers partielle (galaxie, RE, classements)
				</p>
			</dd>
		<dt>09 novembre 2008</dt>
		<dd>
			<div class="version">Extension Firefox 2.1</div>
			<p>
				<em>Fix : </em><br />
				&nbsp;* Compatibilit&eacute; Foxgame<br />
				&nbsp;* Les plan&egrave;tes sans nom de joueurs dans la galaxie sont ignor&eacute;es (le reste du syst&egrave;me solaire est envoy&eacute;)<br />
				&nbsp;* L'absence de laboratoire ou de chantier spatial ne cr&eacute;e plus d'erreur<br />
			</p>
			<p>
				<em>Ajouts : </em><br />
				&nbsp;* Refonte de l'architecture du code par Unibozu<br />
				&nbsp;* Modification du design<br />
				&nbsp;* Ajout de la lecture des d&eacute;parts de flotte<br />
				&nbsp;* Lecture des ressources &agrave; quai sur la vue g&eacute;n&eacute;rale<br />
				&nbsp;* Am&eacute;lioration du journal d'erreurs (plus de pr&eacute;cisions sur les mods appell&eacute;s)<br />
			</p>
			
			<div class="version">Module OGSpy 2.1a</div>
			<p>
				<em>Fix : </em><br />
				&nbsp;* 
			</p>
			<p>
				<em>Ajouts : </em><br />
				&nbsp;* Le module n&eacute;cessite php5.<br />
				&nbsp;* A l'installation, le module v&eacute;rifie ses fichiers (checksum)<br />
				&nbsp;* A l'installation, le module propose de saisir l'adresse de l'univers de jeu (compatible avec les serveurs autres qu'ogame.fr).<br />
				&nbsp;* A l'installation, le module peut d&eacute;placer le fichier xtense.php &agrave; la racine de l'OGSpy.<br />
				&nbsp;- le module peut d&eacute;placer le fichier xtense.php &agrave; la racine de l'OGSpy.<br />
				&nbsp;* Ajout d'un bouton r&eacute;initialiser dans l'onglet Mods. Il permet de mettre &agrave; jour les appels &agrave; Xtense des autres modules sans avoir besoin les r&eacute;installer.<br />
			</p>
		</dd>
		<dt>Mercredi 1 janvier 2007</dt>
		<dd>
			<div class="version">Extension Firefox 2.0&beta;7</div>
			
			<p>
				<em>Fix :</em><br />
				&nbsp;* Lunes ayant pour nom "lune" qui &eacute;taient reconnues comme plan&egrave;tes<br />
				&nbsp;* Noms de plan&egrave;tes comportant des points<br />
				&nbsp;* Envoi de MIPS dans la galaxie<br />
			</p>
			<p>
				<em>Ajout :</em><br />
				&nbsp;* Bouton pour copier le texte de debug (retour du plugin)<br />
				&nbsp;* Mise en place des pr&eacute;f&eacute;rences par d&eacute;faut<br />
				&nbsp;* Activation des serveurs OGSpy<br />
				&nbsp;* Remise en forme des fen&ecirc;tres d'erreurs qui sont plus claires<br />
				&nbsp;* Noms des colonies absents des syst&egrave;mes solaires vus depuis une lune avec la r&eacute;duction de la galaxie par Foxgame
			</p>
			
			<div class="version">Module OGSpy 2.0&beta;6</div>	
			<p>
				<em>Fix : </em><br />
				&nbsp;* Erreur lors de la d&eacute;sactivation d'un OGSpy<br />
				&nbsp;* Parsing des RE sous OGSpy 3.05<br />
				&nbsp;* Effacement des RE<br />
				&nbsp;* Synchronisation des codes d'envois de Xtense qui sont maintenant comme dans la DB<br />
			</p>
			<p>
				<em>Ajouts : </em><br />
				&nbsp;* Option permettant d'activer ou non l'effacement automatique des RE<br />
			</p>
			
			
		</dd>
		
	</dl>
<?php } ?>
	</div>
</div>

<div id="foot"><?php echo round((get_microtime() - $time)*1000, 2); ?> ms - Plugin Xtense version <?php echo PLUGIN_VERSION; ?> - Cr&eacute;&eacute; par Unibozu - <a href="http://www.ogsteam.fr/viewforum.php?id=59" onclick="return winOpen(this);" target="_blank">Support</a></div>


</body>
</html>
<?php if (!defined('IN')) exit; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2002/REC-xhtml1-20020801/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" >
<head>
	<title>Xtense</title>
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
		<p><?php ___('tb download accept'); ?> <a href="<?php $toolbar_data['url']; ?>" onclick="return winOpen(this);" target="_blank"><?php echo $toolbar_data['version']; ?></a> (<?php echo $toolbar_data['date']; ?>)</p>
	<?php } else { ?>
		<p class="error"><?php ___('tb download error'); ?></p>
	<?php } ?>
	<?php } ?>
	
	<h2><?php ___('tab infos'); ?></h2>
	
	<p>Voici les informations que vous devez rentrer dans le plugin Xtense pour vous connecter à ce serveur : </p>
	<p><label for="url"><strong>URL de l'univers</strong></label></p>
	<p class="c">
		<input type="text" class="infos" id="url" name="url" value="http://uni<?php echo $univers; ?>.ogame.fr" onfocus="this.select();" onclick="this.select();" readonly/>
	</p>
	<p><label for="plugin"><strong>URL plugin OGSpy</strong></label></p>
	<p class="c">
		<input type="text" class="infos" id="plugin" name="plugin" value="<?php echo $url; ?>" onfocus="this.select();" onclick="this.select();" readonly />
	</p>
	<p>Vous devez également mettre votre pseudo et votre mot de passe de connexion à OGSpy</p>
	
<?php } elseif ($page == 'config') { ?>
	
	<?php if (isset($update)) { ?>
		<p class="success">Mise à jour effectuée</p>
	<?php } ?>
	
	<?php if (isset($action)) { ?>
			<?php if ($action == 'move') { ?>
				<?php if (isset($move_error)) { ?>
					<p class="error">
						<?php if ($move_error == 'file_access') { ?>
						Le fichier <em>xtense.php</em> déjà présent à la racine de votre ogspy n'est pas disponible en écriture, veuillez vérifier son CHMOD.
						<?php } elseif ($move_error == 'file_unlink') { ?>
						Impossible de supprimer le fichier <em>xtense.php</em> déjà présent à la racine de votre OGSpy.
						<?php } elseif ($move_error == 'dir_access') { ?>
						Le dossier racine de votre ogspy n'est pas disponible en écriture. Il est impossible de copier le plugin.
						<?php } else { ?>
						Une erreur critique est survenue lors de la copie du plugin !
						<?php }  ?>
					</p>
				<?php } else { ?>
					<p class="success">Le déplacement c'est correctement passé. L'URL du plugin a été modifiée pour correspondre à son nouvel emplacement.</p>
				<?php } ?>
			<?php } elseif ($action == 'repair') { ?>
				<p class="success">L'espace personnel a été correctement réparé</p>
			<?php } elseif ($action == 'install_callbacks') { ?>
				<p class="success">Les appels ont été installés. <?php echo $installed_callbacks; ?> appel(s) installé(s) pour un total de <?php echo $total_callbacks; ?> appels disponibles</p>
			<?php } ?>
	<?php } ?>

	<form action="?action=xtense&amp;page=config" method="post" name="form" id="form">
		<div class="col">
			<p>
				<span class="chk"><input type="checkbox" id="allow_connections" name="allow_connections"<?php echo ($config['xtense_allow_connections'] == 1 ? ' checked="checked"' : '');?> /></span>
				<label for="allow_connections">Autoriser les connexions au plugin</label>
			</p>
			<p>
				<span class="chk"><input type="checkbox" id="strict_admin" name="strict_admin"<?php echo ($config['xtense_strict_admin'] == 1 ? ' checked="checked"' : '');?> onclick="if (this.checked && <?php echo (int)($user['user_coadmin'] && !$user['user_admin']);?>) alert('Vous êtes co-admin, si vous cochez cette option vous ne pourrez plus acceder à l\'administration de Xtense');" /></span>
				<label for="strict_admin">Limiter l'administration à l'admin (et non aux co-admins)</label>
			</p>
			<p>
				<span class="chk"><input type="text" size="2" maxlength="2" id="keep_log" name="keep_log" value="<?php echo $config['xtense_keep_log']; ?>" /></span>
				<label for="keep_log">Durée de conservation des fichiers logs de Xtense (en jours, 0 pour aucune suppression).</label>
			</p>
			<p>
				<span class="chk"><input type="checkbox" id="log_reverse" name="log_reverse"<?php echo ($config['xtense_log_reverse'] == 1 ? ' checked="checked"' : '');?> /></span>
				<label for="log_reverse">Afficher les actions les plus récentes en haut dans le journal.</label>
			</p>
			
			<p>
				<span class="chk"><input type="checkbox" id="plugin_root" name="plugin_root"<?php echo ($config['xtense_plugin_root'] == 1 ? ' checked="checked"' : '');?> /></span>
				<label for="plugin_root">Plugin à la racine de votre OGSpy.</label>
			</p>
			<p>
				<span class="chk"><input type="checkbox" id="spy_autodelete" name="spy_autodelete"<?php echo ($config['xtense_spy_autodelete'] == 1 ? ' checked="checked"' : '');?> /></span>
				<label for="spy_autodelete">Effacement automatique des RE trop vieux (configurable depuis l'admin de OGSpy).</label>
			</p>
			<p>
				<span class="chk"><input type="text" size="25" maxlength="25" id="universe" name="universe" value="<?php echo $config['xtense_universe']; ?>" /></span>
				<label for="universe">Serveur ogame</label>
			</p>
		</div>
		
		<div>
			<fieldset>
				<legend>Journaliser les requêtes</legend>
				
				<p>
					<span class="chk"><input type="checkbox" id="log_system" name="log_system"<?php echo ($config['xtense_log_system'] == 1 ? ' checked="checked"' : '');?> /></span>
					<label for="log_system">Systemes solaires</label>
				</p>
				<p>
					<span class="chk"><input type="checkbox" id="log_spy" name="log_spy"<?php echo ($config['xtense_log_spy'] == 1 ? ' checked="checked"' : '');?> /></span>
					<label for="log_spy">Rapports d'espionnage</label>
				</p>
				<p>
					<span class="chk"><input type="checkbox" id="log_empire" name="log_empire"<?php echo ($config['xtense_log_empire'] == 1 ? ' checked="checked"' : '');?> onclick="if (this.checked) {if (!confirm('Attention ! La journalisation des pages des empires des joueurs n\'est pas forcement necessaire. Elle prend rapidement beaucoup de place dans les logs !\nEtes-vous sûr de vouloir l\'activer ?')) this.checked = false;}" /></span>
					<label for="log_empire">Empire (Pages Empire, Batiments, Recherche...)</label>
				</p>
				<p>
					<span class="chk"><input type="checkbox" id="log_ranking" name="log_ranking"<?php echo ($config['xtense_log_ranking'] == 1 ? ' checked="checked"' : '');?> /></span>
					<label for="log_ranking">Classements</label>
				</p>
				<p>
					<span class="chk"><input type="checkbox" id="log_ally_list" name="log_ally_list"<?php echo ($config['xtense_log_ally_list'] == 1 ? ' checked="checked"' : '');?> /></span>
					<label for="log_ally_list">Membres d'alliance</label>
				</p>
				<p>
					<span class="chk"><input type="checkbox" id="log_messages" name="log_messages"<?php echo ($config['xtense_log_messages'] == 1 ? ' checked="checked"' : '');?> /></span>
					<label for="log_messages">Messages</label>
				</p>
				<hr size="1" />
				<p>
					<span class="chk"><input type="checkbox" id="log_ogspy" name="log_ogspy"<?php echo ($config['xtense_log_ogspy'] == 1 ? ' checked="checked"' : '');?> /></span>
					<label for="log_ogspy">Utiliser le journal OGSpy</label>
				</p>
			</fieldset>
		</div>
		<div class="clear sep"></div>
		<div id="actions">
			<h2>Actions</h2>
			<p>
				<a href="?action=xtense&amp;page=config&amp;do=move" class="action" title="Effectuer cette action">&nbsp;</a>
				Tenter de déplacer automatiquement le fichier xtense.php à la racine de votre OGSpy
			</p>
			<p>
				<a href="?action=xtense&amp;page=config&amp;do=repair" class="action" title="Effectuer cette action">&nbsp;</a>
				Réparer les espaces personnels (en cas de problèmes avec un espace personnel plein)
			</p>
			
			<p>
				<a href="?action=xtense&amp;page=config&amp;do=install_callbacks" class="action" title="Effectuer cette action">&nbsp;</a>
				Installer les appels de tous les mods installés et activés
			</p>
		</div>
		<div class="sep"></div>
		
		<p class="center"><button type="submit" class="submit">Envoyer</button> <button type="reset" class="reset">Annuler</button></p>
		
		</form>
		
<?php } elseif ($page == 'group') { ?>


<script language="Javascript" type="text/javascript">
	var groups_id = [<?php echo implode(', ', $groups_id); ?>];
</script>

	<p>
		Vous pouvez definir pour chaque groupe de OGSpy les accès qu'ont les utilisateurs à Xtense.
	</p>
	
	<?php if (isset($update)) { ?>
		<p class="success">Mise à jour effectuée</p>
	<?php } ?>
	
	<p style="text-align:right;" class="p10"><span onclick="set_all(true);" style="cursor:pointer;">Tout cocher</span> / <span onclick="set_all(false);" style="cursor:pointer;">Tout decocher</span></p>
	
	<form action="?action=xtense&amp;page=group" method="post" name="form" id="form">
	<input type="hidden" name="groups_id" id="groups_id" value="<?php echo implode('-', $groups_id); ?>" />
	<table width="100%">
		<tr>
			<th>Nom</th>
			<th width="12%" class="c">Systemes</th>
			<th width="12%" class="c">Classement</th>
			<th width="12%" class="c"><acronym title="Pages Batiments, Recherches, Defenses.. et Empire">Empire</acronym></th>
			<th width="12%" class="c">Messages</th>
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
	<p class="center"><button class="submit" type="submit">Envoyer</button> <button class="reset" type="reset">Annuler</button></p>
	</form>
	
<?php } elseif ($page == 'mods') { ?>

	<p>Liste des mods liés au plugin Xtense. Ces liens permettent aux mods de récuperer les données envoyées par Xtense 2.
	Vous pouvez ici activer ou desactiver ces liaisons. Elles sont automatiquement créées par les mods.</p>
	
	<?php if (isset($update)) { ?>
		<p class="success">Mise à jour effectuée</p>
	<?php } ?>
	
	<form action="?action=xtense&amp;page=mods" method="post" name="form" id="form">
	<input type="hidden" name="calls_id" id="calls_id" value="<?php echo implode('-', $calls_id); ?>" />
	<table width="100%">
		<tr>
			<th class="c">#</th>
			<th>Nom/version du Mod</th>
			<th width="40%">Type de données</th>
			<th width="17%" class="c">Status du mod</th>
			<th width="17%" class="c">Status du lien</th>
			<th class="c" width="10"></th>
		</tr>
	<?php if (empty($callbacks)) { ?>
		<tr>
			<td class="c" colspan="5"><em>Aucun lien enregistré dans la base de données</em></td>
		</tr>
	<?php } ?>
	
	<?php foreach ($callbacks as $l) { ?>
		<tr>
			<td><?php echo $l['id']; ?></td>
			<td><?php echo $l['title']; ?> (<?php echo $l['version']; ?>)</td>
			<td><?php echo $l['type']; ?></td>
			<td class="c"><?php echo ($l['active'] == 1 ? 'Activé' : 'Désactivé'); ?></td>
			<td class="c"><?php echo ($l['callback_active'] == 1 ? 'Activé' : 'Désactivé'); ?></td>
			<td><a href="index.php?action=xtense&amp;page=mods&amp;toggle=<?php echo $l['id']; ?>&amp;state=<?php echo $l['callback_active']==1?0:1; ?>" title="<?php echo ($l['callback_active'] == 1 ? 'Désactiver' : 'Activer'); ?> l'appel"><?php icon($l['callback_active'] == 1 ? 'reset' : 'valid'); ?></a></td>
		</tr>
	<?php } ?>
	</table>

<?php } elseif ($page == 'log') { ?>
<style type="text/css">@import url(mod/Xtense/js/calendar/theme.css);</style>
<script type="text/javascript" src="mod/Xtense/js/calendar/calendar.js" /></script>
<script type="text/javascript" src="mod/Xtense/js/calendar/calendar-fr.js" /></script>
<script type="text/javascript" src="mod/Xtense/js/calendar/calendar-setup.js" /></script>
	
	<?php if (isset($unwritable)) { ?>
		<p class="error">Le dossier log/ du plugin Xtense n'est pas accessible en écriture ! Les journaux ne seront pas sauvegardés</p>
	<?php } ?>

	<?php if (isset($purge)) { ?>
		<?php if ($purge == 0) { ?>
			<p class="error">Une erreur a eu lieue lors de la suppression des fichiers. Impossible de continuer.</p>
		<?php } else { ?>
			<p class="success">Fichiers supprimés</p>
		<?php } ?>
	<?php } ?>
	
	<p>
		Taille actuellement occupée par les fichiers de journalisation : <strong><?php echo $log_size; ?></strong> <em>(<?php echo $log_size_moy; ?> pour <?php echo $log_nb; ?> fichiers)</em> -
		<a href="?action=xtense&amp;page=log&amp;purge" onclick="return confirm('Etes-vous sûr de vouloir supprimer tous les journaux ?');">Tout supprimer</a>
	</p>
	
	<div class="sep"></div>
	<form action="?action=xtense&amp;page=log" method="post" name="form" id="form">
		<label>Date du journal à visionner : <input type="text" id="date" name="date" size="10" maxlength="10" readonly value="<?php echo $date; ?>" /></label>
		<button class="submit" type="submit">Voir</button>
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
	<p class="error">Impossible de lire le fichier du journal : <?php echo $file; ?></p>
<?php } ?>

	<div class="sep"></div>
	<p><strong>Historique du <?php echo $date; ?> :</strong></p>
	<p id="log">
		<?php if (isset($no_log)) { ?>
			Historique vide
		<?php } else { ?>
			<?php echo $content; ?>
		<?php } ?>
	</p>
<?php } elseif ($page == 'about') { ?>
	<p>Xtense a été entièrement ré-écrit par <a href="http://www.unibozu.fr/" onclick="return winOpen(this);" target="_blank">Unibozu</a></p>
	<p>Forum de support de l'OGSteam : <a href="http://ogsteam.fr/forum-59-xtense" onclick="return winOpen(this);" target="_blank">Xtense</a></p>
	<p>Set d'icônes "Silk icons" par <a href="http://www.famfamfam.com/lab/icons/silk/">FamFamFam</a></p>
	
	<div class="sep"></div>
	<h2>Changelog</h2>
	
	<dl class="changelog">
		<dt>Mercredi 1 janvier 2007</dt>
		<dd>
			<div class="version">Plugin 2.0&beta;6</div>
			
			<p>
				<em>Fix : </em><br />
				&nbsp;* Erreur lors de la désactivation d'un OGSpy<br />
				&nbsp;* Parsing des RE sous OGSpy 3.05<br />
				&nbsp;* Effacement des RE<br />
				&nbsp;* Synchronisation des codes d'envois de Xtense qui sont maintenant comme dans la DB<br />
			</p>
			<p>
				<em>Ajouts : </em><br />
				&nbsp;* Option permettant d'activer ou non l'effacement automatique des RE<br />
			</p>
			
			<div class="version">Barre d'outils 2.0&beta;7</div>
			
			<p>
				<em>Fix :</em><br />
				&nbsp;* Lunes ayant pour nom "lune" qui étaient reconnues comme planètes<br />
				&nbsp;* Noms de planètes comportant des points<br />
				&nbsp;* Envoi de MIPS dans la galaxie<br />
			</p>
			<p>
				<em>Ajout :</em><br />
				&nbsp;* Bouton pour copier le texte de debug (retour du plugin)<br />
				&nbsp;* Mise en place des préférences par défaut<br />
				&nbsp;* Activation des serveurs OGSpy<br />
				&nbsp;* Remise en forme des fenêtres d'erreurs qui sont plus claires<br />
				&nbsp;* Noms des colonies absents des systèmes solaires vus depuis une lune avec la réduction de la galaxie par Foxgame
			</p>
		</dd>
		
	</dl>
<?php } ?>
	</div>
</div>

<div id="foot"><?php echo round((get_microtime() - $time)*1000, 2); ?> ms - Plugin Xtense version <?php echo PLUGIN_VERSION; ?> - Créé par Unibozu - <a href="http://ogsteam.fr/forums/viewforum.php?id=40" onclick="return winOpen(this);" target="_blank">Support</a></div>


</body>
</html>
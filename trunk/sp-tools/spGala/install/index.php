<?php
	require ( '../classes/mysql.class.php' );
	require ( '../classes/permissions.class.php' );
	require ( '../includes/commons.php' );
	
	$response = true;
	
	if ( isset($_POST['user'], $_POST['pass'], $_POST['host'], $_POST['name'], $_POST['root_pass'], $_POST['root_passc']) )
	{
		$response = array();
		
		if ( !preg_match(PASS_MATCH, trim($_POST['root_pass'])) )
			$response[] = 'Le mot de passe Admin doit avoir une longueur minimale de 8 caractères et un maximum de 32.<br />Sont autorisés lettres et chiffres, ".", "-" e "_".';
			
		if ( md5(trim($_POST['root_pass'])) !== md5(trim($_POST['root_passc'])) )
			$response[] = PASSWORD_CHECK_FAILED;
		
		if ( empty($response) )
		{
			$db_host = trim($_POST['host']);
			$db_user = trim($_POST['user']);
			$db_pass = trim($_POST['pass']);		
			$db_name = trim($_POST['name']);
			
			$db = new DATABASE($db_host, $db_user, $db_pass, $db_name);
			
			$db->query(
				"DROP TABLE IF EXISTS `spgdb_config`"
			);
			
			$db->query(
				"CREATE TABLE `spgdb_config` (
				  `id` int(11) NOT NULL auto_increment,
				  `name` varchar(20) collate latin1_general_ci NOT NULL default '',
				  `value` varchar(100) collate latin1_general_ci NOT NULL default '',
				  PRIMARY KEY  (`id`)
				) DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci"
			);
			
			$db->query(
				"INSERT INTO `spgdb_config` (`id`,`name`,`value`) VALUES 
				 (1,'tag','SPGdb v2.0'),
				 (2,'name','Space Pioneers Galaxy Database'),
				 (3,'skin','default'),
				 (4,'gmt','1'),
				 (5,'gmtsign','+'),
				 (6,'dst','0'),
				 (7,'lang','it'),
				 (8,'pruning','0'),
				 (9,'windows','3'),
				 (10,'maxrankings','100')"
			);
			
			$db->query(
				"DROP TABLE IF EXISTS `spgdb_planets`"
			);
			
			$db->query(
				"CREATE TABLE `spgdb_planets` (
				  `id` bigint(20) unsigned NOT NULL auto_increment,
				  `fkplayer` int(10) unsigned NOT NULL default '0',
				  `name` varchar(20) collate latin1_general_ci NOT NULL default '',
				  `x` smallint(3) unsigned NOT NULL default '0',
				  `y` smallint(3) unsigned NOT NULL default '0',
				  `z` smallint(3) unsigned NOT NULL default '0',
				  `build00` varchar(30) collate latin1_general_ci NOT NULL default '0',
				  `build01` varchar(30) collate latin1_general_ci NOT NULL default '0',
				  `build02` varchar(30) collate latin1_general_ci NOT NULL default '0',
				  `build03` varchar(30) collate latin1_general_ci NOT NULL default '0',
				  `build04` varchar(30) collate latin1_general_ci NOT NULL default '0',
				  `build05` varchar(30) collate latin1_general_ci NOT NULL default '0',
				  `build06` tinyint(3) unsigned NOT NULL default '0',
				  `build07` tinyint(3) unsigned NOT NULL default '0',
				  `build08` tinyint(3) unsigned NOT NULL default '0',
				  `build09` tinyint(3) unsigned NOT NULL default '0',
				  `build10` tinyint(3) unsigned NOT NULL default '0',
				  `build11` tinyint(3) unsigned NOT NULL default '0',
				  `build12` tinyint(3) unsigned NOT NULL default '0',
				  `build13` tinyint(3) unsigned NOT NULL default '0',
				  `ship00` int(10) unsigned NOT NULL default '0',
				  `ship01` int(10) unsigned NOT NULL default '0',
				  `ship02` int(10) unsigned NOT NULL default '0',
				  `ship03` int(10) unsigned NOT NULL default '0',
				  `ship04` int(10) unsigned NOT NULL default '0',
				  `ship05` int(10) unsigned NOT NULL default '0',
				  `ship06` int(10) unsigned NOT NULL default '0',
				  `ship07` int(10) unsigned NOT NULL default '0',
				  `ship08` int(10) unsigned NOT NULL default '0',
				  `ship09` int(10) unsigned NOT NULL default '0',
				  `ship10` int(10) unsigned NOT NULL default '0',
				  `ship11` int(10) unsigned NOT NULL default '0',
				  `ship12` int(10) unsigned NOT NULL default '0',
				  `ship13` int(10) unsigned NOT NULL default '0',
				  `ship14` int(10) unsigned NOT NULL default '0',
				  `ship15` int(10) unsigned NOT NULL default '0',
				  `ship16` int(10) unsigned NOT NULL default '0',
				  `ship17` int(10) unsigned NOT NULL default '0',
				  `def00` int(10) unsigned NOT NULL default '0',
				  `def01` int(10) unsigned NOT NULL default '0',
				  `def02` int(10) unsigned NOT NULL default '0',
				  `def03` int(10) unsigned NOT NULL default '0',
				  `def04` int(10) unsigned NOT NULL default '0',
				  `def05` int(10) unsigned NOT NULL default '0',
				  `def06` int(10) unsigned NOT NULL default '0',
				  `def07` int(10) unsigned NOT NULL default '0',
				  `def08` int(10) unsigned NOT NULL default '0',
				  `def09` int(10) unsigned NOT NULL default '0',
				  `date` int(10) unsigned NOT NULL default '0',
				  `fkplayerud` int(10) unsigned NOT NULL default '0',
				  PRIMARY KEY  (`id`),
				  UNIQUE KEY `x_y_z` (`x`,`y`,`z`)
				) DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci"
			);
			
			$db->query(
				"DROP TABLE IF EXISTS `spgdb_players`"
			);
			
			$db->query(
				"CREATE TABLE `spgdb_players` (
				  `id` int(11) NOT NULL auto_increment,
				  `nick` varchar(20) collate latin1_general_ci NOT NULL default '',
				  `ally` varchar(10) collate latin1_general_ci NOT NULL default '',
				  `class` tinyint(4) NOT NULL default '0',
				  `status` tinyint(4) NOT NULL default '0',
				  `date` int(11) NOT NULL,
				  `notes` text collate latin1_general_ci,
				  `oldnick` varchar(20) collate latin1_general_ci NOT NULL default '',
				  PRIMARY KEY  (`id`),
				  UNIQUE KEY `nick` (`nick`)
				) DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci"
			);
			
			$db->query(
				"DROP TABLE IF EXISTS `spgdb_res`"
			);
			
			$db->query(
				"CREATE TABLE `spgdb_res` (
				  `id` int(11) NOT NULL auto_increment,
				  `fkplayer` int(11) NOT NULL,
				  `res00` tinyint(4) NOT NULL,
				  `res01` tinyint(4) NOT NULL,
				  `res02` tinyint(4) NOT NULL,
				  `res03` tinyint(4) NOT NULL,
				  `res04` tinyint(4) NOT NULL,
				  `res05` tinyint(4) NOT NULL,
				  `res06` tinyint(4) NOT NULL,
				  `res07` tinyint(4) NOT NULL,
				  `res08` tinyint(4) NOT NULL,
				  `res09` tinyint(4) NOT NULL,
				  `res10` tinyint(4) NOT NULL,
				  `res11` tinyint(4) NOT NULL,
				  `res12` tinyint(4) NOT NULL,
				  `res13` tinyint(4) NOT NULL,
				  `res14` tinyint(4) NOT NULL,
				  `res15` tinyint(4) NOT NULL,
				  `res16` tinyint(4) NOT NULL,
				  `res17` tinyint(4) NOT NULL,
				  `res18` tinyint(4) NOT NULL,
				  `res19` tinyint(4) NOT NULL,
				  `fkplayerud` int(11) NOT NULL,
				  PRIMARY KEY  (`id`),
				  UNIQUE KEY `fkplayer` (`fkplayer`)
				) DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci"
			);
			
			$db->query(
				"DROP TABLE IF EXISTS `spgdb_sessions`"
			);
			
			$db->query(
				"CREATE TABLE `spgdb_sessions` (
				  `id` int(11) NOT NULL auto_increment,
				  `fkuser` int(11) NOT NULL,
				  `ip` varchar(32) collate latin1_general_ci NOT NULL default '',
				  `browser` varchar(32) collate latin1_general_ci NOT NULL default '',
				  `sessionid` varchar(32) collate latin1_general_ci NOT NULL default '',
				  `lastaction` int(11) NOT NULL,
				  `td` int(11) NOT NULL,
				  `lang` varchar(2) collate latin1_general_ci NOT NULL default '',
				  `permissions` smallint(6) NOT NULL,
				  `nick` varchar(20) collate latin1_general_ci NOT NULL default '',
				  PRIMARY KEY  (`id`)
				) DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci"
			);
			
			$db->query(
				"DROP TABLE IF EXISTS `spgdb_stats`"
			);
			
			$db->query(
				"CREATE TABLE `spgdb_stats` (
				  `id` int(11) NOT NULL auto_increment,
				  `fkplayer` int(11) NOT NULL,
				  `tot` int(11) NOT NULL,
				  `build` int(11) NOT NULL,
				  `res` int(11) NOT NULL,
				  `fleetdef` int(11) NOT NULL,
				  `date` int(11) NOT NULL,
				  `n` int(11) NOT NULL,
				  `fkplayerud` int(11) NOT NULL,
				  PRIMARY KEY  (`id`),
				  UNIQUE KEY `fkplayer_n` (`fkplayer`,`n`)
				) DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci"
			);
			
			$db->query(
				"DROP TABLE IF EXISTS `spgdb_users`"
			);
			
			$db->query(
				"CREATE TABLE `spgdb_users` (
				  `id` int(11) NOT NULL auto_increment,
				  `nick` varchar(20) collate latin1_general_ci NOT NULL default '',
				  `pass` varchar(64) collate latin1_general_ci NOT NULL default '',
				  `email` varchar(50) collate latin1_general_ci NOT NULL default '',
				  `credentials` smallint(6) NOT NULL default '0',
				  `active` tinyint(4) NOT NULL default '0',
				  `login` int(11) NOT NULL default '0',
				  `ip` varchar(15) collate latin1_general_ci NOT NULL default '0.0.0.0',
				  `gmt` int(11) NOT NULL,
				  `gmtsign` char(1) collate latin1_general_ci NOT NULL default '',
				  `dst` tinyint(4) NOT NULL,
				  `lang` varchar(2) collate latin1_general_ci NOT NULL default '',
				  PRIMARY KEY  (`id`),
				  UNIQUE KEY `nick` (`nick`)
				) DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci"
			);
			
			$db->query(
				"INSERT INTO `spgdb_users` (`nick`,`pass`,`email`,`credentials`,`active`,`gmt`,`gmtsign`,`dst`,`lang`) VALUES
				('root','" . md5(trim($_POST['root_pass'])) . "','root@" . $_SERVER['HTTP_HOST'] . "','255','1','1','+','0','it')"
			);
						
			$config_data = '<?php'."\n\n";
			$config_data.= "\/\/Fichiers de configuration automatique de SPGdb v2.0\n\n";
			$config_data.= '$db_host = "'.$db_host.'";'."\n";
			$config_data.= '$db_user = "'.$db_user.'";'."\n";
			$config_data.= '$db_pass = "'.$db_pass.'";'."\n";
			$config_data.= '$db_name = "'.$db_name.'";'."\n\n";
			$config_data.= '?>';
			
			$response = false;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SPGala v.1.0  - Base de connaissance d'alliance pour Space Pioneers</title>
<link href="../skins/default/css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div align="center"><br />
  <img src="logo.gif" width="255" height="45" align="middle" />
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" id="output_table">
    <tr>
      <td class="tl"><img src="images/spacer.gif" width="1" height="1" /></td>
      <td class="top"><img src="images/spacer.gif" width="1" height="1" /></td>
      <td class="tr"><img src="images/spacer.gif" width="1" height="1" /></td>
    </tr>
    <tr>
      <td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
      <td class="name" valign="middle">Installation</td>
      <td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
    </tr>
    <tr>
      <td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
      <td>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <?php
			if ( is_array($response) )
			{
				echo '<tr><td colspan="2">' . "\n";
				
				foreach ($response as $msg)
					echo '<span class="label">• ' . $msg . '</span><br />';

				echo '</td></tr>' . "\n";
				echo '<tr><td><img src="images/spacer.gif" width="1" height="5" align="right" /></td></tr>' . "\n";
			}
			else if ($response === false)
			{
				echo '<tr><td colspan="2" align="center">' . "\n";
				echo '<span class="label">L\'installation a été achevée. <br /> Téléchargez le fichier de configuration et le mettre dans le dossier principal SPGdb. <br /> Sans oublier d\' <strong> <span style="text-decoration:underline;"> ÉLIMINER </ span> </ strong> <span style="text-decoration:underline;"> <strong> le dossier d\'installation" </ Span> </strong>dans les plus brefs délais.</span>';
				echo '<form action="make_file.php" method="post">';
				echo '<input type="hidden" value="' . htmlspecialchars(stripslashes($config_data)) . '" name="config_data" /><br />';
				echo '<input name="submit" type="submit" class="button" value="Scarica il file di configurazione." />';
				echo '<br />';
				echo '<div id="gohome" style="display:none"><br />';
				echo '<a href="../index.php" style="text-decoration:none">';
				echo '</a></div>';
				echo '</form>';
				echo '</td></tr>' . "\n";
				echo '<tr><td><img src="images/spacer.gif" width="1" height="5" align="right" /></td></tr>' . "\n";
			}
			else if ($response === true || is_array($response))
			{
		?>
          <form method="post">
            <tr>
              <td colspan="2" align="center" class="text"></td>
            </tr>
            <tr>
              <td colspan="2" align="center" class="label">Data Serveur </td>
            </tr>
            <tr>
              <td width="50%" align="right" class="row2"> Adresse serveur mySql: </td>
              <td width="50%" align="left" class="row1">
                <label>
                <input name="host" type="text" id="host" />
                </label>
              </td>
            </tr>
            <tr>
              <td align="right" class="row2">Nom d'utilisateur: </td>
              <td align="left" class="row1">
                <input name="user" type="text" id="user" />
              </td>
            </tr>
            <tr>
              <td align="right" class="row2">Mot de passe:</td>
              <td align="left" class="row1">
                <input name="pass" type="password" id="pass" />
              </td>
            </tr>
            <tr>
              <td align="right" class="row2">Base de donnée: </td>
              <td align="left" class="row1">
                <input name="name" type="text" id="name" />
              </td>
            </tr>
            <tr>
              <td colspan="2" align="center" class="label">Account Admin.<br />
                Ce compte donne toutes les autorisations sur la base de données et ne peut être supprimé ou modifié. </td>
            </tr>
            <tr>
              <td align="right" class="row2">Mot de passe</td>
              <td align="left" class="row1">
                <input name="root_pass" type="password" id="root_pass" />
              </td>
            </tr>
            <tr>
              <td align="right" class="row2">Répéter le mot de passe: </td>
              <td align="left" class="row1">
                <input name="root_passc" type="password" id="root_passc" />
              </td>
            </tr>
            <tr>
              <td colspan="2" align="center">
                <input type="submit" value="Invia" />
              </td>
            </tr>
          </form>
		<?php
			}
		?>
        </table>
      </td>
      <td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
    </tr>
    <tr>
      <td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
      <td><img src="images/spacer.gif" width="1" height="1" /></td>
      <td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
    </tr>
    <tr>
      <td class="bl"><img src="images/spacer.gif" width="1" height="1" /></td>
      <td class="bottom"><img src="images/spacer.gif" width="1" height="1" /></td>
      <td class="br"><img src="images/spacer.gif" width="1" height="1" /></td>
    </tr>
  </table>
</div>
</body>
</html>

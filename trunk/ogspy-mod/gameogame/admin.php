<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');

$query = 'SELECT active FROM '.TABLE_MOD.' WHERE action=\'gameOgame\' AND active=\'1\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) die('Hacking attempt');

if (!($user_data['user_admin'] == 1 || $user_data['user_coadmin'] == 1 || $user_data['management_user'] == 1 || isAdmin($user_data['user_id']))) echo die('Vous n\'avez pas les droits suffisants pour visualiser cette page');

//retour des forms
if (isset($pub_anyUsers))
{
	$sql = 'UPDATE '.TABLE_GAME_USERS.' SET user=\'0\'';
	$db->sql_query($sql);
}

if (isset($pub_allUsers))
{
	$sql = 'SELECT user_id FROM '.TABLE_USER.'';
	$result = $db->sql_query($sql);
	while ($val=$db->sql_fetch_assoc($result))
	{
		$sql = 'SELECT id FROM '.TABLE_GAME_USERS.' WHERE id=\''.$val['user_id'].'\'';
		$rst = $db->sql_query($sql);
		if ($db->sql_numrows($rst))
		{
			$sql = 'SELECT id FROM '.TABLE_GAME_USERS.' WHERE id=\''.$val['user_id'].'\' AND user=\'1\'';
			$rst = $db->sql_query($sql);
			if (!$db->sql_numrows($rst))
			{
				$sql = 'UPDATE '.TABLE_GAME_USERS.' SET user=\'1\' WHERE id=\''.$val['user_id'].'\'';
				$db->sql_query($sql);
			}
		} else {
			$sql = 'INSERT INTO '.TABLE_GAME_USERS.' (id, user, admin) VALUES (\''.$val['user_id'].'\',\'1\',\'0\')';
			$db->sql_query($sql);
		}
	}
}
//Mise à jour des coeficients dans la BDD
if (isset($pub_coeff))
{
	$config['pertes'] = (int)$pub_pertesA;
	$config['degats'] = (int)$pub_pertesD;
	$config['pillage'] = (int)$pub_pillage;
	$config['recycl'] = (int)$pub_recyclage;
	$config['clune'] = (int)$pub_lune;
	gog_SauvConfig;
	$sql = 'UPDATE '.TABLE_GAME.' SET points=pertesA/100000*'.$config['pertes'].'+pertesD/100000*'.$config['degats'].'+(pillageM+pillageC+pillageD)/100000*'.$config['recycl'].'+(recycleM+recycleC)/100000*'.$config['recycl'].'+lune*'.$config['clune'];
	echo '<blink><font size=\'5\' color=\'red\'><b>Recalcul en cours. Merci de patienter...</b></font></blink>';
	$db->sql_query($sql);
	redirection('?action=gameOgame&subaction=admin');
}
// Mise a jour du nombre de ligne dans les paramètres
if (isset($pub_lignes))
{
    $config['ligne'] = (int)$pub_ligne;
    $sqldata=serialize($config);
    $query = "UPDATE ".TABLE_MOD_CFG." SET value = '".$sqldata."' WHERE `mod` = 'gameOgame' and `config`='config'";
    $db->sql_query($query);
    redirection('?action=gameOgame&subaction=admin');
}

if (isset($pub_gestion))
{
    $admin = ($pub_admin=='oui' ? 1 : 0);
    $user = ($pub_user=='oui' ? 1 : 0);
    $pub_gestion = (int)$pub_gestion;
	$sql = 'SELECT id FROM '.TABLE_GAME_USERS.' WHERE id=\''.$pub_gestion.'\'';
	$result = $db->sql_query($sql);
	if ($db->sql_numrows($result))
	{
        $sql = 'UPDATE '.TABLE_GAME_USERS.' SET admin=\''.$admin.'\', user=\''.$user.'\' WHERE id=\''.$pub_gestion.'\'';
        $db->sql_query($sql);
	} else {
        $sql = 'INSERT INTO '.TABLE_GAME_USERS.' (id, admin, user) VALUES (\''.$pub_gestion.'\',\''.$admin.'\',\''.$user.'\')';
        $db->sql_query($sql);
	}
	$sql = 'DELETE FROM '.TABLE_GAME_USERS.' WHERE admin=\'0\' AND user=\'0\'';
	$db->sql_query($sql);
	redirection('?action=gameOgame&subaction=admin');
}

// Connexion Xtense2
if (isset($pub_submitxt2))
  {
  // on récupère le n° d'id du mod
  $query = "SELECT `id` FROM `".TABLE_MOD."` WHERE `action`='gameOgame' AND `active`='1' LIMIT 1";
  $result = $db->sql_query($query);
  $gog_id = $db->sql_fetch_row($result);
  $gog_id = $gog_id[0];
  // on fait du nettoyage au cas ou
  $query = "DELETE FROM `".$table_prefix."xtense_callbacks"."` WHERE `mod_id`=".$gog_id;
  $db->sql_query($query);
  // Insert les données pour récuperer les RC
  $query = "INSERT INTO ".$table_prefix."xtense_callbacks"." ( `mod_id` , `function` , `type` )
				VALUES ( '".$gog_id."', 'gog_rc', 'rc')";
	$db->sql_query($query);
	// Insert les données pour récuperer les RR
	$query = "INSERT INTO ".$table_prefix."xtense_callbacks"." ( `mod_id` , `function` , `type` )
				VALUES ( '".$gog_id."', 'gog_rr', 'rc_cdr')";
	$db->sql_query($query);
  }
 
//Purge Soft
if (isset($pub_softP))
{
	if (isset($pub_soft))
	{
		$config['soft'] = (int)$pub_soft;
	}
	if (isset($pub_autoS))
	{
		$config['autoS'] = "TRUE";
		if ($config['autoH'] == "TRUE") { $config['autoH']="FALSE";}
	}else{
		$config['autoS'] = "FALSE";
	}
	softpurge();
	$config['timer']=time();
	gog_SauvConfig();
}
 
//Purge Hard
if (isset($pub_hardP))
{
	if (isset($pub_hard))
	{
		$config['hard'] = (int)$pub_hard;
	}
	if (isset($pub_autoH))
	{
		$config['autoH'] = "TRUE";
		if ($config['autoS'] == "TRUE") { $config['autoS']="FALSE";}
	} else {
		$config['autoH'] = "FALSE";
	}
	hardpurge();
	$config['timer']=time();
	gog_SauvConfig();
}
if (isset($pub_purge))
{
	purge();
	$config['timer']=time();
	gog_SauvConfig();
}

// Nettoyage
if (isset($pub_nettoy))
{
	echo "Nettoyage<br>";
	// Construit la liste des joueurs actifs
	$query = "SELECT DISTINCT id FROM `".TABLE_GAME_USERS."` WHERE `user`='1' ORDER BY id";
	$result = $db->sql_query($query);
	$userlist=array();
	while ($row = mysql_fetch_row($result))
	{
		$userlist[]=$row[0];
	}
	// on recherche les RC dont le sender n'existe plus
	// Extrait la liste des senders des RC
	$query = "SELECT DISTINCT sender FROM `".TABLE_GAME."` ORDER BY sender";
	$result = $db->sql_query($query);
	while ($row = mysql_fetch_row($result))
	{
		//On recherche si un 'sender' n'est pas dans la liste des joueurs actifs
		if (array_search($row[0],$userlist) === false)
		{
			// Si on en trouve un, on sélectionne la liste de ses RC
			$query = "SELECT id FROM `".TABLE_GAME."` WHERE `sender`=".$row[0];
			$result2 = $db->sql_query($query);
			while ($row2 = mysql_fetch_row($result2))
			{
				//supprime le RC
				$sql = 'DELETE FROM '.TABLE_GAME.' WHERE id=\''.$row2[0].'\'';
				$db->sql_query($sql);
				//supprime le RR 
				$sql = 'DELETE FROM '.TABLE_GAME_RECYCLAGE.' WHERE rc=\''.$row2[0].'\'';
				$db->sql_query($sql);
			}
		}
	}
	// On recherche les RC dont le sender est le défenseur
	foreach ($userlist as $val)
	{
		// liste les planètes du joueur
		$planet = array();
		$query = "SELECT coordinates FROM `".TABLE_USER_BUILDING."` WHERE `user_id`=".$val;
		$result = $db->sql_query($query);
		while ($row = mysql_fetch_row($result))
		{
			$planet[] = $row[0];
		}
		// Sélectionne la liste des RC du joueur
		$query = "SELECT id,coord_att,rawdata FROM `".TABLE_GAME."` WHERE `sender`=".$val." ORDER BY id";
		$result = $db->sql_query($query);
		while ($row = mysql_fetch_array($result))
		{
			// Si les coordonnées de l'attaquant ne sont pas dans la BDD, on va les chercher dans le RC	
			if ((!isset($row['coord_att'])) || $row['coord_att'] == "")
			{
				// Deux format de RC différents
				preg_match('#Attaquant\s.{3,110}\[(.{5,8})]#',$row['rawdata'],$coord_att);
				if (!isset($coord_att[1]))
				{
					preg_match('#Attaquant\s.{3,110}\((.{5,8})\)#',$row['rawdata'],$coord_att);
				}
				$row['coord_att'] = $coord_att[1];
			}			
			// On vérifie les coordonnées de l'attaquant correspondent à une planète du joueur
			if (array_search($row['coord_att'],$planet) === false)
			{
				// Si on ne trouve pas, le joueur n'est manifestement pas l'attaquant
				//supprime le RC
				$sql = 'DELETE FROM '.TABLE_GAME.' WHERE id=\''.$row['id'].'\'';
				$db->sql_query($sql);
				//supprime le RR éventuellement.
				$sql = 'DELETE FROM '.TABLE_GAME_RECYCLAGE.' WHERE rc=\''.$row['id'].'\'';
				$db->sql_query($sql); 
			}
		}
	}
	// On optimize les tables 
	$query = "OPTIMIZE TABLE ".TABLE_GAME;
	$db->sql_query($query);
	$query = "OPTIMIZE TABLE ".TABLE_GAME_RECYCLAGE;
	$db->sql_query($query);
}
//Controle systématique - Si un joueur n'existe plus dans la table TABLE_USERS, il faut le supprimer de 
// la liste des joueurs et supprimer ses RC 
//on récupère la liste des id qui sont dans la table du mod
$query = "SELECT DISTINCT id FROM `".TABLE_GAME_USERS."` ORDER BY id";
$result = $db->sql_query($query);
while ($id = $db->sql_fetch_row($result))
{
	// On vérifie si cet id existe 
	$query2 = "SELECT user_id FROM `".TABLE_USER."` WHERE `user_id`='".$id[0]."'";
	$result2 = $db->sql_query($query2);
	// on regarde combien de ligne on retrouve
	if (mysql_num_rows($result2) == 0) 
	{
		//On en a trouvé un 
		//On sélectionne la liste des RC du joueur
		$query3 = "SELECT id FROM `".TABLE_GAME."` WHERE `sender`=".$id[0];
		$result3 = $db->sql_query($query3);
		while ($row = mysql_fetch_array($result3))
		{
			//On supprime le RC
			$sql = 'DELETE FROM '.TABLE_GAME.' WHERE id=\''.$row['id'].'\'';
			$db->sql_query($sql);
			//On supprime le RR 
			$sql = 'DELETE FROM '.TABLE_GAME_RECYCLAGE.' WHERE rc=\''.$row['id'].'\'';
			$db->sql_query($sql); 
		}
		//On supprime le joueur de la liste
		$sql = "DELETE FROM ".TABLE_GAME_USERS." WHERE `id`='".$id[0]."'";
		$db->sql_query($sql);
		
		// On optimize les tables 
		$sql = "OPTIMIZE TABLE ".TABLE_GAME;
		$db->sql_query($sql);
		$sql = "OPTIMIZE TABLE ".TABLE_GAME_RECYCLAGE;
		$db->sql_query($sql);
		$sql = "OPTIMIZE TABLE ".TABLE_GAME_USERS;
		$db->sql_query($sql);
	}
}

// ---------------------------Début Affichage des tableaux -----------------------------------------
?>

	<form method='post' action='?action=gameOgame&subaction=admin'>
	<table align='center' width='100%'>		
		<tr>
			<td class='c' colspan='5'>Coefficients</td>
		</tr><tr>
			<td class='c' width='20%' align='center'>Pertes attaquant</td>
			<td class='c' width='20%' align='center'>Pertes défenseur</td>
			<td class='c' width='20%' align='center'>Pillage</td>
			<td class='c' width='20%' align='center'>Recyclage</td>
			<td class='c' width='20%' align='center'>Lune</td>
		</tr><tr>
			<th nowrap><input type='text' name='pertesA' size='3' value='<?php echo $config['pertes']; ?>'/> points/100k</th>
			<th nowrap><input type='text' name='pertesD' size='3' value='<?php echo $config['degats']; ?>'/> points/100k</th>
			<th nowrap><input type='text' name='pillage' size='3' value='<?php echo $config['pillage']; ?>'/> points/100k</th>
			<th nowrap><input type='text' name='recyclage' size='3' value='<?php echo $config['recycl']; ?>'/> points/100k</th>
			<th nowrap><input type='text' name='lune' size='3' value='<?php echo $config['clune']; ?>' /> points</th>
		</tr><tr>
			<td class='c' colspan='5' align='center'>
			<input type='hidden' name='coeff' value='1' />
			<input type='submit' value='Modifier les coefficients' /><br />
			<font color='red'><u>/!\</u> Les rapports de combats existants seront recalculés! <u>/!\</u></font></td>
		</tr>
	</table>
	</form>
	<form style='margin:0px;padding:0px;' method="post" action="?action=gameOgame&subaction=admin" enctype='multipart/form-data'>
	<table align='center' width='100%'>
        <tr>
            <th colspan='5'>
                Nombre de lignes affich&eacute;s dans les tableaux :
                <input type='text' name='ligne' size='3' value='<?php echo $config['ligne']; ?>'/>
                &nbsp;<?php echo help("line"); ?>
            </th>
        </tr>
        <tr>
            <td class='c' colspan='5' align='center'>
                <input name='lignes' type='submit' value='Enregistrer' />
            </td>
        </tr>
	</table>
	</form>
	<br />
	
<?php
	
//Connexion Xtense2
echo "<form name='xt2' style='margin:0px;padding:0px;' action='index.php?action=gameOgame&subaction=admin' enctype='multipart/form-data' method='post'><center>";
echo "<table width='100%' border='0'>
<tr>
  <td class='c' colspan='5'>Xtense 2&nbsp;&nbsp;</td>
</tr>";
echo "<tr>";
//On vérifie que la table xtense_callbacks existe
if( ! mysql_num_rows( mysql_query("SHOW TABLES LIKE '".$table_prefix."xtense_callbacks"."'")))
  {
  echo "<th>la barre Xtense2 semble ne pas &ecirc;tre install&eacute;e</th>";
  }else{
  // Si oui, on récupère le n° d'id du mod
  $query = "SELECT `id` FROM `".TABLE_MOD."` WHERE `action`='gameOgame' AND `active`='1' LIMIT 1";
  $result = $db->sql_query($query);
  $gog_id = $db->sql_fetch_row($result);
  $gog_id = $gog_id[0];
  // Maintenant on vérifie que le mod est déclaré dans la table
  $query = "SELECT `id` FROM ".$table_prefix."xtense_callbacks"." WHERE `mod_id`=".$gog_id;
  $result = $db->sql_query($query);
  // On doit avoir 1 entrées dans la table : une pour les RC,
  if (mysql_num_rows($result) != 2)
    {
    echo "<th>Le module 'GameOGame' n'est pas enregistr&eacute; aupr&egrave;s de Xtense2</th>";
    echo "<tr>";
    echo "<th>Souhaitez vous &eacute;tablir la connexion ?</th>";
    echo "</tr>";
    echo "<tr><td class='c' align='center'><input name='submitxt2' type='submit' value='Connecter Xtense2' /></td></tr>";
    }else{
    echo "<th>Le module 'GameOGame' est correctement enregistr&eacute; aupr&egrave;s de Xtense2</th>";
    }
  }
echo "</tr></table></form><br />";
?>

<table align='center'>
	<tr>
		<td class='c' align='center' colspan='5'>Gestion des membres</td>
	</tr><tr>
		<td class='c' align='center' colspan='5'>
		<form method='post' action='?action=gameOgame&subaction=admin'>
			<input type='submit' value='Tous joueurs'/><input type='hidden' name='allUsers' value='true'/>
		</form>
		<form method='post' action='?action=gameOgame&subaction=admin'>
			<input type='submit' value='Aucun joueur'/>
			<input type='hidden' name='anyUsers' value='true'/>
		</form>
		</td>
	</tr><tr>
		<td class='c'>Pseudo</td>
		<td class='c'>Nombre<br />de rapport</td>
		<td class='c'>Participant</td>
		<td class='c'>Admin</td>
		<td class='c'>&nbsp;</td>
	</tr>
<?php
$sql = 'SELECT user_id, user_name FROM '.TABLE_USER.' ORDER BY user_name ASC';
$result = $db->sql_query($sql);
while ( $val = $db->sql_fetch_assoc($result))
{
	$sql = 'SELECT count(id) AS nb FROM '.TABLE_GAME.' WHERE sender=\''.$val['user_id'].'\'';
	$nb = $db->sql_query($sql);
	list($nb) = $db->sql_fetch_row($nb);
	$admin = (isAdmin($val['user_id']) ? ' SELECTED' : '');
	$user = (isUser($val['user_id']) ? ' SELECTED' : '');
	
	echo '<form method=\'post\' action=\'?action=gameOgame&subaction=admin\'><tr><th><a href=\'?action=gameOgame&subaction=display&player='.$val['user_name'].'\'>'.$val['user_name'].'</a></th><th>'.$nb.'</th><th><select name=\'user\'><option>non</option><option'.$user.'>oui</option></select></th><th><select name=\'admin\'><option>non</option><option'.$admin.'>oui</option></select></th><th><input type=\'image\' src=\'./mod/gameOgame/images/check.png\'></th></tr><input type=\'hidden\' name=\'gestion\' value=\''.$val['user_id'].'\'></form>';
}

?>
</table>
<br />
<!-- Purges de la base de données -->
<form method='post' action='?action=gameOgame&subaction=admin' enctype='multipart/form-data' >
<table align='center' width='60%'>
<tr>
	<td class='l'>&nbsp;Purge de la base de donn&eacute;es</td>
</tr>
<tr>
	<td class='c'>&nbsp;Derni&egrave;re purge : <?php setlocale(LC_TIME, "fr_FR"); echo strftime("%A %d %B %Y %T" ,$config['timer'])."&nbsp;".help("timer"); ?></td>
</tr>
<tr>
	<td class='c'>&nbsp;Soft Purge&nbsp;<?php echo help("soft"); ?></td>
	
</tr>
<tr>
	<th>&nbsp;Supprimer les rapports inf&eacute;rieurs ou &eacute;gaux à&nbsp; <input type='text' value='<?php echo $config['soft']; ?>' name='soft' size='3' /> points</th>
</tr>
<tr>
	<th>&nbsp;Automatique&nbsp;<input type='checkbox' name='autoS' <?php echo ($config['autoS']=='TRUE'? "checked":""); ?>	/>&nbsp;<?php echo help("auto"); ?></th>
</tr>
<tr>
	<th><input type='submit' value='Purge' name='softP' /></th>
</tr>
</table>
</form>
<form method='post' action='?action=gameOgame&subaction=admin' enctype='multipart/form-data' >
<table align='center' width='60%'>
<tr>
	<td class='c'>&nbsp;Hard Purge&nbsp;<?php echo help("hard"); ?></td>
</tr>
<tr>
	<th>&nbsp;Ne conserver que les&nbsp;<input type='text' value='<?php echo $config['hard']; ?>' name='hard' size='3' /> meilleurs rapports de chaque joueur</th>
</tr>
<tr>
	<th>&nbsp;Automatique&nbsp;<input type='checkbox' name='autoH' <?php echo ($config['autoH']=='TRUE'? "checked":""); ?> />&nbsp;<?php echo help("auto"); ?></th>
</tr>
<tr>
	<th><input type='submit' value='Purge' name='hardP' /></th>
</tr>
</table>
</form>

<table align='center' width='60%'>
<tr>
	<td class='c'>&nbsp;Purge Totale&nbsp;<?php echo help("total"); ?></td>
</tr>
<tr>
	<th>&nbsp;Suppression de tout les rapports</th>
</tr>
<tr>
	<th>
	<form method='post' action='?action=gameOgame&subaction=admin' enctype='multipart/form-data' onSubmit="return confirm('Etes-vous sûr de vouloir supprimer tous les rapports?');" >
		<input type='submit' name='purge' value='Purge totale' />
	</form>
	</th>
</tr>
<tr>
	<td class='c'>&nbsp;Nettoyage&nbsp;<?php echo help("nettoy"); ?></td>
</tr>
<tr>
	<th>&nbsp;Supprimer les rapports orphelins et les rapports de défense</th>
</tr>
<tr>
	<th>
		<form method='post' action='?action=gameOgame&subaction=admin' enctype='multipart/form-data' >
			<input type='submit' name='nettoy' value='Nettoyage' />
		</form>
	</th>
</tr>
</table>
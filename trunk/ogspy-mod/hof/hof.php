<?php
	if (!defined('IN_SPYOGAME'))
		exit('Hacking attempt');
	
	/* On verifie que le mod est actif */
	
	$select_active	= mysql_query('SELECT active FROM ' . TABLE_MOD . ' WHERE action=\'hof\'');
	$active			= mysql_fetch_array($select_active);
	
	if (!$active[0])
		exit('Hacking attempt');
	
	/* Prefix des tables choisi lors de l'installation d'OGSpy */
	
	if (!isset ($table_prefix))
		global $table_prefix;
	
	// Variable qui defini sur quel page on est
	
	if (isset($_GET['page']))
		$page = htmlentities($_GET['page'], ENT_QUOTES);
	else
		$page = 'batiments';
	
	/* Definition des noms des tables utilisees en fonctions du prefix */
	
	define('TABLE_HOF_CONFIG', $table_prefix . 'hof_config');
	define('TABLE_HOF_RECORDS', $table_prefix . 'hof_records');
	define('TABLE_HOF_PROD', $table_prefix . 'hof_prod');
	
	define('TABLE_FLOTTES', $table_prefix . 'mod_flottes');
	
	// $rightToAdmin vaut true si l'utilisateur a le droit d'administre OGSpy
	
	if ($user_data['user_admin'] == 1 OR $user_data['user_coadmin'] == 1)
		$rightToAdmin = true;
	else
		$rightToAdmin = false;

	// Determine la taille, en %, des colones du menu
	
	if ($rightToAdmin)
		$rowWidth = 12;
	else
		$rowWidth = 14;
	
	require_once('views/page_header.php');
	require_once('mod/hof/pages/functions.php');
	require_once('mod/hof/pages/arrays.php');
?>

<style type='text/css'>
	@import url("mod/hof/pages/skin.css");
</style>

<table class='table_menu'>
	<tr>
		<td style='width : <?php echo $rowWidth; ?>%;'><a style='color : <?php if ($page == 'batiments') { echo 'lime;'; } else { echo '#00F0F0;'; } ?>' href='index.php?action=hof&page=batiments'>B�timents</a></td>
		<td style='width : <?php echo $rowWidth; ?>%;'><a style='color : <?php if ($page == 'labo') { echo 'lime;'; } else { echo '#00F0F0;'; } ?>' href='index.php?action=hof&page=labo'>Laboratoire</a></th>
		<td style='width : <?php echo $rowWidth; ?>%;'><a style='color : <?php if ($page == 'flottes') { echo 'lime;'; } else { echo '#00F0F0;'; } ?>' href='index.php?action=hof&page=flottes'>Flottes</a></td>
		<td style='width : <?php echo $rowWidth; ?>%;'><a style='color : <?php if ($page == 'defense') { echo 'lime;'; } else { echo '#00F0F0;'; } ?>' href='index.php?action=hof&page=defense'>D�fense</a></th>
		<td style='width : <?php echo $rowWidth; ?>%;'><a style='color : <?php if ($page == 'prod') { echo 'lime;'; } else { echo '#00F0F0;'; } ?>' href='index.php?action=hof&page=prod'>Production</a></td>
		<td style='width : <?php echo $rowWidth; ?>%;'><a style='color : <?php if ($page == 'bbcode') { echo 'lime;'; } else { echo '#00F0F0;'; } ?>' href='index.php?action=hof&page=bbcode'>Export BBCode</a></td>
		
		<?php
			if ($rightToAdmin)
			{
				echo '<td style=\'width : ' . $rowWidth . '%;\'><a style=\'color : ';
				
				if ($page == 'admin')
					echo 'lime;';
				else
					echo '#00F0F0;';
				
				echo '\' href=\'index.php?action=hof&page=admin\'>Administration</a></td>' . "\n";
			}
		?>
		<td style='width : <?php echo $rowWidth; ?>%;'><a style='color : <?php if ($page == 'changelog') { echo 'lime;'; } else { echo '#00F0F0;'; } ?>' href='index.php?action=hof&page=changelog'>Change Log</a></td>
	</tr>
</table>

<?php
	$userId = $user_data['user_id'];
	
	switch ($page)
	{
		/*
			- Batiments
		*/
		
		case 'batiments':
			if (isset($_GET['cat']) && $_GET['cat'] == 'cumul')
				$cat = 5;
			else
				$cat = 1;
			
			createHoF($cat, $labelBatiment, $nameBatiment, $iconBatiment, $userId);
			
			if ($cat == 1)
				echo '<p style=\'font-weight : bold;\'><a href=\'index.php?action=hof&amp;page=batiments&amp;cat=cumul\'>Voir les records des niveaux cumul�s</a></p>';
			else
				echo '<p style=\'font-weight : bold;\'><a href=\'index.php?action=hof&amp;page=batiments&amp;cat=nonCumul\'>Voir les records des niveaux non-cumul�s</a></p>';
			
			break;
		
		/*
			- Laboratoires
		*/
		
		case 'labo':
			createHoF(2, $labelLabo, $nameLabo, $iconLabo, $userId);
			break;
		
		/*
			- Flottes
		*/
		
		case 'flottes':
			$select_mod	= mysql_query('SELECT title FROM ' . TABLE_MOD . ' WHERE title=\'Flottes\'');
			$mod		= mysql_fetch_array($select_mod);
			
			if (!empty($mod))
				createHoF(3, $labelFlotte, $nameFlotte, $iconFlotte, $userId);
			else
				echo '<p style=\'color : red; font-weight : bold;\'>Vous devez installer le mod <a href=\'http://ogsteam.fr/sujet-1858-mod-flottes\'>Flottes</a> !</p>';
			
			break;
		
		/*
			- Defense
		*/
		
		case 'defense':
			if (isset($_GET['cat']) && $_GET['cat'] == 'cumul')
				$cat = 6;
			else
				$cat = 4;
			
			createHoF($cat, $labelDefense, $nameDefense, $iconDefense, $userId);
			
			if ($cat == 4)
				echo '<p style=\'font-weight : bold;\'><a href=\'index.php?action=hof&amp;page=defense&amp;cat=cumul\'>Voir les d�fenses cumul�es</a></p>';
			else
				echo '<p style=\'font-weight : bold;\'><a href=\'index.php?action=hof&amp;page=defense&amp;cat=nonCumul\'>Voir les d�fenses non-cumul�es</a></p>';
			
			break;
		
		/*
			- Le reste =)
		*/
		
		case 'prod':
			require_once('mod/hof/pages/prod.php');
			break;
		
		case 'bbcode':
			require_once('mod/hof/pages/bbcode.php');
			break;
		
		case 'admin':
			require_once('mod/hof/pages/admin.php');
			break;
		
		case 'changelog':
			require_once('mod/hof/pages/changelog.php');
			break;
	}
	
	require_once('views/page_tail.php');
?>
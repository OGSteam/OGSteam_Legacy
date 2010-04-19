<?php
	/* On recupere la configuration */
	
	$select_config	= mysql_query ('SELECT * FROM ' . TABLE_HOF_CONFIG . '');
	$settings		= array ();
	
	while ($config	= mysql_fetch_array ($select_config))
	{
		$settings[$config['parameter']] = $config['value'];
	}
	
	/* ** Generation du BBCode ** */
	
	/* Creation des categories */
	
	$catTable	= array (
		'1' => 'Bâtiments',
		'2' => 'Laboratoire',
		'3' => 'Flottes',
		'4' => 'Défense',
		'5' => 'Bâtiments (Niveaux cumulés)',
		'6' => 'Défense (Unitées cumulées)');
?>

<textarea rows='25' class='bbcode'><?php
	/* On affiche les records Bat, Labo, Flotte, Def */
	
	if ($settings['center'])
		echo '[center]';
	
	for ($i = 1 ; $i <= 6 ; $i++)
	{
		$select_hof	= mysql_query ('SELECT * FROM ' . TABLE_HOF_RECORDS . ' WHERE id_cat=\'' . $i . '\'');
		
		$cat		= '[color=' . $settings['couleurCat'] . '][size=' . $settings['tailleCat'] . ']' . $catTable[$i] . '[/size][/color]';
		
		if ($settings['gras'])
			$cat	= '[b]' . $cat . '[/b]';
		
		if ($settings['souligne'])
			$cat	= '[u]' . $cat . '[/u]';
		
		if ($settings['italic'])
			$cat	= '[i]' . $cat . '[/i]';
		
		echo $cat . "\n";
		
		echo '[list]' . "\n";
		
		while ($hof	= mysql_fetch_array ($select_hof))
		{
			$label		= '[color=' . $settings['couleurLabel'] . '][size=' . $settings['tailleLabel'] . ']' . $hof['nom'] . '[/size][/color]';
			$max		= ' [color=' . $settings['couleurNiv'] . '][size=' . $settings['tailleNiv'] . ']' . number_format ($hof['valeur'], 0, ',', ' ') . '[/size][/color] ';
			$pseudos	= '[color=' . $settings['couleurPseudos'] . '][size=' . $settings['taillePseudos'] . ']' . $hof['pseudos'] . '[/size][/color]';
			
			echo '[*]' . $label . $max . $pseudos . "\n";
		}
		
		echo '[/list]' . "\n\n";
	}
	
	/* On affiche la production */
	
	/* ** ******************** ** *
	 * ** Production Par Heure ** *
	 * ** ******************** ** */
	
	if ($settings['prod_heure'])
	{
		/* On affiche les records de production */
		
		$cat		= '[color=' . $settings['couleurCat'] . '][size=' . $settings['tailleCat'] . ']Production par Heure[/size][/color]';
		
		if ($settings['gras'])
			$cat	= '[b]' . $cat . '[/b]';
		
		if ($settings['souligne'])
			$cat	= '[u]' . $cat . '[/u]';
		
		if ($settings['italic'])
			$cat	= '[i]' . $cat . '[/i]';
		
		echo $cat . "\n";
		
		echo '[list]' . "\n";
		
		$select_records	= mysql_query ('SELECT * FROM ' . TABLE_HOF_PROD . ' ORDER BY m DESC LIMIT 0, ' . $settings['nb_recordsMen'] . '');
		
		while ($records	= mysql_fetch_array ($select_records))
		{
			if ($settings['uni50'])
			{
				$records['m'] = 2 * $records['m'];
				$records['c'] = 2 * $records['c'];
				$records['d'] = 2 * $records['d'];
			}
			
			$pseudo	= '[color=' . $settings['couleurPseudos'] . '][size=' . $settings['taillePseudos'] . ']' . $records['pseudo'] . '[/size][/color]';
			$m		= '[color=' . $settings['couleurNiv'] . '][size=' . $settings['taillePseudos'] . ']' . number_format ($records['m'], 0, ',', ' ') . '[/size][/color] ';
			$c		= '[color=' . $settings['couleurNiv'] . '][size=' . $settings['taillePseudos'] . ']' . number_format ($records['c'], 0, ',', ' ') . '[/size][/color] ';
			$d		= '[color=' . $settings['couleurNiv'] . '][size=' . $settings['taillePseudos'] . ']' . number_format ($records['d'], 0, ',', ' ') . '[/size][/color] ';
			
			echo '[*]' . $pseudo . ' : ' . $m . ' - ' . $c . ' - ' . $d . "\n";
		}
		
		echo '[/list]' . "\n";
	}
	
	/* ** ******************* ** *
	 * ** Production Par Jour ** *
	 * ** ******************* ** */
	
	if ($settings['prod_jour'])
	{
		$cat		= '[color=' . $settings['couleurCat'] . '][size=' . $settings['tailleCat'] . ']Production par Jour[/size][/color]';
		
		if ($settings['gras'])
			$cat	= '[b]' . $cat . '[/b]';
		
		if ($settings['souligne'])
			$cat	= '[u]' . $cat . '[/u]';
		
		if ($settings['italic'])
			$cat	= '[i]' . $cat . '[/i]';
		
		echo $cat . "\n";
		
		echo '[list]' . "\n";
		
		/* On affiche les records de production */
		
		$select_records	= mysql_query ('SELECT * FROM ' . TABLE_HOF_PROD . ' ORDER BY m DESC LIMIT 0, ' . $settings['nb_recordsMen'] . '');
		
		while ($records	= mysql_fetch_array ($select_records))
		{
			if ($settings['uni50'])
			{
				$records['m'] = 48 * $records['m'];
				$records['c'] = 48 * $records['c'];
				$records['d'] = 48 * $records['d'];
			}
			else
			{
				$records['m'] = 24 * $records['m'];
				$records['c'] = 24 * $records['c'];
				$records['d'] = 24 * $records['d'];
			}
			
			$pseudo	= '[color=' . $settings['couleurPseudos'] . '][size=' . $settings['taillePseudos'] . ']' . $records['pseudo'] . '[/size][/color]';
			$m		= '[color=' . $settings['couleurNiv'] . '][size=' . $settings['taillePseudos'] . ']' . number_format ($records['m'], 0, ',', ' ') . '[/size][/color] ';
			$c		= '[color=' . $settings['couleurNiv'] . '][size=' . $settings['taillePseudos'] . ']' . number_format ($records['c'], 0, ',', ' ') . '[/size][/color] ';
			$d		= '[color=' . $settings['couleurNiv'] . '][size=' . $settings['taillePseudos'] . ']' . number_format ($records['d'], 0, ',', ' ') . '[/size][/color] ';
			
			echo '[*]' . $pseudo . ' : ' . $m . ' - ' . $c . ' - ' . $d . "\n";
		}
		
		echo '[/list]' . "\n";
	}
	
	/* ** ********************** ** *
	 * ** Production Par Semaine ** *
	 * ** ********************** ** */
	
	if ($settings['prod_semaine'])
	{
		$cat		= '[color=' . $settings['couleurCat'] . '][size=' . $settings['tailleCat'] . ']Production par Semaine[/size][/color]';
		
		if ($settings['gras'])
			$cat	= '[b]' . $cat . '[/b]';
		
		if ($settings['souligne'])
			$cat	= '[u]' . $cat . '[/u]';
		
		if ($settings['italic'])
			$cat	= '[i]' . $cat . '[/i]';
		
		echo $cat . "\n";
		
		echo '[list]' . "\n";
		
		/* On affiche les records de production */
		
		$select_records	= mysql_query ('SELECT * FROM ' . TABLE_HOF_PROD . ' ORDER BY m DESC LIMIT 0, ' . $settings['nb_recordsMen'] . '');
		
		while ($records	= mysql_fetch_array ($select_records))
		{
			if ($settings['uni50'])
			{
				$records['m'] = 336 * $records['m'];
				$records['c'] = 336 * $records['c'];
				$records['d'] = 336 * $records['d'];
			}
			else
			{
				$records['m'] = 168 * $records['m'];
				$records['c'] = 168 * $records['c'];
				$records['d'] = 168 * $records['d'];
			}
			
			$pseudo	= '[color=' . $settings['couleurPseudos'] . '][size=' . $settings['taillePseudos'] . ']' . $records['pseudo'] . '[/size][/color]';
			$m		= '[color=' . $settings['couleurNiv'] . '][size=' . $settings['taillePseudos'] . ']' . number_format ($records['m'], 0, ',', ' ') . '[/size][/color] ';
			$c		= '[color=' . $settings['couleurNiv'] . '][size=' . $settings['taillePseudos'] . ']' . number_format ($records['c'], 0, ',', ' ') . '[/size][/color] ';
			$d		= '[color=' . $settings['couleurNiv'] . '][size=' . $settings['taillePseudos'] . ']' . number_format ($records['d'], 0, ',', ' ') . '[/size][/color] ';
			
			echo '[*]' . $pseudo . ' : ' . $m . ' - ' . $c . ' - ' . $d . "\n";
		}
		
		echo '[/list]';
	}
	
	if ($settings['center'])
		echo '[/center]';
?></textarea>

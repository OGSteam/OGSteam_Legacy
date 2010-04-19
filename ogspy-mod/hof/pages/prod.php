<?php
	if (isset($_GET['tri']) && $_GET['tri'] == 'c')
		$tri = 'c';
	else if (isset($_GET['tri']) && $_GET['tri'] == 'd')
		$tri = 'd';
	else
		$tri = 'm';
	
	$select_userIDs	= mysql_query('SELECT DISTINCT user_id FROM '. TABLE_USER_BUILDING .'');

	while ($userIDs	= mysql_fetch_array($select_userIDs))
	{
		/* Reinitialisation de la production */
		
		$prodMetal		= 0;
		$prodCristal	= 0;
		$prodDeut		= 0;
		
		$select_users	= mysql_query(
			'SELECT user_id, planet_id, temperature, Sat, M, C, D, CES, CEF, Sat_percentage, M_percentage, C_percentage, D_percentage, CES_percentage, CEF_percentage
			FROM '. TABLE_USER_BUILDING .' WHERE user_id=\''. $userIDs[0] .'\'');
		
		/* Recuperation du pseudo du joueur */
		
		$select_pseudo	= mysql_query('SELECT user_name FROM '. TABLE_USER .' WHERE user_id=\''. $userIDs[0] .'\'');
		$pseudo			= mysql_fetch_array($select_pseudo);
		$pseudo			= $pseudo[0];
		
		/* Récupération de la technologie energie du joueur */
		
		$select_NRJ		= mysql_query('SELECT NRJ FROM '. TABLE_USER_TECHNOLOGY .' WHERE user_id=\''. $userIDs[0] .'\'');
		$NRJ			= mysql_fetch_array($select_NRJ);
		$NRJ			= $NRJ[0];
		
		// Debug ...
		//echo '<pre style=\'text-align : left; font-size : 12px; border : 3px ridge silver;\'>';
		//echo $pseudo .'<br />';
		
		while ($users	= mysql_fetch_array($select_users))
		{
			/* On verifie que ce n'est pas une lune */
			
			if ($users['planet_id'] >= 1 AND $users['planet_id'] <= 9)
			{
				/* ** Facteur de production = Energie produite / Energie nécessaire ** */
				
				/* Energie produite = CES + CEF + Sat */
				
				$cesProd		= ($users['CES_percentage'] / 100) * 20 * $users['CES'] * pow(1.1, $users['CES']);
				$cefProd		= ($users['CEF_percentage'] / 100) * 30 * $users['CEF'] * pow((1.05 + $NRJ * 0.01), $users['CEF']);
				$satProd		= ($users['Sat_percentage'] / 100) * floor(($users['temperature'] / 4) + 20) * $users['Sat'];
				
				$prodEnergie	= floor($cesProd + $cefProd + $satProd);
				
				/* Energie nécessaire = Metal + Cristal + Deut */
				
				$metalConso		= ceil(($users['M_percentage'] / 100) * 10 * $users['M'] * pow (1.1, $users['M']));
				$cristalConso	= ceil(($users['C_percentage'] / 100) * 10 * $users['C'] * pow (1.1, $users['C']));
				$deutConso		= ceil(($users['D_percentage'] / 100) * 20 * $users['D'] * pow (1.1, $users['D']));
				
				$consoEnergie	= floor($metalConso + $cristalConso + $deutConso);
				
				// Facteur de production
				
				if ($consoEnergie == 0)
					$prodFacteur = 1;
				else
					$prodFacteur	= $prodEnergie / $consoEnergie;
				
				if ($prodFacteur > 1)
					$prodFacteur = 1;
				
				/* ** Calcul des production horaire ** */
				
				// Consomation de deut par la CEF				
				$cefConso		= ($users['CEF_percentage'] / 100) * 10 * $users['CEF'] * pow (1.1, $users['CEF']);
				
				$prodMetal		= $prodMetal + 20 + $prodFacteur * floor (($users['M_percentage'] / 100) * (30 * $users['M'] * pow (1.1, $users['M'])));
				$prodCristal	= $prodCristal + 10 + $prodFacteur * floor (($users['C_percentage'] / 100) * (20 * $users['C'] * pow (1.1, $users['C'])));
				$prodDeut		= $prodDeut + $prodFacteur * ($users['D_percentage'] / 100) * (10 * $users['D'] * pow (1.1, $users['D']) * (-0.002 * $users['temperature'] + 1.28)) - $cefConso - 1;
				
				// Debug ...
				//echo '<br />'. $users['planet_id'] .' :';
				//echo "\t" .'Energie affichee : '. ($prodEnergie - $consoEnergie) .' / '. $prodEnergie .'<br />';
				//echo "\t" .'Facteur de prod : '. $prodFacteur .'<br />';
				//echo "\t" .'Metal : '. $prodMetal .' - '. $metalConso .'<br />';
				//echo "\t" .'Cristal : '. $prodCristal .' - '. $cristalConso .'<br />';
				//echo "\t" .'Deut : '. $prodDeut .' - '. $deutConso .'<br />';
			}
		}
		
		// Debug ...
		//echo '</pre>';
			
		/* On verifie si le joueur existe dans la table TABLE_HOF_PROD */
		
		$select_testPseudo	= mysql_query('SELECT * FROM '. TABLE_HOF_PROD .' WHERE pseudo=\''. $pseudo .'\'');
		$testPseudo			= mysql_fetch_array($select_testPseudo);
		
		if (!empty($testPseudo[0])) // Si le joueur existe
		{
			/* On verifie que sa production est superieure a celle deja presente, si oui on met a jour */
			
			if ($prodMetal > $testPseudo['m'])
				mysql_query('UPDATE '. TABLE_HOF_PROD .' SET m=\''. $prodMetal .'\' WHERE pseudo=\''. $pseudo .'\'');
			
			if ($prodCristal > $testPseudo['c'])
				mysql_query('UPDATE '. TABLE_HOF_PROD .' SET c=\''. $prodCristal .'\' WHERE pseudo=\''. $pseudo .'\'');
			
			if ($prodDeut > $testPseudo['d'])
				mysql_query('UPDATE '. TABLE_HOF_PROD .' SET d=\''. $prodDeut .'\' WHERE pseudo=\''. $pseudo .'\'');
		}
		else // Le joueur n'existe pas
		{
			mysql_query('INSERT INTO '. TABLE_HOF_PROD .' VALUES (\''. $pseudo .'\', \''. $prodMetal .'\', \''. $prodCristal .'\', \''. $prodDeut .'\')');
		}
	}
	
	/*
		- Recuperation de la config du mod
	*/
	
	$select_config	= mysql_query('SELECT * FROM '. TABLE_HOF_CONFIG .'');
	$settings		= array();
	
	while ($config	= mysql_fetch_array($select_config))
	{
		$settings[$config['parameter']] = $config['value'];
	}
	
	/*
		- Affichage de la production
	*/
	
	echo '<p class=\'warningProd\'>Si votre production vous semble incorrecte soyez sûr que la température, le nombre de satellites solaires et le niveau de vos centrales sont correct.</p>';
	
	if ($settings['uni50'])
		$facteur = 2;
	else
		$facteur = 1;
	
	if ($settings['prod_heure'])
		afficherProd('heure', $facteur, $tri, $settings['nb_recordsMen']);
	
	if ($settings['prod_jour'])
		afficherProd('jour', $facteur * 24, $tri, $settings['nb_recordsMen']);
	
	if ($settings['prod_semaine'])
		afficherProd('semaine', $facteur * 168, $tri, $settings['nb_recordsMen']);
?>
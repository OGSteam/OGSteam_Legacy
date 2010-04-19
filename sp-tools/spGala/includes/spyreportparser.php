<?php
	if ( !defined('SPGDB_INC') )
		 die('Do not access this file directly.');
		 
	define('HEADER', '/' . SPYREPORT_HEADER . ': ([\x20-\x7e\x81-\xff]+) \(([0-9]+):([0-9]+):([0-9]+)\) ([\x20-\x7e\x81-\xff]+)/');
//	define('HEADER', '/' . SPYREPORT_HEADER . ': (.*) \(([0-9]+):([0-9]+):([0 -9]+)\) (.*)/');
	function parse($exp, $id, $line)
	{
		global $$id;
		switch($id)
		{
			case 'S':
				$spy = preg_match("/".$exp . "+(la guerre|le commerce)/", $line, $matches);
				break;
			default:
				$spy = preg_match_all("/" . $exp . "[ \t]+([0-9]+)/", $line, $matches);
				break;
		}
		
//var_dump($matches, $line); echo "<br />";
		if ($spy)
		{
			switch($id)
			{
				case 'S':
					$$id = trim($matches[1]);
					break;
				default:
					$$id = ( isset($$id) && $$id !== 0 ) ? "," . trim($matches[1][0]) : trim($matches[1][0]);

					if ( isset($matches[1][1]) )
						$$id .= "," . trim($matches[1][1]);

					break;
			}
		}
		else if ( !isset($$id) )
			$$id = 0;

		return $$id;
	}
	
	$fkplayerud = $SESSION['USERID'];
				
	$data = trim(stripslashes($_POST['spyreport']));
	$lines = explode("\n", $data);
	$date = time();
	$info = false;
	$n = count($lines);
	$i = 0;


	$spy = preg_match("/Recherche/", $data);

	if ( $spy )
	{
		while ($i < $n)
		{
			$line = trim($lines[$i]);

			if ( $spy = preg_match(HEADER, $line, $matches) )
			{

//var_dump($matches, $line); echo "<br />";


				$info = true;
				$planet['name'] = $matches[1];
				$planet['x']    = $matches[2];
				$planet['y']    = $matches[3];
				$planet['z']    = $matches[4];
				$player['name'] = $matches[5];

				$player['id'] = $db->first_result(
					"SELECT id
					FROM " . DB_PLAYERS_TABLE . "
					WHERE nick = '{$player['name']}'"
				);

	
				if ( $player['id'] === false )
				{
					$db->query(
						"INSERT INTO " . DB_PLAYERS_TABLE . " (nick, date)
						VALUES ('{$player['name']}', '$date')"
					);
					
					$player['id'] = mysql_insert_id();
				}
			}
			else if ( $info === true && !empty($line) )
			{
				foreach ($BUILDINGS as $id => $exp)
						$$id = parse($exp, $id, $line);
						
				foreach ($SHIPS as $id => $exp)
						$$id = parse($exp, $id, $line);
						
				foreach ($DEFENSES as $id => $exp)
						$$id = parse($exp, $id, $line);

				foreach ($RESEARCHES as $id => $exp)
						$$id = parse($exp, $id, $line);
				
				$S = parse('Specialisation vers ', 'S', $line);
				
			}
			
			$i++;
		}
		
		if ( $info === true )
		{

			switch ($S)
			{
				case '0':
					$class = 0;
					break;
				case 'la guerre':
					$class = 1;
					break;
				case 'le commerce':
					$class = 2;
					break;
			}

			$db->query(
				"UPDATE " . DB_PLAYERS_TABLE . "
				SET class = '$class'
				WHERE id = '{$player['id']}'"
			);

			$spy_date = trim(stripslashes($_POST['date_time']));
		
			if ( preg_match("/([0-9]+)\.([0-9]+)\.([0-9]+) ([0-9]+):([0-9]+):([0-9]+)/", $spy_date, $matches) )
				$spy_date = mktime($matches[4], $matches[5], $matches[6]-$SESSION['TD'], $matches[2], $matches[1], $matches[3]);
			else
				$spy_date = $date;
			
			$planet['x'] = ( $planet['x'] <= 9 ) ? '0' . $planet['x'] : $planet['x'];
			$planet['y'] = ( $planet['y'] <= 9 ) ? '0' . $planet['y'] : $planet['y'];
			$planet['z'] = ( $planet['z'] <= 9 ) ? '0' . $planet['z'] : $planet['z'];			


			$planet['id'] = $db->first_result(
				"SELECT id
				FROM " . DB_PLANETS_TABLE . "
				WHERE name = '{$planet['name']}'"
			);

			$db->query(
				"REPLACE " . DB_PLANETS_TABLE . "
				SET fkplayer = '{$player['id']}',
				name = '{$planet['name']}',
				x = '{$planet['x']}',
				y = '{$planet['y']}',
				z = '{$planet['z']}',
				build00 = '$build00',
				build01 = '$build01',
				build02 = '$build02',
				build03 = '$build03',
				build04 = '$build04',
				build05 = '$build05',
				build06 = '$build06',
				build07 = '$build07',
				build08 = '$build08',
				build09 = '$build09',
				build10 = '$build10',
				build11 = '$build11',
				build12 = '$build12',
				build13 = '$build13',
				ship00 = '$ship00',
				ship01 = '$ship01',
				ship02 = '$ship02',
				ship03 = '$ship03',
				ship04 = '$ship04',
				ship05 = '$ship05',
				ship06 = '$ship06', 
				ship07 = '$ship07',
				ship08 = '$ship08',
				ship09 = '$ship09',
				ship10 = '$ship10',
				ship11 = '$ship11',
				ship12 = '$ship12',
				ship13 = '$ship13',
				ship14 = '$ship14',
				ship15 = '$ship15',
				ship16 = '$ship16',
				ship17 = '$ship17',
				def00 = '$def00',
				def01 = '$def01',
				def02 = '$def02',
				def03 = '$def03',
				def04 = '$def04',
				def05 = '$def05',
				def06 = '$def06',
				def07 = '$def07',
				def08 = '$def08',
				def09 = '$def09',
				date = '$spy_date',
				fkplayerud = '$fkplayerud',
				id = '{$planet['id']}'"
			);


		$db->query(
				"REPLACE " . DB_RESEARCH_TABLE . "
				SET fkplayer = '{$player['id']}', 
				res00 = '$res00',
				res01 = '$res01',
				res02 = '$res02',
				res03 = '$res03',
				res04 = '$res04',
				res05 = '$res05',
				res06 = '$res06',
				res07 = '$res07',
				res08 = '$res08',
				res09 = '$res09',
				res10 = '$res10',
				res11 = '$res11',
				res12 = '$res12',
				res13 = '$res13',
				res14 = '$res14',
				res15 = '$res15',
				res16 = '$res16',
				res17 = '$res17',
				res18 = '$res18',
				res19 = '$res19',
				fkplayerud = '$fkplayerud'"
			);
		}
	}
?>



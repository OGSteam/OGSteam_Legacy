<?php


/**
* Affichage des systèmes solaires obsolètes
*/
function galaxy_obsolete() {
	global $db;
	global $pub_perimeter, $pub_since, $pub_typesearch;

	$obsolete = array();
	if (isset($pub_perimeter) && isset($pub_since) && is_numeric($pub_perimeter) && is_numeric($pub_since)) {
		if (!isset($pub_typesearch) || ($pub_typesearch != "M" && $pub_typesearch != "P")) $pub_typesearch = "P";

		$timestamp = time();
		$pub_since_56 = $timestamp - 60 * 60 * 24 * 56;
		$pub_since_42 = $timestamp - 60 * 60 * 24 * 42;
		$pub_since_28 = $timestamp - 60 * 60 * 24 * 28;
		$pub_since_21 = $timestamp - 60 * 60 * 24 * 21;
		$pub_since_14 = $timestamp - 60 * 60 * 24 * 14;
		$pub_since_7 = $timestamp - 60 * 60 * 24 * 7;

		if ($pub_typesearch == "P") {
			$field = "last_update";
			$row_field = "";
			$moon = 0;
		}
		else {
			$field = "last_update_moon";
			$row_field = ", row";
			$moon = 1;
		}

		switch ($pub_since) {
			case 56 :
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where moon = '".$moon."' and ".$field." < ".$pub_since_56;
			if ($pub_perimeter != 0) $request .= " and galaxy = ".intval($pub_perimeter);
			$request .= " order by galaxy, system, row limit 0, 51";
			$result = $db->sql_query($request);

			while ($row = $db->sql_fetch_assoc($result)) {
				$request = "select min(".$field.") from ".TABLE_UNIVERSE." where galaxy = ".$row["galaxy"]." and system = ".$row["system"];
				$result2 = $db->sql_query($request);
				list($last_update) = $db->sql_fetch_row($result2);
				$row["last_update"] = $last_update;

				$obsolete[56][] = $row;
			}

			case 42 :
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where moon = '".$moon."' and ".$field." between ".$pub_since_56." and ".$pub_since_42;
			if ($pub_perimeter != 0) $request .= " and galaxy = ".intval($pub_perimeter);
			if ($pub_perimeter != 0)
			$request .= " and galaxy = ".intval($pub_perimeter);
			$request .= " order by galaxy, system, row limit 0, 51";
			$result = $db->sql_query($request);

			while ($row = $db->sql_fetch_assoc($result)) {
				$request = "select min(".$field.") from ".TABLE_UNIVERSE." where galaxy = ".$row["galaxy"]." and system = ".$row["system"];
				$result2 = $db->sql_query($request);
				list($last_update) = $db->sql_fetch_row($result2);
				$row["last_update"] = $last_update;

				$obsolete[42][] = $row;
			}

			case 28 :
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where moon = '".$moon."' and ".$field." between ".$pub_since_42." and ".$pub_since_28;
			if ($pub_perimeter != 0) $request .= " and galaxy = ".intval($pub_perimeter);
			$request .= " order by galaxy, system, row limit 0, 51";
			$result = $db->sql_query($request);

			while ($row = $db->sql_fetch_assoc($result)) {
				$request = "select min(".$field.") from ".TABLE_UNIVERSE." where galaxy = ".$row["galaxy"]." and system = ".$row["system"];
				$result2 = $db->sql_query($request);
				list($last_update) = $db->sql_fetch_row($result2);
				$row["last_update"] = $last_update;

				$obsolete[28][] = $row;
			}

			case 21 :
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where moon = '".$moon."' and ".$field." between ".$pub_since_28." and ".$pub_since_21;
			if ($pub_perimeter != 0) $request .= " and galaxy = ".intval($pub_perimeter);
			$request .= " order by galaxy, system, row limit 0, 51";
			$result = $db->sql_query($request);

			while ($row = $db->sql_fetch_assoc($result)) {
				$request = "select min(".$field.") from ".TABLE_UNIVERSE." where galaxy = ".$row["galaxy"]." and system = ".$row["system"];
				$result2 = $db->sql_query($request);
				list($last_update) = $db->sql_fetch_row($result2);
				$row["last_update"] = $last_update;

				$obsolete[21][] = $row;
			}

			case 14 :
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where moon = '".$moon."' and ".$field." between ".$pub_since_21." and ".$pub_since_14;
			if ($pub_perimeter != 0) $request .= " and galaxy = ".intval($pub_perimeter);
			$request .= " order by galaxy, system, row limit 0, 51";
			$result = $db->sql_query($request);

			while ($row = $db->sql_fetch_assoc($result)) {
				$request = "select min(".$field.") from ".TABLE_UNIVERSE." where galaxy = ".$row["galaxy"]." and system = ".$row["system"];
				$result2 = $db->sql_query($request);
				list($last_update) = $db->sql_fetch_row($result2);
				$row["last_update"] = $last_update;

				$obsolete[14][] = $row;
			}

			case 7 :
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where moon = '".$moon."' and ".$field." between ".$pub_since_14." and ".$pub_since_7;
			if ($pub_perimeter != 0) $request .= " and galaxy = ".intval($pub_perimeter);
			$request .= " order by galaxy, system, row limit 0, 51";
			$result = $db->sql_query($request);

			while ($row = $db->sql_fetch_assoc($result)) {
				$request = "select min(".$field.") from ".TABLE_UNIVERSE." where galaxy = ".$row["galaxy"]." and system = ".$row["system"];
				$result2 = $db->sql_query($request);
				list($last_update) = $db->sql_fetch_row($result2);
				$row["last_update"] = $last_update;

				$obsolete[7][] = $row;
			}

			default: return $obsolete;
		}
	}

	return $obsolete;
}


?>
	
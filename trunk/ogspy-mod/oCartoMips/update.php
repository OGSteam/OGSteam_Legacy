<?php


	require_once("common.php");

	global $db;

	$query="UPDATE ".TABLE_MOD." SET version='1.1a' where root='OCartoMips'";
	$db->sql_query($query);
	?>
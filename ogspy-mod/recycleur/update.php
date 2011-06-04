<?php
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db, $table_prefix;

$filename = 'mod/recycleur/version.txt';
if (file_exists($filename)) $file = file($filename);

$security = false;
$security = update_mod('recycleur','Recycleurs');
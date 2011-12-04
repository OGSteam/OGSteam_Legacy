<?php

//table
define("TABLE_PLAYER", $table_prefix . "bigb_player");
define("TABLE_ALLY", $table_prefix . "bigb_ally");
define("TABLE_STORY_PLAYER", $table_prefix . "bigb_story_player");
define("TABLE_STORY_ALLY", $table_prefix . "bigb_story_ally");
define("TABLE_RPP", $table_prefix . "bigb_rank_player_points");
define("TABLE_RPF", $table_prefix . "bigb_rank_player_fleet");
define("TABLE_RPR", $table_prefix . "bigb_rank_player_research");
define("TABLE_UNI", $table_prefix . "bigb_uni");

//chemin
define("MOD_URL", "mod/bigbrother/");
// appel des classes
require_once (MOD_URL . "include/ally.php");
require_once (MOD_URL . "include/player.php");
require_once (MOD_URL . "include/sql.php");
require_once (MOD_URL . "include/system.php");





?>
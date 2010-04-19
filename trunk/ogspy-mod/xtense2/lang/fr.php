<?php

if ($branch == 'admin')
$lang = array(
	// Global strings

	'admin h1' => 'Administration de Xtense',
	'tab infos' => 'Informations',
	'tab group' => 'Autorisations',
	'tab config' => 'Configuration',
	'tab about' => 'A propos',
	'tab log' => 'Journal',
	'tab mods' => 'Mods',
	
	// Tab Informations
	'tb download' => 'Telechargement de la barre',
	'tb download link' => 'Cliquez ici pour récuper les informations sur la dernière barre d\'outils Xtense disponible.',
	'tb download accept' => 'Dernière version disponible : ',
	'tb download error' => 'Impossible de récupérer l\'url de la dernière barre Xtense',
	
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	
	// Tab config
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	
	// Tab authorizations
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	'' => '',
	
	// Tab mod
	
	// Tab log
	
	// Tab about
	
);

if ($branch == 'log') 
// Plugin log locales (xtense.php)
$lang = array(
	'log buildings' => 'envoie les batiments de sa planète $1 ($2)',
	'log overview' => 'envoie les informations de sa planète $1 ($2)',
	'log defense' => 'envoie les defenses de sa planète $1 ($2)',
	'log research' => 'envoie ses recherches',
	'log fleet' => 'envoie la flotte de sa planète $1 ($2)',
	'log system' => 'envoie le système solaire $1',
	'log ranking' => 'envoie le classement $1 des $2 ($3-$4) : $5h', // type1 (ally/player), type2, offsetMin, offsetMax, hour
	'log ranking player' => 'joueurs',
	'log ranking ally' => 'alliances',
	'log ranking points' => 'points',
	'log ranking fleet' => 'flotte',
	'log ranking research' => 'recherches',
	'log ally_list' => 'envoie la liste des membres de l\'alliance $1',
	'log rc' => 'envoie un rapport de combat',
	'log messages' => 'envoie sa page de messages',
	'log messages msg' => 'messages',
	'log messages ally_msg' => '$1 messages d\'alliance',
	'log messages rc_cdr' => '$1 rapports de recyclages',
	'log messages expedition' => '$1 rapports d\'expedition',
	'log messages added_spy' => '$1 rapports d\'espionnage ajoutés : $2', // coords list
	'log messages ignored_spy' => '$1 rapports d\'espionnage ignorés',
	'log messages ennemy_spy' => '$1 espionnages ennemis'
);

if ($branch == 'install') 
// Installation locales (install.php)
$lang = array(
	
);

// COMMON
if (!isset($lang)) $lang = array();

$lang = array_merge($lang, array(
	// Callback Exceptions (class/Callback.php)
	'callback file exists' => 'Le fichier de lien n\'existe pas',
	'callback class exists' => 'La classe "$1" n\'existe pas dans le fichier de lien',
	'callback class abstract' => 'La classe "$1" doit hériter de la classe abstraite "Callback"',
	'callback version' => 'Le mod requiert une version de Xtense plus recente',
	'callback get method' => 'La méthode "$1" n\'existe pas',
	'callback get invalid' => 'Données sur le lien invalides',
	'callback install load' => 'erreur lors du chargement du lien',
	'callback invalid type' => 'Type de lien ($1) invalide', // type

	// Call types names
	'spy' => 'Rapports d\'espionnage',
	'rc_cdr' => 'Rapports de recyclage',
	'msg' => 'Messages de joueurs',
	'ally_msg' => 'Messages d\'alliances',
	'expedition' => 'Rapports d\'expeditions',
	'overview' => 'Vue générale',
	'ennemy_spy' => 'Espionnages ennemis',
	'system' => 'Systèmes solaires',
	'ally_list' => 'Liste des joueurs d\'alliance',
	'buildings' => 'Bâtiments',
	'research' => 'Laboratoire',
	'fleet' => 'Flotte',
	'defense' => 'Défense',
	'rc' => 'Rapports de combat',
	'ranking_player_fleet' => 'Statistiques (flotte) des joueurs',
	'ranking_player_points' => 'Statistiques (points) des joueurs',
	'ranking_player_research' => 'Statistiques (recherches) des joueurs',
	'ranking_ally_fleet' => 'Statistiques (flotte) des alliances',
	'ranking_ally_points' => 'Statistiques (points) des alliances',
	'ranking_ally_research' => 'Statistiques (recherches) des alliances'
));


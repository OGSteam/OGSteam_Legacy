<?php
        define('USER_MATCH', '/^[0-9A-Za-z_. \-]{3,20}$/');
        define('PASS_MATCH', '/^[0-9A-Za-z_.\-]{8,32}$/');
        define('EMAIL_MATCH', '/^[0-9a-z][0-9a-z_.\-]{1,40}[0-9a-z]@[0-9a-z.\-]{3,50}\.[a-z]{2,6}$/');

        define('NO_PERMISSIONS', 'Droits insuffisants pour acc�der � cette section.');

        define('PLAYERS_NUM', 'Nombre de Joueurs');
        define('ALLYS_NUM', 'Nombre d\'Alliances');
        define('PLANETS_NUM', 'Nombre de Plan�tes');
        define('LAST_RANKING_UPD', 'Derni�re mise � jour');
        define('SERVER_TIME', 'Date du Serveur');

        #--== Admin Panel ==--#
        define('MENU', 'Menu');
        define('DB_SETTINGS', 'Configuration de la Base');
        define('ACCOUNT_ADMIN', 'Gestions des Utilisateurs');
        define('DB_STATS', 'Statistiques de la base');
        define('SETTINGS_SAVED', 'Sauvegarder les modifications');
        define('ACCOUNT_DELETED', 'Eliminer un compte');
        #--=================--#

        #--== Account Manager ==--#
        define('LAST_LOGIN', 'Derni�re Visite');
        define('LAST_IP', 'Derni�re Addresse IP');
        define('ACTIVE', 'Actif');
        define('PERMISSIONS', 'Permissions');
        define('PERM_ADMINISTRATION', 'Administration');
        define('PERM_UPDATE_DB', 'Mise � jour de la Base');
        define('PERM_SHOW_MAP', 'Afficher la Carte de la Galaxie');
        define('PERM_SHOW_RANKING', 'Afficher le Classement');
        define('PERM_USE_SEARCH', 'Utiliser la recherche');
        define('PERM_SHOW_STATS', 'Afficher les statistique de joueur');
        #--=================--#

        #--== Database Tables ==--#
        define('DB_CONFIG_TABLE', 'spgdb_config');
        define('DB_PLANETS_TABLE', 'spgdb_planets');
        define('DB_PLAYERS_TABLE', 'spgdb_players');
        define('DB_RESEARCH_TABLE', 'spgdb_res');
        define('DB_SESSIONS_TABLE', 'spgdb_sessions');
        define('DB_STATS_TABLE', 'spgdb_stats');
        define('DB_USERS_TABLE', 'spgdb_users');
        #--=====================--#

        #--== Tables Names ==--#
        define('TABLE_ADMIN', 'Administration');
        define('TABLE_COMPARE', 'Comparer');
        define('TABLE_LOGIN', 'Login');
        define('TABLE_MAP', 'Carte de la Galaxie');
        define('TABLE_PLAYER_INFO', 'Infos sur le joueur');
        define('TABLE_PLAYER_NOTES', 'Note');
        define('TABLE_PLAYER_RESEARCH', 'Recherche');
        define('TABLE_RANKING', 'Classement');
        define('TABLE_REGISTRATION', 'Enregistrement');
        define('TABLE_SEARCH', 'Recherche');
        define('TABLE_SEARCH_RESULT', 'R�sultats');
        define('TABLE_SPYREPORT', 'Rapport d\'espionnage');
        #--==================================--#

        #--== Search Terms ==--#
        define('SEARCH_ALLIANCE', 'Alliance');
        define('SEARCH_AREA', 'Area');
        define('SEARCH_FLEET_POINTS', 'Points de flotte');
        define('SEARCH_NAME', 'Nom');
        define('SEARCH_NO_ALLIANCE', 'Sans alliance');
        define('SEARCH_RANKING_SELECTION', 'Date de la mise � jour du classement');
        define('SEARCH_RESULTS_PER_PAGE', 'R�sultats par page');
        define('SEARCH_STATUS', 'Status');
        define('SEARCH_BETWEEN', 'Entre');
        define('SEARCH_AND', 'et');
        #--=======================--#

        #--== Map Terms ==--#
        define('MAP_ENEMY', 'Joueur Ennemi');
        define('MAP_FRIEND', 'Membres de l\'alliance');
        define('MAP_NO_MEMBER', 'Nom d\'un Joueur');
        define('MAP_STATUS', 'Status de la Carte');
        define('MAP_SYSTEM', 'Syst�me Solaire');
        #--===============--#

        #--== Registration and Login ==--#
        define('LOGIN_INFO_ERROR', 'Erreur de login/pass.');
        define('USER_NAME', 'Utilisateur');
        define('USER_PASSWORD', 'Mot de Passe');
        define('CONFIRM_USER_PASSWORD', 'Confirmer le Mot de Passe');
        define('EMAIL', 'Email');
        define('ACC_CREATED', 'Utilisateur cr�� avec succ�s.');
        define('USER_NOT_VALID', 'Le login doit avoir au minimum 3 caract�res et au maximum 20.<br />Sont admis les caract�res alph-num�riques, espaces, ".", "-" e "_".');
        define('PASSWORD_NOT_VALID', 'Le mot de passe doit avoir au minimum 8 caract�res et au maximum 32.<br />Sont admis les caract�res alph-num�riques, ".", "-" e "_".');
        define('PASSWORD_CHECK_FAILED', 'Les mots de passe ne concordent pas.');
        define('EMAIL_NOT_VALID', 'Adresse email invalide.');
        define('USER_EXISTS', 'Ce nom existe d�j� dans la base.');
        #--=================--#

        #--== Spyreport ==--#
        define('SPYREPORT_HEADER', 'Rapport d\`espionnage');
        define('REPORT_INSERTED', 'Rapport ins�r�.');
        define('REPORT_FAILED', 'Impossible d\'extraire des donn�es de ce rapport.');
        define('PASTE_REPORT_DATE', 'Heure du rapport d\'espionnage');
        define('PASTE_SPY_REPORT', 'Rapport d\'espionnage (1 seul rapport complet)');
        #--===============--#

        #--== Player Class ==--#
        define('CLASS_NONE', 'None');
        define('CLASS_WARRIOR', 'Guerrier');
        define('CLASS_MERCHANT', 'Commer�ant');
        #--==================--#

        #--== Player Status ==--#
        define('STATUS_ACTIVE', 'Actif');
        define('STATUS_BANNED', 'Banni');
        define('STATUS_INACTIVE', 'Inactif');
        define('STATUS_ON_HOLIDAY', 'Mode Vacances');
        define('STATUS_FORCED_HOLIDAY', 'Mode Vacances forc�');
        define('STATUS_INACTIVE_ON_HOLIDAY', 'Mode Vacance Inactif');
        #--===================--#

        #--== Chart Terms ==--#
        define('CHART_TOTAL', 'Totaux');
        define('CHART_BUILD', 'Construction');
        define('CHART_RESEARCH', 'Recherche');
        define('CHART_FLEET_DEFENSE', 'Flotte/D�fense');
        #--=================--#

        #--== DB Stats ==--#
        define('STATS_TABLE', 'Table');
        define('STATS_DATA_SIZE', 'Volum�trie des donn�es');
        define('STATS_INDEX_SIZE', 'Volum�trie des indexes');
        define('STATS_TOTAL_SIZE', 'Volum�trie totale');
        define('STATS_ROWS_NUMBER', 'Nombre de lignes');
        define('STATS_AVERAGE_SIZE_PER_ROW', 'Taille moyenne par ligne');
        define('STATS_DB_TOTAL_SIZE', 'Volum�trie totale de la base');
        #--==============--#

        #--== DB Settings ==--#
        define('SET_ALLIANCE_TAG', 'Tag d\'alliance');
        define('SET_ALLIANCE_NAME', 'Nom d\'alliance');
        define('SET_RANKINGS_PER_DAY', 'Nombre max de mise � jour quotidienne du classement');
        define('SET_MAX_RANKINGS', 'Nombre max de mise � jour du classement');
        #--=================--#

        #--== Compare Terms ==--#
        define('COMP_PLAYER', 'Joueur');
        define('COMP_POINTS', 'Points');
        #--===================--#

        define('FORM_DELETE_ACCOUNT', 'Eliminer \'Utilisateur');
        define('FORM_SUBMIT', 'OK');
        define('FORM_RESET', 'Reset');

        $TABLE_TERMS = array(
                'POSITION'             => 'Pos.',
                'NAME'                 => 'Nom',
                'PREVIOUS_NAME'        => 'Nom precedent',
                'ALLIANCE'             => 'Alliance',
                'CLASS'                => 'Classe',
                'STATUS'               => 'Status',
                'TOTAL_POINTS'         => 'Points Totaux',
                'BUILD_POINTS'         => 'Points Construction',
                'RESEARCH_POINTS'      => 'Points Recherche',
                'FLEET_DEFENSE_POINTS' => 'Points Flotte/D�fense',
                'LAST_UPDATE'          => 'Derni�re mise � jour',
                'PLANET_NAME'          => 'Nom plan�te',
                'PLANET_POSITION'      => 'Position plan�te'
        );

        $PLAYER_CLASS = array(
                '0' => CLASS_NONE,
                '1' => CLASS_WARRIOR,
                '2' => CLASS_MERCHANT
        );

        $PLAYER_STATUS = array(
                '0' => STATUS_ACTIVE,
                '1' => STATUS_BANNED,
                '2' => STATUS_INACTIVE,
                '3' => STATUS_ON_HOLIDAY,
                '4' => STATUS_FORCED_HOLIDAY,
                '5' => STATUS_INACTIVE_ON_HOLIDAY
        );

        $BUILDINGS = array(
                'build00' => 'Mine de m�tal',
                'build01' => 'Mine de cristal',
                'build02' => 'Synth�tiseur de tritium',
                'build03' => 'Centrale �lectrique solaire',
                'build04' => 'Centrale �lectrique G�othermique',
                'build05' => 'Centrale �lectrique �olienne',
                'build06' => 'Chantier naval d`astronef',
                'build07' => 'Research Lab',
                'build08' => 'Universit�',
                'build09' => 'Centre de production',
                'build10' => 'Usine d`andro�des',
                'build11' => 'Complexe industriel',
                'build12' => 'Centre de commerce',
                'build13' => 'Installation de recyclage'
        );

        $SHIPS = array(
                'ship00' => 'Cargo SL-5',
                'ship01' => 'Cargo SL-25',
                'ship02' => 'Cargo SL-250',
                'ship03' => 'Chasseur X320',
                'ship04' => 'Chasseur X382',
                'ship05' => 'Destructeur',
                'ship06' => '�Boucher�',
                'ship07' => 'Croiseur imp�rial',
                'ship08' => 'Navire porteur',
                'ship09' => 'Ravitailleur',
                'ship10' => 'Sonde d`espionnage',
                'ship11' => 'Bourdon de terreur',
                'ship12' => 'Navire de colonisation',
                'ship13' => 'Satellite solaire',
                'ship14' => 'Recycleur',
                'ship15' => 'Megarecycleur',
                'ship16' => 'Navire de colonisation',
                'ship17' => 'Voyageur'
        );

        $DEFENSES = array(
                'def00' => 'Canon antia�rien',
                'def01' => 'Pi�ce d\`artillerie Gattling',
                'def02' => 'Canon laser',
                'def03' => 'Phalange laser',
                'def04' => 'Pi�ce d\'artillerie ionis�e',
                'def05' => 'EMP',
                'def06' => 'Bobine de tesla',
                'def07' => 'lanceur de boules tesla',
                'def08' => 'Petit g�n�rateur de bouclier',
                'def09' => 'Grand g�n�rateur de bouclier'
        );

        $RESEARCHES = array(
                'res00' => 'Technologie d`espionnage',
                'res01' => 'Technologie de navigation',
                'res02' => 'Syst�mes d`armes',
                'res03' => 'Syst�mes bouclier',
                'res04' => 'Recherche des mat�riaux',
                'res05' => 'Syt�mes energ�tiques',
                'res06' => 'Technologie hyperspace',
                'res07' => 'Technologie de r�acteur',
                'res08' => 'Technologie de r�acteur impulse',
                'res09' => 'Propulsion hyperspace',
                'res10' => 'Technologie de laser',
                'res11' => 'Technologie Ionique',
                'res12' => 'Technologie de plasma',
                'res13' => 'Astronomie',
                'res14' => 'Statique',
                'res15' => 'Geologie',
                'res16' => '�cologie',
                'res17' => 'Terraforming',
                'res18' => 'Capteur de trous spatials',
                'res19' => 'Technologie robot'
        );

        $WINDOWS = array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '6' => '6',
                '8' => '8',
                '12' => '12',
                '24' => '24'
        );
?>

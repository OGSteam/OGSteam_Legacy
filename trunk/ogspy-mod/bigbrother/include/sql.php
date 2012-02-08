<?php
if (!defined('IN_SPYOGAME'))
    exit;

class sql
{

    ////// joueur \\\\\\
    private $_insert_player_value;
    private $_insert_historique_value;
    private $_insert_rank_player_points;
    private $_insert_rank_player_fleet;
    private $_insert_rank_player_research;
    ///// fin joueur \\\\\\

    //////ally\\\\
    private $_insert_ally_value;
    private $_insert_historique_value_ally;
    private $_insert_rank_ally_points;
    private $_insert_rank_ally_fleet;
    private $_insert_rank_ally_research;


    // ss \\
    private $_insert_system_solaire_value;
    // a place en fin de end_trans
    private $_simple_requete;


    public function insert_rank_player($requete, $type)
    {
        switch ($type) {
            case 'point':
                $this->_insert_rank_player_points[] = $requete;
                break;
            case 'fleet':
                $this->_insert_rank_player_fleet[] = $requete;
                break;
            case 'research':
                $this->_insert_rank_player_research[] = $requete;
                break;
        }


    }

    public function insert_rank_ally($requete, $type)
    {
        switch ($type) {
            case 'point':
                $this->_insert_rank_ally_points[] = $requete;
                break;
            case 'fleet':
                $this->_insert_rank_ally_fleet[] = $requete;
                break;
            case 'research':
                $this->_insert_rank_ally_research[] = $requete;
                break;
        }


    }


    public function start_transaction()
    {
        //todo faire un appel des cache qu on sauvegarde


    }

    public function insert_simple_requete($requete)
    {
        $this->_simple_requete[] = $requete;

    }


    public function end_transaction()
    {
        global $db;

        if (isset($this->_insert_system_solaire_value)) {
            $requete = "REPLACE INTO " . TABLE_UNI . " ";
            $requete .= " (galaxy, system, row,id_player,datadate) ";
            $requete .= " VALUES ";
            $requete .= implode(',', $this->_insert_system_solaire_value);
            // var_dump ( $requete);
            $db->sql_query($requete);


        }


        $cache_player = false;
        $cache_ally = false;


        /// o ajoute les insert player value
        if (isset($this->_insert_player_value)) {
            $requete = "REPLACE INTO " . TABLE_PLAYER . " ";
            $requete .= " (id, name_player, id_ally,status) ";
            $requete .= " VALUES ";
            $requete .= implode(',', $this->_insert_player_value);
            // var_dump ( $requete);
            $db->sql_query($requete);

            $cache_player = true;
        }


        //insertion d historique

        /// o ajoute les insert player value
        if (isset($this->_insert_historique_value_ally)) {
            $requete = "REPLACE INTO " . TABLE_STORY_ALLY . " ";
            $requete .= " (id_ally, tag, datadate) ";
            $requete .= " VALUES ";
            $requete .= implode(',', $this->_insert_historique_value_ally);
            // var_dump ( $requete);
            $db->sql_query($requete);

            $cache_ally = true;
        }


        /// o ajoute les insert historique value
        if (isset($this->_insert_historique_value)) {
            $requete = "INSERT INTO " . TABLE_STORY_PLAYER . " ";
            $requete .= " (id_player, name_player, id_ally,status,datadate) ";
            $requete .= " VALUES ";
            $requete .= implode(',', $this->_insert_historique_value);
            // var_dump ( $requete);
            $db->sql_query($requete);
            $cache_player = true;
        }


        /// o ajoute les rank
        if (isset($this->_insert_rank_player_points)) {
            $requete = "INSERT INTO " . TABLE_RPP . " ";
            $requete .= " (datadate, rank, player_id) ";
            $requete .= " VALUES ";
            $requete .= implode(',', $this->_insert_rank_player_points);
            // var_dump ( $requete);
            $db->sql_query($requete);
        }

        if (isset($this->_insert_rank_player_fleet)) {
            $requete = "INSERT INTO " . TABLE_RPF . " ";
            $requete .= " (datadate, rank, player_id) ";
            $requete .= " VALUES ";
            $requete .= implode(',', $this->_insert_rank_player_fleet);
            // var_dump ( $requete);
            $db->sql_query($requete);
        }

        if (isset($this->_insert_rank_player_research)) {
            $requete = "INSERT INTO " . TABLE_RPR . " ";
            $requete .= " (datadate, rank, player_id) ";
            $requete .= " VALUES ";
            $requete .= implode(',', $this->_insert_rank_player_research);
            // var_dump ( $requete);
            $db->sql_query($requete);
        }


        /// o ajoute les rank
        if (isset($this->_insert_rank_ally_points)) {
            $requete = "INSERT INTO " . TABLE_RAP . " ";
            $requete .= " (datadate, rank, ally_id) ";
            $requete .= " VALUES ";
            $requete .= implode(',', $this->_insert_rank_ally_points);
            // var_dump ( $requete);
            $db->sql_query($requete);
        }

        if (isset($this->_insert_rank_ally_fleet)) {
            $requete = "INSERT INTO " . TABLE_RAF . " ";
            $requete .= " (datadate, rank, ally_id) ";
            $requete .= " VALUES ";
            $requete .= implode(',', $this->_insert_rank_ally_fleet);
            // var_dump ( $requete);
            $db->sql_query($requete);
        }

        if (isset($this->_insert_rank_ally_research)) {
            $requete = "INSERT INTO " . TABLE_RAR . " ";
            $requete .= " (datadate, rank, ally_id) ";
            $requete .= " VALUES ";
            $requete .= implode(',', $this->_insert_rank_ally_research);
            // var_dump ( $requete);
            $db->sql_query($requete);
        }


        //    var_dump($this->_insert_historique_value);

        if (isset($this->_insert_ally_value)) {
            $requete = "REPLACE INTO " . TABLE_ALLY . " ";
            $requete .= " (id, tag) ";
            $requete .= " VALUES ";
            $requete .= implode(',', $this->_insert_ally_value);
            // var_dump ( $requete);
            $db->sql_query($requete);


            $cache_ally = true;

        }


        // si des modifs sont intervenus, on doit refaire le cache a la fin de la transaction ...
        if ($cache_ally == true) {
            $this->create_cache_ally();
        }


        // si des modifs sont intervenus, on doit refaire le cache a la fin de la transaction ...
        if ($cache_player == true) {
            $this->create_cache_player();
        }

        /// toute les requetes simple ( )
        if (isset($this->_simple_requete)) {
            foreach ($this->_simple_requete as $request) {
                $db->sql_query($request);
            }
        }

    }

    public function insert_player_value($requete)
    {
        $this->_insert_player_value[] = $requete;

    }

    public function insert_historique_value($requete)
    {
        $this->_insert_historique_value[] = $requete;

    }


    public function insert_historique_value_ally($requete)
    {
        $this->_insert_historique_value_ally[] = $requete;

    }


    public function insert_system_solaire_value($requete)
    {
        $this->_insert_system_solaire_value[] = $requete;

    }

    public function insert_ally_value($requete)
    {
        $this->_insert_ally_value[] = $requete;

    }


    public static function find_table_rank_player($type)
    {
        $bdd = null; // on selectionne la bdd
        switch ($type) {
            case 'point':
                $bdd = TABLE_RPP;
                break;
            case 'fleet':
                $bdd = TABLE_RPF;
                break;
            case 'research':
                $bdd = TABLE_RPR;
                break;
        }
        return $bdd;
    }


    public static function find_table_rank_ally($type)
    {
        $bdd = null; // on selectionne la bdd
        switch ($type) {
            case 'point':
                $bdd = TABLE_RAP;
                break;
            case 'fleet':
                $bdd = TABLE_RAF;
                break;
            case 'research':
                $bdd = TABLE_RAR;
                break;
        }
        return $bdd;
    }


    private static function create_cache_player()
    {


        global $db, $table_prefix, $server_config;

        $data = null;
        $result = $db->sql_query("select * from " . TABLE_PLAYER . "");

        while ($row = $db->sql_fetch_assoc($result)) {
            $data[$row['id']] = $row;
        }
        // require_once (MOD_URL . "include/ally.php");
        $fh = @fopen(MOD_URL . 'cache/player.php', 'wb');
        if (!$fh) {            {
                // impossible de creer le cache
                var_dump("impossible pour le cache");
                return false;
            }

        } else {
            fwrite($fh, '<?php' . "\n\n" . ' $temp = ' . var_export($data, true) . ';' . "\n\n" .
                '?>');

            fclose($fh);

        }

        return $data;
    }

    public static function get_all_cache_player()
    {
        $path = MOD_URL . 'cache/player.php';

        if (!file_exists($path)) {
            // on crée le cache et on renvoit les donnée
            $retour = self::create_cache_player();
            return $retour;

        } else { // le cche existe, on l inclus
            try {
                // on tente d inclure le fichier
                include $path;
                return $temp;
                 }
            catch (exception $e) {
                // si erreur on le genere a nouveau
                log_("mod big brother", "get_all_cache_player");
                $retour = self::create_cache_player();
            return $retour;
            }
        }

    }

    private static function create_cache_ally()
    {


        global $db, $table_prefix, $server_config;

        $data = null;
        $result = $db->sql_query("select * from " . TABLE_ALLY . "");

        while ($row = $db->sql_fetch_assoc($result)) {
            $data[$row['id']] = $row;
        }
        // require_once (MOD_URL . "include/ally.php");
        $fh = @fopen(MOD_URL . 'cache/ally.php', 'wb');
        if (!$fh) {            {
                // impossible de creer le cache
                var_dump("impossible pour le cache");
                return false;
            }

        } else {
            fwrite($fh, '<?php' . "\n\n" . ' $temp = ' . var_export($data, true) . ';' . "\n\n" .
                '?>');

            fclose($fh);

        }

        return $data;
    }

    public static function get_all_cache_ally()
    {
        $path = MOD_URL . 'cache/ally.php';

        if (!file_exists($path)) {
            // on crée le cache et on renvoit les donnée
            $retour = self::create_cache_ally();
            return $retour;

        } else { // le cche existe, on l inclus
          try {
                // on tente d inclure le fichier
            include $path;
            return $temp;
                 }
            catch (exception $e) {
                // si erreur on le regenere
                 log_("mod big brother", "get_all_cache_ally");
             $retour = self::create_cache_ally();
            return $retour;
            }

        }

    }


}

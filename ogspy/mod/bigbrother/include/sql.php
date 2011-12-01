<?php

class sql
{

    private $_insert_player_value;
    private $_insert_historique_value;

    public $update;
    public $insertinto;


    public function start_transaction()
    {
        //todo faire un appel des cache qu on sauvegarde


    }


    public function end_transaction()
    {
        global $db;
        $cache_player = false;

        //  $requete = "REPLACE INTO " . TABLE_PLAYER .
        //            "   (id, name_player, id_ally,status)" . " VALUES (" . $this->_id_player . ", '" .
        //            $this->_name_player . "', '" . $this->_id_ally . "',  '" . $this->_status .
        //            "' )";
        //        $db->sql_query($requete);

        //	$db->sql_query('REPLACE INTO '.$table.' ('.$fields.') VALUES '.implode(',', $query));


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


        //   $query = "INSERT INTO " . TABLE_STORY_PLAYER .
        //            " (id_player, name_player, id_ally,status,datadate)" . " VALUES (" . $this->
        //            _id_player . ", '" . $player_name . "', '" . $id_ally . "',  '" . $status .
        //            "',  " . $this->_date . ")";
        //        $db->sql_query($query);


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


        //    var_dump($this->_insert_historique_value);


        // si des modifs sont intervenus, on doit refaire le cache a la fin de la transaction ...
        if ($cache_player == true) {
            create_cache_player();
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


    public static function get_all_player()
    {
        global $db;

        $data = null;

        $requete = "select * from " . TABLE_PLAYER . "  ;";
        $result = $db->sql_query($requete);

        while ($row = $db->sql_fetch_assoc($result)) {
            $data[$row['id']] = $row;
        }
        return $data;
    }


    public static function find_table_rank_player($type)
    {
        $bdd = null; // on selectionne la bdd
        switch ($type) {
            case 'point':
                $bdd = TABLE_RANK_PLAYER_POINTS;
                break;
            case 'fleet':
                $bdd = TABLE_RANK_PLAYER_FLEET;
                break;
            case 'research':
                $bdd = TABLE_RANK_PLAYER_RESEARCH;
                break;
        }
        return $bdd;
    }


    private function create_cache_player()
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

    public function get_all_cache_player()
    {
        $path = MOD_URL . 'cache/player.php';

        if (!file_exists($path)) {
            // on crée le cache et on renvoit les donnée
            $retour = create_cache_player();
            return $retour;

        } else { // le cche existe, on l inclus
            include $path;
            return $temp;
        }

    }


}

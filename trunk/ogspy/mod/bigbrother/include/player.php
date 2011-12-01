<?php
class player
{
    private $_id_player;
    private $_name_player;
    private $_id_ally;
    private $_status = 'x'; // seule variable qui n est pas forcement presente
    private $_date;

    private $_must_update = false;
    private $_must_historique = false;
    private $_requete_historique;


    // constructeur privé
    private function __construct($id_player, $name_player, $id_ally, $status, $date)
    {
        $this->_id_player = $id_player;
        $this->_name_player = $name_player;
        $this->_id_ally = $id_ally;
        $this->_status = $status;
        $this->_date = $date;
    }

    // renvoi le joueur avec les informations provenant d une ligne d un systeme
    public static function get_player_by_system($row, $date)
    {

        // xtense envoi des id nul
        if (!is_numeric($row['ally_id'])) {
            $row['ally_id'] = 0;
        }
        $id_ally = $row['ally_id'];
        $id_player = $row['player_id'];
        $name_player = $row['player_name'];
        $status = $row['status'];
        // on créé l objet
        $instance = new player($id_player, $name_player, $id_ally, $status, $date);
        // routine pour savoir quel update / insert faire
        $instance->save();

        return $instance;
    }

    // renvoi le joueur avec les informations provenant d une ligne d un systeme
    public static function get_player_by_rank($row, $date)
    {
        // xtense envoi des id nul
        if (!is_numeric($row['ally_id'])) {
            $row['ally_id'] = 0;
        }
        $id_ally = $row['ally_id'];
        $id_player = $row['player_id'];
        $name_player = $row['player_name'];
        $status = 'x'; //on ne le connait pas ...
        $instance = new player($id_player, $name_player, $id_ally, $status, $date);
        // routine pour savoir quel update / insert faire
        $instance->save();
        return $instance;
    }


    private function save()
    {
        global $db;
        $requete = "select * from " . TABLE_PLAYER . " WHERE id = " . $this->_id_player .
            " ;";
        $result = $db->sql_query($requete);
        if ($db->sql_numrows($result) == 0) {
            // pas de resultat on ajoute le tout neuf joueur
            $this->_must_update = true;

        } else {
            while ($data = mysql_fetch_array($result)) {
                // update si valeur differente
                if ($this->_name_player != $data['name_player'] || $this->_id_ally != $data['id_ally'] ||
                    ($this->_status != $data['status'] && $this->_status != 'x')) {
                    // explication : ( $this->_status != $data['status'] && $this->_status != 'x')
                    // on cnsidere qu il y a une modif pour statut que si on peut !! si maj par rank c impossible d ou le x

                    $this->_must_update = true;
                    $this->_must_historique = true; // on prépare l update a suivre
                    $this->historique($data['name_player'], $data['id_ally'], $data['status']);

                }

            }
        }
    }


    public function update_rank($type, $rank)
    {
        global $db;
        $bdd = null;
        // on selectionne la bdd
        $bdd = sql::find_table_rank_player($type);

        // mise a jour ( le nom est une securite supp : non necessaire)
        $requete = "UPDATE  " . $bdd . " set   id_player = '" . $this->_id_player .
            "'  WHERE  datadate = '" . $this->_date . "' AND rank = '" . $rank .
            "' AND player = '" . $this->_name_player . "' ";
        $db->sql_query($requete);
        // var_dump($requete);
        // $this->sql->set_insert($requete);


        //datadate 	rank 	player 	ally 	points 	sender_id 	id_player
    }


    // insert  les valeurs du joueur
    public function insert_new_player()
    {
        $retour = "(" . $this->_id_player . ", '" . $this->_name_player . "', '" . $this->
            _id_ally . "',  '" . $this->_status . "' )";

        return $retour;


        //  $requete = "REPLACE INTO " . TABLE_PLAYER .
        //            "   (id, name_player, id_ally,status)" . " VALUES (" . $this->_id_player . ", '" .
        //            $this->_name_player . "', '" . $this->_id_ally . "',  '" . $this->_status .
        //            "' )";
        //        $db->sql_query($requete);


    }

    //update des valeur du joueur
    public function update()
    {

        insert_new_player();

    }

    // mise en historique de ses anciennes valeurs
    private function historique($player_name, $id_ally, $status)
    {
        //              $query = "INSERT INTO " . TABLE_STORY_PLAYER .
        //            " (id_player, name_player, id_ally,status,datadate)" . " VALUES (" . $this->
        //            _id_player . ", '" . $player_name . "', '" . $id_ally . "',  '" . $status .
        //            "',  " . $this->_date . ")";
        //        $db->sql_query($query);
        $this->_requete_historique = "(" . $this->_id_player . ", '" . $player_name .
            "', '" . $id_ally . "',  '" . $status . "',  " . $this->_date . ")";

    }


    public function get_must_update()
    {
        return $this->_must_update;
    }

    public function get_must_historique()
    {
        return $this->_must_historique;
    }

    public function get_requete_historique()
    {
        return $this->_requete_historique;
    }


}

//}



?>
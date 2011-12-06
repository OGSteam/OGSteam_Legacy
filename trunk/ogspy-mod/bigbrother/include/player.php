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
    public static function get_player_by_system($row, $date, $cache)
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
        $instance->save($cache);

        return $instance;
    }

    // renvoi le joueur avec les informations provenant d une ligne d un systeme
    public static function get_player_by_rank($row, $date, $cache)
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
        $instance->save($cache);
        return $instance;
    }


    private function save($cache)
    {
        global $db;

        // var_dump($cache);
        if (!isset($cache['id'])) {
            $this->_must_update = true;
        } else {
            if ($this->_name_player != $cache['name_player'] || $this->_id_ally != $cache['id_ally']) {
                // explication : ( $this->_status != $data['status'] && $this->_status != 'x')
                // on cnsidere qu il y a une modif pour statut que si on peut !! si maj par rank c impossible d ou le x

                $this->_must_update = true;
                $this->_must_historique = true; // on prépare l update a suivre
                $this->historique($cache['name_player'], $cache['id_ally'], $cache['status']);

            } else {
                if ($this->_status != $cache['status'] && $cache['status'] == 'x') {
                    $this->_must_update = true;
                } else
                    if ($this->_status != $cache['status'] && $this->_status == 'x') {

                    } else {
                        if ($this->_status == $cache['status'] && $this->_name_player == $cache['name_player'] && $this->_id_ally == $cache['id_ally']) {
                             $this->_must_update = false;
                        $this->_must_historique = false;
                        }
                        else
                        {
                        
                        $this->_must_update = true;
                        $this->_must_historique = true; // on prépare l update a suivre
                        $this->historique($cache['name_player'], $cache['id_ally'], $cache['status']);
}
                    }


            }


        }


    }


    public function update_rank($type, $rank)
    {


        $retour = "(" . $this->_date . ", '" . $rank . "', '" . $this->_id_player .
            "' )";
        return $retour;

    }


    // insert  les valeurs du joueur
    public function insert_new_player()
    {
        $retour = "(" . $this->_id_player . ", '" . $this->_name_player . "', '" . $this->
            _id_ally . "',  '" . $this->_status . "' )";

        return $retour;


    }

    //update des valeur du joueur
    public function update()
    {

        $this->insert_new_player();

    }

    // mise en historique de ses anciennes valeurs
    private function historique($player_name, $id_ally, $status)
    {

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
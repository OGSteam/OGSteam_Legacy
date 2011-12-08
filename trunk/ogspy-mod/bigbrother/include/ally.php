<?php
if (!defined('IN_SPYOGAME'))
    exit;
class ally
{
    private $_id_ally;
    private $_tag;
    private $_date;

    private $_must_update = false;
    private $_must_historique = false;
    private $_requete_historique;


    // constructeur privי
    private function __construct($id_ally, $tag, $date)
    {
        $this->_id_ally = $id_ally;
        $this->_tag = $tag;
        $this->_date = $date;

    }

    // renvoi le joueur avec les informations provenant d une ligne d un systeme
    public static function get_ally_by_system($row, $date, $cache)
    {

        // xtense envoi des id nul
        if (!is_numeric($row['ally_id'])) {
            $row['ally_id'] = 0;
        }
        $id_ally = $row['ally_id'];
        $tag = $row['ally_tag'];


        // on crיי l objet
        $instance = new ally($id_ally, $tag, $date);
        // routine pour savoir quel update / insert faire
        $instance->save($cache);

        return $instance;
    }

    // renvoi le joueur avec les informations provenant d une ligne d un systeme
    public static function get_ally_by_rank($row, $date, $cache)
    {
        //  xtense envoi des id nul

        $id_ally = $row['ally_id'];
        $tag = $row['ally_tag'];
        // on crיי l objet
        $instance = new ally($id_ally, $tag, $date);
        // routine pour savoir quel update / insert faire
        $instance->save($cache);
        return $instance;
    }


    private function save($cache)
    {
        global $db;


        //// var_dump($cache);
        if (!isset($cache['id'])) {
            $this->_must_update = true;
        } else {
            if ($this->_tag != $cache['tag']) {

                $this->_must_update = true;

                $this->_must_historique = true; // on prיpare l update a suivre
                $this->historique($cache['tag']);

            }
        }


    }


    public function update_rank($type, $rank)
    {

        $retour = "(" . $this->_date . ", '" . $rank . "', '" . $this->_id_ally . "' )";
        return $retour;

    }
    //
    //
    // insert  les valeurs du joueur
    public function insert_new_ally()
    {
        $retour = "(" . $this->_id_ally . ", '" . $this->_tag . "')";

        return $retour;


    }
    //
    //update des valeur du joueur
    public function update()
    {

        $this->insert_new_ally();

    }
    //
    //    // mise en historique de ses anciennes valeurs
    private function historique($tag)
    {

        $this->_requete_historique = "(" . $this->_id_ally . ", '" . $tag . "',  " . $this->
            _date . ")";

    }


    public function get_must_update()
    {
        return $this->_must_update;
    }
    //
    public function get_must_historique()
    {
        return $this->_must_historique;
    }
    //
    public function get_requete_historique()
    {
        return $this->_requete_historique;
    }
    //
    //
    //}
    //
    ////}
    //
    //
    //

}
?>
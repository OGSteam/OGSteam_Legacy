<?php

if (!defined('IN_SPYOGAME'))
    die("Hacking attempt");

global $db, $table_prefix, $user, $xtense_version;
$xtense_version = "2.2";

// fichier commun
require_once ("mod/bigbrother/common.php");


if (class_exists("Callback")) {
    class bigbrother_Callback extends Callback
    {
        public $version = '2.3.9';

        public function getCallbacks()
        {
            return array(array('function' => 'addsystem', 'type' => 'system'), array('function' =>
                'addrankplayerpoints', 'type' => 'ranking_player_points'), array('function' =>
                'addrankplayerflotte', 'type' => 'ranking_player_fleet'), array('function' =>
                'addrankplayersearch', 'type' => 'ranking_player_research'), array('function' =>
                'addrankallypoints', 'type' => 'ranking_ally_points'), array('function' =>
                'addrankallyflotte', 'type' => 'ranking_ally_fleet'), array('function' =>
                'addrankallysearch', 'type' => 'ranking_ally_research'));
        }

        //////////////////////////////////////  SYSTEME \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        public function addsystem($system)
        {
            global $io;
            if (addsystem($system))
                return Io::SUCCESS;
            else
                return Io::ERROR;
        }
        //////////////////////////////////// FIN SYSTEME \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


        ///////////////////////////////////// CLASSEMENT JOUEUR \\\\\\\\\\\\\\\\\\\\\\\\\\\\\

        // POINT \\
        public function addrankplayerpoints($ranking_player_points)
        {
            global $io;
            if (addrankplayerpoints($ranking_player_points))
                return Io::SUCCESS;
            else
                return Io::ERROR;
        }
        // FIN POINT \\

        // FLOTTE \\
        public function addrankplayerflotte($ranking_player_fleet)
        {
            global $io;
            if (addrankplayerflotte($ranking_player_fleet))
                return Io::SUCCESS;
            else
                return Io::ERROR;
        }
        // FIN FLOTTE \\

        // RESEARC \\
        public function addrankplayersearch($ranking_player_research)
        {
            global $io;
            if (addrankplayersearch($ranking_player_research))
                return Io::SUCCESS;
            else
                return Io::ERROR;
        }
        // FIN RESEARCH \\

        //////////////////////////////////// FIN CLASSEMENT JOUEUR\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        ///////////////////////////////////// CLASSEMENT ally \\\\\\\\\\\\\\\\\\\\\\\\\\\\\

        // POINT \\
        public function addrankallypoints($ranking_ally_points)
        {
            global $io;
            if (addrankallypoints($ranking_ally_points))
                return Io::SUCCESS;
            else
                return Io::ERROR;
        }
        // FIN POINT \\

        // FLOTTE \\
        public function addrankallyflotte($ranking_ally_fleet)
        {
            global $io;
            if (addrankallyflotte($ranking_ally_fleet))
                return Io::SUCCESS;
            else
                return Io::ERROR;
        }
        // FIN FLOTTE \\

        // RESEARC \\
        public function addrankallysearch($ranking_ally_research)
        {
            global $io;
            if (addrankallysearch($ranking_ally_research))
                return Io::SUCCESS;
            else
                return Io::ERROR;
        }
        // FIN RESEARCH \\

        //////////////////////////////////// FIN CLASSEMENT ally\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


    }
}


/**
 * addsystem()
 * 
 * @param mixed $system
 * @return true si reussite
 */
function addsystem($system)
{
    global $sql, $user, $db, $table_prefix;
    $sql = new sql();
    $sql->start_transaction();
    $cache = $sql->get_all_cache_player();
    $cache_ally = $sql->get_all_cache_ally();
    $tab_player[] = 0;
    $tab_ally[] = 0;
    $time = time();
    for ($i = 1; $i < 16; $i++) {

        if (isset($system['data'][$i]['player_id']) && is_numeric($system['data'][$i]['player_id'])) {

            if ($system['data'][$i]['ally_id'] != -1) { // on va attendre que grease monkey soit compatible avec id alliance ... comme ca la base sera saine meme si moins complete

                ////////////// PARTIE JOUEUR UPDATE / INSERT JOUEUR : HISTORISATION  \\\\\\\\\\\\\\\\\\\\\\\
                if (!in_array($system['data'][$i]['player_id'], $tab_player)) { // on ne cherche pas si deja mis a jour


                    /// on instancie l objet joueur
                    if (!isset($cache[$system['data'][$i]['player_id']])) {
                        $cache[$system['data'][$i]['player_id']] = null;
                    }
                    $player = player::get_player_by_system($system['data'][$i], $time, $cache[$system['data'][$i]['player_id']]);
                    // o verifie les differents traitements sql a faire
                    if ($player->get_must_update() == true) {
                        $sql->insert_player_value($player->insert_new_player());
                    }
                    if ($player->get_must_historique() == true) {
                        $sql->insert_historique_value($player->get_requete_historique());
                    }
                    // on libere
                    $player = null;
                    // juste pour ne pas traiter 2 fois le meme joueur
                    $tab_player[] = $system['data'][$i]['player_id']; // on sauvegarde les index

                }

                ////////////// FIN JOUEUR UPDATE / INSERT JOUEUR : HISTORISATION  \\\\\\\\\\\\\\\\\\\\\\\

                ////////////// UPDATE UNI AVEC ID JOUEUR ET ALLIANCE  \\\\\\\\\\\\\\\\\\\\\\\\\\\

                $sql->insert_system_solaire_value(system::get_system_by_row($system['data'][$i]['player_id'],
                    $system['data'][$i]['ally_id'], $system['galaxy'], $system['system'], $i, $time));


                ////////////// FIN UPDATE UNI AVEC ID JOUEUR ET ALLIANCE  \\\\\\\\\\\\\\\\\\\\\\\


                //////////// PARTIE ALLIANCE \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
                // if ($system['data'][$i]['ally_id']<1){  // 0  ou -1
                if (!in_array($system['data'][$i]['ally_id'], $tab_ally)) { // on ne cherche pas si deja mis a jour

                    if (!isset($cache_ally[$system['data'][$i]['ally_id']])) {
                        $cache_ally[$system['data'][$i]['ally_id']] = null;
                    }
                    /// on instancie l objet ally
                    $ally = ally::get_ally_by_system($system['data'][$i], $time, $cache_ally[$system['data'][$i]['ally_id']]);

                    // o verifie les differents traitements sql a faire
                    if ($ally->get_must_update() == true) {
                        $sql->insert_ally_value($ally->insert_new_ally());


                    }
                    if ($ally->get_must_historique() == true) {
                        $sql->insert_historique_value_ally($ally->get_requete_historique());
                    }
                    // on libere
                    $ally = null;
                    // juste pour ne pas traiter 2 fois le meme joueur
                    $tab_ally[] = $system['data'][$i]['ally_id']; // on sauvegarde les index

                }


                /////////////////////// fin partie alliance \\\\\\\\\\\\\\\\\\\\\\
            }

        }
        //  }

    }
    $sql->insert_simple_requete(system::get_clean_up_system($system['galaxy'], $system['system'],
        $time));
    $sql->end_transaction();

    return true;

}


// todo voir pour systeme de cache ou de verif prealable pour soulager la base !!!
function abstract_rankplayer($ranking, $type)
{

    $sql = new sql();
    $sql->start_transaction();
    $cache = $sql->get_all_cache_player();

    $times = $ranking['time'];
    //var_dump($ranking_player_points);
    for ($i = 0; $i < 100; $i++) {
        if (isset($ranking['data'][$i])) {
            if ($ranking['data'][$i]['ally_id'] != -1) {
                if (!isset($cache[$ranking['data'][$i]['player_id']])) {
                    $cache[$ranking['data'][$i]['player_id']] = null;
                }
                $rank = $i + $ranking['offset'];
                $player = player::get_player_by_rank($ranking['data'][$i], $times, $cache[$ranking['data'][$i]['player_id']]);
                if ($player->get_must_update() == true) {
                    $sql->insert_player_value($player->insert_new_player());
                }
                if ($player->get_must_historique() == true) {
                    $sql->insert_historique_value($player->get_requete_historique());
                }

                $sql->insert_rank_player($player->update_rank($type, $rank), $type);
                //$player->update_rank($type, $rank);
                $player = null;

            }
        }
    }
    $sql->end_transaction();
    return true;
}

function abstract_rankally($ranking, $type)
{
//var_dump($ranking);
    $sql = new sql();
    $sql->start_transaction();
    $cache = $sql->get_all_cache_ally();

    $times = $ranking['time'];
    //   var_dump($ranking['data'][6]);
    for ($i = 0; $i < 100; $i++) {
        if (isset($ranking['data'][$i])) {
            if ($ranking['data'][$i]['ally_id'] != -1 && $ranking['data'][$i]['ally_id'] !="") {
                if (!isset($cache[$ranking['data'][$i]['ally_id']])) {
                    $cache[$ranking['data'][$i]['ally_id']] = null;
                }

                $rank = $i + $ranking['offset'];
                $ally = ally::get_ally_by_rank($ranking['data'][$i], $times, $cache[$ranking['data'][$i]['ally_id']]);
                if ($ally->get_must_update() == true) {
                    $sql->insert_ally_value($ally->insert_new_ally());


                }
                if ($ally->get_must_historique() == true) {
                    $sql->insert_historique_value_ally($ally->get_requete_historique());
                }

                $sql->insert_rank_ally($ally->update_rank($type, $rank), $type);
                $ally = null;
                //
            }
        }
    }
    $sql->end_transaction();
    return true;
}


function addrankplayerpoints($ranking_player_points)
{
    // var_dump($ranking_player_points);
    return abstract_rankplayer($ranking_player_points, 'point');

}

function addrankplayerflotte($ranking_player_fleet)
{
    return abstract_rankplayer($ranking_player_fleet, 'fleet');

}

function addrankplayersearch($ranking_player_research)
{
    return abstract_rankplayer($ranking_player_research, 'research');

}


function addrankallypoints($ranking_ally_points)
{
    // var_dump($ranking_player_points);
    return abstract_rankally($ranking_ally_points, 'point');

}

function addrankallyflotte($ranking_ally_fleet)
{
    return abstract_rankally($ranking_ally_fleet, 'fleet');

}

function addrankallysearch($ranking_ally_research)
{
    return abstract_rankally($ranking_ally_research, 'research');

}






?>

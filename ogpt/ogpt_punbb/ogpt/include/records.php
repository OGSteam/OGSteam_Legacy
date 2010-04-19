<?php
function pseudo($id)
{

    global $db;


    $sql = 'SELECT user_name FROM   ogspy_user WHERE user_id=\'' . (int)$id . '\'';

    $result = $db->query($sql);

    list($name) = $db->fetch_row($result);

    if ($name == '')
        $name = "??????????";

    return ($name);

}


function Create_HOF($Table_name, $Table_label, $Title, $OGSpy_Table, $NbItems, $Table_icon)
{
    global $db, $pun_config, $Building_Name, $Building_Label, $Building_number, $Flottes_Name,
        $Flottes_Label, $Flottes_icon, $Tech_label;

    /// boucle effacant les données de la table record qui seront réactualisé par la suite
    for ($NoBld = 0; $NoBld <= $NbItems; $NoBld++) {
        $db->query('DELETE FROM mod_fofo_records WHERE nom_record="' . $Table_name[$NoBld] .
            '"') or error('Unable to delete "arcade_showtop" from config table', __file__,
            __line__, $db->error());
        $db->query('DELETE FROM mod_fofo_records WHERE nom_record="max_' . $Table_name[$NoBld] .
            '"') or error('Unable to delete "arcade_showtop" from config table', __file__,
            __line__, $db->error());
    }
    ///mise en place du tableau
    $tableau = '<table border="0" cellpadding="2" cellspacing="0" align="center">';
    $tableau .= '<tr><th colspan="6">' . $Title . '</th></tr> ';
    $tableau .= '<tr><th><b>Nom</b></th><th></th><th><b>Niveau Max</b></th><th><b>Pseudo(s)</b></th><th><b>Cumul Total</b></th><th><b>Pseudo(s)</b></th></tr> ';

    ///nb de requete egale au nb d'item
    for ($NoBld = 0; $NoBld <= $NbItems; $NoBld++) {
        //Requète SQL pour récupérer la valeur Max de chaque type et l'id du joueur
        $sql = "select max($Table_name[$NoBld]) as max , user_id from $OGSpy_Table group by user_id order by max desc limit 1";
        $result = $db->query($sql);
        while ($row = $db->fetch_assoc($result)) {

            $max[$NoBld] = $row['max'];
            /// etablissement du nom et du niveau

            $tableau .= '<tr><td><center><b>' . $Table_label[$NoBld] .
                '</b></center></td><td><center><img src="ogpt/skin/gebaeude/' . $Table_icon[$NoBld] .
                '"></center></td><td>' . convNumber($row['max']) . '</td><td> ';
            $max[$NoBld] = $row['max'];
            /// etablssement du nom du joueur ou des joueur detenteurs du records .....
            $num = 0;
            $sql = 'select  user_id from $OGSpy_Table where "' . $Table_name[$NoBld] .
                '"=$max[$NoBld] group by user_id';
            $result = $db->query($sql);
            while ($noms = $db->fetch_assoc($result)) {
                /// mise en place d'une virgule entre les joueurs
                if ($num != 0) {
                    $tableau .= ' , ';
                }
                //appel nom de joeur(s)
                $tableau .= '' . pseudo($noms['user_id']) . ' ';
                ///envoi du nom dans la base de donnée

                $db->query('INSERT INTO mod_fofo_records (nom_record, id_user) VALUES ("' . $Table_name[$NoBld] .
                    '", "' . $noms['user_id'] . '")') or error('Unable to add records 1 in  table',
                    __file__, __line__, $db->error());

                /// mise en place d'un retour a la ligne tous les X noms
                if ($num == 4) {
                    $tableau .= ' ,<br> ';
                    $num = -1;
                }
                $num = $num + 1;
            }
            $tableau .= '</td>';
            ///recuperation du niveau max des mines cumulé
            $sql2 = "select sum($Table_name[$NoBld]) as sum  ,user_id from $OGSpy_Table  group by user_id order by sum desc limit 1";
            $result2 = $db->query($sql2);
            while ($sum = $db->fetch_assoc($result2)) {
                $tableau .= '<td>' . convNumber($sum['sum']) . '</td><td>' . pseudo($sum['user_id']) .
                    '</td>';

                /// envoidu max record dans la base de donnée
                $db->query('INSERT INTO mod_fofo_records (nom_record, id_user) VALUES ("max_' .
                    $Table_name[$NoBld] . '", "' . $sum['user_id'] . '")') or error('Unable to add records 2 in  table',
                    __file__, __line__, $db->error());


            }

            $tableau .= '</tr> ';


        }
    }
    /// fin du tableau
    $tableau .= '</table>';

    return $tableau;
}


function Create_Div($Table_name, $Table_label, $Title, $OGSpy_Table, $NbItems, $Table_where)
{
    global $db;

    /// boucle effacant les données de la table record qui seront réactualisé par la suite
    for ($NoBld = 0; $NoBld <= $NbItems; $NoBld++) {
        $db->query('DELETE FROM mod_fofo_records WHERE nom_record="' . $Table_name[$NoBld] .
            '"') or error('Unable to delete "arcade_showtop" from config table', __file__,
            __line__, $db->error());
        $db->query('DELETE FROM mod_fofo_records WHERE nom_record="max_' . $Table_name[$NoBld] .
            '"') or error('Unable to delete "arcade_showtop" from config table', __file__,
            __line__, $db->error());
    }
    ///mise en place du tableau
    $tableau = '<table border="0" cellpadding="2" cellspacing="0" align="center">';
    $tableau .= '<tr><th colspan="5">' . $Title . '</th></tr> ';
    $tableau .= '<tr><th><b>Nom</b></th><th><b>Niveau Max</b></th><th><b>Pseudo(s)</b></th><th><b>Cumul Total</b></th><th><b>Pseudo(s)</b></th></tr> ';

    ///nb de requete egale au nb d'item
    for ($NoBld = 0; $NoBld <= $NbItems; $NoBld++) {
        //Requète SQL pour récupérer la valeur Max de chaque type et l'id du joueur
        $sql = "select max($Table_name[$NoBld]) as max , user_id from $OGSpy_Table where group by user_id order by max desc limit 1";
        $result = $db->query($sql);
        while ($row = $db->fetch_assoc($result)) {

            $max[$NoBld] = $row['max'];
            /// etablissement du nom et du niveau

            $tableau .= '<tr><th>' . $Table_label[$NoBld] . '</th><td>' . convNumber($row['max']) .
                '</td><td> ';
            $max[$NoBld] = $row['max'];
            /// etablssement du nom du joueur ou des joueur detenteurs du records .....
            $num = 0;
            $sql = 'select  user_id from $OGSpy_Table where "' . $Table_name[$NoBld] .
                '"=$max[$NoBld] group by user_id';
            $result = $db->query($sql);
            while ($noms = $db->fetch_assoc($result)) {
                /// mise en place d'une virgule entre les joueurs
                if ($num != 0) {
                    $tableau .= ' , ';
                }
                //appel nom de joeur(s)
                $tableau .= '' . pseudo($noms['user_id']) . ' ';
                ///envoi du nom dans la base de donnée
                $db->query('INSERT INTO mod_fofo_records (nom_record, id_user) VALUES ("' . $Table_name[$NoBld] .
                    '", "' . $noms['user_id'] . '")') or error('Unable to add records 3 in  table',
                    __file__, __line__, $db->error());

                /// mise en place d'un retour a la ligne tous les X noms
                if ($num == 4) {
                    $tableau .= ' ,<br> ';
                    $num = -1;
                }
                $num = $num + 1;
            }
            $tableau .= '</td>';
            ///recuperation du niveau max des mines cumulé
            $sql2 = "select sum($Table_name[$NoBld]) as sum  ,user_id from $OGSpy_Table  where $Table_where[$NoBld] group by user_id order by sum desc limit 1";
            $result2 = $db->query($sql2);
            while ($sum = $db->fetch_assoc($result2)) {
                $tableau .= '<td>' . convNumber($sum['sum']) . '</td><td>' . pseudo($sum['user_id']) .
                    '</td>';

                /// envoidu max record dans la base de donnée
                $db->query('INSERT INTO mod_fofo_records (nom_record, id_user) VALUES ("max_' .
                    $Table_name[$NoBld] . '", "' . $sum['user_id'] . '")') or error('Unable to add 4 records in  table',
                    __file__, __line__, $db->error());


            }

            $tableau .= '</tr> ';


        }
    }
    /// fin du tableau
    $tableau .= '</table>';

    return $tableau;
}


function Create_game($Table_name, $Table_label, $Title, $OGSpy_Table, $NbItems)
{
    global $db;

    /// boucle effacant les données de la table record qui seront réactualisé par la suite
    for ($NoBld = 0; $NoBld <= $NbItems; $NoBld++) {
        $db->query('DELETE FROM mod_fofo_records WHERE nom_record="' . $Table_name[$NoBld] .
            '"') or error('Unable to delete "arcade_showtop" from config table', __file__,
            __line__, $db->error());
        $db->query('DELETE FROM mod_fofo_records WHERE nom_record="max_' . $Table_name[$NoBld] .
            '"') or error('Unable to delete "arcade_showtop" from config table', __file__,
            __line__, $db->error());
    }
    ///mise en place du tableau
    $tableau = '<table border="0" cellpadding="2" cellspacing="0" align="center">';
    $tableau .= '<tr><th colspan="6">' . $Title . '</th></tr> ';
    $tableau .= '<tr><th><b>Nom</b></th><th><b>Niveau Max</b></th><th><b>Pseudo(s)</b></th><th><b>Cumul Total</b></th><th><b>Pseudo(s)</b></th></tr> ';

    ///nb de requete egale au nb d'item
    for ($NoBld = 0; $NoBld <= $NbItems; $NoBld++) {
        //Requète SQL pour récupérer la valeur Max de chaque type et l'id du joueur
        $sql = "select max($Table_name[$NoBld]) as max , sender from $OGSpy_Table group by sender order by max desc limit 1";
        $result = $db->query($sql);
        while ($row = $db->fetch_assoc($result)) {

            $max[$NoBld] = $row['max'];
            /// etablissement du nom et du niveau

            $tableau .= '<tr><td><center><b>' . $Table_label[$NoBld] .
                '</b></center></td><td>' . convNumber($row['max']) . '</td><td> ';
            $max[$NoBld] = $row['max'];
            /// etablssement du nom du joueur ou des joueur detenteurs du records .....
            $num = 0;
            $sql = 'select  user_id from $OGSpy_Table where "' . $Table_name[$NoBld] .
                '"=$max[$NoBld] group by user_id';
            $result = $db->query($sql);
            while ($noms = $db->fetch_assoc($result)) {
                /// mise en place d'une virgule entre les joueurs
                if ($num != 0) {
                    $tableau .= ' , ';
                }
                //appel nom de joeur(s)
                $tableau .= '' . pseudo($noms['sender']) . ' ';
                ///envoi du nom dans la base de donnée
                $db->query('INSERT INTO mod_fofo_records (nom_record, id_user) VALUES ("' . $Table_name[$NoBld] .
                    '", "' . $noms['sender'] . '")') or error('Unable to add records in  table',
                    __file__, __line__, $db->error());

                /// mise en place d'un retour a la ligne tous les X noms
                if ($num == 4) {
                    $tableau .= ' ,<br> ';
                    $num = -1;
                }
                $num = $num + 1;
            }
            $tableau .= '</td>';
            ///recuperation du niveau max des mines cumulé
            $sql2 = "select sum($Table_name[$NoBld]) as sum  ,sender from $OGSpy_Table  group by sender order by sum desc limit 1";
            $result2 = $db->query($sql2);
            while ($sum = $db->fetch_assoc($result2)) {
                $tableau .= '<td>' . convNumber($sum['sum']) . '</td><td>' . pseudo($sum['sender']) .
                    '</td>';

                /// envoidu max record dans la base de donnée
                $db->query('INSERT INTO mod_fofo_records (nom_record, id_user) VALUES ("max_' .
                    $Table_name[$NoBld] . '", "' . $sum['sender'] . '")') or error('Unable to add records in  table',
                    __file__, __line__, $db->error());


            }

            $tableau .= '</tr> ';


        }
    }
    /// fin du tableau
    $tableau .= '</table>';

    return $tableau;
}

?>
<?php
if (!defined('IN_SPYOGAME'))
    die("Hacking attempt");
    
 $id = $db->sql_escape_string($pub_id);
 $first_date= $server_config['bigbrother'];
if ( is_numeric($id)){
    
  //  Colonne 	Type 	Interclassement 	Attributs 	Null 	Défaut 	Extra 	Action
//	id_player 	int(7) 			Non 	Aucun 		Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
//	name_player 	varchar(30) 	latin1_swedish_ci 		Non 	Aucun 		Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
//	id_ally 	int(7) 			Oui 	NULL 		Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
//	status 	varchar(6) 	latin1_swedish_ci 		Oui 	NULL 		Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
//	datadate 	int(11) 			Non 	0 		Affiche les valeurs distinctes 	Modifier 	Supprimer 	Primaire 	Unique 	Index 	Texte entier
//    
//    
    
    
   
     
     
        $requete = "select * from " . TABLE_PLAYER . "";
        $requete .= " where id = '" . $id . "' ";
                


            $affichage .= '<br /><table>';
            $affichage .= '<tr>';
            $affichage .=  '<td colspan="3" class="c">Actuellement</td>';
            $affichage .=  '	</tr>';
            $affichage .= '<tr>';
             $affichage .=  '<td width="100" class="c">name_player</td>';
             $affichage .=  '<td width="100" class="c">status</td>';
             $affichage .=  '<td width="100" class="c">alliance</td>';
            $affichage .=  '	</tr>';

            $result = $db->sql_query($requete);


            while ($row = $db->sql_fetch_assoc($result)) {
                $affichage .=  '<tr>';
                 $affichage .=  '<td class="b">' . $row['name_player'] . '</td>';
                 $affichage .=  '<td class="b">' . convert_status($row['status']) . '</td>';
                 $affichage .=  '<td class="b">' . convert_ally($row['id_ally']) . '</td>';
                $affichage .=  '</tr>';


            }
            $affichage .=  '</table>';
    
     
     
     
     
     
       $requete = "select * from " . TABLE_STORY_PLAYER . "";
       $requete .= " where id_player = '" . $id . "' ";


            $affichage .= '<br /><table>';
             $affichage .= '<tr>';
            $affichage .=  '<td colspan="4" class="c">Historique du joueur</td>';
            $affichage .=  '	</tr>';
            $affichage .= '<tr>';
            $affichage .=  '<td width="150" class="c">jusqu \'au</td>';
            $affichage .=  '<td width="100" class="c">Nom</td>';
            $affichage .=  '<td width="100" class="c">status</td>';
            $affichage .=  '<td width="100" class="c">alliance</td>';

            $affichage .=  '	</tr>';

            $result = $db->sql_query($requete);


            while ($row = $db->sql_fetch_assoc($result)) {
                $affichage .=  '<tr>';
                $affichage .=  '<td  class="b">' . strftime("%d %b %Y %H:%M:%S", $row['datadate']) . '</td>';
                $affichage .=  '<td  class="b">' . $row['name_player'] . '</td>';
                $affichage .=  '<td  class="b">' . convert_status($row['status']) . '</td>';
                $affichage .=  '<td  class="b">' .  convert_ally($row['id_ally']) . '</td>';
                $affichage .=  '	</tr>';


            }
            $affichage .=  '</table>';
    
    
    
    
    
    echo $affichage ;
    
    
    
    
    
    
    
    
    
    
}

?>

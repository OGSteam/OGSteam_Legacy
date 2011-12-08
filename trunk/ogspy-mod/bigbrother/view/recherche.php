<?php
if (!defined('IN_SPYOGAME'))
    die("Hacking attempt");


if (isset($pub_recherche) && $pub_string_search != "") {
    $type = $db->sql_escape_string($pub_type_search);
    $temps = $db->sql_escape_string($pub_temps);
    $string = $db->sql_escape_string($pub_string_search);

    if ($pub_type_search == 'ally') {
      
          if ($temps == 'now') {
              // liste ally  actuelle
                $requete = "select id ,	tag from " . TABLE_ALLY . "";
            $requete .= " where tag like '%" . $string . "%' ";


            $affichage = '<br /><table>';
            $affichage .= '<tr>';
            $affichage .= '<td width="200" class="c">tag</td>';
            $affichage .= '<td width="50" class="c">Id</td>';
            $affichage .= '	</tr>';

            $result = $db->sql_query($requete);


            while ($row = $db->sql_fetch_assoc($result)) {
                $affichage .= '<tr>';
                $affichage .= '<td width="200" class="b"><a href="index.php?action=bigbrother&subaction=ally&id=' .
                    $row['id'] . '">' . $row['tag'] . '</a></td>';
                $affichage .= '<td width="50" class="b">' . $row['id'] . '</td>';
                $affichage .= '	</tr>';


            }
            $affichage .= '</table>';



            
            
            }
            else
            {
              
              // liste ally  actuelle
                $requete = "select id_ally ,	tag from " . TABLE_STORY_ALLY . "";
            $requete .= " where tag like '%" . $string . "%' ";


            $affichage = '<br /><table>';
            $affichage .= '<tr>';
            $affichage .= '<td width="200" class="c">tag</td>';
            $affichage .= '<td width="50" class="c">Id</td>';
            $affichage .= '	</tr>';

            $result = $db->sql_query($requete);


            while ($row = $db->sql_fetch_assoc($result)) {
                $affichage .= '<tr>';
                $affichage .= '<td width="200" class="b"><a href="index.php?action=bigbrother&subaction=ally&id=' .
                    $row['id'] . '">' . $row['tag'] . '</a></td>';
                $affichage .= '<td width="50" class="b">' . $row['id_ally'] . '</td>';
                $affichage .= '	</tr>';


            }
            $affichage .= '</table>';



            
              
            }

















    } else {
        if ($temps == 'now') {
            // liste joueur actuelle
            $requete = "select id ,	name_player from " . TABLE_PLAYER . "";
            $requete .= " where name_player like '%" . $string . "%' ";


            $affichage = '<br /><table>';
            $affichage .= '<tr>';
            $affichage .= '<td width="200" class="c">Nom</td>';
            $affichage .= '<td width="50" class="c">Id</td>';
            $affichage .= '	</tr>';

            $result = $db->sql_query($requete);


            while ($row = $db->sql_fetch_assoc($result)) {
                $affichage .= '<tr>';
                $affichage .= '<td width="200" class="b"><a href="index.php?action=bigbrother&subaction=player&id=' .
                    $row['id'] . '">' . $row['name_player'] . '</a></td>';
                $affichage .= '<td width="50" class="b">' . $row['id'] . '</td>';
                $affichage .= '	</tr>';


            }
            $affichage .= '</table>';

        } else {
            //  liste joueur de tous les temps
            // liste joueur actuelle
            $requete = "select id_player ,	name_player from " . TABLE_STORY_PLAYER . "";
            $requete .= " where name_player like '%" . $string . "%' ";


            $affichage = '<br /><table>';
            $affichage .= '<tr>';
            $affichage .= '<td width="200" class="c">Nom</td>';
            $affichage .= '<td width="50" class="c">Id</td>';
            $affichage .= '	</tr>';

            $result = $db->sql_query($requete);


            while ($row = $db->sql_fetch_assoc($result)) {
                $affichage .= '<tr>';
                $affichage .= '<td width="200" class="b"><a href="index.php?action=bigbrother&subaction=player&id=' .
                    $row['id'] . '">' . $row['name_player'] . '</a></td>';
                $affichage .= '<td width="50" class="b">' . $row['id_player'] . '</td>';
                $affichage .= '	</tr>';


            }
            $affichage .= '</table>';


        }


    }


}



?>
		<table width="60%">
		<form action="index.php?action=bigbrother&subaction=recherche" method="POST">
        <input type="hidden" value="bigbrother" name="recherche">
		<tbody><tr>
			<td colspan="4" class="c">Recherche</td>
		</tr>
		<tr>
			<th><input type="radio" <?php if ($pub_type_search == 'player'){echo 'checked';}?> value="player" name="type_search"></th>
			<th>Joueur</th>
			<th rowspan="2"><input type="text" value="<?php echo $string; ?>" size="25" maxlength="25" name="string_search"></th>
            <th rowspan="2">
                <select name="temps">
            		<option value="now" <?php if ($temps == 'now'){echo 'SELECTED ';}?> >actuellement</option>
                    <option value="story" <?php if ($temps == 'story'){echo 'SELECTED ';}?> >historique</option>
                </select>
            </th>
            
		</tr>
		<tr>
			<th><input type="radio" <?php if ($pub_type_search == 'ally'){echo 'checked';}?> value="ally" name="type_search"></th>
			<th>Alliance</th>
		</tr>
		
		<tr>
			<th colspan="4"><input type="submit" value="Chercher"></th>
		</tr>
			</form>
		</tbody></table>


<?php

echo $affichage;




?>
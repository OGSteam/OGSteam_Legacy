<?php
if(!defined("IN_SPYOGAME") && !defined("IN_XTENSE")) die("Hacking Attemp!");

function player_update($v, $id_ally_){

	global $sql, $user;
	
	if($v['player_id'] > 0)
	{
		//verifier si id_player existe, 
		$name_player_exist = $sql->query('SELECT name_player FROM '.TABLE_PLAYER.' WHERE id_player = "'.$v['player_id'].'" LIMIT 1');
		if(mysql_num_rows($name_player_exist)>0)
		{
			//si oui verifier si id_player a le meme name dans la table player
			$name_player_ok = $sql->query('SELECT name_player FROM '.TABLE_PLAYER.' WHERE id_player = "'.$v['player_id'].'" and name_player = "'.quote($v['player_name']).'"    LIMIT 1');
			if(mysql_num_rows($name_player_ok)<1)
			{
				//si non rajouter une ligne dans la table history id_player, id_ally, name_ally, ancien name player,  et en date il faut trouver la derniere fois que ce player avait ce nom
				list($name_player)=mysql_fetch_row($name_player_exist);
				$sql->query( 'REPLACE INTO '.TABLE_HISTORY.' ( id_player, id_ally, name_player, name_ally, datadate  ) 
				VALUES ("'.quote($v['player_id']).'" , "'.$id_ally_.'" , "'.$name_player.'" ,  "'.quote($v['ally_tag']).'" , "'.time().'") ');
											
				//mettre à jour la table player avec le nouveau name  
				$sql->query( 'UPDATE '.TABLE_PLAYER.' SET name_player = "'.quote($v['player_name']).'" WHERE id_player =  "'.quote($v['player_id']).'" ');
			}
		}
		else
		{
			//si non, on l'ajoute avec id_player ingame, et on le rattache à la bonne ally
			$sql->query('REPLACE INTO '.TABLE_PLAYER.'( id_player, name_player, id_ally  ) VALUES ( "'.$v['player_id'].'", "'.quote($v['player_name']).'", "'.$id_ally_.'"   ) ');
		}
	}
}

function ally_update($v){
	
	global $sql,$user;
	if( $v['ally_id'] != 0)
	{
		if( $v['ally_id'] > 0)
		{
			$name_ally_exist = $sql->query("SELECT name_ally FROM ".TABLE_ALLY." WHERE id_ally = '".$v['ally_id']."' LIMIT 1");
			if(mysql_num_rows($name_ally_exist)>0 )
			{
				//si oui, on verifie son name
				$name_ally_ok = $sql->check("SELECT id_ally FROM ".TABLE_ALLY." WHERE id_ally = '".$v['ally_id']."' and name_ally = '".quote($v['ally_tag'])."'    LIMIT 1");
				if(!$name_ally_ok)
				{
					//si name different, on rajoute une ligne dans la table history, id_player, id_ally, name_player, ancien nom de l'ally, et en date il faut trouver la derniere fois que cette ally avait ce nom
					list($name_ally)= mysql_fetch_row($name_ally_exist);
					$sql->query( 'REPLACE INTO '.TABLE_HISTORY.' ( id_player, id_ally, name_player, name_ally, datadate  ) 
					VALUES ("-'.$v['player_id'].'" , "'.$v['ally_id'].'" , "'.quote($v['player_name']).'" , "'.$name_ally.'" , "'.time().'") ');
					
					//puis on modifie le name dans table ally
					$sql->query( "UPDATE ".TABLE_ALLY." SET name_ally = '".quote($v['ally_tag'])."' WHERE id_ally =  '".$v['ally_id']."' ");
				}
			}
			//si il n'y a pas d' ally
			else
			{
				$sql->query("REPLACE INTO ".TABLE_ALLY."( id_ally, name_ally  ) VALUES ( '".$v['ally_id']."', '".quote($v['ally_tag'])."' )");
			}
		}
		else
		{
			//si l'ally n'est pas renseigné dans le profil, on l'ajoute, avec lid user ogspy negatif
			if(strlen($user["ally_stat_name"]) == 0)
			{
				$sql->query("update ".TABLE_USER." set ally_stat_name = '".$v['ally_tag']."' where user_id = '".$user['id']."'");
				$sql->query("REPLACE INTO ".TABLE_ALLY."( id_ally, name_ally  ) VALUES ( '-".$user['id']."', '".quote($v['ally_tag'])."' )");
			}
			//id ally negatif
			//si le name != le name ally user profil
			if($v['ally_tag'] != $user["ally_stat_name"])
			{
				//ally trouver est different de ogs
				//verifier si l'ally a changé de nom ou si l'user à changé d'ally
				//d'abord regarder si le name de l'ally trouver existe ailleurs
				$name_ally_exist = $sql->query("SELECT id_ally, name_ally FROM ".TABLE_ALLY." WHERE name_ally = '".$v['ally_tag']."' LIMIT 1");
				if(mysql_num_rows($name_ally_exist)>0 )
				{
					//si oui,  veur dire le user a changé d'ally, ajouter une ligne hostoric
					list($id_ally)= mysql_fetch_row($sql->query("SELECT id_ally from ".TABLE_ALLY." WHERE name_ally = '".quote($user["ally_stat_name"])."' "));
				}
				else
				{
					//si non, ally de user a changé de nom
					//ajouter une ligne hostoric
					list($id_ally)= mysql_fetch_row($sql->query("SELECT id_ally from ".TABLE_ALLY." WHERE name_ally = '".$v['ally_tag']."' "));
				}
				$sql->query( 'REPLACE INTO '.TABLE_HISTORY.' ( id_player, id_ally, name_player, name_ally, datadate  ) 
				VALUES ("-'.$user['id'].'" , "'.$id_ally.'" , "'.quote($v['player_name']).'" , "'.quote($user["ally_stat_name"]).'" , "'.time().'") ');
				
				//puis changer l'ally dans le profil
				$request = "update ".TABLE_USER." set ally_stat_name = '".$v['ally_tag']."' where user_id = '".$user['id']."'";
				$sql->query($request);
			}
		}
	}
	//si une alliance est cree, on retourne son id
	return $v['ally_id'];
	//pour l'instant une ally d'un joueur d'ogspy peut avoir deux id
}

?>
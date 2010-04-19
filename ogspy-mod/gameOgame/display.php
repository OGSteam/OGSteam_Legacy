<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');
$query = 'SELECT active FROM '.TABLE_MOD.' WHERE action=\'gameOgame\' AND active=\'1\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) die('Hacking attempt');

// Définition de la liste des joueurs à afficher
if ((!isset($pub_player) || $pub_player=='') && (!isset($pub_memberslist))) 
{
	$pub_memberslist[0] = $user_data['user_name'];
}
elseif ((isset($pub_player)) && (!isset($pub_memberslist)))
{
	$pub_memberslist[0] = $pub_player;
}
if (!isset($pub_mix)) $pub_mix = "yes";
if (!isset($pub_order)) $pub_order = "date";
if (!isset($pub_sort)) $pub_sort ="down";
if ((!isset($pub_page)) || ($pub_page < 1)) $pub_page = 1;

?>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
// Permet de sélectionner tout les joueurs
function checkAll()
{
// "userlist" est l'id du form 
var x=document.getElementById("userlist");
// On cycle dans les éléments du form et quand on trouve un 'checkbox' on le valide
for (var i=0;i<x.length;i++)
  {
  if (x.elements[i].type == "checkbox")
     {
         x.elements[i].checked = true;
     }
  }
}
// fonction inverse - Déselectionne tout les joueurs
function uncheckAll()
{
var x=document.getElementById("userlist");
for (var i=0;i<x.length;i++)
  {
  if (x.elements[i].type == "checkbox")
     {
         x.elements[i].checked = false;
     }
  }
}
//  End -->
</script>
<?php
$query = "SELECT DISTINCT id FROM `".TABLE_GAME_USERS."` WHERE `user`='1' ORDER BY id";
$result = $db->sql_query($query);
$i = 0;
$j = 6; // nombres de joueurs par ligne du tableau
echo 'Afficher les rapports de :';
echo '<form id=\'userlist\' method=\'post\' action=\'?action=gameOgame&subaction=display\'>';
echo '<table width=\'100%\'>';
echo '<tr>';
while ($id = $db->sql_fetch_row($result))
{
	echo '<td class=\'c\' width=\'3%\' align=\'center\'><input type=\'checkbox\' value=\''.userNameById($id["0"]).'\' name=\'memberslist[]\' id=\''.$id["0"].'\'';
	if (count($pub_memberslist)!=0)
				echo (array_search(userNameById($id["0"]),$pub_memberslist)!==false?" checked ":"");
	echo ' ></td>';
	echo '<td class=\'c\' width=\''.(80/$j).'%\'\' >'.userNameById($id["0"]).'</td>';
	$i += 1;
	if ($i == $j)
	{
		echo '</tr><tr>';
		$i = 0;
	}
}
// ferme le tableau, ca sert à rien mais c'est plus beau :-)
if ($i >0 &&  $i != $j)
{
	for ( ;$i<$j; $i++)
	{
		echo '<td class=\'c\' width=\'3%\' align=\'center\'>&nbsp</td>';
		echo '<td class=\'c\' width=\''.(80/$j).'%\'>&nbsp;</td>';
	}
	echo '</tr>';
}
else 
{
	echo '</tr>';
}

// Bouton CheckAll et UnCheckAll
echo "\t<tr>\n";
echo "\t\t<th colspan='".$j."'><input type='button' name='CheckAll' value='Tous' onClick='checkAll()'>\n";
echo "\t\t</th>\n";
echo "\t\t<th colspan='".$j."'><input type='button' name='UnCheckAll' value='Aucun' onClick='uncheckAll()'>\n";
echo "\t\t</th>\n";
echo "\t</tr>\n";
// Radio boutons mixe/separe
echo "\t<tr>\n";
echo "\t\t<th colspan='".$j."' style='text-align: right;')> R&eacute;sultat s&eacute;par&eacute; <input type='radio' name='mix' value='yes' ".((!isset($pub_mix) || $pub_mix == 'yes')?" checked ":"");
echo "></th>\n";
echo "\t\t<th colspan='".$j."' style='text-align: left;'><input type='radio' name='mix' value='no' ".((isset($pub_mix) && $pub_mix =='no')?" checked ":"");
echo "> R&eacute;sultat mix&eacute; </th>\n";
echo "\t</tr>\n";
// Bouton Appliquer
echo "<tr><th colspan='".($j*2)."'><input type='submit' value='Appliquer'></th></tr>";
echo '</table>';
echo '</form>';
// Page suivante/precedente
pages();

// supprime un RC 
if (isset($pub_delete) && ($pub_delete == $user_data['user_id'] || $user_data['user_admin'] == 1 || $user_data['user_coadmin'] == 1 || $user_data['management_user'] == 1))
{
	$sql = 'DELETE FROM '.TABLE_GAME.' WHERE id=\''.(int)$pub_delete.'\'';
	$db->sql_query($sql);
	$sql = 'DELETE FROM '.TABLE_GAME_RECYCLAGE.' WHERE rc=\''.(int)$pub_delete.'\'';
	$db->sql_query($sql);
}

check_name($pub_player);
$player_save = $pub_player;
$player = (!isset($pub_player) || ($pub_player=='')) ? $user_data['user_name'] : $pub_player;

$listplayer = $pub_memberslist ;

if ((!isset($pub_mix)) || $pub_mix == 'yes')
{
	foreach ($listplayer as $player)
	{
		$id = userIdByName($player);
		if (!$id)
		{
			echo '<table width=\'90%\' align=\'center\'><tr><td class=\'c\'>Joueur '.$player.' inconnu</td></tr></table><br>';
		} 
		else if (!isUser($id)) 
		{
			echo '<table width=\'90%\' align=\'center\'><tr><td class=\'c\'>Joueur '.$player.' ne participant pas</td></tr></table><br>';
		} 
		else 
		{
			echo '<table width=\'90%\' align=\'center\'><tr><td class=\'c\' colspan=\'8\'>Rapports de combat de '.$player.'</td></tr>';
			entete();
			
			// Sélectionne 20 rapports dans la DB
			$sql = 'SELECT * FROM '.TABLE_GAME.' WHERE sender=\''.$id.'\'';
			// Ordre de tri de la requète
			if (isset($pub_order))
			{
				$sql .= ' ORDER BY '.$pub_order;
			}
			if (isset($pub_sort))
			{
				if ($pub_sort == "down") 
				{
					$sql .= ' DESC';
				}
				else
				{
					$sql .= ' ASC';
				}
			}
            $sql .= ' LIMIT '.($config['ligne']*($pub_page-1)).','.$config['ligne'];
			$result = $db->sql_query($sql);
			while ($val = $db->sql_fetch_assoc($result))
			{
				$precyclage = @($val['recyclageM']+$val['recyclageC']>0 ? '<br>(Recyclé à '.ceil(($val['recycleM']+$val['recycleC'])/($val['recyclageM']+$val['recyclageC'])*100).'%)' : '');
				$valRecyclage = @(($val['recycleM']+$val['recycleC'])/($val['recyclageM']+$val['recyclageC'])*100);
				$recyclage = ($val['recyclageM']+$val['recyclageC']>0) ? convNumber($val['recycleM']).' métal<br>'.convNumber($val['recycleC']).' cristal' : '-';
				$points = $val['points'];
				if (!$val['%lune'])
				{
					$lune = '-';
				} else {
					$lune = '<font color=\''.($val['lune'] ? 'lime' : 'red').'\'>'.$val['%lune'].'%';
				}
				$img = '<br>';
				if (($id == $user_data['user_id']) && ($recyclage<>'-') && ($valRecyclage<100)) $img .= '<form method=\'post\' action=\'?action=gameOgame&reportRecyclage='.$val['id'].'\'><input type=\'image\' src=\'./mod/gameOgame/images/recyclage.png\'></form>';
				if ($id == $user_data['user_id'] || $user_data['user_admin'] == 1 || $user_data['user_coadmin'] == 1 || $user_data['management_user'] == 1 || isAdmin($user_data['user_id'])) $img .= '<form method=\'post\' action=\'?action=gameOgame&subaction=display\' onSubmit="return confirm(\'Etes-vous sûr de vouloir supprimer ce rapport?\');"><input type=\'hidden\' name=\'player\' value=\''.$player_save.'\'><input type=\'hidden\' name=\'delete\' value=\''.$val['id'].'\'><input type=\'image\' src=\'./mod/gameOgame/images/delete.png\' title=\'Supprimer ce rapport\'></form>';
				echo '<tr><th nowrap><a href=\'?action=gameOgame&displayRC='.$val['id'].'\'>'.$val['id'].'</a>'.$img.'<th nowrap>'.date('d/m/Y',$val['date']).'<br>'.date('H:i:s',$val['date']).'</th><th nowrap>'.$val['attaquant'].'<br>vs.</br>'.$val['defenseur'].'</th><th nowrap>Attaquant: '.convNumber($val['pertesA']).'<br>Défenseur: '.convNumber($val['pertesD']).'</th><th nowrap>'.convNumber($val['pillageM']).' métal<br>'.convNumber($val['pillageC']).' cristal<br>'.convNumber($val['pillageD']).' deutérium</th><th nowrap>'.$recyclage.$precyclage.'</th><th nowrap>'.$lune.'</th><th nowrap>'.convNumber($points).'</th></tr>';
			}
			echo '</table><br>';
			// Page suivante/precedente
			pages();
		}
	}
} 
else
{
	$list_users = "";
	$sql = 'SELECT * FROM '.TABLE_GAME.' WHERE';
	$i = 0;
	foreach ($listplayer as $player)
	{
		$id = userIdByName($player);
		if (!$id)
		{
			$list_users .=  (($i>0)?",":"")."inconnu"; 
		}
		else
		{
			$list_users .= (($i>0)?",":""). $player;
			$sql .= (($i>0)?" OR":""). ' sender=\''.$id.'\'';
			$i ++;
		}
	}
	if (isset($pub_order))
		{
			$sql .= ' ORDER BY '.$pub_order;
		}
	if (isset($pub_sort))
			{
				if ($pub_sort == "down") 
				{
					$sql .= ' DESC';
				}
				else
				{
					$sql .= ' ASC';
				}
			}
	$sql .= ' LIMIT '.($config['ligne']*($pub_page-1)).','.$config['ligne'];

	echo '<table width=\'90%\' align=\'center\'><tr><td class=\'c\' colspan=\'8\'>Rapports de combat de '.$list_users.'</td></tr>';
	entete();
	
	$result = $db->sql_query($sql);
	while ($val = $db->sql_fetch_assoc($result))
	{
		$precyclage = @($val['recyclageM']+$val['recyclageC']>0 ? '<br>(Recyclé à '.ceil(($val['recycleM']+$val['recycleC'])/($val['recyclageM']+$val['recyclageC'])*100).'%)' : '');
		$valRecyclage = @(($val['recycleM']+$val['recycleC'])/($val['recyclageM']+$val['recyclageC'])*100);
		$recyclage = ($val['recyclageM']+$val['recyclageC']>0) ? convNumber($val['recycleM']).' métal<br>'.convNumber($val['recycleC']).' cristal' : '-';
		$points = $val['points'];
		if (!$val['%lune'])
		{
			$lune = '-';
		} else {
			$lune = '<font color=\''.($val['lune'] ? 'lime' : 'red').'\'>'.$val['%lune'].'%';
		}
		$img = '<br>';
		if (($id == $user_data['user_id']) && ($recyclage<>'-') && ($valRecyclage<100)) $img .= '<form method=\'post\' action=\'?action=gameOgame&reportRecyclage='.$val['id'].'\'><input type=\'image\' src=\'./mod/gameOgame/images/recyclage.png\'></form>';
		if ($id == $user_data['user_id'] || $user_data['user_admin'] == 1 || $user_data['user_coadmin'] == 1 || $user_data['management_user'] == 1 || isAdmin($user_data['user_id'])) $img .= '<form method=\'post\' action=\'?action=gameOgame&subaction=display\' onSubmit="return confirm(\'Etes-vous sûr de vouloir supprimer ce rapport?\');"><input type=\'hidden\' name=\'player\' value=\''.$player_save.'\'><input type=\'hidden\' name=\'delete\' value=\''.$val['id'].'\'><input type=\'image\' src=\'./mod/gameOgame/images/delete.png\' title=\'Supprimer ce rapport\'></form>';
		echo '<tr><th nowrap><a href=\'?action=gameOgame&displayRC='.$val['id'].'\'>'.$val['id'].'</a>'.$img.'<th nowrap>'.date('d/m/Y',$val['date']).'<br>'.date('H:i:s',$val['date']).'</th><th nowrap>'.$val['attaquant'].'<br>vs.</br>'.$val['defenseur'].'</th><th nowrap>Attaquant: '.convNumber($val['pertesA']).'<br>Défenseur: '.convNumber($val['pertesD']).'</th><th nowrap>'.convNumber($val['pillageM']).' métal<br>'.convNumber($val['pillageC']).' cristal<br>'.convNumber($val['pillageD']).' deutérium</th><th nowrap>'.$recyclage.$precyclage.'</th><th nowrap>'.$lune.'</th><th nowrap>'.convNumber($points).'</th></tr>';
		}
	echo '</table><br>';
	// Page suivante/precedente
	pages();
}

// Draw arrows in the columns
function arrows($ordrename)
{
	global $pub_order,$pub_sort,$pub_mix,$pub_memberslist;
	echo '&nbsp;&nbsp;&nbsp;';
	echo '<form method=\'post\' action=\'?action=gameOgame&subaction=display&sort=up\' >';
	echo '<input type=\'image\' src=\'./mod/gameOgame/images/'.((($pub_order==$ordrename)&&($pub_sort=='up'))?'rup.gif':'up.gif').'\'  name=\'order\' value=\''.$ordrename.'\' width=10px height=9px />';
	echo '<input type=\'hidden\' name=\'mix\' value=\''.$pub_mix.'\' />';
	foreach ($pub_memberslist as $val)
	{
		echo '<input type=\'hidden\' name=\'memberslist[]\' value=\''.$val.'\' />';
	}
	echo '</form>';
	echo '&nbsp;';
	echo '<form method=\'post\' action=\'?action=gameOgame&subaction=display&sort=down\' >';
	echo '<input type=\'image\' src=\'./mod/gameOgame/images/'.((($pub_order==$ordrename)&&($pub_sort=='down'))?'rdown.gif':'down.gif').'\'  align=\'middle\' name=\'order\' value=\''.$ordrename.'\' width=10px height=9px />';
	echo '<input type=\'hidden\' name=\'mix\' value=\''.$pub_mix.'\' />';
	foreach ($pub_memberslist as $val)
	{
		echo '<input type=\'hidden\' name=\'memberslist[]\' value=\''.$val.'\' />';
	}
	echo '</form>';
	echo '&nbsp;';
}	

// header of the columns
function entete()
{
	echo '<tr><td class=\'c\' >N°';
	arrows('id');
	echo '</td>';
	echo '<td class=\'c\'>Date';
	arrows('date');
	echo '</td>';
	echo '<td class=\'c\'>Opposants&nbsp;</td>';
	echo '<td class=\'c\'>Pertes&nbsp;</td>';
	echo '<td class=\'c\'>Pillage&nbsp;</td>';
	echo '<td class=\'c\'>Recyclage&nbsp;</td>';
	echo '<td class=\'c\'>Lune&nbsp;</td>';
	echo '<td class=\'c\'>Points';
	arrows('points');
	echo '</td></tr>';
}

// Page previous/next 
function pages()
{
	global $pub_order,$pub_page,$pub_sort,$pub_mix,$pub_memberslist;
	echo '<table width=100% ><tr>';
	echo '<td style=\'text-align: left;\' class=\'s\' >';
	echo '<form method=\'post\' action=\'?action=gameOgame&subaction=display\' >';
	echo '<input type=\'image\' src=\'./mod/gameOgame/images/'.(($pub_page <= 1)? 'rleft.gif': 'left.gif').'\' name=\'page\' value=\''.($pub_page - 1).' align=\'middle\' />';
	echo '&nbsp;Page Pr&eacute;c&eacute;dente</td>';
	echo '<td style=\'text-align: right;\' class=\'s\' >';
	echo 'Page Suivante&nbsp;';
	echo '<input type=\'image\' src=\'./mod/gameOgame/images/right.gif\' name=\'page\' value=\''.($pub_page + 1).' align=\'middle\' />';
	echo '</td>';
	echo '<input type=\'hidden\' name=\'order\' value=\''.$pub_order.'\' />';
	echo '<input type=\'hidden\' name=\'sort\' value=\''.$pub_sort.'\' />';
	echo '<input type=\'hidden\' name=\'mix\' value=\''.$pub_mix.'\' />';
	foreach ($pub_memberslist as $val)
	{
		echo '<input type=\'hidden\' name=\'memberslist[]\' value=\''.$val.'\' />';
	}
	echo '</form>';
	echo '</tr></table>';
}

?>

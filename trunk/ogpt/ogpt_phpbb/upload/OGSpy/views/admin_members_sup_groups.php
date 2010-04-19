<?php
/***************************************************************************
*	filename	: admin_members_group.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 16/12/2005
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] != 1) {
	redirection("index.php?action=message&id_message=forbidden&info");
}

if (isset($pub_subaction) and ($pub_subaction=='usergroup_delmember') and isset($pub_user_id) and isset($pub_group_id)) {
  // 	if (!isset($pub_user_id) || !isset($pub_group_id))
  usergroup_delmember();
 // usergroup_delete();
}



require_once("views/page_header.php");
$request = "select use_name from ".TABLE_USER." where user_id=".$pub_user_id.";";
$result = $db->sql_query($request);

$row = $db->sql_fetch_assoc($result);
$target_user_name = isset($row['username']) ? $row['username'] : 'nom inconnu';

$request = "select tg.group_name, tg.group_id from ".TABLE_GROUP." tg left join ".TABLE_USER." ug";
$request .= " on tg.group_id  = ug.group_id";
$request .= " where ug.user_id = ".$pub_user_id;

$result = $db->sql_query($request);
//list($user_groups) = $db->sql_fetch_row($result);

// $user_groups = user_statistic();
/*foreach ($result as $ugs) {
  list($group_name, $group_id) = $ugs;
  echo $group_name['']."\n";
}  */

?>
<table>
<tr>
	<td class="c" colspan="1" width="290">Liste des groupes auquel <b><?php echo $target_user_name; ?></b> appartient</td>
</tr>
</table>
<br>
<table>
<div align='center'>
<tr>

        <td class="c" width="160">Nom Groupe</td>
	<td class="c" width="120" colspan="2">Action</td>
	<!--- //<td class="c" >&nbsp;</td> --->

</tr>  	</div>
<?php
while ($row = $db->sql_fetch_assoc($result)) {
      //list($group_name, $group_id) = $row;
      echo "<tr>"."\n";
      echo "\t"."<th>".$row['group_name']."<br></th>";
  
  	echo "<form method='POST' action='index.php?action=show_user_groups&user_id=".$pub_user_id."&subaction=group&group_id=".$row['group_id']."' >"."\n";
        echo "\t"."<th><input type='image' src='images/usercheck.png' title='Affiche le groupe ".$row['group_name']." contenant ".$target_user_name."'>"."\n";
	echo "</form></th>"; // ."\n";

	echo "<form method='POST' action='index.php?action=show_user_groups&subaction=usergroup_delmember&target_user_id=".$pub_target_user_id."&user_id=".$pub_user_id."&group_id=".$row['group_id']."' onsubmit=\"return confirm('Etes-vous sûr de vouloir supprimer ".$target_user_name." du groupe ".$row['group_name']."');\">"."\n";
	echo "\t"."<th><input type='image' src='images/userdrop.png' title='Supprimer ".$target_user_name." du groupe ".$row['group_name']."'>"."\n";
	echo "</form></th>"."\n";
      echo "</tr>"."\n";
}
?>

</table>
<br> <br>
<?php
if (isset($pub_subaction) and ($pub_subaction=='group') and isset($pub_user_id) ) {
    echo "\t"."<table>\n";
    echo "\t"."<tr>\n";
    echo "\t"."<td class=\"c\" colspan=\"1\" width=\"290\"><b>Affichage des propriétés du groupe sélectionné</b></td>\n";
    echo "\t"."</tr>\n";
    echo "\t"."</table><br>\n";
}

 require("views/admin_members_group.php");
 require_once("views/page_tail.php");
?>
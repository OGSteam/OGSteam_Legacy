<?php
/***************************************************************************
*	filename	: admin_mod.php
*	desc.		:
*	Author		: Aéris - http://ogs.servebbs.net/
*	created		:
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");


$mod_menupos_captions[] = $LANG["adminmod_menupos_common"];
$mod_menupos_captions[] = $LANG["adminmod_menupos_admin"];
$mod_menupos_captions[] = $LANG["adminmod_menupos_homearea"];


$mod_list = mod_list();

$num_enabled_mods = count($mod_list["actived"]);
$num_enabled_mods_common = 0;
foreach($mod_list["actived"] as $mod) {
	if ($mod["menupos"] == "0") $num_enabled_mods_common++;
}
$num_disabled_mods = count($mod_list["disabled"]);
$num_wrong_mods = count($mod_list["wrong"]);


?>

<table align="center" width="1000">
	<tr><td>&nbsp;</td></tr>

	<tr><td class="c"  align='center'><a href="index.php?action=administration&subaction=mod&orderasc=title"><?php echo $LANG["adminmod_ActiveMods"]; ?><img src='images/asc.png'></a> (<?php echo $num_enabled_mods; ?>)</td>
         <td class="c"  colspan="3"  align='center'><?php echo $LANG["adminmod_Action"]; ?></td>
         <td class="c"  width="80" align='center'><?php echo $LANG["adminmod_promote"]; ?></td>
         <td class="c"  width="130" align='center'><a href="index.php?action=administration&subaction=mod&orderasc=menupos"><?php echo $LANG["adminmod_sitting"]; ?><img src='images/asc.png'></a></td>
         
         <td class="c"  width="150" align='center'><a href="index.php?action=administration&subaction=mod&orderasc=id"><?php echo $LANG["adminmod_position"]; ?><img src='images/asc.png'></a></td>

        </tr>
<?php

$mods = $mod_list["actived"];

while ($mod = current($mods)) {
	

        $notice_on_new_off = !$mod['noticeifnew'] ? " selected" : "";

        //
        echo "\t"."<tr>\n";
      	echo "\t"."\t"."<th >".$mod["title"]." (".$mod["version"].")</th>"."\n";
      	echo "\t"."\t"."<th width='80'><a href='index.php?action=mod_disable&mod_id=".$mod['id']."&orderasc=".$pub_orderasc."' onclick=\"return confirm('".$LANG["adminmod_confirm_Desactivate"]."');\">".$LANG["adminmod_Desactivate"]."</a></th>"."\n";
      	echo "\t"."\t"."<th width='80'><a href='index.php?action=mod_uninstall&mod_id=".$mod['id']."&orderasc=".$pub_orderasc."' onclick=\"return confirm('".$LANG["adminmod_confirm_Uninstall"]."');\">".$LANG["adminmod_Uninstall"]."</a></th>"."\n";
      	if (!$mod["up_to_date"]) {
      		  echo "<th width='100'/><a href='index.php?action=mod_update&mod_id=".$mod['id']."&orderasc=".$pub_orderasc."'>".$LANG["adminmod_Update"]."</a></th>"."\n";
      	}
        //-------
        else echo "\t"."<th width='100'/>&nbsp;</th>"."\n";
		
		echo "\t\t"."<form method='POST' action='index.php?action=mod_modify_props&mod_id=".$mod['id']."&orderasc=".$pub_orderasc."'>"."\n";
        // promotion?
        echo "\t\t"."<th >"."<select name='noticeifnew'><option value='1'>".$LANG["basic_Yes"]."</option><option value='0' $notice_on_new_off>".$LANG["basic_No"]."</option></select>"."</th>"."\n";
        
        // emplacement
        echo "\t\t"."<th >"."<select name='menupos'>";
			foreach ($mod_menupos_captions as $key => $mod_menupos){
				echo "<option value='$key' ".($key == ($mod['menupos']) ? "selected" : "").">".$mod_menupos."</option>";
			}
			echo "</select></th>";
				


        // colonne position
        echo "\t\t"."<th >";
        $menupos_orderpos = $mod['position']; // var intermédiaire 
        $menupos_movelink = "<a href='index.php?action=mod_modify_props&mod_id=".$mod['id'].(isset($pub_orderasc) ? "&orderasc=".$pub_orderasc : "");
        // colonne position
		if ($mod['menupos'] == "0"){
	        if ($menupos_orderpos<($num_enabled_mods_common+16)) 
				echo $menupos_movelink./* down */"&orderpos=".($menupos_orderpos+1)."'><img src='images/desc.png'></a> ";
	        else 
				echo $menupos_movelink./* up */"&orderpos=".($menupos_orderpos-1)."'><img src='images/asc.png'></a> ";
		}
        // boite liste déroulante choix indice position        
        echo "<select name='orderpos'>";
		if (!$mod['menupos'] == "0"){
			echo "<option value='0' selected>0</option>";
		} else {
			for( $lcpt = 1 ; $lcpt <= ($num_enabled_mods_common+16) ; $lcpt++) {
	             echo "<option value='".$lcpt."' ".($lcpt==$menupos_orderpos ? "selected" : "").">".$lcpt."</option>";
	        };
		}
        echo "</select>";
        
		if ($mod['menupos'] == "0"){
	        if ($menupos_orderpos>1)
				echo " ".$menupos_movelink ./* up */"&orderpos=".($menupos_orderpos-1)."'><img src='images/asc.png'></a>";
	        else
				echo " ".$menupos_movelink./* down */"&orderpos=".($menupos_orderpos+1)."'><img src='images/desc.png'></a>";
	        echo "</th>\n";
		}
        // bouton validation
        echo "\t"."<th><input type='image' src='images/usercheck.png' title='".$LANG["adminmod_validate_mod_params"].$mod["title"]."'></th>"."\n";
       	echo "\t\t"."</form>"."\n";

	echo "</tr>";
	echo "\n";

	next($mods);
}
?>
	<tr><td>&nbsp;</td></tr>
	<br>
        <a href='index.php?action=mod_sort_bytitle'><?php echo $LANG["adminmod_sort_alpha"]; ?></a>
	<br>
	<tr><td class="c" colspan="7" width="760"><?php echo $LANG["adminmod_InactiveMods"]; ?>(<?php echo $num_disabled_mods; ?>)</td></tr>
<?php
$mods = $mod_list["disabled"];
while ($mod = current($mods)) {
	echo "\t"."<tr>";
	echo "<th width='200'>".$mod["title"]." (".$mod["version"].")</th>";
	echo "<th width='100'><a href='index.php?action=mod_active&mod_id=".$mod['id']."'>".$LANG["adminmod_Activate"]."</a></th>";
	echo "<th width='100'><a href='index.php?action=mod_uninstall&mod_id=".$mod['id']."&orderasc=".$pub_orderasc."' onclick=\"return confirm('".$LANG["adminmod_confirm_Uninstall"]."');\">".$LANG["adminmod_Uninstall"]."</a></th>";
	if (!$mod["up_to_date"]) {
		echo "<th width='100'><a href='index.php?action=mod_update&mod_id=".$mod['id']."'>".$LANG["adminmod_Update"]."</a></th>";
	}
	else echo "<th width='100'>&nbsp;</th>";
	
	//echo "<th width='100'>Promo.: ".(($mod['noticeifnew']==1)? 'Oui':'Non')."</th>";
	//echo "<th width='110'>Client: ".$caruser_captions[($mod['catuser'])]."</th>";
	//echo "<th width='50'>Pos.: ".$mod['orderpos']."</th>";

	echo "</tr>";
	echo "\n";

	next($mods);
}
?>
	<tr><td>&nbsp;</td></tr>
	
	<tr><td class="c" colspan="4" width="500"><?php echo $LANG["adminmod_InstallableMods"]; ?></td></tr>
<?php
$mods = $mod_list["install"];
while ($mod = current($mods)) {
	echo "\t"."<tr>";
	echo "<th width='200'>".$mod["title"]."</th>";
	echo "<th width='300' colspan='3'><a href='index.php?action=mod_install&directory=".$mod['directory']."'>".$LANG["adminmod_Install"]."</a></th>";


	echo "</tr>";
	echo "\n";

	next($mods);
}
?>
	<tr><td>&nbsp;</td></tr>
	
	<tr><td class="c" colspan="4" width="500"><?php echo $LANG["adminmod_InvalidMods"]."(".$num_wrong_mods; ?>)</td></tr>
<?php
$mods = $mod_list["wrong"];
while ($mod = current($mods)) {
	echo "\t"."<tr>";
	echo "<th width='200'>".$mod["title"]."</th>";
	echo "<th width='300' colspan='3'><a href='index.php?action=mod_uninstall&mod_id=".$mod['id']."&orderasc=".$pub_orderasc."' onclick=\"return confirm('".$LANG["adminmod_confirm_Uninstall"]."');\">".$LANG["adminmod_Uninstall"]."</a></th>";
	echo "</tr>";
	echo "\n";

	next($mods);
}
?>
</table>

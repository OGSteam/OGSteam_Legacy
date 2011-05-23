<?php
/***************************************************************************
*	filename	: ogsplugmod_user.php
*	desc.		: partire module affichant les infos de config pour l'utilisateur
*	Author		: Naqdazar - lexa.gg@free.fr
*	created		: 29/05/2007
*	modified	: 29/05/2007
***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $ogp_lang, $help, $ogsplugin_nameuniv, $ogsplugin_numuniv, $hote, $script_ogsplugin, $xpiplugin_info, $gamename;


$firefoxplugin_info = GetModuleInfo('frx_ogsplugin');

echo '<div align="center">';

// utilité test à revoir
if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
    $table_width = "100%";
} else $table_width = "100%";


?>
    <table width="<?php echo $table_width; ?>">
        <tr>
        	<td class="c" colspan="2"><?php echo $ogp_lang["usersinfos_main"];?></td>
        </tr>
        <tr>  <?php // Serveur d'Univers Ogame ?>
            <th width="40%"><?php echo $ogp_lang["gameserver_usrinfo"].$gamename;?>
                <?php echo ogsplugin_help("ogp_ogsplug_univ"); ?>
            </th>
        	  <th><?php echo $ogp_lang["universelabel_misc"];?>&nbsp; : &nbsp;
              <?php /* <input type="text" size="1" value=" */
               echo $ogsplugin_numuniv; /* " readonly="true"> */
               ?>&nbsp; - &nbsp;
               <?php /* <input type="text" name="galviewslog" size="20" value=" */
               echo $ogp_lang["gameserver_namelabel"]."&nbsp; : &nbsp;"; echo $ogsplugin_nameuniv;  /* " readonly="true"> */ ?>
               
            </th>
        </tr>
        <tr>  <?php // URL plugin ?>
        	<th width="40%"><?php echo $ogp_lang["urlplugin_usrinfo"];?></th>
        	<th>
          <?php /* <input type="text" name="ogsurlplugin" size="60" value=" */ 
           echo "http://".$hote.$script_ogsplugin;
           /* " readonly="true"></th> */ ?>
        </tr>
        
        <tr>
        <th>
          <?php echo $ogp_lang["frxplugin_info"]." v".$firefoxplugin_info["version"]; ?>:
        </th>
        <th>
        <a href="<?php echo $firefoxplugin_info["link"]; ?>"><?php echo $ogp_lang["download_frxplugin"];?></a>
        </th>
        </tr>
        
        <tr>
        <th>
          <?php echo $ogp_lang["tutorial_word"];?>:
        </th>
        <th>
        <a href="<?php echo $firefoxplugin_info["tutorial"];?>"><?php echo $ogp_lang["tutorial_label"];?> v<?php echo $firefoxplugin_info["version"]; ?></a>
        </th>
        </tr>
    </table>
</div>

<?php if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
    echo '</table>';
} ?>

<?php
/**
 * insertion.php 

Module d'insertion

 * @package QuiMSonde
 * @author Sylar
 * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08

 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
// Affichage du cadre de l'importation de rapport
?>
<fieldset><legend><b><font color='#80FFFF'><?php echo $lang['qms_menu_insertion'].help('qms_ajouter rapport'); ?></font></b></legend>
<?php echo $lang['qms_insertion_desc']; ?>
<p>
	<form action='index.php?action=<?php echo $mod_name; ?>' method='post'>
	<textarea rows='10' name='espionage' cols='25'></textarea>
</p>
<p>
	<input type='submit' value='<?php echo $lang['qms_insertion_submit']; ?>'>
	</form>
</p>
</fieldset>
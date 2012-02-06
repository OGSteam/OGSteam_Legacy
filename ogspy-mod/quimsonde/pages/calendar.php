<?php
/**
 * calendar.php 

Code pour insertion de la zone de calendrier.

 * @package QuiMSonde
 * @author Sylar
 * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08

 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
global $mod_name;
?>
<style type="text/css">
#user_time_start,#user_time_end,#admin_time_start,#admin_time_end {
	border: 1px solid #999;
	color: #FFF;
	padding: 3px 2px 2px 24px;
	cursor: hand;
	background: url(mod/<?php echo $mod_name; ?>/images/img.gif) no-repeat 2px center;
}
</style>
<style type="text/css">@import url(mod/<?php echo $mod_name; ?>/js/calendar/theme.css);</style>
<script type="text/javascript" src="mod/<?php echo $mod_name; ?>/js/calendar/calendar.js" /></script>
<script type="text/javascript" src="mod/<?php echo $mod_name; ?>/js/calendar/calendar-fr.js" /></script>
<script type="text/javascript" src="mod/<?php echo $mod_name; ?>/js/calendar/calendar-setup.js" /></script>
<?php
if(defined("FROM_DETAILS")){
?>
<script type="text/javascript">
	Calendar.setup({inputField:'user_time_start',ifFormat:'%d/%m/%Y',button:'user_time_start',showOthers:true,range:[2007, 2010],weekNumbers:false});
	Calendar.setup({inputField:'user_time_end',ifFormat:'%d/%m/%Y',button:'user_time_end',showOthers:true,range:[2007, 2010],weekNumbers:false});
</script>
<?php
}
if(defined("FROM_ADMIN")){
?>
<script type="text/javascript">
Calendar.setup({inputField:'admin_time_start',ifFormat:'%d/%m/%Y',button:'admin_time_start',showOthers:true,range:[2007, 2010],weekNumbers:false});
Calendar.setup({inputField:'admin_time_end',ifFormat:'%d/%m/%Y',button:'admin_time_end',showOthers:true,range:[2007, 2010],weekNumbers:false});
</script>
<?php
}
?>

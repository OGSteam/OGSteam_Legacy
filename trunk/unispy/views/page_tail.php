<?php
/***************************************************************************
*	filename	: page_tail.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 08/12/2005
*	modified	: 23/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$php_end = benchmark();
$php_timing = $php_end - $php_start - $sql_timing;
?>
	</td>
</tr>
<tr align="center">
	<td>&nbsp;</td>
	<td>
		<center>
			<font size="2">
				<i><b><a href="http://www.ogsteam.fr" target="_blank">UniSpy</a></b> <?php echo $LANG["pagetail_Copyright"]."<b> ".$LANG["pagetail_Copyright2"]."</b> &copy; 2006"?></i><br />v <?php echo $server_config["version"];?><br />
				<i><?php echo $LANG['Time_generation'];?> <?php echo round($php_timing+$sql_timing, 3);?> sec (<b>PHP</b> : <?php echo round($php_timing, 3);?> / <b>SQL</b> : <?php echo round($sql_timing, 3);?>)<br /></i>
			</font>
		</center>
	</td>
</tr>
</table>
<script language="JavaScript" src="js/wz_tooltip.js"></script>
</body>
</html>
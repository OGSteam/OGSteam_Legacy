<?php
/***************************************************************************
*	filename	: page_tail_2.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 08/12/2005
*	modified	: 30/07/2006 00:00:00
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
	<td>
		<center>
			<font size="2">
				<i><b><a href="http://ogs.servebbs.net" target="_blank">OGSpy</a></b> is a <b>Kyser Software</b> &copy; 2006</i><br />v <?php echo $server_config["version"];?><br />
				<i>Temps de génération <?php echo round($php_timing+$sql_timing, 3);?> sec (<b>PHP</b> : <?php echo round($php_timing, 3);?> / <b>SQL</b> : <?php echo round($sql_timing, 3);?>)<br /></i>
			</font>
		</center>
	</td>
</tr>
</table>
</body>
</html>
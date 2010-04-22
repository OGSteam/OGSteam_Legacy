<?php
/**
* page_tail.php :  Footer des pages OGSpy
* @author Kyser - http://ogsteam.fr/
* @created  08/12/2005
* @package OGSpy
* @subpackage main
*/
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$php_end = benchmark();
$php_timing = $php_end - $php_start - $sql_timing;
$db->sql_close(); // fermeture de la connexion à la base de données 
?>
	</td>
</tr>
<?php
global $ogspy_phperror;
if (is_array($ogspy_phperror) && count($ogspy_phperror)) {
	echo "\n<tr>\n\t<td><table><tr><th>Erreurs php</th></tr>";
	foreach($ogspy_phperror as $line) {
		echo "\n<tr><td>$line</td></tr>";
	}
	echo "</table>\n\t</td>\n</tr>";
}
?>
<tr>
	<td>
		<center>
			<font size="2">
				<i><b><a href="http://ogsteam.fr" target="_blank">OGSpy</a></b> is a <b>Kyser Software</b> &copy; 2007</i><br />v <?php echo $server_config["version"];?><br />
				<i>Temps de génération <?php echo round($php_timing+$sql_timing, 3);?> sec (<b>PHP</b> : <?php echo round($php_timing, 3);?> / <b>SQL</b> : <?php echo round($sql_timing, 3);?>)<br /></i>
			</font>
		</center>
	</td>
</tr>
</table>
<script language="JavaScript" src="js/wz_tooltip.js"></script>
</body>
</html>

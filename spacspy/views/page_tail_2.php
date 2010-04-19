<?php
/**
* page_tail_2.php :  Footer des pages SpacSpy
* @author Kyser - http://ogsteam.fr/
* @created  08/12/2005
* @package SpacSpy
* @subpackage main
***************************************************************************/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

$php_end = benchmark();
$php_timing = $php_end - $php_start - $sql_timing;
$db->sql_close(); // fermeture de la connexion à la base de données 
?>
	</td>
</tr>
<?php
global $SpacSpy_phperror;
if (is_array($SpacSpy_phperror) && count($SpacSpy_phperror)) {
	echo "\n<tr>
 <td>&nbsp;</td>";
 echo "<td><table><tr><th>Erreurs php</th></tr>";
 foreach($SpacSpy_phperror as $line) {
 	echo "\n<tr><td>$line</td></tr>";
 }
 echo "</table>
 </td></tr>";
}
?>
<tr align="center">
	<td>
		<center>
			<font size="2">
				<i><b><a href="http://www.spacsteam.fr" target="_blank">SpacSpy</a></b> is a <b>Kyser Software</b> &copy; 2007</i><br />v <?php echo $server_config["version"];?><br />
				<i>Temps de génération <?php echo round($php_timing+$sql_timing, 3);?> sec (<b>PHP</b> : <?php echo round($php_timing, 3);?> / <b>SQL</b> : <?php echo round($sql_timing, 3);?>)<br /></i>
			</font>
		</center>
	</td>
</tr>
</table>
</body>
</html>

<?php
/**
 * changelog.php 
 * @package HofRC
 * @author Shad
 * @link http://www.ogsteam.fr
 * @version : 0.0.1
 */
 
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//Définitions
global $db;

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='hofrc' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

?>
<table style='width:60%'  align='center'>
	<!-- Amélioration -->
	<tr style='line-height : 20px; vertical-align : center;'>
		<td class='c' style='text-align : center; color : #0080FF;'>Version</td>
	</tr>
		<tr>
			<th>
				<fieldset>
					<legend>
						<b>
							<font color='#0080FF'><u>Version 0.0.1</u></font>
						</b>
					</legend>
					<ul>
						<li>Sortie du mod</li>
					</ul>
				</fieldset>
			</th>
		</tr>
</table>
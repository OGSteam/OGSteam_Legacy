<?php
$query = "SELECT `version` FROM `".TABLE_MOD."` WHERE `action`='QuiMobserve' LIMIT 1";
list ($version) = $db->sql_fetch_row($db->sql_query($query));


echo"<br>";
echo"<br>";
echo"<hr width='325px'>";
echo"<p align='center'><font size=\"2\">Mod de Gestion des Espionnages | Version ".$version." | <a href='mailto:santory@websantory.ner'>Santory</a> | © 2007</font></p>";
?>
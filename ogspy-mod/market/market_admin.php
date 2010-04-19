<?php
/** market_admin.php Partie administration des serveurs Market dans le MOD Market
* @package MOD_Market
* @author Jey2k <jey2k.ogsteam@gmail.com>
* @version 1.0
*/
?>
	<div align='left'>
		<form action='index.php?action=market' method='post'>
		En tant qu'administrateur ou co-administrateur, vous pouvez:
		<?php
		// On récupère tous les serveurs définis
		$query = "SELECT `server_id`,`server_url`, `server_name`, `server_password`, `server_active`, `universes_list`, `universes_list_timestamp`, `trades_list`, `trades_list_timestamp`, `server_refresh`, `active_universe`, `trades_count`, UNIX_TIMESTAMP() as maintenant FROM ".TABLE_MARKET;
		$result = $db->sql_query($query);
		$servers = array();
		while ($server = $db->sql_fetch_assoc($result)) {
		   $servers[]=$server;
		}
	?>
	<br>
	<table border=1 width="100%">
		<TR><TH colspan="9">Modifier des serveurs</TH></TR>
		<tr><th>&nbsp;</th><th>URL</th><th>Password</th><th>Nom</th><th>Délai refresh</th><th>Univers</th><th>Actif</th><th>&nbsp;</th><th>&nbsp;</th></tr>
	<?php
			foreach ($servers as $server)
			{
				//$server=update_server_universes($server,$OGSMarket_uni_url);
				//echo "<tr><td>".$server["server_id"]."</td><td>".$server["server_url"]."</td><td>";
				//echo "<tr><td>".$server["server_id"]."</td><td>".$server["server_url"]."</td><td>";
				?>
				<tr>
					<td><a href="index.php?action=market&subaction=serverdelete&server_id=<?php echo $server["server_id"];?>"><img src="images/drop.png" title="Supprimer le serveur"/></a></td>
					<td><form action='index.php?action=market' method='post'>
					<input type="hidden" name="subaction" value="serverupdate"/>
					<input type="hidden" name="server_id" value="<?php echo $server["server_id"];?>"/>
					<input type="text" name="server_url" size="40" value="<?php echo $server["server_url"];?>"></td>
					<td><input type="password" name="server_password" size="15" value="<?php echo $server["server_password"];?>"></td>
					<td><input type="text" name="server_name" size="40" value="<?php echo $server["server_name"];?>"></td>
					<td><input type="text" name="server_refresh" size="4" value="<?php echo $server["server_refresh"];?>"></td>
					<td>
						<select name="active_universe">
							<?php
							$universes_array=get_universes_array($server);
							foreach($universes_array as $universe){
								echo "\n<OPTION ";
								if ($universe["id"]==$server["active_universe"]) {
									echo " SELECTED";
								}		
								echo " VALUE=\"".$universe["id"]."\">".$universe["name"]."</OPTION>";
							}
							?>
						</select>
					</td>
					<td><input type="checkbox" name="server_active" value="1"<?php if ($server["server_active"]==1) {echo " CHECKED";}?>></td>
					<td><input type="submit"/></form></td>
					<td><a href="index.php?action=market&subaction=updateuniverselist&server_id=<?php echo $server["server_id"];?>"><img src="images/userpwd.png" title="Mise à jour des univers"/></a></td>
				</tr>
	<?php
		}
	?>
			<TR><TH colspan="8">Ajouter un nouveau serveur</TH></TR>
			<tr><th>&nbsp;</th><th>URL</th><th>Password</th><th>Nom</th><th>Délai refresh</th><th>Univers</th><th>Actif</th><th>&nbsp;</th><th>&nbsp;</th></tr>
			<TR>
				<td>&nbsp;</td>
				<td><form action='index.php?action=market&subaction=insertserver' method='post'><input type="text" name="server_url" size="40" value="http://"></td>
				<td><input type="password" name="server_password" size="15" value=""></td>
				<td><input type="text" name="server_name" size="40" value=""></td>
				<td><input type="text" name="server_refresh" size="4" value="300"></td>
				<td>&nbsp;</td>
				<td><input type="checkbox" name="server_active" value="1" CHECKED></td>
				<td><input type="submit"/></form></td>
				<td>&nbsp;</td>
			</TR>
		</TABLE>
		</div>
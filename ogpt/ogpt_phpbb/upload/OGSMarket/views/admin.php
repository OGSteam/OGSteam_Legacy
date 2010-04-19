<?php
/***************************************************************************
*	filename	: home.php
*	desc.		: 
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 17/12/2005
*	modified	: 28/12/2005 23:56:40
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");
require_once("views/admin_menu.php");
echo "<table align='center' width='80%'>";
//Conversion en heures
$ogs_max_trade_delay_seco = ($ogs_max_trade_delay_hours)*60*60;
$ogs_users_active = (is_null($ogs_member_auto_activ)) ? "0" : "1";

if (isset($ogs_subaction))
{
	switch ($ogs_subaction) {
		case "updateidentparam":
			
			$queries=array();
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_users_auth_type."' WHERE name='users_auth_type' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_users_adr_auth_db."' WHERE name='users_adr_auth_db' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_users_auth_db."' WHERE name='users_auth_db' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_users_auth_dbuser."' WHERE name='users_auth_dbuser' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_users_auth_dbpasswor."' WHERE name='users_auth_dbpasswor' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_users_auth_table."' WHERE name='users_auth_table' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_users_inscription_ur."' WHERE name='users_inscription_ur' LIMIT 1;" ;

			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_servername."' WHERE name='servername' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_skin."' WHERE name='skin' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_users_active."' WHERE name='users_active' LIMIT 1;" ;


			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_menuprive."' WHERE name='menuprive' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_menulogout."' WHERE name='menulogout' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_menuautre."' WHERE name='menuautre' LIMIT 1;" ;;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_menuforum."' WHERE name='menuforum' LIMIT 1;" ;

			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_nomforum."' WHERE name='nomforum' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_adresseforum."' WHERE name='adresseforum' LIMIT 1;" ;

			$queries[]="UPDATE ".TABLE_INFOS." SET value='".$ogs_home."' WHERE name='home' LIMIT 100000;" ;

			foreach($queries as $query)
			{
				$result = $db->sql_query($query);
			}
			init_serverconfig();
			echo "<tr><th>Paramètres d'Identification Login Mis à Jour</th></tr>";
			break;
		case "updatemodmarketparam":
			$queries=array();
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_market_read_access."' WHERE name='market_read_access' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_market_write_access."' WHERE name='market_write_access' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_market_password."' WHERE name='market_password' LIMIT 1;" ;
			foreach($queries as $query)
			{
				$result = $db->sql_query($query);
			}
			init_serverconfig();
			echo "<tr><th>Paramètres d'Accès Mod Market Mis à jour</th></tr>";
			break;
	}
}

//Convertion en heures (suite)
$max_trade_delay = ($server_config["max_trade_delay_seco"])/60/60;

//Conversion des attributs des checkbox
$member_activ_auto = ($server_config["users_active"]) == 1 ? "checked" : "";

?>
<tr>
	<td>
		<form action="index.php" method="POST">
		<table width="100%">

			<tr>
				<th colspan="2">Configuration Général</th>
			</tr>

				<tr>
					<td class="c">Nom du serveur:</td>
					<td>
						<input type="text" name="servername" value="<?php echo $server_config["servername"]?>"/>
					</td>
				</tr>

				<tr>
					<td class="c">Skin de base:</td>
					<td>
						<input type="text" name="skin" value="<?php echo $server_config["skin"]?>"/>
					</td>
				</tr>

				<tr>
					<td class="c">Activation automatique des nouveaux membres:</td>
					<td>
						<input type="checkbox" name="member_auto_activ" value="1" <?php echo $member_activ_auto ?> />
					</td>
				</tr>
			<tr>
				<td colspan="2" class="c" align="center"><input type="submit"></td>
			</tr>
			
<!--Forum-->

				<th colspan="2">Forum</th>
			</tr>

				<tr>
					<td class="c">Nom du forum:</td>
					<td>
						<input type="text" name="nomforum" value="<?php echo $server_config["nomforum"]?>"/>
					</td>
				</tr>

				<tr>
					<td class="c">Adresse du forum:</td>
					<td>
						<input type="text" name="adresseforum" value="<?php echo $server_config["adresseforum"]?>"/>
					</td>
				</tr>
			<tr>
				<td colspan="2" class="c" align="center"><input type="submit"></td>
			</tr>

<!--catégorie-->

				<th colspan="2">Nom des Catégories</th>
			</tr>

				<tr>
					<td class="c">Privés:</td>
					<td>
						<input type="text" name="menuprive" value="<?php echo $server_config["menuprive"]?>"/>
					</td>
				</tr>

				<tr>
					<td class="c">forum:</td>
					<td>
						<input type="text" name="menuforum" value="<?php echo $server_config["menuforum"]?>"/>
					</td>
				</tr>

				<tr>
					<td class="c">Logout:</td>
					<td>
						<input type="text" name="menulogout" value="<?php echo $server_config["menulogout"]?>"/>
					</td>
				</tr>
				<tr>
					<td class="c">autre:</td>
					<td>
						<input type="text" name="menuautre" value="<?php echo $server_config["menuautre"]?>"/>
					</td>
				</tr>
			<tr>
				<td colspan="2" class="c" align="center"><input type="submit"></td>
			</tr>

<!--messages-->
				<th colspan="2">Configuration des messages configurables (En html sans ligne)</th>
			</tr>

				<tr>
					<td class="c">message d'accueil:</td>
					<td>
						<textarea name="home" rows="7"><?php echo $infos_config["home"]; ?></textarea>
					</td>
				</tr>
			<tr>
				<td colspan="2" class="c" align="center"><input type="submit"></td>
			</tr>

<!--Authentification-->

			<tr>
				<th colspan="2">Configuration Authentification</th>
			</tr>
			<tr>
				<input name="action" type="hidden" value="admin"/>
				<input name="subaction" type="hidden" value="updateidentparam"/>
				<td class="c" width="50%">Type Authentification:</td>
				<td>
					<select name="users_auth_type">
						<option value="internal" <?php if ($server_config["users_auth_type"]=="internal"){echo " SELECTED";} ?>>Internal</option>
						<option value="punbb" <?php if ($server_config["users_auth_type"]=="punbb"){echo " SELECTED";} ?>>PunBB</option>
						<option value="smf" <?php if ($server_config["users_auth_type"]=="smf"){echo " SELECTED";} ?>>SMF</option>
						<option value="phpbb2" <?php if ($server_config["users_auth_type"]=="phpbb2"){echo " SELECTED";} ?>>PHPBB2</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="c">Adresse Du Server SQL:</td>
				<td>
					<input type="text" name="users_adr_auth_db" value="<?php echo $server_config["users_adr_auth_db"]?>"/>
				</td>
			</tr>
			<tr>
				<td class="c">Base d'identification:</td>
				<td>
					<input type="text" name="users_auth_db" value="<?php echo $server_config["users_auth_db"]?>"/>
				</td>
			</tr>
			<tr>
				<td class="c">User Base d'identification:</td>
				<td>
					<input type="text" name="users_auth_dbuser" value="<?php echo $server_config["users_auth_dbuser"]?>"/>
				</td>
			</tr>
			<tr>
				<td class="c">Password Base d'identification:</td>
				<td>
					<input type="text" name="users_auth_dbpasswor" value="<?php echo $server_config["users_auth_dbpasswor"]?>"/>
				</td>
			</tr>
			<tr>
				<td class="c">Table d'identification:</td>
				<td>
					<input type="text" name="users_auth_table" value="<?php echo $server_config["users_auth_table"]?>"/>
				</td>
			</tr>
			<tr>
				<td class="c">URL d'inscription:</td>
				<td>
					<input type="text" name="users_inscription_ur" value="<?php echo $server_config["users_inscription_ur"]?>"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="c" align="center"><input type="submit"></td>
			</tr>
		</table>
	</form>
	</td>
</tr>
<tr>
	<td>
		<form action="index.php" method="POST">
			<table width="100%">
				<tr>
					<th colspan="2">Authentification Mod Market</th>
				</tr>
				<tr>
					<td class="c" width="50%">Lecture des offres:</td>
					<td>
						<input name="action" type="hidden" value="admin"/>
						<input name="subaction" type="hidden" value="updatemodmarketparam"/>
						<select name="market_read_access">
							<option value="0" <?php if ($server_config["market_read_access"]=="0"){echo " SELECTED";} ?>>0 - Public</option>
							<option value="1" <?php if ($server_config["market_read_access"]=="1"){echo " SELECTED";} ?>>1 - Mot de passe</option>
							<option value="2" <?php if ($server_config["market_read_access"]=="2"){echo " SELECTED";} ?>>2 - URI</option>
							<option value="3" <?php if ($server_config["market_read_access"]=="3"){echo " SELECTED";} ?>>3 - URI + Mot de passe</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="c">Création d'offre:</td>
					<td>
						<select name="market_write_access">
							<option value="0" <?php if ($server_config["market_write_access"]=="0"){echo " SELECTED";} ?>>0 - Public</option>
							<option value="1" <?php if ($server_config["market_write_access"]=="1"){echo " SELECTED";} ?>>1 - Mot de passe</option>
							<option value="2" <?php if ($server_config["market_write_access"]=="2"){echo " SELECTED";} ?>>2 - URI</option>
							<option value="3" <?php if ($server_config["market_write_access"]=="3"){echo " SELECTED";} ?>>3 - URI + Mot de passe</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="c">Password Accès:</td>
					<td>
						<input type="text" name="market_password" value="<?php echo $server_config["market_password"]?>"/>
					</td>
				</tr>
				<tr>
						<td colspan="2" class="c" align="center"><input type="submit"></td>
					</tr>
			</table>
		</form>
	</td>
</tr>
<tr>
	<td>
		<table width="100%">
			<tr>

				<th colspan="2">Autres Paramètres</th>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
		<table width="80%" align="center">
			<tr>
				<th colspan="5">Liste des OGSpys autorisés à poster</th>
			</tr>
			<tr>
				<th>URL</th>
				<th>Description</th>
				<th>Accès Lecture</th>
				<th>Accès Ecriture</th>
				<th>Actif</th>
			</tr>
<?php
			$query = "SELECT `id`, `url`, `read_access`, `write_access`, `active`, `description` from ".TABLE_OGSPY_AUTH.";";
			$result	=	$db->sql_query($query);
			while (list( $id, $url, $read_access, $write_access, $active, $description) = $db->sql_fetch_row($result)) {
				echo "<tr><td>$url</td><td>$description</td><td>$read_access</td><td>$write_access</td><td>$active</td></tr>";
			}
?>
		</table>
	</td>
</tr>
</table>

<?php
//if (!$dont_include_header){
	require_once("views/page_tail.php");
//	}
?>

<?php 
if ( ! defined ( 'IN_SPYOGAME' ) )
  die ( 'Hacking attempt' );
include_once("views/page_header.php");

// if ( ! isset ( $pub_subaction ) || ! file_exists ( 'mod/recycleur/' . $pub_subaction . '.php' ) )
  // $pub_subaction = 'index';
  
// config OGSpy
$nb_galaxies = $server_config['num_of_galaxies'] + 1;
$nb_systems = $server_config['num_of_systems']+1;

if ( ! isset ( $pub_subaction ) || ! file_exists ( 'mod/recycleur/' . $pub_subaction . '.php' ) )
{ $pub_subaction = 'index';}

?>

<table width="100%">
<tr>
	<td>
		<table align="center">
		<tr align='center'>
<?php

if ( $pub_subaction != 'recycleurs' )
	{
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=recycleurs&subaction=recycleurs';\">";
		echo "<a style='cursor: pointer'><font color:'lime'>Recycleurs</font></a>";
		echo "</td>";
	}
else
	{
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Recycleurs</a>";
		echo "</th>";
	}
	
if ( $pub_subaction != 'phalanges' )
	{
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=recycleurs&subaction=phalanges';\">";
		echo "<a style='cursor: pointer'><font color:'lime'>Phalanges</font></a>";
		echo "</td>";
	}
else
	{
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Phalanges</a>";
		echo "</th>";
	}
	
if ( $user_data['user_admin'] == 1 || $user_data['user_coadmin'] == 1 )
	{
		if ( $pub_subaction != 'admin' )
			{
				echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=recycleurs&subaction=admin';\">";
				echo "<a style='cursor: pointer'><font color:'lime'>Administration</font></a>";
				echo "</td>";
			}
		else
			{
				echo "\t\t\t"."<th width='150'>";
				echo "<a>Administration</a>";
				echo "</th>";
			}
   }
if ( $pub_subaction != 'version' )
	{
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=recycleurs&subaction=version';\">";
		echo"<a style='cursor: pointer'><font color:'lime'>Version et Info</font></a>";
		echo "</td>";
	}
else
	{
		echo "<th width='150'>";
		echo "<a>Version et Info</a>";
		echo "</th>";
	}
  
 ?>
 
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
<?php
switch ($pub_subaction) {
	case "recycleurs" :
	require_once("recycleurs.php");
	break;

	case "phalanges" :
	require_once("phalanges.php");
	break;

	case "admin" :
	require_once("admin.php");
	break;
	
	case "version" :
	require_once("version.php");
	break;

	default:
	require_once("recycleurs.php");
	break;
	}
	?>  
	</td>
</tr>
</table>

<?php
print '<hr width="325px">' . "\n";
print '<p align="center">MOD Recycleurs & Phalanges | Version 1.0.0 | DeusIrae</p>' . "\n";
print '<p align="center">Mise à jour par Shad</p>' . "\n";
include_once './views/page_tail.php';
?>
<?php 
if ( ! defined ( 'IN_SPYOGAME' ) )
  die ( 'Hacking attempt' );
include_once("views/page_header.php");
if ( ! isset ( $pub_subaction ) || ! file_exists ( 'mod/recycleurs/' . $pub_subaction . '.php' ) )
  $pub_subaction = 'index';
?>
<table height="600px">
  <tr height="10%">
	<td align="center" valign="top"><table border="1">
	  <tr align="center">
<?php
if ( $pub_subaction != 'index' )
  print '	    <td class="c" width="150" onclick="window.location.href=\'index.php?action=recycleurs\';"><a style="cursor: pointer; color:lime;">Index</font></a></td>'."\n";
else
  print '	    <th width="150"><a>Index</a></th>'."\n";
if ( $pub_subaction != 'recycleurs' )
  print '	    <td class="c" width="150" onclick="window.location.href=\'index.php?action=recycleurs&subaction=recycleurs\';"><a style="cursor: pointer; color:lime;">Recycleurs</font></a></td>'."\n";
else
  print '	    <th width="150"><a>Recycleurs</a></th>'."\n";
if ( $pub_subaction != 'phalanges' )
  print '	    <td class="c" width="150" onclick="window.location.href=\'index.php?action=recycleurs&subaction=phalanges\';"><a style="cursor: pointer; color:lime;">Phalanges</font></a></td>'."\n";
else
  print '	    <th width="150"><a>Phalanges</a></th>'."\n";
if ( $user_data['user_admin'] == 1 || $user_data['user_coadmin'] == 1 )
{
  if ( $pub_subaction != 'admin' )
    print '	    <td class="c" width="150" onclick="window.location.href=\'index.php?action=recycleurs&subaction=admin\';"><a style="cursor: pointer; color:lime;">Administration</font></a></td>'."\n";
  else
    print '	    <th width="150"><a>Administration</a></th>'."\n";
}
if ( $pub_subaction != 'version' )
  print '	    <td class="c" width="150" onclick="window.location.href=\'index.php?action=recycleurs&subaction=version\';"><a style="cursor: pointer; color:lime;">Version et Info</font></a></td>'."\n";
else
  print '       <th width="150"><a>Version et Info</a></th>'."\n";
?>
      </tr>
    </table></td>
  </tr>
  <tr height="90%">
    <td align="center"><?php include_once( $pub_subaction . '.php' ); ?></td>
  </tr>
</table>
<?php
print '<hr width="325px">' . "\n";
print '<p align="center">MOD Recycleurs & Phalanges | Version 1.1 | DeusIrae</p>' . "\n";
include_once './views/page_tail.php';
?>
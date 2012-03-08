<?php

if (!defined('IN_SPYOGAME'))
{
	exit('Hacking attempt');
}

if (!$db->sql_numrows($db->sql_query('SELECT active FROM '. TABLE_MOD .' WHERE action = \'densite\' AND active = \'1\' LIMIT 1')))
{
  exit('Module non activé');
}

require_once 'views/page_header.php';

?>

<style type="text/css">
  .densite-wrap {
    padding: 10px 10px 5px 10px;
    width: 1000px;
    background-color: #252525;
  }
  
  .densite {
    border-collapse: collapse;
    margin-bottom: 5px;
  }
  
  .densite td, .densite tr {
    margin: 0px;
    padding: 0px;
  }
  
  .densite td {
    height: 2px;
    width: 2px;
  }
  
  .em { background-color: white; }
  .oc { background-color: black; }
  .un { background-color: orange; }
</style>

<?php

/* ************************************************************************** */

$result = $db->sql_query('SELECT galaxy, system, row, player FROM '. TABLE_UNIVERSE);

// 0: empty, 1: occupied, 2: unknown
for ($k = 1; $k < 10; $k++)
{
  for ($i = 1; $i < 16; $i++)
  {
    for ($j = 1; $j < 500; $j++)
    {
      $overview[$k][$i][$j] = 2;
    }
  }
}

while (list($galaxy, $system, $row, $player) = $db->sql_fetch_row($result))
{
  $overview[$galaxy][$row][$system] = empty($player) ? 0 : 1;
}

echo '<div class="densite-wrap">';

for ($k = 1; $k < 10; $k++)
{
  echo '<table class="densite">';

  for ($i = 1; $i < 16; $i++)
  {
    echo '<tr>';
  
    for ($j = 1; $j < 500; $j++)
    {
      switch ($overview[$k][$i][$j]) {
        case 0 : echo '<td class="em"></td>'; break;
        case 1 : echo '<td class="oc"></td>'; break;
        default: echo '<td class="un"></td>';
      }
    }
  
    echo '</tr>';
  }

  echo '</table>';
}

echo '</div>';

/* ************************************************************************** */

require_once 'views/page_tail.php';

?>

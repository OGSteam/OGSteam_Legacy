<?php


define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';

///ogpt
$lien="galaxie.php";
$page_title = "rapport d espionnage";
require_once  PUN_ROOT . 'ogpt/include/ogpt.php';
/// fin ogpt

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="<?php echo $lang_common['lang_direction'] ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $lang_common['lang_encoding'] ?>" />
<title><?php echo pun_htmlspecialchars($pun_config['o_board_title']).' / '.$new_message_txt ?></title>
<link rel="stylesheet" type="text/css" href="style/<?php echo $pun_user['style'].'.css' ?>" />
<style type="text/css">
<!--
div#new_pm {
margin: 50px 20% 12px 20%;
}
-->
</style>


<?php
    if (isset($_GET['re']))
    {



  $ss=''.pun_trim(pun_htmlspecialchars($_GET['re'])).'';






     








$result = $db->query('SELECT *  FROM '.$pun_config["ogspy_prefix"].'parsedspy where coordinates="'.$ss.'" order by dateRE desc');
while ($re = $db->fetch_assoc($result))
{





       $test=$re['id_spy'];

  $data = UNparseRE($test);

echo''.$data.'';

    
   



}
    }
?>








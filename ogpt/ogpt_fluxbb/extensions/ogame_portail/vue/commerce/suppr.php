
<?php

if(isset($_GET['suppr']) )
{
if (is_numeric($_GET['suppr']))
{
$forum_db->query('DELETE FROM '.$forum_db->prefix.'commerce_vente WHERE id=\''.$_GET['suppr'].'\'') or error(__FILE__, __LINE__);
echo '<script> alert("Suppression prise en compte") </script>';
echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?offre=foo"}setTimeout("redirect()",5000); </SCRIPT>';

}
else
{
echo "Qu'est-ce que tu fais, petit malin ? ;)";
}

	
	

}	
	
else
{
echo "Qu'est-ce que tu fais, petit malin ? ;)";
}	
?>

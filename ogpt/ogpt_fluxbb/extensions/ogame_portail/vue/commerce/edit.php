
<?php

if(isset($_GET['edit']) )
{
if (is_numeric($_GET['edit']))
{

	$forum_db->query('DELETE FROM '.$forum_db->prefix.'commerce_vente WHERE id=\''.$_GET['edit'].'\'') or error(__FILE__, __LINE__);
echo '<script> alert("Votre demande est prise en compte, vous pouvez maintenant recommencer votre offre") </script>';
echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?offre=foo"}setTimeout("redirect()",50); </SCRIPT>';
}














}
else
{
echo "Qu'est-ce que tu fais, petit malin ? ;)";
}

	
	

	
		
?>

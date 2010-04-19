<?php


$sql = 'SELECT *  FROM colonne  WHERE  actif=\'1\'  ORDER BY ordre asc ';
$resultter = $db->query($sql);
while ($colonne = $db->fetch_assoc($resultter)) {

/// seecu max => admin seulement 
if ($colonne['secu']== '4' && $pun_user['g_id'] =='1' )
{
echo "<div class=\"block\"><h2 class=\"block2\"><span>".$colonne['title']." </span></h2><div class=\"box\"><div class=\"inbox\"><ul>";
include 'include/user/'. $colonne['lien'].''; 
echo "</ul></div></div></div>";   
}
/// seecu niveau 3  => admin, et membre ayant accés ogspy  seulement 
else if ($colonne['secu']== '3' && ($pun_user['id_ogspy'] !== '0' ||$pun_user['g_id'] =='1'  ))
{
echo "<div class=\"block\"><h2 class=\"block2\"><span>".$colonne['title']." </span></h2><div class=\"box\"><div class=\"inbox\"><ul>";
include 'include/user/'. $colonne['lien'].''; 
echo "</ul></div></div></div>";   
}

/// seecu niveau 2  => admin, et membre 
else if ($colonne['secu']== '2' && !$pun_user['is_guest']   )
{
echo "<div class=\"block\"><h2 class=\"block2\"><span>".$colonne['title']." </span></h2><div class=\"box\"><div class=\"inbox\"><ul>";
include 'include/user/'. $colonne['lien'].''; 
echo "</ul></div></div></div>";   
} 

/// seecu niveau 0  => tout le monde peut voir 
else if ($colonne['secu']== '0')
{
echo "<div class=\"block\"><h2 class=\"block2\"><span>".$colonne['title']." </span></h2><div class=\"box\"><div class=\"inbox\"><ul>";
include 'include/user/'. $colonne['lien'].''; 
echo "</ul></div></div></div>";   
} 

 else 
{
	echo "<div class=\"block\"><h2 class=\"block2\"><span>".$colonne['title']." </span></h2><div class=\"box\"><div class=\"inbox\"><ul>";
echo "Vous n\avez pas  les accces requis";  
echo "</ul></div></div></div>";   
 
}  
  
}



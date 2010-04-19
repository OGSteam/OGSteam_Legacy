

<div id="category1" class="main-content category" style="margin-top: 4px">
	

	<table cellspacing="0" summary="Acceuil.">
		<thead>
			<tr>
				<th class="tcl" scope="col">vente en cours</th>
				<th class="tc2" scope="col">par</th>
				<th class="tcr" scope="col">fin</th>

			</tr>
		</thead>
		
		<?php
		
		
		/// requete pour l affichage des ventes en cours
		$date=time();
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 		
	$query = array(
		'SELECT'	=> 'v.id, v.date, v.fin, v.id_user , v.username, v.ressource, v.quantite , v.vs, v.vsquantite, v.vs2 ,  v.vs2quantite ,v.commentaire, v.livraison, v.reservation , v.pseudo , v.id_user_r, v.vente, v.satisfaction  , v.commentaire_satisfaction  , g.id_groupe , g.permission   ',
		'FROM'		=> 'commerce_vente AS v',
		'JOINS'		=> array(
			array(
				'INNER JOIN'	=> 'commerce_groupe AS g',
				'ON'			=> '(v.id=g.id_vente) '
			),
		),
		'WHERE'		=> '('.$forum_user['group_id'].' = g.id_groupe) and (v.fin > '.$date.')  and (g.permission = 1)  and (v.reservation = 0) and (v.vente=0) order by fin asc ',
	);	
	
$vente = $forum_db->query_build($query) or error(__FILE__, __LINE__);
while ($venteencours = $forum_db->fetch_assoc($vente))
{

echo'
<tbody class="statused">
			<tr id="forum2" class="odd normal row1">
			
<td class="tc1"><span class="status normal" title="Forum"></span> <h3><a href=""><span>vente de '.conv($venteencours['quantite']).' de '.ressource($venteencours['ressource']).' contre '.conv($venteencours['vsquantite']).' de '.ressource($venteencours['vs']).''; if($venteencours['vs2']!='0'){ echo ' et '.conv($venteencours['vs2quantite']).' de '.ressource($venteencours['vs2']).'';}

 echo' </span></a></h3>offre depose le : '.format_time($venteencours['date']).'';
  if($venteencours['livraison']!='0'){ echo ' <li>livraison en <b>G'.$venteencours['livraison'].'</b></li> ';}

echo '<li></li>
 <li> <b>detail :</b>
 <li>'.$venteencours['commentaire'].' <li>';
echo '<li></li> ';



echo ' <a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/commerce.php?reservation='.$venteencours['id'].'">Reserver </a>  ';

 if ( $venteencours['id_user']==$forum_user['id'] ){ echo ' <a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/commerce.php?edit='.$venteencours['id'].'">editer</a> ';}

if ( $venteencours['id_user']==$forum_user['id'] || $forum_user['g_id'] == FORUM_ADMIN ){ echo ' <a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/commerce.php?suppr='.$venteencours['id'].'">supprimer </li>';}
 
 
 
 echo'
 </td>	';


echo'<td class="tc2">'.$venteencours['username'].' </td>';

echo'	<td class="tcr">'.format_time($venteencours['fin']).'</span></a></td>
			</tr>
			
		</tbody>';
		

}
		
	?>	
		
	
	</table>
	</div>
	<div id="category1" class="main-content category" style="margin-top: 4px">
	
		<table cellspacing="0" summary="Acceuil.">
		<thead>
			<tr>
				<th class="tcl" scope="col">vente deja reserve</th>
				<th class="tc2" scope="col">par</th>
				<th class="tcr" scope="col">Reservation</th>

			</tr>
		</thead>
		
		<?php
		
		
		/// requete pour l affichage des ventes en cours
		$date=time();
		$query = array(
		'SELECT'	=> 'v.id, v.date, v.fin, v.id_user , v.username, v.ressource, v.quantite , v.vs, v.vsquantite, v.vs2 ,  v.vs2quantite ,v.commentaire, v.livraison, v.reservation , v.pseudo , v.id_user_r, v.vente, v.satisfaction  , v.commentaire_satisfaction  , g.id_groupe , g.permission   ',
		'FROM'		=> 'commerce_vente AS v',
		'JOINS'		=> array(
			array(
				'INNER JOIN'	=> 'commerce_groupe AS g',
				'ON'			=> '(v.id=g.id_vente) '
			),
		),
		'WHERE'		=> '('.$forum_user['group_id'].' = g.id_groupe) and (v.fin > '.$date.')  and (g.permission = 1)  and (v.reservation = 1) and (v.vente=0) order by fin asc ',
	);	
	
		
		
$vente = $forum_db->query_build($query) or error(__FILE__, __LINE__);
while ($venteencours = $forum_db->fetch_assoc($vente))
{
echo'
<tbody class="statused">
			<tr id="forum2" class="odd normal row1">
			
<td class="tc1"><span class="status normal" title="Forum"></span> <h3><a href=""><span>vente de '.conv($venteencours['quantite']).' de '.ressource($venteencours['ressource']).' contre '.conv($venteencours['vsquantite']).' de '.ressource($venteencours['vs']).''; if($venteencours['vs2']!='0'){ echo ' et '.conv($venteencours['vs2quantite']).' de '.ressource($venteencours['vs2']).'';}
 echo' </span></a></h3>offre depose le : '.format_time($venteencours['date']).'';
  if($venteencours['livraison']!='0'){ echo ' <li>livraison en <b>G'.$venteencours['livraison'].'</b></li> ';}
echo'
<li></li> 
 <li> <b>detail :</b>
 <li>'.$venteencours['commentaire'].' <li>
 </td>	';


echo'<td class="tc2">'.$venteencours['username'].' </td>';

echo'	<td class="tcr">';
echo'	<li>Reserver par : '.$venteencours['username'].'</li><br/>';
echo'	<li></li><br/';
echo ' <a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/commerce.php?vente='.$venteencours['id'].'">Accepter la transaction</a>';
echo'</td>
			</tr>
			
		</tbody>';


}
		
	?>	
	
			</table>
			</div>
	
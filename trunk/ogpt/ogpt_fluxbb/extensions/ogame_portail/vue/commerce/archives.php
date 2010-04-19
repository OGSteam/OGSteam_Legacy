

<div id="category1" class="main-content category" style="margin-top: 4px">
	

	<table cellspacing="0" summary="Acceuil.">
		<thead>
			<tr>
				<th class="tcl" scope="col">vente reussi</th>
				<th class="tc2" scope="col">par</th>
				<th class="tcr" scope="col">fin</th>

			</tr>
		</thead>
		
		<?php
		
		
		/// requete pour l affichage des ventes en cours
		$date=time();
		
		$query = array(
	'SELECT'	=> '*',
	'FROM'		=> 'commerce_vente',
	'WHERE'		=> '(fin > '.$date.') and (reservation = 1 ) order by fin desc ',
	
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

echo'	<td class="tcr">vendu a '.$venteencours['pseudo'].'</span></a></td>
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
				<th class="tcl" scope="col">vente ratee</th>
				<th class="tc2" scope="col">par</th>
				<th class="tcr" scope="col">fin</th>

			</tr>
		</thead>
		
		<?php
		
		
		/// requete pour l affichage des ventes en cours
		$date=time();
		
		$query = array(
	'SELECT'	=> '*',
	'FROM'		=> 'commerce_vente',
	'WHERE'		=> '(fin < '.$date.') and (reservation = 0) and (vente=0) order by fin desc',
	
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

echo'	<td class="tcr">'.format_time($venteencours['fin']).'</span></a></td>
			</tr>
			
		</tbody>';


}
		
	?>	
	
			</table>

	
	
	
</div>
function user_edit(id){
	document.getElementById('user_id_edit').value = id;
	document.getElementById('edit_member_name').innerHTML = document.getElementById('name_'+id).value;
	document.getElementById('no_active').selected = (document.getElementById('active_'+id).value!=1);
<!-- IF is_admin -->
	document.getElementById('no_coadmin').selected = (document.getElementById('coadmin_'+id).value!=1);
<!-- END IF is_admin -->
<!-- IF is_admin_or_co -->
	document.getElementById('no_userman').selected = (document.getElementById('userman_'+id).value!=1);
<!-- END IF is_admin_or_co -->
	document.getElementById('no_rankman').selected = (document.getElementById('rankman_'+id).value!=1);
	document.getElementById('edit_member').style.visibility = 'visible';
}
function user_delete(id,msg_confirm){
	if(confirm(msg_confirm))
		window.location = '?action=delete_member&'+'user_id='+id;
}
function user_pass(id,msg_confirm){
	if(confirm(msg_confirm)){
		document.getElementById('this_id_newpass').value = id;
		document.getElementById('new_pass_input').value = '';
		document.getElementById('new_pass_div').style.visibility = 'visible';
	}
}

var index
function  sort_int(p1,p2) { return p1[index]-p2[index]; }			//fonction pour trier les nombres
function sort_char(p1,p2) { return ((p1[index]>=p2[index])<<1)-1; }	//fonction pour trier les strings
function ClearArrow(oTable,len){									//fonction pour effacer les flèches
	for(var i = 0; i < len; i++)
		oTable.rows[0].cells[i].innerHTML = 
			oTable.rows[0].cells[i].innerHTML
				.replace(new RegExp(String.fromCharCode(9650)),'')
				.replace(new RegExp(String.fromCharCode(9660)),'');
}

function TableOrder(e,Dec)  //Dec= 0:Croissant, 1:Décroissant
{ 
	//---- Détermine : oCell(cellule) oTable(table) index(index cellule) -----//
	var FntSort = new Array()
	if(!e) e=window.event
	for(oCell=e.srcElement?e.srcElement:e.target;oCell.tagName!="TD";oCell=oCell.parentNode);	//determine la cellule sélectionnée
	for(oTable=oCell.parentNode;oTable.tagName!="TABLE";oTable=oTable.parentNode);				//determine l'objet table parent
	for(index=0;oTable.rows[0].cells[index]!=oCell;index++);									//determine l'index de la cellule

	ClearArrow(oTable,oTable.rows[0].cells.length); // Supprime toutes les fleches (pour plus de clareté)

 //---- Copier Tableau Html dans Table JavaScript ----//
	var Table = new Array()
	for(r=1;r< oTable.rows.length;r++) Table[r-1] = new Array()

	for(c=0;c< oTable.rows[0].cells.length;c++)	//Sur toutes les cellules
	{	var Type;
		objet=oTable.rows[1].cells[c].innerHTML.replace(/<\/?[^>]+>/gi,"")
		if(objet.match(/^\d\d[\/-]\d\d[\/-]\d\d\d\d$/)) { FntSort[c]=sort_char; Type=0; } //date jj/mm/aaaa
		if(objet.match(/^\d\d[\/-]\d\d[\/-]\d\d\d\d\s.\s\d\d\:\d\d$/))
														{ FntSort[c]=sort_char; Type=3; } //date jj/mm/aaaa à hh:mm
		else if(objet.match(/^[0-9£$\.\s-]+$/))		{ FntSort[c]=sort_int;  Type=1; } //nombre, numéraire
		else											{ FntSort[c]=sort_char; Type=2; } //Chaine de caractère

		for(r=1;r< oTable.rows.length;r++)		//De toutes les rangées
		{	objet=oTable.rows[r].cells[c].innerHTML.replace(/<\/?[^>]+>/gi,"")
			switch(Type)		
			{	case 0: Table[r-1][c]= new Date(objet.substring(6),objet.substring(3,5),objet.substring(0,2)); break; //date jj/mm/aaaa
				case 3: Table[r-1][c]= new Date(objet.substring(6,10),objet.substring(3,5),objet.substring(0,2),objet.substring(13,15),objet.substring(16,18)); break; //date jj/mm/aaaa
				case 1: Table[r-1][c]=parseFloat(objet.replace(/[^0-9.-]/g,'')); break; //nombre
				case 2: Table[r-1][c]=objet.toLowerCase(); break; //Chaine de caractère
			}
			Table[r-1][c+oTable.rows[0].cells.length] = oTable.rows[r].cells[c].innerHTML
		}
	}

 //--- Tri Table ---//
	Table.sort(FntSort[index]);
	if(Dec) Table.reverse();

 //---- Copier Table JavaScript dans Tableau Html ----//
	for(c=0;c< oTable.rows[0].cells.length;c++)	//Sur toutes les cellules
		for(r=1;r< oTable.rows.length;r++)		//De toutes les rangées 
			oTable.rows[r].cells[c].innerHTML=Table[r-1][c+oTable.rows[0].cells.length];  

			
 // ---- Modification du champ et du lien ---- //
	var childs = oCell.childNodes;
	var nbChilds = childs.length;
	for(var i = 0; i < nbChilds; i++){
		if(childs[i].nodeType==1) { span_arrow = childs[i]; break; }
	}
	span_arrow.innerHTML = (Dec==1)?'&#9660;':'&#9650;';
	oCell.setAttribute("onclick",'TableOrder(event,'+(1-Dec)+')');

}
//*****************************************************************************************
function uf_messageOptionListener(button)
{
try {
//alert('bb');
	var select=false;
	//alert(e.target.getAttribute('name'));
	//si on valide la suppression des messages non selectionnes, on inverse la selection
	if(button.getAttribute('name').match("^button1$"))//bouton du bas
	{
	//var td=button.parentNode;
	select=document.getElementsByName('supmsg1')[0];
	//td.firstChild.nextSibling;
	//e.target.parentNode.getElementsByName("supmsg1")[0];
	}
	else if(button.getAttribute('name').match("^button2$"))//bouton du haut
	{
	//alert(e.target.parentNode.innerHTML);
	//var td=button.parentNode;

	select=document.getElementsByName('supmsg2')[0];
	//select=td.firstChild;//getElementsByName("supmsg2")[0];

	//alert(select);
	}
	if(select!=false)
	{
	//alert(select.innerHTML);
		if(select.value.match(/^myeff$/))
		{
		var boxes=document.getElementsByName("msgtosup[]");
		for(i=0;i<boxes.length;i++)
		{
		if(boxes[i].checked)
		boxes[i].checked=false;
		else boxes[i].checked=true;
		//alert(i+":"+boxes[i].checked.toString()+"a");
		}
		select.options[0].selected="selected";
		//e.target.type="button";
		}
	}
}
catch (e) {
		unifoxdebug(e,"option listener",doc);
	}
}


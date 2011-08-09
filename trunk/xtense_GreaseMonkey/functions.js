function displayOption(id){
	if(id=="Xtense_serveurs"){
		document.getElementById(id).style.display="block";
		document.getElementById("Xtense_pages").style.display="none";
		document.getElementById("Xtense_options").style.display="none";
		document.getElementById("Xtense_about").style.display="none";
		document.getElementById("menu_servers").style.value=document.getElementById("menu_servers").style.value.replace("orange","white");
		document.getElementById("menu_pages").style.value=document.getElementById("menu_pages").style.value.replace("white","orange");
		document.getElementById("menu_options").style.value=document.getElementById("menu_options").style.value.replace("white","orange");
		document.getElementById("menu_about").style.value=document.getElementById("menu_about").style.value.replace("white","orange");		
	} else if(id=="Xtense_pages"){
		document.getElementById(id).style.display="block";		
		document.getElementById("Xtense_serveurs").style.display="none";
		document.getElementById("Xtense_options").style.display="none";
		document.getElementById("Xtense_about").style.display="none";
		document.getElementById("menu_servers").style.value=document.getElementById("menu_servers").style.value.replace("white","orange");
		document.getElementById("menu_pages").style.value=document.getElementById("menu_pages").style.value.replace("orange","white");
		document.getElementById("menu_options").style.value=document.getElementById("menu_options").style.value.replace("white","orange");
		document.getElementById("menu_about").style.value=document.getElementById("menu_about").style.value.replace("white","orange");
	} else if(id=="Xtense_options"){
		document.getElementById(id).style.display="block";
		document.getElementById("Xtense_serveurs").style.display="none";		
		document.getElementById("Xtense_pages").style.display="none";
		document.getElementById("Xtense_about").style.display="none";
		document.getElementById("menu_servers").style.value=document.getElementById("menu_servers").style.value.replace("white","orange");
		document.getElementById("menu_pages").style.value=document.getElementById("menu_pages").style.value.replace("white","orange");
		document.getElementById("menu_options").style.value=document.getElementById("menu_options").style.value.replace("orange","white");
		document.getElementById("menu_about").style.value=document.getElementById("menu_about").style.value.replace("white","orange");
	} else if(id=="Xtense_about"){
		document.getElementById(id).style.display="block";
		document.getElementById("Xtense_serveurs").style.display="none";
		document.getElementById("Xtense_pages").style.display="none";
		document.getElementById("Xtense_options").style.display="none";
		document.getElementById("menu_servers").style.value=document.getElementById("menu_servers").style.value.replace("white","orange");
		document.getElementById("menu_pages").style.value=document.getElementById("menu_pages").style.value.replace("white","orange");
		document.getElementById("menu_options").style.value=document.getElementById("menu_options").style.value.replace("white","orange");
		document.getElementById("menu_about").style.value=document.getElementById("menu_about").style.value.replace("orange","white");
		
		
	}
}
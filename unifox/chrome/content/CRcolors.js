function ufInitCRcolors() {
try{
	//ufDump(ufCRconvPref);
	if(ufCRconvPref.colors) {
		var options = ufGetCRconvOptions();
		var colors = typeof options.colors != 'undefined' ? options.colors : {};
		var grid = document.getElementById('ufCRcolorsGrid');
		var rows = grid.getElementsByTagName('rows')[0];
		var rowCount = 0;
		for(var i in ufCRconvPref.colors) {
			if(rowCount%2 == 0) {
				var row = document.createElement('row');
				row.id = "row-"+rowCount;
			}
			rowCount++;
			//ufDump(ufCRconvPref.colors[i]);
			//ufLog(ufCRconvPref.colors[i].label);
			var label = document.createElement('label');
			var textbox = document.createElement('textbox');
			var square = document.createElement('label');
			var button = document.createElement('button');
			//<button label="&unifox.prefs.colorButton;"	oncommand="uf_openColor('ufTextColor','ufTextColor');"/>'
			row.appendChild(label);
			row.appendChild(textbox);
			row.appendChild(square);
			row.appendChild(button);
			rows.appendChild(row);
			
			label.value = ufCRconvPref.colors[i].label;
			label.control = "textb-"+i;
			
			textbox.id = "textb-"+i;
			//ufLog(i+' '+colors[i]+' '+(typeof colors[i]!='undefined'));
			
			textbox.addEventListener('change',ufUpdateColorListener,false);
			textbox.addEventListener('keyup',ufUpdateColorListener,false);
			square.setAttribute('style','-moz-appearance: none');
			square.value = ' ';
			/*square.setAttribute('disabled',true);
			square.setAttribute('size',2);*/
			//ufDump( square.offsetHeight);
			square.style.width = square.style.height = "2em";
			
			
			button.setAttribute('label',"Choisir");
			//button.setAttribute('oncommand', "uf_openColor('','"+textbox.id+"');");
		}
		for(var i in ufCRconvPref.colors) {
			textbox = document.getElementById("textb-"+i);
			var color = '';
			if(typeof colors[i]!='undefined') color = colors[i];
			else color = ufCRconvPref.colors[i].color;
			textbox.value = color;
			ufUpdateColor(textbox);
			textbox.nextSibling.nextSibling.setAttribute('oncommand', "uf_openColor('"+color+"','"+textbox.id+"');");
		}
	}
}catch(e) {
ufDump(e);
}
}

//**************************************
function ufSaveCRcolors() {
	var options = ufGetCRconvOptions();
	options.colors = {};
	if(ufCRconvPref.colors) {
		for(var i in ufCRconvPref.colors) {
			var val = document.getElementById('textb-'+i).value;
			options.colors[i] = val;
		}
	}
	/*var st = '('+ufSerialize(options)+')';
	//ufLog(st);
	ufSetCharPref("unifoxCRConverterOptions",st);*/
	ufSetCRconvOptions(options);
	return true;
}
//**************************************
function ufUpdateColorListener(event) {
try{
	var box = event.target;
	ufUpdateColor(box);
}catch(e) {
ufDump(e);
}
}
//**************************************
function ufUpdateColor(box) {
try{
	var color = box.value;
	var target = box.nextSibling;
	if(uf_isColor(color)) {
		//box.style.color = box.value;
		
		target.style.backgroundColor = color;
		target.value = ' ';
		//box.style.backgroundColor = color;
		//box.style.background = "#aa00aa url(image.jpg) no-repeat fixed center center";
		//box.style.color = color;
	} else {
		ufLog("not a color: "+color);
		target.style.backgroundColor = "transparent";
		target.value = '#';
	}
	
}catch(e) {
ufDump(e);
}
}

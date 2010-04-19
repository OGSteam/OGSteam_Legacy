function getclip()
{
	{
	var clip = Components.classes["@mozilla.org/widget/clipboard;1"]
		.createInstance(Components.interfaces.nsIClipboard);
	if (!clip) return false;

	var trans = Components.classes["@mozilla.org/widget/transferable;1"]
		.createInstance(Components.interfaces.nsITransferable);
	if (!trans) return false;
		trans.addDataFlavor("text/unicode");
		clip.getData(trans,clip.kGlobalClipboard);
	
	var str = new Object();
	var strLength = new Object();
		trans.getTransferData("text/unicode",str,strLength);
	
	var vNsString = str.value;
		vNsString.QueryInterface(Components.interfaces.nsISupportsString);
	
	document.getElementById("spyreport").value = RemovePoint(vNsString.data);
	}
}

function reload(){ status_timer = setInterval("getclip()", 2000);}
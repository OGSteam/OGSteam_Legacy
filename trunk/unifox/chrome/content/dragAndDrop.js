/*var listObserver = {
  onDragStart: function (event, transferData, action) {
    var txt = event.target.getAttribute("id");
    transferData.data = new TransferData();
    transferData.data.addDataForFlavour("text/unicode", txt);
  }
};
var boardObserver = {
  getSupportedFlavours : function () {
    var flavours = new FlavourSet();
    flavours.appendFlavour("text/unicode");
    return flavours;
  },
  onDragOver: function (evt,flavour,session){
  //session.test=evt.target;
  },
  onDrop: function (evt,dropdata,session){
    if (dropdata.data!=""){
	//alert(evt.target.label);
	uf_insertAlly(evt.target,dropdata.data);
      //var elem=document.createElement(dropdata.data);
	  //elem.label=dropdata.data;
   //   evt.target.appendChild(elem);
      //elem.setAttribute("left",""+evt.pageX);
     // elem.setAttribute("top",""+evt.pageY);
     // elem.setAttribute("label",session.test);
	//  elem.setAttribute("value",session.test);
	//  elem.setAttribute("style","color:white;background-color:black");
    }
  }
};*/

/**code from Greasemonkey */

function reorderList(from, to,listbox) {
  // make sure to and from are in range
  if (from < 0 || to < 0 ||
    from > listbox.length || to > listbox.length
  ) {
    return false;
  }

  

  // REORDER DISPLAY:
  var tmp = listbox.childNodes[from];
  listbox.removeChild(tmp);
  listbox.insertBefore(tmp, listbox.childNodes[to]);
  // fix the listbox indexes
  for (var i=0, node=null; node=listbox.childNodes[i]; i++) {
	  node.index=i;
  }

  // then re-select the dropped script
  listbox.selectedIndex = to;

  return true;
}


var dndObserver = {
  lastFeedbackIndex: null,

  getSupportedFlavours: function () {
    var flavours = new FlavourSet();
    flavours.appendFlavour("text/unicode");
    return flavours;
  },

  onDragStart: function (event, transferData, action) {
    if ('listitem' != event.target.tagName ) return false;

    transferData.data = new TransferData();
    transferData.data.addDataForFlavour("text/unicode", event.target.index);
  },

  onDragOver: function (event, flavour, session) {
	var listbox= event.target;
	if(listbox.tagName=='listitem')listbox=listbox.parentNode;
    if (listbox.selectedIndex == event.target.index) {
      this.clearFeedback(event);
      return false;
    }

    return this.setFeedback(event);
  },

  onDrop: function (event, dropdata, session) {
	var listbox= event.target;
	if(listbox.tagName=='listitem')listbox=listbox.parentNode;
  
    // clean up the feedback
    this.lastFeedbackIndex = null;
    this.clearFeedback(event);

    // figure out how to move
    var newIndex = this.findNewIndex(event);
    if (null === newIndex) return;
    var index = parseInt(dropdata.data);
    if (newIndex > index) newIndex--;

    // do the move
    reorderList(index, newIndex,listbox);
  },

  //////////////////////////////////////////////////////////////////////////////

  setFeedback: function(event) {
	var listbox= event.target;
	if(listbox.tagName=='listitem')listbox=listbox.parentNode;
  
    var newIndex = this.findNewIndex(event);

	var lastVisibleIndex=listbox.getIndexOfFirstVisibleRow()+parseInt(listbox.getAttribute('rows'));
	if(newIndex>=lastVisibleIndex && lastVisibleIndex<listbox.childNodes.length)
		{
		listbox.ensureIndexIsVisible(lastVisibleIndex+1);
		//alert(newIndex);
		//newIndex++;
		}
	else if(newIndex<=listbox.getIndexOfFirstVisibleRow() && listbox.getIndexOfFirstVisibleRow()>0)
	{
	listbox.ensureIndexIsVisible(listbox.getIndexOfFirstVisibleRow()-1);
	}
	//if(newIndex==listbox.getIndexOfFirstVisibleRow+listbox.rows)
    // don't do anything if we haven't changed
    if (newIndex === this.lastFeedbackIndex) return;
    this.lastFeedbackIndex = newIndex;

    // clear any previous feedback
    this.clearFeedback(event);

    // and set the current feedback
    if (null === newIndex) {
      return false;
    } else if (listbox.selectedIndex == newIndex) {
      return false;
    } else {
      if (0 == newIndex) {
        listbox.firstChild.setAttribute('dragover', 'top');
      } else if (newIndex >= listbox.childNodes.length) {
        listbox.lastChild.setAttribute('dragover', 'bottom');
      } else {
        listbox.childNodes[newIndex - 1].setAttribute('dragover', 'bottom');
      }
    }

    return true;
  },

  clearFeedback: function(event) {
	var listbox= event.target;
	if(listbox.tagName=='listitem')listbox=listbox.parentNode;
    for (var i = 0, el; el = listbox.childNodes[i]; i++) {
      el.removeAttribute('dragover');
    }
  },

  findNewIndex: function(event) {
	var listbox= event.target;
	if(listbox.tagName=='listitem')listbox=listbox.parentNode;
	
    var target = event.target;

    // not in the list box? forget it!
    if (listbox != target && listbox != target.parentNode) return null;

    var targetBox = target.boxObject
      .QueryInterface(Components.interfaces.nsIBoxObject);

    if (listbox == target) {
      // here, we are hovering over the listbox, not a particular listitem
      // check if we are very near the top (y + 4), return zero, else return end
      if (event.clientY < targetBox.y + 4) {
        return 0;
      } else {
        return listbox.childNodes.length;
      }
    } else {
      var targetMid = targetBox.y + (targetBox.height / 2);

      if (event.clientY >= targetMid) {
        return target.index + 1;
      } else {
        return target.index;
      }
    }

    // should never get here, but in case
    return null;
  }
};
/** end of Greasemonkey code*/
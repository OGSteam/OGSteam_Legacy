/**
 * @author Unibozu
 * @license GNU/GPL
 */

var Xtense = XgetMainInstance();
var log = [];

window.on('load', function() {
	window.on('keydown', function(e){ Log.keydown(e); } );
	window.on('keyup', function(e){ Log.keyup(e); } );
	$('left-panel').on('click', function(e) { if (!Log.control && e.button == 0) Log.unselect(e); });
	$('close').on('command', function(e){ Log.close(e); } );
	$('flush').on('command', function(e){ Log.flush(e); } );
	$('display-debug').on('click', function(e){ Log.displayDebug(e); } );
	$('extra').on('click', function(e){ if (e.button == 2) Log.extraContextMenu(e); });
	
	// Left panel (content) menu
	//$('left-menu').on('popupshowing', function(e) { Log.contentContextMenu(); });
	$('left-menu-copy-all').on('command', function(e){ Log.contentCopy(1); } );
	$('left-menu-copy-selected').on('command', function(e){ Log.contentCopy(0); } );
	
	// Right panel (extra) menu
	$('right-menu-copy-all').on('command', function(e){ Log.extraCopy(1); });
	$('right-menu-copy-hovered').on('command', function(e){ Log.extraCopy(0); });
	
	$('right-panel-caption').set('label', Xl('no row selected'));
	
	if (Xprefs.getBool('debug')) {
		$('display-debug').checked = true;
		Log.debug = true;
	}
	
	Log.init();
	Xtense.logOpen = true;
});

window.on('unload', function() {
	Xtense.logOpen = false;
});

var Log = {
	control : false,
	oneSelected : false,
	lastSelected : null,
	currentExtra: -1,
	selectedEntriesCount: 0,
	debug: false,
	extraElHovered: null,
	
	init : function() {
		try {
			//this.shift = false;
			this.control = false;
			
			this.timeFormat = Xprefs.getInt('log-time-format');
			var displayTime = Xprefs.getBool('log-display-time');
			
			$('content').empty();
			if(Xtense.CurrentTab==null)return;//si tous les onglets sont fermés, pas de journal
			log = Xtense.CurrentTab.log;
			
			if (log.length == 0) {
				var vbox = new Xel('vbox').addClass('empty').set('flex', '1');
				vbox.add(
					new Xel('spacer').set('flex', '1'),
					new Xel('label').set('value', Xl('empty log')),
					new Xel('spacer').set('flex', '1')
				);
				$('content').add(vbox);
			} else {
				var container = new Xel('vbox').set('flex', '1');
				$('content').add(container);
				
				for (var i = 0, len = log.length; i < len; i++) {
					var line = log[i], time = '';
					
					var row = new Xel('hbox').addClass(logClassName[line.type]).set('id', 'row-'+i).set('idx', i);
					row.on('context', function(e) {e.stopPropagation();});
					row.on('click', function(e){ Log.select(this.getAttribute('idx'), e); });
					
					if (displayTime) {
						row.add(new Xel('label').set('value', this.format_time(line.Date)).set('class', 'time').setText(this.format_time(line.Date)+' - '));
					}
					
					var desc = new Xel('description').set('flex', '1').setText(line.value);
					
					if (line.extra.calls) {
						row.add(new Xel('image').set('class', 'icon-top calls-'+line.extra.calls.status));
					}
					
					row.add(desc);
					container.add(row);
				}
				
				if (this.currentExtra != -1) {
					if (this.currentExtra > (log.length-1)) this.currentExtra = 0;
					
					//this.oneSelected = true;
					this.lastSelected = this.currentExtra;
					
					$('row-'+this.currentExtra).addClass('selected');
					$('row-'+this.currentExtra).selected = true;
					
					this.displayExtra();
				}
			}
			
			return;
		} catch (e) {
			show_backtrace(e);
		}
	},
	
	displayExtra: function (n) {
		if (typeof n == 'undefined') n = this.currentExtra;
		if (n == -1) return;
		this.currentExtra = n;
		var extra = log[n].extra;
		var panel = $('extra');
		panel.empty();
		
		var hasEntries = false;
		
		if (extra.calls) {
			hasEntries = true;
			panel.add(new Xel('label').set('value', Xl('title calls')).setText('- ' + Xl('title calls')).addClass('title', 'calls'));
			
			for (var i = 0, keys = ['success', 'warning', 'error']; i < 3; i++) {
				var type = keys[i];
				
				if (extra.calls[type].length != 0) {
					var row = new Xel('row').add(new Xel('label').set('value', Xl('call name '+type)).setText(Xl('call name '+type) + ' : '));
					var hbox = new Xel('hbox').set('style', 'display: block').set('flex', '1').set('class', 'callsList');
					
					for (var t = 0, len = extra.calls[type].length; t < len; t++) {
						var name = new Xel('label').set('value', extra.calls[type][t]).set('class', type);
						
						if (t != (len - 1)) {
							hbox.add(
								new Xel('hbox').add(
									name,
									new Xel('label').set('value', ', ')
								)
							);
						} else {
							hbox.add(name);
						}
					}
					
					panel.add(row.add(hbox));
				}
			}
			
			if (extra.calls.messages) {
				hasEntries = true;
				panel.add(new Xel('label').set('value', Xl('title call messages')).setText('- ' + Xl('title call messages')).addClass('title', 'messages'));
				
				for (var i = 0, keys = ['success', 'warning', 'error']; i < 3; i++) {
					var type = keys[i];
					
					for (var t = 0, len = extra.calls.messages[type].length; t < len; t++) {
						label = new Xel('label').addClass(type, 'message').setText(extra.calls.messages[type][t]);
						label.innerHTML = 
						panel.add(
							//new Xel('row').add(
								label
							//)
						);
					}
				}
			}
		}
		
		if (this.debug) {
			if (extra.url || extra.Request || extra.Response) {
				
				hasEntries = true;
				panel.add(new Xel('label').set('value', Xl('title debug data')).setText('- ' + Xl('title debug data')).addClass('title', 'debug'));
				
				if (extra.Request) {
					panel.add(
						new Xel('row').add(
							new Xel('label').set('value', Xl('sent data')).setText(Xl('sent data') + ' : '),
							new Xel('label').setText(extra.Request.postedData[extra.Server.n]).set('flex', '1')
						),
						
						new Xel('row').add(
							new Xel('label').set('value', Xl('server url')).setText(Xl('server url') + ' : '),
							new Xel('label').setText(extra.Server.url).set('flex', '1')
						),
						
						new Xel('row').add(
							new Xel('label').set('value', Xl('complete url')).setText(Xl('complete url') + ' : '),
							new Xel('label').setText(extra.Server.url+'?'+extra.Request.postedData[extra.Server.n]).set('crop', 'end')
						)
					);
				}
				
				if (extra.Response) 
					panel.add(
						new Xel('row').add(
							new Xel('label').set('value', Xl('response')).setText(Xl('response') + ' : '),
							new Xel('label').setText(extra.Response.content).set('flex', '1')
						)
					);
				
				if (extra.url)
					panel.add(
						new Xel('row').add(
							new Xel('label').set('value', Xl('url')).setText(Xl('url') + ' : '),
							new Xel('label').setText(extra.url).set('flex', '1')
						)
					);
			}
		}
		
		if (hasEntries) {
			$('right-panel-caption').set('label', Xl('caption infos'));
		} else {
			$('right-panel-caption').set('label', Xl('caption no extra data'));
		} 
		
	},
	
	displayDebug: function(e) {
		this.debug = e.target.checked;
		this.displayExtra();
	},
	
	keydown: function(e) {
		if (e.keyCode == 17) this.control = true;
	},
	
	keyup: function(e) {
		if (e.keyCode == 17) this.control = false;
	},
	
	select: function(n, e) {
		try {
			e.stopPropagation();
			//if (e.button != 0) return; // Right click
			var len = log.length;
			
			if (!this.control) {
				this.unselect();
			} else {
				if ($('row-'+n).selected) {
					$('row-'+n).delClass('selected');
					$('row-'+n).selected = false;
					this.selectedEntriesCount --;
				} else {
					$('row-'+n).addClass('selected');
					$('row-'+n).selected = true;
					this.selectedEntriesCount ++;
				}
				
				this.contentContextMenu();
				return;
			}
			
			$('row-'+n).addClass('selected');
			$('row-'+n).selected = true;
			this.selectedEntriesCount ++;
			
			this.displayExtra(n);
			// Empecher des problèmes de synchro avec le menu et le comptage des lignes selectionnées (menu affiché avant le comptage)
			this.contentContextMenu();
			return;
		} catch (e) {
			show_backtrace(e);
		}
	},
	
	unselect: function() {
		if (this.selectedEntriesCount == 0) return;
		
		for (var i = 0, len = log.length; i < len; i++) {
			$('row-'+i).delClass('selected');
			$('row-'+i).selected = false;
		}
		
		this.currentExtra = -1;
		this.selectedEntriesCount = 0;
		
		$('extra').empty();
		$('right-panel-caption').set('label', Xl('no row selected'));
	},
	
	contentContextMenu: function(e) {
		$('left-menu-copy-all').disabled = (log.length == 0);
		$('left-menu-copy-selected').disabled = (Log.selectedEntriesCount == 0);
	},
	
	extraContextMenu: function(e) {
		var el = e.target;
		
		$('right-menu-copy-all').disabled = ($('extra').childNodes.length == 0);
		
		if (el.tagName == 'rows') {
			this.extraElHovered = null;
			$('right-menu-copy-hovered').disabled = true;
			return;
		}
		
		while (el.parentNode.tagName != 'rows') el = el.parentNode;
		this.extraElHovered = el;
		$('right-menu-copy-hovered').disabled = false;
	},
	
	extraCopy: function(copyAll) {
		try {
			if (!copyAll) {
				if (this.extraElHovered) Xclipboard(this.extraElHovered.textContent);
				return;
			}
			
			for (var i = 0, len = $('extra').childNodes.length, text = ''; i < len; i++) {
				text += $('extra').childNodes[i].textContent + '\n';
			}
			
			Xclipboard(text);
		} catch (e) {
			show_backtrace(e);
		}
	},
	
	contentCopy: function(copyAll) {
		try {
			
			for (var i = 0, len = log.length, text = ''; i < len; i++) {
				if ($('row-'+i).selected || copyAll) text += $('row-'+i).textContent + '\n';
			}
			
			Xclipboard(text);
		} catch (e) {
			show_backtrace(e);
		}
	},
	
	format_time: function (Date) {
		var month = Date.getMonth() + 1, d = Date.getDay(), h = Date.getHours(), m = Date.getMinutes(), s = Date.getSeconds();
		
		if (d < 10) d = '0' + d;	if (month < 10) month = '0' + month;
		if (h < 10) h = '0' + h;	if (m < 10) m = '0' + m;	if (s < 10) s = '0' + s;
		
		if (this.timeFormat == 0) return h + ':' + m; 
		else if (this.timeFormat == 1) return h + ':' + m + ':' + s
		return month + '/' + d + ' ' + h + ':' + m + ':' + s;
	},
	
	flush: function() {
		try {
			Xtense.CurrentTab.log = [];
			var childs = $('content').childNodes;
			for (var i = childs.length-1; i >= 0; i--) $('content').removeChild(childs[i]);
			
			var vbox = new Xel('vbox').set('class', 'empty').set('flex', '1');
			vbox.add(
				new Xel('spacer').set('flex', '1'),
				new Xel('label').set('value', 'Journal vide'),
				new Xel('spacer').set('flex', '1')
			);
			$('content').add(vbox);
		} catch (e) {
			show_backtrace(e);
		}
	},
	
	close: function () {
		window.close();
	}
};

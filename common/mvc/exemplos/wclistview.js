WcListView = new Object(
{
	init: function(table_name, options) {
		var obj_name = table_name + '_lv';
		window[obj_name] = new Object({
			selected: null,
			order_input: null,
			colResize: false,
			startX: 0,
			resizing: false,
			hResize: null,
			bResize: null,
			up: function() {
				if (this.selected == null)
					return;
				idx = this.selected.rowIndex;
				if (idx == 0)
					return;
				this.table.removeChild(this.selected);
				var tr2 = this.table.rows[idx - 1];
				this.table.insertBefore(this.selected, tr2);
				if (this.sel_input)
					document.getElementById(this.sel_input).value = this.selected.rowIndex;
				this.updateOrder();
			},
			
			down: function() {
				if (this.selected == null)
					return;
				idx = this.selected.rowIndex;
				this.table.removeChild(this.selected);
				if (idx < (this.table.rows.length - 1)) {
					var tr2 = this.table.rows[idx + 1];
					this.table.insertBefore(this.selected, tr2);
				} else {
					this.table.appendChild(this.selected);
				}
				if (this.sel_input)
					document.getElementById(this.sel_input).value = this.selected.rowIndex;
				this.updateOrder();
			},
			
			select: function(row) {
				var elem;
				if (!window.event) {
					elem = row.target;
				} else {
					elem = window.event.srcElement;
				}
				row = elem.parentNode;
				if (this.selected != row) {
					if (elem && elem.tagName != 'TD' && elem.tagName != 'td')
						// clicks on controls should not select anything
						return;
					if (this.selected)
						this.selected.className = '';
					row.className = 'selected';
					this.selected = row;
				}
				if (this.sel_input)
					document.getElementById(this.sel_input).value = row.rowIndex;
			},
			updateOrder: function() {
				if (this.order_input != null) {
					var order_str = '';
					for (i = 0; i < this.table.rows.length; i++) {
						if (i != 0)
							order_str += ',';
						order_str += this.table.rows[i].getAttribute('wc_idx');
					}
					document.getElementById(this.order_input).value = order_str;
				}
			},
			startResize: function(col) {
				// Browser compat.
				var event;
				if (!window.event) {
					// FF
					event = col;
					col = event.target;
				} else {
					event = window.event;
					col = event.srcElement;
				}
				//
				// Locate elements.
				//
				this.hResize = col.parentNode.cells[col.cellIndex - 1];
				this.bResize = this.table.parentNode.firstChild;
				while (this.bResize && !this.bResize.tagName)
					this.bResize = this.bResize.nextSibling;
				if (this.bResize) {
					this.bResize = this.bResize.childNodes[(col.cellIndex - 1) / 2];
				}
				
				// Save state and replace handlers
				this.startX = event.clientX;
				this.oldmouseup = document.onmouseup;
				this.oldmousemove = document.onmousemove;
				if (!window.event) {
					this.startH = this.hResize.offsetWidth;
					this.startB = this.bResize.offsetWidth;
					document.onmousemove = function(e) { window[obj_name].doResize(e); }
				} else {
					this.startH = this.hResize.style.pixelWidth;
					this.startB = this.bResize.style.pixelWidth;
					document.onmousemove = function() { window[obj_name].doResize(null); }
				}
				document.onmouseup = function() { window[obj_name].endResize(); }
				// we're done
				this.resizing = true;
			},
			
			doResize: function(e) {
				if (e == null)
					e = window.event;
				if (this.resizing) {
					this.bResize.style.width = ''+ (this.startB + e.clientX - this.startX) + 'px';
					this.hResize.style.width = ''+ (this.startH + e.clientX - this.startX) + 'px';
				}
			},
			endResize: function() {
				if (this.resizing) {
					this.resizing = false;
					document.onmousemove = this.oldmousemove;
					document.onmouseup = this.oldmouseup;
				}
			}
		});
		var sel_idx = '';
		window[obj_name].table = document.getElementById(table_name).tBodies[0];
		if (options != null) {
			if (options.upButton)
				document.getElementById(options.upButton).onclick = function() { window[obj_name].up(); };
			if (options.downButton)
				document.getElementById(options.downButton).onclick = function() { window[obj_name].down(); };
			if (options.selInput) {
				window[obj_name].sel_input = options.selInput;
				sel_idx = document.getElementById(options.selInput).value;
			}
			if (options.orderInput)
				window[obj_name].order_input = options.orderInput;
			if (options.colResize == true) {
				// we need to find the header table first. We will go up to the second div and then down to
				// the first table.
				var head_row = window[obj_name].table.parentNode.parentNode.parentNode.firstChild.firstChild.rows[0];
				var l = head_row.cells.length;
				for (i = 0; i < l; i++) {
					var oresize = document.createElement("TD");
					oresize.style.cssText = 'width: 3px; cursor: col-resize; background-color: #909090;';
					if (window.event != null)
						oresize.onmousedown = function() { window[obj_name].startResize(this); }
					else
						oresize.onmousedown = function(e) { window[obj_name].startResize(e); }
					if (i < (l - 1))
						head_row.insertBefore(oresize, head_row.cells[i*2 + 1]);
					else
						head_row.insertBefore(oresize);
				}
				window[obj_name].colResize = options.colResize;
			}
		}
				
		for (i = 0; i < window[obj_name].table.rows.length; i++) {
			var row = window[obj_name].table.rows[i];
			if (window.event != null)
				row.onmousedown = function() { window[obj_name].select(this); };
			else
				row.onmousedown = function(e) { window[obj_name].select(e); }
			if (i == sel_idx) {
				row.className = 'selected';
				window[obj_name].selected = row;
			}
		}
	}
});

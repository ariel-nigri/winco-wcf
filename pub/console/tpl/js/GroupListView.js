function GroupListView(htmlTable) {
	this.htmlTable = htmlTable;
	this.dataFormat = null;
	this.data = [];
	this.rawData = null; // if in grouping or filtering mode, this has the original rawData.
	this.headers = null;
	this.sort_field = null;
	this.sort_up = false;
	this.id_field = null;
	this.selected_row = null;
	this.selected_id = null;
	this.selected_group = null;
	this.htmlTable.style.cursor = 'default';
	this.onclick = null;
	this.ondblclick = null;
	this.group_col = null;
	this.filter_col = null;
	this.filter_val = null;
	this.paginate=false;
	this.pager;
	this.newOffset=0;
	this.offset;
	this.newMaxRows=0;
	this.maxRows;
	this.columnResize = true;
	
	
	var myself = this;
	this.htmlTable.tBodies[0].onclick = function(e) { myself.selectrow(e, this); }
	this.htmlTable.tBodies[0].ondblclick = function(e) { myself.dblclick(e); return false; }

	// data template? nao....
	// this.dataTemplate = htmlTable.tBodies[0].getElementsByTagName('TR').item(0);
	// this.dataTemplate.parentNode.removeChild(this.dataTemplate);
	
	GroupListView.prototype.setDataFormat = function(formatArray) {
		
		//clean table
		while (this.htmlTable.tHead.firstChild) {
			this.htmlTable.tHead.removeChild(this.htmlTable.tHead.firstChild);
		}
		this.clear()
		
		for (i = 0; i < formatArray.length; i++) {
			if (formatArray[i].id == true) {
				this.id_field = i;
			}
			if (formatArray[i].type)
				formatArray[i].sortFunction = function(a,b) { return a - b; }
			else
				formatArray[i].sortFunction = function(a,b) { return a.localeCompare(b); }
		}
		this.dataFormat = formatArray;
	}
	GroupListView.prototype.setHeaders = function(headerArray) {
		hdr = this.htmlTable.tHead;
		if (hdr.firstChild)
			hdr.removeChild(hdr.firstChild, true);
		var hrow = document.createElement('tr');
		for (i = 0; i < headerArray.length; i++) {
			var th = document.createElement('th');
			var width = this.dataFormat[headerArray[i]].width;
			if (typeof(width) == 'undefined')
				width = '100';
			th.style.width =  '' + width + 'px';
//			th.innerHTML = '<div class="label">'+this.dataFormat[headerArray[i]].label+'</div><div class="resizer" onmousedown="resizing.startResize(event, \'h\', this.parentNode);"></div>'; // versao antiga, nao funfa no FIrefox
			if(this.columnResize){
				th.innerHTML = '<div class="resizer" onmousedown="resizing.startResize(event, \'h\', this.parentNode)"><div class="label">'+this.dataFormat[headerArray[i]].label+'</div></div>';
			}else{
				th.innerHTML = '<div><div class="label">'+this.dataFormat[headerArray[i]].label+'</div></div>';
			}
			var x = this;
			th.setAttribute('data-col', headerArray[i]);
			th.onclick = function(e) { x.clickToSort(e, this); }
			hrow.appendChild(th);
		}
		hdr.appendChild(hrow);
		this.headers = headerArray;
	}	
	GroupListView.prototype.clickToSort = function(event, th) {
		var el;
		if (window.event) {
			event = window.event;
			el = event.srcElement;
		} else
			el = event.target;
		if (el.className != 'label')
			return;
		var th = el.parentNode.parentNode;
		if (this.sort_field != null) {
			// ja tinha uma coluna 'sorted' vamos tirar o estilo.
			var thlist = th.parentNode.getElementsByTagName('TH');
			for (i = 0; i < thlist.length; i++)
				thlist.item(i).className = '';
		}
		var col = parseInt(th.getAttribute('data-col'));
		var direction = (col == this.sort_field ? !this.sort_up : true);
		th.className = direction ? 'sel_up' : 'sel_down';
		this.setSorting(col, direction);
		var newdata = this.data;
		this.clear();
		this.sync(newdata);
		if(this.paginate){
			this.pager.goToPage(1);
		}
	}
	GroupListView.prototype.setSorting = function(col, ascending) {
		this.sort_field = col;
		this.sort_up = ascending;
		var sort_func1 = this.dataFormat[col].sortFunction;
		var sort_func2 = null;
		if (this.id_field != null) {
			var id_field = this.id_field;
			var sort_func2 = this.dataFormat[this.id_field].sortFunction;
		}
		
		this.sortFunction = function(a, b) {
			var r = sort_func1(a[col], b[col]);
			if (r == 0 && sort_func2)
				r = sort_func2(a[id_field], b[id_field]);
			return (ascending ? r : -r);
		}
	}
	GroupListView.prototype.setGrouping = function(col_idx) {
		this.group_col = col_idx;
		this.filter_col = null;
		this.selected_group = null; // no selected group so far..
		this.selected_id = null; // cannot keep selection anymore...
		
		var rawData = this.rawData? this.rawData : this.data;
		this.clear();
		this.sync(rawData);
	}
	
	GroupListView.prototype.setFilter = function(col_idx, value) {
		this.filter_col = col_idx;
		this.filter_val = value;
		this.group_col = null;
		this.selected_id = null; // cannot keep selection anymore...

		var rawData = this.rawData? this.rawData : this.data;
		this.clear();
		this.sync(rawData);
	}
	
	GroupListView.prototype.filterData = function(rawData) {
		var result_data = [];

		var idx = 0;		
		for (var i = 0; i < rawData.length; i++) {
			if (rawData[i][this.filter_col] == this.filter_val)
				result_data[idx++] = rawData[i];
		}
		this.rawData = rawData;
		return result_data;
	}

	GroupListView.prototype.groupData = function(rawData) {
		this.rawData = rawData;
		var result_data = [];
		var idx = 0;
		var grp_array = [];
		
		for (var i = 0; i < rawData.length; i++) {
			var pos = grp_array[rawData[i][this.group_col]];
			if (typeof(pos) == 'undefined') {
				// new entry
				result_data[idx] = rawData[i].slice(0); // TRICK: this will copy all items of the array instead of simpy passing the reference.
				grp_array[rawData[i][this.group_col]] = idx;
				++idx;
			} else {
				// old entry we must add all values.
				for (var j = 0; j < this.dataFormat.length; j++) {
					if (this.dataFormat[j].type == 'quantity')
						result_data[pos][j] = parseInt(result_data[pos][j]) +  parseInt(rawData[i][j]);
					else {
						if (result_data[pos][j] != rawData[i][j])
							result_data[pos][j] = '(...)';
					}
				}
			}
		}
		return result_data;
	}
	
	GroupListView.prototype.selectrow = function(event, row) {
		var el;
		if (window.event) {
			event = window.event;
			el = event.srcElement;
		} else
			el = event.target;
		if (el.tagName == 'TD')
			el = el.parentNode;
		if (el.tagName != 'TR')
			return;
		if (this.selected_row) {
			this.selected_row.style.backgroundColor = '';
			this.selected_row.style.color = '';
			this.selected_row.className = '';
		}
		el.style.backgroundColor = 'blue';
		el.style.color = 'white';
		el.className = 'selected';
		this.selected_row = el;
		if (this.group_col != null)
			this.selected_group = this.data[el.sectionRowIndex][this.group_col];
		if (this.id_field != null) {
			this.selected_id = this.data[el.sectionRowIndex][this.id_field];
		}
		if (this.onclick)
			this.onclick(el.sectionRowIndex, this.selected_id);
	}
	
	GroupListView.prototype.dblclick = function(event) {
		if (this.ondblclick) {
			if (document.selection && document.selection.empty) {
				document.selection.empty();
			} else if (window.getSelection) {
				var sel = window.getSelection();
				sel.removeAllRanges();
			}

			var el;
			if (window.event) {
				event = window.event;
				el = event.srcElement;
			} else
				el = event.target;
			if (el.tagName == 'TD')
				el = el.parentNode;
			if (el.tagName != 'TR')
				return;
			this.ondblclick(el.sectionRowIndex, this.selected_id);
		}
	}
	
	GroupListView.prototype.clear = function() {
		while (this.htmlTable.tBodies[0].rows.length > 0)
			this.htmlTable.tBodies[0].removeChild(this.htmlTable.tBodies[0].firstChild, true);
		this.data = [];
	}
	
	GroupListView.prototype.sync = function(_newdata) {
		var newdata;
		if (this.group_col != null)
			newdata = this.groupData(_newdata);
		else if (this.filter_col != null)
			newdata = this.filterData(_newdata);
		else {
			this.rawData = null;
			newdata = _newdata;
		}
		if (this.sort_field != null)
			newdata.sort(this.sortFunction);
		var olddata = this.data
		if(this.paginate){
			olddata=olddata.slice(this.offset,this.offset+this.maxRows);
		}	
		this.data = newdata;
		// cannot save the sliced array, or the filer and pager wont work!
		if(this.paginate){
			newdata=newdata.slice(this.newOffset,this.newOffset+this.newMaxRows);
			this.offset=this.newOffset;
			this.maxRows=this.newMaxRows
			
		}
		var oi = 0, ni = 0;
		var finished = false;
		this.selected_row = null; // we will tag the correct row when we see it.
		while (true) {
			var cmp;
			// after using sort(this.sortFunction), IE8 and IE7 messes up the
			// array so the property length cannot be trusted anymore.
			// therefore, we will check for the end of array by examining
			// the existence of the element at the specified index.
			if (!olddata[oi]) {
				if (!newdata[ni])
					break;
				else
					cmp = -1;
			}
			else if (!newdata[ni])
				cmp = 1;
			else {
				cmp = this.sortFunction(newdata[ni], olddata[oi]);
			}
			var targetRow = this.htmlTable.tBodies[0].rows[ni];
			if (typeof(targetRow) == 'undefined')
				targetRow = null;
			if (cmp < 0) {
				// new element, lets insert
				var newRow = document.createElement('tr');
				if (this.id_field != null && newdata[ni][this.id_field] == this.selected_id) {
					newRow.className = 'selected';
					newRow.style.backgroundColor = 'blue';
					newRow.style.color = 'white';
					this.selected_row = newRow;
				}
				for (j = 0; j < this.headers.length; j++) {
					var td = document.createElement('td');
					var val = newdata[ni][this.headers[j]];
					if (this.dataFormat[this.headers[j]].type == 'quantity') {
						val = parseFloat(val);
						if (val > 1000000)
							val = (val / 1000000).toFixed(1) + 'M';
						else if (val > 1000)
							val = (val / 1000).toFixed(1) + 'k';
					}else if(this.dataFormat[this.headers[j]].type == 'time_s') {
						val = parseFloat(val);
						var h =  Math.floor(val/3600);
						var m =  Math.floor((val%3600)/60);
						var s =val-(h*3600)-(m*60);
						if (m <10) {m="0"+m;}
						if (s < 10) {s="0"+s;}
						val=(h+":"+m+":"+s);
					}

					td.innerHTML = val;
					newRow.appendChild(td);
				}
				this.htmlTable.tBodies[0].insertBefore(newRow, targetRow);
				++ni;
			} else if (cmp > 0) {
				// deleted element.
				targetRow.parentNode.removeChild(targetRow);
				++oi;
			} else {
				// same element, we will just update it.
				var cells = targetRow.getElementsByTagName('TD');
				for (j = 0; j < cells.length; j++) {
					var dpos = this.headers[j];
					if (this.dataFormat[dpos].sync) {
						var val = newdata[ni][dpos];
						if (this.dataFormat[dpos].type == 'quantity') {
							val = parseFloat(val);
							if (val > 1000000)
								val = (val / 1000000).toFixed(1) + 'M';
							else if (val > 1000)
								val = (val / 1000).toFixed(1) + 'k';
						}else if(this.dataFormat[dpos].type == 'time_s') {
							val = parseFloat(val);
							var h =  Math.floor(val/3600);
							var m =  Math.floor((val%3600)/60);
							var s =val-(h*3600)-(m*60);
							if (m <10) {m="0"+m;}
							if (s < 10) {s="0"+s;}
							val=(h+":"+m+":"+s);
						}
						cells.item(j).innerHTML = val;
					}
				}
				if (this.id_field != null && newdata[ni][this.id_field] == this.selected_id)
					this.selected_row = targetRow;
				++ni;
				++oi;
			}
		}
		if (!this.selected_row) // the selected row is gone.
			this.selected_id = null;
	}
}

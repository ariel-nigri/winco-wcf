
/*

function disableSelection(target){
if (typeof target.onselectstart!="undefined") //IE route
	target.onselectstart=function(){return false}
else if (typeof target.style.MozUserSelect!="undefined") //Firefox route
	target.style.MozUserSelect="none"
else //All other route (ie: Opera)
	target.onmousedown=function(){return false}
target.style.cursor = "default"
}
*/
	
window.resizing = ({
	element: null,
	element2: null,
	oldmouseup: null,
	oldmousemove: null,
	startX: 0,
	startY: 0,
	startW: 0,
	startH: 0,
	type: '',
	onmousemove: function(e) {
		if (this.element == null)
			return;
		if (e == null)
			e = window.event;
			
		/* IE hack: if the mouse is over some control, even with a lower z-index we loose the event. we should probably use the alpha channel
		   but I'm afraid it will not work on some browsers, so we check for a pressed button.
  		we check if the button was released. problem is that this triggers Chrome as well, so we check for event.which */
		if (window.event && event.button == 0 && typeof(event.which) == 'undefined') {
			this.endResize();
			return;
		}
		if (this.type == 'v') {
			var newHeight = this.startH + (e.clientY - this.startY);
			if (newHeight < 0)
				newHeight = 0;
			this.element.style.height = parseInt(newHeight) + 'px';
			if (this.element2)
				this.element2.style.height = parseInt(newHeight) + 'px';
		} else {
			var newWidth = this.startW + (e.clientX - this.startX);
			if (newWidth < 0)
				newWidth = 0;
			this.element.style.width = parseInt(newWidth) + 'px';
			if (this.element2)
				this.element2.style.width = parseInt(newWidth) + 'px';
		}
	},
	
	onmouseup: function(e) {
		if (e == null)
			e = window.event;
		this.endResize();
	},
	startResize: function(evt, type, col, col2) {
		// Browser compat.
		var event = (window.event ? window.event : evt);
		
		// Save state and replace handlers
		this.element = typeof(col) == 'object' ? col : document.getElementById(col);
		this.element2 = typeof(col2) == 'object' ? col2 : (typeof(col2) == 'undefined' ? null : document.getElementById(col2));
		this.oldmouseup = document.onmouseup;
		this.oldmousemove = document.onmousemove;
		this.oldselectstart = document.onselectstart;
		this.startX = event.clientX;
		this.startY = event.clientY;
		if (type == 'v' || type == 'V')
			this.type = 'v';
		else
			this.type = 'h';
		if (window.getComputedStyle) {
			// computed style rules!
			this.startW = parseInt(window.getComputedStyle(this.element, null).getPropertyValue('width'));
			this.startH = parseInt(window.getComputedStyle(this.element, null).getPropertyValue('height'));
		} else {
			// for IE 7 and 8, this is the best I could come up with. Not sure if this can go wrong yet.
			var border = parseInt(this.element.currentStyle.paddingLeft) + parseInt(this.element.currentStyle.paddingRight);
			this.startW = this.element.scrollWidth - border;
			borderH = parseInt(this.element.currentStyle.paddingTop) + parseInt(this.element.currentStyle.paddingBottom);
			this.startH = this.element.scrollHeight - border;
		}
		document.onmouseup = function(e) { resizing.onmouseup(e); }
		document.onmousemove = function(e) { resizing.onmousemove(e); }
		//if (typeof document.style.MozUserSelect!="undefined") //Firefox route
			//this.element.style.MozUserSelect = 'none';
		document.onselectstart = function() { return false; }
		return false;
	},
	/* 
	   This version will create a transparent div over all the document to allow capture of all mouse events
	    even when the cursor is over a frame or iframe object. If this proves to work always, we will remove the old function.
	*/
	startResizeEx: function(event, type, element, element2) {
		if (event.preventDefault) // for mozilla, this will stop the mousedown from causing a "mouse capture" on the wrong element.
			event.preventDefault();
		var alldiv = document.createElement('DIV');
		alldiv.setAttribute('id', 'resizing_div');
//		alldiv.innerHTML = '<img src="../imgs/logo_wnc6.png" style="width: 100%; height: 100%;" />'
		if (type == 'v' || type == 'V')
			//alldiv.style.cssText = 'background: url(../imgs/logo_wnc6.png) ;position: absolute; top: 0px; left: 0px; width: 100%; height: 300px; cursor: row-resize; z-index: 1000';
			alldiv.style.cssText = 'position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; cursor: row-resize; z-index: 1000';
		else
			alldiv.style.cssText = 'position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; cursor: col-resize; z-index: 1000';
		document.body.appendChild(alldiv);
		this.startResize(event, type, element, element2);
		var oldEndResize = this.onEndResize;
		this.onEndResize = function() {
			var el = document.getElementById('resizing_div');
			el.parentNode.removeChild(el, true);
			this.onEndResize = oldEndResize;
			if (this.onEndResize)
				this.onEndResize(this.element);
		}
	},
	
	endResize: function() {
		document.onmouseup = this.oldmouseup;
		document.onmousemove = this.oldmousemove;
		document.onselectstart = this.oldselectstart;
		if (this.onEndResize)
			this.onEndResize(this.element);
		this.element = null;
	}
	/*hookElement: function(el) {
		var handle = document.CreateElement('div')
	}*/
});


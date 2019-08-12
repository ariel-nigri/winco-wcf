function XHRUpdater(url, interval) {
	this.url = url;
	this.interval = interval;
	try {
		this.request = new XMLHttpRequest();
	} catch (trymicrosoft) {
		try {
			this.request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (othermicrosoft) {
			try {
				this.request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (failed) {
				request = false;
			}  
		}
	}

	if (!this.request)
		alert("Error initializing XMLHttpRequest!");

	XHRUpdater.prototype.start = function() {
		this.request.open('GET', this.url, true);
		// 'this' is reserved, so we must call ourselves x to use inside the closure
		var x = this;
		this.request.onreadystatechange = function() { x.statechange(); }
		this.request.send(null);
	}
	XHRUpdater.prototype.statechange = function() {
		if (this.request.readyState != 4)
			return;
		if (this.request.status == 200) {
			this.onUpdate(this.request);
		}
		// 'this' is reserved, so we must call ourselves x to use inside the closure
		var x = this;
		if (this.interval)
			setTimeout(function() { x.start(); }, this.interval); 
	}
	XHRUpdater.prototype.stop = function() {
		//this.request.abort();
		this.request = null;
	}
}

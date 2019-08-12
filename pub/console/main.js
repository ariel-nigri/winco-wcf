function $(id) { return document.getElementById(id); } // helper copied from jQuery

// State variables.
var instance = '';
var service = '';

// Forms main function (called on body onload()
function init() {		
	window.onresize = fix_sizes;
	window.resizing.onEndResize = fix_sizes;	
	fix_sizes();
	
	if (service == '')
		service = 'ADMIN'; // default screen
	load_service(service, '');	
}

/* Layout management */
function fix_sizes() {
	var newHeight = document.body.offsetHeight - $('nav').offsetHeight;	
	$('tree_iframe').style.height = newHeight + 'px';
	$('main_iframe').style.height = newHeight + 'px';
}

function load_service(service, inst) {
	window.instance = inst;
	window.service = service;
	
	switch (service) {
	case '':
		// error, dont do anything...
		break;	
	default:
		$('main_iframe').src = 'status.phtml?service=' + service + '&instance=' + escape(inst);
	}
}
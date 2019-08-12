function $(id) { return document.getElementById(id); }

var currSel = null;

function select(el) {
	
	if (direct_link_sel != '') {
		$(direct_link_sel+'_img').src = 'tpl/imgs/'+direct_link_sel+'.png';
		$(direct_link_sel+'_txt').className = "text";
		direct_link_sel = '';
		direct_link_el = null;
	}
	
	var svcname;
	if (currSel != null) {
		svcname = currSel.getAttribute('id').split(':')[0];		
		if (currSel.getAttribute('data-status') != 'RUNNING')
			currSel.className = 'disabled';
		else
			currSel.className = '';
	}
	
	sname = el.getAttribute('id').split(':')[0];		
	if (el.getAttribute('data-status') != 'RUNNING')
		el.className = 'stopped';
	else
		el.className = el.className + ' selected';
	
	var svcname = el.getAttribute('id').split(':')[0];
	currSel = el;
}

function load_service(el, svc, inst) {
	select(el);
	if (parent != window)
		parent.load_service(svc,inst);
}

var direct_link_sel = '';
var direct_link_el = null;

function direct_link(el, svc, inst) {
	
	if (direct_link_sel != '') {
		$(direct_link_sel+'_img').src = 'tpl/imgs/'+direct_link_sel+'.png';
		$(direct_link_sel+'_txt').className = "text";
	}
	
	direct_link_sel = svc;
	direct_link_el = el;
	
	if (currSel != null) {
		svcname = currSel.getAttribute('id').split(':')[0];		
		if (currSel.getAttribute('data-status') != 'RUNNING')
			currSel.className = 'disabled';
		else
			currSel.className = '';
	}
	currSel = null;
	
	$(svc+'_img').src = 'tpl/imgs/'+svc+'_SEL.png';	
	$(svc+'_txt').className = "selected_link";
	
	parent.load_service(svc, inst);
}

function openclose(el, header_id) {	
	
	var nel = el.nextSibling;
		
	if (typeof(nel.tagName) == 'undefined')
		nel = nel.nextSibling;
	if (nel.style.display == 'none') {
		$(header_id+'_img').src = 'tpl/imgs/'+header_id+'_SEL.png';
		if ($(header_id+'_add')) {
			$('dd_'+header_id).className = "addSvcMenu";
			$('dd_'+header_id).onclick = function(event) { showDropDown(event, this); }
		}
		nel.style.display = '';
	} else {
		$(header_id+'_img').src = 'tpl/imgs/'+header_id+'.png';
		if ($(header_id+'_add')) {
			$('dd_'+header_id).className = "addSvcMenu hidden";
			$('dd_'+header_id).onclick = "";
		}
		nel.style.display = 'none';
	}
}

function createGroup(svc_properties) {
	var grp = document.createElement('DIV');
	grp.className = 'service_group';
	grp.setAttribute('id', svc_properties.group);
	
	var click = ''
	if (svc_properties.idgroup != svc_properties.service) {
		click = 'openclose(this, \''+svc_properties.idgroup+'\');';
	} else {
		click = 'direct_link(this, \''+svc_properties.service+'\', \''+svc_properties.instance+'\');';
	}
			
	grp.innerHTML = '<div class="group_header" onclick="'+click+'">'+
						'<span class="img">'+
							'<img id="'+svc_properties.idgroup+'_img" src="tpl/imgs/'+svc_properties.idgroup+'.png">'+
						'</span>'+
						'<span id="'+svc_properties.idgroup+'_txt" class="text">'+svc_properties.group+'</span>'+
					'</div>'+					
					'<div class="grp_content" style="display: none;">'+
					'</div>';
			
	$('env').appendChild(grp);
	return grp;
}

function createSvcinst(grp, service, spaces) {
	var instance = service.service+':'+service.instance;
	var svclink = document.createElement('A');
	svclink.setAttribute('id', instance);
	svclink.setAttribute('href', '#none');
	svclink.setAttribute('data-status', service.status);
	svclink.onclick = function() {
		load_service(this, service.service, service.instance);
		return false;
	}
	switch (service.status) {
	case 'RUNNING':
		break;
	default:
	//case 'ERROR':
		svclink.className = 'disabled';
		break;
	}
	svclink.innerHTML = spaces+service.label;
	grp.appendChild(svclink);
	return svclink;
}

function refresh_list() {

	// le os servicos e seleciona a primeira opcao.
	xhr = new XHRUpdater('services_feed.php?cache_bust='+(new Date().getTime()));
	xhr.onUpdate = function(request) {
		
		response = eval(request.responseText);	
		services = response[0].running;
		
		// erase all services, but save the selected ID
		var currId = null;
		if (currSel) {
			currId = currSel.getAttribute('id');
			currSel = null;
		}
		
		var groups = document.getElementsByTagName('DIV');
		for (i = 0; i < groups.length; i++) {
			if (groups[i].className == 'grp_content') {
				while (groups[i].firstChild)
					groups[i].removeChild(groups[i].firstChild);
			}
		}
		
		// sync the new services.
		for (i = 0; i < services.length; i++) {				
			var grp = $(services[i].group);
			if (grp == null)				
				grp = createGroup(services[i]);
					
			if (services[i].idgroup != services[i].service) {
				var svcinst = createSvcinst(grp.lastChild, services[i], '');			
				
				if (currId != null) {
					if (svcinst.getAttribute('id') == currId) {
						select(svcinst);
						var grpIsOpen = grp.firstChild.className == 'group_header';
						if (!grpIsOpen)
							openclose(grp.firstChild, services[i].idgroup);
					}
				} else if (i == 0) {
					openclose(grp.firstChild, services[i].idgroup);
					select(svcinst);
				}
			} else {
				if (direct_link_sel != "")
					direct_link(direct_link_el, direct_link_sel, direct_link_sel);
				else if (currId == null && i == 0)
					direct_link(grp, services[i].idgroup, '')
			}
		}
	}
	xhr.start();
}

function init() {
	refresh_list();
	parent.services_window = window;
}
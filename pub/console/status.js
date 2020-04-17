function $(id) { return document.getElementById(id); } // helper copied from jQuery

// State variables
var instance = '';
var service = '';
var list_obj_id = '';
var list_obj_edit = false;
var list_obj_del = false;

function set_list_actions(id, list_actions, list){
	var amenu = $(id);
	var al = $(list);
	while (al.firstChild)
		al.removeChild(al.firstChild);
	list_obj_id = ''; // nada pode 'continuar selecionado'
	if (list_actions.length > 0)
		amenu.style.display = '';
	else
		amenu.style.display = 'none';
	for (i = 0; i < list_actions.length; i++) {
		var cmd = list_actions[i].cmd;
		if (cmd == 'EDIT')
			list_obj_edit = true;
		else if (cmd == 'DEL')
			list_obj_del = true;	
		var item = document.createElement('a');
		item.setAttribute('href', '#none');
		item.innerHTML = list_actions[i].label;
		if (list_actions[i].item)
			item.setAttribute('data-item', 'true');
		eval('item.onclick = function(e) { on_list_action(this, "'+cmd+'"); }');
		al.appendChild(item);
	}	
}

function set_list_filter(id, label) {
	var amenu = $(id);
	var al = $('filterList');
	var hasFilter = (label == 'Conexão');
	
	while (al.firstChild)
		al.removeChild(al.firstChild);
	
	if (hasFilter) {
		//filtrar por usuario
		var item = document.createElement('a');
		item.setAttribute('href', '#none');
		item.setAttribute('class','filterA');
		item.innerHTML = 'Filtrar por usuário';
		eval('item.onclick = function(e) {on_list_action(this, "filter_by_user");}');		
		al.appendChild(item);
		
		//filtrar por origem
		item = document.createElement('a');
		item.setAttribute('href', '#none');
		item.className='filterA';
		item.innerHTML = 'Filtrar por origem';
		eval('item.onclick = function(e) { on_list_action(this, "filter_by_local"); }');		
		al.appendChild(item);

		//filtrar por destino
		item = document.createElement('a');
		item.setAttribute('href', '#none');
		item.className='filterA';
		item.innerHTML = 'Filtrar por destino';
		eval('item.onclick = function(e) { on_list_action(this, "filter_by_remote"); }');		
		al.appendChild(item);

		//filtrar por servico
		item = document.createElement('a');
		item.setAttribute('href', '#none');
		item.className='filterA';
		item.innerHTML = 'Filtrar por serviço';
		eval('item.onclick = function(e) { on_list_action(this, "filter_by_service"); }');		
		al.appendChild(item);
	}
}

function enable_disable_list_filter(id, label, cmd) {
	var hasFilter = (label == 'Conexão');
	if (hasFilter) {
		var amenu = $(id);
		var al = document.getElementById("filterList");
		var filterA = al.getElementsByTagName('a');
		for (var i = 0; i < filterA.length; i++){
			if (cmd=="enable")
				filterA[i].className = 'filterA enable';
			else if (cmd == "disable")
				filterA[i].className='filterA disable';
		}
	}
}	

var cmd_str = new Array();
cmd_str["START"] = "Iniciando instância. Aguarde ...";
cmd_str["STOP"] = "Parando instância. Aguarde ...";
cmd_str["RESTART"] = "Reiniciando instância. Aguarde ..."; 
cmd_str["STATUS"] = "Verificando status da instância. Aguarde ..."; 

function on_list_action(el, cmd) {
	if (el.getAttribute('data-item') == 'true' && list_obj_id == '') {
		alert('Selecione um item da lista.');
		hideDropDown();
		return;
	}
	
	if (cmd == 'EDIT') 
		on_list_edit();
	if (cmd == 'UPDATE_LIC') 
		on_list_update_lic();
	else if (cmd == 'NEW')
		on_list_new();
	else if (cmd == 'DEL')
		on_list_del();
	else if (cmd == 'SHOW_DISABLED' || cmd == 'HIDE_DISABLED')
		on_list_chview(cmd);
	else if (cmd == 'NEW_ACCOUNT')
		on_list_new_account();
	else if (cmd == 'LIST_ACCOUNTS')
		on_list_accounts();
	else if (cmd == 'SUPPORT_INST')
		on_list_support("inst_seq");
	else if (cmd == 'LOST_MEDIA_REPORT')
		on_list_lost_medida_report(list_obj_id);
	else if (cmd == 'SUPPORT_ADM')
		on_list_support("usu_seq");
	else if (cmd == 'LOG_VIEW')
		on_list_logview("log");
	else if (cmd == 'HIST_VIEW')
		on_list_logview("log_history");
	else if (cmd == 'GET_NTP_INSTANCE')
		on_list_instance(450, 'user_id');
	else if (cmd == 'GET_WTM_INSTANCE')
		on_list_instance(670, 'user_id');
	else if (cmd == 'WTM_INSTANCE_INFO')
		on_list_instance(670, 'inst_id');
	else if (cmd == 'NTP_INSTANCE_INFO')
		on_list_instance(450, 'inst_id');
	else if (cmd == 'START' || cmd == 'STOP' || cmd == 'RESTART' || cmd == 'STATUS' || cmd == 'SHOW_DISABLED' || cmd == 'HIDE_DISABLED') {	
		document.getElementById('button_close').style.display = 'none';
		document.getElementById('alert').style.display = '';
		document.getElementById('alert_msg').innerHTML = cmd_str[cmd];
		//var myxhr = new XHRUpdater('../wsvc/instanceControl.wsvc?id='+escape(list_obj_id)+'&cmd='+cmd);
		var myxhr = new XHRUpdater('item_ctl.php?service='+service+'&cmd='+cmd+'&id='+escape(list_obj_id));
		myxhr.onUpdate = function(request) {
			var response = null;
			try {
				response = JSON.parse(request.responseText);
			} catch (e) {}
			if (response == null)
				response = { "error" : 'Invalid JSON: '+ request.responseText }
				
			document.getElementById('alert_msg').innerHTML = response.error;
			document.getElementById('button_close').style.display = '';
		}
		myxhr.start();
	}	
	
	hideDropDown();
}

function on_list_select(id) {
	list_obj_id = id;
}

function on_list_edit() {
	if (!list_obj_edit)
		return;	
	location.href = 'svc_config.php?service='+service+'&instance='+escape(list_obj_id);
}

function on_list_update_lic() {
	if (!list_obj_edit)
		return;
	location.href = 'svc_config.php?service='+service+'&instance='+escape(list_obj_id)+"&update_lic=true";
}

function on_list_del() {
	if (list_obj_id.indexOf(":") > 0) { // wtm admin master
		alert('Não é possível excluir um administrador principal.');
	} else if (confirm('Confirma a exclusão do item?')) {
		var myxhr = new XHRUpdater('item_ctl.php?service='+service+'&instance='+escape(instance)+'&cmd=DEL&id='+escape(list_obj_id));
		myxhr.onUpdate = function(request) {
			var response = JSON.parse(request.responseText);
			if (!response.status)
				alert(response.error);
		}
		myxhr.start();
	}
}

function on_list_new() {
	location.href ='svc_config.php?service='+service;
}

function on_list_new_account() {
	location.href ='svc_config.php?service=ADMIN'+'&id='+escape(list_obj_id)+'&return_service='+service;
}

function on_list_accounts() {
	window.open('accounts.phtml?inst_id='+list_obj_id, 'Pagina', 'STATUS=NO, TOOLBAR=NO, MENUBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=800, HEIGHT=500');
}

function on_list_instance(height, field) {
	window.open('instance_info.phtml?'+field+'='+list_obj_id, 'Pagina', 'STATUS=NO, TOOLBAR=NO, MENUBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=800, HEIGHT='+height);
}

function on_list_support(param) {
	window.open("login_support.php?inst_seq="+list_obj_id, '_blank');
}

function on_list_logview(page) {
	window.open("../wsvc/log.php?inst_seq="+list_obj_id+"&page="+page, '_blank');
}

function on_list_lost_medida_report(vds_seq) {
	window.open('lost_media_report.phtml?vds_seq='+vds_seq, '_blank');
}

function on_list_chview(cmd) {
	var myxhr = new XHRUpdater('item_ctl.php?service=INSTANCE&instance=INSTANCE&id=NONE&cmd='+cmd);
	myxhr.onUpdate = function(request) {
		var response = JSON.parse(request.responseText);
		if (!response.status)
			alert(response.error);
		window.location.reload();
	}
	myxhr.start();
}
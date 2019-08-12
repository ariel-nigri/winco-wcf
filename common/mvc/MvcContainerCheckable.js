var inputs;

function getInputsFrom(obj) {
	if (obj.children) {
		if (obj.children.length > 0 && obj.nodeName.toUpperCase() != 'SELECT') {
			for(n in obj.children) {
				if (typeof(obj.children[n]) == 'object') getInputsFrom(obj.children[n]);
			}
		}
		else {
			if (
				obj.nodeName.toUpperCase() == 'INPUT' ||
				obj.nodeName.toUpperCase() == 'TEXTAREA' ||
				obj.nodeName.toUpperCase() == 'SELECT' ||
				obj.nodeName.toUpperCase() == 'BUTTON'
			) inputs[inputs.length] = obj;
//			window.alert(obj.nodeName+' - '+obj.id);
		}
	}
}

function onOff(check) {
	inputs = new Array();
	var container = check.parentNode;
	if (container.nodeName.toUpperCase() == 'LEGEND') container = container.parentNode;
	getInputsFrom(container); //sai do check pro legend e dele pro fieldset

	var status = !check.checked;
	for(var n in inputs)
		if (inputs[n].name != check.name) {
			inputs[n].disabled = status;
		}
}
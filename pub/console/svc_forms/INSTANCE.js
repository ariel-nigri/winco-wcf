var active_status = '';

function startJs() {
	if (document.getElementById("inst_active")) {
		var obj = document.getElementById("inst_active");	
		obj.onclick = dummyShowAlert;
		showAlert(false);
	}
	
	active_status = document.getElementById("inst_active").checked;
}

function dummyShowAlert() {
	showAlert(document.getElementById("inst_active").checked != active_status);
}

function showAlert(show_option)
{
	if (document.getElementById("inst_active").checked)
		document.getElementById("label_advise").style.display = "none";
	else
		document.getElementById("label_advise").style.display = "";
		
	if (show_option) {
		document.getElementById("startstop").style.display = "";
		document.getElementById("label_startstop").style.display = "";
		document.getElementById("startstop").checked=true;
		if (document.getElementById("inst_active").checked)
			document.getElementById("label_startstop").innerHTML = "Iniciar instância imediatamente após ativá-la";
		else
			document.getElementById("label_startstop").innerHTML = "Parar instância imediatamente após desativá-la";
	} else {
		document.getElementById("startstop").checked=false;
		document.getElementById("startstop").style.display = "none";
		document.getElementById("label_startstop").style.display = "none";
	}
}
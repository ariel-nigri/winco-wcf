var active_status = '';

function startJs() {
	if (document.getElementById("inst_active")) {
		var obj = document.getElementById("inst_active");	
		obj.onclick = dummyShowAlert;
		showAlert(false);
		
		active_status = document.getElementById("inst_active").checked;
	}
	
	if (document.getElementById("type")) {
		var obj2 = document.getElementById("type");	
		obj2.onclick = checkType;
		
		if (document.getElementById("license").value != "")
			oldLicense = document.getElementById("license").value;
		
		checkType();
	}
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

var caps = new Array();
caps["St"] = 'WTMGC=N,WTMHIST=12,WTMAD=N,WTMAR=10';
caps["Pr"] = 'WTMGC=Y,WTMHIST=24,WTMAD=N,WTMAR=60';
caps["En"] = 'WTMGC=Y,WTMHIST=65,WTMAD=Y,WTMAR=1000'; 
caps["Fr"] = 'WTMGC=N,WTMHIST=6,WTMAD=N,WTMAR=0'; 

var oldLicense = '';

function checkType() {
	if (document.getElementById("type").value == 'Fr') { // free
		document.getElementById("nusers").value = "5";		
		document.getElementById("nusers").readOnly=true;
		document.getElementById("license").readOnly=true;
		document.getElementById("license").value = " - LICENÇA FREE - ";
	} else {
		document.getElementById("nusers").readOnly=false;
		document.getElementById("license").readOnly=false;
		if (document.getElementById("license").value == " - LICENÇA FREE - ")
			document.getElementById("license").value = oldLicense != "" ? oldLicense : "";
	}
	
	if (document.getElementById("type").value == 'CUSTOM') {
		document.getElementById("personalizado").readOnly=false;
		if (document.getElementById("personalizado").value == '')
			document.getElementById("personalizado").value = "WTMGC=,WTMHIST=,WTMAD=,WTMAR=";
	} else {
		document.getElementById("personalizado").readOnly=true;
		document.getElementById("personalizado").value = caps[document.getElementById("type").value];
	}
}
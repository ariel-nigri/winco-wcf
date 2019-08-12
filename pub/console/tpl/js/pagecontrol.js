
var nextButObj;
var prevButObj;
var finishLabel;
var nextLabel;
var saveFunction;

function registerButtons(nextButId, prevButId, finishLbl, saveFnc) {
	nextButObj = document.getElementById(nextButId);
	prevButObj = document.getElementById(prevButId);
	
	if (!nextButObj || !prevButObj || !finishLbl) {
		window.alert('O nome dos botões passados não estão corretos. Esta função será desabilitada');
		return;
	}
	
	finishLabel = finishLbl;
	nextLabel = nextButObj.value;

	saveFunction = saveFnc;
}

function changeButState(pagecontrol) {

	if (!nextButObj)
		return;

	var currTab = discoverCurrTab(pagecontrol);

	var obj = document.getElementById(pagecontrol+'_ul').getElementsByTagName('li');
	
	if (!obj)
		return;
		
	tabNum = obj.length;

	if (currTab == 0) {
		prevButObj.disabled = "disabled";
		nextButObj.value = nextLabel;
	}
		
	if (currTab > 0) {
		if (prevButObj.disabled)
			prevButObj.disabled = "";
		if (currTab == tabNum - 1) {
			nextLabel = nextButObj.value;
			nextButObj.value = finishLabel;
		}
		if (currTab < tabNum - 1) {
			nextButObj.value = nextLabel;
			prevButObj.disabled = "";
		}
	}
		
}

function discoverCurrTab(pagecontrol) {

	var sel = document.getElementById(pagecontrol);

	var obj = document.getElementById(pagecontrol+'_ul').getElementsByTagName('li');
	
	if (!obj || !sel)
		return;
		
	for (i=0; i < obj.length; i++) {
		if (obj[i].id == sel.value+'_tab')
			return i;
	}
	return -1;
}

function nextTab(pagecontrol) {
	var currTab = discoverCurrTab(pagecontrol);

	var obj = document.getElementById(pagecontrol+'_ul').getElementsByTagName('li');
	
	if (!obj)
		return;
		
	tabNum = obj.length;

	if (currTab + 1 == tabNum) {
		form1do_action(saveFunction);
		return;
	}

	if (currTab < tabNum) {
		currTab++;
		activateTab(pagecontrol, currTab);
	}
	
}

function previousTab(pagecontrol) {
	
	var currTab = discoverCurrTab(pagecontrol);

	var obj = document.getElementById(pagecontrol+'_ul').getElementsByTagName('li');
	
	if (!obj)
		return;
		
	tabNum = obj.length;

	if (currTab > 0) {
		currTab--;
		activateTab(pagecontrol, currTab);
	}
	
}


function activateTab(pagecontrol, tabId) {
	
	var obj = document.getElementById(pagecontrol+'_ul').getElementsByTagName('li');
	if (!obj)
		return;
	
	var tabName = obj[tabId].id;
	
	tabName = tabName.substr(0,tabName.length-4);
	
	changetab(pagecontrol, tabName);

}

function changetab(pagecontrol, mytab)
{
	var tab = document.getElementById(mytab + '_tab');
	var sel = document.getElementById(pagecontrol);
	if (sel && sel.value != '') {
		document.getElementById(sel.value).style.display = 'none';
		document.getElementById(sel.value + '_tab').className = '';
	}
	sel.value = mytab;
	tab.className = 'active';
	document.getElementById(mytab).style.display = '';
	
	changeButState(pagecontrol);
}
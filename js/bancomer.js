function openBancomerWindow(){
	var iWinState = 1;
	var objForm = null;

	if(document.bancomer_standard_checkout)
		objForm = document.bancomer_standard_checkout;
	else
		objForm = document.getElementById("bancomer_standard_checkout");

	if(objForm.windowstate)
	iWinState = objForm.windowstate.value;

	if (iWinState == "1") {
		//popup window
		var bancomerwin = window.open("","bancomer_window","height=450,width=650,menubar=0,resizable=1,scrollbars=1,status=1,titlebar=0,toolbar=0,left=100,top=50");

		if (bancomerwin)
			bancomerwin.focus();

		objForm.target = "bancomer_window";
	} else
		objForm.target = "";

	objForm.submit();
}
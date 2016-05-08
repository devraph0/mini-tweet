function menu_connection () {
	document.getElementById('select-connection').setAttribute("class", "active");
	document.getElementById('select-register').removeAttribute("class");
	document.getElementById('connection').style.display = "block";
	document.getElementById('register').style.display = "none";
}

function menu_register () {
	document.getElementById('select-register').setAttribute("class", "active");
	document.getElementById('select-connection').removeAttribute("class");
	document.getElementById('connection').style.display = "none";
	document.getElementById('register').style.display = "block";
}
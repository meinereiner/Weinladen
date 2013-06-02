function overlay() {
	el = document.getElementById("overlay");
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
}

function loginButtonOnsubmit() {
	var shaObj = new jsSHA(document.getElementById("passwort").value, "TEXT");
	document.getElementById("hash").value = shaObj.getHash("SHA-256", "HEX");
	document.getElementById("passwort").value = "";
}

function registerButtonOnsubmit() {
	var shaObj = new jsSHA(document.getElementById("registerPass").value, "TEXT");
	document.getElementById("hash").value = shaObj.getHash("SHA-256", "HEX");
	document.getElementById("registerPass").value = "";
}

function formUserOnFocus() {
	var el = document.getElementById("username");
	if (el.value == "Benutzername") {
		el.value = "";
		el.style.fontStyle = "normal";
	}	
}

function formPasswordOnFocus() {
	var el = document.getElementById("passwort");
	if (el.value == "Passwort") {
		el.value = "";
		el.type = "password";
		el.style.fontStyle = "normal";
	}
}

function formUserOnBlur() {
	var el = document.getElementById("username");
	if (el.value == "") {
		el.value = "Benutzername";
		el.style.fontStyle = "italic";
	}
}

function formPasswordOnBlur() {
	var el = document.getElementById("passwort");
	if (el.value == "") {
		el.value = "Passwort";
		el.type = "text";
		el.style.fontStyle = "italic";
	}
}

function changeLoginButton() {
	var pass = document.getElementById("passwort");
	var user = document.getElementById("username");
	var button = document.getElementById("loginButton");
	var condition = (pass.value != "Passwort" && user.value != "Benutzername" &&
					 pass.value != "" && user.value != "")
	button.disabled = condition ? false : true;
	button.style.opacity = condition ? 1 : 0.2;
}

function formEmailOnFocus() {
	var el = document.getElementById("email");
	el.style.color = "rgb(176, 0, 0)";
	if (el.value == "Email") {
		el.value = "";
		el.style.fontStyle = "normal";
	}	
	changeRegisterButton();
}

function formRegUserOnFocus() {
	var el = document.getElementById("registerUser");
	if (el.value == "Benutzername") {
		el.value = "";
		el.style.fontStyle = "normal";
	}	
	changeRegisterButton();
}

function formRegPasswordOnFocus() {
	var el = document.getElementById("registerPass");
	if (el.value == "Passwort") {
		el.value = "";
		el.type = "password";
		el.style.fontStyle = "normal";
	}
	changeRegisterButton();
}

function formEmailOnBlur() {
	var el = document.getElementById("email");
	if (el.value == "") {
		el.value = "Email";
		el.style.fontStyle = "italic";
		el.style.color = "rgb(176, 0, 0)";
	}
	if (!el.value.isEmail() && el.value != "Email") {
		el.style.color = "rgb(255, 0, 0)";
	}
	changeRegisterButton();
}

function formRegUserOnBlur() {
	var el = document.getElementById("registerUser");
	if (el.value == "") {
		el.value = "Benutzername";
		el.style.fontStyle = "italic";
	}	
	changeRegisterButton();
}

function formRegPasswordOnBlur() {
	var el = document.getElementById("registerPass");
	if (el.value == "") {
		el.value = "Passwort";
		el.type = "text";
		el.style.fontStyle = "italic";
	}
	changeRegisterButton();
}

function changeRegisterButton() {
	var pass = document.getElementById("registerPass");
	var user = document.getElementById("registerUser");
	var email = document.getElementById("email");
	var button = document.getElementById("registerButton");
	var condition = (pass.value != "Passwort" && pass.value != "" && user.value != "Benutzername" 
		&& user.value != "" && email.value.isEmail())
	button.disabled = condition ? false : true;
	button.style.opacity = condition ? 1 : 0.2;
}

String.prototype.isEmail = function () {
  var validmailregex = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.([a-z][a-z]+)|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i
  return validmailregex.test(this);
}

function periodicUpdate(){
	jqGetMessages();
	setInterval("jqGetMessages()", 10000);
}

function jqGetMessages(){
	$.ajax({
		url: "common/getMessages.php",
		success: function( data ) {
			$( "#right" ).html( data );
		}
	});
}

function postMessage(){
	$.ajax({
		url: "common/postMessage.php",
		data: {
			nachricht: document.getElementById("nachricht").value
		},
		success: function( data ) {
			document.getElementById("nachricht").value = "";
		}
	});
}
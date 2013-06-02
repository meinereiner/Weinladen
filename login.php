<?php
include "./auth/login_header.php";
include "./common/head.html";

echo'
<div id="divLogin">
	<h3>Login</h3>
	<form action="login.php" method="post" onsubmit="loginButtonOnsubmit()">
		<input type="text" id="username" name="username" value="Benutzername" onblur="formUserOnBlur()" onfocus="formUserOnFocus()" onkeyup="changeLoginButton()" /><br />
		<input type="text" id="passwort" name="passwort" value="Passwort" onblur="formPasswordOnBlur()" onfocus="formPasswordOnFocus()"  onkeyup="changeLoginButton()" /><br />
		<input id="loginButton" type="submit" value="Anmelden" disabled />
		<input id="hash" name="hash" type="hidden" value="" / >
	</form>
</div>';
  
include "./common/navigationFooter.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	echo'
<script type="text/javascript">
alert("Benutzername oder Passwort unbekannt!");
</script>
';
}
?>
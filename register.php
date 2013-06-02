<?php
include "./auth/register_header.php";
include "./common/head.html";

echo'
<div id="divLogin">
	<h3>Registrieren</h3>
	<form action="register.php" method="post"  onsubmit="registerButtonOnsubmit()">
		<input type="text" id="email" name="email" value="Email" onblur="formEmailOnBlur()" onfocus="formEmailOnFocus()" onkeyup="changeRegisterButton()"/><br />
		<input type="text" id="registerUser" name="user" value="Benutzername" onblur="formRegUserOnBlur()" onfocus="formRegUserOnFocus()" onkeyup="changeRegisterButton()"/><br />
		<input type="text" id="registerPass" name="pass"value="Passwort" onblur="formRegPasswordOnBlur()" onfocus="formRegPasswordOnFocus()"  onkeyup="changeRegisterButton()" /><br />
		<input id="registerButton" type="submit" value="Registrieren" disabled/>
		<input id="hash" name="hash" type="hidden" value="" / >
	</form>
</div>';
  
include "./common/navigationFooter.php";
?>
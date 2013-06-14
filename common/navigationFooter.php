<?php
echo'
	  </div>
	  </div>
	  
	  <!-- Hier endet der Seiteninhalt. -->
	  
	  <div id="left" class="column">
	  
	  <!-- Hier beginnt die Navigationsleiste. -->
	  
	  <ul>
	  ';
if (isset($_SESSION['angemeldet']) && $_SESSION['angemeldet']) {
	echo '<li id="userGreet">Hallo '.$_SESSION['username'].'!</li>';
}
	  
echo '    <li><a href="home.php">Home</a></li>';
		
		
if (!isset($_SESSION['angemeldet']) || !$_SESSION['angemeldet'])
{
	echo '<li><a href="login.php">Login</a></li>
	<li><a href="register.php">Registrieren</a></li> ';
}
else
{
	echo '<li><a href="auth/logout.php">Logout</a></li>
	<li><a href="warenkorb.php">Warenkorb</a></li> ';
}
echo '
		<!-- Zeigt alle Weine in der Datenbank an -->
	    <li><a href="sortiment.php">Sortiment</a></li> 
		
		<!-- Suchformular. Falsche Einträge werden mit Javascript rot markiert -->
		<li><a href="suche.php">Suche</a></li>
';
if (isset($_SESSION['angemeldet']) && $_SESSION['angemeldet'])
{
	echo '
		<!-- Newsletter Anmeldung wenn nicht Admin-->
		<li><a href="newsletter.php">Newsletter</a></li>
		';
}

if (isset($_SESSION['administrator']) && $_SESSION['administrator'])
{
	echo '<li><a href="admin.php">Admin</a></li>';
}
echo '
	  </ul>
	  </div>
	  
	  <div id="right" class="column">
	  
	  <!-- Hier beginnt die Nachrichtenbox. Zeigt die letzten 10 Nachrichten, neueste Fett -->
	  <div id="divNachrichtbox">
		<h3 id="nachrichtenueberschrift">Nachrichten (lade...)</h3>
		<img id="loadGif" src="./images/loading.gif" />
	  </ div>
		<!-- Hier endet die Nachrichtenbox. -->
		
	  </div>
	</div>
  <div id="footer">
	<ul id="fussliste">
	  <li><a href="#" onclick="overlay()">Impressum</a></li>
	</ul>
  </div>
  
  <!-- Overlay von Impressum, wird sichtbar/unsichtbar je nachdem. -->
  
 <div id="overlay">
     <div>
          <p>Hier ist die Adresse</p>
		  <a href="#" onclick="overlay()">Zur&uuml;ck</a>
     </div>
</div>

</body>
</html>';
?>
<?php
include "./auth/session.php";
include "./common/head.html";

echo'
		  <p>
			<h3>Die k&ouml;rperreichsten Weine. Die rundesten Bouquets.</h3>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vel risus odio. Nunc sit amet mi libero, vitae pretium velit. Praesent sed nunc ante, a pellentesque justo. Nullam eu ullamcorper ante. Aenean congue, tellus nec sagittis accumsan, augue odio elementum nulla, id tincidunt augue lacus et enim. Aenean lacinia pharetra tellus, vel blandit mauris eleifend vel. Mauris at ligula arcu. Cras aliquam, nibh eu congue hendrerit, orci ipsum rutrum velit, ut fermentum massa augue ut ante. Pellentesque mi felis, tincidunt a tristique et, sollicitudin sit amet urna. Vestibulum et viverra est. Nulla sodales, orci cursus sodales ornare, nisi neque ultricies augue, eu imperdiet arcu ante quis velit. 
		  </p>
		  
		  <div id="postMessage">
	<h3>Nachricht schreiben</h3>
	<form>
		<input type="text" id="nachricht" name="message"/> <br />
		<input type="reset" value="Anschicken" onclick="postMessage()" />
	</form>
</div>';
		  
include "./common/navigationFooter.php";
?>
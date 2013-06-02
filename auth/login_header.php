<?php
include "./classes/mysql.class.php";
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      session_start();
	  
      $username = $_POST['username'];
      $passwort = $_POST['hash'];
	  
	  $sql = new mysql();
	  $sql->login("Simon","qwertz");
	  $userStatus = $sql->login($username, $passwort);
	  $sql->close_connect();

      $hostname = $_SERVER['HTTP_HOST'];
      $path = dirname($_SERVER['PHP_SELF']);

      // Benutzername und Passwort werden überprüft
	  if ($userStatus == "ADMIN") {
       $_SESSION['administrator'] = true;
       $_SESSION['angemeldet'] = true;
	   }
      if ($userStatus == "TRUE" || $userStatus == "ADMIN") {
       $_SESSION['angemeldet'] = true;
	   $_SESSION['username'] = $username;
       // Weiterleitung zur geschützten Startseite
       if ($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1') {
        if (php_sapi_name() == 'cgi') {
         header('Status: 303 See Other');
         }
        else {
         header('HTTP/1.1 303 See Other');
         }
        }
       header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/home.php');
       exit;
       }
	  }
?>
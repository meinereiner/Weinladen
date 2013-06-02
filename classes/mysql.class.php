<?php
class mysql
{
    //DB Daten eingeben
    private $host      = 'localhost'; 
    private $user      = 'root';
    private $passwort  = ''; 
    private $dbname    = 'weinladen';
    private $conn_id   = null; 
    private $injection ='';
 
	//Felder die nach dem login benutzt werden k�nnen
	private $name;
	private $admin = "FALSE";
	private $id = "GAST";
	
	//Getter
	//Name abfragen
	public function getname()
	{
		return $this->name;
	}
	//ID abfragen
	public function getid()
	{
		return $this->id;
	}
	//Adminstatus abfragen
	public function getadminstatus()
	{
		return $this->admin;
	}
	
	public function getlands()
	{
		$landarray;
		$newlandarray;
		$query = "SELECT land FROM wein";
		$result = $this->sendtodb2($query);
		while($row = mysql_fetch_assoc($result))
		{
			$landarray[] = $row["land"];
		}
		//doppelte eintr�ge entfernen
		$landarray = array_unique($landarray);
		//Index korrigieren durch umkopieren
		foreach ($landarray as $arr) 
		{
			$newlandarray[] = $arr;
		}	 
		
		return $newlandarray;
	}
	
	public function gettypes()
	{
		$typesarray;
		$newtypesarray;
		$query = "SELECT typ FROM wein";
		$result = $this->sendtodb2($query);
		while($row = mysql_fetch_assoc($result))
		{
			$typesarray[] = $row["typ"];
		}
		//doppelte eintr�ge entfernen
		$typesarray = array_unique($typesarray);
		//Index korrigieren durch umkopieren
		foreach ($typesarray as $arr) 
		{
			$newtypesarray[] = $arr;
		}	 
		
		return $newtypesarray;
	}
	
	
    //Standardkonstruktor
    public function mysql()
    {
		//Session zu db Aufbauen
		$this->conn_id = mysql_connect($this->host,$this->user,$this->passwort);
		//db ausw�hlen
		mysql_select_db($this->dbname,$this->conn_id);
		
		//Abfrage ob Verbindund ok	
		if($this->conn_id === false)
		{
			$message = mysql_error();
			echo "<p>Verbindungsfehler : &message </p>";
		}     
	}
		
    //query an db senden f�r Eintr�ge
    private function sendtodb($query)
    {
		//Datenbankanfrage senden
		$this->injection = mysql_query($query);
		//Fehler abfangen
        if($this->injection === false)
        {
            $message = mysql_error();
            echo "<p>Queryfehler : $message </p>";
			echo "<p>Query : $query </p>";
			return false;
        }
        else
        {
			return true;
        }
    }
	
	//query an db senden f�r Abfragen
    private function sendtodb2($query)
    {
		//Datenbankanfrage senden
		$this->injection = mysql_query($query);
		//Fehler abfangen
        if($this->injection === false)
        {
            $message = mysql_error();
            echo "<p>Queryfehler : $message </p>";
			echo "<p>Query : $query </p>";
			return false;
        }
        else
        {
			return $this->injection;
        }
    }

    //Benutzer hinzuf�gen
    public function adduser($benutzername,$admin, $e_mail, $newsletter, $passwort)
    {
        //Abfrage ob user schon vorhanden
		$query = "SELECT * FROM benutzer WHERE benutzername='$benutzername'";
		$result = $this->sendtodb2($query);
		if(mysql_num_rows($result)==0)
		{
			//Benutzer anlegen
			//query erzeugen
			$query  = "INSERT INTO benutzer (benutzername , admin , e_mail , newsletter , passwort) "; 
			$query .= "values ('$benutzername', $admin, '$e_mail', $newsletter, '$passwort')";	
		
			//Datenbankanfrage senden
			return $this->sendtodb($query);
		}
		else
		{
			return "EXIST";
		}

    }

	public function usernameExists($benutzername)
	{
	    //Abfrage ob user schon vorhanden
		$query = "SELECT * FROM benutzer WHERE benutzername='$benutzername'";
		$result = $this->sendtodb2($query);
		if(mysql_num_rows($result)==0)
		{
			return FALSE;
		}
		return TRUE;	
	}
	
		public function emailExists($e_mail)
	{
	    //Abfrage ob user schon vorhanden
		$query = "SELECT * FROM benutzer WHERE e_mail='$e_mail'";
		$result = $this->sendtodb2($query);
		if(mysql_num_rows($result)==0)
		{
			return FALSE;
		}
		return TRUE;	
	}
	
	
	
    //Nachricht hinzuf�gen max. 1000 Zeichen
    public function addnote($nachricht)
    {
		$timestamp = time(); //aktuelles Datum ermitteln
		$datum = date("Y-m-d G:i:s",$timestamp);	//Datum ins mysql-date format konvertieren
		//query erzeugen
		$query = "INSERT INTO nachrichten (nachricht, datum) ";
		$query .= "values ('$nachricht', '$datum')";

		//Datenbankanfrage senden
		return $this->sendtodb($query);
    }
	
	//Wein hinzuf�gen
	public function addwine($name, $jahrgang, $typ, $anbaugebiet, $land, $beschreibung, $preis)
	{
		$query = "INSERT INTO wein (name, jahrgang, typ, anbaugebiet, land, beschreibung, preis) ";
		$query .= "values ('$name', '$jahrgang', $typ, '$anbaugebiet', '$land', '$beschreibung', '$preis')";
		//Datenbankanfrage senden
		return $this->sendtodb($query);
    }
	
	//Benutzerlogin �berpr�fen	R�ckgabeparameter 	TRUE, ADMIN oder Fehlermeldung als String
	public function login($name, $passwort)
	{
		$query = "SELECT idbenutzer FROM benutzer WHERE benutzername='$name' AND passwort='$passwort'";
		$result = $this->sendtodb2($query);
		
		if(mysql_num_rows($result)==1)
		{
			$this->id = mysql_result($result, 0);
			//Benutzername speichern
			$this->name = $name;
			
			//Adminstatus abfragen
			$query = "SELECT * FROM benutzer WHERE idbenutzer='$this->id' AND admin=1";
			$result = $this->sendtodb2($query);
			if(mysql_num_rows($result)==1)
			{
				$this->admin = "TRUE";
				return "ADMIN";
			}
			else	
				return "TRUE";
		}
		else
		{
			return "FALSE";
		}
		
	}
	
	public function winetable()
	{
		$query = "SELECT * FROM wein";
		$result = $this->sendtodb2($query);
		//Tabelle erzeugen
		echo "<table border='1'>";
		//Spaltennamen erzeugen
		echo "<tr>";
		echo "<td>ID</td><td>Name</td><td>Jahrgang</td><td>Typ</td>";
		echo "<td>Anbaugebiet</td><td>Land</td><td>Preis</td><td>Beschreibung</td>";
		echo "</tr>";
		
		while($row = mysql_fetch_assoc($result))
		{
			echo "<tr>";
			echo "	<td>" . $row["idwein"] . "</td>";		
			echo "	<td>" . $row["name"] . "</td>";		
			echo "	<td>" . $row["jahrgang"] . "</td>";
			echo "	<td>" . $row["typ"] . "</td>";
			echo "	<td>" . $row["anbaugebiet"] . "</td>";
			echo "	<td>" . $row["land"] . "</td>";
			echo "	<td>" . number_format($row["preis"], 2, ',', '') . "�</td>";
			echo "	<td>" . $row["beschreibung"] . "</td>";
		}
		echo "</table>";
	}
	
	public function getwinebytype($type)
	{
		$query = "SELECT * FROM wein WHERE typ = '$type'";
		$result = $this->sendtodb2($query);
		//Tabelle erzeugen
		echo "<table border='1'>";
		//Spaltennamen erzeugen
		echo "<tr>";
		echo "<td>ID</td><td>Name</td><td>Jahrgang</td><td>Typ</td>";
		echo "<td>Anbaugebiet</td><td>Land</td><td>Preis</td><td>Beschreibung</td>";
		echo "</tr>";
		
		while($row = mysql_fetch_assoc($result))
		{
			echo "<tr>";
			echo "	<td>" . $row["idwein"] . "</td>";		
			echo "	<td>" . $row["name"] . "</td>";		
			echo "	<td>" . $row["jahrgang"] . "</td>";
			echo "	<td>" . $row["typ"] . "</td>";
			echo "	<td>" . $row["anbaugebiet"] . "</td>";
			echo "	<td>" . $row["land"] . "</td>";
			echo "	<td>" . number_format($row["preis"], 2, ',', '') . "�</td>";
			echo "	<td>" . $row["beschreibung"] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	
	public function getwinebyland($land)
	{
		$query = "SELECT * FROM wein WHERE land = '$land'";
		$result = $this->sendtodb2($query);
		//Tabelle erzeugen
		echo "<table border='1'>";
		//Spaltennamen erzeugen
		echo "<tr>";
		echo "<td>ID</td><td>Name</td><td>Jahrgang</td><td>Typ</td>";
		echo "<td>Anbaugebiet</td><td>Land</td><td>Preis</td><td>Beschreibung</td>";
		echo "</tr>";
		
		while($row = mysql_fetch_assoc($result))
		{
			echo "<tr>";
			echo "	<td>" . $row["idwein"] . "</td>";		
			echo "	<td>" . $row["name"] . "</td>";		
			echo "	<td>" . $row["jahrgang"] . "</td>";
			echo "	<td>" . $row["typ"] . "</td>";
			echo "	<td>" . $row["anbaugebiet"] . "</td>";
			echo "	<td>" . $row["land"] . "</td>";
			echo "	<td>" . number_format($row["preis"], 2, ',', '') . "�</td>";
			echo "	<td>" . $row["beschreibung"] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	
	public function csv()
	{
		$query = "SELECT * FROM wein";
		$result = $this->sendtodb2($query);
		echo "Nr.;Name;Jahrgang;Typ;Anbaugebiet;Land;Preis;Beschreibung\n";
		$i=1;
		$count = mysql_num_rows($result);
		
		while($row = mysql_fetch_assoc($result))
		{
			$i++;					
			echo $row["idwein"] . ";";		
			echo $row["name"] . ";";		
			echo $row["jahrgang"] . ";";
			echo $row["typ"] . ";";
			echo $row["anbaugebiet"] . ";";
			echo $row["land"] . ";";
			echo number_format($row["preis"], 2, ',', '') . "�;";
			echo $row["beschreibung"];
			if($i<=$count)
				echo "\n";
		}
		
	}
	
	public function winelist()
	{
		$query = "SELECT * FROM wein";
		$result = $this->sendtodb2($query);
		
		echo " <form> 
			";
		
		while($row = mysql_fetch_assoc($result))
		{
			
			echo "<div class='divWeineintrag'>\n";
			echo "	<h3>" . $row["name"] . "</h3>\n";
			echo "	<img src='./images/weinbild.jpg' />\n";
			echo "	<ul class='ulWeineigenschaften'>\n";
			
			echo "		<li>" . $row["name"] . "</li>\n";		
			echo "		<li>" . $row["jahrgang"] . "</li>\n";
			echo "		<li>" . $row["typ"] . "</li>\n";
			echo "		<li>" . $row["anbaugebiet"] . "</li>\n";
			echo "		<li>" . $row["land"] . "</li>\n";
			echo "		<li>" . number_format($row["preis"], 2, ',', '') . "�</li>\n";
			
			if(isset($_SESSION['angemeldet']) && $_SESSION['angemeldet'] == true) 
				echo ' <li> <input type="checkbox" class="WarenkorbCheckbox" name="' . $row["name"] . '" value="Hinzuf�gen"> In Warenkorb </li>';
			echo "	<li>" . $row["beschreibung"] . "</li>\n";
			
			echo "	</ul>\n";
			echo "</div>\n";
		}
		echo "</form>";
		echo ' <input id="warenkorbButton" type="submit" value="Hinzuf�gen" />';
	}
	
	public function winelistbyname($namearray)
	{
		for($i=0; $i < count($namearray); $i++)
		{
			$query = "SELECT * FROM wein WHERE name = '$namearray[$i]'";
			$result = $this->sendtodb2($query);
			$row = mysql_fetch_assoc($result);
					
			echo "<div class='divWeineintrag'>\n";
			echo "	<h3>" . $row["name"] . "</h3>\n";
			echo "	<img src='./images/weinbild.jpg' />\n";
			echo "	<ul class='ulWeineigenschaften'>\n";
			
			echo "		<li>" . $row["name"] . "</li>\n";		
			echo "		<li>" . $row["jahrgang"] . "</li>\n";
			echo "		<li>" . $row["typ"] . "</li>\n";
			echo "		<li>" . $row["anbaugebiet"] . "</li>\n";
			echo "		<li>" . $row["land"] . "</li>\n";
			echo "		<li>" . number_format($row["preis"], 2, ',', '') . "�</li>\n";
			echo "		<li>" . $row["beschreibung"] . "</li>\n";
			
			echo "	</ul>\n";
			echo "</div>\n";
		}
	}
	
	public function newstopten()
	{
		$query = "SELECT * FROM `nachrichten` ORDER BY datum DESC LIMIT 0 , 10";
		$result = $this->sendtodb2($query);
		
		echo "<div id='divNachrichtbox'>\n";
		echo "	<h3 id='nachrichtenueberschrift'>Nachrichten</h3>\n";
		echo "	<ul id='ulNachrichten'>\n";
		while($row = mysql_fetch_assoc($result))
		{
			echo "		<li>" . $row["nachricht"] . "</li>\n";
		}
		echo "	</ul>\n";
		echo "</div>\n";
	}
	
	
    //Verbindung zur db trennen
    public function close_connect()
    {
        mysql_close($this->conn_id);
    } 
}
?>

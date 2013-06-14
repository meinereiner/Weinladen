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
 
	//Felder die nach dem login benutzt werden können
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
	
	//Newsletterstatus abfragen
	public function getnewsletterstatus()
	{
		$query = "SELECT newsletter FROM benutzer WHERE idbenutzer = " . $this->id;
		$result = $this->sendtodb2($query);
		$row = mysql_fetch_assoc($result);
		if($row["newsletter"] == 1)
			return true;
		else
			return false;
	}
	
	//Tabelle mit allen Newsletterabonnenten ausgeben
	public function allnewsuser()
	{
		$query = "SELECT e_mail FROM benutzer WHERE newsletter = 1";
		$result = $this->sendtodb2($query);
		
		//Tabelle erzeugen
		echo "<table border='1'>\n";
		echo "<tr>\n";
		echo "<td>e-mail Adressen der Abonnenten</td>\n";
		echo "</tr>\n";
		
		while($row = mysql_fetch_assoc($result))
		{
			echo "<tr>\n";
			echo "<td>" . $row["e_mail"] . "</td>\n";
			echo "</tr>\n";			
		}
		
		echo "</table>";
	}
	
	//Newsletterstatus invertieren
	public function invertnewsletter()
	{
		$query = "SELECT newsletter FROM benutzer WHERE idbenutzer = " . $this->id;
		$result = $this->sendtodb2($query);
		$row = mysql_fetch_assoc($result);
		if($row["newsletter"] == 1)
		{
			$query = "UPDATE benutzer SET newsletter = 'FALSE' WHERE idbenutzer = " . $this->id;
		}
		else
		{
			$query = "UPDATE benutzer SET newsletter = 1 WHERE idbenutzer = " . $this->id;
		}
		
		$this->sendtodb($query);
			
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
		//doppelte einträge entfernen
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
		//doppelte einträge entfernen
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
		//db auswählen
		mysql_select_db($this->dbname,$this->conn_id);
		
		$this->sendtodb("SET NAMES 'utf8'");
		
		//Abfrage ob Verbindund ok	
		if($this->conn_id === false)
		{
			$message = mysql_error();
			echo "<p>Verbindungsfehler : &message </p>";
		}     
	}
		
    //query an db senden für Einträge
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
	
	//query an db senden für Abfragen
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

    //Benutzer hinzufügen
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
	
	
	
    //Nachricht hinzufügen max. 1000 Zeichen
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
	
	//Wein hinzufügen
	public function addwine($name, $jahrgang, $typ, $anbaugebiet, $land, $beschreibung, $preis)
	{
		$query = "INSERT INTO wein (name, jahrgang, typ, anbaugebiet, land, beschreibung, preis) ";
		$query .= "values ('$name', '$jahrgang', $typ, '$anbaugebiet', '$land', '$beschreibung', '$preis')";
		//Datenbankanfrage senden
		return $this->sendtodb($query);
    }
	
	//Benutzerlogin überprüfen	Rückgabeparameter 	TRUE, ADMIN oder Fehlermeldung als String
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
			echo "	<td>" . number_format($row["preis"], 2, ',', '') . "€</td>";
			echo "	<td>" . $row["beschreibung"] . "</td>";
			echo "</tr>";
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
			echo "	<td>" . number_format($row["preis"], 2, ',', '') . "€</td>";
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
			echo "	<td>" . number_format($row["preis"], 2, ',', '') . "€</td>";
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
			echo number_format($row["preis"], 2, ',', '') . "€;";
			echo $row["beschreibung"];
			if($i<=$count)
				echo "\n";
		}
		
	}
	
	public function winelist()
	{
		$query = "SELECT * FROM wein";
		$result = $this->sendtodb2($query);
		echo '<form action="warenkorb.php" method="post">';  
		
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
			echo "		<li>" . number_format($row["preis"], 2, ',', '') . "€</li>\n";
						
			if(isset($_SESSION['angemeldet']) && $_SESSION['angemeldet'] == true) 
				echo ' <li> <input type="checkbox" class="WarenkorbCheckbox" value="' . $row["name"] . '" name="check_list[]"> In Warenkorb </li>'; 
			echo "  <li>" . $row["beschreibung"] . "</li>\n"; 
			
			echo "	</ul>\n";
			echo "</div>\n";
		}
		echo '<input id="warenkorbButton" type="submit" value="Hinzufügen" />'; 
		echo "</form>";
	}
	
	public function winesorted($type = "", $land = "", $price = "")
	{
		$and = FALSE;
		$query = "SELECT * FROM wein ";
		if($type!="")
		{
			$query .= "WHERE typ = '$type' "; 
			$and = TRUE;
		}
		if($land!="")
		{
			if($and)
			{
				$query .= "AND land = '$land' ";
			}
			else
			{
				$query .= "WHERE land = '$land' ";
			}			
			$and = TRUE;
		}
		if($price!="")
		{
			if($and)
			{
				$query .= "AND preis < $price ";
			}
			else
			{		
				$query .= "WHERE preis < $price "; 
			}
		}		
		
		
		$result = $this->sendtodb2($query);
		echo "<form>"; 
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
			echo "		<li>" . number_format($row["preis"], 2, ',', '') . "€</li>\n";
			echo "		<li>" . $row["beschreibung"] . "</li>\n";
			
			if(isset($_SESSION['angemeldet']) && $_SESSION['angemeldet'] == true) 
				echo ' <li> <input type="checkbox" class="WarenkorbCheckbox" name="' . $row["name"] . '" value="Hinzufügen"> In Warenkorb </li>'; 
			echo "  <li>" . $row["beschreibung"] . "</li>\n"; 
			echo "	</ul>\n";
			echo "</div>\n";
		};
		if(isset($_SESSION['angemeldet']) && $_SESSION['angemeldet'] == true) 
     		echo ' <input id="warenkorbButton" type="submit" value="Hinzufügen"/>';
    	echo "</form>";       	
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
			echo "		<li>" . number_format($row["preis"], 2, ',', '') . "€</li>\n";
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
	
	public function createorder($username, $winearray) 
	{
		//Datum erstellen
		$timestamp = time(); //aktuelles Datum ermitteln
		$datum = date("Y-m-d G:i:s",$timestamp);	//Datum ins mysql-date format konvertieren
		
		//Benutzerid speichern
		$query = "SELECT idbenutzer FROM benutzer WHERE benutzername='$username'";
		$result = $this->sendtodb2($query);
		$id = mysql_result($result, 0);
		
		//query erzeugen
		$query = "INSERT INTO bestellung (benutzer_idbenutzer, datum) ";
		$query .= "values ('$id', '$datum')";

		//Datenbankanfrage senden
		$result = $this->sendtodb2($query);
		//id der Bestellung speichern
		$idbestellung = mysql_insert_id();
		
		//Alle Weine aus der db auslesen
		//query erzeugen
		$query = "SELECT name, idwein FROM wein";
		$result = $this->sendtodb2($query);
		//Array mit [name] und id speichern
		while($row = mysql_fetch_assoc($result))
		{
			$allwinearray[$row["name"]] = $row["idwein"];
		}
		
		
		//Weine der Bestellung speichern
		for($i = 0;$i < count($winearray);$i ++)
		{
			//Weinid speichern
			$idwein = $allwinearray[$winearray[$i]];
			$query = "INSERT INTO artikel (wein_idwein, bestellung_idbestellung) ";
			$query .= "VALUES ($idwein, $idbestellung); ";
			$this->sendtodb($query);
		}
			
	
	}
	
	//Übersicht der Bestellungen eines Kunden
	public function getorder()
	{
		
		//query erzeugen
		$query = "SELECT * FROM bestellung WHERE benutzer_idbenutzer = $this->id";
		//Datenbankanfrage senden
		$result = $this->sendtodb2($query);		
		
		while($row = mysql_fetch_assoc($result))
		{
			$sumprice = 0;
			$count = 0;
			//Tabelle erzeugen
			echo "<table border='1'>";
			//Überschrift erzeugen
			echo "<tr>\n";
			echo "<td>Bestellnummer: " . $row["idbestellung"] . "</td><td>Datum : " . $row["datum"] . "</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Weinname</td><td>Preis</td>";
			echo "</tr>\n";
			//Weine abfragen
			$query = "SELECT wein_idwein FROM artikel WHERE bestellung_idbestellung = " . $row["idbestellung"];
			//Datenbankanfrage senden
			$result2 = $this->sendtodb2($query);	
			while($row2 = mysql_fetch_assoc($result2))
			{
				$count++;
				$query = "SELECT name, preis FROM wein WHERE idwein = " . $row2["wein_idwein"];
				//Datenbankanfrage senden
				$result3 = $this->sendtodb2($query);	
				$row3 = mysql_fetch_assoc($result3);
				echo "<tr>\n";
				echo "<td>" . $row3["name"] . "</td><td>" . number_format($row3["preis"], 2, ',', '') . "€</td>\n";
				echo "</tr>\n";
				//Preis speichern
				$sumprice += $row3["preis"];
			}
			echo "<td>" . $count . " Artikel</td><td>Gesamtpreis: " . number_format($sumprice, 2, ',', '') . "€</td>\n"; 		
			echo "</tr>\n";
			echo "</table>\n";
			echo "<br>\n";
		}
		
	
	}
	 
	//Übersicht der Bestellungen aller Kunden
	public function orderoverview()
	{
		//Alle Namen aus der db auslesen
		//query erzeugen
		$query = "SELECT benutzername, idbenutzer FROM benutzer";
		$result = $this->sendtodb2($query);
		//Array mit [id] und name speichern
		while($row = mysql_fetch_assoc($result))
		{
			$alluserarray[$row["idbenutzer"]] = $row["benutzername"];
		}
				
		//query erzeugen
		$query = "SELECT * FROM bestellung";
		//Datenbankanfrage senden
		$result = $this->sendtodb2($query);		
		
		while($row = mysql_fetch_assoc($result))
		{
			$sumprice = 0;
			$count = 0;
			$username = $alluserarray[$row["benutzer_idbenutzer"]];
			
			//Tabelle erzeugen
			echo "<table border='1' width = '450'>";
			//Überschrift erzeugen
			echo "<tr>\n";
			echo "<td>Benutzername:</td><td>" . $username . "</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Bestellnummer: " . $row["idbestellung"] . "</td><td>Datum : " . $row["datum"] . "</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Weinname</td><td>Preis</td>";
			echo "</tr>\n";
			//Weine abfragen
			$query = "SELECT wein_idwein FROM artikel WHERE bestellung_idbestellung = " . $row["idbestellung"];
			//Datenbankanfrage senden
			$result2 = $this->sendtodb2($query);	
			while($row2 = mysql_fetch_assoc($result2))
			{
				$count++;
				$query = "SELECT name, preis FROM wein WHERE idwein = " . $row2["wein_idwein"];
				//Datenbankanfrage senden
				$result3 = $this->sendtodb2($query);	
				$row3 = mysql_fetch_assoc($result3);
				echo "<tr>\n";
				echo "<td>" . $row3["name"] . "</td><td>" . number_format($row3["preis"], 2, ',', '') . "€</td>\n";
				echo "</tr>\n";
				//Preis speichern
				$sumprice += $row3["preis"];
			}
			echo "<td>" . $count . " Artikel</td><td>Gesamtpreis: " . number_format($sumprice, 2, ',', '') . "€</td>\n"; 		
			echo "</tr>\n";
			echo "</table>\n";
			echo "<br>\n";
		}
		
	
	}
	
    //Verbindung zur db trennen
    public function close_connect()
    {
        mysql_close($this->conn_id);
    } 
}

?>
